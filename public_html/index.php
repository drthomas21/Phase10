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
		        <!-- li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li -->
		        <li><a href="https://github.com/drthomas21/Phase10">Github Project</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid">
			<tabset>
				<tab heading="Players">
					<div class="col-md-4" ng-hide="round > 0">
						<h3>Add Players</h3>
						<ul class="list-group">
							<li class="list-group-item"><input type="text" ng-model="newPlayers[0]" placeholder="Player Name"> <button class="btn btn-success" ng-click="addPlayer(0)"><span class="glyphicon glyphicon-plus"></span></i></button></li>
							<li class="list-group-item"><input type="text" ng-model="newPlayers[1]" placeholder="Player Name"> <button class="btn btn-success" ng-click="addPlayer(1)"><span class="glyphicon glyphicon-plus"></span></i></button></li>
							<li class="list-group-item"><input type="text" ng-model="newPlayers[2]" placeholder="Player Name"> <button class="btn btn-success" ng-click="addPlayer(2)"><span class="glyphicon glyphicon-plus"></span></i></button></li>
							<li class="list-group-item"><input type="text" ng-model="newPlayers[3]" placeholder="Player Name"> <button class="btn btn-success" ng-click="addPlayer(3)"><span class="glyphicon glyphicon-plus"></span></i></button></li>
						</ul>
						<button class="btn btn-success" ng-click="addPlayers()">Add Players</button>
						<button class="btn btn-primary" ng-click="resetPlayers()">Rest Players</button>
					</div>
					<div class="col-md-8">
						<h3>Players</h3>
						<section class="col-lg-12">
							<ul class="list-group">
								<li ng-repeat="player in Players" class="list-group-item col-lg-12">
									<div>
										<strong>Name:</strong> <input type="text" ng-model="player.name" placeholder="Player Name" /> <strong>Phase:</strong> {{player.phases[player.phases.length-1]}} <strong>Score: </strong> {{player.totalScore()}}
										<span class="pull-right"><button class="btn btn-danger" ng-click="removePlayer($index)">Remove</button></span>
									</div>
								</li>
							</ul>
							<p>&nbsp;</p>
						</section>
						<section class="col-lg-12" ng-show="Players.length > 1">
							<table class="table table-bordered" >
								<thead>
									<tr>
										<th>Round #</th>
										<th ng-repeat="player in Players">{{player.name}}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>{{round+1}}</td>
										<td ng-repeat="player in Players">
											<div class="form-group">
												<input type="checkbox" id="player-phase-{{$index}}" ng-model="player.completed"/> <label for="player-phase-{{$index}}">Completed Phase</label>
											</div>
											<div class="form-group">
												<label for="player-score-{{$index}}">Score</label>
												<input id="player-score-{{$index}}" type="text" ng-model="player.scores[round]" placeholder="score">
											</div>								
										</td>
									</tr>
								</tbody>
							</table>
							<button class="btn btn-success" ng-click="nextRound()">Next Round</button>
						</section>
					</div>
				</tab>
				<tab heading="Scores" ng-show="Players.length > 1" class="score">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Round #</th>
								<th ng-repeat="player in Players">{{player.name}} <small>(Current Phase: {{player.phases[round]}})</small></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="row in list()">
								<td>{{$index + 1}}</td>
								<td ng-repeat="player in Players"><strong>Phase: </strong>{{player.phases[row]}} <strong>Score: </strong>{{player.scores[row]}}</td>
							</tr>
							<tr>
								<td>{{round+1}}</td>
								<td ng-repeat="player in Players">
									<div class="form-group">
										<input type="checkbox" id="player-phase-{{$index}}" ng-model="player.completed"/> <label for="player-phase-{{$index}}">Completed Phase</label>
									</div>
									<div class="form-group">
										<label for="player-score-{{$index}}">Score</label>
										<input id="player-score-{{$index}}" type="text" ng-model="player.scores[round]" placeholder="score">
									</div>								
								</td>
							</tr>
						</tbody>
					</table>
					<button class="btn btn-success" ng-click="nextRound()">Next Round</button>
				</tab>
			</tabset>
		</div>
	</body>
</html>