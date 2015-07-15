<?php session_start(); ?>
<!DOCTYPE HTML>
<html ng-app="phase10" ng-cloak>
	<head>
		<title>Phase 10 Scoreboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="3KSdffPsPX34BKMHn8b-vKfbexBdg8PdbGEa5gqojbM" />
		
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-sanitize.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-cookies.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js"></script>
		<script src="./js/app.js"></script>
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-29594513-11', 'auto');
		  ga('send', 'pageview');
		
		</script>
		
		<style type="text/css">
			input.error {
				border-color: red;
			}
		</style>
	</head>
	<body ng-controller="GameCtrl">
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="/">Phase 10 Scoreboard</a>
		    </div>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="navbar-collapse">
		      <ul class="nav navbar-nav">
		        <li><a href="https://github.com/drthomas21/Phase10" target="_blank">Github Project</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>