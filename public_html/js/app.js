var Player = function() {
	this.name = "";
	this.phases = [1];
	this.scores = [];
	this.completed = false;
	this.totalScore = function() {
		var sum = 0;
		for(var i = 0; i < that.scores.length; i++) {
			sum += that.scores[i];
		}
		
		return sum;
	};
	var that = this;
};

var app = angular.module('phase10',['ngCookies','ngSanitize','ui.bootstrap'])
.controller('GameCtrl',function($scope) {
	$scope.newPlayers = ["","","",""];
	$scope.Players = [];
	$scope.round = 0;
	
	$scope.list = function() {
		var list = [];
		for(var i = 0; i < $scope.round; i++) {
			list.push(i);
		};
		
		return list;
	}
	
	$scope.addPlayer = function(num) {
		if($scope.newPlayers[num].trim() != "") {
			var _Player = new Player();
			_Player.name = $scope.newPlayers[num].trim();
			_Player.scores.push(0);
			$scope.Players.push(_Player);			
		}
		
		$scope.newPlayers[num] = "";
		
	};
	
	$scope.resetPlayers = function() {
		$scope.Players = [];
	};
	
	$scope.addPlayers = function() {
		for(var i = 0; i < $scope.newPlayers.length; i++) {
			$scope.addPlayer(i);
		}
	};
	
	$scope.removePlayer = function(num) {
		$scope.Players.splice(num,1);
	};
	
	$scope.nextRound = function() {		
		for(var i = 0; i < $scope.Players.length; i++) {
			var point = $scope.Players[i].scores[$scope.round];
			
			console.log(point, typeof(point));
			if(typeof(point) != "number") {
				point = Number.parseInt(point.replace(/[^0-9\.]/,""));
				if(isNaN(point)) {
					point = 0;
				}
			}
			
			if($scope.Players[i].completed) {
				$scope.Players[i].phases.push($scope.Players[i].phases[$scope.round] + 1);
			} else {
				$scope.Players[i].phases.push($scope.Players[i].phases[$scope.round]);
			}
			
			$scope.Players[i].completed = false;
			
			$scope.Players[i].scores[$scope.round] = point;
			$scope.Players[i].scores.push(0);
		}
		
		$scope.round++;
	};
});