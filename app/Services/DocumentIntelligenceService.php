<?php

namespace App\Services;

use ZipArchive;
use App\Models\ProjectModel;
use App\Models\ProjectFileModel;
use App\Models\ActivityLogModel;

class DocumentIntelligenceService
{
    /**
     * Inspect and list contents of a ZIP or Archive file without extracting to disk
     */
    public function inspectZipArchive(string $filePath): array
    {
        $realPath = FCPATH . ltrim($filePath, '/\\');
        if (!file_exists($realPath)) {
            return [
                'success' => false,
                'message' => 'Archive file not found on disk.'
            ];
        }

        $zip = new ZipArchive();
        if ($zip->open($realPath) !== true) {
            return [
                'success' => false,
                'message' => 'Could not open ZIP archive. File may be corrupted or encrypted.'
            ];
        }

        $entries = [];
        $totalSize = 0;
        $fileCount = 0;
        $folderCount = 0;

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $stat = $zip->statIndex($i);
            if (!$stat) continue;

            $name = $stat['name'];
            $isDir = substr($name, -1) === '/';
            $size = (int)($stat['size'] ?? 0);
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if ($isDir) {
                $folderCount++;
                $icon = 'folder';
                $type = 'folder';
            } else {
                $fileCount++;
                $totalSize += $size;
                $type = $this->determineFileType($ext);
                $icon = $this->determineFileIcon($ext);
            }

            $entries[] = [
                'index'        => $i,
                'name'         => $name,
                'basename'     => basename($name),
                'is_dir'       => $isDir,
                'size'         => $isDir ? '-' : format_file_size($size),
                'raw_size'     => $size,
                'ext'          => $ext,
                'type'         => $type,
                'icon'         => $icon,
                'modified_at'  => date('Y-m-d H:i', (int)($stat['mtime'] ?? time()))
            ];
        }

        $totalFiles = $zip->numFiles;
        $zip->close();

