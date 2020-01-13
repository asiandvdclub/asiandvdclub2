<?php require APP_ROUTE . "/views/inc/header.php"; ?>

<table class="mainouter" width="982" cellspacing="0" cellpadding="5" align="center">
    <tbody>
        <tr>
            <td id="nav_block" class="text" align="center">
                <a href="<?php echo URL_ROOT;?>/login">
                    <span class="big">
                        <b>Login</b>
                    </span>
                </a> /
                <a href="<?php echo URL_ROOT;?>/login">
                    <span class="big">
                        <b>Signup</b>
                    </span>
                </a>
                <form method="post" action="<?php echo URL_ROOT;?>/failedlogin">
                    <div align="right" valign="top"><?php echo $lang_signup['text_select_lang']; ?>
                        <?php echo $data['getLangDropdown']; ?>
                    </div>
                </form>
                <table align="center" class="main" width="500" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td class="embedded">
                                <h2>Login failed!</h2>
                                <table width="100%" border="1" cellspacing="0" cellpadding="10">
                                    <tbody>
                                    <tr>
                                        <td class="text">
                                            <b>Error</b>: Username or password incorrect! Or you are not confirmed yet<br><br>Don't remember your password? <b>
                                                <a href="<?php echo URL_ROOT;?>/recover">Recover</a>
                                            </b> your password!
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<?php require APP_ROUTE . "/views/inc/footer.php"; ?>