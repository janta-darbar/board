<?php

include_once("game_file_functions.php");

function default_page_show_request() {
	return;
		global $facebook;

   		$data=$facebook->api('/me/apprequests/');
   		for($i=0;$i<count($data['data']);$i++){ 
   			  	
   			if($list_request_ids[$data['data'][$i]['from']['id']]){
   				$list_request_ids[$data['data'][$i]['from']['id']]=$list_request_ids[$data['data'][$i]['from']['id']].",".$data['data'][$i]['id'];	
   			}
   			else{
   				$list_request_ids[$data['data'][$i]['from']['id']]=$data['data'][$i]['id'];
   				$list_friends_name[$data['data'][$i]['from']['id']]=$data['data'][$i]['from']['name'];
   			}  			
   		}  
   		  		
   		$array_keys_list = array_keys($list_friends_name);
   		
   		for($i=0;$i<count($array_keys_list);$i++){
   			
   			$friends_name_id[] = array("id"=>$array_keys_list[$i],"name"=>$list_friends_name[$array_keys_list[$i]],"request_id"=>$list_request_ids[$array_keys_list[$i]]);
   		}
   		
   		return $friends_name_id ;
     
}

function delete_friends_request($id){
	return;
   $token_url = "https://graph.facebook.com/oauth/access_token?" .
     "client_id=" . FB_APP_ID .
     "&client_secret=" . FB_SECRET .
     "&grant_type=client_credentials";
   
   	$access_token = file_get_contents($token_url);
	$array_requests=explode(",",$id);
	
   foreach($array_requests as $val){
    	$delete_url = "https://graph.facebook.com/" .
    	$val . "?" . $access_token;

    	$delete_url = $delete_url . "&method=delete";
    	$result = file_get_contents($delete_url);
 	    //echo("Requests deleted? " . $result);
   }
  
}



