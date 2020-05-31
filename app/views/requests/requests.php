<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <div id="news" class="container">
        <h1>Requests Selection</h1><br>
        <a href="<?php echo URL_ROOT . "/make_request" ; ?>">Make a request</a>

    </div>
    <br>
    <div id="news" class="container">
        <table class="bg-dark text-white"  border="1" cellspacing="0" cellpadding="10">
            <thead>
            <tr class="">
                <th>Requests</th>
                <th style="width: 1200px;">Name</th>
                <th width='200px'>Added</th>
                <th style="width: 380px;">Added By</th>
                <th>Filled?</th>
                <th>Filled By</th>
                <th>Votes</th>
            </tr>
            </thead>
            <tbody align="center">
                <?php echo $data['requests']; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
