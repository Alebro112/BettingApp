<?php

$url = $_SERVER['REQUEST_URI'];

$adminSidebar = [
    '/admin/users' => 'Пользователи',
    '/admin/events' => 'События'
];
?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <script src="/jQuery.js"></script>
</head>

<style>
    <?php include 'normalize.css'; ?>
    <?php include 'main.css'; ?>
    <?php include 'admin.css'; ?>
</style>

<?php include '../src/Views/components/header/header.php'; ?>

<div class="container">
    <div class="sidebar">
        <ul>
            <?php foreach ($adminSidebar as $key => $value): ?>
                <li class="<?php if ($key == $url)
                    echo 'active'; ?>" onclick="redirect('<?php echo $key; ?>')">
                    <?php echo $value; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="content">
        <?php include $view; ?>
    </div>
</div>

<script>
    function redirect(url) {
        window.location.href = url
    }
</script>