<?php if (empty($users)): ?>
    <div>
        No users
    </div>
<?php else: ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>Real Name</th>
                <th>Nick Name</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <?php foreach ($users as $u): ?>
            <tr class="anchor" data-anchor-href="<?=U('/User/editForm?user_id=' . $u['user_id']);?>">
                <td><?= $u['user_id']; ?></td>
                <td><?= $u['email']; ?></td>
                <td><?= $u['real_name']; ?></td>
                <td><?= $u['user_name']; ?></td>
                <td><?= $u['role']; ?></td>
                <td><?= $u['status']; ?></td>
                <td><?= date('Y-m-d', $u['created']); ?></td>
            </tr>
        <?php endforeach ?>
        <tbody>

        </tbody>
    </table>

    <?= isset($page) ? $page : ''; ?>
<?php endif ?>

