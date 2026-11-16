# Reviewer walkthrough — laravel-inventory

## Five-minute technical review

1. Follow the local setup in the repository README; do not use production/customer data.
2. Inspect the real workflow: **SKU creation → initial balance → transactionally adjusted stock → reorder alerts**.
3. Make at least one mutation using the UI or HTTP endpoint in `docs/API.md`.
4. Refresh `/api/insights` to see how persisted business data changes.
5. Execute the project tests and inspect the automated workflow.
6. Read `docs/ENGINEERING.md` for design trade-offs and production limitations.

### What the demo proves

It demonstrates a small, understandable workflow with persistent storage and regression-testable behaviours. It does **not** demonstrate scaling, public hosting or enterprise authentication.
