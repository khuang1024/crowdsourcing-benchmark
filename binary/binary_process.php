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
<script language="javascript">
    var clip = null;
    function init(){
        // set path
        ZeroClipboard.setMoviePath('./ZeroClipboard.swf');

        //create client
        clip = new ZeroClipboard.Client();
        clip.setHandCursor( true );

        clip.addEventListener('load', function (client) {
            alert("hello");
            alert(document.getElementById('token').value);
        });

        //event
        clip.addEventListener('mouseOver',function(client) {
            //alert("asdadsads");
            //document.write(document.getElementById('token'));
            alert(document.getElementById('token').value);
            //clip.setText(document.getElementById('box-content').value);
        });

        clip.addEventListener('complete', function(client,text) {
          alert('copied: ' + text);
        });

        //glue it to the button
        clip.glue('copy');
    }
</script>
<style type="text/css">
    body {
        margin:0 auto;
        text-align: center;
    }
</style>
</head>
<body onLoad="init()">
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

    // start with a blank string
    $hms = "";
    
    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600); 

    // add hours to $hms (with a leading 0 if asked for)
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. ":";
    
    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
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
$content = $answer.$delimiter.$img1.$delimiter.$img2.$delimiter.$token.$delimiter.(strval($counter)).$delimiter.gmdate("F-d-H:i:s", $startTime).$delimiter.gmdate("F-d-H:i:s", $endTime).$delimiter.time_difference($startTime - $endTime)."\n";
writeLog("log.txt", $content."\n");

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
