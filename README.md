# Sparkybot v2.0

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![AI Engine](https://img.shields.io/badge/AI-OpenAI-412991?style=flat-square&logo=openai&logoColor=white)](https://openai.com)
[![Standards](https://img.shields.io/badge/Standards-AS%2FNZS_3008_%7C_AS%2FNZS_3000-007ACC?style=flat-square)](https://www.standards.org.au/)

---
<div style="margin-top: 16px; display: flex; justify-content: center; align-items: center; gap: 8px">
    <b style="font-size: 18px; text-align: center;"> Download The App :</b>  
    <span> 
        <a href="https://apps.apple.com/au/app/sparkybot/id6754190924" style="font-size: 16px;">App Store (iOS)</a>
    </span> 
</div>

---

### ◼ About the Project

**Sparkybot** is an AI-driven electrical engineering calculation and compliance platform built specifically for Australian & New Zealand licensed electricians ("sparkies"), contractors, and electrical engineers. It translates complex regulatory standards, notably **AS/NZS 3008:2017** (Selection of Cables) and **AS/NZS 3000:2018** (Wiring Rules), to calculate perfect cable sizing, voltage drop number, and interactive AI technical assistance.

---

### ◼ My Role

Responsible for conducting month-long research on AS/NZS standards with trained professionals, and developing the complete backend API, mathematical calculation engines (similar to JCalc, ELEK), OpenAI assistant integration, and the admin dashboard from scratch.

---

### ◼ Tech Stack

| Category | Technology |
| :--- | :--- |
| **Backend** | Laravel 11.x, PHP 8.2+ |
| **Admin Dashboard** | Blade, Tailwind CSS, Alpine.js, Vite |
| **Frontend (Association)** | Flutter Mobile App (iOS / Android) |
| **Architecture** | Layered Architecture |
| **Design Pattern** | MVC |
| **Database** | MySQL 8.x, Eloquent ORM |
| **AI Engine** | OpenAI API (`gpt-4o` Multimodal Vision & Sizing Engine) |
| **Auth & Security** | `tymon/jwt-auth` (API), `Laravel Breeze` (Admin Session), `Laravel Socialite` (Google OAuth) |

<div style="margin:48px auto;  background-color: #fff8e1; border: 1px solid #ffe082; border-left: 5px solid #ffb300; padding: 14px 18px; border-radius: 8px; color: #5d4037;">
  <strong>⚠️ Note on Confidentiality</strong><br>
  Due to proprietary restrictions, sensitive credentials have been replaced with fake/personal test data, and files containing proprietary business architecture were removed. Modules, sub-modules, and the underlying structure have been retained for inspection & review.
</div>

### ◼ CORE MODULES

`🔴 Cable Sizing` `🔵 AI Electrical Assistant` `🟡 Volt Drop Calculator` `🟣 AS/NZS 3008 Standards`

---

### ◼ FEATURES

- **AI Electrical Assistant:** Solves compliance queries and analyzes field wiring photos via GPT-4o.
- **Cable Sizing Engine:** Computes compliant cable gauges for 1-phase, 3-phase, and DC circuits per AS/NZS 3008.
- **Derating Factor Matrix:** Automated lookup for grouped cables across trays, conduits, cleats, and racks.
- **Volt Drop Calculations:** Real-time absolute and percentage voltage drop checking against regulatory limits.
- **AS/NZS Standards Hub:** Digital wiring rules library with full-text search and clause/page indexing.
- **Admin Management:** In-dashboard reference CRUD, user moderation, and legal CMS configuration.

---

### ◼ History

Originally built as a basic electrical calculator utility in `v1.0`, then upgraded to `v2.0` with multimodal GPT-4o AI analysis, automated AS/NZS 3008 derating matrices, and standards search.

---

### ◼ Impact of this project

- Built for an Australian electrical contracting company to streamline on-site compliance.
- Digitized 500+ pages of AS/NZS regulatory standards into sub-second mobile lookups.
- Automated complex derating and voltage drop formulas to prevent field wiring errors.
- Delivered proven, higher accuracy in specific edge cases over commercial tools (ELEK, JCalc).

---

### ◼ Architecture Highlights

```text
app/
├── Helpers/                  # AS/NZS calculation & impedance tables
│   ├── CableSizeVoltDrops.php
│   ├── CurrentCarryingCapacities.php
│   ├── DeratingFactors.php
│   └── ... ... ...
├── Http/
│   ├── Controllers/
│   │   ├── API/
│   │   │   ├── Ai/ApiAiAnalysisController.php
│   │   │   └── ... ... ...
│   │   ├── CableSizeController.php
│   │   ├── VoltDropController.php
│   │   └── ... ... ...
│   └── Middleware/
├── Models/
│   ├── CableSize.php
│   ├── ReferencePage.php
│   └── ... ... ...
└── ... ... ...

routes/
├── api.php
├── backend.php
└── web.php
... ... ...
```

---

### ◼ Setup

```bash
# 1. Install dependencies
composer install
npm install
npm run build

# 2. Environment & key
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# 3. Database & storage
php artisan migrate --seed
php artisan storage:link

# 4. Run
composer run dev
php artisan queue:work
```

---

### ◼ License

Proprietary. All rights reserved.
