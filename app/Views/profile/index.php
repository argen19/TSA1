<?= view('layouts/header', ['title' => 'Profile | Tasks for Today', 'active' => 'profile']) ?>
<section class="page-heading"><div><p class="eyebrow">Meet the team</p><h1>Your profile.</h1><p class="intro">The demo team member for this workspace.</p></div></section>
<section class="card profile-card" aria-labelledby="profile-heading">
    <?php if ($user === null): ?>
        <div class="empty-state" role="status"><h2 id="profile-heading">No profile available.</h2><p>The demo user has not been added to the database yet.</p></div>
    <?php else: ?>
        <div class="profile-intro">
            <div class="avatar" aria-hidden="true"><?= esc(mb_strtoupper(mb_substr($user['full_name'], 0, 1))) ?></div>
            <div><p class="eyebrow">Demo team member</p><h2 id="profile-heading"><?= esc($user['full_name']) ?></h2><p class="muted">@<?= esc($user['username']) ?></p></div>
        </div>
        <dl class="detail-grid">
            <div><dt>Full name</dt><dd><?= esc($user['full_name']) ?></dd></div>
            <div><dt>Username</dt><dd><?= esc($user['username']) ?></dd></div>
            <div><dt>Email</dt><dd><?= esc($user['email']) ?></dd></div>
            <div><dt>Created at &middot; Manila time</dt><dd><?= esc($user['created_at']) ?></dd></div>
        </dl>
    <?php endif ?>
</section>
<?= view('layouts/footer') ?>
