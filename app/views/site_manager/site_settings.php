<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="bloc">
                <h2>Tracker Settings</h2>
                <div class="row justify-content-md-center">
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Turn on/off signup</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Clear Cache</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Maintenance</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Stop Announce</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Remove Torrent</button>
                    </div>
                </div>
            </div>
            <div class="bloc">
               <h2>User Settings</h2>
                <div class="row justify-content-md-center">
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Add user</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Ban User</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Change Username</button>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-info text-center"  type="button">Remove user</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bloc">
                <div class="row justify-content-md-center">
                    <div class="row">
                        Tracker Status
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-3">
                        User Count:
                    </div>
                    <div class="col-md-1">
                        0
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-3">
                        Total upload
                    </div>
                    <div class="col-md-1">
                        0
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-3">
                        Total download
                    </div>
                    <div class="col-md-1">
                        0
                    </div>
                </div>
            </div>
            <div class="bloc">
                <div class="row justify-content-md-center">
                    <div class="row">
                        Database Status
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                    <?php echo $data['db_status']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
