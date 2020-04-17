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
                            <td class="text-right"><?php echo $data["lang_index"]['row_registered_users'];?></td>
                            <td><?php echo $data["index_data"]['users'] . " / " . $data['index_data']['user_limit'];?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_users_active_today'];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <?php echo $data["lang_index"]['text_users_browsing_now'];?>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <?php echo $data["lang_index"]['row_warned_users'];?>
                            </td>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_torrents'];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_peers'];?></td>
                            <td>&nbsp<?php echo $data["index_data"]['peers'];?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_seeders'];?></td>
                            <td>&nbsp;<?php echo $data["index_data"]['seeders'];?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_leechers'];?></td>
                            <td>&nbsp;<?php echo $data["index_data"]['leechers'];?></td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_seeder_leecher_ratio'];?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="text-right"><?php echo $data["lang_index"]['row_unconfirmed_users'];?></td>
                            <td><?php echo $data["index_data"]['unconfirmed'];?></td>
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
