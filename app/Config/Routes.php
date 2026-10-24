<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Root Route
$routes->get('/', static function () {
    if (session()->get('logged_in')) {
        return redirect()->to('/dashboard');
    }
    return redirect()->to('/login');
});

// Authentication Routes (Direct Login, No Verification Email)
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginSubmit');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerSubmit');
$routes->get('logout', 'AuthController::logout');

// Protected Workspace & Dashboard Routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('workspace/switch/(:num)', 'DashboardController::switchWorkspace/$1');
    $routes->post('workspace/create', 'DashboardController::createWorkspace');

    // Projects
    $routes->get('projects', 'ProjectController::index');
    $routes->post('projects', 'ProjectController::store');
    $routes->get('projects/(:segment)', 'ProjectController::view/$1');
    $routes->post('projects/(:num)', 'ProjectController::update/$1');
    $routes->get('projects/(:num)/toggle', 'ProjectController::toggleStatus/$1');
    $routes->match(['get', 'post'], 'projects/(:num)/delete', 'ProjectController::deleteAndZip/$1');
    $routes->match(['get', 'post'], 'projects/(:num)/restore', 'ProjectController::restore/$1');
    $routes->get('projects/(:num)/download-zip', 'ProjectController::downloadZip/$1');
    $routes->match(['get', 'post'], 'projects/(:num)/destroy', 'ProjectController::destroyPermanently/$1');
    $routes->post('projects/(:num)/tasks', 'ProjectController::addTask/$1');
    $routes->post('projects/(:num)/tasks/auto-generate', 'ProjectController::autoGenerateTasks/$1');
    $routes->post('projects/(:num)/tasks/approve-all', 'ProjectController::approveAllTasks/$1');
    $routes->post('tasks/(:num)/status', 'ProjectController::updateTaskStatus/$1');
    $routes->post('tasks/(:num)/verify', 'ProjectController::verifyTask/$1');
    $routes->post('tasks/(:num)/edit', 'ProjectController::editTask/$1');
    $routes->get('tasks/(:num)/delete', 'ProjectController::deleteTask/$1');
    $routes->get('projects/(:num)/export', 'ProjectController::exportJson/$1');

    // Project Files, ZIP Inspector & AI Knowledge Base Ingestion
    $routes->post('projects/(:num)/files/upload', 'ProjectController::uploadFile/$1');
    $routes->get('projects/(:num)/files/delete/(:num)', 'ProjectController::deleteFile/$1/$2');
    $routes->get('projects/(:num)/files/inspect-zip/(:num)', 'ProjectController::inspectZip/$1/$2');
    $routes->post('projects/(:num)/files/ingest-kb/(:num)', 'ProjectController::ingestFileKnowledge/$1/$2');
    $routes->post('projects/(:num)/knowledge/update', 'ProjectController::updateKnowledgeBase/$1');

    // Multiple Websites & Deep Scanner
    $routes->post('projects/(:num)/websites/add', 'ProjectController::addWebsite/$1');
    $routes->get('projects/(:num)/websites/delete/(:num)', 'ProjectController::deleteWebsite/$1/$2');
    $routes->get('projects/(:num)/websites/primary/(:num)', 'ProjectController::setPrimaryWebsite/$1/$2');
    $routes->post('projects/(:num)/websites/scan/(:num)', 'ProjectController::scanWebsite/$1/$2');
    $routes->post('projects/(:num)/websites/apply-insights/(:num)', 'ProjectController::applyWebsiteInsights/$1/$2');

    // Tool Connectors (Google Search Console, Bing, Meta, GA4, etc.)
    $routes->get('projects/(:num)/connectors/oauth/(:segment)', 'ProjectController::oauthPopup/$1/$2');
    $routes->post('projects/(:num)/connectors/oauth-grant/(:segment)', 'ProjectController::oauthGrant/$1/$2');
    $routes->post('projects/(:num)/connectors/save', 'ProjectController::saveConnector/$1');
    $routes->post('projects/(:num)/connectors/one-click', 'ProjectController::oneClickConnect/$1');
    $routes->post('projects/(:num)/connectors/connect-all-recommended', 'ProjectController::connectAllRecommended/$1');
    $routes->post('projects/(:num)/connectors/disconnect-type/(:segment)', 'ProjectController::disconnectConnectorType/$1/$2');
    $routes->get('projects/(:num)/connectors/delete/(:num)', 'ProjectController::deleteConnector/$1/$2');

    // Google Search Console OAuth & Analytics API
    $routes->get('integrations/google-search-console/connect/(:num)', 'GoogleSearchConsoleController::connect/$1');
    $routes->get('integrations/google-search-console/callback', 'GoogleSearchConsoleController::callback');
    $routes->post('integrations/google-search-console/sync/(:num)', 'GoogleSearchConsoleController::sync/$1');
    $routes->post('integrations/google-search-console/map-property/(:num)', 'GoogleSearchConsoleController::mapProperty/$1');
    $routes->post('projects/(:num)/gsc/map-property', 'GoogleSearchConsoleController::mapProperty/$1');
    $routes->get('projects/(:num)/gsc/performance', 'GoogleSearchConsoleController::getPerformance/$1');
    $routes->post('projects/(:num)/gsc/sync', 'GoogleSearchConsoleController::sync/$1');
    $routes->post('projects/(:num)/gsc/disconnect', 'GoogleSearchConsoleController::disconnect/$1');
    $routes->get('projects/(:num)/(:any)', 'ProjectController::view/$1');

    // Agency Skills & Frameworks Library (Global & Project Custom)
    $routes->get('skills', 'SkillController::index');
    $routes->get('skills/', 'SkillController::index');
    $routes->post('skills/create', 'SkillController::create');
    $routes->post('skills/update/(:num)', 'SkillController::update/$1');
    $routes->get('skills/delete/(:num)', 'SkillController::delete/$1');
    $routes->get('skills/api/(:num)', 'SkillController::apiGet/$1');
    $routes->post('projects/(:num)/skills/custom', 'SkillController::createProjectSkill/$1');

    // AI Agents & API Keys
    $routes->get('agents', 'AgentController::index');
    $routes->post('agents/save', 'AgentController::save');
    $routes->post('agents/(:num)/test', 'AgentController::testRun/$1');

    // People & Team Access
    $routes->get('team', 'TeamController::index');
    $routes->post('team/add', 'TeamController::addMember');
    $routes->get('team/remove/(:num)', 'TeamController::removeMember/$1');

    // Activity Log
    $routes->get('activity', 'ActivityController::index');

    // Plan & Billing
    $routes->get('billing', 'BillingController::index');
});
