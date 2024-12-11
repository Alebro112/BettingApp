<head>
    <title>Borbo | Админ панель</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    <?php include 'index.css'; ?>
</style>

<div id="event-show" class="section event-show">
    <h1>Просмотр события</h1>

    <div class="event-general">
        <div class="team-block">
            <div class="team">
                <h2><?= $event->teamOneName ?></h2>
            </div>
            <div class="team">
                <h2><?= $event->teamTwoName ?></h2>
            </div>
        </div>

        <div class="outcome-block">
            <?php foreach ($event->outcomes as $outcome): ?>
                <div class="outcome">
                    <h3><?= $outcome['label'] ?></h3>
                    <h4><?= $outcome['rate'] ?>x</h4>
                    <form class="outcome-form" method="post" action="/admin/event/calculate?eventId=<?= $event->id ?>&outcome=<?= $outcome['name'] ?>">
                        <button type="submit">Расчитать <?= $outcome['label'] ?></button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <h2>Ставки на событие</h2>

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

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Outcome</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Rate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bets as $bet): ?>
                <tr>
                    <td><a href="/admin/user/show?userId=<?= $bet->userId ?>"><?= $bet->username ?></a></td>
                    <td><?= $bet->outcome ?></td>
                    <td><?= $bet->currency ?></td>
                    <td><?= $bet->amount ?></td>
                    <td><?= $bet->rate ?>x</td>
                    <td class="actions">
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
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>