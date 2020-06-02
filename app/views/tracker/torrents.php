<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>
<div id="home_content" class="container">
    <div style="padding: 20px 0;" align="center">
        <table class="bg-dark text-white"  border="1" cellspacing="0" cellpadding="10">
            <thead>
            <tr class="">
                <th>Search for</th>
                <th>Show Only</th>
                <th>Display categories</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                   <td>
                       <input type="text" style="width: 350px;" name="imdb_url" value=""><?php echo $data['error']['imdb']; ?><br><br>
                       <input style="float: right; background: #ECE9D8" id="" type="submit"  value="Search">
                   </td>
                    <td>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Bookmarked</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Blu-ray Torrents</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Completed</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Bumped Torrents</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">My Uploads</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Golden Torrents</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Seeds Needed</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Silver Torrents</label>
                    </td>
                    <td  align="center">
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Anime</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Japan</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Patches</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Taiwan</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">China</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Korea</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Philippines</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Thailand</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Hong Kong</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Music DVDs</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Pinku</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">TV Series</label>
                        <br>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">India</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Other Asian</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Soundtracks</label>
                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Viet Nam</label>
                        <br>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
    <div id="news" class="torrenttable_helper" align="center">
        <table class="torrenttable_helper"  border="1" cellspacing="0" cellpadding="10">
            <thead>
                <tr class="">
                    <th>Type</th>
                    <th>Name</th>
                    <th>Com.</th>
                    <th>Time</th>
                    <th>Size</th>
                    <th>Seeds</th>
                    <th>Leech</th>
                    <th>Down.</th>
                    <th>Uploader</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $data['showList']; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
