<?php include("../includes/header.inc"); ?>
<div class="container-fluid">
	<tabset>
		<tab heading="Players">
			<div class="col-md-4" ng-hide="round > 0">
				<h3>Add Players</h3>
				<ul class="list-group">
					<li class="list-group-item"><input type="text" ng-model="newPlayers[0]" placeholder="Player Name"></li>
					<li class="list-group-item"><input type="text" ng-model="newPlayers[1]" placeholder="Player Name"></li>
					<li class="list-group-item"><input type="text" ng-model="newPlayers[2]" placeholder="Player Name"></li>
					<li class="list-group-item"><input type="text" ng-model="newPlayers[3]" placeholder="Player Name"></li>
					<li class="list-group-item"><input type="text" ng-model="newPlayers[4]" placeholder="Player Name"></li>
					<li class="list-group-item"><input type="text" ng-model="newPlayers[5]" placeholder="Player Name"></li>
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
								<button class="btn btn-default" ng-click="removePlayer($index)" ng-hide="round > 0"><span class="glyphicon glyphicon-trash"></span></button> <strong>Name:</strong> <input type="text" ng-model="player.name" placeholder="Player Name" /> <strong>Phase:</strong> {{player.phase()}} <strong>Score: </strong> {{player.totalScore()}}
							</div>
						</li>
					</ul>
					<p>&nbsp;</p>
				</section>
				<section class="col-lg-12" ng-show="Players.length > 1">
					<section style="overflow-x: scroll">
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
											<input type="checkbox" id="summary-player-phase-{{$index}}" ng-model="player.phases[round]" ng-true-value="1" ng-false-value="0"/> <label for="summary-player-phase-{{$index}}">Completed Phase</label>
										</div>
										<div class="form-group">
											<label for="summary-player-score-{{$index}}">Score</label>
											<input id="summary-player-score-{{$index}}" type="number" ng-model="player.scores[round]" placeholder="score" ng-click="player.scores[round] = ''">
										</div>								
									</td>
								</tr>
							</tbody>
						</table>
					</section>
					<button class="btn btn-success" ng-click="nextRound()">Next Round</button>
				</section>
			</div>
		</tab>
		<tab heading="Scores" ng-show="Players.length > 1" class="score">
			<section style="overflow-x: scroll">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Round #</th>
							<th ng-repeat="player in Players">{{player.name}} <small>(Current Phase: {{player.phase()}} / Total Score: {{player.totalScore()}})</small></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="row in list()">
							<td>{{$index + 1}} 
								<button ng-click="editThisRound($index)" ng-show="!isEditing"><span class="glyphicon glyphicon-edit"></span></button>
							</td>
							<td ng-repeat="player in Players">
								<span ng-show="!isEditing || (isEditing && editRound != row)">
									<strong>Phase: </strong>{{player.phase(row)}} <strong>Score: </strong>{{player.scores[row]}}
								</span>
								<span ng-show="isEditing && editRound == row">
									<input type="checkbox" id="edit-player-phase-{{$index}}-{{row}}" ng-model="player.phases[row]" ng-true-value="1" ng-false-value="0"/> <label for="edit-player-phase-{{$index}}-{{row}}">Completed Phase</label><br />
									<label for="edit-player-score-{{$index}}-{{row}}">Score:</label><input id="edit-player-score-{{$index}}-{{row}}" type="number" ng-model="player.scores[row]" placeholder="score"></span>
								</span>
							</td>
						</tr>
						<tr ng-show="!isEditing">
							<td>{{round+1}}</td>
							<td ng-repeat="player in Players">
								<div class="form-group">
									<input type="checkbox" id="player-phase-{{$index}}" ng-model="player.phases[round]" ng-true-value="1" ng-false-value="0"/> <label for="player-phase-{{$index}}">Completed Phase</label>
								</div>
								<div class="form-group">
									<label for="player-score-{{$index}}">Score</label>
									<input id="player-score-{{$index}}" type="number" ng-model="player.scores[round]" placeholder="score" ng-click="player.scores[round] = ''">
								</div>								
							</td>
						</tr>
					</tbody>
				</table>
			</section>
			<button class="btn btn-success" ng-click="nextRound()" ng-show="!isEditing">Next Round</button>
			<button class="btn btn-primary" ng-click="endRoundEditing()" ng-hide="!isEditing">Edit Round</button>
		</tab>
		<tab heading="Manage Session">
			<div class="col-lg-12">
				<div class="col-lg-12">
					<div class="col-lg-12">
						<h2>Current Session</h2>
						<form class="form-inline">
							<div class="form-group">
								<label for="password">Set Passcode:<small>(Optional)</small></label>
								<input type="text" ng-model="password" id="password">
							</div>
							<div class="form-group">
								<label for="name">Set Name:<small>(Optional)</small></label>
								<input type="text" ng-model="name" id="name">
							</div>
							<div class="form-group text-right">
								<button class="btn btn-success" ng-click="saveData(password,name)">Update Settings</button>
							</div>
						</form>
					</div>
				</div>				
				<div class="clear"></div>
				<hr />
			</div>
			<div class="col-lg-12">
				<h2>Existing Sessions</h2>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="text-center">Session Name</th>
							<th class="text-center">Number of Players</th>
							<th class="text-center">Is Private?</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="session in sessions" ng-show="session.session_id != sessionId">
							<td><a ng-href="" ng-click="loadNewSession(session)">{{session.name.length > 0 ? session.name : session.session_id}}</a></td>
							<td class="text-center">{{session.numOfPlayers}}</td>
							<td class="text-center"><span ng-show="session.hasPassword" class="glyphicon glyphicon-lock"></span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</tab>
		<tab heading="Standard Rules">
			<h2>Players</h2>
			<hr />
			<p>This game was designed for 2 to 6 players</p>
			
			<h2>Phases</h2>
			<hr />
			<ol>
				<li>2 sets of 3</li>
				<li>1 set of 3 + 1 run of 4</li>
				<li>1 set of 4 + 1 run of 4</li>
				<li>1 run of 7</li>
				<li>1 run of 8</li>
				<li>1 run of 9</li>
				<li>2 sets of 4</li>
				<li>7 cards of one color</li>
				<li>1 set 5 + 1 set of 2</li>
				<li>1 set 4 + 1 set of 3</li>
			</ol>
			<p>Each player can make only one phase per hand. For instance, a run of 9 when the player is on Phase 4 cannot also count as Phase 5 and/or 6. The phases must also be completed in order.</p>
			
			<h2>Skip Cards</h2>
			<hr />
			<p>When discarded, a "Skip " card causes another player to lose their next turn. The player who discards the "Skip " card chooses the player who loses their turn. When a player draws a "Skip " card, the player may discard it immediately or save it for a later turn. A "Skip " card may never be used in making Phase 8, or any other Phase. A "Skip " card may never be picked up from the discard pile. A player may only be skipped once per round. If player one skips player two, then player two can not be skipped until player one plays again.</p>
			
			<h2>Wild Cards</h2>
			<hr />
			<p>A "Wild " card may be used in place of a number card in order to complete a Phase. A "Wild " card also maybe used as any color, to complete Phase 8. A "Wild" card can not be used as a "Skip" card.</p>
			
			<h2>Completing Phases</h2>
			<hr />
			<p>If, during a player's turn, they are able to make their current Phase with the cards in their hand, they lay the Phase down, face-up on the table before discarding.</p>
			<ul>
				<li>Phases must be made in order, from 1 to 10.</li>
				<li>A player must have the whole Phase in hand before laying it down.</li>
				<li>A player may lay down more than the minimum requirements of a Phase, but only if the additional cards can be directly added to the cards already in the Phase. For instance, if a Phase requires a set of 3 but the player has four of that card, the player may lay down all four cards when completing the Phase.</li>
				<li>Only one Phase may be made per hand. For instance, a player who must make a run of 7 cards (Phase 4) cannot complete the next two Phases in the same hand by laying down a run of 9.</li>
				<li>If a player successfully makes a Phase, then they can try to make the next Phase in the next hand. If they fail to make a Phase, they must try to make the same Phase again in the next hand. As a result, players may not all be working on the same Phase in the same hand.</li>
			</ul>
			
			<h2>Scoring</h2>
			<hr />
			<ul>
				<li>5 points for each card numbered 1-9</li>
				<li>10 poinst for each card numbered 10-12</li>
				<li>15 points for each "Skip" card</li>
				<li>25 points for each "Wild" card</li>
			</ul>
			
			<h2>Play</h2>
			<hr />
			<p>One player is chosen to be dealer (alternately, the deal can rotate to the left after each hand). The dealer shuffles the deck and deals 10 cards, face down, one at a time, to each player. Players hold their 10 cards in hand so that the other players cannot see them. The remaining deck is placed face-down in the center of the play area to become the draw pile. The dealer then turns the top card of the draw pile over and places it next to the draw pile, to become the discard pile. The person to the left of the dealer begins play, and can take either this upturned card or the top card of the draw pile. The player then chooses a card that will not help make the Phase, or a Skip, and discards it. Players then take similar turns in clockwise fashion, drawing and discarding to attempt to acquire the cards required by their current Phase.</p>
		</tab>
	</tabset>
</div>
<?php include("../includes/footer.inc")?>