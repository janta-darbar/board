<?

ob_start("ob_gzhandler");

//preload php files
include_once("systempath.php");
include ("check_scrab_board.php");// #3837
include_once("fbapi/facebook.php");
//include_once("game_file_functions.php");////////////////done
include_once("fbapi/jsonwrapper/jsonwrapper.php");

include_once ("../amazon/dynamodb_sdk-1.5.3/sdk.class.php");/////////////added
// include_once ("/var/www/html/aws-sdk/include.php");///////////added
//amazon implementation
include_once ("FileIOModel.php");////////////added
$FileIO = new FileIOModel();//////////////added

header("Content-Type: text/plain");

//////////////////json vars////////////////////////////
$jsondata = (array)json_decode(stripslashes($json));
$gid                = $jsondata['gid'];
$pid 		    = $jsondata['pid'];
$password 	    = $jsondata['password'];
$showGameOver 	    = $jsondata['showGameOver'];
$action 	    = $jsondata['action'];
$mobileRequest 	    = $jsondata['mobileRequest'];
$fb_sig_user        = $jsondata['fb_sig_user'];
$fb_sig_session_key = $jsondata['fb_sig_session_key'];
///////////////////////////////////////////////////////


//set the appropriate table names depending on game id passed

if($gid > 42958000) {
	$fin_games_moves_table = "fin_games_moves_3";
	$fin_games_boards_table = "fin_games_boards_3";
	$messages_table = "message_3";
} else {
	if($gid > 9750000) {
		$fin_games_moves_table = "fin_games_moves_2";
		$fin_games_boards_table = "fin_games_boards_2";
		$messages_table = "message_2";
	} else {
		if($gid < 8150000) {
			$fin_games_moves_table = "fin_games_moves";
			$fin_games_boards_table = "fin_games_boards";
			$messages_table = "message";
		} else {
			$fin_games_moves_table = "fin_games_moves_1";
			$fin_games_boards_table = "fin_games_boards_1";
			$messages_table = "message_1";
		}
	}
}

