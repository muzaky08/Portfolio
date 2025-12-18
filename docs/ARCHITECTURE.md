# Portfolio CMS Architecture

## Overview
A modular CodeIgniter 4 application that powers a public-facing portfolio website and an admin-only CMS. The stack combines Bootstrap 5 for responsive UI, MySQL/MariaDB for persistence, and CodeIgniter sessions + CSRF for security.

## Modules
- **Frontend (`app/Controllers/Frontend`, `app/Views/frontend`)**: Public landing page, skills, projects, and contact form.
- **Admin CMS (`app/Controllers/Admin`, `app/Views/admin`)**: Authenticated dashboard dengan modul Projects, Skills, Experiences, Activities, Educations, Profile (biodata), Settings, dan contact messages.
- **Timeline Data (`App\Models\ActivityModel`, `App\Models\EducationModel`)**: Provides filtered/paginated builders for the activity log & education history displayed on the homepage.
- **Domain Layer (`app/Models`, `app/Services`)**: Reusable models plus `PortfolioService` to aggregate sections for the homepage.
- **Filters & Helpers (`app/Filters`)**: `AuthFilter`/`GuestFilter` secure admin routes; upload helpers live inside controllers.

## Database Schema
| Table | Highlights |
| --- | --- |
| `users` | Admin identity with hashed passwords, role, and audit fields. |
| `settings` | Key/value store for hero/about/contact/social content, grouped by section. |
| `skills` | Skill name, category, level %, optional description. |
| `projects` | Title, slug, summary, description, technologies, optional image + URL, featured flag. |
| `experiences` | Role, company, location, start/end dates, description, current flag. |
| `messages` | Contact submissions (name, email, subject, message, read status). |
| `activities` | Daily log (title, description, date, location, category, icon) powering the frontend timeline & filters. |
| `educations` | Vertical timeline items with institution, level, major, years, and notes. |
| `profile` | Single-record biodata including contact fields, photo, CV path, and social links. |

Every table includes `created_at`/`updated_at`, with soft deletes where relevant to simplify history tracking.

## Security & Auth
- Session-based login for admins (username/email + password) handled by `AuthController` and `UserModel`.
- Middleware-level guards through `AuthFilter`/`GuestFilter` (configured in `app/Config/Filters.php`).
- Global CSRF protection enabled via `.env` plus `csrf_field()` on all forms.
- Views escape output with `esc()` and interactions go through the Query Builder to prevent SQL injection.

## Frontend Experience
- Sections: hero, about, biodata/CV (photo, contacts, download button), activity timeline with search/filter/pagination, education timeline, skills, projects, experiences, and contact form.
- `PortfolioService` collects data so the controller stays thin, including helpers for paginated activities/educations.
- Bootstrap 5 + custom CSS (`public/assets/css/frontend.css`) for the professional look.

## Admin Experience
- Dashboard cards summarizing counts/unread messages, recent projects/messages list.
- CRUD pages with Bootstrap tables/forms for projects, skills, and experiences.
- Settings form groups fields by Hero/About/Contact/Social/SEO, saved via the key/value store.
- Contact inbox with read/unread state and deletion workflow.

## Deployment Notes
1. Copy `env` to `.env`, configure DB credentials, and create the schema.
2. Run `php spark migrate --seed` to build baseline data (default admin user included).
3. Ensure `public/uploads/projects` is writable for file uploads, then serve `public/` via Apache/Nginx or `php spark serve`.