        return [
            'success'                 => true,
            'file_count'              => $fileCount,
            'folder_count'            => $folderCount,
            'total_files'             => $totalFiles,
            'total_uncompressed_size' => format_file_size($totalSize),
            'raw_total_size'          => $totalSize,
            'entries'                 => $entries
        ];
    }

    /**
     * Extract raw readable text from PDF, DOCX, TXT, CSV, RTF, MD
     */
    public function extractTextFromDocument(string $filePath): array
    {
        $realPath = FCPATH . ltrim($filePath, '/\\');
        if (!file_exists($realPath)) {
            return ['success' => false, 'text' => '', 'message' => 'File not found on server.'];
        }

        $ext = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
        $text = '';

        try {
            if ($ext === 'docx') {
                $text = $this->extractFromDocx($realPath);
            } elseif ($ext === 'pdf') {
                $text = $this->extractFromPdf($realPath);
            } elseif (in_array($ext, ['txt', 'csv', 'md', 'json', 'log', 'rtf'])) {
                $raw = file_get_contents($realPath);
                $text = strip_tags($raw);
            } else {
                return ['success' => false, 'text' => '', 'message' => "File format .{$ext} does not support automatic text extraction."];
            }

            $cleaned = trim(preg_replace('/\s+/', ' ', $text));
            if (empty($cleaned)) {
                return ['success' => false, 'text' => '', 'message' => 'No readable text content found in document.'];
            }

            return ['success' => true, 'text' => $text, 'char_count' => mb_strlen($text)];
        } catch (\Throwable $e) {
            return ['success' => false, 'text' => '', 'message' => 'Error extracting text: ' . $e->getMessage()];
        }
    }

    /**
     * Extract text from Microsoft Word (.docx) file
     */
    protected function extractFromDocx(string $realPath): string
    {
        $zip = new ZipArchive();
        if ($zip->open($realPath) !== true) {
            return '';
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xml) {
            return '';
        }

        // Replace paragraph tags with linebreaks
        $xml = preg_replace('/<\/w:p>/i', "\n", $xml);
        $xml = preg_replace('/<\/w:tr>/i', "\n", $xml);
        $xml = preg_replace('/<w:tab\/>/i', "\t", $xml);
        
        $cleanText = strip_tags($xml);
        return html_entity_decode($cleanText, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }

    /**
     * Extract text from standard PDF documents
     */
    protected function extractFromPdf(string $realPath): string
    {
        $content = file_get_contents($realPath);
        if (!$content) return '';

        $text = '';

        // Extract uncompressed stream blocks or decompress flate streams
        preg_match_all('/stream(.*?)endstream/s', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $stream) {
                $stream = ltrim($stream, "\r\n");
                $uncompressed = @gzuncompress($stream);
                $data = $uncompressed !== false ? $uncompressed : $stream;

                // Extract strings inside BT ... ET (Begin Text ... End Text)
                if (preg_match_all('/BT(.*?)ET/s', $data, $btMatches)) {
                    foreach ($btMatches[1] as $bt) {
                        // Extract text enclosed in parentheses: (Sample text) Tj or [(Sample) 20 (Text)] TJ
                        if (preg_match_all('/\((.*?)\)\s*(?:Tj|\'|\")/s', $bt, $strMatches)) {
                            $text .= implode(' ', $strMatches[1]) . "\n";
                        } elseif (preg_match_all('/\[(.*?)\]\s*TJ/s', $bt, $tjMatches)) {
                            foreach ($tjMatches[1] as $tj) {
                                preg_match_all('/\((.*?)\)/', $tj, $parts);
                                if (!empty($parts[1])) {
                                    $text .= implode('', $parts[1]) . ' ';
                                }
                            }
                            $text .= "\n";
                        }
                    }
                }
            }
        }

        // Fallback: If structured BT extraction didn't yield enough characters, extract clean alphanumeric sequences
        if (mb_strlen(trim($text)) < 40) {
            preg_match_all('/\(([\w\s.,;:!?@#%&*+=\-\/]{4,})\)/', $content, $fallback);
            if (!empty($fallback[1])) {
                $text = implode("\n", array_unique($fallback[1]));
            }
        }

        return trim($text);
    }

    /**
     * Synthesize and extract key marketing & client requirements from document
     */
    public function analyzeDocumentKnowledge(string $text, string $fileName, array $project): array
    {
        $words = preg_split('/\s+/', trim($text));
        $wordCount = count($words);
        
        // Analyze lines and paragraphs
        $lines = array_filter(array_map('trim', explode("\n", $text)));
        $keyPoints = [];
        $audienceHints = [];
        $brandDirectives = [];
        $usps = [];

        foreach ($lines as $line) {
            if (mb_strlen($line) < 15 || mb_strlen($line) > 250) continue;
            $lower = strtolower($line);

            if (preg_match('/(target|audience|customer|demographic|age|gender|b2b|b2c|buyer)/i', $lower)) {
                if (count($audienceHints) < 4) $audienceHints[] = $line;
            } elseif (preg_match('/(usp|unique|advantage|benefit|offer|quality|guarantee|feature)/i', $lower)) {
                if (count($usps) < 4) $usps[] = $line;
            } elseif (preg_match('/(brand|tone|guideline|voice|color|logo|do not|never|always)/i', $lower)) {
                if (count($brandDirectives) < 4) $brandDirectives[] = $line;
            } elseif (count($keyPoints) < 6) {
                $keyPoints[] = $line;
            }
        }

        // Fallback extracts if text was compact
        if (empty($keyPoints)) {
            $chunks = array_chunk($words, 15);
            foreach (array_slice($chunks, 0, 4) as $chunk) {
                $keyPoints[] = implode(' ', $chunk) . '...';
            }
        }

        $summary = "Document '{$fileName}' analyzed ({$wordCount} words). Extracted operational requirements, positioning pillars, and client specifications for project: " . ($project['name'] ?? 'Client');

        return [
            'summary'          => $summary,
            'word_count'       => $wordCount,
            'key_takeaways'    => array_values(array_unique($keyPoints)),
            'audience_hints'   => array_values(array_unique($audienceHints)),
            'usps'             => array_values(array_unique($usps)),
            'brand_directives' => array_values(array_unique($brandDirectives))
        ];
    }

    /**
     * Ingest document insights into both project_files and project knowledge base
     */
    public function ingestFileKnowledge(int $fileId, int $projectId): array
    {
        $fileModel = new ProjectFileModel();
        $projectModel = new ProjectModel();

        $file = $fileModel->where('project_id', $projectId)->find($fileId);
        if (!$file) {
            return ['success' => false, 'message' => 'File record not found.'];
        }

        $project = $projectModel->find($projectId);
        if (!$project) {
            return ['success' => false, 'message' => 'Project record not found.'];
        }

        // Extract raw text
        $extraction = $this->extractTextFromDocument($file['file_path']);
        if (!$extraction['success']) {
            return ['success' => false, 'message' => $extraction['message']];
        }

        $rawText = $extraction['text'];
        $insights = $this->analyzeDocumentKnowledge($rawText, $file['file_name'], $project);

        // Format Knowledge Base Block
        $dateStr = date('Y-m-d H:i');
        $kbEntry = "\n\n### 📄 Document Intelligence: {$file['file_name']} (Ingested {$dateStr})\n";
        $kbEntry .= "**Summary:** " . $insights['summary'] . "\n\n";

        if (!empty($insights['key_takeaways'])) {
            $kbEntry .= "**Key Requirements & Points:**\n";
            foreach ($insights['key_takeaways'] as $tp) {
                $kbEntry .= "- " . $tp . "\n";
            }
        }

        if (!empty($insights['audience_hints'])) {
            $kbEntry .= "\n**Audience Specifics:**\n";
            foreach ($insights['audience_hints'] as $ah) {
                $kbEntry .= "- " . $ah . "\n";
            }
        }

        if (!empty($insights['brand_directives'])) {
            $kbEntry .= "\n**Brand & Creative Directives:**\n";
            foreach ($insights['brand_directives'] as $bd) {
                $kbEntry .= "- " . $bd . "\n";
            }
        }

        // Update Project Knowledge Base
        $existingKb = $project['knowledge_base'] ?? '';
        $updatedKb = trim($existingKb . $kbEntry);
        $projectModel->update($projectId, ['knowledge_base' => $updatedKb]);

        // Update File Record
        $fileModel->update($fileId, [
            'extracted_text' => mb_substr($rawText, 0, 50000), // store up to 50k chars
            'ai_summary'     => json_encode($insights, JSON_UNESCAPED_UNICODE),
            'is_ingested'    => 1,
            'ingested_at'    => date('Y-m-d H:i:s')
        ]);

        // Activity log
        ActivityLogModel::log(
            (int)$project['workspace_id'],
            'Document Intelligence Engine',
            "Ingested client document '{$file['file_name']}' into Project Knowledge Base",
            "Project #{$projectId}"
        );

        return [
            'success'  => true,
            'message'  => "File '{$file['file_name']}' successfully read and ingested into AI Knowledge Base!",
            'insights' => $insights
        ];
    }

    protected function determineFileType(string $ext): string
    {
        $images = ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg', 'ico'];
        $docs = ['pdf', 'doc', 'docx', 'txt', 'rtf', 'csv', 'xls', 'xlsx'];
        $archives = ['zip', 'rar', '7z', 'tar', 'gz'];
        $videos = ['mp4', 'mov', 'webm', 'mkv', 'avi'];

        if (in_array($ext, $images)) return 'image';
        if (in_array($ext, $docs)) return 'document';
        if (in_array($ext, $archives)) return 'archive';
        if (in_array($ext, $videos)) return 'video';
        return 'file';
    }

    protected function determineFileIcon(string $ext): string
    {
        switch ($ext) {
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'webp':
            case 'gif':
            case 'svg':
                return 'image';
            case 'pdf':
                return 'file-text';
            case 'doc':
            case 'docx':
            case 'txt':
            case 'rtf':
                return 'file-text';
            case 'xls':
            case 'xlsx':
            case 'csv':
                return 'file-spreadsheet';
            case 'zip':
            case 'rar':
            case '7z':
            case 'tar':
                return 'archive';
            case 'mp4':
            case 'mov':
            case 'webm':
                return 'play-circle';
            default:
                return 'file';
        }
    }
}
