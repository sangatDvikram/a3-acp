# A3 Ultimate — Game Portal

A PHP-based web portal for the **A3 Ultimate** private game server. The portal handles player
registration and authentication, in-game character and inventory management, a virtual item
shop with real-money payment processing, an admin control panel (ACP), game statistics, and
an integrated bug/support-ticket tracker.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Technology Stack](#2-technology-stack)
3. [Folder Structure](#3-folder-structure)
4. [Environment Configuration](#4-environment-configuration)
5. [Setup & Running Locally](#5-setup--running-locally)

---

## 1. Project Overview

| Feature | Description |
|---|---|
| **Player portal** | Registration, login, email verification, forgot-password flow |
| **Account management** | Profile editing, transaction-password vault, secret Q&A |
| **Character management** | View/edit game characters, rebirths, stats, inventory |
| **Virtual shop (e-Shop)** | Purchase in-game currency and items |
| **Payment gateways** | PayU Money (live + sandbox) and PayPal IPN |
| **Admin Control Panel** | `acp.php` + `beta/` CI app — manage accounts, characters, logs |
| **Game statistics** | Leaderboards, kill counts, rebirth stats, online-player counts |
| **Bug / support tracker** | MantisBT instance at `beta/bugs/` |
| **Geekstoy sub-app** | Separate login endpoint at `geekstoy/` |

---

## 2. Technology Stack

### Back-end
| Technology | Role |
|---|---|
| **PHP 5.6.40** | Primary server-side language for the portal |
| **CodeIgniter 2.x** | MVC framework powering the `beta/` application |
| **ODBC / SQL Server** | Primary game database (`webasdOdbc`, `webasdItemEvent` DSNs) |
| **MySQL / MariaDB** | Auxiliary ACP database |
| **PDO** | Database abstraction layer (`conn/`, `inc/`, `ultimate_classes/`) |
| **PHPMailer** | Transactional email (registration, password reset, notifications) |
| **MantisBT** | Bug and support-ticket tracker (`beta/bugs/`) |
| **PayU Money** | Indian payment gateway — live and sandbox modes |
| **PayPal IPN** | PayPal Instant Payment Notification listener |
| **reCAPTCHA v1** | Bot protection on registration and lost-password forms |

### Front-end
| Technology | Role |
|---|---|
| **Bootstrap 2.x** | Responsive CSS grid and UI components |
| **jQuery** (1.4.x – 1.9.x) | DOM manipulation, AJAX, UI widgets |
| **Kendo UI** (`kendo.all.min.js`) | Rich form widgets (date pickers, text boxes) |
| **jQuery Lightbox** | Image gallery pop-ups |
| **jQuery mCustomScrollbar** | Custom scroll bars |
| **Prettify** | Syntax highlighting |
| **Fireworks JS** | Particle animation effects |
| **Custom fonts** | Qlassik, Calibri, Candara, Ubuntu (served from `css/` and `Fonts/`) |

---

## 3. Folder Structure

```
htdocs/                          ← Apache document root (repository root)
│
├── beta/                        ← CodeIgniter 2.x application (admin panel + beta features)
│   ├── application/             ← CI controllers, models, views, helpers, config
│   │   ├── config/              ← database.php, paypal_ipn.php, routes.php, etc.
│   │   ├── controllers/         ← acp, admin, eshop, game, payment, paypalipn, …
│   │   ├── models/              ← Database models (login, admin, crafting, IPN, …)
│   │   ├── views/               ← HTML templates (admin, eshop, game, email, …)
│   │   └── logs/                ← ⚠ Runtime CI logs — may contain PII; apply retention policy
│   ├── bugs/                    ← MantisBT bug tracker (full standalone installation)
│   └── system/                  ← CodeIgniter core framework files
│
├── conn/                        ← Standalone PDO connection helpers
│   ├── pdoclass.php             ← MySQL PDO wrapper (credentials via env vars)
│   ├── pdombody.php             ← PDO query body builder
│   └── pdoquery.php             ← PDO query executor
│
├── inc/                         ← Shared includes for the portal
│   ├── config.php               ← Master bootstrap: ODBC + MySQL connections, session start
│   ├── functions.php            ← Core helper functions (antisql, checkPwd, log_action, …)
│   ├── secondary_functions.php  ← Additional utility functions
│   ├── class.MySqlDatabase.php  ← MySQL PDO wrapper class
│   ├── class.session.php        ← Custom session handler
│   ├── class.phpmailer.php      ← PHPMailer (portal copy)
│   ├── form_functions.php       ← Form validation helpers
│   └── pdoclass.php             ← Alternate PDO bootstrap (credentials via env vars)
│
├── Payu/                        ← PayU Money payment gateway integration
│   ├── index.php                ← Payment initiation (live)
│   ├── index1.php               ← Payment initiation (sandbox/test)
│   ├── success.php              ← Payment success handler
│   ├── failure.php              ← Payment failure handler
│   └── button.php               ← PayU pay-button helper
│
├── testpaypal/                  ← PayPal Standard / IPN integration
│   ├── plans.php                ← Product/plan listing
│   ├── ipn.php                  ← IPN endpoint
│   ├── ipnlistener.php          ← IPN listener library
│   ├── payments.php             ← Payment processing logic
│   ├── success.php              ← Payment success page
│   └── cancel.php               ← Payment cancellation page
│
├── geekstoy/                    ← Geekstoy sub-application
│   └── login.php                ← API-key-protected login endpoint (key via env var)
│
├── ultimate_classes/            ← Shared PHP class library
│   ├── class.Dbconnections.php  ← Fluent PDO query builder (ODBC + MySQL)
│   ├── class.Gallery.php        ← Image gallery helper
│   ├── class.ImageUpload.php    ← File-upload handler
│   └── class.LoginRestart.php   ← Session restart helper
│
├── Stats/                       ← Public game statistics pages
│   ├── index.html               ← Stats landing page
│   ├── stats.php                ← General statistics
│   ├── killer.php / pvpkiller.php ← PvP kill rankings
│   ├── hero.php / bhero.php     ← Hero leaderboards
│   └── toonline.php             ← Online player count
│
├── userlogs/                    ← ⚠ Flat-file audit logs (by year, category)
│   ├── 2013/ … 2018/            ←   Historical logs — apply retention & scrub policy
│   ├── Auction/, Gold/, RB/, …  ←   Action-specific log directories
│   └── LevelUpLog/, Storage/    ←   More action categories
│
├── css/                         ← Global stylesheets and webfonts
├── js/                          ← Global JavaScript libraries and custom scripts
├── images/ img/ allitems/       ← Static image assets
├── Fonts/                       ← Webfont files (TTF, OTF, WOFF)
├── phpmailer/                   ← PHPMailer library (root-level copy)
├── dashboard/                   ← XAMPP welcome dashboard (do not deploy publicly)
├── tools/                       ← Internal API tools (report generation, PK tools)
│
├── login.php                    ← Player login
├── register.php                 ← New account registration
├── logout.php                   ← Session teardown
├── forgot-password.php          ← Password reset via email
├── verifyemail.php              ← Email verification link handler
├── profile.php                  ← Player profile / password change
├── eacct.php                    ← Admin: edit account
├── echar.php                    ← Admin: edit character
├── acct.php / vacct.php         ← View account (player / admin)
├── char.php / vchar.php         ← View character (player / admin)
├── acp.php                      ← Admin control panel entry point
├── inventory.php                ← Player inventory viewer
├── skills.php                   ← Character skill viewer
├── rb.php                       ← Rebirth info
├── onlinepoints.php             ← Online-time reward system
├── paypal_payments.php          ← PayPal payment entry (root-level)
├── index.php                    ← Portal home page
├── header.php / footer.php      ← Shared layout partials
├── session.php                  ← Session bootstrap include
├── composer.json                ← Composer dependency manifest
├── .env.example                 ← ✅ Environment variable template (commit this)
├── web.config                   ← IIS / Apache URL rewrite rules
└── LICENSE                      ← Project licence
```

> **⚠ Log directories** — `userlogs/` and `beta/application/logs/` are written to at
> runtime and may contain personal data captured before the current security hardening was
> applied. These directories should be moved outside the web root and a log-rotation /
> retention policy should be established before going to production.

---

## 4. Environment Configuration

All database credentials, API keys, and other secrets are read from environment variables at
runtime via `getenv()`. **No secrets are hardcoded in source files.**

### Setup steps

```bash
# 1. Copy the template
cp .env.example .env

# 2. Open .env in a text editor and fill in every value
notepad .env          # Windows
```

Never commit `.env` to version control. Confirm that `.env` is listed in `.gitignore`.

### Environment variable groups

| Group | Variables | Used by |
|---|---|---|
| **ODBC / SQL Server** | `ODBC_DB_USERNAME`, `ODBC_DB_PASSWORD` | `inc/config.php`, `ultimate_classes/class.Dbconnections.php`, `beta/application/config/database.php` |
| **MySQL (ACP)** | `MYSQL_DB_HOST`, `MYSQL_DB_NAME`, `MYSQL_DB_USERNAME`, `MYSQL_DB_PASSWORD` | `inc/config.php`, `conn/pdoclass.php`, `inc/pdoclass.php`, `beta/application/config/database.php` |
| **PayU Live** | `PAYU_MERCHANT_KEY`, `PAYU_SALT` | `Payu/index.php`, `Payu/success.php`, `Payu/failure.php` |
| **PayU Sandbox** | `PAYU_TEST_MERCHANT_KEY`, `PAYU_TEST_SALT` | `Payu/index1.php` |
| **PayPal** | `PAYPAL_EMAIL`, `PAYPAL_SANDBOX_EMAIL`, `PAYPAL_ADMIN_EMAIL` | `testpaypal/`, `beta/application/config/paypal_ipn.php` |
| **Geekstoy** | `GEEKSTOY_SEC_KEY`, `GEEKSTOY_DB_USERNAME`, `GEEKSTOY_DB_PASSWORD` | `geekstoy/login.php` |
| **Support contact** | `SUPPORT_PHONE` | `Payu/failure.php`, `register.php` |

See `.env.example` for full documentation of every variable.

---

## 5. Setup & Running Locally

### Prerequisites

| Software | Recommended version | Notes |
|---|---|---|
| XAMPP | 5.6.x (`xampp2`) — PHP **5.6.40** | Bundles Apache, PHP, MySQL |
| SQL Server (or compatible) | Any | Required for the ODBC game DB |
| ODBC Driver for SQL Server | 17 or 18 | Windows ODBC Data Source Administrator |
| Composer | Latest | PHP dependency manager |

### Step 1 — Install XAMPP

Download XAMPP from <https://www.apachefriends.org/> and install it. The default installation
path on Windows is `C:\xampp`. This repository lives inside the `htdocs` directory of your
XAMPP installation.

### Step 2 — Configure ODBC DSNs

The game database is accessed over ODBC. You must create two **System DSNs** in the Windows
ODBC Data Source Administrator (`odbcad32.exe`):

| DSN name | Points to |
|---|---|
| `webasdOdbc` | Primary game SQL Server database |
| `webasdItemEvent` | Item-event SQL Server database |

Use the **SQL Server Native Client** or **ODBC Driver 17/18 for SQL Server** driver. An
`.reg` file (`odbc Ultimate.reg`) is included in the repository root as a reference for the
required registry keys — review it before importing.

### Step 3 — Configure MySQL

1. Start XAMPP and open **phpMyAdmin** at `http://localhost/phpmyadmin`.
2. Create a database named `a3acp` (or the name set in `MYSQL_DB_NAME`).
3. Import any provided SQL schema dumps.
4. Create a MySQL user with full privileges on that database.

### Step 4 — Create the `.env` file

```bash
cd C:\xampp\htdocs      # adjust path to your XAMPP installation
copy .env.example .env
```

Open `.env` and fill in every value. At minimum you need:

```ini
ODBC_DB_USERNAME=sa
ODBC_DB_PASSWORD=<your SQL Server password>

MYSQL_DB_HOST=localhost
MYSQL_DB_NAME=a3acp
MYSQL_DB_USERNAME=<your MySQL user>
MYSQL_DB_PASSWORD=<your MySQL password>

SUPPORT_PHONE=<your support line>
```

### Step 5 — Install Composer dependencies

```bash
cd C:\xampp\htdocs
composer install
```

### Step 6 — Configure Apache to load `.env`

PHP's `getenv()` reads from the system environment and from Apache's `SetEnv` directive.
Add the following block to your Apache `VirtualHost` (or to `httpd-vhosts.conf`) and reload
Apache:

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost

    # Load .env values into the environment
    SetEnvFile "C:/xampp/htdocs/.env"

    <Directory "C:/xampp/htdocs">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

> **Alternative:** Use a PHP bootstrap file that calls `putenv()` for each variable,
> or use a library such as `vlucas/phpdotenv` (already in `composer.json` if present).

### Step 7 — Start XAMPP and verify

1. Open the XAMPP Control Panel and **Start** Apache and MySQL.
2. Navigate to `http://localhost/` — the portal home page should load.
3. Navigate to `http://localhost/beta/` — the CodeIgniter admin app.
4. Navigate to `http://localhost/beta/bugs/` — the MantisBT tracker.
5. Check `http://localhost/dashboard/phpinfo.php` to confirm the PHP version and loaded
   extensions (`pdo`, `pdo_mysql`, `odbc`).

### Troubleshooting

| Symptom | Likely cause |
|---|---|
| "Sorry Not able to connect to mysql database!!" | MySQL not running, or wrong `MYSQL_DB_*` env vars |
| "Sorry Not able to connect to odbc database!!" | DSN not created, or wrong `ODBC_DB_*` env vars |
| Blank page / no output | `display_errors` is `0` in `config.php`; check Apache error log |
| `getenv()` returns `false` | `.env` values not loaded into the Apache environment |
| PayU hash mismatch | `PAYU_SALT` or `PAYU_MERCHANT_KEY` incorrect |

