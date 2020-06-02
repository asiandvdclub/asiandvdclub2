<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div class="news">
    <div class="news-heading" style="width: auto; overflow: hidden;">
        <div class="box" style="float: left;margin-right: 20px;">
            <img src="https://i.pinimg.com/236x/bf/87/a5/bf87a5b5617c16da78aeb8aa4ffe906e.jpg" width="200px" height="200px">
            <br>
            <input id="qr" type="submit" style="margin-left: 55px;" class="" value="Change Avatar">
        </div>
        <div class="box" style="overflow: hidden; padding: 20px;  height: 500px">
            <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="5">
                <thead>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                <tr></tr>
                </thead>
                <tbody>
                    <tr align="center">
                        <td style="table-layout: fixed; width: 10%;">Personal Settings</td>
                        <td style="table-layout: fixed; width: 10%;">Tracker Settings</td>
                        <td style="table-layout: fixed; width: 10%;">Forum Settings</td>
                        <td style="table-layout: fixed; width: 10%;">Security Settings</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="10">
                <thead>
                    <tr></tr>
                    <tr></tr>
                </thead>
                <tbody>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Username:</td>
                    <td><?php echo $data['user_data']['username']; ?></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Join Date:</td>
                    <td><?php echo $data['user_data']['added']; ?></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Last Seen:</td>
                    <td><?php echo $data['user_data']['last_access']; ?></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Gender:</td>
                    <td><?php echo $data['user_data']['gender']; ?></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Class:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Bonus Points:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Uploaded Torrents:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Currently Seeding:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Currently Leeching:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="table-layout: fixed; width: 10%;">Completed Torrents:</td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
    </div>
</div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
