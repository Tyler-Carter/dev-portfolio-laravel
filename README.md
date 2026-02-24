# Dev Portfolio Platform (Laravel + React)

A production-ready, full-stack portfolio platform designed to showcase a developer's brand, capture inbound opportunities, and provide an authenticated admin workspace for content and site management.

This repository demonstrates practical software engineering skills across:
- **Backend API design** (Laravel 8 + JWT auth)
- **Admin-grade CRUD workflows** (projects, skills, experience, education, services, messages)
- **Containerized development and deployment** (Docker Compose + Render)
- **CI/CD automation** (GitHub Actions + post-deploy migration orchestration)

---

## Why this project is relevant to employers

This codebase is positioned as more than a portfolio website; it is an **operations-aware web product** with:
- API versioning and route organization (`/api/v1/...`)
- Authenticated administrative surface protected by JWT middleware
- Deployment-aware workflow with explicit migration gating after production deploy
- Environment-specific Docker workflows for dev and prod-like parity

---

## Core Features

### Public-facing portfolio experience
- Home/landing route and downloadable CV endpoint
- Contact submission endpoint
- Frontend projects feed endpoint
- Optional pixel tracking endpoint

### Admin platform capabilities
- JWT-based login + token refresh
- Profile (`/me`) and stats endpoints
- Configurable site settings (logo/favicon/mail settings)
- CRUD management for:
    - Skills
    - Education
    - Experience
    - Projects
    - Services
    - Messages
- Visitor statistics endpoints

### Operational tooling
- CI on pull requests and pushes to `main`
- Render deployment monitoring before migration execution
- One-off post-deploy migration job
- Local Docker workflows for development and production simulation

---

## Architecture Snapshot

```text
GitHub Push / PR
        │
        ▼
GitHub Actions CI
        │
        ├── PR: Validate build/dependencies
        └── main: Validate → wait for Render deploy live
                              │
                              ▼
                     Run one-off migration job
```

---

- **Backend:** PHP 8.3 (platform target), Laravel 8
- **Auth:** `tymon/jwt-auth`
- **Frontend libraries:** React 17, Ant Design ecosystem
- **Build tooling:** Laravel Mix 6
- **Containerization:** Docker + Docker Compose
- **Deployment target:** Render
- **CI/CD:** GitHub Actions

---

## References

- Laravel documentation: https://laravel.com/docs/8.x
- Laravel routing: https://laravel.com/docs/8.x/routing
- Laravel middleware: https://laravel.com/docs/8.x/middleware
- Laravel deployment: https://laravel.com/docs/8.x/deployment
- JWT package for Laravel (`tymon/jwt-auth`): https://jwt-auth.readthedocs.io/en/develop/
- React documentation: https://react.dev/
- Ant Design documentation: https://ant.design/docs/react/introduce
- Docker Compose docs: https://docs.docker.com/compose/
- GitHub Actions docs: https://docs.github.com/actions
- Render docs: https://render.com/docs

---

## API Surface Highlights

### Health
- `GET /api/v1/status`

### Public endpoints
- `GET /api/v1/frontend/projects`
- `POST /api/v1/messages`
- `GET /`
- `GET /download-cv`

### Admin auth
- `POST /api/v1/admin/login`
- `POST /api/v1/admin/refresh-token`
- `GET /api/v1/admin/me`

### Admin resources
- `skills`, `education`, `experiences`, `projects`, `services`, `messages`
- Mixed route styles include REST-like CRUD and specialized media/config handlers

---

## Local Setup

### 1) Prerequisites
- Docker + Docker Compose plugin
- Node.js + npm
- PHP + Composer (for some local workflows outside containers)

### 2) Install dependencies
```bash
composer install
npm install
```

### 3) Environment
Create `.env` from `.env.example` and set required app/database values.

### 4) Start development stack
```bash
npm run docker:dev:up
```

### 5) Useful Docker commands
```bash
npm run docker:dev:logs
npm run docker:dev:shell
npm run docker:dev:artisan migrate
npm run docker:dev:composer install
npm run docker:dev:npm run prod
```

### 6) Production-like local run
```bash
npm run docker:prod:build
npm run docker:prod:up
npm run docker:prod:logs
npm run docker:prod:down
```

### 7) Cleanup
```bash
npm run docker:prune
npm run docker:dev:reset
```

---

## CI/CD Workflow (current repo)
- CI workflow triggers on pull requests and pushes to `main`
- Main-branch flow waits for Render deploy to become `live`
- After deploy confirmation, repository script executes migrations via Render API job

This pattern separates **build/deploy** from **schema change execution**, improving operational safety.

---

## Screenshots
### Public Landing Page
![Public Landing Page Screenshot Placeholder](docs/screenshots/public-landing.png)

### Admin Dashboard
![Admin Dashboard Screenshot Placeholder](docs/screenshots/admin-dashboard-placeholder.png)

### Projects Management UI
![Projects Management Screenshot Placeholder](docs/screenshots/projects-management-placeholder.png)

### Mobile Responsive View
![Mobile Responsive Screenshot Placeholder](docs/screenshots/mobile-responsive-placeholder.png)

---

## Suggested “Demo Script” for interviews

1. Open the public site and explain personal branding content strategy.
2. Submit a contact message and show where it is managed in admin.
3. Log into admin and walk through CRUD for projects and skills.
4. Explain JWT authentication and route protection.
5. Close by outlining CI/CD and post-deploy migration design decisions.

---

## License

This project is under the MIT license (per upstream Laravel project defaults unless otherwise specified).

