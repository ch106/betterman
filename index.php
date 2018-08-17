<?php
require("./weixin_oop.php");
$redirect_url = "http://chua.applinzi.com/logo.php";
$appid = "wx5f7e76a499956419";
$appsecret = "22ef2d429456869644a5ad2f6f7addcd";
$wx = new weixinapi($appid, $appsecret);
$base = $wx->snsapi_base($redirect_url);
$openid = $base['openid'];
echo $openid;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta http-equiv="refresh" content="2;url=exercise.html"/>
    <title>百特美健身</title>
    <link rel="stylesheet" href="css/rem.css">
    <style type="text/css">
        body {
            background: #202020;
        }

        img {
            width: 100%;
            height: 100%;
            overflow-y: hidden;
        }
    </style>
</head>
<body>
<img src="images/logo.jpg">
</body>
</html>