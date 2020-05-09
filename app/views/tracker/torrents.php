<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div style="padding: 20px 0;">
    Search Will be Here
</div>
<table class="torrenttable">
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

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
