<?php
class UsersStatsDataModel{
	private $db;
	
	public function __construct() {
		$this->db = new UsersstatsDbModel();
	}
	
	public function selectUserStats($uid) {
		$cacheData = LexMemCache::getMemCache("LexUserStats" . $uid);
		
		if($cacheData) {
			$row = $cacheData;
		} else {
			//$row = $this->db->selectRecord("email = '$uid'");
			$row = $this->db->selectRecord("userid = '$uid'");
			LexMemCache::setMemCache("LexUserStats" . $uid, $row, 3600);
		} 
		return $row;
	}
	
	public function getUserRatingsInArray($userids) {
		//$rows = $this->db->selectMultipleRow("email IN ('".implode("','",$userids)."')");
		$rows = $this->db->selectMultipleRow("userid IN ('".implode("','",$userids)."')");
		$stats = array();
		foreach($rows as $row) {
			//$stats[$row['email']] = array("rating"=>$row['rating'],'played'=>$row['played'],'won'=>$row['won'],'lost'=>$row['lost'],'drawn'=>$row['drawn']);
			$stats[$row['userid']] = array("rating"=>$row['rating'],'played'=>$row['played'],'won'=>$row['won'],'lost'=>$row['lost'],'drawn'=>$row['drawn']);
		}
		return $stats;
	}
	
	public function setWon($userid) {
		//$record = $this->db->selectRecord("email = '$userid'");
		$record = $this->db->selectRecord("userid = '$userid'");
		$this->db->updateRecord($userid, array("won"=>$record['won']+1));
	}
	
	public function setLost($userid) {
		//$this->db->executeQuery("UPDATE users_stats SET lost = lost + 1 WHERE email = '$userid'");
		$this->db->executeQuery("UPDATE all_users_stats SET lost = lost + 1 WHERE userid = '$userid'");
	}
	
	public function removePlayed($userid) {
		//$this->db->executeQuery("UPDATE users_stats SET played = played - 1 WHERE email = '$userid'");
		$this->db->executeQuery("UPDATE all_users_stats SET played = played - 1 WHERE userid = '$userid'");
	}
	
