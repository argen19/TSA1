<?= view('layouts/header', ['title' => 'Welcome | Tasks for Today', 'active' => 'home']) ?>
<section class="page-heading">
    <div>
        <p class="eyebrow">Welcome to your daily workspace</p>
        <h1>Focus on today.</h1>
        <p class="intro">A clear view of the tasks scheduled for today. One day, one step at a time.</p>
    </div>
    <p class="date-label"><span>Today &middot; Manila time</span><time datetime="<?= esc($today, 'attr') ?>"><?= esc((new DateTimeImmutable($today))->format('F j, Y')) ?></time></p>
</section>
<section class="card" aria-labelledby="today-heading">
    <div class="section-heading">
        <div><p class="eyebrow">Your daily agenda</p><h2 id="today-heading">Today's tasks <span class="count"><?= count($tasks) ?></span></h2></div>
        <a class="text-link" href="<?= esc(site_url('tasks'), 'attr') ?>">View all tasks &rarr;</a>
    </div>
    <?= view('tasks/_table', ['tasks' => $tasks, 'caption' => 'Tasks scheduled for today', 'emptyTitle' => 'No tasks scheduled for today.', 'emptyMessage' => 'You are all clear for today. You can still browse every task in the Task List.']) ?>
</section>
<p class="page-note">This page shows today's tasks only. Open the Task List to see previous and upcoming dates.</p>
<?= view('layouts/footer') ?>
