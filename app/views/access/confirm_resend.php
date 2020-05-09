<?php require APP_ROUTE . "/views/inc/header.php"; ?>
<form method="post" action="<?php echo URL_ROOT;?>/confirm_resend">
    <table class="mainouter" width="982" cellspacing="0" cellpadding="5" align="center">
        <tbody align="center">
        <tr>
            <td><h1>Resend account confirmation email</h1><br>Use the form below to have another confirmation email for your account sent to you.</td>

        </tr>
        <tr>
            <td> <b>Registered email: <input type="text" id="lname" name="email"><?php echo (!empty($data['emailErr']) ? " " . $data['emailErr'] : "");?><br></b> </td>
        </tr>
        <tr>
            <td><input type="submit" value="Send confirmation email"></td>
        </tr>
        </tbody>
    </table>
</form>
<?php require APP_ROUTE . "/views/inc/footer.php"; ?>