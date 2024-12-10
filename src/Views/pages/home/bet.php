<head>
    <title>Borbo | <?= $event->teamOneName ?> - <?= $event->teamTwoName ?></title>
</head>

<style>
    <?php include 'bet.css' ?>
</style>

<div class="container">
    <section class="events">
        <div class="events-container">
            <div class="event">
                <h3><?= $event->teamOneName ?> - <?= $event->teamTwoName ?></h3>
                <div class="event-bet-wrapper">
                    <?php foreach ($event->outcomes as $outcome): ?>
                        <div class="event-bet">
                            <div class="event-bet-name">
                                <span><?= $outcome['label'] ?></span>
                            </div>
                            <a class="event-bet-btn <?= $outcome['name'] == $chosedOutcome ? 'active' : '' ?>"
                                href="/bet?eventId=<?= $event->id ?>&outcome=<?= $outcome['name'] ?>"><?= $outcome['rate'] ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <form class="bet" action="/bet?eventId=<?= $event->id ?>&outcome=<?= $chosedOutcome ?>" method="post">
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
                <div class="bet-up">
                    <input class="bet-input" type="number" name="amount" id="bet" placeholder="Сумма ставку" required>
                    <select name="currency">
                        <?php foreach ($balances as $balance): ?>
                            <option value="<?= $balance->currency ?>"><?= $balance->tag ?> (<?= $balance->display() ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="bet-btn">Сделать ставку</button>
            </form>
        </div>

    </section>
</div>