<head>
    <title>Borbo | Админ панель</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    <?php include 'index.css'; ?>
</style>


<div class="user-show" class="section">
    <h1>Информация о пользователи</h1>

    <div class="user-show-info">
        <div class="user-show-info-item">
            <span class="user-show-info-label">Имя пользователя:</span>
            <span class="user-show-info-value"><?= $user->username ?></span>
        </div>

        <div class="user-show-info-item">
            <span class="user-show-info-label">Имя Фамилия:</span>
            <span class="user-show-info-value"><?= $user->name ?></span>
        </div>

        <div class="user-show-info-item">
            <span class="user-show-info-label">Статус:</span>
            <span class="user-show-info-value"><?= $user->status ?></span>
        </div>

        <div class="user-show-info-item">
            <span class="user-show-info-label">Пол:</span>
            <span class="user-show-info-value"><?= $user->gender ?></span>
        </div>

        <div class="user-show-info-item">
            <span class="user-show-info-label">Дата рождения:</span>
            <span class="user-show-info-value"><?= $user->birthday ?></span>
        </div>
    </div>

    <h2>Балансы</h2>
    <table>
        <thead>
            <tr>
                <th>Валюта</th>
                <th>Количество</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userBalances as $balance): ?>
                <tr>
                    <td><?= $balance->currency ?></td>
                    <td><?= $balance->display() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Ставки пользователя</h2>

    <table>
        <thead>
            <tr>
                <th>Event</th>
                <th>Outcome</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bets as $bet): ?>
                <tr>
                    <td><a href="/admin/event/show?eventId=<?= $bet->eventId ?>" ><?= $bet->teamOneName ?> - <?= $bet->teamTwoName ?></a></td>
                    <td><?= $bet->outcome ?></td>
                    <td><?= $bet->currency ?></td>
                    <td><?= $bet->amount ?></td>
                    <td><?= $bet->rate ?>x</td>
                    <td><?= $bet->status ?></td>
                    <td class="actions">
                        <?php if ($bet->status == 'Pending'): ?>
                            <form method="post" action="/admin/bet/success?betId=<?= $bet->id ?>">
                                <button class="action-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                        <path fill="currentColor"
                                            d="M28.28 6.28L11 23.563l-7.28-7.28l-1.44 1.437l8 8l.72.686l.72-.687l18-18l-1.44-1.44z" />
                                    </svg>
                                </button>
                            </form>
                            <form method="post" action="/admin/bet/failure?betId=<?= $bet->id ?>">
                                <button class="action-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                        <path fill="currentColor"
                                            d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3m0 2c6.087 0 11 4.913 11 11s-4.913 11-11 11S5 22.087 5 16S9.913 5 16 5m-3.78 5.78l-1.44 1.44L14.564 16l-3.782 3.78l1.44 1.44L16 17.437l3.78 3.78l1.44-1.437L17.437 16l3.78-3.78l-1.437-1.44L16 14.564l-3.78-3.782z" />
                                    </svg>
                                </button>
                            </form>
                            <form method="post" action="/admin/bet/refund?betId=<?= $bet->id ?>">
                                <button class="action-btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
                                        <path fill="currentColor"
                                            d="m12.78 5.28l-8 8l-.686.72l.687.72l8 8l1.44-1.44L7.936 15H21c2.755 0 5 2.245 5 5v7h2v-7c0-3.845-3.155-7-7-7H7.937l6.282-6.28z" />
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>