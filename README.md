# Tasks for Today Management System

IT0049 Technical Summative Assessment 1  
Developer: **Edzel Kim Arce (ECARCE)**

A CodeIgniter 4 application for viewing a team's daily tasks, complete task
schedule, and one demo user's profile. This project adapts the supplied TFA1
project and retains its burgundy styling. CodeIgniter **4.7.4** and the existing
Composer dependencies are included in the ZIP.

## Assessment requirements

| Requirement | Implementation |
| --- | --- |
| Welcome page at / | Pages::index uses TaskModel::forDate with today's Manila date |
| Task List at /tasks | Tasks::index uses TaskModel::allByDate; date ascending, then ID |
| Profile at /profile | Profile::index retrieves one demo user through UserModel |
| Static About at /about | Identifies Edzel Kim Arce as developer |
| Exact tasks and users schemas | Migration and database/tsa1.sql |
| At least 8 tasks across 3 dates including today | 8 seeded tasks: 2 yesterday, 3 today, 3 tomorrow |
| Exactly one demo user | admin01 / Kim Cortez / kim.cortez@gmail.com |
| Separate models, controllers and views | app/Models, app/Controllers and app/Views |
| Database submission files | Migration, TaskSeeder and SQL import included |
| GitHub and hosted links | Add actual published links in docs/SUBMISSION.md |

The demo email is an example address. The demo user's name and username come
from the first user in the original project. The About page identifies the
developer separately.

## Start locally

Requirements: PHP 8.2 or newer, intl, mbstring and MySQLi extensions, and a
running MySQL or MariaDB server. PHPUnit also requires its usual XML extensions
and SQLite3 for the included database tests.

1. Extract the ZIP and open the **TSA1** folder in VS Code. This is the folder
   containing `spark`, `app/`, `public/` and `composer.json`.
2. Start MySQL in XAMPP (or your local database server).
3. Create a **new, empty** database named `tsa1_tasks`. Do not reuse a database
   containing earlier POS users or unrelated tables.
4. The ZIP includes a local `.env`. For a GitHub clone, copy `env.example` to
   `.env`. Set the local database details:

   ```ini
   CI_ENVIRONMENT = development
   app.baseURL = 'http://localhost:8080/'
   app.indexPage = ''
   app.appTimezone = 'Asia/Manila'
   database.default.hostname = localhost
   database.default.database = tsa1_tasks
   database.default.username = root
   database.default.password = ''
   database.default.DBDriver = MySQLi
   database.default.DBPrefix = ''
   database.default.port = 3306
   ```

   Use your actual local username and password. The supplied defaults match a
   common local XAMPP installation; hosting uses different credentials.

5. Initialize the database using **one** of these methods.

   **Method A, phpMyAdmin:** select `tsa1_tasks`, choose Import, select
   `database/tsa1.sql`, and run the import.

   **Method B, terminal:** from the TSA1 folder, run:

   ```console
   php spark migrate
   php spark db:seed TaskSeeder
   ```

   Use Method A OR Method B. SQL imports intentionally do not create CodeIgniter
   migration-history rows; do not run the migration after importing SQL.
   Migrations refuse to replace an existing tasks or users table.

6. Run:

   ```console
   php spark serve
   ```

7. Open `http://localhost:8080/`. The other pages are:
   `http://localhost:8080/tasks`, `http://localhost:8080/profile` and
   `http://localhost:8080/about`.

If Windows says PHP is not recognized, use your PHP executable directly, for
example `C:\xampp\php\php.exe spark serve`. Use that same executable for migration
and seeder commands. If an extension is missing, enable it in the active
`php.ini`, confirm using `php -m`, and restart the server.

The ZIP includes `vendor/`, so Composer installation is not needed just to run
the extracted ZIP. After cloning from GitHub, run `composer install`; the
existing `composer.lock` pins the supplied dependencies.

### Using XAMPP Apache instead

