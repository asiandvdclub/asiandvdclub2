<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>


<div id="std_web" class="container">
    <div id="std_in" class="container bg-dark">
        <a class="badge bg-light font-big mg"><?php echo $data["lang_index"]['text_recent_news'];?></a>
        <?php echo $data['news']; ?>
    </div>

    <div id="pools" class="container bg-dark">
        <a class="badge bg-light font-big mg"><?php echo $data["lang_index"]['text_polls'];?></a>

    </div>
    <div id="tracker_stats" class="container bg-dark">
        <a class="badge bg-light font-big mg"><?php echo $data["lang_index"]['text_tracker_statistics'];?></a>
        <table  class="table table-striped table-bordered bg-white">
            <tbody class="text-right">
            <tr>
                <td><?php echo $data["lang_index"]['row_users_active_today'];?></td>
                <td></td>
                <td><?php echo $data["lang_index"]['row_users_active_this_week'];?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $data["lang_index"]['row_registered_users'];?></td>
                <td>&nbsp;</td>
                <td><?php echo $data["lang_index"]['row_unconfirmed_users'];?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
                <td><?php echo $data["lang_index"][''];?></td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div id="disclaimer" class="container bg-dark">
        <a class="badge bg-light font-big mg"><?php echo $data["lang_index"]['text_disclaimer'];?></a>
    </div>
</div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
