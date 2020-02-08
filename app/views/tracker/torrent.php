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
            <td><?php echo $data['torrent_lang']['small_desc'];?></td>
            <td style="padding-left: 15px"><?php echo $data['torrentData']['small_desc'];?></td>
        </tr>
        <tr>
            <td><?php echo $data['torrent_lang']['basic_info'];?></td>
            <td style="padding-left: 15px">Basic info is not set in DB yet</td>
        </tr>
        <tr>
            <td><?php echo $data['torrent_lang']['action'];?></td>
            <td style="padding-left: 15px">[<a href="<?php echo URL_ROOT . "/download/" .$data['tID']; ?>"><?php echo $data['torrent_lang']['download'];?></a>]</td>
        </tr>
    </table>
</div>
    <?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
