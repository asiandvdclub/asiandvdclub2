<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <form enctype="multipart/form-data" method="POST" action="<?php echo $URL_ROOT . "/upload";?>" role="form">
        <table class="bg-dark text-white" align="center" border="1" cellspacing="0" cellpadding="5" width="940">
            <tr>
            <tr><td class="colhead" colspan="2" align="center"><b>!!Request Experimental Test!!</b>
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

            <tr class="">
                <td class="rowhead nowrap" valign="top" align="right">Request&nbsp;Title
                    <span class="required"></span>
                </td>
                <td class="rowfollow" valign="top" align="left">
                    <input type="text" style="width: 650px;" id="name" name="req_title" value=""><?php echo $data['error']['title']; ?><br>
                </td>
            </tr>
            <tr id="movie" class="type">
                <td class="rowhead nowrap" valign="top" align="right"> IMDb&nbsp;URL
                </td>
                <td class="rowfollow" valign="top" align="left">
                    <input type="text" style="width: 650px;" name="imdb_url" value=""><?php echo $data['error']['content_link']; ?><br>
                    <span class="medium">(URL taken from <strong><a href="http://www.imdb.com/" target="_blank">IMDb</a></strong>. e.g.&nbsp;for movie <b>The Dark Knight</b> the URL is <b>http://www.imdb.com/title/tt0468569/</b>)</span>
                </td>
            </tr>
            <tr id="anime" class="type">
                <td class="rowhead nowrap" valign="top" align="right">AniDB&nbsp;URL
                </td>
                <td class="rowfollow" valign="top" align="left">
                    <input type="text" style="width: 650px;" name="anidb_url" value=""><?php echo $data['error']['content_link']; ?><br>
                    <span class="medium">(URL taken from <strong><a href="https://anidb.net/" target="_blank">AniDB</a></strong>. e.g.&nbsp;for anime <b> Infinite Dendrogram</b> the URL is <b>https://anidb.net/anime/14564</b></span>
                </td>
            </tr>

            <tr>
                <td align="right">Description</td>
                <td align="left">
                <?php echo $data['error']['description']; ?><br>
                <textarea class="bbcode" cols="100" style="width: 650px;" name="big_desc" id="descr" rows="20">
                </textarea>
                </td>
            </tr>
            <tr>
                <td class="toolbox" align="center" colspan="2">
                    <input id="qr" type="submit" class="btn btn-primary mg" value="Upload">
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
