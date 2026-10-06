# AI Agent & Skill Guidelines

Welcome to the project workspace. This project centers on a modern **Laravel application (`my-app`)** with real-time **WebSocket / Event Broadcasting** features, paired with a modern JavaScript frontend.

---

## 🛠️ Installed AI Skills

The following skills are configured in [`.agents/skills/`](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills) and can be invoked on-demand:

| Skill | Path | Primary Focus | Trigger Keywords |
|-------|------|---------------|------------------|
| **`laravel-specialist`** | [SKILL.md](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/laravel-specialist/SKILL.md) | Laravel 10/11+, Eloquent ORM, Migrations, Artisan, Sanctum Auth, Queues, Pest/PHPUnit | `Laravel`, `Eloquent`, `Artisan`, `PHP`, `Migration`, `Sanctum`, `Blade`, `Pest` |
| **`websocket-engineer`** | [SKILL.md](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/websocket-engineer/SKILL.md) | Real-time bidirectional communication, Laravel Reverb / Echo, Socket.IO, Redis Pub/Sub, Presence Channels | `WebSocket`, `Reverb`, `Echo`, `Socket.IO`, `real-time`, `broadcasting`, `presence`, `channels` |
| **`javascript-pro`** | [SKILL.md](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/javascript-pro/SKILL.md) | Modern ES2023+, Vite tooling, asynchronous flows, browser APIs, client-side WebSocket clients | `JavaScript`, `ESM`, `Vite`, `async/await`, `client-side`, `frontend`, `Node` |
| **`debugging-wizard`** | [SKILL.md](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/debugging-wizard/SKILL.md) | Root cause investigation, error parsing, stack traces, log correlation, hypothesis testing | `debug`, `error`, `bug`, `fix issue`, `traceback`, `troubleshoot`, `not working` |
| **`code-reviewer`** | [SKILL.md](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/code-reviewer/SKILL.md) | Code quality, security audits (XSS, SQLi), N+1 query detection, PSR-12, architectural review | `review`, `code review`, `audit`, `PR review`, `code quality`, `refactor check` |
| **`code-documenter`** | [SKILL.md](file:///Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/code-documenter/SKILL.md) | Docblocks, OpenAPI/Swagger specifications, architectural guides, READMEs, onboarding documentation | `documentation`, `document`, `docblock`, `OpenAPI`, `Swagger`, `API docs` |

---

## 🎯 How to Invoke Skills

You can call or request any skill in multiple ways before or during any prompt:

1. **Direct Mention:**
   - `"Use the laravel-specialist skill to create a chat room model with migrations."`
   - `"Call websocket-engineer to set up Laravel Reverb event broadcasting."`
   - `"/skill laravel-specialist"` or `"/skill websocket-engineer"`

2. **Keyword Auto-Activation:**
   - When your prompt mentions topics like *"set up WebSocket"*, the agent will automatically read and apply the guidelines from [`.agents/skills/websocket-engineer/SKILL.md`](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/websocket-engineer/SKILL.md).
   - When asking about Eloquent models, controllers, or database migrations, the agent will load [`.agents/skills/laravel-specialist/SKILL.md`](file:///Users/andiabi4925/Documents/campus/Rekayasa%20Perangkat%20Lunak/.agents/skills/laravel-specialist/SKILL.md).

---

## 🏗️ Project Architecture & Stack

- **Backend Application:** `my-app` (Laravel Framework, PHP 8.3+)
- **Frontend / Asset Bundler:** Vite + Tailwind CSS v4
- **Real-Time Layer:** Laravel Event Broadcasting (Laravel Reverb / Pusher-compatible protocol / Laravel Echo)
- **Database & Storage:** Eloquent ORM with migrations, SQLite / MySQL / PostgreSQL support
- **Testing Suite:** PHPUnit / Pest (`php artisan test`)
- **Code Style:** PSR-12 standard, formatted via Laravel Pint (`./vendor/bin/pint`)

---

## ⚡ Agent Execution Rules

1. **Always read the relevant `SKILL.md`** before implementing major features or troubleshooting.
2. **Never guess paths or commands:** Work inside `my-app/` for artisan and composer commands.
3. **Prevent N+1 Queries:** Always eager load relationships (`with()`) as instructed by `laravel-specialist`.
4. **Secure Broadcasting:** Authenticate all private and presence channels via `routes/channels.php`.
5. **Lint and Test:** Always run tests (`php artisan test`) and linting (`./vendor/bin/pint --test`) to confirm changes before finishing.
