<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div style="width: 1600px; height: 300px">
    <div  style="float: left;margin-right: 30px; width: 100%">
        <h2>Forum Overview</h2>
        <div class="news">
            <div class="news-heading"></div>
            <table class="table" style="width: 700px; " cellspacing="0" cellpadding="10">
                <thead>
                <tr class="">
                    <th>Categorys</th>
                    <th>Forums</th>
                    <th>Topics</th>
                    <th>Posts</th>
                    <th>Blocked users to post</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div  style="float: left;margin-right: 30px; width: 100%">
        <h2>Forum Settings</h2>
        <div class="news">
            <?php echo $data['error']; ?>
            <?php echo $data['view_settings']; ?>
            <!--
            <div class="news-heading"></div>
            <div class="news-body">

            </div>
            -->
        </div>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
