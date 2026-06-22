# APEX AIR - WEBSITE CUSTOMIZATION GUIDE

## Quick Start - 5 Simple Steps

### Step 1: Update Your Email Address
**File:** index.html  
**Line:** Search for "recruitment@apexair.net"

Replace with your actual email:
```html
<p><a href="mailto:your-email@yourdomain.com">your-email@yourdomain.com</a></p>
```

### Step 2: Add Your Logo
**File:** index.html  
**Location:** Navigation bar

Replace the SVG code with your image:
```html
<!-- Before (SVG) -->
<svg class="logo" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <!-- Mountain code here -->
</svg>

<!-- After (Your Image) -->
<img src="your-logo.png" alt="Apex Air Logo" class="logo">
```

### Step 3: Update Contact Links
**File:** index.html  
**Search for:** "Contact Section"

Update these sections:
- Email link (mailto:)
- Discord server link
- VATSIM profile link

### Step 4: Customize Colors
**File:** styles.css  
**Lines:** 7-13 (CSS Variables)

```css
:root {
    --primary-color: #1a472a;      /* Dark green - change here */
    --secondary-color: #2d5f3f;    /* Medium green - change here */
    --accent-color: #4a8f5f;       /* Light green - change here */
    --light-color: #f5f7fa;        /* Light gray */
    --dark-color: #0f0f0f;         /* Dark gray */
    --text-color: #333;            /* Text color */
    --border-color: #ddd;          /* Border color */
}
```

### Step 5: Update Flight Schedules
**File:** index.html  
**Search for:** "Flight Schedules"

Edit the table rows with your actual routes:
```html
<tr>
    <td>AAX101</td>
    <td>KJFK (New York)</td>
    <td>EGLL (London)</td>
    <td>B777</td>
    <td>Daily</td>
</tr>
```

---

## More Advanced Customization

### Update Pilot Count & Statistics
**File:** index.html  
**Section:** "Pilot Community"

```html
<p class="stat-number">47</p>  <!-- Change this number -->
```

Update these statistics:
- Active Pilots
- Flight Hours
- Routes Operated
- Years in Operation

### Modify Aircraft Fleet
**File:** index.html  
**Section:** Fleet Cards

Add or remove aircraft by editing these cards:
```html
<div class="aircraft-card">
    <div class="aircraft-icon">✈️</div>
    <h3>Aircraft Model</h3>
    <p>Range Category</p>
    <p class="aircraft-desc">Description</p>
    <span class="aircraft-count">X Aircraft</span>
</div>
```

### Change Airline Information
**File:** index.html
**Search for:** These key phrases

| What to Change | Current Value | Where |
|---|---|---|
| Airline Name | "Apex Air" | Throughout file |
| ICAO Code | "AAX" | Navigation & Footer |
| Callsign | "AAX" | About section |
| Requirements | Specific numbers | Pilot section |

### Add Social Media Links
**File:** index.html  
**Section:** Contact Section

Add after existing contact cards:
```html
<div class="contact-card">
    <h3>Facebook</h3>
    <p><a href="https://facebook.com/yourpage" target="_blank">Follow Us</a></p>
</div>
```

---

## Content Organization

### Key Sections in HTML
1. **Lines 1-30:** Meta tags & head
2. **Lines 32-80:** Navigation bar
3. **Lines 82-95:** Hero section
4. **Lines 97-145:** About section
5. **Lines 147-200:** Fleet section
6. **Lines 202-250:** Schedules table
7. **Lines 252-310:** Pilot info
8. **Lines 312-360:** Contact section
9. **Lines 362-400:** Footer

### CSS Sections
- **Lines 1-100:** Variables & base styles
- **Lines 101-180:** Navigation styling
- **Lines 181-250:** Hero section
- **Lines 251-350:** Sections & cards
- **Lines 351-500:** Tables & specific elements
- **Lines 501-600:** Responsive design

---

## Deployment Instructions

### Option 1: GitHub Pages (Free)
1. Create GitHub account at github.com
2. Create new repository named "apexair"
3. Upload all files (index.html, styles.css, script.js, images)
4. Go to Settings > Pages
5. Set source to "main" branch
6. Your site will be at: https://yourusername.github.io/apexair

### Option 2: Hostinger / Bluehost
1. Sign up for hosting
2. Use File Manager to upload files
3. Make sure index.html is in root directory
4. Set index.html as default page
5. Your site will be at: your-domain.com

### Option 3: Netlify (Free)
1. Go to netlify.com
2. Drag and drop your website folder
3. Site automatically deployed
4. Get free custom subdomain

---

## Testing Checklist

- [ ] All links work and navigate correctly
- [ ] Contact form validates input
- [ ] Mobile version looks good
- [ ] Images load properly
- [ ] Logo displays correctly
- [ ] Colors match your branding
- [ ] Phone numbers format correctly
- [ ] Email links open in client
- [ ] External links open in new tab
- [ ] Site loads quickly

---

## Common Issues & Fixes

### Logo not showing
- Check filename matches exactly (case-sensitive on servers)
- Ensure image file is in same directory as HTML
- Use relative path: `src="logo.png"`

### Contact form not working
- Forms need backend (PHP, Node.js, etc.)
- Use service like Formspree for backend
- Add to form: `action="https://formspree.io/f/YOUR_ID"`

### Styling looks different
- Clear browser cache (Ctrl+Shift+Delete)
- Ensure CSS file is linked correctly
- Check all CSS files uploaded

### Responsive design broken
- Check viewport meta tag in head
- Verify media queries in CSS
- Test in mobile device or Chrome dev tools

---

## Useful Resources

### Editing Tools
- Visual Studio Code (free code editor)
- Sublime Text
- Notepad++ (Windows)
- TextEdit (Mac)

### Image Editing
- Canva (free design)
- Photoshop
- GIMP (free)
- Paint.net (free)

### Color Palettes
- Coolors.co
- ColorHunt.co
- Adobe Color

### Font Resources
- Google Fonts (free)
- FontAwesome (icons)

---

## File Reference

| File | Purpose | Edit For |
|---|---|---|
| index.html | Main website content | Text, images, structure |
| styles.css | Website styling | Colors, fonts, layout |
| script.js | Interactive features | Forms, animations |
| README.md | Documentation | General info |
| VATSIM_COMPLIANCE.md | VATSIM guidelines | Regulations |
| PILOT_SOP.md | Pilot procedures | Operations |

---

## Next Steps

1. ✅ Customize colors and branding
2. ✅ Add your logo
3. ✅ Update contact information
4. ✅ Update flight schedules
5. ✅ Update airline statistics
6. ✅ Choose hosting provider
7. ✅ Deploy website
8. ✅ Share with VATSIM community
9. ✅ Register airline officially
10. ✅ Start recruiting pilots!

---

## Support & Help

For specific customization help:
1. Check the HTML comments in code
2. Review README.md for overview
3. Look at VATSIM_COMPLIANCE.md for regulations
4. Test changes in browser before deploying

---

**Good luck with Apex Air! Safe skies!** ✈️
