<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <form enctype="multipart/form-data" method="POST" action="<?php echo $URL_ROOT . "/upload";?>" role="form">
    <table class="bg-dark text-white" align="center" border="1" cellspacing="0" cellpadding="5" width="940">
        <tbody>
        <tr><td class="colhead" colspan="2" align="center"><b>!!Upload Experimental Test!!</b>
            </td>
        </tr>
        <tr><td class="colhead" colspan="2" align="center">The tracker's announce URL is: &nbsp;&nbsp;&nbsp;&nbsp;<b>https://twtpefxuz7.tk/announce</b>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Torrent&nbsp;file
                <span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="file" class="file" id="torrent" name="torrent_file"><span class="error"> <?php echo $data['fileErr']; ?></span>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Type<span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="dvd" checked>DVD&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="bdmw">Blu-ray disc&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="patch">Patch&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="tracklist">Soundtrack&nbsp;&nbsp;
                </label>
            </td>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Torrent&nbsp;name
                <span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" id="name" name="name" value=""><br>
                <span class="medium">(Taken from filename if not specified. <b>Please use descriptive names.</b> e.g. Blade Runner 1982 Final Cut 720p HDDVD DTS x264-ESiR)</span>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Small&nbsp;description
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="small_desc" value=""><br>
                <span class="medium">(This is shown in torrents page under the torrent name. e.g. 720p @ 4615 kbps - DTS 5.1 @ 1536 kbps)</span>
            </td>
        </tr>
        <tr class="no-music no-adult">
            <td class="rowhead nowrap" valign="top" align="right">IMDb&nbsp;URL
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="url_imdb" value=""><br>
                <span class="medium">(URL taken from <strong><a href="http://www.imdb.com/" target="_blank">IMDb</a></strong>. e.g.&nbsp;for movie <b>The Dark Knight</b> the URL is <b>http://www.imdb.com/title/tt0468569/</b>)</span>
            </td>
        </tr>
        <tr class="no-music no-adult">
            <td class="rowhead nowrap" valign="top" align="right">AniDB&nbsp;URL
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="url_anidb" value=""><br>
                <span class="medium">(URL taken from <strong><a href="https://anidb.net/" target="_blank">AniDB</a></strong>. e.g.&nbsp;for anime <b> Infinite Dendrogram</b> the URL is <b>https://anidb.net/anime/14564</b>)</span>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">NFO&nbsp;file
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="file" class="file" name="nfo"><br>
                <span class="medium">(Can only be viewed by <b class="User_Name">User</b> or Above.  insert only file ending with <b>.nfo</b>)</span>
            </td>
        </tr>
        <tr>
            <td align="right">Description</td>
            <td align="left">
                <textarea class="bbcode" cols="100" style="width: 650px;" name="big_desc" id="descr" rows="20">
                </textarea>
            </td>
        </tr>
        <tr>
            <td class="rowhead nowrap" valign="top" align="right">Show Uploader</td>
            <td class="rowfollow" valign="top" align="left">
                <input type="checkbox" name="hide_up" value="yes">Don't show my username in 'Uploaded By' field.
            </td>
        </tr>
        <tr>
            <td class="toolbox" align="center" colspan="2"><b>I read the rules before this uploading.</b>
                <input id="qr" type="submit" class="btn btn-primary mg" value="Upload">
            </td>
        </tr>
        </tbody>
    </table>
    </form>


    <?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
