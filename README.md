# CodeIgniter 4 Application Starter

## Portfolio CMS Overview

This project has been extended into a full personal portfolio with a lightweight CMS:

- Public landing page built with Bootstrap 5 (hero, about, skills, projects, experiences, contact form).
- Timeline aktivitas harian dengan pencarian, filter kategori & rentang tanggal, sorting terbaru/terlama, serta pagination (10 item per halaman).
- Biodata/CV modern lengkap dengan foto profil, kontak, media sosial, progress bar keahlian, dan tombol download CV (PDF).
- Riwayat pendidikan vertikal dengan filter jenjang, pencarian institusi, sorting tahun, dan pagination.
- Admin dashboard with CRUD untuk aktivitas harian (bulk delete + ekspor CSV/Excel), biodata (preview & backup/restore), projects, skills, educations, experiences, dan key/value settings.
- Session-based authentication dengan role `admin`, CSRF protection, automatic output escaping, and file uploads stored under `public/uploads`.
- Contact form submissions are persisted so you can follow up from the CMS.
- Tema frontend kini memiliki **dark/light mode toggle**, tombol language switcher (ID/EN), meta tags SEO, serta dukungan Google Analytics (isi Measurement ID dari menu Settings).
- Sistem caching untuk homepage/contacts + database indexing agar query filters lebih cepat.
- Admin panel otomatis membuat **activity logs** dan menyediakan halaman monitoring khusus.
- Menu **Backups** + perintah `php spark portfolio:backup` untuk membuat arsip JSON seluruh tabel (siap dijalankan via cron).
- REST API read-only: `/api/portfolio/{activities|biodata|educations|projects|skills}`.
- Form kontak langsung mengirim email notifikasi (gunakan alamat di pengaturan contact email).

### Quick Start

1. Ensure PHP 8.1+, Composer, and MySQL/MariaDB are installed and running.
2. Copy `env` to `.env` and update the `database.default.*` values (defaults assume `portfolio_cms` on `root@127.0.0.1` with blank password).
3. Create the database manually if it does not exist yet: `CREATE DATABASE portfolio_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`.
4. Install dependencies and run database migrations + seeders (or `php spark migrate --seed` in one shot):

   ```bash
   composer install
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

5. Make sure `public/uploads/projects` is writable by the web server for image uploads.
6. Serve the site with `php spark serve` (default at http://localhost:8080) or configure your web server's document root to point at the `public/` directory.

### REST API

Semua endpoint merespons JSON dan menerima filter dasar via query string:

| Endpoint | Deskripsi |
| --- | --- |
| `GET /api/portfolio/activities` | Daftar aktivitas harian (keyword, category, start_date, end_date, per_page, page). |
| `GET /api/portfolio/biodata` | Data biodata + skills snapshot + social links. |
| `GET /api/portfolio/educations` | Riwayat pendidikan (urut tahun). |
| `GET /api/portfolio/projects` | Seluruh proyek CMS. |
| `GET /api/portfolio/skills` | Daftar skills dengan kategori/level. |

Tambahkan query `per_page` (max 50) & `page` untuk pagination JSON.

### Backup & Restore

- Jalankan `php spark portfolio:backup` untuk membuat arsip `.zip` (tersimpan di `writable/backups` dan dicatat pada activity log).
- Dari panel admin buka menu **Backups** untuk melihat riwayat file dan tombol "Generate & Download".
- Biodata memiliki backup JSON khusus (menu Biodata → Backup JSON) plus restore.

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

