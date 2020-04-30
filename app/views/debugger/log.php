<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

    <div id="home_content" class="container">
        <div id="log" class="container">
        Developers Log (Use this only to test pages layone only)
            <?php print_r($data['log_data']); ?>
        </div>
    </div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>