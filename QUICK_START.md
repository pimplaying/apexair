# APEX AIR - QUICK START GUIDE

## 🚀 Welcome to Apex Air!

Your professional VATSIM virtual airline website is ready to go! This guide will help you get started in 10 minutes.

---

## 📋 What You Have

Your website package includes:

✅ **Website Files:**
- `index.html` - Main website
- `styles.css` - Styling
- `script.js` - Interactive features

✅ **Documentation:**
- `README.md` - Overview
- `CUSTOMIZATION_GUIDE.md` - How to customize
- `VATSIM_COMPLIANCE.md` - Compliance requirements
- `PILOT_SOP.md` - Pilot procedures
- `VATSIM_INTEGRATION.md` - Network integration

---

## 🎨 Customize in 5 Minutes

### 1. Update Your Email
**File:** `index.html`  
**Find:** `recruitment@apexair.net`  
**Replace with:** Your email address

### 2. Add Your Logo
**File:** `index.html`  
**Find:** The SVG mountain logo  
**Replace with:** Your logo image: `<img src="logo.png">`

### 3. Change Brand Colors (Optional)
**File:** `styles.css`  
**Find:** `:root { --primary-color: #1a472a; }`  
**Change:** To your brand colors

### 4. Update Contact Information
- Discord server link
- Additional contact methods
- Social media links

### 5. Update Flight Routes
**File:** `index.html`  
**Section:** Flight Schedules  
**Update:** Your actual routes and frequencies

---

## 🌐 Deploy Your Website

### Option A: GitHub Pages (Recommended - Free & Easy)

1. **Create GitHub Account**
   - Go to https://github.com
   - Sign up for free

2. **Create New Repository**
   - Click "New Repository"
   - Name: `apexair`
   - Description: `Apex Air Virtual Airline Website`
   - Make it Public
   - Click "Create Repository"

3. **Upload Your Files**
   - Click "Upload files"
   - Drag and drop all files (index.html, styles.css, script.js, images)
   - Click "Commit changes"

4. **Enable GitHub Pages**
   - Click "Settings"
   - Scroll to "GitHub Pages"
   - Source: Select "main" branch
   - Your site is now live at: `https://yourusername.github.io/apexair`

### Option B: Netlify (Free & Powerful)

1. **Sign Up**
   - Go to https://netlify.com
   - Click "Sign up"
   - Choose GitHub authentication

2. **Deploy**
   - Click "New site from Git"
   - Connect to GitHub
   - Select your `apexair` repository
   - Click "Deploy"

3. **Live!**
   - Site automatically deployed
   - Get free subdomain: `apexair-yourname.netlify.app`
   - Set custom domain later

### Option C: Traditional Hosting

1. **Choose Provider**
   - Hostinger
   - Bluehost
   - GoDaddy
   - Any web host

2. **Upload Files**
   - Use FTP or File Manager
   - Upload all files to public_html folder
   - Set index.html as default

3. **Go Live**
   - Visit your domain
   - Website is live!

---

## ✉️ Set Up Contact Form

For the contact form to work, use a service like Formspree:

1. Go to https://formspree.io
2. Sign up for free
3. Create new form
4. Copy your form ID
5. In `index.html`, update the contact form:

```html
<form action="https://formspree.io/f/YOUR_FORM_ID" method="POST" class="contact-form">
    <input type="email" name="email" placeholder="Your Email" required>
    <!-- rest of form -->
</form>
```

---

## 📱 Test Your Website

### Before Launching:

- [ ] Open in Chrome, Firefox, Safari
- [ ] Test on mobile phone
- [ ] Click all navigation links
- [ ] Try contact form
- [ ] Check all images load
- [ ] Verify email link works
- [ ] Test responsive design

### Responsive Testing:
1. Open Chrome Developer Tools (F12)
2. Click mobile icon (top left)
3. Test different screen sizes
4. Verify it looks good

---

## 🔗 Register with VATSIM

1. **Create Your VATSIM Account**
   - Visit https://vatsim.net
   - Create account (if not already)
   - Get your VATSIM ID

2. **Register Your Airline**
   - Visit https://vatsim.net/divisions
   - Find your region
   - Register virtual airline
   - Provide your website URL

3. **Get Official Recognition**
   - VATSIM will verify your airline
   - Get official airline code
   - Listed in VATSIM directory