function get_stats_for_friends_page($uid) {
    $results = generic_mem_cache('statscache/B' . $uid, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$uid'");
    $rowA = $results[0];

    //$results = generic_mem_cache('scache/bcount' . $uid, 3600, "SELECT count(*) cnt FROM `bingos` WHERE userstatid = '$rowA[id]'");
    //$bcount = $results[0];

    $results = generic_mem_cache('scache/bcount' . $uid, 3600, "SELECT count(*) cnt FROM `bingos_old` WHERE userstatid = '$rowA[id]'");
    $bcount += $results[0];

    $gamescompleted = $rowA['won'] + $rowA['lost'] + $rowA['drawn'];

    $arr = array();
    $arr['playing'] = abs($rowA['played'] - $gamescompleted);
    $arr['won'] = $rowA['won'];
    $arr['lost'] = $rowA['lost'];
    $arr['bingos'] = 0; //$bcount['cnt'];
    $arr['rating'] = $rowA['rating'];

    return $arr;
}

function get_stats_iphone_JSON($uid) {
    $results = generic_mem_cache('statscache/B' . $uid, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$uid'");

    $rowA = $results[0];

    $results = generic_mem_cache('avgstat' . $uid, 3600, "SELECT * FROM `averageStats` WHERE userid = '$uid'");
    $rowAVG = $results[0];

    $results = generic_mem_cache('statscache/bingos' . $uid, 3600, "select * from bingos where userstatid = $rowA[id] order by score desc limit 0, 10");

    $bingos = array();

    if(count($results) > 0) {
            foreach($results as $eachbingo){
                    $bingos[] = array("date"=>$eachbingo['date'],"word"=>$eachbingo['word'],"score"=>$eachbingo['score']);
            }
    }

    $outputArr = array();
    $outputArr['currentrating']   = (string)$rowA['rating'];
    $outputArr['bestrating']      = (string)$rowA['bestrating'];
    $outputArr['playing']         = (string)($rowA['played'] - ($rowA['drawn'] + $rowA['won'] + $rowA['lost']));
    $outputArr['finished']        = (string)($rowA['drawn'] + $rowA['won'] + $rowA['lost']);
    $outputArr['won']             = (string)$rowA['won'];
    $outputArr['lost']            = (string)$rowA['lost'];
    $outputArr['drawn']           = (string)$rowA['drawn'];
    $outputArr['avgmovescore']    = isset($rowAVG['avg_move_score'])?(string)$rowAVG['avg_move_score']:"";
    $outputArr['avggamescore']    = isset($rowAVG['avg_game_score'])?(string)$rowAVG['avg_game_score']:"";
    $outputArr['streak']          = isset($rowAVG['streak'])?(string)$rowAVG['streak']:"";
    $outputArr['beststreak']      = isset($rowAVG['beststreak'])?(string)$rowAVG['beststreak']:"";
    $outputArr['bingos'] 	      = count($bingos)>0?$bingos:array();

    
    return $outputArr;
}


function get_stats($uid) {
    $retarr = array();

    $results = generic_mem_cache('statscache/' . $uid, 3600, "SELECT facebookusers.*, date_format(dateadded,'%d-%b-%Y') dt FROM facebookusers WHERE facebookusers.uid  = '$uid'");
    $row = $results[0];
 
    $results = generic_mem_cache('statscache/B' . $uid, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$uid'");
    $rowA = $results[0];

    $results = generic_mem_cache('avgstat' . $uid, 3600, "SELECT * FROM `averageStats` WHERE userid = '$uid'");
    $rowAVG = $results[0];
    
    //----------Bingo divided into 5 tables---------------------//
	$allBingos = array();
	$allBingos = getMemCache("statscache/bingostophundred". $uid);
	if ($allBingos){
		/////
	}else{
		/*
		$sqlBingo2008 = "select * from bingos2008 where userstatid = $rowA[id] order by score desc limit 0, 100";
		$res2008 = mysql_query($sqlBingo2008);
		if (mysql_num_rows($res2008)> 0){			
			while ($row2008 = mysql_fetch_array($res2008)){
				$bingosTotal[] = $row2008;
			}
		}
		$sqlBingo2009 = "select * from bingos2009 where userstatid = $rowA[id] order by score desc limit 0, 100";
		$res2009 = mysql_query($sqlBingo2009);
		if (mysql_num_rows($res2009)>0){
			while ($row2009 = mysql_fetch_array($res2009)){
				$bingosTotal[] = $row2009;
			}
		}
		$sqlBingo2010 = "select * from bingos2010 where userstatid = $rowA[id] order by score desc limit 0, 100";
		$res2010 = mysql_query($sqlBingo2010);
		if (mysql_num_rows($res2010)>0){
			while ($row2010 = mysql_fetch_array($res2010)){
				$bingosTotal[] = $row2010;
			}
		}
		$sqlBingo2011 = "select * from bingos2011 where userstatid = $rowA[id] order by score desc limit 0, 100";
		$res2011 = mysql_query($sqlBingo2011);
		if (mysql_num_rows($res2011)>0){
			while ($row2011 = mysql_fetch_array($res2011)){
				$bingosTotal[] = $row2011;
			}
		}
		$sqlBingo = "select * from bingos where userstatid = $rowA[id] order by score desc limit 0, 100";
		$resbingos = mysql_query($sqlBingo);
		if (mysql_num_rows($resbingos)>0){
			while ($rowbingos = mysql_fetch_array($resbingos)){
				$bingosTotal[] = $rowbingos;
			}
		}
		$scoreVal = array();
		foreach ($bingosTotal as $key => $row){
	    	$scoreVal[$key] = $row['score'];
		}
		array_multisort($scoreVal, SORT_DESC, $bingosTotal);
		$allBingos = array_slice($bingosTotal, 0, 100);
		setMemCache("statscache/bingostophundred". $uid, $allBingos, false, 3600);
		*/
		$allBingos = getTotalBingoList($rowA[id]);/////added on 10_8_12
		setMemCache("statscache/bingostophundred". $uid, $allBingos, false, 3600);/////added on 10_8_12
	}
	//------------------End all bingo---------------------//
	
    //-----------Close previous bingo-----------------------//
    /*
    $results = generic_mem_cache('statscache/bingostophundred' . $uid, 3600, "select * from bingos where userstatid = $rowA[id] order by score desc limit 0, 20");
    $allBingos = array();
    if(count($results) > 0) {
        for($i=0;$i<count($results);$i++) {
            $allBingos[] = $results[$i];
			if($i == 20)
				break;
        }
    }
    */
    //----------Closed----------------------//
    
    $gamescompleted = $rowA['won'] + $rowA['lost'] + $rowA['drawn'];
    $retarr['id']=$rowA['id'];					//added on 13-10-12 #1999

    $retarr['rating']=$rowA['rating'];
    $retarr['email']=$rowA['email'];
    $retarr['bestrating']=$rowA['bestrating'];
    $retarr['played']= $gamescompleted; // $rowA['played'];
    $retarr['won']=$rowA['won'];
    $retarr['lost']=$rowA['lost'];
    $retarr['drawn']=$rowA['drawn'];
    $retarr['allbingos'] = $allBingos;

    $retarr['avg_move_score']=$rowAVG['avg_move_score'];
    $retarr['avg_game_score']=$rowAVG['avg_game_score'];
    $retarr['streak']=$rowAVG['streak'];
    $retarr['beststreak']=$rowAVG['beststreak'];

    $GLOBALS['otherJoinDt'] = $row['dt'];
    $retarr['otherJoinDt']=$row['dt'];/////#1454

    if($row['defaultdic'] == 'sow')
        $GLOBALS['otherDefaultDic'] = 'English games based on the UK English dictionary, ';
    elseif ($row['defaultdic'] == 'twl')
        $GLOBALS['otherDefaultDic'] = 'English games based on the US English dictionary, ';
    elseif ($row['defaultdic'] == 'it')
        $GLOBALS['otherDefaultDic'] = 'Italian games, ';
    elseif ($row['defaultdic'] == 'fr')
        $GLOBALS['otherDefaultDic'] = 'French games, ';

    if($row['defaultgame'] == 'R')
        $GLOBALS['otherDefaultGame'] = 'Regular';
    else
        $GLOBALS['otherDefaultGame'] = 'Challenge';

    if($retarr['rating']==0){$retarr['rating']=1200;}
	if($retarr['bestrating']==0){$retarr['bestrating']=1200;}
      return $retarr;

}

function get_user_profiles($limit) {
    $start = rand(0,25); 
    $res =  mysql_query("select uid from facebookusers where showprofiles = 'y' and removed = 'n' limit $start, $limit");
    $return_array = array();
    if(mysql_num_rows($res) > 0) {
        while($row = mysql_fetch_array($res)) {
            array_push($return_array, $row['uid']);
        }
    }

    return $return_array;
}

function getNickName($uid) {
    global $facebook;
	$proxyarray = array("1391118825"=>"Javon K", "1414340545"=>"Lee M","1365409143"=>"Hugo H","1402162950"=>"Damian R","1286030000"=>"Solomon C","1319119609"=>"Kristy G","1331539528"=>"Lorraine B","1398409799"=>"Lauryn L", "1309759752"=>"Tori C",
			"400001953006601"=>"Craig S","400001953006602"=>"Landen H","400001953006603"=>"Earl K","400001953006604"=>"Ron M","400001953006605"=>"Tanner E","400001953006606"=>"Rene B","400001953006607"=>"Edward T","400001953006608"=>"Raul S","400001953006609"=>"Wesley E","4000019530066010"=>"Pedro O",
			"4000019530066011"=>"Peyton S","4000019530066012"=>"Glenda F","4000019530066013"=>"Shania H","4000019530066014"=>"Erica M","4000019530066015"=>"Amya S",
			"4000019530066016"=>"Sharon W","4000019530066017"=>"Kelsey C","4000019530066018"=>"Rosie W","4000019530066019"=>"Jillian R","4000019530066020"=>"Virginia M","4000019530066021"=>"Homer A");
	
 
	if($proxyarray[$uid]){
		return $proxyarray[$uid];
	}
	
    $nickname = getMemCache("n-". $uid);
    if($nickname) { return $nickname; }

    $fql    =   "select first_name, last_name from user where uid = $uid";
	$param  =   array(
    	'method'     => 'fql.query',
        'query'     => $fql,
      	'callback'    => ''
	);
	$result   =   $facebook->api($param);
    
    $toreplace = array(' ');

    $first = str_replace($toreplace, '', $result[0]['first_name']);
    $last = str_replace($toreplace, '', $result[0]['last_name']);

    //$nickname =  $first . " " . $last{0};
    $nickname =  $first . " " . mb_substr($last, 0, 1, 'UTF-8');
    setMemCache("n-". $uid, $nickname, false, 600);

    return $nickname;
}


function getMultipleNickNames($uid_arr) {
    global $facebook;
    $returnarr = array();
    $new_uid_arr = array();
	$proxyarray = array("1391118825"=>"Javon K", "1414340545"=>"Lee M","1365409143"=>"Hugo H","1402162950"=>"Damian R","1286030000"=>"Solomon C","1319119609"=>"Kristy G","1331539528"=>"Lorraine B","1398409799"=>"Lauryn L", "1309759752"=>"Tori C",
			"400001953006601"=>"Craig S","400001953006602"=>"Landen H","400001953006603"=>"Earl K","400001953006604"=>"Ron M","400001953006605"=>"Tanner E","400001953006606"=>"Rene B","400001953006607"=>"Edward T","400001953006608"=>"Raul S","400001953006609"=>"Wesley E","4000019530066010"=>"Pedro O",
			"4000019530066011"=>"Peyton S","4000019530066012"=>"Glenda F","4000019530066013"=>"Shania H","4000019530066014"=>"Erica M","4000019530066015"=>"Amya S",
			"4000019530066016"=>"Sharon W","4000019530066017"=>"Kelsey C","4000019530066018"=>"Rosie W","4000019530066019"=>"Jillian R","4000019530066020"=>"Virginia M","4000019530066021"=>"Homer A");

    foreach($uid_arr as $val) {
		if($proxyarray[$val]){
			$returnarr[$val] = $proxyarray[$val];
		} else {
	        $temp = getMemCache("n-". $val);
	        if($temp) {
	            $returnarr[$val] = $temp;
	        } else {
	            array_push($new_uid_arr, $val);
	        }		
		}
    }
	
    if(count($new_uid_arr) > 0) {
        $uid_arr = $new_uid_arr;
        
        $vals = join(',' , $uid_arr);
        
        $fql    =   "select uid, first_name, last_name from user where uid in ($vals)";
		$param  =   array(
       			'method'     => 'fql.query',
        		'query'     => $fql,
      			'callback'    => ''
		);
		$result   =   $facebook->api($param);
        $toreplace = array('"', "'");
        foreach($result as $row) {
        /*if ((strlen($row['first_name']) != strlen(utf8_decode($row['first_name'])))){    ///Non English    		
            	$first = str_replace($toreplace, '', $row['first_name']);
            	//$last = str_replace($toreplace, '', $row['last_name']);
            	$last = " ";
            	//$returnarr[$row['uid']] = $first . " " . $last{0};
        	}else{*/       		
        		$first = str_replace($toreplace, '', $row['first_name']);
            	$last = str_replace($toreplace, '', $row['last_name']);
            	//$returnarr[$row['uid']] = $first . " " . $last{0};
        	//}
        	$returnarr[$row['uid']] = $first . " " . mb_substr($last, 0, 1, 'UTF-8');
        }

    }
    return $returnarr;
}

function getGameInfo($uid, $gid) {
    $retval = array();
    $res = mysql_query("select player_id, password from users where email = '$uid' and game_id = $gid");
    if(mysql_num_rows($res) > 0) {
        $row = mysql_fetch_array($res);
        $retval[0] = $row['password'];
        $retval[1] = $row['player_id'];
    }

    return $retval;
}

function startnewgame($user, $with, $dictionary, $game_type, $opponentname, $mobile='n') {
  	global $facebook, $tmp_games_fre_tiles_table,$blockedUserArrStr;
  	$blockedUserArr = explode(",", $blockedUserArrStr);
  	foreach ($blockedUserArr as $key=>$value){
  		if (in_array($value, $with)){
  			echo "<script type='text/javascript'>top.location.href = '".FB_APP_PATH."';</script>";
  			exit();
  		}
  	}

	if(!$dictionary) {
		$dictionary = "twl";
	}
	
	$language = array("sow" => "en", "twl" => "en", "fr" => "fr", "it" => "it");
	$languageNotify = array("fr" => " in French", "it" => " in Italian");

	if($language[$dictionary]=="en") {
		$tmp_games_fre_tiles_table="tmp_games_fre_tiles";
	} else {
		$tmp_games_fre_tiles_table="tmp_games_fre_tiles_".$language[$dictionary];
	}

	$selectedlang = $language[$dictionary];
	$langfornotification = $languageNotify[$dictionary];

  	$nicks = array();

  	$p2id = $with[0];
	$p3id = $with[1];
	$p4id = $with[2];

	$uid_arr = $with;
	array_push($uid_arr, $user);
	$userList = $uid_arr;
	
	if($mobile == 'y') {
		$uid_arr[$p2id] =  $opponentname;
		$ownnickname = getNicknameFromFbpassword($user);
		$uid_arr[$user] = $ownnickname;
	}else {
        if ((count($with) == 1) && (strlen($opponentname) > 1)){///if-else added on 21_12_12
            $uid_arr[$user] = getNickName($user);
            $uid_arr[$p2id] =  $opponentname;
        }else{
            $uid_arr = getMultipleNickNames($uid_arr);
        }
    }
	
	//else {
	//	$uid_arr = getMultipleNickNames($uid_arr);
	//}

 	$p1nickname = $uid_arr[$user];
	$p2nickname = $uid_arr[$p2id];
	array_push($nicks, $p2nickname);

	$no_play = 2;

	if($p3id) {
		$p3nickname = $uid_arr[$p3id];
		array_push($nicks, $p3nickname);
		$no_play++;
	}

	if($p4id) {
		$p4nickname = $uid_arr[$p4id];
		array_push($nicks, $p4nickname);
		$no_play++;
	}

	$p1password = "";

	// now write the code for starting this game

	$week = strtotime("+15 days");
	$week1 = date("Y-m-d H:i:s", $week);

	if ($game_type != 'C') { $game_type = 'R'; }

	// insert into counter table for stats
	//mysql_query("insert into sowtwlcounter set `date` = CURDATE(), `dic` = '$dictionary'");
	//echo "insert into `games` (`game_id`,`players_no`,`dictionary`,`startedon`,`game_type`,`expirydatetime`, language)  values('','$no_play','$dictionary', now(),'$game_type','$week1', '$selectedlang')";exit;
    mysql_query("insert into `games` (`game_id`,`players_no`,`dictionary`,`startedon`,`game_type`,`expirydatetime`, language)  values('','$no_play','$dictionary', now(),'$game_type','$week1', '$selectedlang')");
	$id = mysql_insert_id();

	addGametoUser($userList, $id);

	mysql_query("insert into `$tmp_games_fre_tiles_table` (`gameid`)  values ('$id')");

	$gid = $id;

	// create empty game file
	//write_empty_game_file($gid);/////////////////done
	$FileIO = new FileIOModel();///////////////////added
	$FileIO->writeEmptyFile($gid, "game", date("Y-m-d g:i:s"));////////added
	$feed = feed_generate($gid);

	unset($giventiles);

	$tmpTilesStr = "";
	$ownhand = "";

    for ($i = 0; $i < $no_play; $i++)
    {
		$rand_str = rand_str();

        if ($i == 0) {
            $player = 1;
            $email = $user;
            $nickname = $p1nickname;
            $player_id1 = 1;
            $p1password = $rand_str;
        }

        if ($i == 1) {
            $player = 2;
            $email = $p2id;
            $nickname = $p2nickname;
            $player_id2 = 2;
        }

        if ($i == 2) {
            $player = 3;
            $email = $p3id;
            $nickname = $p3nickname;
        }

        if ($i == 3) {
            $player = 4;
            $email = $p4id;
            $nickname = $p4nickname;
        }

      	$users_str.= $email.",".$rand_str.",".$nickname.",n|";
	  	$users_string.= "('".$id."','".$player."','".$email."','".$rand_str."','".$nickname."'),";

	  	$rand_str1 = "";
	  	for ($j = 0; $j < 8; $j++)
	  	{
	  		$rand = substr($feed, rand(0, strlen($feed) - 1), 1);
	  		$rand_str1 .= $rand;

	  		$pos = strpos($feed, $rand);
	  		$rest1 = substr($feed, 0, $pos);
	  		$rest2 = substr($feed, $pos + 1);
	  		$feed = $rest1 . $rest2;

	  	}

		$tmpTilesStr .= "`p" . $player . "hand`='$rand_str1',";

		if($i == 0) { $ownhand = $rand_str1; }

		for ($d = 0; $d < strlen($rand_str1); $d++)
		{
			if ($giventiles[$rand_str1[$d]] > 0) {
				$giventiles[$rand_str1[$d]] += 1;
			} else {
				$giventiles[$rand_str1[$d]] = 1;
			}
		}

        // now insert this user in the stats table
        mysql_query("UPDATE `users_stats` set played = played + 1 where email = '$email'");
        if(mysql_affected_rows() <= 0) {
        	mysql_query("INSERT INTO `users_stats` set email = '$email', played = 1");
        }
    }

	// remove trailing delimiters
    $users_str = substr($users_str, 0, -1);
	$users_string = substr($users_string, 0, -1);

	mysql_query("update games set users_info = '$users_str' where game_id = '$gid'");
	mysql_query("insert into `users` (`game_id`,`player_id`,`email`,`password`,`nickname`) values ".$users_string);

    $sql_string = "";
    foreach ($giventiles as $key => $value)
    {
        if ($key == "*")
            $key = "blank";
        $sql_string .= "`tile_" . strtolower($key) . "`=tile_" . strtolower($key) . "-" .
            $value . ",";
    }

    $sql_string = substr($sql_string, 0, -1);

    mysql_query("UPDATE `$tmp_games_fre_tiles_table` SET $tmpTilesStr $sql_string WHERE gameid='$id' ");

	$pid = join(',', $with);

	$result = array();
	$result[0] = join(', ', $nicks);
	$result[1] = $id;
	$result[2] = 1;
	$result[3] = $p1password;
	$result[4] = $selectedlang;
	$result[5] = $pid;
	$result[6] = $ownhand;
	$result[7] = $ownnickname;

	//if($mobile != 'y')    {
		$pid = join(',', $with);
			
		send_notification($user, $pid, $langfornotification);
	//}

    return $result;
}


function send_notification($from, $uid, $lang) {
//  global $facebook;
//   $to_user = explode(",",$to);
//   $facebook->api_client->dashboard_multiIncrementCount($to_user);	
 
  global $facebook;


  // Publish feed story
  //$feed_body = ' has started a game of Lexulous with you' . $lang . '. Click <a href="http://apps.facebook.com/lexulous/">here</a> to view your games list.';
  //$facebook->api_client->notifications_send($to, $feed_body);
 // echo "aaaa";
 // exit;
	try {
			if(!is_array($uid)){
				$uid = explode(',', $uid);
			}

			foreach($uid as $val) {

					//$apprequest_url = "https://graph.facebook.com/" . $val . "/apprequests?message=" . urlencode("Your turn in Lexulous!") . "&data=notif&access_token=".FB_APP_ID."|".FB_SECRET."&method=post";
					//file_get_contents($apprequest_url);
				
					//added on 5_9_12
					$req_url = "https://graph.facebook.com/" . $val . "/apprequests";
					$postdata =  "message=" . urlencode("Your turn in Lexulous!") . "&data=notif&access_token=".FB_APP_ID."|".FB_SECRET; 
					https_post_notify($req_url, $postdata);

					$notifi_URL = 'https://graph.facebook.com/' . $val . '/notifications';  
					$postdata_nofify = 	"access_token=" . $facebook->getAppId()."|".$facebook->getApiSecret()."&template=".urlencode("A new game has been started with you. Play your turn now.")."&ref=Start_playing";			
				
					//$notifi_result = https_post_notify($notifi_URL,$postdata_nofify);
				////5_9_12 End
			}
			/*
			//----added on 3_9_12 #1668
			foreach ($uid as $key=>$opp_id){
				$notifi_URL = 'https://graph.facebook.com/' . $opp_id . '/notifications?access_token=' . $facebook->getAppId().'|'.$facebook->getApiSecret();  
				$postdata_nofify = 	"href=".FB_APP_PATH."&template=A new game has been started with you. Play your turn now.&ref=Start_playing";			
				$notifi_result = https_post_notify($notifi_URL,$postdata_nofify);
			}	 
			//-----3_9_12 End  #1668
						
			foreach($uid as $val) {
			$apprequest_url = "https://graph.facebook.com/" . $val . "/apprequests?message=" . urlencode("Your turn in Lexulous!") . "&data=notif&access_token=".FB_APP_ID."|".FB_SECRET."&method=post";
			file_get_contents($apprequest_url);
			}
			
	  		$inccounter = array('method' => 'dashboard.multiIncrementCount',
	                        'access_token' => FB_APP_ID . "|" . FB_SECRET,
	                         'uids' => $uid
	                      );
		 	$facebook->api($inccounter);
		 	*/
	} catch (Exception $e) {
		
	}
}


//---------------added on 30_7_12
function https_post_notify($uri, $postdata) {
	$sql = "INSERT INTO fbnotification SET url='{$uri}',data='{$postdata}'";
	mysql_query($sql);
	return;	
    $ch = curl_init($uri);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
  }
  //------30_7_12-------

function load_settings($uid, $getfromcache = false) {
	global $settingCookie;
	
	if(!DB::$connected) { DB::connect(); }

	$res = mysql_query("select facebookusers.*, date_format(dateadded,'%d-%b-%Y') dt from facebookusers where uid = $uid");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		//$settingCookie = "y,{$row['showstatus']},{$row['defaultdic']},{$row['defaultgame']},{$row['autoRefreshBoard']},{$row['numberedboard']},{$row['autosort']},{$row['chat']},{$row['eggadvert']},{$row['show_tiles']},{$row['default_newgame']}";////closed on 10_7_12 #1142(1)//#3626
		$settingCookie = "{$row['showprofiles']},{$row['showstatus']},{$row['defaultdic']},{$row['defaultgame']},{$row['autoRefreshBoard']},{$row['numberedboard']},{$row['autosort']},{$row['chat']},{$row['eggadvert']},{$row['show_tiles']},{$row['default_newgame']}";
		
		setcookie('settingCookie',$settingCookie, time() + 3600 * 24 * 7);/////closed on 10_9_12 #1142(1)
		$_COOKIE['settingCookie'] = $settingCookie;

		setcookie("app_dateadded",$row['dt'],time()+3600*24*7);
		$_COOKIE['app_dateadded'] = $row['dt'];


		//$_SESSION['lexCookieList'] = $CookieList;/////added on 10_9_12 #1142(1)

		if($row['banned'] == 'y') { return "y"; }

	} else {
		mysql_query("insert into facebookusers set uid = '$uid', dateadded = CURDATE()");
		mysql_query("insert into users_stats set email = '$uid'");
		$_COOKIE['app_dateadded'] = date('d-M-Y');
	}
}


function get_completedgames_count($email_id, $cutoff ='') {

	global $completedGamesList;

	if($cutoff == '200608')  {
		$gamestable = "games_over_200608";
		$userstable = "users_over_200608";
	} else {
		$gamestable = "games_over";
		$userstable = "users_over";
	}

	$result = generic_mem_cache("pc" . $cutoff . $email_id, 3600, "SELECT game_id FROM $userstable WHERE email='$email_id'");
	$cnt = 0;
	$completedGamesList = "";
	foreach ($result as $id => $record)
	{
		$cnt++;
	    $completedGamesList.=$record['game_id'].",";
	}
	$completedGamesList = rtrim($completedGamesList,",");
	return $cnt;
}


/*closed on 7_8_12
function get_completedgames_list($email_id, $pagetoshow, $profile = 'false', $search_option = 'finishedon desc', $cutoff = '', $selfprofile = 'true') {

	if(!$search_option)
		$search_option = 'finishedon desc';

	if($cutoff == '200608')  {
		$gamestable = "games_over_200608";
		$userstable = "users_over_200608";
	} else {
		$gamestable = "games_over";
		$userstable = "users_over";
	}

	$month = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec",);

	global $completedGamesList;
	$pagetoshow = ($pagetoshow - 1) * 15;
	if(!strpos($email_id, "@"))
		$fb = "y";

	$returnstr = "";
	$imgname = "li-normal";

	if($profile == 'true') {
		$sql = "SELECT  finishedon, winner, language, player_id, games_over.game_id, password, game_type  FROM users_over, games_over WHERE users_over.game_id = games_over.game_id and users_over.email='$email_id' order by games_over.finishedon desc limit $pagetoshow, 15";
	} else {
		if($search_option == 'wf')   {
			$sql = "SELECT g.winner, g.game_id, g.game_type, g.language, CASE WHEN winner='-1' THEN 1 WHEN email='$email_id' THEN 3	ELSE 2 END AS sortkey FROM `$gamestable` AS g, `$userstable` AS u WHERE g.game_id = u.game_id AND (g.winner = u.player_id or (g.winner=-1 and u.player_id=1)) AND g.game_id IN ( $completedGamesList ) ORDER BY sortkey DESC limit $pagetoshow, 15";
		} else if($search_option == 'lf') {
			$sql = "SELECT g.winner, g.game_id, g.game_type, g.language, CASE WHEN winner='-1' THEN 1 WHEN email='$email_id' THEN 2 ELSE 3 END AS sortkey FROM `$gamestable` AS g, `$userstable` AS u	WHERE g.game_id = u.game_id AND (g.winner = u.player_id or (g.winner=-1 and u.player_id=1)) AND g.game_id IN( $completedGamesList ) ORDER BY sortkey DESC limit $pagetoshow, 15";
		} else if($search_option == 'df')   {
			$sql = "SELECT g.winner, g.game_id, g.game_type, g.language, CASE WHEN winner='-1' THEN 3 WHEN email='$email_id' THEN 2 ELSE 1 END AS sortkey FROM `$gamestable` AS g, `$userstable` AS u WHERE g.game_id = u.game_id AND (g.winner = u.player_id or (g.winner=-1 and u.player_id=1)) AND g.game_id IN( $completedGamesList ) ORDER BY sortkey DESC limit $pagetoshow, 15";
		} else if($search_option == 'r')   {
			$sql = "SELECT winner, game_id, game_type , language, CASE `game_type`	WHEN 'R' THEN 2	WHEN 'C' THEN 1	END AS sortkey FROM $gamestable WHERE game_id IN( $completedGamesList ) ORDER BY sortkey DESC limit $pagetoshow, 15";
		} else if($search_option == 'c')   {
			$sql = "SELECT winner, game_id, game_type , language,CASE `game_type`	WHEN 'R' THEN 1	WHEN 'C' THEN 2	END AS sortkey FROM $gamestable WHERE game_id IN( $completedGamesList )	ORDER BY sortkey DESC limit $pagetoshow, 15";
		} else if($search_option == 'hs')   {
			$sql = " SELECT g.winner, g.game_id, g.game_type, g.language,CASE `player_id` WHEN 1 THEN p1score WHEN 2 THEN p2score WHEN 3 THEN p3score WHEN 4 THEN p4score END AS ownscore FROM $gamestable as g,tmp_games_fre_tiles_over_200608 as t,$userstable as u WHERE g.game_id in($completedGamesList) and g.game_id=t.gameid and g.game_id=u.game_id and u.email='$email_id' order by ownscore desc limit $pagetoshow, 15";
		} else if($search_option == 'ls')   {
			$sql = " SELECT g.winner, g.game_id, g.game_type, g.language,CASE `player_id` WHEN 1 THEN p1score WHEN 2 THEN p2score WHEN 3 THEN p3score WHEN 4 THEN p4score END AS ownscore FROM $gamestable as g,tmp_games_fre_tiles_over_200608 as t,$userstable as u WHERE g.game_id in($completedGamesList) and g.game_id=t.gameid and g.game_id=u.game_id and u.email='$email_id' order by ownscore desc limit $pagetoshow, 15";
		} else  {
			$sql = "SELECT winner, game_id, game_type, finishedon, language  FROM $gamestable WHERE $gamestable.game_id in ( $completedGamesList ) order by $search_option limit $pagetoshow, 15";
		}
	}

	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	$returnArr = array();
	if($cnt > 0) {
		while($row = mysql_fetch_array($result))
		{
			$wonby = "";
			// get list of players
			$playerlist = "";
			$newgameWith = "";/////////added on 16_7_12 #1142(4)
			$result1 = generic_mem_cache("pca" . $row['game_id'], 3600, "select id, player_id, nickname, email, password from $userstable where game_id = " . $row['game_id']);
			$rematchlist = "";
			foreach ($result1 as $id=> $playrow)
			{
				if(!($playrow['email'] == $email_id)) {
					if($fb == 'y') {
						$playerlist .= '<a href="'.FB_APP_PATH.'?action=profile&profileid=' . $playrow['email'] . '" class="text_blue_12" target="_top">' . $playrow['nickname'] . '</a>, ';
                                           // $playerlist .= $playrow['nickname'] . ", ";
					} else {
						$playerlist .= $playrow['nickname'] . ", ";
					}

					$rematchlist .= $playrow['email'] . ",";
					$newgameWith .= $playrow['nickname'].',';/////////added on 16_7_12 #1142(4)
				} else {
					$linkpid = $playrow['player_id'];
					$linkpassword = $playrow['password'];
					$linkgid = $row['game_id'];
				}

				if($row['winner'] == $playrow['player_id']) {
					if($playrow['email'] == $email_id)
						$wonby = "<b>Won by " . $playrow['nickname']."</b>";
					else
						$wonby = "Won by " . $playrow['nickname'];
				} else if($row['winner'] == -1) {
						$wonby = "<b>Game Drawn</b>";
				}
			}

			$playerlist = substr($playerlist, 0, strlen($playerlist) - 2);
			$rematchlist =  substr($rematchlist, 0, strlen($rematchlist) - 1);
			$newgameWith =  substr($newgameWith, 0, strlen($newgameWith) - 1);///////added on 16_7_12 #1142

			$finishedStr = "";
			if($search_option == 'finishedon desc' || $search_option == 'finishedon asc')    {
				$datestamp = split(' ', $row['finishedon']);
				$datestamp = split('-', $datestamp[0]);
				$datestamp = $datestamp[2] . "-" . $month[$datestamp[1]] . "-" . substr($datestamp[0], 2, 2);
				$finishedStr.= " on " . $datestamp;
			}

			$gametypeStr = "";
			if($search_option == 'r' || $search_option == 'c')    {
				$gametypeStr.= "[".$row['game_type']."]";
			}

			$scoreStr = "";
			if($search_option == 'hs' || $search_option == 'ls')    {
				$scoreStr.= "[My Score: ".$row['ownscore']."]";
			}

			$lang = strtoupper($row['language']);

			if($selfprofile == 'true') {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$linkgid}&pid={$linkpid}&lang={$lang}";
				//$rematchlink = "<a href=\"".FB_APP_PATH."?action=newgame&with=$rematchlist\" class=\"text_blue_12\" target=\"_top\">Rematch?</a>";////////closed on 16_7_12  #1142
				$rematchlink = " <a href=\"".FB_APP_PATH."?action=newgame&with=$rematchlist&name=$newgameWith&rematch=1\" class=\"text_blue_12\" target=\"_top\">(rematch?)</a>";////////added on 16_7_12  #1142
			} else {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$linkgid}&lang={$lang}";
				$rematchlink = "";				
			}
            $l='<div style="margin:9px 0px 0 0;"><img src="'.APP_IMG_URL.'grey_ball.png" style="margin:3px 5px 0 0;float:left;" alt=""/>';
			$returnArr[] =  '<div class="text_grey3_12"><span class="text_grey3_12">' . $l . '<a href="'.$link.'" class="text_grey_12" target="_top">'.$row['game_id'].'</a> - <span class="text_blue_12">'.$playerlist.'.</span> '.$wonby . $finishedStr.' '.$rematchlink.'</span></div>' . "<div style=\"clear:both;\"></div></div>";
		}
		return $returnArr;
	}
}
*/

///modified on 7_8_12
function get_completedgames_list($email_id, $pagetoshow, $profile = 'false', $search_option = 'finishedon desc', $cutoff = '', $selfprofile = 'true') {

	if(!$search_option)
		$search_option = 'finishedon desc';

	/*if($cutoff == '200608')  {
		$gamestable = "games_over_200608";
		$userstable = "users_over_200608";
	} else {
		$gamestable = "games_over";
		$userstable = "users_over";
	}*/////closed on 7_8_12
	//$userstable = "users_over";/////added on 7_8_12

	$month = array("01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr", "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug", "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec",);

	global $completedGamesList;
	$pagetoshow = ($pagetoshow - 1) * 15;
	if(!strpos($email_id, "@"))
		$fb = "y";

	$total_count = 0;/////added on 7_8_12
	$returnstr = "";
	$imgname = "li-normal";
	
	//------added on 7_8_12
	$currentmonth = date("m");	
	$currentyear = date("y");
	$table_list_arr = array();
	$table_list_arr["users_over"] = "games_over";
	for($i=1;$i<=2;$i++){
		$previous_mn = $currentmonth - $i;
		$game_year = $currentyear;
		if($previous_mn == 0){
			$previous_mn = 12;
			$game_year = $currentyear - 1;
		}else if($previous_mn < 0){
			$previous_mn = 12 + $previous_mn;
			$game_year = $currentyear - 1;
		}
		$previous_mn = strlen($previous_mn)==2?$previous_mn:"0".$previous_mn;
		$table_list_arr['users_over_'.$previous_mn.$game_year] = "games_over_".($previous_mn).($game_year);
	}

	//print_r ($table_list_arr);exit;
	//------added on 7_8_12--end
	$returnArr = array();////added on 7_8_12
	foreach($table_list_arr as $k1 => $v1){	/////foreach added on 7_8_12

	if($profile == 'true') {
		//$sql = "SELECT  finishedon, winner, language, player_id, games_over.game_id, password, game_type  FROM users_over, games_over WHERE users_over.game_id = games_over.game_id and users_over.email='$email_id' order by games_over.finishedon desc limit $pagetoshow, 15";
		$sql = "SELECT  finishedon, winner, language, player_id, {$v1}.game_id, password, game_type  FROM {$k1}, {$v1} WHERE {$k1}.game_id = {$v1}.game_id and {$k1}.email='$email_id' order by {$v1}.finishedon desc limit $pagetoshow, 15";
	} else {
		////remove query on 8_8_12--#1439
	}//////all the queries are changed with variable of games_over-----7_8_12
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	//$returnArr = array();//////closed on 7_8_12
	if($cnt > 0) {
		while($row = mysql_fetch_array($result))
		{
			$wonby = "";
			// get list of players
			$playerlist = "";
			$newgameWith = "";/////////added on 16_7_12 #1142(4)
			$result1 = generic_mem_cache("pca" . $row['game_id'], 3600, "select id, player_id, nickname, email, password from $k1 where game_id = " . $row['game_id']);/////closed on 24_8_12
			$rematchlist = "";
			foreach ($result1 as $id=> $playrow)
			{
				if(!($playrow['email'] == $email_id)) {
					if($fb == 'y') {
						$playerlist .= '<a href="'.FB_APP_PATH.'?action=profile&profileid=' . $playrow['email'] . '" class="text_blue_12" target="_top">' . $playrow['nickname'] . '</a>, ';
                                           // $playerlist .= $playrow['nickname'] . ", ";
					} else {
						$playerlist .= $playrow['nickname'] . ", ";
					}

					$rematchlist .= $playrow['email'] . ",";
					$newgameWith .= $playrow['nickname'].',';/////////added on 16_7_12 #1142(4)
				} else {
					$linkpid = $playrow['player_id'];
					$linkpassword = $playrow['password'];
					$linkgid = $row['game_id'];
				}

				if($row['winner'] == $playrow['player_id']) {
					if($playrow['email'] == $email_id)
						$wonby = "<b>Won by " . $playrow['nickname']."</b>";
					else
						$wonby = "Won by " . $playrow['nickname'];
				} else if($row['winner'] == -1) {
						$wonby = "<b>Game Drawn</b>";
				}
			}

			$playerlist = substr($playerlist, 0, strlen($playerlist) - 2);
			$rematchlist =  substr($rematchlist, 0, strlen($rematchlist) - 1);
			$newgameWith =  substr($newgameWith, 0, strlen($newgameWith) - 1);///////added on 16_7_12 #1142

			$finishedStr = "";
			if($search_option == 'finishedon desc' || $search_option == 'finishedon asc')    {
				$datestamp = split(' ', $row['finishedon']);
				$datestamp = split('-', $datestamp[0]);
				$datestamp = $datestamp[2] . "-" . $month[$datestamp[1]] . "-" . substr($datestamp[0], 2, 2);
				$finishedStr.= " on " . $datestamp;
			}

			$gametypeStr = "";
			if($search_option == 'r' || $search_option == 'c')    {
				$gametypeStr.= "[".$row['game_type']."]";
			}

			$scoreStr = "";
			if($search_option == 'hs' || $search_option == 'ls')    {
				$scoreStr.= "[My Score: ".$row['ownscore']."]";
			}

			$lang = strtoupper($row['language']);

			if($selfprofile == 'true') {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$linkgid}&pid={$linkpid}&lang={$lang}";
				//$rematchlink = "<a href=\"".FB_APP_PATH."?action=newgame&with=$rematchlist\" class=\"text_blue_12\" target=\"_top\">Rematch?</a>";////////closed on 16_7_12  #1142
				$rematchlink = " <a href=\"".FB_APP_PATH."?action=newgame&with=$rematchlist&name=$newgameWith&rematch=1\" class=\"text_blue_12\" target=\"_top\">(rematch?)</a>";////////added on 16_7_12  #1142
			} else {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$linkgid}&lang={$lang}";
				$rematchlink = "";				
			}
            $l='<div style="margin:9px 0px 0 0;"><img src="'.APP_IMG_URL.'grey_ball.png" style="margin:3px 5px 0 0;float:left;" alt=""/>';
			$returnArr[] =  '<div class="text_grey3_12"><span class="text_grey3_12">' . $l . '<a href="'.$link.'" class="text_grey_12" target="_top">'.$row['game_id'].'</a> - <span class="text_blue_12">'.$playerlist.'.</span> '.$wonby . $finishedStr.' '.$rematchlink.'</span></div>' . "<div style=\"clear:both;\"></div></div>";

			//added on 7_8_12---added
			$total_count = $total_count + 1;
			if($total_count == 15)
				break;
			////7_812  ---end
		
		}
		//return $returnArr;/////closed on 7_8_12
	}
	if($total_count == 15)
	    break;
    }/////////end of for() ////7_8_12
    return $returnArr;//////changed position 0n 7_8_12
}


