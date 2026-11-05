<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Nome: one Laravel application

The Blade/Alpine frontend and JSON API live together in this application.
Authentication is login-only, with identical features for all users and memo ownership
enforced on every protected endpoint. No roles or approval workflow are implemented.

### Run locally

Run commands from `my-app/`. For an existing installation, keep your current `.env`
and application key:

```sh
composer install
npm ci
php artisan migrate
npm run build
php artisan nome:user your-email@example.com --name="Your Name"
composer dev
```

The account command prompts for a password twice without echoing it or putting it in
shell history. It will not overwrite an existing account. On a fresh checkout, copy
`.env.example` to `.env` and run `php artisan key:generate` before migration.
The browser stores its Bearer token in sessionStorage for the current tab, for at most
seven days. Logout revokes the token and clears the local draft.

The dev command starts the HTTP server, queue worker, Vite and scheduler together.
To run them individually, use separate terminals:

```sh
composer serve
npm run dev
php artisan queue:work --timeout=65 --tries=1
php artisan schedule:work
```

The development server sets upload_max_filesize=100M and post_max_size=110M.
Configure equivalent PHP and HTTP request-body limits on the production host.

### Completion checklist

- [x] Login, current user, logout, seven-day token expiry, login throttling.
- [x] Per-user memo CRUD, UUID URLs, pagination, date/status/search filters.
- [x] Agenda and meeting end time saved in create/update/preview/export.
- [x] Letter metadata and participants; list includes letter number and attendee count.
- [x] Private audio upload with MIME/extension validation and a 100 MiB limit.
- [x] Queued AI submission adapter, status polling, authenticated HMAC callback.
- [x] Duplicate/stale callback protection, timeout recovery, version conflicts.
- [x] Sanitized summary editing and actual PDF/DOCX downloads.
- [x] Frontend uses server data; no simulated login, history or export.
- [x] Unsupported registration/reset/settings flows show account guidance.
- [x] API, JavaScript and browser workflow checks.
- [ ] Supply and verify the actual external AI endpoint, credentials and callback secret.
- [ ] Run an end-to-end test against the real AI service (automated tests mock it).
- [ ] Configure production database, persistent private audio storage, queue worker and scheduler.
- [x] Patched the existing Symfony advisories; Composer reports no known advisories.

### AI adapter boundary

The backend team's handoff defines the callback, but not the AI submission endpoint.
The adapter in `app/Jobs/ProcessAudio.php` makes this explicit:

- `NOME_AI_URL`: exact HTTPS audio-submission URL.
- `NOME_AI_API_KEY`: optional outbound Bearer credential.
- `NOME_WEBHOOK_SECRET`: a strong random secret provisioned separately on both services.
- `NOME_CALLBACK_URL`: externally reachable URL ending in `/api/webhooks/nome-callback`.
- `NOME_JOB_TIMEOUT_MINUTES`: default 120.

The worker sends multipart fields `audio`, `job_id` and `callback_url`, with
`Idempotency-Key: <job_id>`. The AI service must accept our job ID and return promptly
with a 2xx acknowledgement. If the real service uses a different submission contract,
adapt this job after receiving its documentation. The callback sends JSON with
`job_id`, `status`, optional `transcript`, and `structured_minutes` (Markdown, required
on completion). `X-Webhook-Signature` must contain lowercase hexadecimal HMAC SHA-256
of the exact raw JSON bytes using the shared secret. Query-string secrets are rejected.
The frontend never receives the AI key or callback secret.

Without AI configuration, uploading returns 503 and preserves the existing memo.
If a submission fails or its callback times out, the memo becomes `failed` and can
be uploaded again. Previous results survive failures and are replaced only on a
successful new completion. Editing/deletion is blocked during processing.

All meeting wall-clock values use WITA. End time may be earlier than start time
for overnight meetings; this version does not calculate meeting duration.

### API and tests

Import `Notulensi_API.postman_collection.json` into Postman. Supply credentials in
your local environment; do not export populated secrets. Select the audio file
before running. Run with a 5000 ms request delay for bounded status polling.
`simulate_ai=true` enables a signed test-only callback; keep the real worker stopped
for this local simulation. `allow_cleanup=true` enables permanent deletion of the
test memo; it is skipped by default. Logout runs last.

The contract extends the original handoff with `agenda`, `meeting_end_time`,
`letter_number`, `attendees_count`, and integer `version`. Send the last received
version with PUT to reject stale edits (409). Omitting attendees preserves them;
sending an array replaces the complete list. `letter: null` removes the letter.
Summary HTML is sanitized on save and rendering; exports omit styling attributes.

```sh
php artisan test --compact
node --test --experimental-test-coverage tests/js/*.test.js
vendor/bin/pint --test
npm run build
```

The existing Vercel file is not a complete production backend deployment: a temporary
SQLite database and temporary audio filesystem cannot provide durable meeting data,
and a queue worker/scheduler must run outside short-lived requests. Provision a
persistent Laravel host or the necessary managed services before deploying. Configure
APP_KEY and other secrets on the host; no application key is embedded in vercel.json.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
