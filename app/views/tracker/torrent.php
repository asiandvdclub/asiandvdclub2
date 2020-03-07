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
            <td style="padding-left: 15px"><?php echo "Size: " . formatBytes($data['torrentData']['size']) . "&emsp;Format: " . $data['torrentInfo']['format'] . "&emsp; Codec: " . $data['torrentInfo']['codec'] . "&emsp;Standard: " . $data['torrentInfo']['standard'] . "&emsp;Processing: " . $data['torrentInfo']['processing'];?></td>
        </tr>
        <tr>
            <td>Plot</td>
            <td style="padding-left: 15px"><?php echo substr($data['imdb_info']['plot'], 0, strpos($data['imdb_info']['plot'], "::"));; ?></td>
        </tr>
        <tr>
            <td><?php echo $data['torrent_lang']['action'];?></td>
            <td style="padding-left: 15px">[<a href="<?php echo URL_ROOT . "/download/" .$data['tID']; ?>"><?php echo $data['torrent_lang']['download'];?></a>]</td>
        </tr>
    </table>
</div>
    <?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
