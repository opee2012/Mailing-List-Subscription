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

    foreach ($csv as $line){
        if ($line[1] == $confirm){
            echo $confirm;
        }
    }
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