function get_activegames_count($email_id, $listtype = '0') {
	global $currentGamesList;
	
	// cut off date is three months
	$cutoffdate = mktime(0, 0, 0, date("m")-3, 1, date("Y"));
	$cutoffdate = date("Y-m-d", $cutoffdate);
	$cutoffdate = "$cutoffdate 00:00:00";
	
	$res = generic_mem_cache("glist" . $email_id, 900, "select games from users_games where email = '{$email_id}'");
	foreach($res as $id=>$playrow) {
		$currentGamesList = $playrow['games'];
	}

	// remove leading, trailing commas
	$currentGamesList = substr($currentGamesList, 1, -1);
	$row = array();
	if(strlen($currentGamesList) > 0) {
		if($listtype == '0') {
			$result = mysql_query("SELECT count(*) cnt FROM games WHERE game_id in ($currentGamesList) and  now() < games.expirydatetime and startedon >= '$cutoffdate'");
		} else {
			$result = mysql_query("SELECT count(*) cnt FROM games WHERE game_id in ($currentGamesList) and  now() > games.expirydatetime and startedon >= '$cutoffdate'");
		}		
		$row = mysql_fetch_array($result);
	} else {
		$row['cnt'] = 0;
	}
	
	return $row['cnt'];
}

function getNextGame($email_id, $skip_gid) {

	$language = array("sow" => "en", "twl" => "en", "fr" => "fr", "it" => "it"); 

	$res = generic_mem_cache("glist" . $email_id, 900, "select games from users_games where email = '{$email_id}'");
	foreach($res as $id=>$playrow) {
		$currentGamesList = $playrow['games'];
	}

	
	$currentGamesList = str_replace(',' . $skip_gid . ',', ',', $currentGamesList);
	$currentGamesList = substr($currentGamesList, 1, -1);
	//echo $currentGamesList;exit;
	
	$result = mysql_query("SELECT dictionary, current_move, game_id, users_info FROM games WHERE games.game_id in ( $currentGamesList ) limit 0,50");  //DICTIONARY IS NOT IN WS
	if(mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_array($result)) {
			$exp=explode("|", $row['users_info']);
			$count = 1;
			//echo "/////{$row['game_id']}////";exit;
			foreach($exp as  $val)  {
				$exp1=explode(',',$val);
				
                if(($exp1[0] == $email_id) && ($row['current_move'] == $count)) {
					return FB_APP_PATH . "?action=viewboard&gid={$row['game_id']}&pid={$count}&password={$exp1[1]}&lang={$language[$row['dictionary']]}";
				}
				$count++;
			}
		}
	}
	return false;
}

function get_games_list($email_id, $pagetoshow, $listtype = '0') {
	global $currentGamesList;

	// cut off date is three months
	$cutoffdate = mktime(0, 0, 0, date("m")-3, 1, date("Y"));
	$cutoffdate = date("Y-m-d", $cutoffdate);
	$cutoffdate = "$cutoffdate 00:00:00";
	
	$limit = 14;
	$pagetoshow = ($pagetoshow - 1) * $limit;

	if(strlen($email_id) < 1) return;
	if(!strpos($email_id, "@")) $fb = "y";

	$returnstr = "";

	if($listtype == '0') {
		$sql = "SELECT dictionary, language, current_move, game_id, game_type, lastupdate, users_info FROM games WHERE games.game_id in ( $currentGamesList ) and  now() < games.expirydatetime  and startedon >= '$cutoffdate' order by lastupdate desc limit $pagetoshow, $limit";
	} else {
		$sql = "SELECT dictionary, language, current_move, game_id, game_type, lastupdate, users_info FROM games WHERE games.game_id in ( $currentGamesList ) and  now() > games.expirydatetime and startedon >= '$cutoffdate' order by lastupdate desc limit $pagetoshow, $limit";
	}

	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);

	if($cnt > 0) {
		while($row=mysql_fetch_array($result))
		{
			$PLAYER_ID_ARRAY = array();
			$PASSWORD_ARRAY = array();
			$NICKNAME_ARRAY = array();

			$exp = explode("|", $row['users_info']);
			$count = 1;

			foreach($exp as  $val)  {
				$exp1 = explode(',',$val);
				$PLAYER_ID_ARRAY[$exp1[0]] = $count;
				$PASSWORD_ARRAY[$exp1[0]] = $exp1[1];
				$NICKNAME_ARRAY[$exp1[0]] = $exp1[2];
				$count++;
			}

			$turn = "";
			$lang = strtoupper($row['language']);
			$lang1 = $row['dictionary'];

			if($PLAYER_ID_ARRAY[$email_id] == $row['current_move']) {
				if($profileList == 'true')
				$turn = "Your turn.";
				else
				$turn = "Your turn.";
				$imgname = "li-active";
			}

			$playerlist = "";

			$count =1;
			$imgname = '<img src="'.APP_IMG_URL.'blue_ball.png" alt="" />';
			$i=2;
			$x=count($NICKNAME_ARRAY);
			foreach($NICKNAME_ARRAY as $uid_key=>$name_val)
			{
				if(!($uid_key == $email_id)) {
					if($count != $row['current_move']) {
						if($count==$x){
							$playerlist .= " <a href=\"".FB_APP_PATH."?action=profile&profileid={$uid_key}\" class=\"text_blue_12\" target=\"_top\">{$name_val}.</a>";
						} else {
							$playerlist .= " <a href=\"".FB_APP_PATH."?action=profile&profileid={$uid_key}\" class=\"text_blue_12\" target=\"_top\">{$name_val},</a>";
						}
					}

					if(($count == $row['current_move']) && ($turn == "")) {
						$turnPID = $uid_key;
						$turn = "<span class=\"text_grey2_12\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$uid_key}\" class=\"text_blue_12\" target=\"_top\">{$name_val}'s</a> turn.</span>";
						$imgname = '<img src="'.APP_IMG_URL.'grey_ball.png" alt="" />';
					}
				}
				$count++;
			}

			$link = FB_APP_PATH . "?action=viewboard&gid={$row['game_id']}&pid={$PLAYER_ID_ARRAY[$email_id]}&password={$PASSWORD_ARRAY[$email_id]}&gametype={$row['game_type']}&lang=" . strtoupper($row['language']);

			if($turn == "Your turn.") {
				$turn = "<a href=\"$link\" class=\"text_black_13\" target=\"_top\">Play your turn.</a>";
			} else {
				$playerlist = str_replace(".", ", ", $playerlist);
			}

			if($profileList == 'true') {
				$returnstr .= "<game><no>" . $row['game_id'] . "</no><players>" . $playerlist . "</players><turn>$turn</turn></game>";
			} else {

				$lastplay = getTimeDiff($row['lastupdate']);

				$toolinfo = "";
				if($lang1=='twl'){
					$toolinfo = "(US) (last move: {$lastplay})";
				} else if($lang1=='sow'){
					$toolinfo = "(UK) (last move: {$lastplay})";
				} else {
					$toolinfo = "({$lang}) (last move: {$lastplay})";
				}

				echo "<div id=\"tooltipdiv\"></div><div class=\"gamelist_active\" onmousemove=\"showToolTip(event,'$toolinfo');\" onmouseout=\"hideToolTip()\"><span class=\"active_game\">{$imgname}</span><span class=\"text_grey3_12\"><a href=\"{$link}\" class=\"text_grey_12\" target=\"_top\">{$row['game_id']}</a> - $playerlist  $turn</span>";

				if( ($PLAYER_ID_ARRAY[$email_id] != $row['current_move'])&& ( (strpos($lastplay, 'd')) || (strpos($lastplay, 'w')) || (strpos($lastplay, 'mon')))) {

					$link_path = FB_APP_PATH."?viewgid=".$row['game_id'];
					echo '<span id="nudge_span_'.$row['game_id'].'" onclick="check_nudge(\''.$turnPID.'\',\''.$link_path.'\')" > <a href="#"><img src="'.APP_IMG_URL.'nudge.png" /></a></span>';
										
					/*$urlSub = urlencode("Hey, we have a game of Lexulous in progress and it's your turn:) Please click on this link to play your move - ".FB_APP_PATH."?viewgid={$row['game_id']} - thanks!");
					echo '<span> <a href="http://www.facebook.com/message.php?id=' . $turnPID . '&subject=Your move on Lexulous!&msg='.$urlSub.'" target="_blank"><img src="'.APP_IMG_URL.'nudge.png" /></a></span>';*/
				}

				if($listtype != '0') {
					if($PLAYER_ID_ARRAY[$email_id] != $row['current_move']) {
						echo "<span> <a href=\"".FB_APP_PATH."?action=resign-ques&id={$turnPID}&gid={$row['game_id']}&pid={$PLAYER_ID_ARRAY[$email_id]}&password={$PASSWORD_ARRAY[$email_id]}\" target=\"_top\"><img src=\"".APP_IMG_URL."force_win.png\" /></a></span>";
					}
				}
				echo "</div>";
			}
		}
		return;
	}

	echo '<div style="margin:0 0 19px -6px;">
		<div class="splash_play_option_bg_left">
			<div style="padding:50px 0 0 35px;">
				<a href="'.FB_APP_PATH.'?action=newgame" target="_top"><img src="'.APP_IMG_URL.'play_with_friends_text.png" alt="" /></a><br /><br />
				<a href="'.FB_APP_PATH.'?action=randomjoin" target="_top"><img src="'.APP_IMG_URL.'random_opponents_text.png" alt="" /></a>
				
				</div></div></div>';
	//echo '<div class="splash_play_option_bg1">
   // <a href= "'.FB_APP_PATH.'?action=newgame" target="_top"><img src="'.APP_IMG_URL.'play_with_friends_text.png" alt="" /></a><br /><br />
   //<a href="'.FB_APP_PATH.'?action=randomjoin" target="_top"><img src="'.APP_IMG_URL.'random_opponents_text.png" alt="" /></a>
   // <p><img src="'.APP_IMG_URL.'/text_img01.png" alt="" /></p></div>';
}


