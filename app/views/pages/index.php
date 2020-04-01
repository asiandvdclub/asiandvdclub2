<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>


<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2><?php echo $data["lang_index"]['text_recent_news'];?></h2>
            <div class="bloc">
                <?php echo $data['news']; ?>
            </div>
        </div>
        <div class="col-md-4">
            <h2><?php echo $data["lang_index"]['text_tracker_statistics'];?></h2>
            <div class="bloc">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="text-right">
                                <?php echo $data["lang_index"]['row_users_active_today'];?>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <?php echo $data["lang_index"]['row_users_active_this_week'];?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_registered_users'];?></td>
                            <td><?php echo $data["index_data"]['users'] . "/" . "max_server";?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_unconfirmed_users'];?></td>
                            <td><?php echo $data["index_data"]['unconfirmed'];?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"][''];?></td>
                            <td>&nbsp;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <h2><?php echo $data["lang_index"]['text_polls']; ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $data["lang_index"]['text_disclaimer'];?>
        </div>
    </div>
</div>

<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
