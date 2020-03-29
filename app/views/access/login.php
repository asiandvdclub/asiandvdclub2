<?php require_once $data['getLangPath']; ?>
<?php require APP_ROUTE . "/views/inc/header.php"; ?>
<form method="post" action="<?php echo URL_ROOT;?>/login" onsubmit="return verify_form()">
    <p>Note: You need cookies enabled to log in.</p>
    <input type="hidden" name="apple" value="evil">
    <table class="clean">
        <tbody>
            <tr>
                <td class="rowhead">Username</td>
                <td>
                    <input type="text" size="40" id="username" name="username" autofocus="autofocus">
                </td>
            </tr>
            <tr>
                <td class="rowhead">Password</td>
                <td>
                    <input type="password" size="40" id="password" name="password">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Log me in!" class="modern">
                </td>
            </tr>
        </tbody>
    </table>
</form>
<p>
    Don't have an account? <a class="bold" href="/signup">Sign up</a> right now!<br><br>
    Forgotten your password and/or username? <a class="bold" href="/recover">Recover them here</a>.<br><br>
    Need another <a class="bold" href="/confirm_resend">account confirmation</a> email?
</p>
<script>
    function verify_form() {
        if (document.getElementById('username').value.length === 0 || document.getElementById('password').value.length === 0) {
            alert('Error: You must supply both a username and a password in order to login.');
            return false;
        }
        return true;
    }
</script>
<?php require APP_ROUTE . "/views/inc/footer.php"; ?>