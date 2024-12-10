<?php

$url = $_SERVER['REQUEST_URI'];

$navItems = [
	'/' => 'Главная',
	'/admin/users' => 'Админ панель'
];

function getBalanceByCurrency($currencyCode, $balances)
{
	foreach ($balances as $balance) {
		if ($balance->currency == $currencyCode) {
			return $balance;
		}
	}
	return 0;
}

?>
<style>
	<?php include 'header.css'; ?>
</style>

<header class="header">
	<div class="container">
		<ul class="nav">
			<?php
			foreach ($navItems as $key => $value) {
				echo '<li class="nav-item' . (($key == $url) ? ' active' : '') . '"><a href="' . $key . '">' . $value . '</a></li>';
			}
			?>
		</ul>

		<div class="user">
			<?php if (isset($_SESSION['userId'])): ?>
				<?php if (isset($balances)): ?>
					<div class="balance-container">
						<?php foreach ($balances as $balance): ?>
							<div class="balance" id="balance-<?php echo $balance->currency; ?>" display="none">
								<?php echo $balance->display(); ?>
							</div>
						<?php endforeach; ?>

						<?php if (count($balances) > 1): ?>
							<div style="display: flex; align-items: center;">
								<div id="currency-toggle" class="dropdown-arrow">
									&#9660;
								</div>
								<ul class="currency-dropdown" id="currency-options">
									<?php foreach ($balances as $balance): ?>
										<li data-currency="<?php echo $balance->currency ?>"><?php echo $balance->currency ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
				<span class="nav-item"><?php echo $_SESSION['username'] ?></span>
				<span class="nav-item"><a href="logout">Выйти</a></span>
			<?php else: ?>
				<span class="nav-item"><a href="login">Войти</a></span>
			<?php endif; ?>
		</div>
	</div>
</header>

<script>
	$(document).ready(function () {
		let currentCurrency = '';
		$(document).ready(function () {
			$('.balance').each(function () {
				if ($(this).css('display') === 'block') {
					currentCurrency = $(this)[0].id.split('-')[1];
				}
			});
		});
		

		$('#currency-toggle').click(function () {
			if ($('#currency-options').is(':visible')) {
				$('#currency-options').hide();
				$('#currency-toggle').css('transform', 'rotate(0deg)');
			} else {
				$('#currency-options').show();
				$('#currency-toggle').css('transform', 'rotate(180deg)');
			}
		});

		$('#currency-options li').click(function () {
			const newCurrency = $(this).data('currency');
			changeCurrency(newCurrency);
			$('#currency-options').hide();
			$('#currency-toggle').css('transform', 'rotate(0deg)');
		});

		function changeCurrency(currency) {
			$('#balance-' + currentCurrency).hide()
			currentCurrency = currency;
			$('#balance-' + currency).show();
		}

		$(document).click(function (e) {
			if (!$(e.target).closest('#currency-toggle, #currency-options').length) {
				$('#currency-options').hide();
				$('#currency-toggle').css('transform', 'rotate(0deg)');
			}
		});
	});
</script>