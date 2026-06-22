# How to Add Aircraft Liveries

Your Apex Air website now features an aircraft liveries section! It's super easy to add new aircraft types.

## Adding a New Livery

### Step 1: Edit script.js

Open `script.js` and find the `aircraftLiveries` array at the top (around line 1-15):

```javascript
const aircraftLiveries = [
    {
        name: "Airbus A320",
        type: "A320",
        registrations: "N-6001 to N-6010",
        quantity: "10 Aircraft",
        image: "✈️ A320"
    },
    {
        name: "Airbus A321",
        type: "A321",
        registrations: "N-7101 to N-7108",
        quantity: "8 Aircraft",
        image: "✈️ A321"
    }
    // Add more here!
];
```

### Step 2: Add Your Aircraft

Add a new object to the array before the closing bracket:

```javascript
{
    name: "Boeing 737-800",
    type: "B737",
    registrations: "N-3801 to N-3810",
    quantity: "10 Aircraft",
    image: "✈️ B737"
}
```

### Step 3: Field Explanations

| Field | Purpose | Example |
|-------|---------|---------|
| **name** | Full aircraft name | "Boeing 777-300ER" |
| **type** | ICAO code or short type | "B777" or "777" |
| **registrations** | Aircraft registration numbers/range | "N-8001 to N-8005" |
| **quantity** | How many of this type you have | "5 Aircraft" |
| **image** | Emoji or image URL for display | "✈️" or "URL" |

## Examples

### Adding more Airbus aircraft:

```javascript
{
    name: "Airbus A330",
    type: "A330",
    registrations: "N-3301 to N-3305",
    quantity: "5 Aircraft",
    image: "✈️ A330"
},
{
    name: "Airbus A350-900",
    type: "A350",
    registrations: "N-3501 to N-3503",
    quantity: "3 Aircraft",
    image: "✈️ A350"
}
```

### Adding Boeing aircraft:

```javascript
{
    name: "Boeing 787-9 Dreamliner",
    type: "B787",
    registrations: "N-7870 to N-7875",
    quantity: "6 Aircraft",
    image: "✈️ B787"
},
{
    name: "Boeing 747-8F",
    type: "B744",
    registrations: "N-4470 to N-4472",
    quantity: "3 Aircraft",
    image: "✈️ B748"
}
```

## Using Custom Images

Instead of emojis, you can use URLs to livery images:

```javascript
{
    name: "Airbus A320",
    type: "A320",
    registrations: "N-6001 to N-6010",
    quantity: "10 Aircraft",
    image: "https://example.com/a320-livery.jpg"
}
```

The image will display in a 200px tall box, so use images with appropriate aspect ratios.

## How Many Aircraft Types?

There's no limit! You can add:
- 2-3 types (small airline)
- 5-10 types (medium airline)
- 15+ types (large airline)

## Live Update

When you save `script.js` and refresh your website, your new liveries will appear automatically! No other files need to be edited.

## Tips

✅ **DO:**
- Keep registration numbers consistent (e.g., all starting with N- for US-based)
- Use realistic aircraft types
- Update quantities as you add aircraft
- Keep names simple and clear

❌ **DON'T:**
- Use identical registration numbers
- Add too many registrations (keep it to a range)
- Use unrealistic aircraft types
- Leave fields empty

## Example Complete Array

Here's a full example with multiple aircraft:

```javascript
const aircraftLiveries = [
    {
        name: "Airbus A320",
        type: "A320",
        registrations: "N-6001 to N-6010",
        quantity: "10 Aircraft",
        image: "✈️ A320"
    },
    {
        name: "Airbus A321",
        type: "A321",
        registrations: "N-7101 to N-7108",
        quantity: "8 Aircraft",
        image: "✈️ A321"
    },
    {
        name: "Boeing 737-800",
        type: "B737",
        registrations: "N-3701 to N-3712",
        quantity: "12 Aircraft",
        image: "✈️ B737"
    },
    {
        name: "Boeing 777-300ER",
        type: "B777",
        registrations: "N-8001 to N-8005",
        quantity: "5 Aircraft",
        image: "✈️ B777"
    }
];
```

---

**That's it!** Your new liveries will display instantly on the website. 🚁✈️

