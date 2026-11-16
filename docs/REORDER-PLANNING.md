# Reorder planning

`GET /api/reorder-report` returns products where `quantity <= reorder_level`, sorted by SKU. The heuristic replenishes each product to `max(2 × reorder_level, 1)`. Estimated purchase cost is `suggested_quantity × unit_cost_cents` and stored in integer minor currency units to avoid floating-point rounding.

This is a **transparent demo heuristic**, not a demand forecast. A real ordering engine needs supplier lead times, sales velocity, minimum order quantities, safety stock and currency assumptions.
