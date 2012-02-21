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
</head>
<body>
    <center>
        <br />
        <br />
        <h3>Please choose the image which has <font color="red">fewer</font> dots.</h3>
    <?php
    $img1 = "../dataset/1000/1.jpg";
    $img2 = "../dataset/1000/2.jpg";
    $startTime = time();
    //$img1 = $_GET["url1"];
    //$img2 = $_GET["url2"];
    ?>
    <form action="binary_process.php" method="post">
        <table style="text-align:center" cellspacing="30">
            <tr>
                <td><img border="1" src="<?php echo $img1; ?>" width="300"></img></td>
                <td><img border="1" src="<?php echo $img2; ?>" width="300"></img></td>
            </tr>
            <tr>
                <td><input type="radio" name="img" value="<?php echo $img1; ?>"></input></td>
                <td><input type="radio" name="img" value="<?php echo $img2; ?>"></input></td>
                <td><input type="hidden" name="img1" value="<?php echo $img1; ?>"></input></td>
                <td><input type="hidden" name="img2" value="<?php echo $img2; ?>"></input></td>
                <td><input type="hidden" name="startTime" value="<?php echo $startTime; ?>"></input></td>
            </tr>
            <tr>
                <td>
                </td>
                </tr>
        </table>
        <input type="submit" value="submit" style="text-align:center"></input>
    </form>
</body>
