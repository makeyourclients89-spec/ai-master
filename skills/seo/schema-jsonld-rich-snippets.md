# Schema.org JSON-LD Structured Data Mastery

**Category:** SEO  
**Level:** Advanced / Technical  
**Scope:** Knowledge Graph & Rich Snippet Activation

---

## 1. Executive Summary & Objective
Structured data written in **JSON-LD (JavaScript Object Notation for Linked Data)** communicates entity attributes directly to search engines without requiring text parsing. Correct Schema implementation drives:
- Star ratings & review rich snippets in SERPs
- FAQ collapsible dropdowns
- Product price, stock availability & delivery badges
- Google Knowledge Panel entity establishment
- Breadcrumbs in mobile search results

---

## 2. Essential Global Schemas

### A. Organization / Agency Schema (Homepage & Sitewide)
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "@id": "https://example.com/#organization",
  "name": "Ivate Ayurveda",
  "url": "https://example.com/",
  "logo": "https://example.com/assets/logo.png",
  "description": "Authentic, certified organic Ayurvedic health and wellness formulations.",
  "sameAs": [
    "https://facebook.com/ivateayurveda",
    "https://instagram.com/ivateayurveda",
    "https://linkedin.com/company/ivateayurveda"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+91-9876543210",
    "contactType": "Customer Support",
    "areaServed": "IN",
    "availableLanguage": ["en", "hi"]
  }
}
</script>
```

### B. E-Commerce Product & Aggregate Rating Schema
Enables star rating rich snippets, price currency, and in-stock badges directly in Google search:
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "Pure Ashwagandha Root Extract Capsules (60ct)",
  "image": [
    "https://example.com/images/ashwagandha-1.webp",
    "https://example.com/images/ashwagandha-2.webp"
  ],
  "description": "Premium 100% organic KSM-66 Ashwagandha for stress relief and vitality.",
  "sku": "IVA-ASH-001",
  "mpn": "8901234567890",
  "brand": {
    "@type": "Brand",
    "name": "Ivate Ayurveda"
  },
  "offers": {
    "@type": "Offer",
    "url": "https://example.com/products/ashwagandha-capsules",
    "priceCurrency": "INR",
    "price": "899.00",
    "priceValidUntil": "2027-12-31",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "Ivate Ayurveda"
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "148"
  }
}
</script>
```

### C. FAQPage Schema (For High CTR SERP Expansion)
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "How long does it take for Ashwagandha capsules to show results?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Most clinical studies indicate noticeable improvements in stress reduction and sleep quality within 2 to 4 weeks of consistent daily usage."
      }
    },
    {
      "@type": "Question",
      "name": "Is this product certified organic and free from heavy metals?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Yes, our formulation is third-party lab tested, AYUSH certified, and complies with international heavy metal safety standards."
      }
    }
  ]
}
</script>
```

### D. BreadcrumbList Schema
Replaces raw URLs with clean clickable site breadcrumbs in Google mobile SERPs:
```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://example.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Herbal Supplements",
      "item": "https://example.com/supplements"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "Ashwagandha",
      "item": "https://example.com/supplements/ashwagandha"
    }
  ]
}
</script>
```

---

## 3. Validation & Testing Protocol
1. Test every JSON-LD code block using the official **Google Rich Results Test Tool** (`https://search.google.com/test/rich-results`).
2. Verify zero warnings and zero critical errors in **Schema.org Validator** (`https://validator.schema.org`).
3. Ensure no hidden or deceptive text is in Schema that does not match the rendered HTML content visible to real human users.
