<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>
<div id="home_content" class="container">
    <div style="padding: 20px 0;">
        Search Will be Here
    </div>
    <div id="news" class="container">
        <table class="bg-dark text-white"  border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr class="">
                    <th>Type</th>
                    <th>Name</th>
                    <th>Com.</th>
                    <th>Time.</th>
                    <th>Size.</th>
                    <th>Seeds</th>
                    <th>Leech</th>
                    <th>Down</th>
                    <th>Uploader</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $data['showList']; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
