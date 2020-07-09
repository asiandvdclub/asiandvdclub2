<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div style="width: 1600px; overflow: auto">
    <div  style="float: left;margin-right: 30px; width: 68%">
        <h2>Tracker Info</h2>
        <div class="news">
            <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="10">
                <thead>
                <tr ></tr>
                <tr ></tr>
                <tr></tr>
                <tr></tr>
                </thead>
                <tbody >
                <tr>
                    <td  align="right" style="width: 65%">Active accounts:</td>
                    <td><?php echo $data['tracker_info']['users'];?></td>
                    <td align="right">Users active today</td>
                    <td><?php echo $data['tracker_info']['users_active_today'];?></td>
                </tr>
                <tr>
                    <td align="right">Users active last 15 min</td>
                    <td><?php echo $data['tracker_info']['users_active_last_15min'];?></td>
                    <td align="right">Active warned accounts</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">Total torrents</td>
                    <td><?php echo $data['tracker_info']['total_torrents'];?></td>
                    <td align="right">Blu-ray</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">Total peers</td>
                    <td><?php echo $data['tracker_info']['peers'];?></td>
                    <td align="right">Seeders</td>
                    <td><?php echo $data['tracker_info']['seeders'];?></td>
                </tr>
                <tr>
                    <td align="right">Leechers</td>
                    <td><?php echo $data['tracker_info']['leechers'];?></td>
                    <td align="right">Seeders/leechers ratio</td>
                    <td><?php echo $data['tracker_info']['ratio'];?></td>
                </tr>
                <tr>
                    <td align="right">User limit</td>
                    <td><?php echo $data['tracker_info']['user_limit'];?></td>
                    <td align="right">Unconfirmed Accounts:</td>
                    <td><?php echo $data['tracker_info']['unconfirmed'];?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div  style="float: left;margin-right: 30px; width: 68%">
        <h2>Tracker Settings</h2>
        <div class="news">
            <h2>Tracker Name: <?php echo SITE_NAME;?></h2>
            <a href="">change title</a>
            <h2></h2>

            <br><br><br><br>
            <div class="news-heading">Announce</div>
            <div class="news-body" style="overflow: auto">
                <input type="button" name="close_ann" value="Double Upload" onclick="window.location.href=''">
                <input type="button" name="close_ann" value="Close announce" onclick="window.location.href=''">
            </div>
        </div>
    </div>
    <div style="overflow: hidden;">
        <h2>Database Info</h2>
        <div class="news" style="height: auto; width: 400px">
            <?php print_r($data['db_status']); ?>
        </div>
    </div>
    <br>
    <div style="overflow: hidden;">
        <h2>System Info</h2>
        <div class="news" style="height: auto; width: 400px">
            <b>Ubuntu Version: </b><?php echo $data['system_info']['os_version']?>
            <p><b>PHP Version: </b> <?php echo $data['system_info']['php_version'];?></p>
           <b>PHP Modules:</b>  <?php echo $data['system_info']['php_modules'];?>
            <br><br><b>Memcached Version:</b> <?php echo $data['system_info']['memcached'] ;?>
        </div>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
