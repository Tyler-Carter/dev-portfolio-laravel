## CI/CD Pipeline Architecture
### CI/CD
GitHub push to main<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
GitHub Actions: CI (tests/build/lint)<br>
&emsp;&emsp;&emsp;&emsp;↓ (status checks pass)<br>
Render auto-deploys Docker image<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
Render runs container<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
Separate Render Job runs migrations (one-shot)

### Preview/PR Flow
Pull request opened<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
GitHub Actions: CI<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
Render PR Preview Environment builds image<br>
&emsp;&emsp;&emsp;&emsp;↓<br>
Preview service runs (no migrations, no seeding)

#### Notes
* Render is the **only deploy orchestrator.**
* GitHub Actions is CI only.
* Migrations are executed after the image is built.
* Seeding is explicit and one-time, not automatic.

## Docker Dev workflow

**Build + start dev stack**
```bash
npm run docker:dev:up
```

**Stop dev stack**
```bash
npm run docker:dev:down
```

**View logs**
```bash
npm run docker:dev:logs
```

**Shell into Laravel container**
```bash
npm run docker:dev:shell
```

## Local Prod-like workflow

**Build prod image**
```bash
npm run docker:prod:build
```

**Run prod stack**
```bash
npm run docker:prod:up
```

**Stop prod stack**
```bash
npm run docker:prod:down
```

**View logs**
```bash
npm run docker:prod:logs
```

## Cleanup

**Remove stopped containers, networks, dangling images**
```bash
npm run docker:prune
```

**Nuclear reset (dev + prod volumes)**
```bash
nom run docker:reset
```

## Running Artisan or Composer in Containers

**Artisan migrate**
```bash
npm run docker:dev:artisan migrate
```

**Install composer dependencies**
```bash
npm run docker:dev:composer install
```

**Run production**
```bash
npm run docker:dev:npm run production
```
