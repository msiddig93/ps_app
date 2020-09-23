<!DOCTYPE html>
<html>
	<head>
        <title>-</title>
        <link rel="icon" href="<?= App::$path ?>img/logo/logo.png" type="image/png"/>

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
        <link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/font-awesome.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/backend.css" />
		<link rel="stylesheet" type="text/css" href="<?= App::$path ?>css/print.css" />
        <style>
            .img-header {
                height: 100px;
                width: 100px;
                padding: 0;
                margin-top: 4px;
                margin-bottom: 2px;
            }
        </style>
        <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,600"> -->
	</head>
	<body >
<div id="body" class="wrapper">

<!-- Start View Content -->
<div class="container">

    <div class="row print-header">
        <div class="col-xs-10 text-right">
            <div class="print-header">
                <h3>شركة المختبر للمعدات الطبية</h3>
                <h3>Laboratory Of Medical Equipment Company</h3>
            </div>
        </div>
        <div class="col-xs-2 text-center">
            <img class="img-header" src="<?= App::$path ?>img/logo/logo.png" >
        </div>
    </div>
    <div class="row">
        <div class="col-xs-5 text-left">
            <h5>  <i class="fa fa-phone-square"></i> هواتفنا  <i class="fa fa-hand-o-left"></i> <span style="direction: "> 0183796478  -  0183796479 </span> </h5>
        </div>
        <div class="col-xs-7">
            <h5>  <i class="fa fa-map-marker"></i> موقعنا <i class="fa fa-hand-o-left"></i> السودان - الخرطوم - السوق العربي </h5>
        </div>
    </div>

    <hr style="margin-top: 0;">

    <?= $content; ?>
</div>
<!-- End View Content -->
</div>
		<script type="text/javascript" src="<?= App::$path ?>js/jquery.min.js" ></script>
		<script type="text/javascript" src="<?= App::$path ?>js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="<?= App::$path ?>js/<?= App::getInstance()->getPage(); ?>.js" ></script>

    </body>
</html>