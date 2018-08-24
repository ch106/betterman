<?php
require "./weixin_oop.php";

define("TOKEN","test");

$wx = new WeixinApi();

if(isset($_GET['echostr']))
{
    echo $wx->valid();
}
else
{
    echo $wx->responseMsg();
}
?>