	public function updatePlayerRatings($pid,$winnerpid,$userinfo,$moveinfo,$usersdetails,$newScore = 0, $playerscore= array()) {
		$ratingsdata = array();
		$avgarray = array();
	
		foreach($moveinfo as $permove) {
			$move = explode(",",trim($permove));
			if(!isset($avgarray[trim($move[1])]['score']))
				$avgarray[trim($move[1])]['score'] = $move[3];
			else
				$avgarray[trim($move[1])]['score']+= $move[3];

			if(!isset($avgarray[trim($move[1])]['moves']))
				$avgarray[trim($move[1])]['moves'] = 1;
			else
				$avgarray[trim($move[1])]['moves']+= 1;
		}
		
		$avgarray[$pid]['score'] += $newScore;
		
		$alluserids = "";
	
		foreach($userinfo as $plid=>$user) { $alluserids .= "'$user[uid]',"; }
		$alluserids = substr($alluserids,0,-1);
	
		//$userratings = $this->db->selectMultipleRow("email IN($alluserids)");
		$userratings = $this->db->selectMultipleRow("userid IN($alluserids)");
	
		//foreach($userratings as $usr) { $ratingsdata[$usr['email']] = $usr; }
		foreach($userratings as $usr) { $ratingsdata[$usr['userid']] = $usr; }
                $mobile_stats_data = new MobileStatsDataModel();
                
		foreach($userinfo as $plid=>$user)
		{
			if(count($moveinfo) != 0) {
				$score = isset($avgarray[$plid]['score'])?$avgarray[$plid]['score']:0;
				$moves = isset($avgarray[$plid]['moves'])?$avgarray[$plid]['moves']:0;

				if(count($playerscore) != 0) {
					$score = isset($playerscore[$plid])?$playerscore[$plid]:0;
				}
				
				if(!$score) {$score = 0;}
				if(!$moves) {$moves = 0;}

				$streak = ($plid == $winnerpid)?$ratingsdata[$user['uid']]['streak']+1:0;
				$beststreak = ($streak>$ratingsdata[$user['uid']]['beststreak'])?$streak:$ratingsdata[$user['uid']]['beststreak'];
				$ratingsdata[$user['uid']]["longeststreakdate"] = ($streak>$ratingsdata[$user['uid']]['beststreak'])?date('Y-m-d'):$ratingsdata[$user['uid']]['longeststreakdate'];
				$ratingsdata[$user['uid']]["avg_game_score"] = (($ratingsdata[$user['uid']]['avg_game_score'] * $ratingsdata[$user['uid']]['total_games']) + $score)/($ratingsdata[$user['uid']]['total_games'] + 1);
				$ratingsdata[$user['uid']]["avg_move_score"] = (($ratingsdata[$user['uid']]['avg_move_score'] * $ratingsdata[$user['uid']]['total_moves']) + $score)/($ratingsdata[$user['uid']]['total_moves'] + $moves);
				$ratingsdata[$user['uid']]["total_moves"] += $moves;
				$ratingsdata[$user['uid']]["total_games"] += 1;
				$ratingsdata[$user['uid']]["streak"] = $streak;
				$ratingsdata[$user['uid']]["beststreak"] = $beststreak;
				$ratingsdata[$user['uid']]["totalscore"] = $ratingsdata[$user['uid']]['totalscore'] + $score;
			}
                        if($usersdetails[$user['uid']]['bbpin'] != "") {
                            $mobile_stats_data->gameFinished("B");
                        }
                        if($usersdetails[$user['uid']]['iphonepin'] != "") {
                            $mobile_stats_data->gameFinished("I");
                        }
                        if($usersdetails[$user['uid']]['appin'] != "") {
                        	$mobile_stats_data->gameFinished("A");
                        }
		}
	
		if(count($userinfo)==2) {

			if($pid == 1)
				$opp = 2;
			else if($pid == 2)
				$opp = 1;
			
			
			$R1 = $ratingsdata[$userinfo[$pid]['uid']]['rating'];
			$R2 = $ratingsdata[$userinfo[$opp]['uid']]['rating'];
			
			$piddata = array();
			$oppdata = array();
		
			if($winnerpid == '-1')   {
				$S1 = 1;
				$S2 = 1;
				$ratingsdata[$userinfo[$pid]['uid']]['drawn'] += 1;
				$ratingsdata[$userinfo[$opp]['uid']]['drawn'] += 1;
			}
			else if($pid == $winnerpid) {
				$S1 = 2;
				$S2 = 1;
				$ratingsdata[$userinfo[$pid]['uid']]['won'] += 1;
				$ratingsdata[$userinfo[$opp]['uid']]['lost'] += 1;
			}
			else if($opp == $winnerpid) {
				$S1 = 1;
				$S2 = 2;
				$ratingsdata[$userinfo[$pid]['uid']]['lost'] += 1;
				$ratingsdata[$userinfo[$opp]['uid']]['won'] += 1;
			}

			$R = $this->calculateRating($S1,$S2,$R1,$R2);
			
			if($R['R3']>$ratingsdata[$userinfo[$pid]['uid']]['bestrating']){ 
				$ratingsdata[$userinfo[$pid]['uid']]['bestrating'] = $R['R3'];
				$ratingsdata[$userinfo[$pid]['uid']]['bestrating_date'] = date("Y-m-d", time());
			}
			if($R['R4']>$ratingsdata[$userinfo[$opp]['uid']]['bestrating']){
				$ratingsdata[$userinfo[$opp]['uid']]['bestrating'] = $R['R4'];
				$ratingsdata[$userinfo[$opp]['uid']]['bestrating_date'] = date("Y-m-d", time());
			}
			if ($R['R3'] == 0)
				$R['R3'] = 500;
			if ($R['R4'] == 0)
				$R['R4'] = 500;
			$ratingsdata[$userinfo[$pid]['uid']]['rating'] = $R['R3'];
			$ratingsdata[$userinfo[$opp]['uid']]['rating'] = $R['R4'];

			//update score for new design
			$mybest = explode("|", $ratingsdata[$userinfo[$pid]['uid']]['bestscore']);
			$oppbest = explode("|", $ratingsdata[$userinfo[$opp]['uid']]['bestscore']);
			
			$myscore = isset($playerscore[$pid])?$playerscore[$pid]:0;
			$oppscore = isset($playerscore[$opp])?$playerscore[$opp]:0;
			
			if(count($playerscore) == 0) {
				$myscore = isset($avgarray[$pid]['score'])?$avgarray[$pid]['score']:0;
				$oppscore = isset($avgarray[$opp]['score'])?$avgarray[$opp]['score']:0;
			}
			
			//update my best score
			if($myscore>$mybest['0']) {
				$usersObj = new UsersDataModel();
				$userDetails = $usersObj->getUsers(array($userinfo[$opp]['uid']));
				$ratingsdata[$userinfo[$pid]['uid']]['bestscore'] = $myscore."|".$userDetails[$userinfo[$opp]['uid']]['name']."|".date("Y-m-d");
			}
			
			//update opp score
			if($oppscore>$oppbest['0']) {
				$usersObj = new UsersDataModel();
				$userDetails = $usersObj->getUsers(array($userinfo[$pid]['uid']));
				$ratingsdata[$userinfo[$opp]['uid']]['bestscore'] = $oppscore."|".$userDetails[$userinfo[$pid]['uid']]['name']."|".date("Y-m-d");
			}
			
		} else {
			foreach($userinfo as $pid=>$info) {
				if($winnerpid == -1) {
					$ratingsdata[$info['uid']]['drawn'] += 1;
				} else if($winnerpid == $pid) {
					$ratingsdata[$info['uid']]['won'] += 1;
				} else {
					$ratingsdata[$info['uid']]['lost'] += 1;
				}
			}
		}
		
		foreach($ratingsdata as $uid=>$data) { $this->db->updateRecord($uid,$data); }
	}
	
