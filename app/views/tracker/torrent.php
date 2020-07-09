<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>
<style>
    table {
        table-layout: auto;
        border-collapse: collapse;
        width: 50%;
    }
    table td {
        border: 1px solid #ccc;
    }
    table .absorbing-column {
        width: 50%;
    }
</style>
<div class="container">
    <table class="bg-dark text-white center" align="center">
        <tr align="center">
            <th  colspan="2">!Torrent Page Test!</th>
        </tr>
        <tr>
            <td style="width: 20%"><?php echo $data['torrent_lang']['torrent_name'];?></td>
            <td style="padding-left: 15px"><?php echo $data['torrentData']['name'];?></td>
        </tr>
        <tr>
            <td style="width: 20%"><?php echo $data['torrent_lang']['uploader'];?></td>
            <td style="padding-left: 15px"><?php echo $data['torrentData']['username'];?></td>
        </tr>
        <tr>
            <td><?php echo $data['torrent_lang']['basic_info'];?></td>
            <td style="padding-left: 15px"><?php echo "Size: " . formatBytes($data['torrentData']['size']) . "&emsp;Format: " . $data['torrentData']['specs']['format'] . "&emsp; Codec: " . $data['torrentData']['specs']['codec'] . "&emsp;Standard: " . $data['torrentData']['specs']['standard'] . "&emsp;Processing: " . $data['torrentData']['specs']['processing'];?></td>
        </tr>
        <!--
        <tr>
            <td>Plot</td>
            <td style="padding-left: 15px"><?php echo $data['content_data']['synopsis'] . substr($data['content_data']['synopsis'], 0, strpos($data['content_data']['synopsis'], "::")); ?></td>
        </tr>
        -->
        <tr>
            <td>Image</td>
            <td style="padding-left: 15px"><?php echo  "<img src=\"" .  $data['content_data']['url'] . "\" width=\"200\" height=\"300\">";?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td style="padding-left: 15px"><?php echo $data['torrentData']['desc'];?></td>
        </tr>
        <tr>
            <td>Mediainfo</td>
            <td style="padding-left: 15px"><?php echo $data['torrentData']['media_info'];?></td>
        </tr>
        <tr>
            <td>Content Info</td>
            <td style="padding-left: 15px;" align="left">
                <p style="font-size: large"><?php echo $data['content_data']['content_site_name'];?></p>
                <?php echo $data['content_data']['content_link_name'];?>: <a href="http://anidb.net/a<?php echo  $data['content_data']['anidb_id'];?>">http://anidb.net/a<?php echo  $data['content_data']['anidb_id'];?></a>
                <br>
                Title: <?php echo  $data['content_data']['title'];?>
                <br>
                Original Title: <?php echo  $data['content_data']['title_jp'];?>
                <br>
                Type: <?php echo  $data['content_data']['type'];?>
                <br>
                Year: <?php echo  $data['content_data']['year'];?>
                <br>
                <p style="font-size: large">Plot</p>
                <br>
                <?php echo  $data['content_data']['synopsis'];?>
            </td>
        </tr>
        <tr>
            <td>Torrent Info</td>
            <td style="padding-left: 15px"><?php echo  $data['torrent_lang']['text_files'] . ": " . $data['torrentData']['numfiles'] . " " . $data['torrent_lang']['text_infohash'] . ": " . $data['torrentData']['info_hash'] ?> </td>
        </tr>
        <tr>
            <td>Peers</td>
            <td style="padding-left: 15px"><?php echo  $data['torrentData']['seeders'] . " Seeders | " .  $data['torrentData']['leechers'] . " Peers" ;?></td>
        </tr>
        <tr>
            <td><?php echo $data['torrent_lang']['action'];?></td>
            <td style="padding-left: 15px">[<a href="<?php echo URL_ROOT . "/download/" .$data['tID']; ?>"><?php echo $data['torrent_lang']['download'];?></a>]</td>
        </tr>
    </table>
    <br>
    <?php echo $data['comments']; ?>
    <br>
    <div class="" align="center">
        <form enctype="multipart/form-data" method="POST" action="<?php echo URL_ROOT . "/torrent/" . $data['torrentData']['torrent_id'];?>" role="form">
            <table class="bg-dark text-white center" align="center">
                <tr align="center">
                    <th  colspan="2">Quick Comment</th>
                </tr>
                <tr align="center">
                    <th>
                        <textarea class="txtarea" style="height:50px;" rows="5" cols="50" name="comment_desc" Id="text" value=""> </textarea>
                    </th>
                </tr>
                <tr align="center">
                    <th>
                        <button class="btn btn-info text-center" name="add"  type="submit" onsubmit="return false">Add</button>
                    </th>
                </tr>
            </table>
        </form>
    </div>
    <br>
</div>
<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
