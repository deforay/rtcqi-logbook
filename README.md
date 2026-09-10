# RTCQI Logbook Register

A web application for recording and reporting HIV rapid testing activity across
testing sites, supporting Rapid Testing Continuous Quality Improvement (RTCQI).

## What it does

- **Monthly reports** — testing sites submit monthly logbook returns, which can
  be entered in the app or imported from spreadsheets and ODK Central.
- **Site and geography registry** — test sites, site types, implementing
  partners, and a province / district / sub-district hierarchy.
- **Test kit management** — test kits and the kits permitted at each site.
- **Reporting** — dashboard, monitoring reports, trend reports, and site-wise
  reports, exportable to Excel and PDF.
- **Administration** — users, roles and privileges, per-user site mapping,
  per-user language selection, global configuration, and an audit trail.

Scheduled commands pull form submissions from ODK Central, send notification
mail, and expire stale logins.

## Requirements

- PHP 8.3 or newer
- MySQL
- Composer

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Set the database credentials in `.env`, then load the schema. The migrations in
`database/migrations` cannot be run from an empty database, so apply `alter.sql`
instead.

## Licence

Released under the GNU Affero General Public License v3.0 or later. See
[LICENSE](LICENSE).
