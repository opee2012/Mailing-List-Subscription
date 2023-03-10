<?php
    $email = "";
    $emailErr = "";

    function test_input($data): string {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = test_input($_POST['email']);
        $error = 0;

        $regex = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@winthrop.edu/';

        if (!preg_match($regex, $email)) {
            if (empty($email)) $emailErr = "Email is required";
            else $emailErr = "Incorrect format ex. flast123@winthrop.edu";
            $error = 1;
        }
        if ($error == 1) {
            $email_Err = urlencode($emailErr);
            header("Location: subscribe.php?emailErr=$email_Err");
        } else {
            try {
                $random = bin2hex(random_bytes(10));
            } catch (Exception $e) {
            }

            $openFile = fopen('subscriptions.csv', 'a');
            fwrite($openFile, $email . "," . $random . ",false\n");

            fclose($openFile);

            $confirmation = ("Confirmation email sent to " . urlencode($email));
            header("Location: subscribe.php?confirm=$confirmation");

            $msg = "Confirm your Mailing List subscription by clicking the link below.
                    \nhttp://localhost:8081/confirm.php?confirmation=$random
                    \nThank you,\nMailing List Company";

            $msg = wordwrap($msg, 70);

            mail($email, "Confirm Subscription to Mailing List", $msg);
        }
    } else {
?>

<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <TITLE>Subscribe</TITLE>
    <STYLE>.error {color: red; font-style: italic}</STYLE>
    <STYLE>.confirm {color: green}</STYLE>
</HEAD>
<BODY>
<H3>Subscribe to Mailing List</H3>
<FORM method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <TABLE>
        <TR>
            <TD><LABEL for="sub_email">Enter Email:</LABEL></TD>
            <TD><INPUT type="text" id="sub_email" name="email"></TD>
            <TD><SPAN class="error">* <?php echo $_GET['emailErr'];?></SPAN></TD>
        </TR>
    </TABLE>
    <INPUT type="submit" value="Subscribe">
    <INPUT type="reset">
    <SPAN class="confirm"><?php echo $_GET['confirm'];?></SPAN>
</FORM>
</BODY>
</HTML>

<?php } ?>