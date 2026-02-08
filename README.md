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
