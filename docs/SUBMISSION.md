# IT0049 TSA1 submission

Developer: Edzel Kim Arce (ECARCE)

- GitHub repository URL: **ADD YOUR ACTUAL REPOSITORY LINK**
- Hosted application URL: **ADD YOUR ACTUAL LIVE WEBSITE LINK**

Publish the extracted raw project files to GitHub, including `app/`, `public/`,
`composer.json`, `composer.lock`, `database/`, the migration and seeder, and the
README. Do not submit a repository containing only this ZIP. Keep `.env` out of
GitHub; `env.example` is the public setup template. Composer restores `vendor/`
when someone clones the repository.

Before submission, open these URLs on the LIVE domain:

- `/` shows only records whose task_date equals today in Asia/Manila.
- `/tasks` shows every task, ordered by date ascending.
- `/profile` shows the one demo user from the users table.
- `/about` identifies Edzel Kim Arce as developer.

Confirm at least 8 tasks across at least 3 dates (including today's date), and
exactly 1 row in users. If demonstrating on a later date, deliberately refresh
the sample dates using the seeder or `database/refresh_demo_dates.sql`.
Record any later data changes in the database setup you submit so it reproduces
the hosted version. The default setup already reproduces the supplied demo data.

The assessment allocates 35 points to functionality, 20 to MVC organization,
25 to database design and queries, and 20 to documentation and submission.
Publishing both actual links and checking the live site are still required.
