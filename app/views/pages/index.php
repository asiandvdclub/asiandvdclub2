<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div>
    <div  style="float: left;margin-right: 30px; width: 75%">
        <h2><?php echo $data["lang_index"]['text_recent_news'];?></h2>
        <div class="news">
            <div class="news-heading">Test</div>
            <div class="news-body">
                <h2>Test</h2>
                <p>Lorem ipsum lorem ipsum</p>
            </div>
        </div>
    </div>
    <div style="overflow: hidden;  width: 300px;">
        <h2><?php echo $data["lang_index"]['text_tracker_statistics'];?></h2>
        <div class="news" style="height: auto">
            <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="10">
                <thead>
                <tr ></tr>
                <tr ></tr>
                </thead>
                <tbody >
                <tr>
                    <td  align="right" style="width: 65%">Active accounts:</td>
                    <td><?php echo $data['tracker_info']['users'];?></td>
                </tr>
                <tr>
                    <td align="right">Users active today</td>
                    <td><?php echo $data['tracker_info']['users_active_today'];?></td>
                </tr>
                <tr>
                    <td align="right">Users active last 15 min</td>
                    <td><?php echo $data['tracker_info']['users_active_last_15min'];?></td>
                </tr>
                <tr>
                    <td align="right">Active warned accounts</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">Total torrents</td>
                    <td><?php echo $data['tracker_info']['total_torrents'];?></td>
                </tr>
                <tr>
                    <td align="right">Blu-ray</td>
                    <td></td>
                </tr>
                <tr>
                    <td align="right">Total peers</td>
                    <td><?php echo $data['tracker_info']['peers'];?></td>
                </tr>
                <tr>
                    <td align="right">Seeders</td>
                    <td><?php echo $data['tracker_info']['seeders'];?></td>
                </tr>
                <tr>
                    <td align="right">Leechers</td>
                    <td><?php echo $data['tracker_info']['leechers'];?></td>
                </tr>
                <tr>
                    <td align="right">Seeders/leechers ratio</td>
                    <td><?php echo $data['tracker_info']['ratio'];?></td>
                </tr>
                <tr>
                    <td align="right">User limit</td>
                    <td><?php echo $data['tracker_info']['user_limit'];?></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>





<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
