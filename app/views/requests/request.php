<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

    <div class="news">
        <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="10">
            <tbody align="left">
            <tr align="center">
                <td colspan="3"><?php echo $data['request_data']['title'];?></td>
            </tr>
            <tr>
                <td width="50px">Type</td>
                <td colspan="2"><?php echo ucwords($data['request_data']['type']);?></td>
            </tr>
            <tr>
                <td width="50px"><?php echo $data['request_data']['web_name'];?></td>
                <td colspan="2"><a href="<?php echo $data['request_data']['content_url'];?>" target="_blank"><?php echo $data['request_data']['content_url'];?></a></td>
            </tr>
            <tr>
                <td width="50px" height="200px">Description</td>
                <td colspan="2"><?php echo $data['request_data']['description'];?></td>
            </tr>
            <tr>
                <td width="50px">Added:</td>
                <td colspan="2"><?php echo $data['request_data']['date'];?></td>
            </tr>
            <tr>
                <td width="110px">Requested By:</td>
                <td colspan="2"><?php echo $data['request_data']['username'];?></td>
            </tr>
            <tr>
                <td width="50px">Vote for this request:</td>
                <td colspan="2"><?php echo $data['request_vote'];?></td>
            </tr>
            </tbody>
        </table>
    </div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>