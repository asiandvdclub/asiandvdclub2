<?php require_once APP_ROUTE . '/views/inc/navbar_header.php';?>

<div id="home_content" class="container">
    <div id="news" class="container">
        <form method="post" class="col-md-12 form-inline form-horizontal" role="form">
            <label class="control-label col-sm-5" for="jbe"><i class="icon-envelope"></i> Torrent type (text) </label>
            <div class="input-group col-sm-5">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                <label class="form-check-label" for="inlineRadio1">DVD</label>
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                <label class="form-check-label" for="inlineRadio2">Blu-ray Disc</label>
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option3">
                <label class="form-check-label" for="inlineRadio3">Patch</label>
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option4">
                <label class="form-check-label" for="inlineRadio4">Soundtrack</label>
            </span>
            </div>
            <label class="control-label col-sm-5" for="jbe"><i class="icon-envelope"></i> Torrent File (text) </label>
            <div class="input-group col-sm-7">
                <input type="file" class="form-control-file" id="exampleFormControlFile1">
            </div>
            <label class="control-label col-sm-5" for="jbe"><i class="icon-envelope"></i> Torrent Name (text) </label>
            <div class="input-group col-sm-7">
                <input class="form-control" type="text" placeholder="Default input">
            </div>
        </form>

    </div>
    <br>
    <div id="news" class="container">
        Submit
    </div>
</div>

<?php require_once APP_ROUTE . '/views/inc/navbar_footer.php';?>
