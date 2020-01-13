<?php require APP_ROUTE . '/views/inc/navbar_header.php';?>
    <div id="std_web" class="container">
        <div id="news" class="container">
            <form method="post" action="<?php echo URL_ROOT . "/create_news";?>" class="was-validated" novalidate>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th id="res">Subject</th>
                        <th> <input name="title" class="form-control" required> </th>
                    </tr>
                    <tr>
                        <th>Body</th>
                        <th>
                            <table id="table2" class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="2">Row 1</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Row 2</td>
                                </tr>
                                <tr>
                                    <td><textarea name="text_area" class="form-control" id="texarea1" rows="3" required></textarea></td>
                                    <td>Emoji</td>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                    <tr align="center">

                        <th>  </th>
                        <th>
                            <button type="submit" class="btn btn-primary">Add news</button>
                        </th>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php require APP_ROUTE . '/views/inc/navbar_footer.php';?>