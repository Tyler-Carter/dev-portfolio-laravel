# GitHub Environment Setup

This repository's workflows expect two GitHub Environments:

- `staging`
- `production`

## Production approval gate

In **Settings → Environments → production**, configure:

- **Required reviewers**: at least 1 reviewer/team.

`deploy-production.yml` targets the `production` environment so deployment execution is blocked until an approved reviewer authorizes the run.
