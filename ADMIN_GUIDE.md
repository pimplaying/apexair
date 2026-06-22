# Apex Air - Admin Dashboard Guide

## 🛡️ Accessing the Admin Panel

Visit: `http://yourdomain.com/admin/`

### Default Credentials
- **Username:** admin
- **Password:** admin

⚠️ **IMPORTANT:** Change the default password immediately after first login!

---

## 📊 Admin Dashboard Overview

The admin dashboard gives you complete control over your virtual airline operations.

### Dashboard Sections

#### 1. **Statistics Cards** (Top)
Quick overview of your airline:
- **Total Pilots** - All registered pilots
- **Pending Applications** - Applications waiting review
- **Approved Pilots** - Pilots approved to fly
- **Registered (No App)** - New pilots not yet applied

#### 2. **Pending Applications** (Main)
All pilot applications waiting for your review.

**For each application, you can:**
- View pilot details
- View flight experience
- See aircraft preferences
- Review additional information
- Approve ✓
- Request more info ℹ️
- Reject ✕

#### 3. **All Pilots** (Table)
Complete list of every pilot on your system with:
- Name
- Email
- VATSIM ID
- Current Status (Registered, Pending, Approved, Rejected)
- Join Date

#### 4. **Application History** (Table)
Complete history of all applications submitted:
- Pilot name
- Flight hours
- VATSIM rating
- Application status
- Date submitted

---

## 🎯 Reviewing Applications

### Step-by-Step Application Review

1. **Find Application** in "Pending Applications" section
2. **Click "Review"** button
3. **Modal Opens** showing all application details:
   - Pilot information
   - Flight experience
   - Aircraft preferences
   - Availability
   - Additional information
4. **Add Admin Notes** (optional) explaining your decision
5. **Choose Action:**
   - **Approve ✓** - Accept pilot to VA
   - **Needs Info ℹ️** - Request more information
   - **Reject ✕** - Decline application

### Application Statuses

| Status | Meaning | Action |
|--------|---------|--------|
| **pending** | Waiting for admin review | Review & decide |
| **approved** | Pilot accepted to VA | Pilot can fly |
| **rejected** | Application denied | Pilot notified |
| **needs_info** | More info required | Pilot must respond |
| **registered** | Pilot account created (no app yet) | Waiting for application |

---

## 👥 Pilot Management

### Viewing Pilot Information

Click on any pilot in the "All Pilots" table to see:
- Full name
- Email address
- VATSIM ID
- Account status
- Date joined
- Flight hours
- Number of flights

### Updating Pilot Records

To update a pilot's flight hours or information:

1. Open admin panel
2. Access database file: `/data/pilots.json`
3. Edit pilot entry manually (advanced)

For simpler updates, consider:
- Creating a pilot management interface
- Using the admin panel to approve applications
- Tracking hours through flight reports

---

## 📋 Data Storage

### File Locations

All pilot data is stored in JSON files:

| File | Purpose |
|------|---------|
| `/data/pilots.json` | All pilot accounts |
| `/data/applications.json` | All applications |
| `/data/admin.json` | Admin credentials |
| `/logs/error.log` | Error logs |

### Pilot Data Structure

```json
{
    "id": "pilot_1234567890.1234",
    "name": "John Pilot",
    "email": "john@example.com",
    "vatsim": "123456",
    "password": "hashed_password_here",
    "status": "approved",
    "created_at": "2026-06-22 10:30:45",
    "flight_hours": 0,
    "flights": 0
}
```

### Application Data Structure

```json
{
    "id": "pilot_1234567890.1234",
    "pilot_id": "pilot_id_here",
    "pilot_name": "John Pilot",
    "pilot_email": "john@example.com",
    "pilot_vatsim": "123456",
    "flight_hours": 150,
    "rating": "S3",
    "aircraft_preferences": ["A320", "A321"],
    "availability": "weekdays",
    "additional_info": "Experienced VA pilot",
    "status": "approved",
    "created_at": "2026-06-22 10:35:00",
    "reviewed_at": "2026-06-22 10:45:00",
    "reviewed_by": "admin",
    "notes": "Great application!"
}
```

