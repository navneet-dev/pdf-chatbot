# PDF Chatbot

> A small Laravel + Livewire application that extracts text from uploaded PDFs and uses Google Gemini (Generative Language API) to answer user questions based only on the PDF contents.

## Features

- Upload a PDF and extract its text
- Ask natural-language questions about the PDF
- Answers are generated from the PDF content via Gemini; if an answer is not present, the app replies: "I could not find that in the uploaded PDF."

## Requirements

- PHP 8.1+
- Composer
- Node.js (16+) and npm
- SQLite / MySQL / Postgres (optional — only if you use DB features)
- A Google Generative Language API key (Gemini)

## Quick Start

1. Clone the repository and change into the project directory:

```bash
git clone <repo-url>
cd pdf-chatbot
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install JavaScript dependencies and build assets (development):

```bash
npm install
npm run dev
```

4. Copy the example env and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure environment variables in `.env`:

- `APP_URL` — your app URL (e.g. `http://localhost:8000`)
- Database settings if you plan to use a DB
- `GEMINI_API_KEY` — your Google Generative Language API key

GeminiService reads the API key from `config('services.gemini.api_key')`. Ensure your `config/services.php` includes an entry like:

```php
'gemini' => [
    'api_key' => env('GEMINI_API_KEY'),
],
```

6. (Optional) Run migrations and create storage symlink:

```bash
php artisan migrate
php artisan storage:link
```

7. Serve the application:

```bash
php artisan serve
```

Open your browser at `http://localhost:8000` — the root route returns the chatbot UI (see `resources/views/chatbot.blade.php`).

## Important Files

- `app/Livewire/PdfChatbot.php` — Livewire component handling uploads and interactions
- `app/Services/GeminiService.php` — sends prompts to the Gemini API
- `resources/views/chatbot.blade.php` — main frontend view served at `/`

## Usage Notes

- The app builds a prompt containing the extracted PDF text and the user question, then posts to the Gemini endpoint. Responses are displayed in the UI.
- If the Gemini API key is missing, the service will throw a runtime exception instructing you to add `GEMINI_API_KEY` to your `.env`.

## Troubleshooting

- "Gemini API key is missing": add `GEMINI_API_KEY` to `.env` and restart the server.
- API request failures: check your network, quota, and that the API key is enabled for the Generative Language API.
- Long PDFs or large prompts may hit timeouts — adjust the HTTP timeout in `GeminiService` if needed.

## Contributing

Contributions are welcome. Please open an issue or submit a pull request describing your change.

## License

This project is provided under the MIT License.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

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

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