function getTimeDiff($lastupdate) {
	return timeDiff(strtotime($lastupdate), true, 1);
}

function timeDiff($timestamp, $detailed=false, $max_detail_levels=8, $precision_level='second')
{
	$now = time();

	if($timestamp >= $now) {
		return "a moment ago";
	}

	#If the difference is positive "ago" - negative "away"
	($timestamp >= $now) ? $action = 'away' : $action = 'ago';

	# Set the periods of time
	$periods = array("s", "m", "h", "d", "w", "mon", "y", "decade");//IN WS "mon" IS "m"
	$lengths = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);

	$diff = ($action == 'away' ? $timestamp - $now : $now - $timestamp);

	$prec_key = array_search($precision_level,$periods);

	# round diff to the precision_level
	$diff = round(($diff/$lengths[$prec_key]))*$lengths[$prec_key];

	# if the diff is very small, display for ex "just seconds ago"
	if ($diff <= 10) {
		$periodago = max(0,$prec_key-1);
		$agotxt = $periods[$periodago];
		return "$agotxt$action";
	}

	# Go from decades backwards to seconds
	$time = "";
	for ($i = (sizeof($lengths) - 1); $i>0; $i--) {
		if($diff > $lengths[$i-1] && ($max_detail_levels > 0)) {        # if the difference is greater than the length we are checking... continue
			$val = floor($diff / $lengths[$i-1]);    # 65 / 60 = 1.  That means one minute.  130 / 60 = 2. Two minutes.. etc
			$time .= $val ."". $periods[$i-1].($val > 1 ? ' ' : ' ');  # The value, then the name associated, then add 's' if plural
			$diff -= ($val * $lengths[$i-1]);    # subtract the values we just used from the overall diff so we can find the rest of the information
			if(!$detailed) { $i = 0; }    # if detailed is turn off (default) only show the first set found, else show all information
			$max_detail_levels--;
		}
	}

	# Basic error checking.
	if($time == "") {
		return "";
	} else {
		return $time.$action;
	}
}

function gameGamesXML($uid) {
	return get_games_list($uid, 'true');
}

function getBingosXML($uid) {
	return get_bingos($uid, 'true');
}

function getStatsXML($uid) {
	return get_stats($uid, 'true');
}

function get_game_type($gid) {
	$res = mysql_query("select game_type from games where game_id = $gid");
	$row = mysql_fetch_array($res);
	return $row['game_type'];
}

function get_game_status($gid) {
	$res = mysql_query("select game_id from games where game_id = $gid");
	if(mysql_num_rows($res) > 0)
		return 'A';
	else
		return '';
}

function post_gamerequest($uid, $dictionary, $gametype, $gamespeed, $maxplayers, $expiresin, $brag, $rangefrom, $rangeto, $adultsonly = 'n', $mobile='n') {

	global $facebook;

	if($rangefrom < 0)
		$rangefrom = 0;

	if($rangeto <= $rangefrom)
		$rangeto = 9999;


     if($mobile == 'y')          
        $p1nickname = getNicknameFromFbpassword($uid);
     else
	   $p1nickname = getNickName($uid);

	
	mysql_query("delete from fbrequests where user = '$uid'");
	mysql_query("delete from fbrequests_brags where uid = '$uid'");
	$res = mysql_query("select rating from users_stats where email = '$uid'");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		$rating = $row['rating'];
	} else
		$rating = 1200;

	if($rating == 0)
		$rating = 1200;

	delMemCache("statscache/" . $uid);
	delMemCache("avgstat" . $uid);

	mysql_query("insert into fbrequests set user = '$uid', postedon = NOW(), rating = $rating, expireson = DATE_ADD(NOW(), INTERVAL '$expiresin:0' MINUTE_SECOND), dictionary = '$dictionary', brag = '$brag', maxplayers = '$maxplayers', speed = '$gamespeed', gametype = '$gametype',`fromrating` = '$rangefrom', `torating` = '$rangeto', adult = '$adultsonly', name = '$p1nickname', pic_small = '$picLink'");
	mysql_query("insert into fbrequests_brags set notes = '$brag', uid = '$uid'");
}

function get_requestbrag($uid) {
    if(!DB::$connected) { DB::connect(); }  
	$res = mysql_query("select notes from fbrequests_brags where uid = '$uid'");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		return $row['notes'];
	}
}

function clear_gamerequest($uid) {
	$res = mysql_query("delete from fbrequests where user = '$uid'");
}

function start_gamerequest($uid) {
	$res = mysql_query("update fbrequests set maxplayers = maxplayers - 1 where user = '$uid'");
	$res = mysql_query("select * from fbrequests where user = '$uid' and maxplayers > -1");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		return $row;
	}
}

function weightRandom($weights) {
	$loop;
	$topNum;
	$randNum;

	foreach( $weights as $val ){
		$topNum += $val;
	}
	$randNum = rand()%$topNum+1;
	$topNum = 0;
	foreach( $weights as $key => $val ){
		$topNum += $val;
		if( $val > 0 ){
			if( $topNum >= $randNum ){
				return $key;
			}
		}
	}
}

function addGametoUser($userList, $gid) {
	$gid_str = $gid . ',';
	foreach($userList as $val) {
		delMemCache("glist" . $val);
		mysql_query("update `users_games` set `games`=CONCAT(games, '','$gid_str') where email='$val'");
		if(mysql_affected_rows() == 0) {
			mysql_query("insert into `users_games` set `email`='$val',`games`=',$gid_str' ");
		}
	}
}

function removeGamefromUser($userList, $gid)   {
	$email_str = "";
	foreach($userList as $val)  {
		 $email_str.= "'".$val."',";
	}
	$email_str = substr($email_str, 0, -1);
	mysql_query("update users_games set games = replace(games,',$gid,',',') where email in ($email_str)");
}

function do_manual_stats($uid) {
	$doStats = 0;
	$res = mysql_query("select TIMESTAMPDIFF(DAY , lastupdate , NOW()) diff from users_manualstats where email = '$uid'");
	if(mysql_num_rows($res) > 0) {
		$row = mysql_fetch_array($res);
		if($row['diff'] > 0) {
			$doStats = 1;
			mysql_query("update users_stats set lastupdate = TIMESTAMPADD(MINUTE, 11, NOW()) where email = '$uid'");
			mysql_query("update users_manualstats set lastupdate = NOW() where email = '$uid'");
		}
	} else {
		mysql_query("insert into users_manualstats set email = '$uid', lastupdate = TIMESTAMPADD(MINUTE, 11, NOW())");
		mysql_query("update users_stats set lastupdate = TIMESTAMPADD(MINUTE, 11, NOW()) where email = '$uid'");
		$doStats = 1;
	}

	if($doStats == 1) {
		return "Your request is queued. Should take place within 15 minutes.";
	} else {
		return "Sorry, you can use this feature once every 24 hours.";
	}
}


function saveNotes($id, $data) {
	// first part of id is gid
	// second part is uid
	include_once '/var/www/html/fblexulous/constants.php';///////////////////////added////////for amazondb
		
	$id = split('-', base64_decode($id));
	$gid = $id[0];
	$uid = $id[1];

	
	if(($gid <=0) || ($uid <=0)) {
		return;
	}
	
	/********* Done	*********//*
	$last_digit = $id[1] % 10;

	switch($last_digit) {

		case 0:
		case 1: 
			$serverdir = FILEPATH.'/gamedata/73/';
			$altserverdir = FILEPATH.'/backup/data/73/';
			$filename = FILEPATH.'/gamedata/73/SNOTES'. $uid. '.txt';
			break;

		case 2:
		case 3: 
			$serverdir = FILEPATH.'/gamedata/72/';
			$altserverdir = FILEPATH.'/backup/data/72/';
			$filename = FILEPATH.'/gamedata/72/SNOTES'. $uid. '.txt';
			break;

		case 4:
		case 5: 
			$serverdir = FILEPATH.'/gamedata/71/';
			$altserverdir = FILEPATH.'/backup/data/71/';
			$filename = FILEPATH.'/gamedata/71/SNOTES'. $uid. '.txt';
			break;

		case 6:
		case 7: 
			$serverdir = FILEPATH.'/gamedata/69/';
			$altserverdir = FILEPATH.'/backup/data/69/';
			$filename = FILEPATH.'/gamedata/69/SNOTES'. $uid. '.txt';
			break;

		case 8:
		case 9: 
			$serverdir = FILEPATH.'/gamedata/68/';
			$altserverdir = FILEPATH.'/backup/data/68/';
			$filename = FILEPATH.'/gamedata/68/SNOTES'. $uid. '.txt';
			break;
	}


	//$serverdir = "/var/www/html/public/FACEBOOKALL/Lexulous/GAMENOTE/";
	//$filename = '/var/www/html/public/FACEBOOKALL/Lexulous/GAMENOTE/SNOTES'. $uid. '.txt';
		
	if(!is_dir($serverdir) ) {
		$filename = $altserverdir . 'SNOTES' . $uid. '.txt';
	}

	if(file_exists($filename)) {
		$arr = unserialize(file_get_contents($filename));
	} else {
		$arr = array();
		$arr[$gid] = $data;
	}

	$arr[$gid] = $data;
	$fh = fopen($filename, 'w');
	fwrite($fh, serialize($arr));
	fclose($fh);
	chmod ($filename, 0777);
	*//********** Done	*********/
	
	///////////////////added/////////////
	
	$FileIO = new FileIOModel();
	$fileText = $FileIO->getFile($uid, "gamenote");
	if ($fileText[0] == ''){
		$arr = array();
		$arr[$gid] = $data;
	}else{
		$arr = unserialize($fileText[0]);
	}
	
	$arr[$gid] = $data;
	$FileIO->writeFile($uid, "gamenote", serialize($arr));
	
	///////////////////added//////////////
	
	
}

function getNotes($id) {
	// first part of id is gid
	// second part is uid

	include_once '/var/www/html/fblexulous/constants.php';///////////////////////added////////for amazondb
	
	$id = split('-', base64_decode($id));
	$gid = $id[0];
	$uid = $id[1];

	if(($gid <=0) || ($uid <=0)) {
		return;
	}

	/********* Done	*********//*
	$last_digit = $id[1] % 10;

	switch($last_digit) {

		case 0:
		case 1: 
			$serverdir = FILEPATH.'/gamedata/73/';
			$altserverdir = FILEPATH.'/backup/data/73/';
			$filename = FILEPATH.'/gamedata/73/SNOTES'. $uid. '.txt';
			break;

		case 2:
		case 3: 
			$serverdir = FILEPATH.'/gamedata/72/';
			$altserverdir = FILEPATH.'/backup/data/72/';
			$filename = FILEPATH.'/gamedata/72/SNOTES'. $uid. '.txt';
			break;

		case 4:
		case 5: 
			$serverdir = FILEPATH.'/gamedata/71/';
			$altserverdir = FILEPATH.'/backup/data/71/';
			$filename = FILEPATH.'/gamedata/71/SNOTES'. $uid. '.txt';
			break;

		case 6:
		case 7: 
			$serverdir = FILEPATH.'/gamedata/69/';
			$altserverdir = FILEPATH.'/backup/data/69/';
			$filename = FILEPATH.'/gamedata/69/SNOTES'. $uid. '.txt';
			break;

		case 8:
		case 9: 
			$serverdir = FILEPATH.'/gamedata/68/';
			$altserverdir = FILEPATH.'/backup/data/68/';
			$filename = FILEPATH.'/gamedata/68/SNOTES'. $uid. '.txt';
			break;
	}

	//$serverdir = "/var/www/html/public/FACEBOOKALL/Lexulous/GAMENOTE/";
	//$filename = '/var/www/html/public/FACEBOOKALL/Lexulous/GAMENOTE/SNOTES'. $uid. '.txt';
	
	if( !is_dir($serverdir) ) {
		$filename = $altserverdir . 'SNOTES' . $uid. '.txt';
	}


	if(file_exists($filename)) {
		$arr = unserialize(file_get_contents($filename));
		//return $arr[$gid];
	} else {
		//return "";
	}
	*//********** Done	*********/
	
	///////////////////added////////////
	$FileIO = new FileIOModel();
	$fileText = $FileIO->getFile($uid, "gamenote");
	if ($fileText[0] != ''){
		$arr = unserialize($fileText[0]);
		if (array_key_exists($gid, $arr)){
			return $arr[$gid];
		}else{
			return "";
		}
	}else{
		return "";
	}
	///////////////////added/////////////
}


function get_onetoone_stats($uid, $foruid) {

	$returnstr = "";

	if($uid < $foruid)
		$ustr = $foruid . "-" . $uid;
	else
		$ustr = $uid . "-" . $foruid;

	$results = generic_mem_cache('L21' . $ustr, 3600, "SELECT * from h2hstats where user = '$ustr'");
	$row = $results[0];
	//return $row;
	//print_r ($row);exit;
	
	$gamescompleted = $row['won'] + $row['lost'] + $row['drawn'];

	if($uid < $foruid) {
		$gameswon = abs($row['lost']);
		$gameslost = abs($row['won']);
	} else {
		$gameswon = abs($row['won']);
		$gameslost = abs($row['lost']);
	}

	$returnstr .= '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
	$returnstr .= '<tr><td class="game_heading" align="left" valign="top">Completed</td><td class="game_heading" align="left" valign="top">I Won</td><td class="game_heading" align="left" valign="top">I Lost</td><td class="game_heading" align="left" valign="top">Drawn</td></tr>';
	$returnstr .= '<tr class="players_details"><td class="players_details_td" align="left" valign="top">' . $gamescompleted . '</td><td class="players_details_td" align="left" valign="top">' . $gameswon . '</td><td class="players_details_td" align="left" valign="top">' . $gameslost . '</td><td class="players_details_td" align="left" valign="top">' . abs($row['drawn']) . '</td></tr>';
	$returnstr .= '</table>';

	return $returnstr;
}

function getNicknameFromFbpassword($uid) {

	$nickname = getMemCache("n-". $uid);
	if($nickname)
	return $nickname;

	$query = mysql_query("select user,nickname from `fbpassword` where user='$uid' and nickname != ''");
	if(mysql_num_rows($query) > 0)     {
		$row = mysql_fetch_array($query);
		$nickname = $row['nickname'];
	}
	else  {
		$query = mysql_query("select email,nickname from `users` where email='$uid' limit 0,1");
		if(mysql_num_rows($query) > 0) {
			$row = mysql_fetch_array($query);
			$nickname = $row['nickname'];
		}
		else  {
			$query = mysql_query("select email,nickname from `users_over` where email='$uid' limit 0,1");
			$row = mysql_fetch_array($query);
			$nickname = $row['nickname'];
		}
	}
	setMemCache("n-". $uid, $nickname, false, 600);
	return $nickname;
}