---

## 🔐 Changing Admin Password

### In Production (Recommended)

Use the admin panel interface (built into future versions) or:

1. Stop your web server
2. Edit `/data/admin.json`
3. Replace password hash with new one:

```php
<?php
// Run this once to generate hash
echo password_hash('your_new_password', PASSWORD_BCRYPT);
?>
```

4. Update the file with new hash
5. Restart web server

### Quick Change (Development)

Edit `/backend/config.php` and change the default password:

```php
// In initDatabases() function, change:
$admin = [
    'username' => 'admin',
    'password' => password_hash('YOUR_NEW_PASSWORD', PASSWORD_BCRYPT)
];
```

---

## 📊 Reports

### Generate Pilot Statistics

Export pilot data for reporting:

**Approved Pilots:** Count pilots with status "approved"
**Pending Applications:** Count applications with status "pending"
**Total Flight Hours:** Sum of all pilot flight_hours
**Monthly Activity:** Track applications by date

### Create Custom Reports

Modify `/admin/index.php` to add custom reports:

```php
// Example: Pilots by rating
$pilots_by_rating = [];
foreach ($pilots as $pilot) {
    // Count pilots by their rating
}
```

---

## 🚨 Troubleshooting

### Can't Access Admin Panel

- Verify URL: `http://yourdomain.com/admin/`
- Check username/password (default: admin/admin)
- Ensure PHP is installed and enabled

### Password Won't Reset

- Check file permissions on `/data/admin.json`
- Ensure `/data/` directory is writable
- Try regenerating hash in `config.php`

### Applications Not Showing

- Check `/data/applications.json` exists
- Verify `/data/` directory writable
- Check browser console for errors (F12)
- Review PHP error logs

### Can't Approve Applications

- Verify you're logged in as admin
- Check `/data/` directory permissions (755)
- Ensure files are writable
- Try refreshing page after action

---

## 🔧 Advanced Admin Tasks

### Bulk Operations

**Export All Pilots to CSV:**

Create `export.php`:
```php
<?php
require_once 'backend/config.php';
$pilots = readDatabase(PILOTS_DB);
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=pilots.csv');

echo "Name,Email,VATSIM ID,Status,Joined\n";
foreach ($pilots as $pilot) {
    echo $pilot['name'] . "," . $pilot['email'] . "," . $pilot['vatsim'] . "," 
         . $pilot['status'] . "," . $pilot['created_at'] . "\n";
}
?>
```

### Backup Data

Regularly backup:
- `/data/pilots.json`
- `/data/applications.json`
- `/data/admin.json`

Store backups securely outside web root.

---

## 📱 Mobile Access

The admin panel is **not mobile-optimized** yet.

**Recommended for mobile:**
- Use desktop version via VPN if needed
- Access via mobile browser (limited UI)
- Use tablet for better experience

---

## 🔒 Security Notes

### Current Security Level
- ✅ Password hashing (bcrypt)
- ✅ Session-based authentication
- ✅ Input sanitization
- ✅ CSRF-ready (add tokens for production)

### Before Production Deployment

Add:
- ✅ HTTPS/SSL certificate
- ✅ CSRF token validation
- ✅ Rate limiting
- ✅ Audit logging
- ✅ Two-factor authentication
- ✅ Encrypted database

### Data Privacy

Ensure compliance with:
- GDPR (if EU pilots)
- Privacy laws in your region
- Data retention policies
- Pilot data protection

---

## 📞 Support

**Admin Panel Questions:**
- Review this guide first
- Check error logs: `/logs/error.log`
- Verify PHP version 7.4+
- Test with sample data

---

**Your Apex Air admin panel is ready to manage your virtual airline! 🎉**

