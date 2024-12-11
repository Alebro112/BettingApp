<head>
    <title>Borbo | Админ панель</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div id="users" class="section active">
    <h1>Пользователи</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->name ?></td>
                    <td><?= $user->gender ?></td>
                    <td><?= $user->birthday ?></td>
                    <td><?= $user->status ?></td>
                    <td class="actions">
                        <button class="action-btn" onclick="redirect('/admin/user/edit?userId=<?= $user->id ?>')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                <path fill="currentColor"
                                    d="M24.688 4.03c-.837 0-1.648.337-2.282.97l-.093.094l-.625-.594l-.688.688L5.406 20.78l-.218.22l-.063.313l-1.094 5.5l-.31 1.468l1.467-.31l5.5-1.095l.313-.063l.22-.218L26.81 11l.688-.688l-.594-.593l.063-.064l.03-.062A3.247 3.247 0 0 0 27 5a3.3 3.3 0 0 0-2.313-.97zm0 1.97c.31 0 .64.14.906.406c.533.534.533 1.248 0 1.782l-.094.093l-1.78-1.78l.093-.094c.266-.266.563-.406.875-.406zm-2.97 1.313l2.97 2.968l-1.438 1.47l-3-3l1.47-1.438zm-2.843 2.875l2.938 2.937l-10.438 10.47l-.406-1.814l-.126-.624l-.625-.125l-1.814-.405l10.47-10.438zM6.97 22.343l2.186.5l.5 2.187l-2.03.407l-1.064-1.062l.407-2.03z" />
                            </svg>
                        </button>
                        <button class="action-btn" onclick="redirect('/admin/user/show?userId=<?= $user->id ?>')">
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