# Search Intent Engineering & Semantic Keyword Clustering

**Category:** SEO  
**Level:** Advanced  
**Scope:** Keyword Strategy, Content Roadmapping & Cannibalization Prevention

---

## 1. Executive Summary & Objective
Targeting individual keywords one-by-one is obsolete and leads to **Keyword Cannibalization** (where multiple pages on the same domain compete against each other for the same query).

Modern SEO requires **Topical Clustering**: grouping 20 to 50 related keyword variations around a single canonical URL based on **SERP Intent Analysis**.

---

## 2. The 4 Dimensions of Search Intent

| Intent Type | User Motivation | SERP Features Expected | Page Type Required | Example Query |
| :--- | :--- | :--- | :--- | :--- |
| **Informational** | Wants to learn, understand, or solve a query | Featured Snippet, PAA, Knowledge Panel, Videos | Comprehensive Blog Guide, Explainer, Infographic | "what is kshara sutra therapy" |
| **Commercial** | Comparing options, brands, reviews before purchasing | Best Lists, Comparison Tables, Review Stars | Round-up Review, Comparison Page, Buyer's Guide | "best ayurvedic shampoo for hair fall 2026" |
| **Transactional** | Ready to buy, subscribe, or book an appointment | Shopping Ads, In-Stock Badges, Product Grid, Checkout | Product Landing Page, Pricing Page, Cart | "buy ashwagandha extract 60 capsules online" |
| **Navigational** | Looking for a specific brand or specific login page | Sitelinks, Brand Knowledge Panel, Official URL | Homepage, Login Portal, Brand Location | "ivate ayurveda customer support" |

---

## 3. The SERP-Overlap Clustering Algorithm
To determine whether two related keywords deserve **one unified page** or **two separate pages**, use the **Google SERP Overlap Test**:

1. Search *Keyword A* in Google incognito: note the top 10 organic ranking URLs.
2. Search *Keyword B* in Google incognito: note the top 10 organic ranking URLs.
3. **Decision Rule:**
   - **If 4 or more URLs are identical in both results:** The user search intent is identical. Merge both keywords into a single comprehensive page.
   - **If fewer than 3 URLs overlap:** Google views the intent as distinct. Create two separate pages and link them contextually.

---

## 4. Semantic Topic Cluster Architecture (Hub & Spoke)

```
                       [ PILLAR PAGE: /hair-fall-treatment/ ]
                        (High-Volume Broad Commercial Entity)
                                      |
       +------------------------------+------------------------------+
       |                              |                              |
  [ SPOKE 1 ]                    [ SPOKE 2 ]                    [ SPOKE 3 ]
/ayurvedic-oil-hair-fall/      /diet-for-hair-growth/       /bhringraj-vs-amla/
(Transactional Product Hub)    (Informational Guide)        (Commercial Comparison)
```

### Cluster Execution Rules:
- The **Pillar Page** targets high-volume head keywords (e.g., "Ayurvedic Hair Fall Treatment").
- Each **Spoke Page** targets mid-tail and long-tail sub-queries.
- Every Spoke links UP to the Pillar using exact anchor text.
- The Pillar links DOWN to every Spoke within context.
- Spokes link laterally to each other when logically relevant.

---

## 5. Keyword Cannibalization Diagnostic & Fix
- **Symptom:** Two URLs on your domain swap ranking positions between page 1 and page 3 in Google Search Console, causing traffic volatility.
- **Root Cause:** Both pages target overlapping intent with similar heading structures.
- **Remediation Protocol:**
  1. Determine the stronger URL (higher backlinks, historical conversions, older age).
  2. Merge the valuable unique content from the weaker page into the stronger page.
  3. Implement a permanent **HTTP 301 Redirect** from the weaker URL to the stronger URL.
  4. Update all internal links across the website pointing to the old URL.
