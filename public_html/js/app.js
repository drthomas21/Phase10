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
			var val = parseInt(that.phases[i]);
			if(!val) {
				val = 0;
				that.phases[i] = 0;
			}
			sum += val;
		}
		
		return sum;
	}
	var that = this;
};

var Instance = null;

var app = angular.module('phase10',['ngCookies','ngSanitize','ui.bootstrap','ngRoute'])
.config(['$routeProvider','$locationProvider',function($routeProvider,$locationProvider){
	$locationProvider.html5Mode({enabled: true,requireBase: false}).hashPrefix('!');
	$routeProvider.otherwise({
		redirectTo: '/'
	});
}])
.controller('GameCtrl',function($scope,SessionService) {
	$scope.newPlayers = ["","","","","",""];
	$scope.Players = [];
	$scope.round = 0;
	$scope.isEditing = false;
	$scope.loadingSession = false;
	$scope.editRound = 0;
	$scope.sessionId = "";
	
	var saveData = function() {
		SessionService.updateSession({
			player: $scope.Players,
			round: $scope.round
		});
	};
	
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
		saveData();
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
		saveData();
	};
	
	$scope.startLoadSession = function() {
		$scope.loadingSession = true;
	};
	
	$scope.loadSession = function() {
		if($scope.sessionId.trim() != "") {
			SessionService.setSessionID($scope.sessionId);
			init();
			$scope.loadingSession = false;
		}
	};
	
	$scope.cancelLoadSession = function() {
		$scope.loadingSession = false;
	};
	
	$scope.shareSession = function() {
		FB.ui({
		  method: 'send',
		  link: window.location.href,
		});
	};
	
	var init = function() {
		SessionService.getSession(function(data) {
			$scope.Players = [];
			if(typeof(data) != "string") {
				for(var i = 0; i < data.player.length; i++) {
					var _player = new Player();
					_player.name = data.player[i].name;
					_player.scores = data.player[i].scores;
					_player.phases = data.player[i].phases;
					$scope.Players.push(_player);
				}
				
				$scope.round = data.round;
			}
		});
	}
	
	init();
	$scope.sessionId = SessionService.getSessionID();
})
.factory("SessionService",['$http','$location','$rootScope',function($http,$location,$rootScope) {
	if(Instance == null) {
		var SessionService = function() {
			var apiUrl = "http://"+window.location.host+"/ajax.php";
			var sessionID = window.location.pathname.replace("/","");
			
			this.updateSession = function(Players) {
				$http.put(apiUrl, JSON.stringify({data: Players,sessionID:sessionID}));
			};
			
			this.getSession = function(callback) {
				$http.get(apiUrl+"?sessionID="+sessionID)
				.success(function(data) {
					if(typeof(callback) == "function") {
						callback(data);
					}
				});
			};
			
			this.setSessionID = function(id) {
				sessionID = id;
				$location.url("/"+id);
				$location.replace();
			};
			
			this.getSessionID = function() {
				return sessionID;
			};
			
		}
		Instance = new SessionService();
	}
	
	return Instance;
}]);