<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <form enctype="multipart/form-data" method="POST" action="<?php echo URL_ROOT . "/upload";?>" role="form">
    <table class="bg-dark text-white" align="center" border="1" cellspacing="0" cellpadding="5" width="940">
        <tr>
        <tr><td class="colhead" colspan="2" align="center"><b>!!Upload Experimental Test!!</b>
            </td>
        </tr>
        <tr><td class="colhead" colspan="2" align="center">The tracker's announce URL is: &nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo URL_ROOT;?>/announce</b>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Torrent&nbsp;file
                <span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="file" class="file" id="torrent" name="torrent_file"><span class="error"> <?php echo $data['error']['file']; ?></span>
            </td>
        </tr>
        <tr>
            <td class="rowhead nowrap" valign="top" align="right">Type<span class="required"></span>
            </td>
            <td id="" valign="top" align="left">
                <select id="type" name="type">
                    <option value="movie">Movie</option>
                    <option value="anime">Anime</option>
                    <option value="music">Music</option>
                </select>
            </td>
        </tr>
        <tr id="format" class="type">
            <td class="rowhead nowrap" valign="top" align="right">Format<span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="dvd" checked>DVD&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="bdmw">Blu-ray disc&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="combo">Combo (DVD and BD)&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="patch">Patch&nbsp;&nbsp;
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio" value="soundtrack">Soundtrack&nbsp;&nbsp;
                </label>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Torrent&nbsp;name
                <span class="required"></span>
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" id="name" name="torrent_name" value=""><?php echo $data['error']['torrent_name']; ?><br>
                <span class="medium">Taken from filename if not specified.</span>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">Synopsis
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="small_desc" value=""><br>
                <span class="medium">If empty data will be taken from imdb</span>
            </td>
        </tr>
        <tr id="movie" class="type">
            <td class="rowhead nowrap" valign="top" align="right"> IMDb&nbsp;URL
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="imdb_url" value=""><?php echo $data['error']['imdb']; ?><br>
                <span class="medium">(URL taken from <strong><a href="http://www.imdb.com/" target="_blank">IMDb</a></strong>. e.g.&nbsp;for movie <b>The Dark Knight</b> the URL is <b>http://www.imdb.com/title/tt0468569/</b>)</span>
            </td>
        </tr>
        <tr id="anime" class="type">
            <td class="rowhead nowrap" valign="top" align="right">AniDB&nbsp;URL
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="text" style="width: 650px;" name="url_anidb" value=""><?php echo $data['error']['anidb']; ?><br>
                <span class="medium">(URL taken from <strong><a href="https://anidb.net/" target="_blank">AniDB</a></strong>. e.g.&nbsp;for anime <b> Infinite Dendrogram</b> the URL is <b>https://anidb.net/anime/14564</b></span>
            </td>
        </tr>
        <tr id="ma0" class="type">
            <td class="rowhead nowrap" valign="top" align="right"> Quality
            </td>
            <td class="rowfollow" valign="top" align="left">
                <b>Extract: </b>
                <select id="extract">
                    <option value="bdmv">BDMV</option>
                    <option value="bdmv_iso">BDMVISO</option>
                    <option value="dvd">DVD</option>
                    <option value="dvd_iso">DVDISO</option>
                </select>
                <b>Codec: </b>
                <select id="codec">
                    <option value="avc">AVC</option>
                    <option value="h.264">H.264</option>
                    <option value="hevc">HEVC</option>
                    <option value="vc-1">VC-1</option>
                </select>
                <b>Standard: </b>
                <select id="standard" name="standard">
                    <option value="fhd">1080p</option>
                    <option value="4k">4k</option>
                    <option value="ntsc">NTSC</option>
                    <option value="pal">PAL</option>
                </select>
                <b>Processing: </b>
                <select id="processing" name="processing">
                    <option value="cn">CN</option>
                    <option value="jp">JP</option>
                    <option value="us_eu">US/EU</option>
                    <option value="hk_tw">HK/TW</option>
                </select>
            </td>
        </tr>
        <tr id="music0" class="type">
            <td class="rowhead nowrap" valign="top" align="right">Standard
            </td>
            <td class="rowfollow" valign="top" align="left">
                <select id="codec" name="codec">
                    <option value="cd">CD</option>
                    <option value="sacd">SACD</option>
                    <option value="vinyl">Vinyl</option>
                    <option value="bdmw">BDMV</option>
                </select>
            </td>
        </tr>
        <tr id="music1" class="type">
            <td class="rowhead nowrap" valign="top" align="right"> Quality
            </td>
            <td class="rowfollow" valign="top" align="left">
                <b>Codec: </b>
                <select id="codec_audio">
                    <option value="dtshd">DTS-HD</option>
                    <option value="flac">FLAC</option>
                    <option value="wav">WAV</option>
                    <option value="wv">WV</option>
                    <option value="ape">APE</option>
                </select>
                <b>Processing: </b>
                <select id="processing">
                    <option value="cd">CN</option>
                    <option value="jp">JP</option>
                    <option value="us_eu">US/EU</option>
                    <option value="hk_tw">HK/TW</option>
                </select>
            </td>
        </tr>
        <tr id="music2" class="type">
            <td class="rowhead nowrap" valign="top" align="right"> Contents
            </td>
            <td class="rowfollow" valign="top" align="left">

                <label for="vehicle1" class="checkbox-inline">CUE
                    <input type="checkbox" name="cue" value="cue">
                </label>

                <label for="vehicle1" class="checkbox-inline">LOG
                    <input type="checkbox" name="log" value="log">
                </label>

                <label for="vehicle1" class="checkbox-inline">Cover
                    <input type="checkbox" name="cover" value="cover">
                </label>
            </td>
        </tr>
        <tr class="">
            <td class="rowhead nowrap" valign="top" align="right">NFO&nbsp;file
            </td>
            <td class="rowfollow" valign="top" align="left">
                <input type="file" class="file" name="nfo"><br>
                <span class="medium">(Can only be viewed by <b class="User_Name">User</b> or Above.  insert only file ending with <b>.nfo</b></span>
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
            <td class="toolbox" align="center" colspan="2"><b>I read the rules before this uploading.</b>
                <input id="qr" type="submit" class="btn btn-primary mg" value="Upload">
            </td>
        </tr>
        </tbody>
    </table>
    </form>

    <?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
