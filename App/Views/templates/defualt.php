<!DOCTYPE html>
<html>
	<head>
        <link rel="icon" href="<?= App::$path ?>img/logo/logo.png" type="image/png"/>
        
		<title>إدارة المبيعات و المشتريات</title>

		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

	    <!-- Bootstrap -->
	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->

		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/zabuto_calendar.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/animate.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/backend.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/respsive.css" />
        <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,600"> -->
	</head>
	<body >
<div id="body" class="wrapper">

    <header class="main-header">
        <a href="<?= App::$path ?>" class="logo">
            <span class="logo-lg"><b>لوحة التحكم </b></span>	
            <span class="logo-mini"><b>د . ج</b></span>	
        </a>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="main-nav">
                <button id="btn-siderbar-collapse" class="btn btn-primary"><i class="fa fa-list"></i></button>
                <ul style="<?php if (!isset($_SESSION['emp'])) echo "display: none";?>" class="nav navbar-nav navbar-notifs-top">
                    <?php if (isset($_SESSION['emp'])): ?>
                    <li class="dropdown dropdown-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= App::$path ?>img/emp/<?= $_SESSION['emp']->AVATAR?>"  class="user-img-top">
                            <span class="user-name-top"><?= $_SESSION['emp']->FULLNAME ?></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li class="user-header">
                                <img src="<?= App::$path ?>img/emp/<?= $_SESSION['emp']->AVATAR?>"  class="img-circle">
                                <p><?= $_SESSION['emp']->FULLNAME ?></p>
                            </li>

                            <li class="user-body text-center">
                                <div class="col-xs-4 text-center">
                                    <a href="#">المشتريات</a>
                                </div>

                                <div class="col-xs-4 text-center">
                                    <a href="#">المبيعات</a>
                                </div>

                                <div class="col-xs-4 text-center">
                                    <a href="#">خيار</a>
                                </div>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <button class="btn btn-default">البروفايل</button>
                                </div>

                                <div class="pull-left">
                                    <a href="<?= App::$path ?>emp/logout" class="btn btn-default">خروج</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php endif; ?>

                </ul>
            </div>
        </nav>
    </header>

<aside class="main-side">

    <div style="<?php //if (!isset($_SESSION['emp'])) echo "display: none";?>">
    <ul class="sidebar">

           <li class="nav-item home">
                <a href="<?= App::$path ?>home" class="nav-link  nav-toggle">
                    <i class="fa fa-home "></i>
                    <span class="title">الرئيسية</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="nav-item  emp">
                <a href="<?= App::$path ?>emp" class="nav-link  nav-toggle">
                    <i class="fa fa-users "></i>
                    <span class="title">الموظفين</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <li class="nav-item has-sub stock">
                <a href="<?= App::$path ?>stock" class="nav-link  nav-toggle">
                    <i class="fa fa-dropbox "></i>
                    <span class="title">المخزون</span>
                    
                </a>
            </li>


            <li class="nav-item  sales">
                <a href="<?= App::$path ?>sale" class="nav-link  nav-toggle">
                    <i class="fa  fa-cart-arrow-down"></i>
                    <span class="title">المبيعات</span>
                    <span class="arrow"></span>
                </a>
            </li>

            

            <li class="nav-item item purchase">
                <a href="<?= App::$path ?>purchase" class="nav-link  nav-toggle">
                    <i class="fa fa-shopping-cart "></i>
                    <span class="title">المشتريات </span>
                </a>
            </li>

            <li class="nav-item  customer">
                <a href="<?= App::$path ?>customer" class="nav-link  nav-toggle">
                    <i class="fa  fa-users"></i>
                    <span class="title">العملاء </span>
                    <span class="arrow"></span>
                </a>
            </li>
            
            <li class="nav-item  vendor">
                <a href="<?= App::$path ?>vendor" class="nav-link  nav-toggle">
                    <i class="fa  fa-user-secret"></i>
                    <span class="title">الموردين</span>
                    <span class="arrow"></span>
                </a>
            </li>

            <!-- <li class="nav-item  bransh">
                <a href="<?= App::$path ?>bransh" class="nav-link  nav-toggle">
                    <i class="fa  fa-balance-scale"></i>
                    <span class="title">الحسابات</span>
                    <span class="arrow"></span>
                </a>
            </li> -->

        
    </ul>

    </div>
</aside>

<!-- Start View Content -->
<div class="content-warpper">
    <?= $content; ?>
</div>
<!-- End View Content -->
		<footer class="main-footer">
			<p><h2> إدارة المبيعات و المشتريات &copy; <?= date('Y') ?> </h2></p>
		</footer>
</div>
		<script type="text/javascript" src="<?= App::$path ?>js/jquery.min.js" ></script>
		<script type="text/javascript" src="<?= App::$path ?>js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/bootstrap-notify.min.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/jquery.nicescroll.min.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/zabuto_calendar.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/counter.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/form-validator/jquery.form-validator.min.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/backend.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/function.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/<?= App::getInstance()->getPage(); ?>.js" ></script>

        <?php if(!isset($_SESSION['emp'])):?>
            <script type="application/javascript">
                $(function(){
                    $('.main-side').css('display','none');
                    // $('.main-side').hide();
                    $('.content-warpper').css('margin-right','0');
                    $('.main-footer').css('margin-right','0');
                });
            </script>
        <?php endif;?>
	</body>
</html>