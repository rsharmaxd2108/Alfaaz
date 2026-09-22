<div align="center">

# دیوانِ الفاظ • Alfaaz
### *Where quiet hearts speak in timeless rhyme.*

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)](https://postgresql.org)
[![Docker](https://img.shields.io/badge/Docker-Alpine-2496ED?style=for-the-badge&logo=docker&logoColor=white)](https://docker.com)
[![Tests](https://img.shields.io/badge/Tests-96%20Passed-2EA44F?style=for-the-badge&logo=githubactions&logoColor=white)](#tests)
[![License](https://img.shields.io/badge/License-MIT-black?style=for-the-badge)](LICENSE)

<br />

> *“Hazaaron khwahishein aisi ki har khwahish pe dam nikle,*  
> *Bahut nikle mere armaan lekin phir bhi kam nikle.”*  
> — **Mirza Ghalib**

<br />

</div>

---

## 📖 About Alfaaz

**Alfaaz** is an elegant, publication-grade literary sanctuary and digital anthology celebrating the depth of Urdu, Hindi, and English poetry. Designed with an editorial aesthetic reminiscent of high-end literary magazines and fine typography, Alfaaz bridges classical masters—from *Mirza Ghalib* and *Faiz Ahmad Faiz* to *Jaun Elia* and *Allama Iqbal*—with the soulful voices of contemporary writers.

Whether you seek solace in verses of heartbreak (*Dard*), the warm light of companionship (*Dosti*), the quiet ecstasy of devotion (*Ishq*), or the stillness of midnight reflection (*Tanhai*), Alfaaz offers an intentional, distraction-free reading sanctuary.

---

## ✨ Key Features

### 🏛️ 1. Curated Explore Feed
- **Masonry Layout**: Adaptive editorial grid showcasing verses categorized by thematic emotion (*Ishq, Dosti, Umeed, Dard, Zindagi, Tanhai*).
- **Author Monogram Badges**: Handcrafted initials and personalized avatar colorways for instant visual attribution.
- **One-Click Couplet Copy**: Seamless clipboard integration with interactive toast feedback for effortless sharing.
- **Typography**: Clean, accessible reading typography powered by `Plus Jakarta Sans` and `Playfair Display`.

### 🌅 2. Sher-e-Roz (Daily Verse)
- **Automatic Daily Calendar Rotation**: Every midnight, a featured couplet takes the stage, complete with poetic era history, biographical context, and a deep reflection essay.
- **Preceding Days Archive**: Browse through past daily verses with full Urdu calligraphy and English translations.

### ✍️ 3. Poet’s Studio & Workspace ("My Desk")
- **Pen New Couplets**: Compose works in Roman Hindi, Urdu script, or English with optional titles (*Unwaan*).
- **Drafts Sanctuary**: Save works-in-progress as private drafts or publish them to the community feed with one click.
- **Personal Literary Metrics**: Live analytics dashboard tracking published works, studio drafts, and appreciations received.

### 💬 4. Community Diwan & Reflections
- **Interactive Reflections Drawer**: Expandable discussion drawers on couplets allowing readers to share notes and critiques.
- **Likes & Saved Couplets**: Heart couplets to express resonance, and bookmark verses to build your personal offline anthology.
- **Admin Moderation Desk**: Integrated editorial moderation console to curate community contributions.

### 🛡️ 5. Production Security & Architecture
- **Dual Authentication**: Native email/password authentication alongside seamless **Google OAuth 2.0 Single Sign-On**.
- **Password Recovery**: Automated password reset tokens dispatched via authenticated SMTP over TLS.
- **Brute-Force Rate Limiting**: Intelligent throttling protecting login, registration, and comment endpoints from spam and credential stuffing.
- **Security Headers**: Production-grade HTTP headers pre-configured (`HSTS`, `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, and strict cookie policies).
- **SEO & PWA**: Dynamic `sitemap.xml`, Open Graph & Twitter Cards, Web App Manifest (`site.webmanifest`), and custom branded error views (404, 500, 403, 419).

---

## 🛠️ Tech Stack

- **Backend**: [Laravel 10.x](https://laravel.com) (PHP 8.2+)
- **Database**: PostgreSQL / MySQL (Database-agnostic migrations)
- **Containerization**: Docker (Alpine Linux + Nginx + PHP-FPM)
- **Authentication**: Laravel Sanctum, Laravel Socialite (Google OAuth)
- **Testing**: PHPUnit (96 automated feature & unit tests, 530 assertions)
- **Frontend**: Blade, Vanilla CSS/JS, SVG Icons, Plus Jakarta Sans, Playfair Display

---

## 🚀 Getting Started Locally

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or PostgreSQL
- Git

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/rsharmaxd2108/Alfaaz.git
   cd Alfaaz
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Configure environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up database in `.env`**:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=alfaaz
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run migrations and seeders**:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

6. **Start development server**:
   ```bash
   php artisan serve
   ```
   Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## 🧪 Running Automated Tests

Alfaaz is built with full test coverage ensuring rock-solid stability across authentication, security, explore feed rotation, comments, and profile management:

```bash
php artisan test
```

```
   PASS  Tests\Feature\AuthFlowTest
   PASS  Tests\Feature\CommentTest
   PASS  Tests\Feature\DailyVerseTest
   PASS  Tests\Feature\DashboardTest
   PASS  Tests\Feature\ErrorPagesAndSeoTest
   PASS  Tests\Feature\ExplorePageTest
   PASS  Tests\Feature\PasswordResetTest
   PASS  Tests\Feature\PrivacyPageTest
   PASS  Tests\Feature\ProfileManagementTest
   PASS  Tests\Feature\SecurityHeadersTest
   PASS  Tests\Feature\WriteAndAuthTest

   Tests:    96 passed (530 assertions)
   Duration: 3.5s
```

---

## 🐳 Docker & Production Deployment

A production-ready `Dockerfile` and `docker/nginx.conf` are included for zero-downtime deployment on **Render**, **Railway**, or any standard container host:

```bash
# Build the Docker image
docker build -t alfaaz:latest .

# Run container locally
docker run -p 8000:80 --env-file .env alfaaz:latest
```

---

## 📜 License

This project is open-source software licensed under the [MIT License](LICENSE).

<br />

<div align="center">
  <sub>Crafted with passion for poetry and fine typography by <a href="https://github.com/rsharmaxd2108">Rahul Sharma</a>.</sub>
</div>