//////////////////////////////////////////////hosted games list/////////////////////////////////////////////////
if($action == "hostedgames") {
	$result = mysql_query("select * from `fbrequests` where expireson > NOW() and maxplayers > 0");
	$cnt = mysql_num_rows($result);
	$content = array("hostedgames"=>array("count"=>(string)$cnt,"games"=>array()));
	if($cnt  > 0) {
		while($row=mysql_fetch_array($result)) {
			$gamereqcontent = array(
				"gamereqid"     => $row['id'],
				"uid"		=> $row['user'],
				"speed"		=> $row['speed'],
				"dictionary"	=> $row['dictionary'],
				"gametype"	=> $row['gametype'],
				"brag"		=>  urldecode(htmlentities(trim($row['brag']))),
				"username"	=> $row['name'],
				"maxrequest"	=> $row['maxplayers'],
				"rating"	=> $row['rating'],
			);
			$content['hostedgames']['games'][] = $gamereqcontent;
		}
	}
	echo json_encode($content);
	exit;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$cnt = $cntmsg = 0;

// set this for user online status
#2481====
$cookies_array = explode(",",$_COOKIE['settingCookie']);
if($fb_sig_user && ($cookies_array[1] == 'y')) {
	setMemCache($fb_sig_user, 1, false, 180);
}
#2481=end===
// set this for user online status
/*if($fb_sig_user && ($_SESSION['showstatus'] == 'y')) {
	//$memcache = memcache_connect(MEMCACHE_HOST, MEMCACHE_PORT);-------#1270
	//if ($memcache) { $memcache->set($fb_sig_user, 1, false, 180); }----#1270
	setMemCache($fb_sig_user, 1, false, 180);
}*/

global $games_overTable,$users_overTable,$prev_month,$current_year;
$games_overTable = "games_over";
$users_overTable = "users_over";

if (strlen($gid) > 0 && strlen($pid) > 0 && strlen($password) > 0) {

	if($showGameOver == 1) {
		$result = mysql_query("select games_over.game_id,games_over.startedon from `users_over`, games_over where users_over.game_id = games_over.game_id and users_over.game_id='$gid' and users_over.player_id='$pid' and users_over.password = '$password'");/////changed on 3_8_12
		$cnt = mysql_num_rows($result);
		$gameOverSuffix = "_over";	////#2481
		
		if($cnt <= 0) {
			//$result = mysql_query("select games_over_200608.game_id from `users_over_200608`, games_over_200608 where users_over_200608.game_id = games_over_200608.game_id and users_over_200608.game_id='$gid' and users_over_200608.player_id='$pid' and users_over_200608.password = '$password'");
			//$gameOverSuffixNew = "_200608";
			//$gameOverSuffix = "_over";
			///#2481
			$current_month = date("m");
			$current_year = date("y");
			for ($i=1;$i<=3;$i++){
				$prev_month = $current_month - $i;
				if ($prev_month <= 0){
					$diff = 0 - $prev_month;
					$prev_month = 12 - $diff;
					$current_year = date("y") - 1;
				}
				$prev_month = strlen($prev_month)==2?$prev_month:"0".$prev_month;	
				$games_overTable = "games_over_{$prev_month}{$current_year}";
				$users_overTable = "users_over_{$prev_month}{$current_year}";
				$gameOverSuffixNew = "_{$prev_month}{$current_year}";
								
				//echo $games_overTable;
				$result = mysql_query("select $games_overTable.game_id,$games_overTable.startedon from `$users_overTable`, $games_overTable where $users_overTable.game_id = $games_overTable.game_id and $users_overTable.game_id='$gid' and $users_overTable.player_id='$pid' and $users_overTable.password = '$password'");////////changed started on added
				$cnt = mysql_num_rows($result);
				if ($cnt >= 1){					
					break;
				}
			}
			/////#2481

		} else {
			$gameOverSuffix = "_over";	
		}
		if($cnt > 0) //////////added_3_8_12
			$GAMEROW = mysql_fetch_array($result);/////////added_3_8_12

	} else {
		// here we get all information of the game from the table
		$result = mysql_query("select * from games where game_id = $gid");
    		$cnt = mysql_num_rows($result);
    		
    		if($cnt > 0) {
			$GAMEROW = mysql_fetch_array($result);

			$PLAYER_ID_ARRAY = $PASSWORD_ARRAY = $NICKNAME_ARRAY = $PLAYERID_EMAIL_ARRAY = array();
			
			$exp=explode("|", $GAMEROW['users_info']);
			$count = 1;
			$matchFound = false;

			foreach($exp as  $val)  {
		        	$exp1=explode(',',$val);
		        	
				if($exp1[0] == 1) {
					// this player has resigned
					$PLAYER_ID_ARRAY[$exp1[1]] = $count;
					$PLAYERID_EMAIL_ARRAY[$exp1[1]] = $count;
					$EMAIL_PLAYERID_ARRAY[$count] = $exp1[1];
					$NICKNAME_ARRAY[$exp1[1]] = $exp1[3];
					$NICKNAME_ARRAY_PLAYERID[$count] = $exp1[3];
					if(($pid == $count) && ($password == $exp1[2])) { $matchFound = true; }
					$count++;
				} else {
					$PLAYER_ID_ARRAY[$exp1[0]] = $count;
					$PLAYERID_EMAIL_ARRAY[$exp1[0]] = $count;
					$EMAIL_PLAYERID_ARRAY[$count] = $exp1[0];
					$NICKNAME_ARRAY[$exp1[0]] = $exp1[2];
					$NICKNAME_ARRAY_PLAYERID[$count] = $exp1[2];
					if(($pid == $count) && ($password == $exp1[1])) { $matchFound = true; }
					$count++;
				}
			}

			// user is invalid so exit
			if(!$matchFound) { exit; }
		}
	}

	if($cnt <= 0) {
		// check in finished games
		$result = mysql_query("select games_over.game_id,games_over.startedon from `users_over`, games_over where users_over.game_id = games_over.game_id and users_over.game_id='$gid' and users_over.player_id='$pid' and users_over.password = '$password'");/////changed on 3_8_12
		$cnt = mysql_num_rows($result);
		$gameOverSuffix = "_over"; /////#2481
		/*
		if($cnt > 0) {
			$gameOverSuffix = "_over";
		} else {
			$result = mysql_query("select games_over_200608.game_id from `users_over_200608`, games_over_200608 where users_over_200608.game_id = games_over_200608.game_id and users_over_200608.game_id='$gid' and users_over_200608.player_id='$pid' and users_over_200608.password = '$password'");
			$cnt = mysql_num_rows($result);
			$gameOverSuffixNew = "_200608";
			$gameOverSuffix = "_over";
		}
		*/
		if($cnt > 0) //////////added_3_8_12
			$GAMEROW = mysql_fetch_array($result);/////////added_3_8_12
	}
}
else
{
	$result_query2 = mysql_query("select game_id,startedon from `games_over` where `game_id`='$gid'");///////changed on 3_8_12
	$cnt_query2 = mysql_num_rows($result_query2);
	
	/*
	if ($cnt_query2 > 0)
	{
		$gameOverSuffix = "_over";
		$cnt = 1;
		$cntmsg = 1;
	} else {
		$result_query2 = mysql_query("select game_id from `games_over_200608` where `game_id`='$gid'");
		$cnt_query2 = mysql_num_rows($result_query2);

		if ($cnt_query2 > 0)
		{
			$gameOverSuffix = "_over";
			$gameOverSuffixNew = "_200608";
			$cnt = 1;
			$cntmsg = 1;
		}
	}*/

	if($cnt_query2 <= 0) {
			$current_month = date("m");
			$current_year = date("y");
			for ($i=1;$i<=3;$i++){
				$prev_month = $current_month - $i;
				if ($prev_month <= 0){
					$diff = 0 - $prev_month;
					$prev_month = 12 - $diff;
					$current_year = date("y") - 1;
				}
				$prev_month = strlen($prev_month)==2?$prev_month:"0".$prev_month;	
				$games_overTable = "games_over_{$prev_month}{$current_year}";
				$users_overTable = "users_over_{$prev_month}{$current_year}";
				
				$result_query2 = mysql_query("select game_id,startedon from `$games_overTable` where `game_id`='$gid'");	/////startedon added on 18_7_12 #1245
				$cnt_query2 = mysql_num_rows($result_query2);
				if ($cnt_query2 >= 1){					
					break;
				}
			}
		}
    
    if ($cnt_query2 > 0)
    {
    	$gameOverSuffix = "_over";
    	$gameOverSuffixNew = "_{$prev_month}{$current_year}";
        $cnt = 1;
        $cntmsg = 1;
    }
	#2481 End	
	
	if($cnt > 0) //////////added  on 18_7_12 #1245---3_8_12
			$GAMEROW = mysql_fetch_array($result_query2);/////////added  #1245----3_8_12
}

$content = array();

if ($cnt > 0)
{
	//////////////////////////MOVE DATA////////////////////////////////
	if ($action != "messages") {

		//if(!$memcache) { ----------#1270
		//	$memcache = memcache_connect(MEMCACHE_HOST, MEMCACHE_PORT); 
		//}

		$user_online_status = array();

		if($gameOverSuffix) {
			// get user information from the database
			$NICKNAME_ARRAY_PLAYERID = array();
			$EMAIL_PLAYERID_ARRAY = array();
			if ($gameOverSuffixNew == "_"){$gameOverSuffixNew = "";}////#2481

			$res = generic_mem_cache("pc" . $gid, 3600, "select id, player_id, nickname, email from users$gameOverSuffix$gameOverSuffixNew where game_id = " . $gid);
			foreach ($res as $id=> $row)
			{
				$NICKNAME_ARRAY_PLAYERID[$row['player_id']] = $row['nickname'];
				$EMAIL_PLAYERID_ARRAY[$row['player_id']] = $row['email'];
				//if($memcache) {
					if(getMemCache($row['email']) == 1) {//------#1270
						$user_online_status[$row['player_id']] = 'online';
					} else
						$user_online_status[$row['player_id']] = ' ';
				//}
			}

		} else {
			// just get the online status
			foreach ($EMAIL_PLAYERID_ARRAY as $id=> $row)
			{
				//if($memcache) {
					if(getMemCache($row) == 1) {////--------#1270
						$user_online_status[$id] = 'online';
					} else
						$user_online_status[$id] = '';
				//}
			}
		}

		$x = 0;

		//$file_array = get_file($gid);/////////////////done
		$file_array = $FileIO->getFile($gid, "game", $GAMEROW['startedon']);//////////added
		$move_info = $file_array[0];
		$board_info = $file_array[1];
		$exp_move=explode("|", $move_info);
		$movecontent = array();

		foreach($exp_move as $val)   {
			if(trim($val) == "") { $x=0; break; }
			$x++;
			$exp2 = explode(",",trim($val));
			$movecontent["x{$x}"] = "{$x},p{$exp2[1]},{$exp2[0]},{$exp2[3]},". strtolower($exp2[4]);
			$lastmoveid = $x;
			$lastmoveword = $exp2[0];
			$lastmovetype = strtolower($exp2[4]);
			$lastmovepoints = $exp2[3];
			$lastmoveplayer = $NICKNAME_ARRAY_PLAYERID[$exp2[1]];
		}
		$movecontent['cnt'] = (string)$x;
		$content['movesnode'] = $movecontent;
	}

	///////////////////////////////////////////////////////////

	//////////////////////BOARD DATA//////////////////////////

	if ($action != "messages") {
		
		$boardcontent = array();
		if(strlen($board_info) > 0){
		
			//$row2 = mysql_fetch_array($query2);
			//$val = split('\|', $row2[tile_str]);
			$val = split('\|', trim($board_info));
			$newarr = array();
			$lmstr = "";
			foreach($val as $tile) {
				$tmpval = split(',', $tile);
				if($tmpval[3] == $lastmoveid) {
					$lmstr .= $tmpval[1] . "," . $tmpval[2] . ",";
				}

				//$tmpval[3] = '1';
				$tmpval = join(',', $tmpval);
				array_push($newarr, $tmpval);
			}

			$boardcontent['nodeval'] = join('|', $newarr);
			$boardcontent['lastmovetiles'] = substr($lmstr, 0 , -1);
		}
		
		if(count($boardcontent) == 0) { $boardcontent['nodeval'] = $boardcontent['lastmovetiles'] = ""; }
		$content['boardnode'] = $boardcontent;
	}
	//echo '<fr>' . $file_read_FLAG . '</fr>';
	
	////////////////////////////////////////////////////////////

	////////////////////////////MESSAGE////////////////////////

	$x = 0;
	if ($cntmsg <= 0)
	{
    		$msgcontent = array();
		/*$msgquery = generic_mem_cache("SCMSGS" . $gid, 900, "SELECT msgid, player, message, DATE_FORMAT(datetime, '%d-%b-%y %H:%i GMT') as dt FROM `$messages_table$gameOverSuffix` where `game_id`='$gid' order by msgid");
		if(count($msgquery)>0) {
			foreach ($msgquery as $id=> $row) {
				$x++;
				$msgcontent["m{$x}"] = "{$x}~!~{$row[dt]}~!~{$row['player']}~!~" . urldecode(htmlentities($row['message']));
			}
		}*/
		$result = mysql_query("SELECT msgid, player, message, DATE_FORMAT(datetime, '%d-%b-%y %H:%i GMT') as dt FROM `$messages_table$gameOverSuffix` where `game_id`='$gid' order by msgid");
		if(mysql_num_rows($result)>0){
			while($row =mysql_fetch_assoc($result)){
				$x++;
				$msgcontent["m{$x}"] = "{$x}~!~{$row[dt]}~!~{$row['player']}~!~" . urldecode(htmlentities($row['message']));
			}

		}
	}
	$msgcontent['cnt'] = (string)$x;
	$content['messages'] = $msgcontent;

	/////////////////////////////////////////////////////////


	/////////////////////////gameinfo///////////////////////

	if ($action != "messages") {
		$gamecontent = array();
		$emails=array();	//----6_2_13 added for rating
		if(is_array($EMAIL_PLAYERID_ARRAY)) {
			foreach ($EMAIL_PLAYERID_ARRAY as $pid_emailID => $pid_emailEMAIL) {
				if(strpos($pid_emailEMAIL,'@') === false)
					$gamecontent["p{$pid_emailID}email"] = $pid_emailEMAIL;
				$emails[]=$pid_emailEMAIL;							//----6_2_13 added for rating
			}
		}

		if($gameOverSuffix) {
			if ($gameOverSuffixNew == "_"){$gameOverSuffixNew = "";}////#2481			
			$query = mysql_query("SELECT * FROM `games$gameOverSuffix$gameOverSuffixNew` where `game_id`='$gid'");
			$row = mysql_fetch_array($query);
			$displaystatus = 'F';
		} else {
			$row = $GAMEROW;
			$displaystatus = 'A';
		}

		$currentturn = $row['current_move'];
		$currentturn_p = "p" . $currentturn;

		if($row['language'] == "en")
			$tmp_games_fre_tiles_table = "tmp_games_fre_tiles";
		else
			$tmp_games_fre_tiles_table = "tmp_games_fre_tiles_".$row['language'];

		if ($row['winner'] > 0) {
		    $winner = $NICKNAME_ARRAY_PLAYERID[$row['winner']];
		} else if($row['winner'] == -1) {
			$winner = -1; 
		}

		$gamecontent['gameid'] = $gid;
		$gamecontent['dictionary'] = $row['dictionary'];
		$gamecontent['playersNo'] = $row['players_no'];
		$gamecontent['status'] = $displaystatus;
		$gamecontent['gametype'] = strtolower($row['game_type']);
		$gamecontent['winner'] = isset($winner)?$winner:"";
		$gamecontent['currentturnpid'] = $currentturn;

		$query2 = mysql_query("select * from `$tmp_games_fre_tiles_table$gameOverSuffix` where gameid='$gid'");
		$row2 = mysql_fetch_array($query2);

		$p1racklen = strlen(trim($row2['p1hand']));
		$p2racklen = strlen(trim($row2['p2hand']));
		$p3racklen = strlen(trim($row2['p3hand']));
		$p4racklen = strlen(trim($row2['p4hand']));

		$phand = "p" . $pid . "hand";
		$myrack = $row2[$phand];

		$total_tile = $row2['tile_a'] + $row2['tile_b'] + $row2['tile_c'] + $row2['tile_d'] + $row2
		  ['tile_e'] + $row2['tile_f'] + $row2['tile_g'] + $row2['tile_h'] + $row2['tile_i'] + $row2
		  ['tile_j'] + $row2['tile_k'] + $row2['tile_l'] + $row2['tile_m'] + $row2['tile_n'] + $row2
		  ['tile_o'] + $row2['tile_p'] + $row2['tile_q'] + $row2['tile_r'] + $row2['tile_s'] + $row2
		  ['tile_t'] + $row2['tile_u'] + $row2['tile_v'] + $row2['tile_w'] + $row2['tile_x'] + $row2
		  ['tile_y'] + $row2['tile_z'] + $row2['tile_blank'];

		$gamecontent['tilesinbag'] = (string)$total_tile;
		$playwith = "";
		
		foreach($NICKNAME_ARRAY_PLAYERID as $key=>$value) {
		  
		  if($value == '' || $value == ' ')
				$value = $EMAIL_PLAYERID_ARRAY[$key];

		  if($key != $pid)
				$playwith.= $EMAIL_PLAYERID_ARRAY[$key].",";
				
		  if ($key == $currentturn)
			  $currentturn_p = $value;

		  $gamecontent["p{$key}"] = $value;
		  $gamecontent["p{$key}status"] = $user_online_status[$key];

		}

		$playwith = rtrim($playwith,',');
		
		$gamecontent['currentturn'] = $currentturn_p;

		/*$gamecontent['p1score'] = $row2['p1score'];
		$gamecontent['p2score'] = $row2['p2score'];
		$gamecontent['p3score'] = $row2['p3score'];
		$gamecontent['p4score'] = $row2['p4score'];
		$gamecontent['p1racklen'] = (string)$p1racklen;
		$gamecontent['p2racklen'] = (string)$p2racklen;
		$gamecontent['p3racklen'] = (string)$p3racklen;
		$gamecontent['p4racklen'] = (string)$p4racklen;*/

		//--6_2_13
		for($i=0;$i<count($emails);$i++){
			//$query3=mysql_query("select rating from users_stats where email='$emails[$i]'");
			//$rows3=mysql_fetch_array($query3);
			$users_stats_res = generic_mem_cache('statscache/B' . $emails[$i], 3600, "SELECT users_stats.* FROM `users_stats` WHERE users_stats.email = '$emails[$i]'");
			$rows3 = $users_stats_res[0];
					
			//$ratings[]=$rows3['rating'];
			$key=$i+1;
			$gamecontent["p{$key}rating"]=(($rows3['rating'] == NULL) || ($rows3['rating'] == "") || $rows3['rating']==0) ? "1200" : $rows3['rating'];
			
		}//--6_2_13
				
		//----------#########changed on 21_9_12
		$gamecontent['p1score'] = (($row2['p1score'] == NULL) || ($row2['p1score'] == "")) ? "0" : $row2['p1score'];
		$gamecontent['p2score'] = (($row2['p2score'] == NULL) || ($row2['p2score'] == "")) ? "0" : $row2['p2score'];
		$gamecontent['p3score'] = (($row2['p3score'] == NULL) || ($row2['p3score'] == "")) ? "0" : $row2['p3score'];
		$gamecontent['p4score'] = (($row2['p4score'] == NULL) || ($row2['p4score'] == "")) ? "0" : $row2['p4score'];
		$gamecontent['p1racklen'] = (((string)$p1racklen == NULL) || ((string)$p1racklen == "")) ? "0" : (string)$p1racklen;
		$gamecontent['p2racklen'] = (((string)$p2racklen == NULL) || ((string)$p2racklen == "")) ? "0" : (string)$p2racklen;
		$gamecontent['p3racklen'] = (((string)$p3racklen == NULL) || ((string)$p3racklen == "")) ? "0" : (string)$p3racklen;
		$gamecontent['p4racklen'] = (((string)$p4racklen == NULL) || ((string)$p4racklen == "")) ? "0" : (string)$p4racklen;
		//---------#########  21_9_12 End
		
		if ($currentturn == $pid) {
			$myturn = "y";
		}
		else {
			$myturn = "n";
		}

		$gamecontent['myturn'] = $myturn;
		//$gamecontent['myrack'] = $myrack;
		$gamecontent['myrack'] = ($myrack == NULL) ? "" : $myrack;	//////////changed on 21_9_12

		// display the last move results
		if($movecontent['cnt']>0) {
			$gamecontent['lastmoveword'] = $lastmoveword;
			$gamecontent['lastmovetype'] = $lastmovetype;
			$gamecontent['lastmoveplayer'] = $lastmoveplayer;
			$gamecontent['lastmovepoints'] = $lastmovepoints;
		} else {
			$gamecontent['lastmoveword'] = $gamecontent['lastmovetype'] = $gamecontent['lastmoveplayer'] = $gamecontent['lastmovepoints'] ="";
		}
		$gamecontent['playwith'] = $playwith;
 		
 		$file_array = $FileIO->getFile($gid, "board", $GAMEROW['startedon']);//#3837

			$bd_exp = explode('|',trim($file_array[2]));
			$new_str  = "";
			foreach($bd_exp as $val)  {
				$bd_exp1 = explode(',',$val);
				if($bd_exp1[1] == 0)
					$new_str.=$bd_exp1[0] . ", |";
				else
					$new_str.= $val."|";
			}
			$new_str = substr($new_str, 0, -1);

			$tilevalues = unserialize(trim($file_array[1]));
			$tilevalues_str = "";
			foreach($tilevalues as $key => $val)   {
				$tilevalues_str.=$key.",".$val."|";
			}
			$tilevalues_str = rtrim($tilevalues_str, "|");
			if(trim($file_array[3]))
				$tilecnt_str = $file_array[3];
			else 
				$tilecnt_str = "a,8|b,2|c,2|d,4|e,11|f,2|g,3|h,2|i,9|j,1|k,1|l,4|m,3|n,6|o,8|p,3|q,1|r,6|s,4|t,6|u,4|v,2|w,2|x,1|y,2|z,1|blank,0";

            $diagonal_count = board_diagonal_checking(trim($file_array[0]));
			$write_board = 0;
			$scrable_board_str = "RWWLWWWRWWWLWWRWPWWWBWWWBWWWPWWWPWWWLWLWWWPWWLWWPWWWLWWWPWWLWWWWPWWWWWPWWWWWBWWWBWWWBWWWBWWWLWWWLWLWWWLWWRWWLWWWPWWWLWWRWWLWWWLWLWWWLWWWBWWWBWWWBWWWBWWWWWPWWWWWPWWWWLWWPWWWLWWWPWWLWWPWWWLWLWWWPWWWPWWWBWWWBWWWPWRWWLWWWRWWWLWWR";

			$scrable_board_str_2 = "RWWLWWWRWWWLWWRWPWWWBWWWBWWWPWWWPWWWLWLWWWPWWLWWPWWWLWWWPWWLWWWWPWWWWWPWWWWWBWWWBWWWBWWWBWWWLWWWLWLWWWLWWRWWLWWWWWWWLWWRWWLWWWLWLWWWLWWWBWWWBWWWBWWWBWWWWWPWWWWWPWWWWLWWPWWWLWWWPWWLWWPWWWLWLWWWPWWWPWWWBWWWBWWWPWRWWLWWWRWWWLWWR";

			if(($scrable_board_str == trim($file_array[0])) || ($scrable_board_str_2 == trim($file_array[0]))  || $diagonal_count >= 4 )  { 
	                    $board_str = "WWWGWWWWWWWGWWWWWRWWWBWBWWWRWWWRWWWLWWWLWWWRWGWWWPWWWWWPWWWGWWWPWWWWWWWPWWWWWLWWWLWLWWWLWWWBWWWLWWWLWWWBWWWWWWWWWWWWWWWWWBWWWLWWWLWWWBWWWLWWWLWLWWWLWWWWWPWWWWWWWPWWWGWWWPWWWWWPWWWGWRWWWLWWWLWWWRWWWRWWWBWBWWWRWWWWWGWWWWWWWGWWW";
	                   $new_str = "P,2W|L,2L|B,3L|R,3W|G,4W|W, ";
	                   $write_board = 1; 
	                }
	                else  {
	                  $board_str = trim($file_array[0]);
	                }

	                 $tilesArray = scrableChecking($tilevalues_str,trim($file_array[3]));
	                 $tile_values = $tilesArray[0];
	                 $tile_count = $tilesArray[1]; 

	                if($tile_values != $tilevalues_str)    {
	                        $exp = explode("|",$tile_values);
							foreach($exp as $val)   {
									$exp1 = explode(",",$val);
									$tilevalues[$exp1[0]]=$exp1[1];
								}
							$Wtilevalues = serialize($tilevalues);
	                        $write_board = 1; 
	                }

	                if($tile_count != trim($file_array[3]))  {                  
	                    $write_board = 1; 
	                }
					
				 if($write_board == 1)   {
				                 	$Wbdsqval = "R,3W|P,2W|B,3L|L,2L|F,4L|G,4W|H,5L|I,5W|W,0";
				                        if(!$Wtilevalues)
				                           $Wtilevalues = trim($file_array[1]);
				                //write_board_file($gid,$board_str . "\r\n" . $Wtilevalues . "\r\n".$Wbdsqval. "\r\n".$tile_count);///////////////done
				                //$FileIO->writeFile($gid, "board", $board_str . "\r\n" . $Wtilevalues . "\r\n".$Wbdsqval. "\r\n".$tile_count, $GAMEROW['startedon']);///////////////////added
				                }
 		//#3837
		/*$board_str = "RWWLWWWRWWWLWWRWWPWWWLWLWWWPWWWPWWWBWWWBWWWPWLWWWPWWWWWPWWWLWWWPWWWWWWWPWWWWWBWWWLWLWWWBWWWLWWWLWWWLWWWLWRWWWWWWPWWWWWWRWLWWWLWWWLWWWLWWWBWWWLWLWWWBWWWWWPWWWWWWWPWWWLWWWPWWWWWPWWWLWPWWWBWWWBWWWPWWWPWWWLWLWWWPWWRWWLWWWRWWWLWWR";
        $new_str = "P,2W|L,2L|B,3L|R,3W|G,4W|W, ";
        if($row['dictionary'] == "twl" || $row['dictionary'] == "sow") {
        	$tile_values = "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,8|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,8|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0";
        } else if($row['dictionary'] == "fr") {
        	$tile_values = "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,12|L,1|M,2|N,1|O,1|P,3|Q,8|R,1|S,1|T,1|U,1|V,5|W,12|X,12|Y,12|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0";
        } else if($row['dictionary'] == "it") {
        	$tile_values = "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,10|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0";
        }*/
        //$tile_values = "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,10|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0";
        //$tile_count = "a,2|b,2|c,2|d,2|e,2|f,2|g,2|h,2|i,2|j,2|k,2|l,2|m,2|n,2|o,2|p,2|q,2|r,2|s,2|t,2|u,2|v,2|w,2|x,2|y,2|z,2|blank,2";

		/*
                   $board_str = "RWWLWWWRWWWLWWRWWPWWWLWLWWWPWWWPWWWBWWWBWWWPWLWWWPWWWWWPWWWLWWWPWWWWWWWPWWWWWBWWWLWLWWWBWWWLWWWLWWWLWWWLWRWWWWWWWWWWWWWRWLWWWLWWWLWWWLWWWBWWWLWLWWWBWWWWWPWWWWWWWPWWWLWWWPWWWWWPWWWLWPWWWBWWWBWWWPWWWPWWWLWLWWWPWWRWWLWWWRWWWLWWR";
                   $new_str = "P,2W|L,2L|B,3L|R,3W|G,4W|W, ";
                   $tile_values = "A,1|B,4|C,4|D,2|E,1|F,5|G,2|H,5|I,1|J,10|K,6|L,1|M,4|N,1|O,1|P,4|Q,12|R,1|S,1|T,2|U,1|V,5|W,5|X,10|Y,5|Z,12|a,0|b,0|c,0|d,0|e,0|f,0|g,0|h,0|i,0|j,0|k,0|l,0|m,0|n,0|o,0|p,0|q,0|r,0|s,0|t,0|u,0|v,0|w,0|x,0|y,0|z,0";
                   $tile_count = "a,2|b,2|c,2|d,2|e,2|f,2|g,2|h,2|i,2|j,2|k,2|l,2|m,2|n,2|o,2|p,2|q,2|r,2|s,2|t,2|u,2|v,2|w,2|x,2|y,2|z,2|blank,2";
			*/
                   $gamecontent['boarddes'] = $board_str;
                   $gamecontent['bdsqval'] = $new_str;
                   $gamecontent['tilevalues'] = $tile_values;
                   $gamecontent['tile_count'] = $tile_count;

	}
	
	$picstr = '';
	if($mobileRequest == '1') {
		$list = '';
		foreach ($EMAIL_PLAYERID_ARRAY as $pid_emailID => $pid_emailEMAIL) {
			$list .= $pid_emailEMAIL . ',';
		}	
		$list = substr($list,0,-1);
		$x = 0;

		$api_key = 'f9aad7bfa944cb308c2afac2cc1ded9c';
		$secret  = '805bd71396719fe7e586cd5eaded08f9';
		$facebookclient = new Facebook($api_key, $secret);
		$facebookclient->set_user($fb_sig_user, $fb_sig_session_key);		
		$result = $facebookclient->api_client->fql_query("select uid, pic_square from user where uid in ($list)");	
		foreach($result as $row) {
			$tmpid = $row['uid'];		
			$gamecontent["p{$PLAYERID_EMAIL_ARRAY[$tmpid]}ImgUrl"] = $row['pic_square'];
			$x++;
		}
		
		for($i = ($x + 1); $i <=4; $i++) {
			$gamecontent["p{$i}ImgUrl"] = "";
		}
	}
	$content['gameinfo'] = $gamecontent;
} else {	///----------$#####else added on 21_9_12
	$content = array("check"=>"Failure", "message" => "This game is not available.");
}

if($_REQUEST['callback']) {//////#2481
	echo $_REQUEST['callback']."(".json_encode($content).")";
}else{
	echo json_encode($content);
}
//echo json_encode($content);
// close memcache before ending
//if($memcache)-------#1270
//	$memcache->close();

function generic_cache($file, $expire, $query) {
	$records = array();
	if (file_exists($file) && filemtime($file) > (time() - $expire)) {
    	$records = unserialize(file_get_contents($file));
	} else {
	    $result = mysql_query($query);
	    if(mysql_num_rows($result) > 0) {
	    	while ($record = mysql_fetch_array($result) ) {
	    	    $records[] = $record;
	    	}
		}

    	$OUTPUT = serialize($records);
    	$fp = fopen($file,"w");
    	fputs($fp, $OUTPUT);
    	fclose($fp);
	}

	return $records;
}

function generic_mem_cache($key, $expiry, $query) {
	global $memcache;

	//if(!$memcache) {---------closed on 20_7_12#1270
	//	$memcache = memcache_connect(MEMCACHE_HOST, MEMCACHE_PORT);
	//}

	//$records = $memcache->get($key);-----#1270
	$records = getMemCache($key);

	if($records) {
		return $records;
	} else {
		$records = array();
		$result = mysql_query($query);
	    if(mysql_num_rows($result) > 0) {
	    	while ($record = mysql_fetch_array($result) ) {
	    	    $records[] = $record;
	    	}
		}

		//$memcache->set($key, $records, false, $expiry);-------#1270
		setMemCache($key, $records, false, $expiry);
		return $records;
	}
}

?>
