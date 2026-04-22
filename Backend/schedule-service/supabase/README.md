This folder contains SQL migrations for the `schedule-service` Supabase database.

Files:
- `migrations/20260422_0001_create_schedule_tables.sql` — creates `users`, `availabilities`, and `bookings` tables.

How to apply these migrations

Option A — Supabase Dashboard (quick, no CLI required):
1. Open your Supabase project
2. Go to SQL Editor
3. Create a new query and paste the contents of the migration file
4. Run the query

Option B — psql (direct to DB)
1. Get your database connection string from Supabase project (Settings → Database → Connection string)
2. Run:

psql "postgresql://<DB_USER>:<DB_PASSWORD>@<DB_HOST>:<DB_PORT>/<DB_NAME>" -f supabase/migrations/20260422_0001_create_schedule_tables.sql

Option C — Supabase CLI (recommended for migration workflows):
1. Install CLI (if not installed):

npm install -g supabase

2. Authenticate and link your project:

supabase login
supabase link --project-ref <PROJECT_REF>

3. Apply SQL directly (simple):

supabase db remote set <CONN_STRING>
psql "<CONN_STRING>" -f supabase/migrations/20260422_0001_create_schedule_tables.sql

OR, if you manage migrations with the CLI repository layout, use the CLI's migration commands per your version:

supabase db push
# or
supabase migration deploy

Notes:
- The migration uses `pgcrypto` extension for `gen_random_uuid()`; Supabase allows creating extensions in projects.
- If you prefer timestamps or different id strategies, edit the SQL file before applying.

If you want, I can try to apply the migration here, but I'll need either:
- your Supabase DB connection string (not recommended to share here), or
- you can run the commands above and I can help debug errors.
