<?= view('layouts/header', ['title' => 'User Accounts | POSarce', 'active' => 'users']) ?>
<section class="card">
    <p class="eyebrow">Team directory</p>
    <h1>User Accounts</h1>
    <p class="intro">View staff accounts and their assigned roles within the POS system.</p>
    <table>
        <thead><tr><th>Username</th><th>Full Name</th><th>Role</th></tr></thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['full_name']) ?></td>
                    <td><?= esc($user['role']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>
<?= view('layouts/footer') ?>
