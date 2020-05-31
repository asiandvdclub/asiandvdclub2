<?php require_once $data['getSiteLangHeader']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITE_NAME;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/adc.css">
</head>
<body>
<div class="logo">
    <div class="logo-text">
        Ratio: <?php $ratio = (int)$data['userStats']['uploaded'] / (int)$data['userStats']['downloaded']; echo is_nan($ratio) ? "0" : sprintf("%01.3f", $ratio); ?> Activity: <img class="main-arrowup"> <img class="main-arrowdown"> Connectable: <?php echo $data['userStats']['connectable']; ?>
    </div>
</div>
<div class="outer">
    <div class="navigation">
        <a href="<?php echo URL_ROOT . "/index"; ?>"><?php echo $lang_functions['text_home'] ?></a>
        <a href="<?php echo URL_ROOT . "/torrents"; ?>"><?php echo $lang_functions['text_torrents'] ?></a>
        <a href="<?php echo URL_ROOT . "/requests"; ?>"><?php echo $lang_functions['text_request'] ?></a>
        <a href="<?php echo URL_ROOT . "/upload"; ?>"><?php echo $lang_functions['text_upload'] ?></a>
        <a href="#"><?php echo $lang_functions['text_bookmarks'] ?></a>
        <a href="<?php echo URL_ROOT . "/profile"; ?>"><?php echo $lang_functions['text_profile'] ?></a>
        <a href="<?php echo URL_ROOT . "/forums"; ?>"><?php echo $lang_functions['text_forums'] ?></a>
        <a href="#"><?php echo $lang_functions['text_top_ten'] ?></a>
        <a href="<?php echo URL_ROOT . "/faq"; ?>"><?php echo $lang_functions['text_faq'] ?></a>
        <a href="<?php echo URL_ROOT . "/rules"; ?>"><?php echo $lang_functions['text_rules'] ?></a>
        <a href="#"><?php echo $lang_functions['text_settings'] ?></a>
        <a href="<?php echo URL_ROOT . "/log"; ?>"><?php echo $lang_functions['text_log'] ?></a>
        <a href="#"><?php echo $lang_functions['text_donate'] ?></a>
        <a href="#"><?php echo $lang_functions['text_staff'] ?></a>
    </div>
    <div class="main">
