//<?php
//session_start();
////$openid = $_SESSION['openid'];
////?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/rem.css">
    <title>百特美健身</title>
    <style>
        @font-face {
            font-family: 'iconfont';  /* project id 727599 */
            src: url('//at.alicdn.com/t/font_727599_2dzvb5kluw9.eot');
            src: url('//at.alicdn.com/t/font_727599_2dzvb5kluw9.eot?#iefix') format('embedded-opentype'),
            url('//at.alicdn.com/t/font_727599_2dzvb5kluw9.woff') format('woff'),
            url('//at.alicdn.com/t/font_727599_2dzvb5kluw9.ttf') format('truetype'),
            url('//at.alicdn.com/t/font_727599_2dzvb5kluw9.svg#iconfont') format('svg');
        }

        body {
            background: #2d2d2d;
            font: 12px "苹方";
        }

        .head {
            width: 100%;
            height: .58rem;
            background: #2d2d2d;
            font-size: .18rem;
            color: #fff;
            line-height: .58rem;
            letter-spacing: 0.06rem;
            border-top: 2px solid #129615;
            border-bottom: 1px solid #4b4b4b;
        }

        .head img {
            width: .27rem;
            height: .11rem;
        }

        .head .position {
            width: 2.64rem;
            height: 100%;
            padding-left: .48rem;
            float: left;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #2d2d2d;
            min-width: 100%;
            color: #ffffff;
            z-index: 5;
            left: 0;
            border-radius: .04rem;
        }

        .dropdown:hover .dropdown-content { /* 在鼠标移上去后显示下拉菜单 */
            display: block;
        }

        .dropdown-content a {
            padding: 0 .48rem .02rem;
            text-decoration: none;
            display: block;
            color: #fff;
            font-size: .18rem;
            border-bottom: .02rem solid #4b4b4b;
        }

        .dropdown-content a:hover { /* 鼠标移上去后修改下拉菜单链接颜色 */
            background-color: #f1f1f1;
            color: black;
        }

        .dropdown:hover .dropbtn { /* 当下拉内容显示后修改下拉按钮的背景颜色 */
            background-color: #3e8e41;
        }

        .head .divider {
            width: 0.02rem;
            height: .34rem;
            background: #4b4b4b;
            float: left;
            margin-top: .12rem;
        }

        .head .type {
            width: 2.64rem;
            height: 100%;
            float: left;
            padding-left: .93rem;
        }

        .contains {
            width: 100%;
            background: transparent;
            padding-top: .22rem;
            padding-bottom: 1.15rem;
            display: flex;
            flex-direction: column;
        }

        .contain {
            width: 5.15rem;
            height: 3.00rem;
            margin: 0 auto;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }

        .contain:nth-child(1) .contain-bg {
            width: 100%;
            height: 100%;
            background: url(images/house3.jpg) no-repeat center/5.15rem 3.0rem;
        }

        .contain:nth-child(2) .contain-bg{
            width: 100%;
            height: 100%;
            background: url(images/house2.jpg) no-repeat center/5.15rem 3.0rem;
        }

        .item {
            margin-top: .14rem;
        }

        .contain p {
            font-size: .16rem;
            color: #ffffff;
            position: absolute;
            bottom: .35rem;
            left: .17rem;
            letter-spacing: 0.02rem;
        }

        .contain .address {
            font-size: .13rem;
            position: absolute;
            bottom: .12rem;
            left: .17rem;
            letter-spacing: 0.02rem;
        }

        .icon-font {
            font-family: "iconfont";
            color: #ffffff;
            font-size: .22rem;
            position: absolute;
            bottom: .13rem;
            right: .19rem;
        }

        .cs {
            color: #b60742;
        }

        .footer {
            width: 100%;
            height: .59rem;
            background: #1d1d1f;
            position: fixed;
            bottom: 0;
        }

        .tab {
            width: .86rem;
            height: .42rem;
            border-radius: 0.08rem;
            color: #f8f8f8;
            font-size: .22rem;
            line-height: .44rem;
            text-align: center;
            float: left;
            margin: .08rem .25rem .09rem .21rem;
        }

        .active {
            background: #b60742;
        }

        .tab-line {
            width: .01rem;
            height: .32rem;
            background: #4b4b4b;
            float: left;
            margin-top: .13rem;
        }
    </style>
</head>
<body>
<input type="text" value="<?php echo $openid; ?>">
<div class="head">
    <div class="position dropdown">
        地区 <img src="images/arrow.png" alt="">
        <div class="dropdown-content">
            <a>迎泽区</a>
            <a>万柏林区</a>
            <a>杏花岭区</a>
            <a>小店区</a>
            <a href="tianyuan.html">尖草坪区</a>
            <a>晋源区</a>
        </div>
    </div>
    <div class="divider"></div>
    <div class="type dropdown">
        舱体类型 <img src="images/arrow.png" alt="">
        <div class="dropdown-content">
            <a href="tianyuan.html">组合式</a>
            <a>亲子式</a>
        </div>
    </div>
</div>
<div class="contains">
    <div class="contain">
        <a href="tianyuan.html">
            <div class="contain-bg"></div>
        </a>
        <p>304田园试点健身舱</p>
        <p class="address">地址：太原市尖草坪区中北大学田园</p>
        <div class="icon-font">&#xe603;</div>
    </div>
    <div class="contain item">
        <a href="#">
            <div class="contain-bg"></div>
        </a>
        <p>亲子体验组合健身舱 </p>
        <p class="address">地址：太原市小店区华雨花谷商业中心</p>
        <div class="icon-font">&#xe603;</div>
    </div>
</div>
<div class="footer">
    <div class="tab active">健身</div>
    <div class="tab-line"></div>
    <div class="tab">课程</div>
    <div class="tab-line"></div>
    <div class="tab">合作</div>
    <div class="tab-line"></div>
    <div class="tab">账户</div>
</div>
<script src="js/jQuery.js"></script>
<script>
    let tab = document.querySelectorAll(".tab");
    for (let i = 0; i < tab.length; i++) {
        tab[i].onclick = function () {
            for (let j = 0; j < tab.length; j++) {
                tab[j].classList.remove("active");
            }
            tab[i].classList.add("active");
        }
    }
</script>
<script>
    $(function () {
        $(".icon-font").click(function () {
            $(this).toggleClass('cs');
        });
    })
</script>
</body>
</html>