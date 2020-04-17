<?php require_once $data['getLangPath']; ?>
<?php  require APP_ROUTE . "/views/inc/header.php"; ?>

<table class="mainouter" width="982" cellspacing="0" cellpadding="5" align="center">
    <tbody>
        <tr>
            <td id="nav_block" class="text" align="center">
                <a href="<?php echo URL_ROOT;?>/login">
                    <span class="big">
                        <b>Login</b>
                    </span></a> /
                <a href="<?php echo URL_ROOT;?>/signup">
                    <span class="big">
                        <b>Signup</b>
                    </span>
                </a>
                <form method="post" action="<?php echo URL_ROOT;?>/signup">
                    <table border="1" cellspacing="0" cellpadding="10">
                        <tbody>
                            <tr>
                                <td class="text" align="center" colspan="2">
                                   <?php echo $lang_signup['text_cookies_note']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="rowhead"><?php echo $lang_signup['row_desired_username']; ?></td>
                                <td class="rowfollow" align="left">
                                    <input type="text" style="width: 200px" name="wantusername" value="<?php echo $data['usernameValue'];?>"> <span class="error"> <?php echo $data['usernameErr']; ?></span>
                                   <br>
                                <span class="small"><?php echo $lang_signup['text_allowed_characters']; ?></span>
                                </td>
                            </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_pick_a_password']; ?></td>
                            <td class="rowfollow" align="left">
                                <input type="password" style="width: 200px" name="wantpassword"><span class="error"> <?php echo $data['passwordErr']; ?></span>
                                <br>
                                <span class="small"><?php echo $lang_signup['text_minimum_six_characters']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_enter_password_again']; ?></td>
                            <td class="rowfollow" align="left">
                                <input type="password" style="width: 200px" name="passagain"><span class="error"> <?php echo $data['passwordMatchErr']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_verification']; ?></td>
                            <td align="left">
                                    <img src="<?php echo $data['captchaImage']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_enter_hint_answer']; ?></td>
                            <td align="left">
                                <input type="text" style="width: 200px" name="captcha"> <span class="error"> <?php echo $data['captchaErr'];?></span>
                            </td>
                        </tr>
                        <tr><td class="rowhead"><?php echo $lang_signup['row_email_address']; ?>
                            </td>
                            <td class="rowfollow" align="left">
                                <input type="text" style="width: 200px" name="email"> <span class="error"> <?php echo $data['emailErr'];?></span>
                                <table width="250" border="0" cellspacing="0" cellpadding="0">
                                    <tbody>
                                        <tr>
                                            <td class="embedded">
                                                <span class="small"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="rowhead nowrap" valign="top" align="right"><?php echo $lang_signup['row_country']; ?></td>
                            <td class="rowfollow" valign="top" align="left">
                                <?php echo $data['getCountries']; ?> <span><?php echo $data['countryErr']; ?></span>
<!--                                <select name="country">-->
<!--                                    <option value="8">---- None selected ----</option>-->
<!--                                </select>-->
                            </td>
                        </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_gender']; ?></td>
                            <td class="rowfollow" align="left">
                                <input type="radio" name="gender" value="Male"><?php echo $lang_signup['radio_male']; ?> <input type="radio" name="gender" value="Female"><?php echo $lang_signup['radio_female']; ?> <span class="error"> <?php echo $data['genderErr']; ?></span>
                            </td>
                        </tr>
                            <tr>
                                <td class="rowhead">Age</td>
                                <td class="rowfollow" align="left">

                                </td>
                            </tr>
                        <tr>
                            <td class="rowhead"><?php echo $lang_signup['row_verification']; ?></td>
                            <td class="rowfollow" align="left">
                                <input type="checkbox" name="rulesverify" value="yes"><?php echo $lang_signup['checkbox_read_rules']; ?><br>
                                <input type="checkbox" name="faqverify" value="yes"><?php echo $lang_signup['checkbox_read_faq']; ?> <br>
                                <input type="checkbox" name="ageverify" value="yes"><?php echo $lang_signup['checkbox_age']; ?>
                            </td>
                        </tr>
                        <input type="hidden" name="hash" value="">
                        <tr>
                            <td class="toolbox" colspan="2" align="center">
                                <span color="red"><b><?php echo $lang_signup['text_all_fields_required']; ?> </b></span>
                                <p><span color="red"></span>
                                    <input type="submit" value="<?php echo $lang_signup['submit_sign_up']; ?>" style="height: 25px">
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </td>
        </tr>
    </tbody>
</table>
<?php require APP_ROUTE . "/views/inc/footer.php"; ?>
