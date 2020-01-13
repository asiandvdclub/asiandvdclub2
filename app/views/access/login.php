<?php require_once $data['getLangPath']; ?>
<?php require APP_ROUTE . "/views/inc/header.php"; ?>

<table class="mainouter" width="982" cellspacing="0" cellpadding="5" align="center">
    <tbody>
        <tr>
            <td id="nav_block" class="nav_bg text" align="center">
                <a href="<?php echo URL_ROOT;?>/login"><span class="big"><b>Login</b></span></a> /

                <a href="<?php echo URL_ROOT?>/signup"><span class="big"><b>Signup</b></span></a>

                <form method="post" action="<?php echo URL_ROOT;?>/login">
                    <div align="right"><?php echo $lang_login['text_select_lang']; ?>
                        <!--  <select name="sitelanguage" onchange="submit()">  This needs to be a for from database -->
                        <?php echo $data['getLangDropdown']; ?>
                    </div>
                </form>
                <form method="post" action="<?php echo URL_ROOT;?>/login">
                    <p><?php echo $lang_login['p_need_cookies_enables'];?><br> [<b>10</b>] <?php echo $lang_login['p_fail_ban'];?></p>
                    <p><?php echo $lang_login['p_you_have'];?> <b><span color="green" size="2">[10]</span></b> <?php echo $lang_login['p_remaining_tries']; ?></p>
                    <table border="0" cellpadding="5">
                        <tbody>
                            <tr>
                                <td class="rowhead"><?php echo $lang_login['rowhead_username'];?></td>
                                <td class="rowfollow" align="left">
                                    <input type="text" name="username"  style="width: 180px; border: 1px solid gray"><span class="error"> <?php echo $data['usernameErr']; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="rowhead"><?php echo $lang_login['rowhead_password'];?></td>
                                    <td class="rowfollow" align="left">
                                        <input type="password" name="password"  style="width: 180px; border: 1px solid gray"><span class="error"> <?php echo $data['passwordErr']; ?></span>
                                    </td>
                            </tr>
                            <tr>
                                <td class="toolbox" colspan="2" align="left"><?php echo $lang_login['text_advanced_options'];?></td>
                            </tr>
                            <tr>
                                <td class="rowhead"><?php echo $lang_login['text_auto_logout'];?></td>
                                <td class="rowfollow" align="left">
                                    <input class="checkbox" type="checkbox" name="logout" value="yes"> <?php echo $lang_login['checkbox_auto_logout'];?>
                                </td>
                            </tr>
                            <tr><td class="rowhead"><?php echo $lang_login['text_restrict_ip'];?></td>
                                <td class="rowfollow" align="left">
                                    <input class="checkbox" type="checkbox" name="securelogin" value="yes"> <?php echo $lang_login['checkbox_restrict_ip'];?>
                                </td>
                            </tr>
                            <tr><td class="rowhead"><?php echo $lang_login['text_ssl'];?></td>
                                <td class="rowfollow" align="left">
                                    <input class="checkbox" type="checkbox" name="ssl" value="yes" checked="checked" disabled="disabled"> <?php echo $lang_login['checkbox_ssl'];?><br>
                                   </td>
                            </tr>
                            <tr><td class="toolbox" colspan="2" align="right"><input type="submit" value="Login!" class="btn">
                                    <input type="reset" value="Reset" class="btn">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <p style="color:red;">Forum with bootstrap inside. Work in progress. Sing up offline.</p>
                <p><?php echo $lang_login['p_no_account_signup'];?></p>
                <p> <?php echo $lang_login['p_forget_pass_recover'];?></p>
                <p><?php echo $lang_login['p_resend_confirm'];?></p>
            </td>
        </tr>
    </tbody>
</table>
<?php require APP_ROUTE . "/views/inc/footer.php"; ?>