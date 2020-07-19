<?php require APP_ROUTE . '/views/inc/navbar_header.php';?>
<div id="news" class="torrenttable_helper" align="center">
    <!--
    <table class="torrenttable_helper"  border="0" cellspacing="0" cellpadding="10">
        <tbody style="border: none;">
        <tr>
            <th colspan="4" style="text-align: left">General Forums</th>
        </tr>
        <tr style=" background: #D7D7D7;">
            <td style="text-align: left;border-right: none; width: 1000px; overflow: auto">Forum</td>
            <td style="border: none; text-align: center;">Topics</td>
            <td style="border: none; text-align: center;">Posts</td>
            <td style="border-left: none; text-align: center;">Last Post</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
    -->
    <?php echo $data['display_forums']; ?>
</div>
<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>
