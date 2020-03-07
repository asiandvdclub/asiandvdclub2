<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <div id="news" class="container">
        Search Will be Here
    </div>
    <br>
    <div id="news" class="container">
        <table class="bg-dark text-white"  border="1" cellspacing="0" cellpadding="10">
            <tbody>
            <tr class="">
                <th>Type</th>
                <th style="width: 1200px;">Name</th>
                <th>Com.</th>
                <th style="width: 380px;">Time.</th>
                <th>Size.</th>
                <th>Seeds</th>
                <th>Leech</th>
                <th>Down</th>
                <th style="width: 300px;" align="right">Uploader</th>
            </tr>
            <?php echo $data['showList']; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
