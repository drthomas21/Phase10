var Player = function() {
	this.name = "";
	this.phases = [];
	this.scores = [];
	this.completed = false;
	this.totalScore = function() {
		var sum = 0;
		for(var i = 0; i < that.scores.length; i++) {
			var val = parseInt(that.scores[i]);
			if(!val) {
				val = 0;
				that.scores[i] = 0;
			}
			sum += val 
		}
		
		return sum;
	};
	this.phase = function(num) {
		if(typeof(num) != "number") {
			num = that.phases.length;
		}
		var sum = 1;
		for(var i = 0; i < num; i++) {
			sum += parseInt(that.phases[i]);
		}
		
		return sum;
	}
	var that = this;
};

var app = angular.module('phase10',['ngCookies','ngSanitize','ui.bootstrap'])
.controller('GameCtrl',function($scope) {
	$scope.newPlayers = ["","","","","",""];
	$scope.Players = [];
	$scope.round = 0;
	$scope.isEditing = false;
	$scope.editRound = 0;
	
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
			_Player.phases.push(0);
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
	
	$scope.editThisRound = function(num) {
		$scope.isEditing = true;
		$scope.editRound = num;
	};
	
	$scope.endRoundEditing = function() {
		for(var i = 0; i < $scope.Players.length; i++) {
			var point = $scope.Players[i].scores[$scope.editRound];
			
			if(typeof(point) != "number") {
				point = Number.parseInt(point.replace(/[^0-9\.]/,""));
				if(isNaN(point)) {
					point = 0;
				}
			}
			
			if(point < 0) {
				point = point * -1;
			}
			
			$scope.Players[i].scores[$scope.editRound] = point;
		}
		
		$scope.isEditing = false;
	};
	
	$scope.nextRound = function() {		
		for(var i = 0; i < $scope.Players.length; i++) {
			var point = $scope.Players[i].scores[$scope.round];
			
			if(typeof(point) != "number") {
				point = Number.parseInt(point.replace(/[^0-9\.]/,""));
				if(isNaN(point)) {
					point = 0;
				}
			}
			
			$scope.Players[i].scores[$scope.round] = point;
			$scope.Players[i].scores.push(0);
		}
		
		$scope.round++;
	};
});