function ratingLevel($user) {
	global $facebook, $udetails;
	$level_arr = array();
	
	$rating_res = generic_mem_cache('statscache/B' . $user, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$user'");
	$rating_rec = $rating_res[0];
	$brating = $rating_rec['rating'];
	$rating = $rating_rec['rating'];
	$name = $udetails[0][0]; 
	$sex = $udetails[0][3];
	
	if($sex == "male") { 
		$pro = array("He","His","Him");
	}
	else if($sex == "female") {
		$pro = array("She","Her","Her");
	}
	else {
		$pro = array($name,$name);
	}
	
	if($rating_rec['played']<20 ) {
		$level_arr['New Fish'] = array("img"=>"nu_fish.png","desc"=>"{$name} has just started playing the Lexulous Crossword Game! Would you like to start a few games with ".strtolower($pro[2])."?");	
	}	
	if($brating>=1000) {
		$level_arr['Amateur'] = array("img"=>"level_up.png","desc"=>"{$name} is now an AMATEUR at the Lexulous Crossword game! {$pro[1]} rating is {$rating}.");
	}
	if($brating>=1200) {
		$level_arr['Playa'] = array("img"=>"level_up2.png","desc"=>"{$name} is getting better at Lexulous! {$pro[1]} rating is now {$rating} and {$pro[0]} just unlocked the Playa achievement!");
	}
	if($brating>=1400) {
		$level_arr['Shark'] = array("img"=>"level_up3.png","desc"=>"With a rating of {$brating}, {$name} is now a SHARK at Lexulous!");
	}
	if($brating>=1600) {
		$level_arr['Professional'] = array("img"=>"pro_level.png","desc"=>"{$name} just became a PRO at Lexulous, with an impressive rating of {$brating}!");
	}
	if($brating>=1800) {
		$level_arr['Champion'] = array("img"=>"champ.png","desc"=>"{$name} just joined the league of champions by achieving a rating of {$brating} at Lexulous!");
	}
	if($brating>=2000) {
		$level_arr['Genius'] = array("img"=>"genius.png","desc"=>"{$name} just became a GENIUS at Lexulous, with a rating of {$brating}! Only a few thousand users have ever managed this feat.");
	}
	if($brating>2200) {
		$level_arr['Godlike'] = array("img"=>"god_like.png","desc"=>"{$name}\'s Lexulous rating just crossed 2200. {$pro[0]} is now one of the best of the best of the best!");
	}
	
	$stat_res = generic_mem_cache('avgstat' . $user, 3600, "SELECT * FROM `averageStats` WHERE userid = '$user'");
	$stat_rec = $stat_res[0];

	switch($stat_rec['streak']) {
		case 4:
			$level_arr['On Fire'] = array("img"=>"on_fire.png","desc"=>"{$name} just won 4 games of Lexulous in a row!");		
			break;
		case 5:
			$level_arr['Thunderstorm'] = array("img"=>"omg.png","desc"=>"{$name} has won FIVE games of Lexulous in a row! Can someone stop ".strtolower($pro[2])."?");		
			break;
		case 6:
			$level_arr['Unstoppable'] = array("img"=>"unstoppable.png","desc"=>" {$pro[0]}\'s just managed 6 wins in a row but there is no stopping {$name}!");		
			break;
		case 7:
			$level_arr['Nightmare'] = array("img"=>"nightmare.png","desc"=>"With 7 victories in a row, {$name} is simply terrorizing his opponents!");		
			break;
	}
	
	return $level_arr;
}

function get_archive_games($user,$orderby=0,$profile=false) {
	//include_once ("archive_file_path.php");/////////////done
	
	$returnArr = array();
	//$fileinfo  = get_archive_file_path($user);///////////////done
	//$serverdir = $fileinfo[0]; $altserverdir = $fileinfo[1]; $filename = $fileinfo[2];/////////////done

	//if(!is_dir($serverdir)) { $filename = $altserverdir; }////////////////done
	$archive_file_arr = array();
/*	echo "******$filename*******<br />";
	if (file_exists($filename)) {
    	echo "The file $filename exists";
	} else {
    	echo "The file $filename does not exist";
	}*/
	
	$archive_file_arr = total_finishedGamesDetails($user);///////added on 2_8_12
	//$FileIO = new FileIOModel();//////////////added////closed on 2_8_12
	//$inputstring = $FileIO->getFile($user,"archive");//////added////closed on 2_8_12
	//if ($inputstring[0] != ''){//////////////////////////added/////closed on 2_8_12
		//$archive_file_arr = unserialize($inputstring[0]);////////added///////closed on 2_8_12
		//if(file_exists($filename)) {//////////////////////done
		//$serialize_file = file($filename);///////////////done
		//echo "********$serialize_file*********";
		//$archive_file_arr = unserialize($serialize_file[0]);/////////done
		
		if(count($archive_file_arr)>0) {
			switch($orderby) {
				case 1: // recent game first
					$sort_key_arr = array();
					foreach($archive_file_arr as $archive) { $sort_key_arr[] = $archive['date']; }
					array_multisort($sort_key_arr, SORT_DESC, $archive_file_arr);
					break;
				case 2: // old game first
					$sort_key_arr = array();
					foreach($archive_file_arr as $archive) { $sort_key_arr[] = $archive['date']; }
					array_multisort($sort_key_arr, SORT_ASC, $archive_file_arr);
					break;
				case 3: // winner first
					$temp = array();
					foreach($archive_file_arr as $archive) {
						if($archive['winuid'] == $user)
							array_unshift($temp,$archive);
						else
							$temp[] = $archive;
					}
					$archive_file_arr = $temp;
					break;
				case 4: // lost first
					$temp = array();
					foreach($archive_file_arr as $archive) {
						if($archive['winuid'] != $user && $archive['winuid'] != -1)
							array_unshift($temp,$archive);
						else
							$temp[] = $archive;
					}
					$archive_file_arr = $temp;
					break;
				case 5: // draws first
					$sort_key_arr = array();
					foreach($archive_file_arr as $archive) { $sort_key_arr[] = $archive['winuid']; }
					array_multisort($sort_key_arr, SORT_ASC, $archive_file_arr);
					break;
				case 6: // regular game first
					$sort_key_arr = array();
					foreach($archive_file_arr as $archive) { $sort_key_arr[] = $archive['gtype']; }
					array_multisort($sort_key_arr, SORT_DESC, $archive_file_arr);
					break;
				case 7: // challenge game first
					$sort_key_arr = array();
					foreach($archive_file_arr as $archive) { $sort_key_arr[] = $archive['gtype']; }
					array_multisort($sort_key_arr, SORT_ASC, $archive_file_arr);
					break;
			}
		}


		foreach($archive_file_arr as $key=>$gamedetails) {
			$ownpid = $ownpassword = $status = $playerlist = $rematchlist = "";         
			$players = explode("|",$gamedetails['players']);
			
			$pindex = 1;
			$opp_list="";
			foreach ($players as $player_list){
				$plr_arr2 = explode(",",$player_list);				
				if($plr_arr2[0]!=$user){
					$opp_list.=$plr_arr2[1].",";
				}
				
			}
			$rest = substr($opp_list, 0, -1);		
			foreach($players as $plr) {
				$plr_arr = explode(",",$plr);
				if($plr_arr[0] != $user) {
					$playerlist .= "<a href=\"".FB_APP_PATH."?action=profile&profileid={$plr_arr[0]}\" target=\"_top\" class=\"text_blue_12\">{$plr_arr[1]}</a>, ";
					$rematchlist .= $plr_arr[0] . ",";
				} else {
					$ownpid      = $pindex;
					$ownpassword = $plr_arr[2];
				}
				if($gamedetails['winuid'] == $plr_arr[0]) { 
					if($plr_arr[0] == $user) {
						$status = "<b>Won by {$plr_arr[1]}</b>";
						$my_name=getNickName($user);
						$winstatus="&nbsp;&nbsp;&nbsp;<a href='#' class=\"text_blue_12\"  onclick='gameoverArchivePublish(\"$my_name\",\"$rest\",4,5,6,7);'>Share My Victory!</a>";	
					} else {
						$status = "Won by {$plr_arr[1]}";
						$winstatus="";
					}
				}
				$pindex++;
			}
			
			if($gamedetails['winuid'] == -1) { $status = "Game Drawn"; }
			
			if($profile) {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$gamedetails['gid']}&pid={$ownpid}&password={$ownpassword}&gametype={$gamedetails['gtype']}&lang=" . strtoupper($gamedetails['lang']);
				$rematchlink = "<a href=\"".FB_APP_PATH."?action=newgame&with=".substr($rematchlist,0,-1)."&name=$rest&rematch=1\" class=\"text_blue_12\" target=\"_top\">Rematch?</a>";///////changed on 16_7_12 &name=$rest&rematch=1 added #1142(4) 
			} else {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$gamedetails['gid']}&gametype={$gamedetails['gtype']}&lang=" . strtoupper($gamedetails['lang']);
				$rematchlink = "";
			}
						
			$gametypeStr = "";
			if($orderby == 6 || $orderby == 7) $gametypeStr = "[{$gamedetails['gtype']}]";
			
		
			$l='<div style="margin:9px 0px 0 0;"><img src="'.APP_IMG_URL.'grey_ball.png" style="margin:3px 5px 0 0;float:left;" alt=""/>';
			$returnArr[]= "<div class=\"text_grey3_12 \"><span class=\"text_grey3_12\">{$l}<a href=\"$link\" class=\"text_grey_12\" target=\"_top\"><u>{$gamedetails['gid']}</u></a></span> - ".substr($playerlist,0,-2) ." - ". $status ."  on ".date("d-M-y",$gamedetails['date']) .$winstatus. "&nbsp;&nbsp;&nbsp;$rematchlink</div>".
						  "<div style=\"clear:both;\"></div></div>";
		}
	//}////////closed on 2_8_12
	
	return $returnArr;
}

function feed_generate($gid)
{
	global $tmp_games_fre_tiles_table;

    $rest = mysql_query("SELECT * FROM `$tmp_games_fre_tiles_table` WHERE `gameid`='$gid' ");
    $rowt = mysql_fetch_array($rest);

    $feed = "";
    $feed.=str_repeat("A", $rowt["tile_a"]);
    $feed.=str_repeat("B", $rowt["tile_b"]);
    $feed.=str_repeat("C", $rowt["tile_c"]);
    $feed.=str_repeat("D", $rowt["tile_d"]);
    $feed.=str_repeat("E", $rowt["tile_e"]);
    $feed.=str_repeat("F", $rowt["tile_f"]);
    $feed.=str_repeat("G", $rowt["tile_g"]);
    $feed.=str_repeat("H", $rowt["tile_h"]);
    $feed.=str_repeat("I", $rowt["tile_i"]);
    $feed.=str_repeat("J", $rowt["tile_j"]);
    $feed.=str_repeat("K", $rowt["tile_k"]);
    $feed.=str_repeat("L", $rowt["tile_l"]);
    $feed.=str_repeat("M", $rowt["tile_m"]);
    $feed.=str_repeat("N", $rowt["tile_n"]);
    $feed.=str_repeat("O", $rowt["tile_o"]);
    $feed.=str_repeat("P", $rowt["tile_p"]);
    $feed.=str_repeat("Q", $rowt["tile_q"]);
    $feed.=str_repeat("R", $rowt["tile_r"]);
    $feed.=str_repeat("S", $rowt["tile_s"]);
    $feed.=str_repeat("T", $rowt["tile_t"]);
    $feed.=str_repeat("U", $rowt["tile_u"]);
    $feed.=str_repeat("V", $rowt["tile_v"]);
    $feed.=str_repeat("W", $rowt["tile_w"]);
    $feed.=str_repeat("X", $rowt["tile_x"]);
    $feed.=str_repeat("Y", $rowt["tile_y"]);
    $feed.=str_repeat("Z", $rowt["tile_z"]);
    $feed.=str_repeat("*", $rowt["tile_blank"]);
    return $feed;
}

function rand_str()
{
    $feed = "0123456789abcdefghijklmnopqrstuvwxyz";
    for ($i = 0; $i < 4; $i++)
    {
        $rand_str .= substr($feed, rand(0, strlen($feed) - 1), 1);
    }

    return ($rand_str);
}


