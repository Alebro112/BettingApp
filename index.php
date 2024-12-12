<?php

session_start();

require './vendor/autoload.php';

require './src/Config/Config.php';

$router = require './src/Routes/index.php';
?>

