<?php

$url = $_SERVER['REQUEST_URI'];

$navItems = [
	'/' => 'Главная',
	'/admin' => 'Админ панель'
]

?>
<style>
	<?php include 'header.css'; ?>
</style>

<header class="header">
	<div class="container">
		<ul class="nav">
			<?php 
				foreach ($navItems as $key => $value) {
					echo '<li class="nav-item'.(($key == $url) ? ' active' : '').'"><a href="'.$key.'">'.$value.'</a></li>';
				}
			?>
		</ul>

		<div class="user">
			<span class="nav-item">150 ₽</span>
			<span class="nav-item"><a href="login">Войти</a></span>
		</div>
	</div>
</header>
