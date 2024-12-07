<style>
    <?php include 'index.css' ?>
</style>

<main class="main">
    <div class="container">
        <!-- <?php echo '<pre>';
        print_r($bets);
        echo '</pre>'; ?> -->
        <section class="events">
            <h2>Доступные события</h2>
            <div class="events-container">
                <?php foreach ($events as $event): ?>
                    <div class="event">
                        <h3><?= $event->teamOneName ?> - <?= $event->teamTwoName ?></h3>
                        <div class="event-bet-wrapper">
                            <?php foreach ($event->outcomes as $outcome): ?>
                                <div class="event-bet">
                                    <div class="event-bet-name">
                                        <span><?=  $outcome['label'] ?></span>
                                    </div>
                                    <button><?= $outcome['coefficient'] ?></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
    </div>
    </section>
    </div>
</main>