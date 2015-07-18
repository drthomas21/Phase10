<?php require_once(__DIR__.'/classes/bootstrap.php');
	$Database = $_GLOBALS['Database'];
	$sessionID = $_GLOBALS['sessionID'];
	$Database->close();
?>
<!DOCTYPE HTML>
<html ng-app="phase10" ng-cloak ng-controller="GameCtrl">
	<head>
		<title>Phase 10 Scoreboard</title>
		<link rel="canonical" ng-href="http://phase10.realplayerzone.com/{{sessionId}}" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="3KSdffPsPX34BKMHn8b-vKfbexBdg8PdbGEa5gqojbM" />
		<meta name="keyword" content="phase, 10, phase 10, card game, game, score, scoreboard, online, free" />
		<meta name="description" content="Phase 10 Scoreboard is a free to use utility that allows you to track scores when you are playing Phase 10!" />
		
		<meta property="og:url" content="http://phase10.realplayerzone.com/{{sessionId}}" />
		<meta property="og:title" content="Phase 10 Scoreboard" />
		<meta property="og:description" content="Follow the intense battle that is taking place on the Phase 10 Scoreboard site" />
		<meta property="og:image" content="http://phase10.realplayerzone.com/img/phase-10-card-game.jpg" />
		
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-sanitize.min.js" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.min.js" defer></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-cookies.min.js" defer></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" defer></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.min.js" defer></script>
		<script src="./js/app.js" defer></script>
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-29594513-11', 'auto');
		  ga('send', 'pageview');
		</script>
		
		<script>
		  window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '101031673580824',
		      xfbml      : true,
		      version    : 'v2.4'
		    });
		  };
		
		  (function(d, s, id){
		     var js, fjs = d.getElementsByTagName(s)[0];
		     if (d.getElementById(id)) {return;}
		     js = d.createElement(s); js.id = id;
		     js.src = "//connect.facebook.net/en_US/sdk.js";
		     fjs.parentNode.insertBefore(js, fjs);
		   }(document, 'script', 'facebook-jssdk'));
		</script>
		
		</script>
		<!--[if lte IE 9]>
		<script type="text/javascript">
			alert("If you are seeing this message then that means that you are using an old version of IE, upgrade that shit now!");
			window.location.href="https://www.google.com/chrome/browser/desktop/";
		</script>
		<[!endif]-->
		
		<style type="text/css">
			input.error {
				border-color: red;
			}
			
			div.sub-nav {
				border: 1px solid #000;
				border-bottom-left-radius: 4px;
				border-bottom-right-radius: 4px;
				width: 100%;
				margin-top: -20px;
				margin-bottom: 20px;
				padding-top: 10px;
				padding-bottom: 10px;
				float: left;
			}
			
			@media (max-width: 507px) {
				div.fb-div {
					float: left !important;
					margin-top: 5px;
				} 
			}
		</style>
	</head>
	<body>
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
		
		<div class="sub-nav">
			<div class="col-xs-12">
				<section ng-hide="loadingSession" style="display: inline-block">
					<button class="btn btn-success" ng-click="startLoadSession()">Load Session</button> 
					<button class="btn btn-primary" ng-click="shareSession()">Share Session</button>
				</section>
				<section ng-show="loadingSession" style="display: inline-block">
					<input ng-model="sessionId" type="text" placeholder="Session ID"/>
					<button class="btn btn-success" ng-click="loadSession()">Load Session</button>
					<button class="btn btn-warning" ng-click="cancelLoadSession()">Cancel</button>
				</section>
				<div class="pull-right fb-div"><div  class="fb-like"  data-share="false"  data-width="200" data-show-faces="false"></div></div>
			</div>
		</div>
		<br />