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
            <tr>
                <th style="width: 200px"><a href="<?php echo URL_ROOT . "/forum_manager_forums"; ?>">Manage Forums</a></th>
                <th class="border-left" rowspan="3">Hello data</th>
            </tr>
            <tr>
                <td><a href="">Manage Users</a></td>
            </tr>
            <tr>
                <td><a href="#">Manages Posts</a></td>
            </tr>
        </table>

    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
