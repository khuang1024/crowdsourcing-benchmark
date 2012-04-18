<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Binary Predicate</title>
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript" src="cufon-yui.js"></script>
<script type="text/javascript" src="Arial_400-Arial_700.font.js"></script>
<script type="text/javascript" src="general.js"></script>
<script type="text/javascript" src="./ZeroClipboard.js"></script>
<style type="text/css">
    body {
        margin:0 auto;
        text-align: center;
    }
</style>
</head>
<body>
<?php
function writeLog($fileName, $content) {
    if (is_writable($fileName)) {
        if (!$handle = fopen($fileName, 'a')) {
            echo "Cannot open file ($fileName)";
            exit;
        }

        if (fwrite($handle, $content) === false) {
            echo "Cannot write to file ($fileName)";
            exit;
        }

        fclose($handle);

    } else {
        echo "The file $fileName is not writable.";
    }
}
function sec2hms ($sec, $padHours = false) {
    $hms = "";
    $hours = intval(intval($sec) / 3600); 
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. ":";
    $minutes = intval(($sec / 60) % 60); 
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";
    $seconds = intval($sec % 60); 
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}
function time_difference($endtime){
    $days= (date("j",$endtime)-1);
    $months =(date("n",$endtime)-1);
    $years =(date("Y",$endtime)-1970);
    $hours =date("G",$endtime);
    $mins =date("i",$endtime);
    $secs =date("s",$endtime);
    $diff="day=".$days."&month=".$months."&year=".$years."&hour=".$hours."&min=".$mins."&sec=".$secs;
    return $diff;
}


// store info on server
$delimiter = ", ";
$startTime = $_POST['startTime'];
$endTime = time();
$token = $_POST['token'];
$answer = $_POST['answer'];
$img1 = $_POST['img1'];
$img2 = $_POST['img2'];
$counter = intval($_POST['counter']) + 2;
$fileName = "log.txt";

if (is_null($answer)) {
    $counter = $_POST['counter'];
} else {
    $counter = $_POST['counter'] + 2;
    $content = $answer.$delimiter.$img1.$delimiter.$img2.$delimiter.$token.$delimiter.(strval($counter)).$delimiter.gmdate("F-d-H:i:s", $startTime).$delimiter.gmdate("F-d-H:i:s", $endTime).$delimiter.time_difference($startTime - $endTime)."\n";
    writeLog("log.txt", $content."\n");
}

// confirmation
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
echo "<br />";
//echo "<center>";
echo "<h3>";
echo "Submitted successful, thank you! <br />\n";
echo "<br />";
echo "You processed <font color=\"red\">$counter</font> images.<br /> Please use the token below as your answer token: ";
echo "<br />";
echo "<br />";
echo "<font color=\"red\"><div id=\"token\" value=\"$token\">".$token."</div></font><br />\n";
echo "</h3>\n";
//echo "</center>";
?>
</body>
