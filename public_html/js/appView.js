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
				//that.scores[i] = 0;
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
var StreamingInstance = null;
var SessionInstance = null;

var app = angular.module('phase10',['ngCookies','ngSanitize','ui.bootstrap','ngRoute'])
.controller('GameCtrl',function($scope,SessionService,StreamingService) {
	var session = {};
	$scope.sessions = [];
	$scope.newPlayers = ["","","","","",""];
	$scope.Players = [];
	$scope.round = 0;
	$scope.isEditing = false;
	$scope.loadingSession = false;
	$scope.editRound = 0;
	
	$scope.sessionId = "";
	$scope.loadSessionId = "";
	$scope.password = "";
	$scope.name = "";
	
	var streamGame = function() {
		StreamingService.streamSession($scope.sessionId,$scope.password,function(data) {
			if(typeof(data) != "string") {
				$scope.round = data.round;
				for(var i = 0; i < $scope.Players.length; i++) {
					for(var j = 0; j < data.player.length; j++) {
						if($scope.Players[i].name == data.player[j].name) {
							for(var k = 0; k < data.player[j].scores.length; k++) {
								$scope.Players[i].scores[k] = data.player[j].scores[k];
							}
							for(var k = 0; k < data.player[j].phases.length; k++) {
								$scope.Players[i].phases[k] = data.player[j].phases[k];
							}
						}
					}
				}
			}
			
			$scope.$apply();
		});
	};
	
	$scope.list = function() {
		var list = [];
		for(var i = 0; i < $scope.round; i++) {
			list.push(i);
		};
		
		return list;
	};
	
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
	
	$scope.startLoadSession = function() {
		$scope.loadingSession = true;
	};
	
	$scope.loadNewSession = function(session) {
		angular.element(window).scrollTop(0);
		$scope.loadSessionId = session.session_id;
		$scope.startLoadSession();
	};
	
	$scope.loadSession = function() {
		if($scope.loadSessionId.trim() != "") {
			SessionService.getNewSession($scope.loadSessionId,$scope.password,function(data) {
				if(typeof(data) != "string") {
					SessionService.setSessionID($scope.loadSessionId);
					$scope.sessionId = SessionService.getSessionID();

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
					
					$scope.loadingSession = false;
					if(typeof(ga) == "function") {
						ga('send', 'pageview');
					}
					streamGame();
				} else {
					alert("Cannot load session. Invalid passcode or session does not exists");
				}
			});
			
		}
	};
	
	$scope.cancelLoadSession = function() {
		$scope.sessionId = SessionService.getSessionID();
		$scope.loadingSession = false;
	};
	
	$scope.shareSession = function() {
		FB.ui({
		  method: 'send',
		  link: window.location.href,
		});
	};
	
	var init = function() {
		SessionService.getSession($scope.password, function(data) {
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
		
		SessionService.getSessions(function(data) {
			$scope.sessions = data;
		});
	}
	
	init();
	$scope.sessionId = SessionService.getSessionID();
})
.factory("SessionService",['$http','$rootScope',function($http,$rootScope) {
	if(SessionInstance == null) {
		var SessionService = function() {
			var apiUrl = "http://"+window.location.host+"/ajax.php";
			var sessionID = "";
			
			this.updateSession = function(Players,password, name) {
				var session = {
						data: Players,
						sessionID: sessionID,
						numOfPlayers: Players.player.length,
						passcode: password,
						name: name
				};
				$http.put(apiUrl, JSON.stringify(session));
			};
			
			this.getSessions = function(callback) {
				$http.get(apiUrl)
				.success(function(data) {
					if(typeof(callback) == "function") {
						callback(data);
					}
				});
			};
			
			this.getSession = function(passcode, callback) {
				$http.get(apiUrl+"?sessionID="+sessionID+"&passcode="+passcode)
				.success(function(data) {
					if(typeof(callback) == "function") {
						callback(data);
					}
				});
			};
			
			this.getNewSession = function(sessID, passcode, callback) {
				$http.get(apiUrl+"?sessionID="+sessID+"&passcode="+passcode)
				.success(function(data) {
					if(typeof(callback) == "function") {
						callback(data);
					}
				});
			};
			
			this.getSessions = function(callback) {
				$http.get(apiUrl)
				.success(function(data) {
					if(typeof(callback) == "function") {
						callback(data);
					}
				});
			};
			
			this.setSessionID = function(id) {
				sessionID = id;
			};
			
			this.getSessionID = function() {
				return sessionID;
			};			
		};
		
		SessionInstance = new SessionService();
	}
	
	return SessionInstance;
}])
.factory("StreamingService",['$rootScope',function($rootScope) {
	if(StreamingInstance == null) {
		var StreamingService = function() {
			var stream = null;
			var apiUrl = "http://"+window.location.host+"/streaming.php";
			var sessionID = "";
			var passcode = "";
			var callback = null;
			
			var init = function() {				
				if(typeof(EventSource) == "function") {
					stream = new EventSource(apiUrl+"?sessionID="+sessionID+"&passcode="+passcode)
					stream.onmessage = function(resp) {
						callback(JSON.parse(resp.data));
					};
				}
			};
			
			this.reset = function() {
				if(stream != null) {
					stream.close();
				}
				init();				
			};
			
			this.streamSession = function(session, pass, call) {
				sessionID = session;
				passcode = pass;
				callback = call;
				that.reset();
			};
			
			var that = this;
		};
		StreamingInstance = new StreamingService();
	}
	
	return StreamingInstance;
}]);