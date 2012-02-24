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
<style type="text/css">
    body {
        margin:0 auto;
        text-align: center;
    }
</style>
<script type="text/javascript">
    function validate(){
        for (var i = 0; i < document.binaryForm.answer.length; i++) {
            if (document.binaryForm.answer[i].checked) {
                return true;
            }
        }
        return false;
    }
    function next(){
        if (validate()){
            document.binaryForm.action='binary.php';
            document.binaryForm.submit();
        } else {
            alert ("Please choose one image.");
        }
    }
    function xsubmit(){
        if (validate()){
            document.binaryForm.action='binary_process.php';
            document.binaryForm.submit();
        } else {
            alert ("Please choose one image.");
        }
    }
</script>
</head>
<body>
    <center>
        <br />
        <br />
        <h3>Please choose the image which has <font color="red">fewer</font> dots.</h3>
        <p>The payment depends on <font color="red">the number of images</font>. Each image is $0.01 .</p>
        <p>You can work on as many images as you like, and stop whenever you want.</p>
        <p>Click "Next" button to continue this task.</p>
        <p>Click "Submit" button to finish task.</p>

<?php
function getRandomString() {
    $length = 10;
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

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


$delimiter = ", ";
$startTime = $_POST['startTime'];
$endTime = time();
$token = $_POST['token'];
$answer = $_POST['answer'];
$img1 = $_POST['img1'];
$img2 = $_POST['img2'];
$counter = intval($_POST['counter']) + 2;
$fileName = "log.txt";

if (!is_null($startTime) && !is_null($token)) {
    // when it is the continued page of the session
    $content = $answer.$delimiter.$img1.$delimiter.$img2.$delimiter.$token.$delimiter.(strval($counter)).$delimiter.gmdate("F-d-H:i:s", $startTime).$delimiter.gmdate("F-d-H:i:s", $endTime).$delimiter.time_difference($startTime - $endTime)."\n";
    writeLog($fileName,$content);
} else {
    // if it is first time, generate the token
    $token = getRandomString();
    $counter = 0;
}

$startTime = $endTime;
$img1 = "../dataset/1000/1.jpg";
$img2 = "../dataset/1000/2.jpg";

//
//
echo "<form name=\"binaryForm\" action=\"\" method=\"post\">";
echo "    <table style=\"text-align:center\" cellspacing=\"30\">";
echo "        <tr>";
echo "            <td><img border=\"1\" src=\"$img1\" width=\"300\"></img></td>";
echo "            <td><img border=\"1\" src=\"$img2\" width=\"300\"></img></td>";
echo "        </tr>";
echo "        <tr>";
echo "            <td><input type=\"radio\" name=\"answer\" value=\"$img1\"></input></td>";
echo "            <td><input type=\"radio\" name=\"answer\" value=\"$img2\"></input></td>";
echo "        </tr>";
echo "    </table>";
echo "    <input type=\"hidden\" name=\"startTime\" value=\"$startTime\"></input>";
echo "    <input type=\"hidden\" name=\"img1\" value=\"$img1\"></input>";
echo "    <input type=\"hidden\" name=\"img2\" value=\"$img2\"></input>";
echo "    <input type=\"hidden\" name=\"counter\" value=\"$counter\"></input>";
echo "    <input type=\"hidden\" name=\"token\" value=\"$token\"></input>";
echo "    <input type=\"button\" name=\"Next\" value=\"Next\" onClick=\"next()\" />";
echo "    <input type=\"button\" name=\"Submit\" value=\"Submit\" onClick=\"xsubmit()\" />";
echo "<br />";
echo "<br />";
echo "So far, you have already done <font color=\"red\"> $counter </font> images.";
//echo "    <input type=\"submit\" value=\"submit\" style=\"text-align:center\"></input>";
echo "    </form>";
echo "</body>";
?>
