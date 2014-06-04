<?php
class Application_Model_UsersStatsData
{
	private $db;
	
	public function __construct() {
		$this->db = new Application_Model_DbClass_Usersstats();
	}
	
	public function selectUserStats($uid) {
		//$cacheData = Application_Model_Cache_MemCache::getMemCache("LexUserStats" . $uid);
		if($cacheData) {
			$row = $cacheData;
		} else {
			//$row = $this->db->selectRecord("email = '$uid'");
			$row = $this->db->selectRecord("userid = '$uid'");
			Application_Model_Cache_MemCache::setMemCache("LexUserStats" . $uid, $row, 3600);
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
		$this->updateUserStatsDynamoDbConditional($userid,"setWon");//mayur
	}
	
	public function setLost($userid) {
		//$this->db->executeQuery("UPDATE users_stats SET lost = lost + 1 WHERE email = '$userid'");
		$this->db->executeQuery("UPDATE all_users_stats SET lost = lost + 1 WHERE userid = '$userid'");
		$this->updateUserStatsDynamoDbConditional($userid,"setLost");//mayur
	}
	
	public function removePlayed($userid) {
		//$this->db->executeQuery("UPDATE users_stats SET played = played - 1 WHERE email = '$userid'");
		$this->db->executeQuery("UPDATE all_users_stats SET played = played - 1 WHERE userid = '$userid'");
		$this->updateUserStatsDynamoDbConditional($userid,"removePlayed");//mayur
	}
	
	public function updatePlayerRatings($pid,$winnerpid,$userinfo,$moveinfo,$usersdetails,$newScore) {
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
                $mobile_stats_data = new Application_Model_MobileStatsData();
                
		foreach($userinfo as $plid=>$user)
		{
			if(count($moveinfo) != 0) {
				$score = isset($avgarray[$plid]['score'])?$avgarray[$plid]['score']:0;
				$moves = isset($avgarray[$plid]['moves'])?$avgarray[$plid]['moves']:0;
				if(!$score) {$score = 0;}
				if(!$moves) {$moves = 0;}

				$streak = ($plid == $winnerpid)?$ratingsdata[$user['uid']]['streak']+1:0;
				$beststreak = ($streak>$ratingsdata[$user['uid']]['beststreak'])?$streak:$ratingsdata[$user['uid']]['beststreak'];
			
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
			
			if($R['R3']>$ratingsdata[$userinfo[$pid]['uid']]['bestrating']) 
				$ratingsdata[$userinfo[$pid]['uid']]['bestrating'] = $R['R3'];
			if($R['R4']>$ratingsdata[$userinfo[$opp]['uid']]['bestrating'])
				$ratingsdata[$userinfo[$opp]['uid']]['bestrating'] = $R['R4'];

			$ratingsdata[$userinfo[$pid]['uid']]['rating'] = $R['R3'];
			$ratingsdata[$userinfo[$opp]['uid']]['rating'] = $R['R4'];
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
		
		foreach($ratingsdata as $uid=>$data) { $this->db->updateRecord($uid,$data); $this->updateUserStatsDynamoDb($uid,$data); }
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
			//if($affected_rows != 1) { $this->db->insertRecord(array("email"=>$user,"played"=>1)); }
			$bestRatingDate = date("Y-m-d", time());
			if($affected_rows != 1) { $this->db->insertRecord(array("userid"=>$user,"played"=>1,"bestrating_date"=>$bestRatingDate));
				$this->updateUserStatsDynamoDbConditional($user,"newRow",array("bestrating_date"=>$bestRatingDate));//mayur
			}else{
				$this->updateUserStatsDynamoDbConditional($user,"addGameToStats");//mayur
			}
		}
	}
	
	public function removeGameFromStats($userlist) {
		//$this->db->executeQuery("UPDATE users_stats SET played = played + 1 WHERE email IN (".implode(",",$userlist) .")");
		$this->db->executeQuery("UPDATE all_users_stats SET played = played + 1 WHERE userid IN (".implode(",",$userlist) .")");
		$this->updateUserStatsDynamoDbConditional($userlist,"removeGameFromStats");//mayur
	}
	
	public function tempUserUpdate($tempuid,$newuid) {
		//$sql = "update users_stats set email = '$newuid' where email = '$tempuid'";
		$sql = "update all_users_stats set userid = '$newuid' where userid = '$tempuid'";
		$this->db->getAdapter()->query($sql);
		$this->updateUserStatsDynamoDbConditional($tempuid,"tempUserUpdate",array("newuid"=>$newuid));//mayur
	}

	public function updateUserStatsDynamoDb($uid,$data){
		$fileio = new FileIOModel($uid, "userstats");
		$fileio->writeFile(json_encode($data));
	}

	public function getUserStatsDynamoDb($uid){
		$fileio = new FileIOModel($uid,"userstats");
		if(count($uid)>1){
			$datat = $fileio->getBatchFiles($uid);
		}else{
			$datat = $fileio->getFile();
		}

		return $datat;		
	}

	public function updateUserStatsDynamoDbConditional($userid,$action,$extra=null){
		$data = array();
		if($action == "newRow"){
			$data = array("drawn"=>0,"rating"=>1200,"userid"=>$userid,"bestrating"=>1200,"played"=>1,"won"=>0,"lost"=>0,"avg_move_score"=>0,"total_moves"=>0,"avg_game_score"=>0,"total_games"=>0,"streak"=>0,"beststreak"=>0,"bestrating_date"=>$extra['bestrating_date'],"bestscore"=>0,"longeststreakdate"=>"0000-00-00","aborted"=>0,"lastplayed"=>"0000-00-00 00:00:00","totalscore"=>0);
			$fileio = new FileIOModel($userid,"userstats");
			$fileio->writeFile(json_encode($data));	
		}else{
			$dynamoData = $this->getUserStatsDynamoDb($userid);
			foreach ($dynamoData as $key => $value) {
				$data = json_decode($value,true);
				$uid = $data['userid'];
				switch ($action) {
					case 'SetWon':
						$data['won'] = intval($data['won'])+1;
						break;

					case 'setLost':
						$data['lost'] = intval($data['lost'])+1;
						break;

					case 'removePlayed':
						$data['played'] = intval($data['played'])-1;
						break;

					case 'addGameToStats':
						$data['played'] = intval($data['played'])+1;
						break;

					case 'removeGameFromStats':
						$data['played'] = intval($data['played'])+1;
						break;

					case 'tempUserUpdate':					
						$data['userid'] = $extra['newuid'];
						break;
				}

				$fileio = new FileIOModel($uid, "userstats");
				$fileio->writeFile(json_encode($data));			
			}
		}

	}
}