---

## 👨‍✈️ Recruit Your First Pilots

### Share Your Website
- Post on VATSIM forums
- Share on Discord communities
- Post on flight sim subreddits
- Email to friends interested in VATSIM

### Share Text
```
🚁 APEX AIR - Now Recruiting Pilots! 🚁

Join our professional virtual airline on VATSIM!
- Realistic flight operations
- Global routes
- Professional community
- Help build our airline

Requirements:
✈️ 50+ VATSIM flight hours
✈️ S1 rating or higher
✈️ Professional conduct

Ready to fly with us?
Visit: [your-website-url]

Contact: recruitment@apexair.net
Discord: [your-discord-link]
```

---

## 🎯 Apex Air Callsigns

Your official callsign format:

**AAX + Flight Number**

Examples:
- `AAX101` - New York to London
- `AAX205` - San Francisco to Tokyo
- `AAX302` - London to Madrid

Pilots will use: `AAX[their-assigned-number]`

---

## 📊 Track Your Progress

### Week 1
- [ ] Website customized
- [ ] Website deployed online
- [ ] Registered with VATSIM
- [ ] Discord server created

### Week 2-4
- [ ] First 5 pilots recruited
- [ ] Sample schedules flying
- [ ] Pilot feedback collected
- [ ] Website refinements made

### Month 2-3
- [ ] 15-20 active pilots
- [ ] Regular flight operations
- [ ] Community events organized
- [ ] Airline reputation building

---

## 🆘 Troubleshooting

### Website won't display
- Check all three files in same folder
- Verify filenames match exactly
- Try different browser
- Clear browser cache (Ctrl+Shift+Del)

### Contact form not sending
- Sign up for Formspree
- Update form action URL
- Test with valid email
- Check email spam folder

### Logo not showing
- Ensure image file in same folder
- Check filename spelling matches
- Use PNG or JPG format
- Try `src="logo.png"`

### Colors don't look right
- Clear browser cache
- Hard refresh (Ctrl+Shift+R)
- Check CSS file uploaded
- Verify CSS is linked in HTML

---

## 📞 Support

**Having issues?**

1. **Website Questions:**
   - See: CUSTOMIZATION_GUIDE.md
   - Check: README.md

2. **VATSIM Questions:**
   - See: VATSIM_COMPLIANCE.md
   - See: VATSIM_INTEGRATION.md
   - Visit: https://vatsim.net

3. **Pilot Operations:**
   - See: PILOT_SOP.md
   - See: PILOT_SOP_QUICK_REFERENCE.txt

4. **Website Hosting Help:**
   - GitHub Pages: Help at github.com/docs
   - Netlify: Support at netlify.com/support
   - Traditional host: Contact their support

---

## ✨ Next Features to Consider

Once your airline is established:

1. **Livery Gallery** - Show your aircraft paint schemes
2. **Pilot Database** - List active pilots and their hours
3. **News Section** - Announce events and updates
4. **Virtual Hub** - Assign home bases for pilots
5. **Leaderboard** - Top pilots by hours
6. **Blog** - Flight reports and updates
7. **Photo Gallery** - Screenshots from flights
8. **Scheduling System** - Reserve flights online

---

## 🎓 Education Resources

### Free Flight Sim Learning
- YouTube: "VATSIM for beginners"
- YouTube: "IFR procedures tutorial"
- VATSIM Academy: https://vatsim.net/training

### Free Tools
- SimBrief: https://simbrief.com (flight planning)
- Skyvector: https://skyvector.com (route planning)
- Navigraph: Charts and data

---

## 🏁 Launch Checklist

Before launching your airline:

- [ ] Website customized with your info
- [ ] Website deployed online
- [ ] Domain or subdomain working
- [ ] Contact form tested
- [ ] All links working
- [ ] Mobile responsive verified
- [ ] VATSIM account ready
- [ ] Discord or communication set up
- [ ] Pilot SOPs reviewed
- [ ] Ready to recruit!

---

## 🚀 You're Ready!

Your Apex Air website is complete and professional. You have everything needed to launch a successful virtual airline on VATSIM.

**Next Step:** Deploy your website and start recruiting pilots!

---

**Welcome to Apex Air! Safe skies!** ✈️

Questions? Check the other documentation files or visit VATSIM.net
