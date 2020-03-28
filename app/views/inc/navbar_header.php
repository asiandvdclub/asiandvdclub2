<?php require_once $data['getSiteLangHeader']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITE_NAME;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/nexusphp.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/functions.js"></script>
</head>
<body>
<header class="header">
    <a href="#" class="logo">
        Asian Dvd Club
    </a>
</header>
<nav class="user-panel clearfix">
    <strong><?php echo $data['userStats']['username']; ?></strong>
    <a href="<?php echo URL_ROOT . "/logout";?>" class="badge badge-primary"><?php echo $lang_functions['text_logout'] ?></a>
    <a href="#" class="badge badge-primary"><?php echo $lang_functions['text_bookmarks'] ?></a>
    <?php echo $data['getSiteManagerBar']; ?>
    <!-- This would be the php generator-->
    <?php echo $lang_functions['text_ratio'] ?> <?php $ratio = (int)$data['userStats']['uploaded'] / (int)$data['userStats']['downloaded']; echo is_nan($ratio) ? "0" : sprintf("%01.3f", $ratio); ?>
    <?php echo $lang_functions['text_uploaded'] ?> <?php echo formatBytes($data['userStats']['uploaded']); ?>
    <?php echo $lang_functions['text_downloaded'] ?> <?php echo formatBytes($data['userStats']['downloaded']); ?>
    <?php echo $lang_functions['text_active_torrents'] ?> <?php echo "<img src=\"../images/up.png\"> " .  $data['userStats']['seeding'] .  "<img src=\"../images/down.png\"> " . $data['userStats']['leeching'];?>
    <?php echo $lang_functions['text_connectable'] ?> <?php echo $data['userStats']['connectable']; ?>
    <?php echo $lang_functions['text_slots'] ?> 
    <?php echo $lang_functions['text_bonus'] ?>: 
    <?php echo $lang_functions['text_invite'] ?>: 
</nav>
<div id="navbar" class="container">
    <nav class="navbar navbar-expand-md" style="width: 100%">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/index"; ?>"><?php echo $lang_functions['text_home'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/torrents"; ?>"><?php echo $lang_functions['text_torrents'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/requests"; ?>"><?php echo $lang_functions['text_request'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/upload"; ?>"><?php echo $lang_functions['text_upload'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_bookmarks'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_profile'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/forums"; ?>"><?php echo $lang_functions['text_forums'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_top_ten'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_faq'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_rules'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_settings'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_log'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_donate'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_staff'] ?></a>
            </li>
        </ul>
    </nav>
</div>