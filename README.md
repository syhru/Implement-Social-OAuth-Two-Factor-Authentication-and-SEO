# Blog Auth — Social OAuth, 2FA OTP & SEO Management

A Laravel 12 blog system featuring **Google/Facebook OAuth**, **Two-Factor Authentication (OTP via Mailtrap API)**, **SEO Automation**, and a **Tailwind CSS Admin Panel**.

---

## ✨ Features

| Feature                  | Description                                                     |
| ------------------------ | --------------------------------------------------------------- |
| **Social OAuth**         | Login via Google & Facebook using Laravel Socialite             |
| **2FA OTP Verification** | OTP code sent via Mailtrap Email API (HTTPS) — ISP-proof        |
| **Admin Panel**          | CRUD for Posts, Categories, Tags with Tailwind CSS              |
| **SEO Automation**       | Auto-generated meta title, meta description, and slug           |
| **XML Sitemap**          | Dynamic sitemap at `/sitemap.xml`                               |
| **Blog Frontend**        | Public blog with search, category filter, and comments          |
| **Role-Based Access**    | Admin-only dashboard with `auth`, `2fa`, and `admin` middleware |

---

## 🛠 Tech Stack

- **Backend:** PHP 8.2+, Laravel 12
- **Frontend:** Tailwind CSS (CDN)
- **Database:** PostgreSQL
- **Auth:** Laravel Socialite (Google/Facebook)
- **Email:** Mailtrap Email API via `railsware/mailtrap-php`
- **Queue:** Sync (instant OTP delivery)

---

## 📦 Installation

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd tugas-Implement-Social-OAuth-Two-Factor-Authentication-and-SEO-Management

composer install
npm install
```

### 2. Configure Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your credentials:

```env
# Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback

# Mailtrap API (for OTP emails)
MAIL_MAILER=mailtrap
MAILTRAP_API_KEY=your_mailtrap_api_key
MAILTRAP_INBOX_ID=your_inbox_id

# OTP
OTP_EXPIRY_MINUTES=60
QUEUE_CONNECTION=sync
```

### 3. Migrate & Seed Database

```bash
php artisan migrate --seed
```

This creates:

- 1 Admin user
- 5 Categories (Teknologi, Programming, Cloud Computing, AI, Cyber Security)
- 10 Tags (Laravel, Python, AWS, Docker, etc.)

### 4. Run Development Server

```bash
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000) → redirects to `/blog`

---

## 🔐 Authentication Flow

```
User clicks "Login with Google"
    → Google OAuth redirect
    → Callback: user created/found
    → If admin (2FA enabled):
        → OTP generated & sent via Mailtrap API
        → Redirect to /otp/verify
        → Enter 6-digit code → Dashboard
    → If regular user:
        → Redirect to /blog
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   │   ├── SocialAuthController.php   # OAuth login
│   │   │   └── OtpController.php          # OTP verify/resend
│   │   ├── Admin/
│   │   │   ├── PostController.php         # CRUD posts
│   │   │   ├── CategoryController.php     # CRUD categories
│   │   │   └── TagController.php          # CRUD tags
│   │   ├── BlogController.php             # Public blog
│   │   ├── CommentController.php          # Comments
│   │   └── SitemapController.php          # XML sitemap
│   └── Middleware/
│       ├── EnsureTwoFactorVerified.php    # 2FA guard
│       └── IsAdmin.php                    # Admin guard
├── Models/
├── Notifications/
│   └── SendOtpCode.php                    # OTP email
├── Providers/
│   └── MailtrapServiceProvider.php        # Mailtrap API transport
└── Services/
    └── OtpService.php                     # OTP generate/verify
```

---

## 🧪 Admin Access

- **Login:** Via Google OAuth only
- **2FA:** Required (OTP via email)


---

## 📝 License

This project is for educational purposes.
