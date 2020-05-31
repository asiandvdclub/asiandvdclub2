<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

    <div id="home_content" class="container">
        <div  class="box">
        <h1>Developers Log (Use this only to test pages layout only)</h1>

        <h1>From MemCached</h1>
        <pre>
            <?php echo $data['dataCache']; ?>
        </pre>
        </div>
    </div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>