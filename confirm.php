<?php
    $confirm = $_GET["confirmation"];

    function csvToArray(): array {
        $lines[] = null;
        if (file_exists("subscriptions.csv")) {
            $file = fopen("subscriptions.csv", 'r');
            while (!feof($file)) {
                $lines[] = fgetcsv($file, 1000);
            }
            fclose($file);
        }
        return $lines;
    }

    $csv = csvToArray();

    for ($i = 0; $i < sizeof($csv); $i++) {
        if ($csv[$i][1] == $confirm) {
            $csv[$i][2] = "true";
            $email = $csv[$i][0];

            $msg = "Thank you for confirming your email. You are now subscribed and will begin receiving emails from us.
                    \nThank you,\nMailing List Company";

            $msg = wordwrap($msg, 70);

            mail($email, "Email Confirmed", $msg);
        }
    }

    $file = fopen("subscriptions.csv","w");

    foreach ($csv as $line) {
        fputcsv($file, $line);
    }

    fclose($file)
?>

<!DOCTYPE html>
<HTML lang="en">
<HEAD>
    <TITLE>Confirmation</TITLE>
</HEAD>
<BODY>
<H3>Thank you for subscribing!</H3>
</BODY>
</HTML>