Place the extracted TSA1 folder inside your XAMPP `htdocs` and start Apache and
MySQL. Set `app.baseURL = 'http://localhost/TSA1/'` in `.env`, then open that
address. If you put it under another folder, include that full path in baseURL.
The supplied root `.htaccess` forwards requests to `public/`; Apache must allow
.htaccess rewrites. When you control the virtual host, pointing its DocumentRoot
directly at `TSA1/public` is preferred.

## How dates work

The application timezone is **Asia/Manila**. The Welcome controller computes
today once and passes that date both to the model query and the page label.
TaskModel applies `WHERE task_date = today's date` in SQL. The full list makes a
separate, unfiltered query against the same table.

Sample dates are relative to the date when you run the setup. Stored task dates
do not change when someone loads a page. As days pass, today's list naturally
changes and can become empty. This is expected behavior.

Before a later demonstration, refresh the supplied SAMPLE dates deliberately:

- Terminal: `php spark db:seed TaskSeeder`.
- phpMyAdmin: run `database/refresh_demo_dates.sql` in the TSA1 database.

The seeder identifies its eight sample tasks by title and updates only their
dates when rerun; it preserves their existing statuses and creation times.
It inserts missing samples, keeps the existing single user, and refuses to
proceed if more than one user exists. It never deletes user records. Do not
rename sample titles if you expect the seeder to recognize them on a later run.
The SQL refresh updates matching sample titles only and does not insert records.

## Database structure

The two assessment tables match the supplied schema. No password, role,
updated_at, or customer columns are added to these tables.

```sql
CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(150) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'pending',
  task_date DATE NOT NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  created_at DATETIME NOT NULL
);
```

The migration route also creates CodeIgniter's standard migration-history table.
It is framework bookkeeping and does not change the assessment schemas.
Database credentials are configured through `.env`.

## Project organization

- `app/Config/Routes.php`: the four assessment routes.
- `app/Controllers/Pages.php`: today's Welcome page and static About.
- `app/Controllers/Tasks.php`: full Task List.
- `app/Controllers/Profile.php`: demo Profile.
- `app/Models/TaskModel.php`: filtered and unfiltered task queries.
- `app/Models/UserModel.php`: database-backed demo user retrieval.
- `app/Views/pages/`, `tasks/`, `profile/`: page content.
- `app/Views/layouts/`: shared header, navigation and footer.
- `public/assets/css/app.css`: responsive burgundy/ivory styling.
- `app/Database/Migrations/`: schema setup.
- `app/Database/Seeds/TaskSeeder.php`: relative-date sample records.
- `database/tsa1.sql`: alternative setup for phpMyAdmin.
- `tests/feature/TaskManagementTest.php`: assessment behavior tests.
- `docs/SUBMISSION.md`: final submission checklist and URL placeholders.

The original `Customers` and `Users` controllers, their array data and views are
retained unchanged at `/customers` and `/users`. They are legacy TFA1 examples,
outside the assessment's four-link navigation. The assessment Profile uses the
database's one demo user; the legacy users array is not inserted into that table.
All database values on the new pages are escaped before display.

## Deploy to a shared host

The host must support the included project's PHP version and extensions.
Use the database hostname, full database name, username and password shown in
your hosting dashboard.

1. Create a new empty database in the hosting dashboard.
2. Open its phpMyAdmin, select that database, and import `database/tsa1.sql`.
   This uses dates relative to the import day in Manila.
3. Upload the extracted project files, including `vendor/`.
4. If you can select the document root, set it to the project's `public/`.
   Keep `app/`, `vendor/`, `writable/` and `.env` beside that public directory.
5. If the host fixes the document root to a folder such as `htdocs`, put the
   **contents** of TSA1 into that folder, including both the root `.htaccess`
   and `public/.htaccess`. This alternative requires Apache-compatible rewrite
   support and permission to use the supplied .htaccess rules. The root rules
   block source/configuration paths and forward application requests to public.
