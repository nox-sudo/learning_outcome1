# HALCÓN – Order Tracking System

Laravel 7 project developed as **Learning Outcome 2** for the web development course.

## Project: `halcon-order-tracking/`

A web application for tracking customer orders through their lifecycle: from placement to delivery, with photo evidence upload and full status history.

---

## Changes / What Was Built

### Models (`app/Models/`)

| Model | Description |
|---|---|
| `Role` | User roles/departments. `hasMany(User)` |
| `User` | Authenticated users. `belongsTo(Role)`, `hasMany(Order, OrderPhoto, StatusHistory)` |
| `Order` | Customer orders with soft-delete. Constants for statuses, `changeStatus()`, `softDelete()`, `restore()`, scopes `active` / `archived` |
| `OrderPhoto` | Photo evidence (loading or delivery). No timestamps. `belongsTo(Order)`, `belongsTo(User)` as `uploader()` |
| `StatusHistory` | Audit trail of status changes. No timestamps. Static `log()` and `getHistory()` methods |

### Migrations

1. `create_roles_table` — name (unique), description
2. `create_users_table` (modified) — added `role_id` FK + `active` flag
3. `create_orders_table` — invoice_number, customer data, ENUM status, soft-delete via `deleted` column
4. `create_order_photos_table` — photo_type ENUM (loading/delivery), photo_url, uploaded_by FK
5. `create_status_histories_table` — old/new status, changed_by FK

### Controllers

| Controller | Middleware | Responsibilities |
|---|---|---|
| `HomeController` | none | Public home + invoice search |
| `DashboardController` | auth | Stats dashboard |
| `UserController` | auth | CRUD users with role assignment |
| `OrderController` | auth | Full order lifecycle, photo upload, soft-delete, restore |

### Seeders

- `RoleSeeder` — 5 roles: admin, sales, warehouse, purchasing, route
- `UserSeeder` — 5 users (one per role), password: `password`
- `OrderSeeder` — 4 orders in all statuses (ordered → delivered), with StatusHistory records

| Email | Name | Role |
|---|---|---|
| admin@halcon.com | Admin Halcón | admin |
| ventas@halcon.com | Carlos Ventas | sales |
| almacen@halcon.com | María Almacén | warehouse |
| compras@halcon.com | Luis Compras | purchasing |
| ruta@halcon.com | Pedro Ruta | route |

### Views (Bootstrap 5 CDN)

**Public:**
- `home/index` — Invoice search; if delivered shows delivery photo; otherwise shows last status + date

**Protected (auth required):**
- `dashboard/index` — Stats cards (total / ordered / in_route / delivered) + nav links
- `users/index` — Table with active/inactive badge + edit button
- `users/create` — Form: name, email, password, role
- `users/edit` — Form: name, email, role, active status
- `orders/index` — Active orders table with status badge, archive button
- `orders/create` — Full order form
- `orders/edit` — Same fields + status selector + conditional photo upload (JS-toggled for in_route / delivered)
- `orders/show` — Two-column layout: customer data + status card, photos gallery, status history table
- `orders/archived` — Soft-deleted orders with restore button

### Routes

```
GET  /                        home
POST /search                  home.search
GET  /login                   login
GET  /dashboard               dashboard          [auth]
GET  /users                   users.index        [auth]
GET  /users/create            users.create       [auth]
POST /users                   users.store        [auth]
GET  /users/{user}/edit       users.edit         [auth]
PUT  /users/{user}            users.update       [auth]
GET  /orders                  orders.index       [auth]
POST /orders                  orders.store       [auth]
GET  /orders/create           orders.create      [auth]
GET  /orders/{order}          orders.show        [auth]
GET  /orders/{order}/edit     orders.edit        [auth]
PUT  /orders/{order}          orders.update      [auth]
DELETE /orders/{order}        orders.destroy     [auth]
GET  /orders-archived         orders.archived    [auth]
PATCH /orders/{order}/restore orders.restore     [auth]
```

---

## Setup

```bash
cd halcon-order-tracking

# Install dependencies
composer install

# Copy environment file and generate key
cp .env.example .env
php artisan key:generate

# Run migrations and seed
php artisan migrate:fresh --seed

# Link storage
php artisan storage:link

# Start dev server
php artisan serve
```

**Default login:** `ventas@halcon.com` / `password`

---

## Tech Stack

- PHP 7.4
- Laravel 7
- SQLite (development)
- Bootstrap 5 (CDN)