	private function calculateRating($S1,$S2,$R1,$R2) {
		if (empty($S1) OR empty($S2) OR empty($R1) OR empty($R2)) return null;
		if ($S1!=$S2) {
			if ($S1>$S2) {
				$E=120-round(1/(1+pow(10,(($R2-$R1)/400)))*120); $R['R3']=$R1+$E; $R['R4']=$R2-$E;
			}
			else {
				$E=120-round(1/(1+pow(10,(($R1-$R2)/400)))*120); $R['R3']=$R1-$E; $R['R4']=$R2+$E;
			}
		}
		else {
			if ($R1==$R2) { $R['R3']=$R1; $R['R4']=$R2; }
			else {
				if($R1>$R2) {
					$E=(120-round(1/(1+pow(10,(($R1-$R2)/400)))*120))-(120-round(1/(1+pow(10,(($R2-$R1)/400)))*120)); $R['R3']=$R1-$E; $R['R4']=$R2+$E;
				}
				else {
					$E=(120-round(1/(1+pow(10,(($R2-$R1)/400)))*120))-(120-round(1/(1+pow(10,(($R1-$R2)/400)))*120)); $R['R3']=$R1+$E; $R['R4']=$R2-$E;
				}
			}
		}
		$R['S1']=$S1; $R['S2']=$S2; $R['R1']=$R1; $R['R2']=$R2;
		$R['P1']=((($R['R3']-$R['R1'])>0)?"+".($R['R3']-$R['R1']):($R['R3']-$R['R1']));
		$R['P2']=((($R['R4']-$R['R2'])>0)?"+".($R['R4']-$R['R2']):($R['R4']-$R['R2']));
		return $R;
	}
	
