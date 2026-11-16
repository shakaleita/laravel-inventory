# Security policy — Laravel Inventory

This repository is an educational portfolio MVP. It is **not approved for public production deployment** or real customer information.

## Reporting
Please report vulnerabilities privately to the repository maintainer via GitHub's security reporting feature when available. Do not post credentials or exploitation details in public issues.

## Known scope boundaries
- No user authentication or fine-grained authorisation.
- Limited request-size, abusive traffic, and rate controls.
- Database storage is local/development-oriented; backup and encryption are out of scope.
- CI tests cover representative workflows, not comprehensive penetration or load tests.

## Recommended controls before deployment
Introduce authentication, CSRF protections where applicable, least-privilege permissions, input/response limits, dependency reviews, observability, HTTPS, and a managed secrets strategy.
