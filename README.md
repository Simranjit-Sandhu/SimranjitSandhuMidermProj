# Quotes REST API (Simple README)

This project is a small PHP API for quotes.

It lets you:
- read quotes, authors, and categories
- add new records
- update records
- delete records

The API returns JSON.

## Main Endpoints

- `/api/quotes/`
- `/api/authors/`
- `/api/categories/`

Use query params for filters, for example:
- `/api/quotes/?id=10`
- `/api/quotes/?author_id=5`
- `/api/quotes/?category_id=4`
- `/api/quotes/?random=true`

## Tech Used

- PHP (OOP)
- PostgreSQL (Render.com ready)
- PDO
- Docker (for Render deployment)

## Quick Setup

1. Create a PostgreSQL database named `quotesdb`.
2. Run `db/schema.sql`.
3. Run `db/sample_data.sql`.
4. Start PHP server locally or deploy on Render.
5. Test endpoint: `/api/authors/`

## Database Connection

The project uses:
- local PostgreSQL values in `config/Database.php`
- `DATABASE_URL` automatically when deployed on Render

Important for Render:
- use the Internal Database URL

## Course

INF653 Midterm Project
