<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>
		ehon | <?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<?php echo $this->Html->script('jquery-2.1.0.min'); ?>
	<?php echo $this->Html->script('bootstrap.min'); ?>

	<!-- Le styles -->

	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('bootstrap.icon-large.min'); ?>
	<?php echo $this->Html->css('trackprogress.css'); ?>
	<style>
	body {
		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	}
	</style>
	<?php echo $this->Html->css('bootstrap-responsive.min'); ?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le fav and touch icons -->
	<!--
	<link rel="shortcut icon" href="/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
	-->
	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>

<body>

	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="/"><img src="/img/logo.svg" style="width:35px;"/></a>
				<div class="nav-collapse">
					<ul class="nav">
						<li><a href="/">Home</a></li>
						<li><a href="/pages/about">About</a></li>
						<li><a href="/pages/contact">Contact</a></li>
					</ul>
          <div class="pull-right" style="margin-top:8px">
          	<?php
          	if(!isset($auth_user)){
          	?>
            <a href="/auth/facebook"><span class="icon-large icon-facebook"></span> login</a>
            <?php
            }else{
          	?>
            	<a href="/user/logout" style="height:30px;width:100px" data-toggle="modal" data-target="#myModal">
            		<?php 
            		if(isset($auth_user["photo_path"])){
            			?>
            			<img src="<?php echo $auth_user["photo_path"]; ?>" style="height:30px;" data-trigger="hover" data-placement="bottom" data-content="<?php echo $auth_user["name"]; ?>" rel="popover" title="Logged in"/>
            			<?php
            		}else{
            			?>
            			<span class="icon-large icon-user" data-trigger="hover" data-placement="bottom" data-content="<?php echo $auth_user["name"]; ?>" rel="popover" title="Logged in"></span>
            			<?php
            		}
            	?></a>
            <?php            	
        	}
        	?>
　        </div>
				</div><!--/.nav-collapse -->

			</div>

		</div>
	</div>

	<div class="container">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>

	</div> <!-- /container -->
    <div id="footer" style="border-top:1px solid #DDD;margin-top:10px;padding-top:10px;">

      <div class="container" style="margin:0 auto; text-align:center;">
          &copy; ehon.link
      </div>

    </div>

	<?php echo $this->element('sql_dump'); ?>

	<!-- Le javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<script type="text/javascript">
	$(function(){
    	$('[rel=popover]').popover({html:true});
	});
	</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Logout?</h4>
      </div>
      <div class="modal-body">
        Do you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="location.href='/users/logout'"> Logout</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
