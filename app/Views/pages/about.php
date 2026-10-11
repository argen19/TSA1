<?= view('layouts/header', ['title' => 'About | Tasks for Today', 'active' => 'about']) ?>
<section class="page-heading"><div><p class="eyebrow">About the system</p><h1>A little clarity for every day.</h1><p class="intro">Tasks for Today Management System keeps a team's daily priorities and full schedule easy to find.</p></div></section>
<section class="card about-card" aria-labelledby="developer-heading">
    <p class="eyebrow">Designed and developed by</p>
    <h2 id="developer-heading" class="developer-name">Edzel Kim Arce</h2>
    <p class="developer-signature">ECARCE &middot; IT0049 &middot; Technical Summative Assessment 1</p>
    <p>This application was developed using CodeIgniter 4 and a relational database. It demonstrates the Model-View-Controller architecture through a filtered Welcome page, a complete Task List, a database-backed Profile, and this static About page.</p>
    <p>The Welcome page retrieves tasks scheduled for the current date. The Task List reads from the same tasks table and displays every record in date order. The Profile displays one demo user from the users table.</p>
    <div class="action-buttons"><a class="button" href="<?= esc(site_url('/'), 'attr') ?>">See today's tasks</a><a class="button button--secondary" href="<?= esc(site_url('tasks'), 'attr') ?>">Browse all tasks</a></div>
</section>
<?= view('layouts/footer') ?>
