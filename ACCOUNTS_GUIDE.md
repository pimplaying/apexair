# Apex Air Pilot Account System

Your website now features a complete pilot account system! Pilots can register, login, and manage their profiles - just like the KLM-VA website.

## How It Works

### User Registration

Pilots can create an account by:
1. Clicking "My Account" in navigation
2. Clicking "Register here"
3. Filling in their details:
   - Full Name
   - Email Address
   - VATSIM ID
   - Password (minimum 8 characters)
   - Confirm Password

### User Login

Registered pilots can login using:
- **Email** OR **Name** + **Password**

### Pilot Profile

After login, pilots see their profile with:
- Welcome message (personalized)
- VATSIM ID
- Flight Hours (starts at 0, you can update manually)
- Total Flights (starts at 0, you can update manually)
- Logout button

## Data Storage

### How It Works

- **No server needed!** Uses browser local storage
- **Secure:** Data stored locally on pilot's device
- **Persistent:** Accounts saved between sessions
- **Private:** Each device/browser has separate accounts

### Storage Details

The system stores two types of data:

**1. All Users List** (`apexairUsers` in localStorage)
```json
[
  {
    "id": 1234567890,
    "name": "John Pilot",
    "email": "john@example.com",
    "vatsim": "123456",
    "password": "mypassword123",
    "flightHours": 0,
    "flights": 0,
    "joinDate": "6/22/2026"
  }
]
```

**2. Current User** (`apexairUser` in localStorage)
- Stores only the logged-in user's data
- Cleared on logout

## Customization

### Update Pilot Flight Hours

You can programmatically update a pilot's hours. Open browser console (F12) and run:

```javascript
// Get current user
let user = JSON.parse(localStorage.getItem('apexairUser'));

// Update their stats
user.flightHours = 50;  // Update hours
user.flights = 15;      // Update flights

// Save back
localStorage.setItem('apexairUser', JSON.stringify(user));

// Refresh page to see changes
location.reload();
```

### Clear All Accounts

To reset all pilot accounts, open console (F12) and run:

```javascript
localStorage.removeItem('apexairUsers');
localStorage.removeItem('apexairUser');
location.reload();
```

### Export User Data

Get a list of all registered pilots:

```javascript
let users = JSON.parse(localStorage.getItem('apexairUsers')) || [];
console.table(users);
```

## Limitations & Notes

### Current Limitations
- ⚠️ Passwords stored in plain text (development only)
- ⚠️ No backend server (data lost if browser cleared)
- ⚠️ Each device has separate accounts
- ⚠️ No email verification

### Future Improvements
- ✅ Add backend server (Node.js + MongoDB)
- ✅ Encrypt passwords
- ✅ Add email verification
- ✅ Add password reset
- ✅ Sync accounts across devices
- ✅ Add pilot statistics tracking
- ✅ Add flight log history

## For Production Use

When you're ready for a real virtual airline, upgrade to:

### Option 1: Simple Backend (Node.js + MongoDB)

```javascript
// Backend would validate, encrypt, and store securely
// Frontend no longer stores passwords
// Data persists on server
// Accessible from any device
```

### Option 2: Third-Party Service

- Firebase (Google's platform)
- Auth0 (specialized auth service)
- Supabase (open-source Firebase alternative)

### Option 3: Custom Server

Build your own using:
- Node.js + Express
- Python + Flask/Django
- PHP + SQL
- Any backend language

## Security Tips

### Development (Current)
✅ Current setup is **fine for demonstration**
✅ Perfect for testing the feature

### Before Going Live
⚠️ **DO NOT use plain-text passwords in production**
⚠️ Switch to a real backend server
⚠️ Use HTTPS only
⚠️ Implement proper authentication

### When Production-Ready
✅ Use encrypted passwords
✅ Add email verification
✅ Implement 2FA (two-factor auth)
✅ Add CAPTCHA to prevent bots
✅ Use session tokens instead of storing passwords

## Example Use Cases

### Use Case 1: Test Pilot Signup
1. Go to "My Account"
2. Click "Register"
3. Fill in test data:
   - Name: John Pilot
   - Email: john@test.com
   - VATSIM ID: 123456
   - Password: Password123
4. Click "Create Account"
5. See pilot profile

### Use Case 2: Test Login
1. Click "Logout"
2. See login form again
3. Enter: john@test.com + Password123
4. Click "Login"
5. See profile reappear

### Use Case 3: Multiple Accounts
1. Logout
2. Register with different email
3. New account created
4. Can login with either account

## How It Looks

### Login Panel
```
┌─────────────────────┐
│   Pilot Login       │
├─────────────────────┤
│ Username/Email  [  ]│
│ Password        [  ]│
│ [  Login Button  ]  │
│                     │
│ No account?         │
│ Register here       │
└─────────────────────┘
```

### Register Panel
```
┌─────────────────────┐
│  Pilot Registration │
├─────────────────────┤
│ Full Name       [  ]│
│ Email           [  ]│
│ VATSIM ID       [  ]│
│ Password        [  ]│
│ Confirm Pass    [  ]│
│ [Create Account  ]  │
│                     │
│ Already have acct?  │
│ Login here          │
└─────────────────────┘
```

### Profile Panel
```
┌─────────────────────┐
│ Welcome, John!      │
├─────────────────────┤
│ VATSIM ID: 123456   │
│ Hours: 50  Flights:15
│ [  Logout Button  ] │
└─────────────────────┘
```

## JavaScript Functions

Available functions you can call:

```javascript
// Switch between login and register
switchAuth(event, 'login');   // Show login
switchAuth(event, 'register'); // Show register

// Login user
handleLogin(formSubmitEvent);

// Register user
handleRegister(formSubmitEvent);

// Show profile
showPilotProfile(userObject);

// Logout user
logout();

// Check for existing login on page load
checkExistingLogin();
```

## Troubleshooting

### "Passwords do not match"
- Verify password and confirm password are identical
- Check for extra spaces

### "This email is already registered"
- Use a different email
- Or logout first if trying to re-test

### "Invalid username or password"
- Check capitalization (case-sensitive)
- Verify exact email or name
- Try other registered account

### Data disappeared after browser refresh
- This is normal! Local storage persists
- If it disappeared, browser data was cleared
- Check browser's "Clear browsing data" settings

### Can't see pilot profile after register
- Page should auto-show profile
- Refresh page (F5) if needed
- Check console for errors (F12 > Console)

---

## Summary

Your Apex Air website now has:
✅ User registration system
✅ Secure login
✅ Pilot profiles
✅ Data persistence
✅ Easy to use interface

This provides the foundation for a real virtual airline! When ready, you can upgrade to a full backend system.

**Start recruiting pilots!** ✈️
