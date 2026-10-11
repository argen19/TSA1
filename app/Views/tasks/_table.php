<?php if ($tasks === []): ?>
    <div class="empty-state" role="status">
        <h3><?= esc($emptyTitle) ?></h3>
        <p><?= esc($emptyMessage) ?></p>
    </div>
<?php else: ?>
    <div class="table-wrap" tabindex="0" role="region" aria-label="<?= esc($caption, 'attr') ?>">
        <table>
            <caption class="sr-only"><?= esc($caption) ?></caption>
            <thead><tr><th scope="col">ID</th><th scope="col">Task</th><th scope="col">Status</th><th scope="col">Task date</th></tr></thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <?php $statusClass = match ($task['status']) { 'completed' => 'completed', 'in progress' => 'progress', default => 'pending' }; ?>
                    <tr>
                        <td class="record-id">#<?= esc($task['id']) ?></td>
                        <th scope="row"><?= esc($task['title']) ?></th>
                        <td><span class="status status--<?= esc($statusClass, 'attr') ?>"><?= esc(ucfirst($task['status'])) ?></span></td>
                        <td class="task-date"><time datetime="<?= esc($task['task_date'], 'attr') ?>"><?= esc($task['task_date']) ?></time></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php endif ?>