6. Edit the hosted `.env` using `env.hosting.example` as a guide. Replace every
   placeholder. Set `CI_ENVIRONMENT = production` and `database.default.DBDebug =
   false`. For example, baseURL must be your actual public URL with a trailing
   slash, such as `https://your-actual-domain/`.
7. Ensure PHP can write to the `writable/` directory. Do not make the entire
   project world-writable.
8. Open all four routes on the live domain. Navigation must remain on that
   domain. If it points to localhost, correct the hosted `app.baseURL`.
9. Verify that direct requests to `/.env`, `/database/tsa1.sql` and
   `/vendor/composer/installed.json` cannot download those files.

Keep the two .htaccess files when transferring through a file manager. Uploading
only the ZIP does not install the application: extract/upload its actual contents.
If the host reports an Apache configuration error, check its supported rewrite
directives or use a document root pointing at public.

No hosting account or GitHub repository was published as part of preparing this
ZIP. Use your own accounts and record the real links in docs/SUBMISSION.md.

## Verification

**Verification status:** PHP 8.2.12 and CodeIgniter 4.7.4 are installed.
Changed PHP files passed syntax checks, the route table was inspected, and the
full PHPUnit suite passed with 15 tests and 51 assertions. This PHP
installation has the `pdo_sqlite` extension but not `sqlite3`, so the tests
were run by loading XAMPP's bundled extension for that command only. A new
dedicated local `tsa1_tasks` database was created, then the migration and
seeder were run twice. The resulting records and routes were inspected, and
HTTP smoke requests to all four pages returned 200 with the expected content.
No graphical browser check was performed.

Run the isolated assessment tests with SQLite3 enabled. On this XAMPP install,
load its bundled extension for the command:

```console
php -d extension=php_sqlite3.dll vendor/phpunit/phpunit/phpunit tests/feature/TaskManagementTest.php
```

On other systems, enable the `sqlite3` extension in the active `php.ini` first,
then omit `-d extension=php_sqlite3.dll` from the command.

These tests use CodeIgniter's in-memory SQLite tests database. They cover sample
counts/dates, today-only filtering, date order, database-driven profile output,
developer identification, repeat seeding, date refresh, empty results and HTML
escaping. They do not access your live database. To run the original starter
tests as well, use `composer test`.

After setting up the real MySQL database, verify:

| Check | Expected immediately after seeding |
| --- | --- |
| Welcome | 3 tasks dated today in Manila |
| Task List | All 8 tasks, with yesterday before today before tomorrow |
| Profile | Kim Cortez, admin01, kim.cortez@gmail.com |
| About | Edzel Kim Arce and ECARCE |
| Navigation | All four links open on the same configured site |
| Narrow window | Text remains readable; wide tables scroll within their container |

Useful phpMyAdmin checks:

```sql
SELECT COUNT(*) AS task_count, COUNT(DISTINCT task_date) AS date_count FROM tasks;
SELECT task_date, COUNT(*) AS tasks_on_date FROM tasks GROUP BY task_date ORDER BY task_date;
SELECT COUNT(*) AS user_count FROM users;
SELECT * FROM tasks WHERE task_date = DATE(DATE_ADD(UTC_TIMESTAMP(), INTERVAL 8 HOUR));
SELECT * FROM tasks ORDER BY task_date ASC, id ASC;
SHOW CREATE TABLE tasks;
SHOW CREATE TABLE users;
```

## Submit

Publish the raw project files to a GitHub repository. Include README, Composer
files, app/public source, and the database SQL or migrations and seeder.
The supplied .gitignore excludes credentials, vendor dependencies and runtime
logs. Review staged files before committing; keep .env private.

Submit **both** the repository URL and the working hosted application URL.
Fill the two placeholders in `docs/SUBMISSION.md` only after they exist and
confirm the hosted code matches your repository.
