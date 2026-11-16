# HTTP interface

Main operations:

- `GET /`
- `POST /products`
- `POST /products/{product}/adjust`

Additional read-only endpoints:

- `GET /api/insights` — aggregated product metrics

These endpoints are demonstration APIs; no public authentication is implemented. See source and tests for payload fields and status codes.