function valid_email($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function display_opponent_badges($gid,$uid) {
    global $facebook;

    //echo "****$gid/////$uid*****";
    if(!DB::$connected) { DB::connect (); }

    $opp_result = mysql_query("select email from users where game_id = '$gid'");
    //echo "select email from users where game_id = '$gid'";
    $disp_str ="";
	$js_str = "\n\n<script type=\"text/javascript\">\n";
	$js_cnt = 0;
	
    $email_str = "";
    while($opp_record = mysql_fetch_array($opp_result)) { 
 
		
		$js_str .= "uidList = uidList + '" . $opp_record['email'] . ",';\n";
		$js_cnt++;
       
    	$users_stats_res = generic_mem_cache('statscache/B' . $opp_record['email'], 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$opp_record[email]'");
        $users_stats_rec = $users_stats_res[0];
		$bingocount = userBingoCount($opp_record[email]);

        //$bingo_res = generic_mem_cache('SbingosCount/' . $opp_record['email'], 3600, "select count(*) as cnt from bingos where userstatid = '{$users_stats_rec['id']}'");

        if(!$users_stats_rec['rating'] || $users_stats_rec['rating'] <= 0 ) { $users_stats_rec['rating'] = 1200; }
        $gamescompleted = $users_stats_rec['won'] + $users_stats_rec['lost'] + $users_stats_rec['drawn'];

        $disp_str .="<div class=\"user_details\">";
 
 /*       $user_data = getUserInfo($opp_record['email'],'first_name,last_name,pic_square,pic_big');
        $pic_big = $user_data[0]['pic_big'];
        
		$email_str .= "'".$opp_record['email']."',"; 
		if($pic_big == "")
            $disp_str .= "<span class=\"user_photo2\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\"><img src=\"{$user_data[0]['pic_square']}\" width=\"30\" height=\"30\" /></a></span>";
        else
            $disp_str .= "<span class=\"user_photo2\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\"  target=\"_top\" onmouseout=\"hidePlayerImage()\" onmousemove= \"showPlayerImage(event,'$pic_big')\" ><img src=\"{$user_data[0]['pic_square']}\" width=\"30\" height=\"30\" /></a></span>";

        $disp_str .="<div style=\"float:left;\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\" class=\"text_blue2_11\">{$user_data[0]['first_name']} {$user_data[0]['last_name']}</a><br />";
		//$disp_str .= "<span class=\"user_photo2\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\" id=\"userPhoto{$opp_record['email']}\"> </a></span>";
        
        //$disp_str .="<div style=\"float:left;\"><a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\" 
        			//class=\"text_blue2_11\" id=\"userName{$opp_record['email']}\"></a><br />"; */

		$disp_str .= "<span class=\"user_photo2\" id=\"photo_" .$opp_record['email'] . "\"></span>";
		$disp_str .="<div style=\"float:left;\"><span  id=\"name_" . $opp_record['email'] . "\">Loading ...</span><br />";

        $disp_str .="<div class=\"user_rank\">";
        $disp_str .="<span class=\"text_grey4_11\">{$users_stats_rec['rating']}</span>";
        $disp_str .="<a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\" class=\"stats_details_btn\"></a>";
        $disp_str .="</div>";
        $disp_str .="<div class=\"game_stats_details\">
			        <ul>
			            <li>{$gamescompleted}</li>
			            <li>{$users_stats_rec['won']}</li>
			            <li>{$users_stats_rec['lost']}</li>
			            <li>{$users_stats_rec['drawn']}</li>
			            <li>{$bingocount}</li>
			            <li class=\"clr\"></li>
			        </ul>
			        </div></div><div class=\"clr\"></div></div>";
        
    }
   	$str = trim($email_str,',');
	$js_str .= "uidList = uidList.substr(0,uidList.length - 1);\n\n</script>\n\n";
	$disp_str .= "<script type=\"text/javascript\"> showGameboardUserInfo(\"{$str}\"); </script>";
	
	return $disp_str . $js_str;
}

function get_myfriends($uid) {
    $retarr = array();

    $results = generic_mem_cache('statscache/B' . $uid, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$uid'");
    $rowA = $results[0];

    $results = generic_mem_cache('avgstat' . $uid, 3600, "SELECT * FROM `averageStats` WHERE userid = '$uid'");
    $rowAVG = $results[0];

    $res = mysql_query("select id from users_stats where email = '$uid'");

    if(mysql_num_rows($res) > 0) {
        $row = mysql_fetch_array($res);
        $id = $row['id'];
        //$res3 = generic_mem_cache('mybingos/' . $uid, 3600, "select *, DATE_FORMAT(date, '%d-%b-%y') dt from bingos where userstatid = $id order by date desc");
        //$f=count($res3);
    }
    
    $gamescompleted = $rowA['won'] + $rowA['lost'] + $rowA['drawn'];
    $pwin=round((($rowA['won']*100)/$gamescompleted),2);
    $plost=round((($rowA['lost']*100)/$gamescompleted),2);
    
    if(!isset($rowAVG['avg_move_score'])){ $rowAVG['avg_move_score']=0;}
    if(!isset($rowAVG['avg_game_score'])){ $rowAVG['avg_game_score']=0;}
    if(!isset($rowAVG['streak'])){ $rowAVG['streak']=0;}
    //$nickname=getMultipleNickNames(array($uid));
    
    $retarr["rating"]=$rowA['rating'];
    $retarr["email"]=$rowA['email'];

    $retarr["played"]=$rowA['played'];
    $retarr["won"]=$rowA['won'];
    $retarr["lost"]=$rowA['lost'];
    $retarr["drawn"]=$rowA['drawn'];
    $retarr["avg_move_score"]=$rowAVG['avg_move_score'];
    $retarr["avg_game_score"]=$rowAVG['avg_game_score'];
    $retarr["streak"]=$rowAVG['streak'];
    $retarr["bingos"]=$f;
    $retarr["pwin"]=$pwin;
    $retarr["plost"]=$plost;
    return $retarr;
}


function get_myfriendslist($farray) {
		$nick_Pic = array();
		$retarr = array();
		$$results = array();
			foreach($farray as $fids)
				{
				    if(!isset($uid)){ $uid = $fids['uid'];}
				    else { $uid.=",".$fids['uid']; }
				    $first = str_replace($toreplace, '', $fids['first_name']);
	            		    $last = str_replace($toreplace, '', $fids['last_name']);
	            		    //$nickname=$first . " " . $last{0};
	            		    $nickname=$first . " " . mb_substr($last, 0, 1, 'UTF-8');
	            		    $nick_Pic[]=array("email"=>$fids['uid'],"pic_id"=>$fids['pic_square'],"nickname"=>$nickname);
	            		 } 
						 $results_stats_raw = mysql_query("SELECT * FROM users_stats as us WHERE us.email in(".$uid.")");


						             $records_sta = array();
						            if(mysql_num_rows($results_stats_raw) > 0) {
						                while ($record_sta = mysql_fetch_array($results_stats_raw) ) {
						                $results_stats[] = $record_sta;
						                }
						            }


						         $results_avs_raw = mysql_query("SELECT * FROM averageStats WHERE userid in(".$uid.")");

						             $records_avs = array();
						             if(mysql_num_rows($results_avs_raw) > 0) {
						                while ($record_avs = mysql_fetch_array($results_avs_raw) ) {
						                $results_avs[] = $record_avs;
						                }
						            }				    		 
		 				//$results_stats = generic_mem_cache('statscache/B' . $me['id'], 3600,"SELECT * FROM users_stats as us WHERE us.email in (".$uid.")");
		 				//$results_avs = generic_mem_cache('avgstat' . $me['id'], 3600,"SELECT * FROM averageStats WHERE userid in (".$uid.")");
		 
  					for($i=0;$i<count($results_stats);$i++)	{
 						$avg_move_score = 0;
 						$avg_game_score = 0;
 						$streak = 0;
						for($j=0;$j<count($results_avs);$j++) {
							if($results_stats[$i]['email']==$results_avs[$j]['userid']){
								$avg_move_score = $results_avs[$j]['avg_move_score'];
								$avg_game_score = $results_avs[$j]['avg_game_score'];
								$streak = $results_avs[$j]['streak'];
								break;
									
							}	
						}
						
						$results[] = array("rating"=>$results_stats[$i]['rating'],"email"=>$results_stats[$i]['email'],"played"=>$results_stats[$i]['played'],
								   "won"=>$results_stats[$i]['won'],"lost"=>$results_stats[$i]['lost'],"lost"=>$results_stats[$i]['lost'],"drawn"=>$results_stats[$i]['drawn'],
								    "avg_move_score"=>$avg_move_score,"avg_game_score"=>$avg_game_score,"streak"=>$streak);
					
					}					
 
 		   
		    for($i=0;$i<count($nick_Pic);$i++){
		    	for($j=0;$j<count($results);$j++){   	
			    	if($results[$j]['email']==$nick_Pic[$i]['email']){ 
			    		$res = $results[$j]['won']+$results[$j]['lost']+$results[$j]['drawn'];
			    		if(!isset($res)||($res == 0)){ $pwin = 0; $plost = 0; $drawn = 0; } 
			    		else {
				    		$pwin = round((($results[$j]['won']/$res)*100),2);
				    		$plost = round((($results[$j]['lost']/$res)*100),2);
				    		$drawn = $results[$j]['drawn'];
				    	}
			    			$retarr[] = array("rating"=>$results[$j]['rating'],"email"=>$results[$j]['email'],
			    					  "played"=>$results[$j]['played'],"won"=>$results[$j]['won'],
			    					  "lost"=>$results[$j]['lost'],"drawn"=>$drawn,"bingoes"=>0,
			    					  "avg_move_score"=>$results[$j]['avg_move_score'],"avg_game_score"=>$results[$j]['avg_game_score'],"streak"=>$results[$j]['streak'],
			    					  "pwin"=>$pwin,"plost"=>$plost, "pic_id"=>$nick_Pic[$i]['pic_id'],"nickname"=>$nick_Pic[$i]['nickname']);
			    		break;
			    	}
		    	}
    	
   		 }
    return $retarr;
}



function get_friendList($rubm){
	$i=0;
	$str2=array();
	$str2=$rubm;
	$friends='';
	foreach($str2 as $str3)
	{
            $str1=$str3;
            $i++;
            $br=$str1['email'];
            if(!isset($str1['avg_move_score'])){ $str1['avg_move_score']=0;}
            if(!isset($str1['avg_game_score'])){ $str1['avg_game_score']=0;}
            if(!isset($str1['streak'])){ $str1['streak']=0;}
			if(!isset($str1['played'])){ $str1['played']=0;}
			if(!isset($str1['won'])){ $str1['won']=0;}
			if(!isset($str1['lost'])){ $str1['lost']=0;}
			if(!isset($str1['drawn'])){ $str1['drawn']=0;}
			if(!isset($str1['bingos'])){ $str1['bingos']=0;}
			if(!isset($str1['pwin'])){ $str1['pwin']=0;}
			if(!isset($str1['plost'])){ $str1['plost']=0;}
			if($str1['rating']==0){$str1['rating']=1200;}
                    $friends.="<div class=\"user_details\">";
                    $friends.="<a href=\"".FB_APP_PATH."?action=profile&profileid=".$br."\" class=\"stats_user_photo\" target=\"_top\"><img src=\"{$str1['pic_id']}\" width=\"40\" height=\"40\" /></a>";
                            $friends.="<a href=\"".FB_APP_PATH."?action=profile&profileid=".$br."\" class=\"stats_user_name text_blue2_11\" target=\"_top\">".$str1['nickname']."</a><br />";
                            $friends.="<div class=\"user_rank_frnd\">";
                                    $friends.="<span class=\"text_grey4_11\">".$str1['rating']."</span><br />";
                                    $friends.="<a href=\"".FB_APP_PATH."?action=startnewgame&with=".$br."\" class=\"frnd_stats_play_btn\" target=\"_top\"></a>";
                            $friends.="</div>";
                            $friends.="<div class=\"frnd_stats_details\">";
                                    $friends.="<ul>";
                                            $friends.="<li id=\"r{$i}c1\">".$str1['played']."</li>";
                                            $friends.="<li id=\"r{$i}c2\">".$str1['won']."</li>";
                                            $friends.="<li id=\"r{$i}c3\">".$str1['lost']."</li>";
                                            $friends.="<li id=\"r{$i}c4\">".$str1['drawn']."</li>";
                                            $friends.="<li id=\"r{$i}c5\">".$str1['bingos']."</li>";
                                            $friends.="<li id=\"r{$i}c6\" style=\"width:70px;\">".$str1['avg_move_score']."</li>";
                                            $friends.="<li id=\"r{$i}c7\" style=\"width:70px;\">".$str1['avg_game_score']."</li>";
                                            $friends.="<li id=\"r{$i}c8\">".$str1['pwin']."</li>";
                                            $friends.="<li id=\"r{$i}c9\">".$str1['plost']."</li>";
                                            $friends.="<li id=\"r{$i}c10\">".$str1['streak']."</li>";
                                            $friends.="<li class=\"clr\"></li>";
                                    $friends.="</ul>";
                            $friends.="</div>";
                            $friends.="<div class=\"clr\"></div>";
                    $friends.="</div>";


	}

	return $friends;
} 


function getUserInfo($uid,$fields) {
    global $facebook;
    $fql = "select $fields from user where uid in ('$uid')"; 
    $param  =   array(
		'method'     => 'fql.query',
		'query'     => $fql,
		'callback'    => ''
    ); 
    	$perms   =   $facebook->api($param);
    return $perms ;
}


function set_user_advt_source($user,$advert)
{
		return;
		
	if(!$user)
		return;
	
	if($_COOKIE['user_source']) {
		setcookie("user_source",$_COOKIE['user_source'],time()+60*60*24*30);
		return;
	}
	
	if($advert) {
		$rs = mysql_query("INSERT INTO `campaign_result` set `userid`= '$user' , `source` = '$advert'");
		setcookie("user_source",$advert,time()+60*60*24*30);	
	}
	else {
		if(($_COOKIE['user_source']=='') || (!$_COOKIE['user_source']) ){
			$rs = mysql_query("SELECT `source` FROM `campaign_result` WHERE `userid` = '$user'");
			$row = mysql_fetch_array($rs);
			if($row['source'])
				setcookie("user_source",$row['source'],time()+60*60*24*30);
			else 
				setcookie("user_source",'',time()+60*60*24*30);
		}
		else {
            setcookie("user_source",$_COOKIE['user_source'],time()+60*60*24*30);

		}
	}
}

//-----added on 11_7_12-----#1142(3)---------//
/*closed on 10_8_12
function countBingos($uid) {	
	$cnt = 0;
	$sql2008 = "SELECT count(*) cnt FROM `bingos2008` WHERE userstatid = '$uid'";
	$res2008 = mysql_query($sql2008);
	$result2008 = mysql_fetch_array($res2008);
	$cnt = $cnt+$result2008['cnt'];
	$sql2009 = "SELECT count(*) cnt FROM `bingos2009` WHERE userstatid = '$uid'";
	$res2009 = mysql_query($sql2009);
	$result2009 = mysql_fetch_array($res2009);
	$cnt = $cnt+$result2009['cnt'];
	$sql2010 = "SELECT count(*) cnt FROM `bingos2010` WHERE userstatid = '$uid'";
	$res2010 = mysql_query($sql2010);
	$result2010 = mysql_fetch_array($res2010);
	$cnt = $cnt+$result2010['cnt'];
	$sql2011 = "SELECT count(*) cnt FROM `bingos2011` WHERE userstatid = '$uid'";
	$res2011 = mysql_query($sql2011);
	$result2011 = mysql_fetch_array($res2011);
	$cnt = $cnt+$result2011['cnt'];
	$sql2012 = "SELECT count(*) cnt FROM `bingos` WHERE userstatid = '$uid'";
	$res2012 = mysql_query($sql2012);
	$result2012 = mysql_fetch_array($res2012);
	$cnt = $cnt+$result2012['cnt'];
		
	return $cnt;
}
*/
//added on 10_8_12
function countBingos($uid) {
	$cnt = 0;
	$month_arr = array('01' => "January", '02' => "February", '03' => "March", '04' => "April", '05' => "May", '06' => "June", '07' => "July", '08' => "August", '09' => "September", '10' => "October", '11' => "November", '12' => "December");
	$year_arr = array ('08' => "2008", '09' => "2009", '10' => "2010", '11' => "2011", '12' => "2012");
	foreach($year_arr as $key_yr => $val_yr){
			foreach($month_arr as $key_mn => $val_mn){
				$sql = "SELECT count(*) cnt FROM `bingos{$key_mn}{$key_yr}` WHERE userstatid = '$uid'";
				$res = mysql_query($sql);
				$result = mysql_fetch_array($res);
				$cnt = $cnt+$result['cnt'];
			}
	}
	return $cnt;
}

//--------ADDED ON 11_7_12 #1142(3)-----------//
function userBingoCount($uid){
	$query = "SELECT * FROM bingo_count WHERE uid='{$uid}'";
	$res = mysql_query($query);
	$result = mysql_fetch_array($res);
	if (mysql_num_rows($res)>0){	/////already entry in new table bingoCount
			$cnt =  $result['totalbingo'];
	}else{	////data not present in the table bingoCount at all
		$cnt = 0;
	}
	return $cnt;
}

//-----------added on 2_8_12
function total_finishedGamesDetails($email_id){
	
	$gamestable = "games_over";
	$userstable = "users_over";
	$sql = "SELECT  finishedon, winner, language, player_id, games_over.game_id, password, game_type  FROM users_over, games_over WHERE users_over.game_id = games_over.game_id and users_over.email='$email_id' order by games_over.finishedon desc";
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	$returnArr = array();
	if($cnt > 0) {
		while($row = mysql_fetch_array($result))
		{
			$result1 = generic_mem_cache("pca" . $row['game_id'], 3600, "select id, player_id, nickname, email, password from $userstable where game_id = " . $row['game_id']);
			$players_details = array();
			foreach ($result1 as $id=> $playrow)
			{			
				//print_r ($playrow);print"<br>";				
				if($row['winner'] == $playrow['player_id']) {
					if($playrow['email'] == $email_id)					
						$winner_id = $email_id;
					else
						$winner_id = $playrow['email'];
				} else if($row['winner'] == -1) {
						//$wonby = "<b>Game Drawn</b>";
				}
								
				$players_details[] = $playrow['email'].','.$playrow['nickname'].','.$playrow['password'];
																					
			}
			$players_details_str = implode($players_details,"|");		
			$returnArr[] = array('gid'=>$row['game_id'],'winuid'=>$winner_id,'players'=>$players_details_str,'date'=>strtotime($row['finishedon']),'gtype'=>$row['game_type'],'lang'=>$row['language']);								
		}
		//print_r ($returnArr);exit;
		return $returnArr;
	}
}
//-------------added on 2_8_12




//----------------added on 3_8_12 for completed games
function get_archive_games_monthwise($user,$month_val,$year_val,$profile=false) {
	
	$returnArr = array();
	$archive_file_arr = array();	
	$archive_file_arr = total_finishedGamesDetails_monthwise($user,$month_val,$year_val);

	if(count($archive_file_arr) > 0){
		foreach($archive_file_arr as $key=>$gamedetails) {
			$ownpid = $ownpassword = $status = $playerlist = $rematchlist = "";         
			$players = explode("|",$gamedetails['players']);
			
			$pindex = 1;
			$opp_list="";
			foreach ($players as $player_list){
				$plr_arr2 = explode(",",$player_list);				
				if($plr_arr2[0]!=$user){
					$opp_list.=$plr_arr2[1].",";
				}
				
			}
			$rest = substr($opp_list, 0, -1);		
			foreach($players as $plr) {
				$plr_arr = explode(",",$plr);
				if($plr_arr[0] != $user) {
					$playerlist .= "<a href=\"".FB_APP_PATH."?action=profile&profileid={$plr_arr[0]}\" target=\"_top\" class=\"text_blue_12\">{$plr_arr[1]}</a>, ";
					$rematchlist .= $plr_arr[0] . ",";
				} else {
					$ownpid      = $pindex;
					$ownpassword = $plr_arr[2];
				}
				if($gamedetails['winuid'] == $plr_arr[0]) { 
					if($plr_arr[0] == $user) {
						$status = "<b>Won by {$plr_arr[1]}</b>";
						$my_name=getNickName($user);
						$winstatus="&nbsp;&nbsp;&nbsp;<a href='#' class=\"text_blue_12\"  onclick='gameoverArchivePublish(\"$my_name\",\"$rest\",4,5,6,7);'>Share My Victory!</a>";	
					} else {
						$status = "Won by {$plr_arr[1]}";
						$winstatus="";
					}
				}
				$pindex++;
			}
			
			if($gamedetails['winuid'] == -1) { $status = "Game Drawn"; }
			
			if($profile) {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$gamedetails['gid']}&pid={$ownpid}&password={$ownpassword}&gametype={$gamedetails['gtype']}&lang=" . strtoupper($gamedetails['lang']);
				$rematchlink = "<a href=\"".FB_APP_PATH."?action=newgame&with=".substr($rematchlist,0,-1)."&name=$rest&rematch=1\" class=\"text_blue_12\" target=\"_top\">Rematch?</a>";///////changed on 16_7_12 &name=$rest&rematch=1 added #1142(4) 
			} else {
				$link = FB_APP_PATH . "?action=viewboard&showGameOver=1&gid={$gamedetails['gid']}&gametype={$gamedetails['gtype']}&lang=" . strtoupper($gamedetails['lang']);
				$rematchlink = "";
			}
						
			$gametypeStr = "";
			if($orderby == 6 || $orderby == 7) $gametypeStr = "[{$gamedetails['gtype']}]";
			
		
			$l='<div style="margin:9px 0px 0 0;"><img src="'.APP_IMG_URL.'grey_ball.png" style="margin:3px 5px 0 0;float:left;" alt=""/>';
			$returnArr[]= "<div class=\"text_grey3_12 \"><span class=\"text_grey3_12\">{$l}<a href=\"$link\" class=\"text_grey_12\" target=\"_top\"><u>{$gamedetails['gid']}</u></a></span> - ".substr($playerlist,0,-2) ." - ". $status ." finished on ".date("d-M-y",$gamedetails['date']) .$winstatus. "&nbsp;&nbsp;&nbsp;$rematchlink</div>".
						  "<div style=\"clear:both;\"></div></div>";
		}
	}
	
	return $returnArr;
}

function total_finishedGamesDetails_monthwise($email_id,$month,$year){
  
  $current_month = date("m"); 
  $current_year = date("y");
  // if(($current_month == $month) &&($current_year == $year)){      //comment by mayur
    $gamestable = "games_over";
    $userstable = "users_over";
  // } else {  //comment by mayur
  //  $gamestable = "games_over_".$month.$year;    //comment by mayur
  //  $userstable = "users_over_".$month.$year;    //comment by mayur
  // }   //comment by mayur


  //$gamestable = "games_over".$month.$year;
  //$userstable = "users_over";
  
  $sql = "SELECT  finishedon, winner, language, player_id, {$gamestable}.game_id, password, game_type  FROM {$userstable}, {$gamestable} WHERE {$userstable}.game_id = {$gamestable}.game_id and {$userstable}.email='$email_id' and `finishedon`>=DATE_SUB(NOW(), INTERVAL 1 MONTH) order by {$gamestable}.startedon desc";
  //$sql = "SELECT  finishedon, winner, language, player_id, games_over.game_id, password, game_type  FROM users_over, games_over WHERE users_over.game_id = games_over.game_id and users_over.email='$email_id' order by games_over.finishedon desc";
  $result = mysql_query($sql);
  $cnt = mysql_num_rows($result);
  $returnArr = array();
  if($cnt > 0) {
    while($row = mysql_fetch_array($result))
    {
      // echo $row['game_id'] . "<br>";
      $result1 = generic_mem_cache("pca" . $row['game_id'], 3600, "select id, player_id, nickname, email, password from $userstable where game_id = " . $row['game_id']);
      $players_details = array();
      foreach ($result1 as $id=> $playrow)
      {     
        //print_r ($playrow);print"<br>";       
        if($row['winner'] == $playrow['player_id']) {
          if($playrow['email'] == $email_id)          
            $winner_id = $email_id;
          else
            $winner_id = $playrow['email'];
        } else if($row['winner'] == -1) {
            //$wonby = "<b>Game Drawn</b>";
            $winner_id = -1;
        }
                
        $players_details[] = $playrow['email'].','.$playrow['nickname'].','.$playrow['password'];
                                          
      }
      $players_details_str = implode($players_details,"|");   
      $returnArr[] = array('gid'=>$row['game_id'],'winuid'=>$winner_id,'players'=>$players_details_str,'date'=>strtotime($row['finishedon']),'startedon'=>strtotime($row['startedon']),'gtype'=>$row['game_type'],'lang'=>$row['language']);                
    }

    $previous_month = date("m",strtotime("-1 month"));

    if($previous_month!=$current_month){
    // if(true){
      $timestamp = strtotime("now -1 month");
      $month = $previous_month;
      $year = date('y',$timestamp);

      $gamestable = "games_over_".$month.$year;
      $userstable = "users_over_".$month.$year;
      $sql2 = "SELECT  finishedon, winner, language, player_id, {$gamestable}.game_id, password, game_type  FROM {$userstable}, {$gamestable} WHERE {$userstable}.game_id = {$gamestable}.game_id and {$userstable}.email='$email_id' and `finishedon`>=DATE_SUB(NOW(), INTERVAL 1 MONTH) order by {$gamestable}.startedon desc";
      $result2 = mysql_query($sql2);
      $cnt2 = mysql_num_rows($result2);
      if($cnt2 > 0) {
        while($row2 = mysql_fetch_array($result2))
        {
          $result3 = generic_mem_cache("pca" . $row2['game_id'], 3600, "select id, player_id, nickname, email, password from $userstable where game_id = " . $row2['game_id']);
          $players_details = array();
          foreach ($result3 as $id2=> $playrow2)
          {     
            if($row2['winner'] == $playrow2['player_id']) {
              if($playrow2['email'] == $email_id)          
                $winner_id = $email_id;
              else
                $winner_id = $playrow2['email'];
            } else if($row2['winner'] == -1) {
                $winner_id = -1;
            }
                    
            $players_details[] = $playrow2['email'].','.$playrow2['nickname'].','.$playrow2['password'];
                                              
          }
          $players_details_str2 = implode($players_details,"|");   
          $returnArr[] = array('gid'=>$row2['game_id'],'winuid'=>$winner_id,'players'=>$players_details_str2,'date'=>strtotime($row2['finishedon']),'startedon'=>strtotime($row2['startedon']),'gtype'=>$row2['game_type'],'lang'=>$row2['language']);                
        }
      }

    }
    // echo json_encode($returnArr);exit;
    return $returnArr;
  }
}

//-----added on 3_8_12--End----

//added on 10_8_12
function getTotalBingoList($user){
		return;
		$month_arr = array('01' => "January", '02' => "February", '03' => "March", '04' => "April", '05' => "May", '06' => "June", '07' => "July", '08' => "August", '09' => "September", '10' => "October", '11' => "November", '12' => "December");
		$year_arr = array ('08' => "2008", '09' => "2009", '10' => "2010", '11' => "2011", '12' => "2012");
		$bingo_tables = array();
		foreach($year_arr as $key_yr => $val_yr){
			foreach($month_arr as $key_mn => $val_mn){
				$sqlBingo = "select * from bingos{$key_mn}{$key_yr} where userstatid = $user order by score desc limit 0, 100";
				//print "<br>";
				$resBingo = mysql_query($sqlBingo);
				if (mysql_num_rows($resBingo)> 0){			
					while ($rowBingo = mysql_fetch_array($resBingo)){
						$bingosTotal[] = $rowBingo;
					}
				}		
			}
		}
	
		$sqlBingo_new = "select * from bingos where userstatid = $user order by score desc limit 0, 100";
		$resbingos_new = mysql_query($sqlBingo_new);
		if (mysql_num_rows($resbingos_new)>0){
			while ($rowbingos_new = mysql_fetch_array($resbingos_new)){
				$bingosTotal[] = $rowbingos_new;
			}
		}
		//print_r ($bingosTotal);exit;
		$scoreVal = array();
		foreach ($bingosTotal as $key => $row){
	    	$scoreVal[$key] = $row['score'];
		}
		array_multisort($scoreVal, SORT_DESC, $bingosTotal);
		$allBingos = array_slice($bingosTotal, 0, 100);
		//print_r ($allBingos);exit;
		return $allBingos;
		
}

//added on 16-10-12 #1999
function getMyBingo($user,$post,$month=null,$year=null){
		
	$Mybingos=array();
	$link2 = '';
	
	if($post){
			if($month==date('m') && $year==date('y')){
				$sqlMybingo="SELECT * FROM bingos WHERE userstatid=$user ORDER BY date DESC"; //fetching data from bingos table
				$resMybingo=mysql_query($sqlMybingo);	
				$link2 = 0;
			}else{
				
				$dbhost2	= "rjsfblexulous.covkvcuw8yle.us-east-1.rds.amazonaws.com";
				$link2 = mysql_connect($dbhost2, "", "");
				if(!$link2) die("Could not connect to Server");
				$db=mysql_select_db("",$link2) or die("fail");
				
				$sqlMybingo="SELECT * FROM bingos{$month}{$year} WHERE userstatid=$user ORDER BY date DESC"; //fetching data from corresponding bingo table
				$resMybingo=mysql_query($sqlMybingo, $link2);
				
			}
		
			if(mysql_num_rows($resMybingo)>0){
			while($rowMybingo=mysql_fetch_array($resMybingo)){
					$Mybingos[]=$rowMybingo;	
				}
			}
			if($link2 != 0) {
				mysql_close($link2);
			}		
		}else{
			
		$sqlMybingo="SELECT * FROM bingos WHERE userstatid=$user ORDER BY date DESC"; //fetching data from bingo table
		$resMybingo=mysql_query($sqlMybingo);	
				
			if(mysql_num_rows($resMybingo)>0){
			while($rowMybingo=mysql_fetch_array($resMybingo)){
					$Mybingos[]=$rowMybingo;	
				}			
		}			
	}
	return $Mybingos;
}




//***************For new layoyt   *************//
//*********************************************//
//-------#2481

/*************ADDED FOR NEW LAYOUT************/

///////////ADDED ON 9_12_11/////////////////
function get_totalgames_list($email_id) {
	
	global $currentGamesList;
	$res = generic_mem_cache("glist" . $email_id, 900, "select games from users_games where email = '{$email_id}'");
	foreach($res as $id=>$playrow) {
		$currentGamesList = $playrow['games'];
	}
	
	// remove leading, trailing commas
	$currentGamesList = substr($currentGamesList, 1, -1);

	if(strlen($email_id) < 1) return;
	if(!strpos($email_id, "@")) $fb = "y";
	
	$cutoffdate = mktime(0, 0, 0, date("m")-3, date("d"),   date("Y"));
	$cutoffdate = date("Y-m-d", $cutoffdate);
	
	//$sql = "SELECT dictionary, language, current_move, game_id, game_type, lastupdate, users_info,lastmove FROM games WHERE games.game_id in ( $currentGamesList ) and  now() < games.expirydatetime  order by lastupdate desc ";
	$sql = "SELECT dictionary, language, current_move, game_id, game_type, lastupdate, users_info,lastmove,players_no FROM games WHERE games.game_id in ( $currentGamesList ) AND expirydatetime > '$cutoffdate 00:00:00' order by lastupdate desc ";///#players_no added #3105
	$result = mysql_query($sql);
	$cnt = mysql_num_rows($result);
	$games_arr = array();
	$each_game_arr = array();
	$last_update_arr = array();
	$tiles_left_arr = array();
	if($cnt > 0) {
		while($row=mysql_fetch_assoc($result)){
			$games_arr[]=$row;
			$last_update_arr[$row['game_id']] = strtotime($row['lastupdate']);
			$tiles_left_arr[$row['dictionary']][] = $row['game_id'];
		}
		$lastupdateArr = time_diff($last_update_arr);		
		$tilesLeftArr = get_tiles_left($tiles_left_arr);	 
		
		foreach ($games_arr as $key=>$val){		
				if ($val['current_move'] !=0){	
				$array_userinfo_pi_explode = explode("|", $val['users_info']);
					
				$uid_arr = array();
				$password_arr= array();
				$nickname_arr = array();
				
				foreach ($array_userinfo_pi_explode as $key1=>$val1){								
					$arr_explode_comma = explode(",", $val1);	
										
					$uid_arr[] = $arr_explode_comma[0];
					$password_arr[] = $arr_explode_comma[1];
					$nickname_arr[] = $arr_explode_comma[2];
					$resign_option = $arr_explode_comma[3];
					
					if ($arr_explode_comma[0] == $email_id){				
						$my_pid = $key1 + 1;
						$my_password = $arr_explode_comma[1];
						$opp_arr_index = ($key1+1)%(count($array_userinfo_pi_explode));
						$opp_info_arr = $array_userinfo_pi_explode[$opp_arr_index];
						$opp_name_id_arr = explode(",",$opp_info_arr);
					} 
				}

				$lastmovendscorearr = explode("," ,$val['lastmove']);	
				$lastword = $lastmovendscorearr[0];
				$lastwordscore = ($lastmovendscorearr[1]!=''?" ({$lastmovendscorearr[1]})":'');	
				$lastwordndscorestr = $lastword.$lastwordscore;		
				
				/*  Added On 30_3_12 */
				/*
				if (($my_pid != $val['current_move']) && ($val['current_move'] != 0)){		////If it is not my turn
					if ((time() - strtotime($val['lastupdate']))>(14*60)){//////At least 14 days to wait
							if ($val['language'] == 'en'){
								$tmp_table = "tmp_games_fre_tiles";
							}else{
								$tmp_table = "tmp_games_fre_tiles_".$val['language'];
							}
							$sql_tmp_table = "SELECT p1score,p2score,p3score,p4score FROM $tmp_table WHERE gameid={$val['game_id']}";						
							$sql_tmp_table_result = mysql_query($sql_tmp_table);
							$sql_tmp_table_result_set = mysql_fetch_assoc($sql_tmp_table_result);
							$my_hand = "p".$my_pid."score";
							$currentPlayer_hand = "p".$val['current_move']."score";																		
							$my_score = $sql_tmp_table_result_set[$my_hand];
							$currentPlayer_score = $sql_tmp_table_result_set[$currentPlayer_hand];
							//echo "--$my_score--$currentPlayer_score-----";
							if ($my_score >= $currentPlayer_score){
								///force win
								do_forcewin($val['game_id'],$my_pid,$my_password,$email_id);
								continue;
							}else {
								if ((time() - strtotime($val['lastupdate']))>(21*60)){///////wait for 21 days if my score is less than current player
									////force win
									do_forcewin($val['game_id'],$my_pid,$my_password,$email_id);
									continue;
								}
							}
					}
				}
				*/
				/*  **End**  */
								
				$each_game_arr[] = array("dictionary"=>$val['dictionary'],
										"language"=>$val['language'],
										"current_move"=>$val['current_move'],
										"game_id"=>$val['game_id'],
										"game_type"=>$val['game_type'],
										"pid"=>$my_pid,									
										"password"=>$my_password,
										"last_update"=>$lastupdateArr[$val['game_id']],
										"tiles_inbag"=>$tilesLeftArr[$val['game_id']],
										"last_update_time"=>strtotime($val['lastupdate']),
										"last_word"=>$lastwordndscorestr,										
										"total_players"=>$val['players_no'],///#3105
										"opp_id"=>$opp_name_id_arr[0],									
										"uid_arr"=>$uid_arr,
										"password_arr"=>$password_arr,
										"nickname_arr"=>$nickname_arr,
										"opp_name"=>$opp_name_id_arr[2]
				);		
			}
		}
	}	
	$arr_return = array("count"=>$cnt,"result"=>$each_game_arr);	
	return $arr_return;
}

function get_tiles_left($game_dic_arr){
	$game_str = '';
	$tiles_str = '';
	$dictionary_game_array = array();
	$return_arr = array();
	for ($i=97;$i<=122;$i++){
		$tiles_str.= 'tile_'.chr($i).',';
	}
	$tiles_str = $tiles_str.'tile_blank';
	
	$dictionary_game_array['en'] = array_merge((array)$game_dic_arr['sow'], (array)$game_dic_arr['twl']);
	$dictionary_game_array['fr'] = $game_dic_arr['fr'];
	$dictionary_game_array['it'] = $game_dic_arr['it'];
	foreach ($dictionary_game_array as $key=>$value){
		if(($value) && ($value!='')) {
			$game_str = implode(",", $value);
			if ($key == 'en'){
				$sql = "SELECT gameid,{$tiles_str},p1hand,p2hand,p3hand,p4hand FROM tmp_games_fre_tiles WHERE gameid IN ({$game_str})";
			}else{
				$sql = "SELECT gameid,{$tiles_str},p1hand,p2hand,p3hand,p4hand FROM tmp_games_fre_tiles_".$key." WHERE gameid IN ({$game_str})";
			}
			$res = mysql_query($sql);
			$cnt = mysql_num_rows($res);
			if ($cnt>0){
				while($row = mysql_fetch_assoc($res)){
					$game_id = $row['gameid'];
					unset($row['gameid']);
					$tiles_left = array_sum($row);
					$return_arr[$game_id] = $tiles_left;
				}
			}					
		}
	}
	return $return_arr;
}


/*  Added On 2_4_12 For Force win issue */
function do_forcewin($gid,$pid,$password,$user){

if ($user == '563981417') {
        $allowforce = 1;
    } else if ($_COOKIE['forcedwintoday']) {
        // see what is current status
        $forced = split(',', $_COOKIE['forcedwintoday']);
        if ($forced[0] == 3)
            $action = '';
        else {
            $forced[0]++;
            setcookie('forcedwintoday', join(',', $forced), $forced[1]);
            $allowforce = 1;
        }
    } else {
        $forced = array();
        $forced[0] = 1;
        $forced[1] = time() + (3600 * 24);
        setcookie('forcedwintoday', join(',', $forced), $forced[1]);
        $allowforce = 1;
    }
$allowforce = 1;////ADDED FOR TESTING To DISABLE COOKIE['forcedwintoday']
    if ($allowforce == 1) {   
	    	       
        include_once ("resign_functions.php");
      $message = startResign($gid, $pid, $password);
    }
}
/***  End  ***/


 function time_diff($time_stamp){
		if(count($time_stamp)){
			foreach ($time_stamp as $key=>$value){
				//for decade
				$timeDiff = abs(time() - abs($value));
				$val = "";
				if(($timeDiff/(60*60*24*365*10))>=1){ 
					$val .= round(abs($timeDiff/(60*60*24*365*10)))."d ";
				}
				//for year
				elseif (($timeDiff/(60*60*24*365))>=1){
					$val .= round(abs($timeDiff/(60*60*24*365)))."y ";
				}
				//for day
				elseif (($timeDiff/(60*60*24))>=1){
					$val .= round(abs($timeDiff/(60*60*24)))."d ";
				}
				//for min
				elseif (($timeDiff/(60*60))>=1){
					$val .= round(abs($timeDiff/(60*60)))."h ";
				}
				else{
					$val .= round(abs($timeDiff/60))."m ";
				}
				$returnArr[$key]=$val."ago";
			}
		}
		return $returnArr;
	}

	function get_totalarchive_games($email_id) {
	
	$currentmonth = date("m");	
	$currentyear = date("y");
	$table_list_arr = array();
	$retrnArr = array();
	$table_list_arr["users_over"] = "games_over";
	for($i=1;$i<=2;$i++){
		$previous_mn = $currentmonth - $i;
		$game_year = $currentyear;
		if($previous_mn == 0){
			$previous_mn = 12;
			$game_year = $currentyear - 1;
		}else if($previous_mn < 0){
			$previous_mn = 12 + $previous_mn;
			$game_year = $currentyear - 1;
		}
		$previous_mn = strlen($previous_mn)==2?$previous_mn:"0".$previous_mn;
		$table_list_arr['users_over_'.$previous_mn.$game_year] = "games_over_".($previous_mn).($game_year);
	}
	
	$returnArr = array();
	foreach($table_list_arr as $k1 => $v1){
		if(count($retrnArr) > 4)
			break;
		
		$sql = "SELECT  startedon, finishedon, winner, players_no, language, player_id, {$v1}.game_id, password, game_type  FROM {$k1}, {$v1} WHERE {$k1}.game_id = {$v1}.game_id and {$k1}.email='$email_id' order by {$v1}.finishedon desc";
		
		$result = mysql_query($sql);
		$cnt = mysql_num_rows($result);
		
		if($cnt > 0) {
			while($row = mysql_fetch_array($result))
			{
				$players_list = "";$opp_ids = "";
				$sql2 = "select id, player_id, nickname, email, password from $k1 where game_id = " . $row['game_id'];
				$res2 = mysql_query($sql2);
				$result1 = array();
				while ($row2 = mysql_fetch_assoc($res2)){
						$result1[] = $row2;
				}
				
				foreach ($result1 as $key=>$val){
					if ($row['winner'] != -1){
						if ($val['player_id']==$row['winner']){
							if ($val['email']==$email_id){
								$winner = "me";							
							}else{
								$winner = $val['nickname'];
							}
						}
					}else {
						$winner = "drawn";
					}
					

					if ($val['email']!=$email_id){
						$players_list.= $val['nickname'].",";
						$opp_ids.=$val['email'].",";
					}else if ($val['email']==$email_id){	
						$my_pid = $val['player_id'];
						$my_password = $val['password'];	
						$my_name = 	$val['nickname'];							
						$opp_name_index = ($key+1)%($row['players_no']);
						$opp_name = $result1[$opp_name_index]['nickname'];
						$opp_uid = $result1[$opp_name_index]['email'];
											
					}									
				}		
				$winner_index = $row['winner']-1;
				$winner_name = $result1[$winner_index]['nickname'];
				$winner_id = $result1[$winner_index]['email'];
				if($row[language] == "en")
					$tmp_games_fre_tiles_over_table = "tmp_games_fre_tiles_over";
				else
					$tmp_games_fre_tiles_over_table = "tmp_games_fre_tiles_".$row[language]."_over";
				
				$sql_tiles = "SELECT p1score,p2score,p3score,p4score FROM `{$tmp_games_fre_tiles_over_table}` WHERE gameid={$row['game_id']}";
				$res_tiles = mysql_query($sql_tiles);
				$result_tiles = mysql_fetch_assoc($res_tiles);
				$score_array = $output = array_slice($result_tiles, 0, $row['players_no']);	
							
				$retrnArr[] = array("game_id"=>$row['game_id'],
											"winStatus"=>$winner,											
											"pid_over"=>$my_pid,
											"password_over"=>$my_password,											
											"user_nickname"=>$my_name,										
											"opp_id"=>$opp_uid,
											"opp_name"=>$opp_name,
											"finishedon"=>strtotime($row['finishedon']),
											"startedon"=>strtotime($row['startedon']),
											"winner_name"=>$winner_name,
											"winner_id"=>$winner_id,
											"game_type"=>$row['game_type'],
											"lang"=>strtoupper($row['language']),
											"scores"=>$score_array,
											"total_players"=>$row['players_no'],
											"opp_namelist"=>substr($players_list,0,-1),
											"opp_uidlist"=>substr($opp_ids,0,-1),											
											"winner_score"=>max($score_array),	
											"loser_score"=>min($score_array),																																	
										    "pic"=>"");				
				if(count($retrnArr) > 4)
					break;								
			}			
		}
	}
	return $retrnArr;
	}
	


function appfriendCount(){
 	global $facebook;
		if (!(isset($_COOKIE["friendCountCookie"]))){
				$fql = "SELECT uid from user where uid IN (SELECT uid1 FROM friend WHERE uid2=me()) and is_app_user and uid<>me()";
				
				$param  =   array(
	       			'method'     => 'fql.query',
	        		'query'     => $fql,
	      			'callback'    => ''
				);
				$appaddedfriendsD   =   $facebook->api($param);
				$count = count($appaddedfriendsD);
				setcookie("friendCountCookie",$count, time()+60*30);
				return $count;
		}else{
				return $_COOKIE["friendCountCookie"];
		}
}

function get_nudge_option($gid){
	$sql= "select * from `nudgeinfotable` where `gameId`={$gid}";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return $row;
}

function get_onetoone_stats_new($uid, $foruid) {

	if($uid < $foruid)
		$ustr = $foruid . "-" . $uid;
	else
		$ustr = $uid . "-" . $foruid;

	$results = generic_mem_cache('L21' . $ustr, 3600, "SELECT * from h2hstats where user = '$ustr'");
	$row = $results[0];
	
	$gamescompleted = $row['won'] + $row['lost'] + $row['drawn'];

	if($uid < $foruid) {
		$gameswon = abs($row['lost']);
		$gameslost = abs($row['won']);
	} else {
		$gameswon = abs($row['won']);
		$gameslost = abs($row['lost']);
	}

	$returnArr = array("completed"=>$gamescompleted,"won"=>$gameswon,"lost"=>$gameslost,"drawn"=>abs($row['drawn']));
	return $returnArr;	
}

function get_stats_new($uid) {
    $retarr = array();

    $results = generic_mem_cache('statscache/' . $uid, 3600, "SELECT facebookusers.*, date_format(dateadded,'%d-%b-%Y') dt FROM facebookusers WHERE facebookusers.uid  = '$uid'");
    $row = $results[0];
 
    $results = generic_mem_cache('statscache/B' . $uid, 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$uid'");
    $rowA = $results[0];

    $results = generic_mem_cache('avgstat' . $uid, 3600, "SELECT * FROM `averageStats` WHERE userid = '$uid'");
    $rowAVG = $results[0];
    $results = generic_mem_cache('statscache/bingoscurrent' . $uid, 3600, "select * from bingos where userstatid = $rowA[id] order by score desc");
    $allBingos = array();
    if(count($results) > 0) {
        for($i=0;$i<count($results);$i++) {
            $allBingos[] = $results[$i];
			//if($i == 200)
			//	break;
        }
    }

    $resultsTopfifty = generic_mem_cache('topfifty/bingos' . $uid, 3600, "select date,word,score from user_top_50_bingo where userstatid = $rowA[id] order by score desc limit 0, 50");
    $TopfiftyBingos = array();
    if(count($resultsTopfifty) > 0) {
    	for($i=0;$i<count($resultsTopfifty);$i++) {
    		$TopfiftyBingos[] = $resultsTopfifty[$i];
    	}
    }
    	
    $gamescompleted = $rowA['won'] + $rowA['lost'] + $rowA['drawn'];
    $retarr['id']=$rowA['id'];
    $retarr['rating']=$rowA['rating'];
    $retarr['email']=$rowA['email'];
    $retarr['bestrating']=$rowA['bestrating'];
    $retarr['bestrating_date']=$rowA['bestrating_date'];
    $retarr['played']= $gamescompleted;
    $retarr['won']=$rowA['won'];
    $retarr['lost']=$rowA['lost'];
    $retarr['drawn']=$rowA['drawn'];
    $retarr['allbingos'] = $allBingos;
    $retarr['topfifty'] = $TopfiftyBingos;

    $retarr['avg_move_score']=$rowAVG['avg_move_score'];
    $retarr['avg_game_score']=$rowAVG['avg_game_score'];
    $retarr['streak']=$rowAVG['streak'];
    $retarr['beststreak']=$rowAVG['beststreak'];

    $GLOBALS['otherJoinDt'] = $row['dt'];

    if($row['defaultdic'] == 'sow')
        $GLOBALS['otherDefaultDic'] = 'English games based on the UK English dictionary, ';
    elseif ($row['defaultdic'] == 'twl')
        $GLOBALS['otherDefaultDic'] = 'English games based on the US English dictionary, ';
    elseif ($row['defaultdic'] == 'it')
        $GLOBALS['otherDefaultDic'] = 'Italian games, ';
    elseif ($row['defaultdic'] == 'fr')
        $GLOBALS['otherDefaultDic'] = 'French games, ';

    if($row['defaultgame'] == 'R')
        $GLOBALS['otherDefaultGame'] = 'Regular';
    else
        $GLOBALS['otherDefaultGame'] = 'Challenge';

    if($retarr['rating']==0){$retarr['rating']=1200;}
	if($retarr['bestrating']==0){$retarr['bestrating']=1200;}
      return $retarr;

}

function file_write_table_update($user,$table,$data){
	if ($table=="FBLexulousArchive"){
		$amazonDBObj = new amazonDB();
		$amazonDBObj->insertData($table,$user,$data);
	}
}


function default_page_show_request_new() {
		global $facebook;
   		$data=$facebook->api('/me/apprequests/');
   		$req_icermnt="";

   		for($i=0;$i<count($data['data']);$i++){ 
   			if($data['data'][$i]['data']){
   				$req_icermnt.=$data['data'][$i]['id'].",";
   			} else {   			  	
	   			if($list_request_ids[$data['data'][$i]['from']['id']]){
	   				$list_request_ids[$data['data'][$i]['from']['id']]=$list_request_ids[$data['data'][$i]['from']['id']].",".$data['data'][$i]['id'];	
	   			}
	   			else{
	   				$list_request_ids[$data['data'][$i]['from']['id']]=$data['data'][$i]['id'];
	   				$list_friends_name[$data['data'][$i]['from']['id']]=$data['data'][$i]['from']['name'];
	   			}
			}
   		}  
   		if(count($list_friends_name)>0){
   			$array_keys_list = array_keys($list_friends_name);
   		}  		
   		
   		
   		for($i=0;$i<count($array_keys_list);$i++){
   			
   			$friends_name_id[] = array("id"=>$array_keys_list[$i],"name"=>$list_friends_name[$array_keys_list[$i]],"request_id"=>$list_request_ids[$array_keys_list[$i]]);
   		}
   		
		if($req_icermnt)
			delete_friends_request_new(trim($req_icermnt,","));
   		
		return $friends_name_id ;
     
}
	
	
function delete_friends_request_new($id){
		global $facebook;
		$token = $facebook->getAccessToken();
    	$batched_request[] = array();
    	$array_requests = explode(",", $id);
		$count = 0;
    	foreach($array_requests as $val){
				$count++;
    	 		$batched_request[] =array("method"=>"DELETE","relative_url"=>"$val");
				if($count == 19) {
					$this->startRequest($batched_request, $token);
					$batched_request = array();
					$count = 0;
				}
    	}
		if($count > 0) {
			startRequest($batched_request, $token);
		}
}
	

function friendsCount(){
	global $facebook;
	
	$fql = "SELECT friend_count FROM user WHERE uid=me()";
				
				$param  =   array(
	       			'method'     => 'fql.query',
	        		'query'     => $fql,
	      			'callback'    => ''
				);
				$friends_count   =   $facebook->api($param);
				$count = count($friends_count);

	return $friends_count[0]['friend_count'];
}

function getMyBingo_new($user,$month,$year){
	
		
	$Mybingos=array();
	$link2 = '';
	
	if($month==date('m') && $year==date('y')){
	$sqlMybingo="SELECT *, DATE_FORMAT(`date`, '%d-%b') as dateFormatted  FROM bingos WHERE userstatid=$user"; 
		$resMybingo=mysql_query($sqlMybingo);	
		$link2 = 0;
	}else{
		$conn2 = mysql_connect("rjsfblexulous.covkvcuw8yle.us-east-1.rds.amazonaws.com", "rjsfblexulous", "iKOcyMHb");
		mysql_select_db("fblexulousbingos", $conn2);
		$sqlMybingo="SELECT *, DATE_FORMAT(`date`, '%d-%b') as dateFormatted FROM bingos{$month}{$year} WHERE userstatid=$user ORDER BY score DESC";
		$resMybingo=mysql_query($sqlMybingo,$conn2);
		mysql_close($conn2);
		}
	
		if(mysql_num_rows($resMybingo)>0){
		while($rowMybingo=mysql_fetch_array($resMybingo)){
				$Mybingos[]=$rowMybingo;	
			}
		}	
	return $Mybingos;
}


function bestBingoEver($statid){
	return;
$Score=0;
$Bingo='';
$month_arr = array ('01' => "January",'02' => "February",'03' => "March",'04' => "April",'05' => "May",'06' => "June",'07' => "July",'08' => "August",'09' => "September",'10' => "October",'11' => "November",'12' => "December");
$year_arr = array ();
for($i=2008;$i<=date('Y');$i++){
	$yrdigit=substr($i,2);
	$year_arr[$yrdigit]=$i;
	}
	
	$sqlBingos=mysql_query("SELECT score, word FROM bingos WHERE userstatid =$statid ORDER BY score DESC LIMIT 0,1");
	if(mysql_num_rows($sqlBingos)>0){
		$val= mysql_fetch_assoc($sqlBingos);
		$Bingo=$val['word'];
		$Score=$val['score'];
	}
	
	foreach($year_arr as $yr_key=>$yr_val){
			
		foreach($month_arr as $mn_key=>$mn_val){
			if($yr_val==date('Y') && $mn_key==date('m'))
				break;
				
			$sql=mysql_query("SELECT score, word FROM bingos{$mn_key}{$yr_key} WHERE userstatid =$statid ORDER BY score DESC LIMIT 0,1");
			if(mysql_num_rows($sql)>0){
				$vals= mysql_fetch_assoc($sql);
				$bestScore=$vals['score'];
				$bestBingo=$vals['word'];
				if($bestScore>$Score){
					$Bingo=$bestBingo;
					$Score=$bestScore;
				}
			}
		}
	}
	return $Bingo.','.$Score;
}


function display_opponent_badges_New($gid,$uid) {
    global $facebook;

    if(!DB::$connected) { DB::connect (); }

    $opp_result = mysql_query("select email from users where game_id = '$gid'");
    $disp_str ="";
	$js_str = "\n\n<script type=\"text/javascript\">\n";
	$js_cnt = 0;
	
    $email_str = "";
    while($opp_record = mysql_fetch_array($opp_result)) { 
 
		
		$js_str .= "uidList = uidList + '" . $opp_record['email'] . ",';\n";
		$js_cnt++;
       
    	$users_stats_res = generic_mem_cache('statscache/B' . $opp_record['email'], 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$opp_record[email]'");
        $users_stats_rec = $users_stats_res[0];
		$bingocount = userBingoCount($opp_record[email]);

        if(!$users_stats_rec['rating'] || $users_stats_rec['rating'] <= 0 ) { $users_stats_rec['rating'] = 1200; }
        $gamescompleted = $users_stats_rec['won'] + $users_stats_rec['lost'] + $users_stats_rec['drawn'];

        $disp_str .="<div class=\"user_details clear\" style=\"margin-top:8px;\">";
 
		$disp_str .= "<span style=\"float:left;margin:4px 8px 0 0;\" id=\"photo_" .$opp_record['email'] . "\"></span>";
		$disp_str .="<div style=\"float:left;\"><span  id=\"name_" . $opp_record['email'] . "\">Loading ...</span><br />";

        $disp_str .="<div style=\"float:left;margin:3px 5px 0 0;width:62px;\">";
        $disp_str .="<span style=\"line-height:12px;\">{$users_stats_rec['rating']}</span><br />";
        $disp_str .="<a href=\"".FB_APP_PATH."?action=profile&profileid={$opp_record['email']}\" target=\"_top\" style=\"background:#333;padding:2px 3px;border-radius:3px;color:#fff;font-size:10px;\">Details</a>";
        $disp_str .="</div>";
        $disp_str .="<div class=\"game_stats_row flt_left\" style=\"padding:0;height:0;\">
			        <ul class=\"clear\">
			            <li>{$gamescompleted}</li>
			            <li>{$users_stats_rec['won']}</li>
			            <li>{$users_stats_rec['lost']}</li>
			            <li>{$users_stats_rec['drawn']}</li>
			            <li>{$bingocount}</li>			            
			        </ul>
			        </div></div></div>";
        
    }
   	$str = trim($email_str,',');
	$js_str .= "uidList = uidList.substr(0,uidList.length - 1);\n\n</script>\n\n";

	return $disp_str . $js_str;
}

function shuffle_assoc(&$array) {
    $keys = array_keys($array);
    shuffle($keys);
    foreach($keys as $key) {
        $new[$key] = $array[$key];
    }
    $array = $new;
    return true;
}

function usort_callback($a, $b)
{
	if ( $a['count'] == $b['count'] )
		return 0;

	return ( $a['count'] > $b['count'] ) ? -1 : 1;
}

function Challengegame()
{
	$proxyarray = array("1391118825"=>"Javon K", "1414340545"=>"Lee M","1365409143"=>"Hugo H","1402162950"=>"Damian R","1286030000"=>"Solomon C","1319119609"=>"Kristy G","1331539528"=>"Lorraine B","1398409799"=>"Lauryn L", "1309759752"=>"Tori C",
			"400001953006601"=>"Craig S","400001953006602"=>"Landen H","400001953006603"=>"Earl K","400001953006604"=>"Ron M","400001953006605"=>"Tanner E","400001953006606"=>"Rene B","400001953006607"=>"Edward T","400001953006608"=>"Raul S",
			"400001953006609"=>"Wesley E","4000019530066010"=>"Pedro O","4000019530066011"=>"Peyton S","4000019530066012"=>"Glenda F","4000019530066013"=>"Shania H","4000019530066014"=>"Erica M","4000019530066015"=>"Amya S",
			"4000019530066016"=>"Sharon W","4000019530066017"=>"Kelsey C","4000019530066018"=>"Rosie W","4000019530066019"=>"Jillian R","4000019530066020"=>"Virginia M","4000019530066021"=>"Homer A");
	
	$newArr=array_flip($proxyarray);
	usort($newArr, 'usort_callback');
	shuffle_assoc($newArr);
	$top5 = array_slice($newArr, 0, 5);
	foreach ($top5 as $key => $value) {
		$idArr.=','.$value;
		$name = $proxyarray[$value];
			$proxy_user_arr[] = array(
								"opp_id"=>$value,									
								"opp_name"=>$name
								);
			
		}

	$proxy_user_arrar = array("idArr"=>substr($idArr, 1),"proxy_user_arr"=>$proxy_user_arr);	
	return $proxy_user_arrar;
}

function getfriendList($uid,$uidList) {
	global $facebook;
	$fql = "SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = $uid AND uid2 IN ($uidList) )";
	$friends = $facebook->api(array(
			'method'       => 'fql.query',
			'callback'    => '',
			'query'        => $fql,
	));
	$friendIds = array();
	foreach ($friends as $friend) {
		$friendIds[] = $friend['uid'];
	}
	return $friendIds;
}

function getBlockUserList($user){
	$blockedUserArr = array();
	$results = generic_mem_cache('userblock/B' . $user, 900, "SELECT user,blocked FROM blockedUser WHERE user='{$user}' OR blocked='{$user}'");
	
	foreach ($results as $key=>$row){
		if ($row['user'] == $user)
			$blockedUserArr[] = $row['blocked'];
		if ($row['blocked'] == $user)
			$blockedUserArr[] = $row['user'];
	}
	$blockedUsers = implode(",",$blockedUserArr);
	return $blockedUsers;


}

function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	return $ipaddress;
}


function daily_user($user){
	
	if(!DB::$connected) { DB::connect(); }
	
	$yesterday='';
	$last7='';
	$last10='';
	$last30='';
	
	$today= date('Y-m-d');
	//$today1= $today." 23:59:59";
	$before1 = date('Y-m-d', strtotime($today . " -1 days"));
	$before7 = date('Y-m-d', strtotime($today . " -7 days"));
	$before10 = date('Y-m-d', strtotime($today . " -10 days"));
	$before30 = date('Y-m-d', strtotime($today . " -30 days"));
	
	//$cookie_time1=strtotime($today1)-time();
	
	$query_date="select date from daily_user where userid='".$user."' order by date DESC limit 1";
	$row_date=mysql_query($query_date);
	$result_date=mysql_fetch_array($row_date);
	$last_active=$result_date['date'];
	
	if((strtotime($last_active)) >= (strtotime($before1))){
		$yesterday='y';
		$last7='y';
		$last10='y';
		$last30='y';
	}else if((strtotime($last_active)) >= (strtotime($before7))){
		$yesterday='n';
		$last7='y';
		$last10='y';
		$last30='y';
	}else if((strtotime($last_active)) >= (strtotime($before10))){
		$yesterday='n';
		$last7='n';
		$last10='y';
		$last30='y';
	}else if((strtotime($last_active)) >= (strtotime($before30))){
		$yesterday='n';
		$last7='n';
		$last10='n';
		$last30='y';
	}else{
		$yesterday='n';
		$last7='n';
		$last10='n';
		$last30='n';
	}
	
	$sql_daily_user = "insert into daily_user set date=now(),userid='".$user."',yesterday='".$yesterday."',last7='".$last7."',last10='".$last10."',last30='".$last30."'";
	mysql_query($sql_daily_user);

}

?>