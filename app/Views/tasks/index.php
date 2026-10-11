<?= view('layouts/header', ['title' => 'Task List | Tasks for Today', 'active' => 'tasks']) ?>
<section class="page-heading">
    <div><p class="eyebrow">The complete schedule</p><h1>Every task, in one place.</h1><p class="intro">Browse all recorded tasks, from the earliest date to the latest.</p></div>
    <a class="button button--secondary" href="<?= esc(site_url('/'), 'attr') ?>">Back to today</a>
</section>
<section class="card" aria-labelledby="list-heading">
    <div class="section-heading">
        <div><p class="eyebrow">Past, present and upcoming</p><h2 id="list-heading">Task List <span class="count"><?= count($tasks) ?></span></h2></div>
        <span class="sort-label">Date &uarr; &nbsp; Oldest first</span>
    </div>
    <?= view('tasks/_table', ['tasks' => $tasks, 'caption' => 'All tasks ordered by date', 'emptyTitle' => 'No tasks have been recorded yet.', 'emptyMessage' => 'Tasks will appear here once they are added to the database.']) ?>
</section>
<?= view('layouts/footer') ?>
