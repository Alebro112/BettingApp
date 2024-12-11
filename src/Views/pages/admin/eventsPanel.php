<head>
    <title>Borbo | Админ панель</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div id="users" class="section active">
    <h1>События</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Team one</th>
                <th>Team two</th>
                <th>Win 1</th>
                <th>Draw</th>
                <th>Win 2</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $event->id ?></td>
                    <td><?= $event->teamOneName ?></td>
                    <td><?= $event->teamTwoName ?></td>
                    <?php foreach ($event->outcomes as $key => $value): ?>
                        <td><?= $value['rate'] ?></td>
                    <?php endforeach; ?>
                    <td class="actions">
                        <button class="action-btn" onclick="redirect('/admin/event/show?eventId=<?= $event->id ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                <path fill="currentColor"
                                    d="m12.25 2.594l-.72.687l-3.59 3.626l-.688.688l.688.718L15.625 16l-7.688 7.688l-.687.718l.688.688l3.593 3.625l.72.686l.72-.687l12-12l.686-.72l-.687-.72l-12-12l-.72-.686zm0 2.844L22.813 16L12.25 26.563l-2.188-2.188l7.688-7.656l.72-.72l-.72-.72l-7.688-7.655l2.188-2.188z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>