# Data export

GET /api/export/inventory-products.csv downloads a read-only CSV snapshot for local use.

- Database cursor streams records in ascending ID order.
- Columns are explicitly allowlisted, and fields are RFC 4180 encoded.
- Potential spreadsheet formulas are escaped with an apostrophe.
- No authentication: **do not deploy** with real data until RBAC and audit logging are added.
