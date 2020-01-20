<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="std_web" class="container">
    <div id="std_in" class="container bg-dark">
        <a class="badge bg-light font-big mg">Forum Overview</a>
        <table class="table table-striped table-bordered bg-white">
            <tbody>
            <tr class="text-center">
                <td>Forums</td>
                <td>Posts</td>
                <td>Users</td>
                <td>Comments</td>
            </tr>
            <tr class="text-center">
                <td><?php echo $data["forum_status"]["forums"] ?></td>
                <td><?php echo $data["forum_status"]["posts"] ?></td>
                <td><?php echo $data["forum_status"]["users"] ?></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>Moderators</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        <br>
        <a class="badge bg-light font-big mg">Forum Settings</a>
        <table class="table table-striped table-bordered bg-white">
            <tbody>
            <tr class="text-center">
                <td>Manage Category</td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>Manage Forums</td>
                <td>Add Forum</td>
            </tr>
            <tr class="text-center">
                <td>Manage Users</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
