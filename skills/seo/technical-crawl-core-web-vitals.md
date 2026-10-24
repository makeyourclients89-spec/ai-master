# Technical SEO, Crawl Budget & Core Web Vitals Mastery

**Category:** SEO  
**Level:** Advanced / Elite  
**Scope:** Global Agency & Project-Level Technical Foundation

---

## 1. Executive Summary & Objective
Technical SEO establishes the search engine crawlability, indexation efficiency, and renderability of web assets. Without sound technical hygiene, even top-tier content fails to rank. This skill provides an exhaustive, battle-tested framework to diagnose and optimize:
- Server Response Time & TTFB (Time to First Byte)
- Google Core Web Vitals (LCP, INP, CLS)
- Crawl Budget Conservation & Dynamic Rendering
- Sitemaps, Robots.txt & Canonicalization
- Mobile-First Indexing & JavaScript Hydration

---

## 2. Core Web Vitals (2025/2026 Standards)

### A. Largest Contentful Paint (LCP)
- **Target:** `<= 2.5 seconds` on mobile 4G networks.
- **Root Causes of Failure:** Render-blocking CSS/JS, slow TTFB, uncompressed hero web assets, client-side rendered hero images.
- **Actionable Optimization Framework:**
  1. Add `fetchpriority="high"` and `loading="eager"` to the LCP hero image:
     ```html
     <link rel="preload" as="image" href="/images/hero-banner.webp" fetchpriority="high">
     <img src="/images/hero-banner.webp" alt="Primary Entity" width="1200" height="630" fetchpriority="high" loading="eager">
     ```
  2. Implement CDN edge caching (Cloudflare / Fastly) with TTFB `< 200ms`.
  3. Inline Critical Above-the-Fold CSS directly into the `<head>` tag.
  4. Defer non-critical stylesheets and external scripts via `defer` or `async`.

### B. Interaction to Next Paint (INP)
- **Target:** `<= 200 milliseconds`.
- **Replaced FID:** Measures responsiveness of all user clicks, taps, and key presses throughout the entire page lifecycle.
- **Actionable Optimization Framework:**
  1. Break long tasks on the main thread: any JS execution `> 50ms` must yield via `scheduler.yield()` or `requestIdleCallback()`.
  2. Avoid heavy event listeners on scroll and touch actions; debounce input handlers.
  3. Remove unused third-party tracking scripts (Hotjar, multiple analytics pixels) that clog the main execution thread.

### C. Cumulative Layout Shift (CLS)
- **Target:** `<= 0.1`.
- **Root Causes:** Images, banners, or iframes without explicit dimensions, dynamic injected ads, FOIT (Flash of Invisible Text) with web fonts.
- **Actionable Optimization Framework:**
  1. Explicitly define `width` and `height` (or CSS `aspect-ratio`) on all images, videos, and SVG elements:
     ```css
     img { aspect-ratio: 16 / 9; width: 100%; height: auto; }
     ```
  2. Use `font-display: optional` or `swap` with size-adjust fallbacks to eliminate layout jank during web font loading.
  3. Reserve fixed CSS containers for dynamic ads and cookie banners before rendering.

---

## 3. Crawl Budget & Indexation Engineering

### A. Robots.txt Architecture
Prevent waste of search crawler resources on faceted navigation, internal search results, staging environments, and cart pages:
```txt
User-agent: *
Disallow: /checkout/
Disallow: /cart/
Disallow: /my-account/
Disallow: /*?s=*
Disallow: /*?filter_*
Disallow: /api/
Allow: /wp-content/uploads/
Allow: /assets/

Sitemap: https://example.com/sitemap_index.xml
```

### B. XML Sitemap Protocol
- Split sitemaps into clean hierarchies: `page-sitemap.xml`, `post-sitemap.xml`, `product-sitemap.xml`.
- Ensure maximum 10,000 URLs per individual sitemap file.
- Only include HTTP 200, indexable, canonical URLs. Strip 301 redirects, 404s, and `noindex` pages immediately.
- Maintain accurate `<lastmod>` timestamps matching real CMS content changes.

### C. Canonicalization Rules
- Always declare self-referencing canonical tags on indexable pages:
  ```html
  <link rel="canonical" href="https://example.com/canonical-page-slug">
  ```
- Enforce strict 301 redirects for:
  - Trailing slash consistency (`/page` vs `/page/`)
  - Case-sensitivity (force all URLs to lowercase)
  - HTTP to HTTPS and non-WWW to WWW (or vice versa).

---

## 4. Technical Audit Execution Checklist
1. [ ] Test mobile rendering in Google Search Console URL Inspection Tool.
2. [ ] Validate server response headers: HTTP/2 or HTTP/3 enabled, Gzip / Brotli active.
3. [ ] Confirm no redirect chains (Page A -> Page B -> Page C); collapse directly into 1 hop.
4. [ ] Verify robots meta tag is `<meta name="robots" content="index, follow, max-image-preview:large">`.
5. [ ] Check 404 page returns proper HTTP 404 status code (not soft 404 with HTTP 200).
