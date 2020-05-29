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
            <td><?php echo $data['torrent_lang']['basic_info'];?></td>
            <td style="padding-left: 15px"><?php echo "Size: " . formatBytes($data['torrentData']['size']) . "&emsp;Format: " . $data['torrentData']['specs']['format'] . "&emsp; Codec: " . $data['torrentData']['specs']['codec'] . "&emsp;Standard: " . $data['torrentData']['specs']['standard'] . "&emsp;Processing: " . $data['torrentData']['specs']['processing'];?></td>
        </tr>
        <tr>
            <td>Plot</td>
            <td style="padding-left: 15px"><?php echo substr($data['content_data']['plot'], 0, strpos($data['content_data']['plot'], "::")); ?></td>
        </tr>
        <tr>
            <td>Image</td>
            <td style="padding-left: 15px"><?php echo  "<img src=\"" .  $data['content_data']['url'] . "\" width=\"200\" height=\"300\">";?></td>
        </tr>
        <tr>
            <td>Description</td>
            <td style="padding-left: 15px"></td>
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
    <form  method="post">
        <table class="bg-dark text-white center" align="center">
            <tr align="center">
                <th  colspan="2">Quick Comment</th>

            </tr>
            <tr align="center">
                <th>
                    <textarea id="comment" rows="4" cols="50">
                    </textarea>
                </th>
            </tr>
            <tr align="center">
                <th>
                    <button class="btn btn-info text-center"  type="button">Add</button>
                </th>
            </tr>
        </table>
    </form>
    <br>
</div>
<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
