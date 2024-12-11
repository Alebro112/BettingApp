<head>
    <title>Borbo | Админ панель</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div id="user-edit" class="section">
    <h1>Изменение пользователя</h1>

    <div id="message" class="message">
        <?php if (isset($_SESSION['message']) && !empty($_SESSION['message']))
            echo $_SESSION['message'];
        unset($_SESSION['message']) ?>
    </div>
    <div id="error" class="error">
        <?php if (isset($_SESSION['error']) && !empty($_SESSION['error']))
            echo $_SESSION['error'];
        unset($_SESSION['error']) ?>
    </div>

    <!-- <?php echo '<pre>';
    print_r($user);
    echo '</pre>'; ?> -->

    <form method="post" action="/admin/user/edit?userId=<?= $user->id ?>">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= $user->username ?>" disabled>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $user->name ?>">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="Active" <?php if ($user->status == "Active")
                    echo "selected"; ?>>Active</option>
                <option value="Banned" <?php if ($user->status == "Banned")
                    echo "selected"; ?>>Banned</option>
            </select>
        </div>


        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male" <?php if ($user->gender == "Male")
                    echo "selected"; ?>>Male</option>
                <option value="Female" <?php if ($user->gender == "Female")
                    echo "selected"; ?>>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" id="birthday" name="birthday" value="<?= $user->birthday ?>">
        </div>

        <button type="submit" class="submite-btn">Сохранить изменения</button>
    </form>

    <form method="post" class="balance-actions" action="/admin/user/balance?userId=<?= $user->id ?>">
        <h2>Балансы</h2>

        <table>
            <thead>
                <tr>
                    <th>Валюта</th>
                    <th>Значение</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userBalances as $balance): ?>
                    <tr>
                        <td><?= $balance->currency ?></td>
                        <td>
                            <div class="form-group">
                                <input type="number" id="balanceEdit-<?= $balance->currency ?>" name="balance-<?= $balance->currency ?>"
                                    value="<?= $balance->amount ?>">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="submite-btn">Сохранить изменения</button>
    </form>
</div>