	public function addGameToStats($userlist) {
		foreach($userlist as $user) {
			//$affected_rows = $this->db->executeQuery("UPDATE users_stats SET played = played + 1 WHERE email = '$user'");
			$affected_rows = $this->db->executeQuery("UPDATE all_users_stats SET played = played + 1 WHERE userid = '$user'");
			if($affected_rows != 1) { $this->db->insertRecord(array("userid"=>$user,"played"=>1,"bestrating_date"=>"DATE(now())")); }
		}
	}
	
	public function removeGameFromStats($userlist) {
		//$this->db->executeQuery("UPDATE users_stats SET played = played + 1 WHERE email IN (".implode(",",$userlist) .")");
		$this->db->executeQuery("UPDATE all_users_stats SET played = played + 1 WHERE userid IN (".implode(",",$userlist) .")");
	}
	
	public function tempUserUpdate($tempuid,$newuid) {
		//$this->db->executeQuery("update users_stats set email = '$newuid' where email = '$tempuid'");
		$this->db->executeQuery("update all_users_stats set userid = '$newuid' where userid = '$tempuid'");
	}
	
	public function statsUpdate($userid, $type="",$joinedon) {
		//$selRow = $this->db->selectRecord("email = '$userid'");
		$selRow = $this->db->selectRecord("userid = '$userid'");
		if($type!="") {
			if($type == 1) {
				$updateData  = array("rating"=>1200,"bestrating"=>1200);
				$row = array("drawn"=>$selRow['drawn'],"rating"=>1200,"bestrating"=>1200,"played"=>$selRow['played'],"won"=>$selRow['won'],"lost"=>$selRow['lost'],"avg_move_score"=>$selRow['avg_move_score'],"total_moves"=>$selRow['total_moves'],"avg_game_score"=>$selRow['avg_game_score'],"total_games"=>$selRow['total_games'],"streak"=>$selRow['streak'],"beststreak"=>$selRow['beststreak'],"bestrating_date"=>date("Y-m-d", time()));
				LexMemCache::setMemCache("LexUserStats" . $userid, $row, 3600);
				$result=$this->db->updateRecord($userid, $updateData);
				return $result;
			} else if($type == 2) {
				$row = array("drawn"=>0,"rating"=>1200,"bestrating"=>1200,"played"=>$selRow['played'] - ($selRow['won'] + $selRow['lost'] + $selRow['drawn']),"won"=>0,"lost"=>0,"avg_move_score"=>0,"total_moves"=>0,"avg_game_score"=>0,"total_games"=>0,"streak"=>0,"beststreak"=>0,"bestrating_date"=>date("Y-m-d", time()));
				LexMemCache::setMemCache("LexUserStats" . $userid, $row, 3600);
				$result=$this->db->updateRecord($userid, $row);
				return $result;
			}else if($type == 3) {
				$time=strtotime($joinedon);
				$month=date("m",$time);
				$year=date("y",$time);
				MysqlProcedureModel::bingoDelete($userid,$year,$month);
				
				LexMemCache::delMemCache("LexBingos" . $userid);
				LexMemCache::delMemCache('LEXLIVEBINGOCNT' . $userid);
				LexMemCache::delMemCache('DBTOPBINGOD');
				LexMemCache::delMemCache('DBMOSTRATING');
				$row = array("drawn"=>0,"rating"=>1200,"bestrating"=>1200,"played"=>$selRow['played'] - ($selRow['won'] + $selRow['lost'] + $selRow['drawn']),"won"=>0,"lost"=>0,"avg_move_score"=>0,"total_moves"=>0,"avg_game_score"=>0,"total_games"=>0,"streak"=>0,"beststreak"=>0,"bestrating_date"=>date("Y-m-d", time()));
				LexMemCache::setMemCache("LexUserStats" . $userid, $row, 3600);
				$result=$this->db->updateRecord($userid, $row);
				return $result;
			}
		}
	}
}
