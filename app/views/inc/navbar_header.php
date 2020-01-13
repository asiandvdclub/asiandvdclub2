<?php require_once $data['getSiteLangHeader']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITE_NAME;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nexusphp.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/functions.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md" style="height: 100px;">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="#">SiteLogo</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="#">DonationLogo</a>
            </li>
        </ul>
        <form method="post" action="<?php echo URL_ROOT . $data['currentPage']; ?>">
            <div align="right"><?php echo $lang_login['text_select_lang']; ?>
                <!--  <select name="sitelanguage" onchange="submit()">  This needs to be a for from database -->
                <?php echo $data['getLangDropdown']; ?>
            </div>
        </form>
    </div>
</nav>
<div id="navbar" class="container">
    <nav class="navbar navbar-expand-md navbar-light bg-dark" style="width: 100%">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/index"; ?>"><?php echo $lang_functions['text_home'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo URL_ROOT . "/forums"; ?>"><?php echo $lang_functions['text_forums'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_torrents'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_offers'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_request'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_upload'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_subtitles'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_user_cp'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_top_ten'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_log'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_chat'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_rules'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_faq'] ?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#"><?php echo $lang_functions['text_staff'] ?></a>
            </li>
        </ul>
    </nav>
    <nav id="controller" class="navbar bg-dark justify-content-start table-responsive" style="width: 100%;">
        <table class="table table-borderless  table-dark text-center">
            <thead>
            <tr id="small" class="d-flex">
                <td>Welcome, <?php echo $data['userStats']['username']; ?></td>
                <td><a href="<?php echo URL_ROOT . "/logout";?>" class="badge badge-primary"><?php echo $lang_functions['text_logout'] ?></a></td>
                <td><a href="#" class="badge badge-primary"><?php echo $lang_functions['text_bookmarks'] ?></a></td>
                <?php echo $data['getSiteManagerBar']; ?>
                <!-- This would be the php generator-->
            </tr>
            <tr id="small_tab" class="d-flex badge-info embed-responsive">
                <td><?php echo $lang_functions['text_ratio'] ?> </td>
                <td><?php echo $lang_functions['text_uploaded'] ?> <?php echo $data['userStats']['uploaded']; ?></td>
                <td><?php echo $lang_functions['text_downloaded'] ?> <?php echo $data['userStats']['downloaded']; ?></td>
                <td><?php echo $lang_functions['text_active_torrents'] ?> </td>
                <td><?php echo $lang_functions['text_connectable'] ?> </td>
                <td><?php echo $lang_functions['text_slots'] ?> </td>
            </tr>
            <tr id="small_tab2" class="d-flex badge-info">
                <td><?php echo $lang_functions['text_bonus'] ?>: </td>
                <td style="margin-left: 3px;"><?php echo $lang_functions['text_invite'] ?>: </td>
            </tr>
            </thead>
        </table>
    </nav>
</div>