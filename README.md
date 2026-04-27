# Falcones Capital

A web application for a proprietary trading firm where skilled traders apply for funding up to $300,000. Traders pass an evaluation challenge to receive a funded account and earn a percentage of the profits while trading with the firm's capital.

## What This Website Contains

The website includes nine functional pages organized into three sections:

### Public Pages

- **Home** — Landing page with key statistics, featured packages, and trader testimonials
- **Challenges** — Browse six account sizes from $5K to $200K with sorting and filtering options
- **Trading Rules** — Detailed parameters table, allowed and prohibited strategies, drawdown explanations
- **About Us** — Company mission, values, statistics, and timeline
- **FAQ** — Frequently asked questions organized in four categories with accordion interface
- **Contact** — Contact form with server-side validation for name, email, and phone

### Authentication

- **Login** — Sign in page with "Remember me" functionality (30-day cookie)
- **Logout** — Securely ends the session and clears cookies

### Role-Based Dashboard

- **Admin Dashboard** — Platform overview with traders list, statistics, and contact messages
- **Trader Dashboard** — Personal account info, payout history, and quick access to new challenges

## User Roles

The platform supports two user types:

- **Administrator** — Full platform visibility, can view all traders and messages
- **Trader** — Personal dashboard with account stats and payout history

## Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Administrator | `admin@falcones.com` | `admin123` |
| Trader | `trader@falcones.com` | `trader123` |

---

## Video Tutorial

A complete walkthrough demonstrating all the website features including login, role-based dashboards, server-side validation, sorting, and the contact form.

<video src="docs/demo.mp4" controls width="800">
  Your browser does not support the video tag.
  <a href="docs/demo.mp4">Download the video instead</a>.
</video>

> If the video does not play, [click here to download it](docs/demo.mp4).

---

## Installation and Setup

### Requirements

- A local web server with **PHP 7.4 or higher** (XAMPP, WAMP, MAMP, or Laragon)
- A modern web browser

### Installation Steps

**1. Download or clone the repository**

```bash
git clone https://github.com/gjelbrimmorina/falcones-capital-php.git
```

Or download as ZIP from GitHub.

**2. Move the project to your web server directory**

For XAMPP:
- Windows: `C:\xampp\htdocs\falcones-capital-php\`
- macOS: `/Applications/XAMPP/htdocs/falcones-capital-php/`
- Linux: `/opt/lampp/htdocs/falcones-capital-php/`

**3. Start Apache** from the XAMPP Control Panel

**4. Verify the configuration**

Open `includes/config.php` and check that `BASE_URL` matches your folder name:

```php
$GLOBALS['BASE_URL'] = '/falcones-capital-php';
```

**5. Open the website**

Navigate to `http://localhost/falcones-capital-php/` in your browser.

**6. Test login**

Click "Sign In" and use one of the demo credentials above.

---

## Troubleshooting

| Problem | Solution |
|---------|----------|
| Apache won't start | Port 80 may be in use. Change to port 8080 in `httpd.conf` |
| Page shows PHP code | Apache is not running. Start it from XAMPP Control Panel |
| Pages have no styling | Update `BASE_URL` in `includes/config.php` to match your folder name |
| Login doesn't work | Allow cookies for localhost in browser settings |

---

## Built With

- **PHP** for server-side logic and dynamic content
- **HTML and CSS** for structure and styling
- **JavaScript** for interactive elements
- **Font Awesome** for icons
- **Google Fonts (Inter)** for typography

The website is fully responsive and works on desktop, tablet, and mobile devices.
