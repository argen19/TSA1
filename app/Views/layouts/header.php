<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Tasks for Today') ?></title>
    <link rel="stylesheet" href="<?= esc(base_url('assets/css/app.css'), 'attr') ?>">
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>
    <header class="site-header">
        <a class="brand" href="<?= esc(site_url('/'), 'attr') ?>">
            <span class="brand-mark" aria-hidden="true">T</span>
            <span>Tasks for Today<small>TEAM TASK MANAGEMENT</small></span>
        </a>
        <nav aria-label="Main navigation">
            <?php foreach (['home' => ['/', 'Welcome'], 'tasks' => ['tasks', 'Task List'], 'profile' => ['profile', 'Profile'], 'about' => ['about', 'About']] as $key => [$path, $label]): ?>
                <a <?= ($active ?? '') === $key ? 'class="active" aria-current="page"' : '' ?> href="<?= esc(site_url($path), 'attr') ?>"><?= esc($label) ?></a>
            <?php endforeach ?>
        </nav>
    </header>
    <main id="main-content">
