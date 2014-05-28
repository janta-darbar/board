<?php

//include ("systempath.php");////////////////////////added/////closed
include ("board_file_functions.php");

//$FILE_ARRAY = get_board_file($gid);////////////////////////////////////done
$FILE_ARRAY = $FileIO->getFile($gid, "board", $row17['startedon']);//////////////////added

if($FILE_ARRAY == false || trim($FILE_ARRAY[0]) == "" || trim($FILE_ARRAY[1]) == "" || trim($FILE_ARRAY[2]) == "") {    
	$message_check = "Failure";
    $final_message = "Connection error, please try again.";
    printOutput($action, $message_check, $final_message);
}

function resign($gid, $pid)
{
	global $loggedinEmail, $originalRackTileRow;
	global $tmp_games_fre_tiles_table;

    $phand = "p" . $pid . "hand";
    $bag = $originalRackTileRow[$phand];
    $len_bag = strlen($bag);

    $sql_string = "";

    for ($i = 0; $i < $len_bag; $i++)
    {
        $key = $bag[$i];
        $value = 1;
		if($key == "*")
			$key = "blank";

        $sql_string .= " `tile_" . strtolower($key) . "`=tile_" . strtolower($key) .
            "+ 1,";
    }

    $sql_string = substr($sql_string, 0, -1);
    mysql_query("UPDATE `$tmp_games_fre_tiles_table` SET $phand = '', " . $sql_string .
        " WHERE gameid='$gid' ");
}

function delete($gameid, $pid)
{
	global $USER_EMAIL_ARRAY;
	global $row17;/////////////////////////////added
	global $FileIO; /////////////////////////////added
	
	mysql_query("call procDeleteGame($gameid)");

	//include_once ("game_file_functions.php");////	/change to include_once from include()//////////done
	//remove_file($gameid);////////////////////////done
	//remove_board_file($gameid);///////////////////////////done
	$FileIO->removeFile($gameid, "game", $row17['startedon']);///////////////////added
	$FileIO->removeFile($gameid, "board", $row17['startedon']);///////////////////added
	
	/*
    $array = array("type" => "game_delete", "player_id1" => $pid, "game_id" => $gameid);
    mysql_query("delete from games where game_id = $gameid");
    mysql_query("delete from tmp_games_fre_tiles where gameid = $gameid");
    mysql_query("delete from tmp_games_fre_tiles_fr where gameid = $gameid");
    mysql_query("delete from tmp_games_fre_tiles_it where gameid = $gameid");
    mysql_query("delete from users where game_id = $gameid");

    foreach ($USER_EMAIL_ARRAY as $key => $val) {
	    mysql_query("update users_stats set played = played - 1 where email = '" . $USER_EMAIL_ARRAY[$key] . "'");
    }
	*/
	
    mailsend($array);
	return;
}

function phpmail($mailto, $mailsubject, $mailbody, $mailfrom, $mailformat = "",
    $bcc = "")
{

    if (!valid_email($mailto))
        return;

    if ($mailformat)
        $mailformat = 'y';
    else
    	$mailformat = 'n';

	mysql_query("insert into emails set `to` = '$mailto', `from` = ' ', `subject` = '" . addslashes($mailsubject) . "', `body` = '" . addslashes($mailbody) . "', `html` = '$mailformat'");
	return 1;

    require_once ("class.phpmailer.php");

    $mail = new PHPMailer();

    $mail->From = "admin@lexulous.com";
    $mail->FromName = "lexulous.com";
    $mail->AddAddress($mailto);
    if (is_array($bcc))
        foreach ($bcc as $b)
        {
            $mail->AddAddress($b);
        }
    $mail->WordWrap = 50;// set word wrap to 50 characters

    if ($mailformat)
        $mail->IsHTML(true);

    $mail->Subject = $mailsubject;
    $mail->Body = $mailbody;

    $mail->Send();
    return 1;
}

function notifyFaceBook($to, $msg, $gid)
{
    	// first check if this user has any entry in the memcache
	global $memcache;
	global $facebookclient;
	$entryforuser = getMemCache("WSNF" . $to);
	if(!$entryforuser) {
		// entry does not exist
		// send notification to this user from the system

		// send standard notification
		//$facebookclient->api_client->notifications_send($to, ' has played a move in WordScraper. You may have moves pending in other games too. <a href="http://apps.facebook.com/wordscraper/?action=playturn">Click here to view your games.</a>');
		$tmp = $facebookclient->api_client->error_code . "-";
		$notiflist_arr = explode(",",$to); 
		incrementCount($notiflist_arr);
		
		// send email notification
/*$mailstring = "Hello,
<br/><br/>You have one or, more moves pending in your WordScraper games at Facebook. <br/><br/>
Please click <a href=\"http://apps.facebook.com/wordscraper/?action=playturn\">here</a> to see your active games or <a href=\"http://apps.facebook.com/wordscraper/?action=newgame\">start a new game</a> with a friend!
<br/><br/>
Best Regards,
<br/>
Rajat & Jayant";*/

		//$tmp .= $facebookclient->api_client->notifications_sendEmail($uid, "Wordscraper - It's your turn", "", $mailstring);

		// create entry in memcache
		// set to expire after 4 hours
		setMemCache("WSNF" . $to, $tmp, false, 14400);
	}
}

function checkDictionary($dictionary, $words)
{
	//$dictionaryServers = array('ec2-23-22-231-95.compute-1.amazonaws.com', 'ec2-50-19-20-148.compute-1.amazonaws.com');
	$dictionaryServers = array('ec2-50-17-141-237.compute-1.amazonaws.com');
	$dictionaryToUse = array_rand(array_flip($dictionaryServers), 1);
	$fp = fsockopen ($dictionaryToUse, 15000, $errno, $errstr);
	if (!$fp) {
		return 1;
	}
	else {
		$words = join(' ', $words);
		$str = fgets ($fp, 256);
		fputs ($fp, 'check ' . $dictionary . " $words\n");
		$str = trim(fgets ($fp, 256));
	}
	fclose ($fp);
	return $str;
}

function mail_gamefinish($gid, $players_no)
{
	global $MAXSCORE,$WINNER_ID;

	global $USER_PASSWORD_ARRAY, $USER_NICKNAME_ARRAY, $USER_NOTRESIGNED_ARRAY, $USER_EMAIL_ARRAY;
	// global $USER_ID_ARRAY, $USER_PLAYERID_ARRAY;

	global $originalRackTileRow;

    $all_user = "";
	$emailstr = "";

    foreach ($USER_NICKNAME_ARRAY as $key => $val)
    {
		$all_user .= $val . ',';
		if(in_array($key,$USER_NOTRESIGNED_ARRAY))
			$emailstr .= '"'.$USER_EMAIL_ARRAY[$key] . '",';
    }

    $all_user = rtrim($all_user, ",");
    $emailstr = rtrim($emailstr, ",");

    if ($WINNER_ID != '-1')
    {
    	// $winner = $USER_NICKNAME_ARRAY[$USER_PLAYERID_ARRAY[$WINNER_ID]];
    	$winner = $USER_NICKNAME_ARRAY[$WINNER_ID];
		$rowmax = $originalRackTileRow;

        $p1 = $rowmax[p1score];
        $p2 = $rowmax[p2score];
        $p3 = $rowmax[p3score];
        $p4 = $rowmax[p4score];

        if ($players_no == 2)
            $score_array = array("1" => $p1, "2" => $p2);
        if ($players_no == 3)
            $score_array = array("1" => $p1, "2" => $p2, "3" => $p3);
        if ($players_no == 4)
            $score_array = array("1" => $p1, "2" => $p2, "3" => $p3, "4" => $p4);

        arsort($score_array);
        $max_array = array();
        $player_array = array();
        foreach ($score_array as $key => $value)
        {
            array_push($player_array, $key);
            array_push($max_array, $value);
        }

        $maxscore2 = $max_array[1];
        $maxscore3 = $max_array[2];
        $maxscore4 = $max_array[3];

        $player2_id = $player_array[1];
        $player3_id = $player_array[2];
        $player4_id = $player_array[3];

        $player2 = $USER_NICKNAME_ARRAY[$player2_id];

        if ($maxscore2 == $maxscore3)
        {
            $player3 = $USER_NICKNAME_ARRAY[$player3_id];

            if ($maxscore3 == $maxscore4)
            {
                $player4 = $USER_NICKNAME_ARRAY[$player4_id];
                $winner2 = $player2 . "," . $player3 . " and " . $player4;
            }
            else
            {
                $winner2 = $player2 . " and " . $player3;
            }

        }
        else
        {
            $winner2 = $player2;
        }
    } else {
		// update stats for draw
		mysql_query("update users_stats set drawn = drawn + 1 where email in ($emailstr)");
	}

    for ($i = 1; $i <= $players_no; $i++)
    {
        if ($WINNER_ID == '-1')
        {
			if ($_GET['notify_fb'] == 'y') {
            	notifyFaceBook($USER_EMAIL_ARRAY[$i], " has played the last move. lexulous Game #$gid ended in a tie",
                $gid);
            } else {

				$mailsubject = "lexulous - Game #$gid is now over";

				$mailbody = "Hello " . $USER_NICKNAME_ARRAY[$i] . ",<br/>
				<br/>
				<font color=\"ff6600\">The game being played by $all_user has ended in a tie.</font><br/>
				<br/>
				----------------------------------------------------------------------<br/>
				To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
					$USER_PASSWORD_ARRAY[$i] . "\">CLICK HERE</a> or paste the link below in your browser:<br/>
				<br/>
				http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
					$USER_PASSWORD_ARRAY[$i] . "<br/>
				----------------------------------------------------------------------<br/>
				<br/>
				You may also want to <a href=\"http://www.lexulous.com/email_scrabble\">start a new game!</a><br/>
				<br/>
				Best Regards,<br/>
				The lexulous Team.<br/>
				<br/>
				www.lexulous.com - Everything Scrabble.";


				phpmail($USER_EMAIL_ARRAY[$i], $mailsubject, $mailbody, $from_email, "html");

            }
        }
        else
        {
            if ($player_array[0] == $i)
            {
            	mysql_query("update users_stats set won = won + 1 where email = '" . $USER_EMAIL_ARRAY[$i] . "'");

			    if ($_GET['notify_fb'] == 'y') {
               		 notifyFaceBook($USER_EMAIL_ARRAY[$i], " has played the last move. You WON lexulous Game #$gid", $gid);
				} else {
					$mailsubject = "lexulous - Game #$gid is now over";
					$mailbody = "Hello " . $USER_NICKNAME_ARRAY[$i] . ",<br/>
					<br/>
					The game being played by $all_user is now over.<br/>
					<font color=\"ff6600\">You have won game with $MAXSCORE points!</font><br/>
					Second place goes to $winner2 with $maxscore2 points.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
						$USER_PASSWORD_ARRAY[$i] . "\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
						$USER_PASSWORD_ARRAY[$i] . "<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					You may also want to <a href=\"http://www.lexulous.com/email_scrabble\">start a new game!</a><br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";

					phpmail($USER_EMAIL_ARRAY[$i], $mailsubject, $mailbody, $from_email, "html");
                }
            }
            else
            {
            	if(in_array($i,$USER_NOTRESIGNED_ARRAY)) {

					mysql_query("update users_stats set lost = lost + 1 where email = '" . $USER_EMAIL_ARRAY[$i] . "'");

					if ($_GET['notify_fb'] == 'y') {
						notifyFaceBook($USER_EMAIL_ARRAY[$i], "has played the last move. $winner has won lexulous Game #$gid",
						$gid);

					} else {
						$mailsubject = "lexulous - Game #$gid is now over";
						$mailbody = "Hello " . $USER_NICKNAME_ARRAY[$i] . ",<br/>
						<br/>
						The game being played by $all_user is now over.<br/>
						<font color=\"ff6600\">$winner has won the game with $MAXSCORE points!</font><br/>
						Second place goes to $winner2 with $maxscore2 points.<br/>
						<br/>
						----------------------------------------------------------------------<br/>
						To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
							$USER_PASSWORD_ARRAY[$i] . "\">CLICK HERE</a> or paste the link below in your browser:<br/>
						<br/>
						http://www.lexulous.com/email_scrabble/play.php?gid=$gid&pid=$i&password=" .
							$USER_PASSWORD_ARRAY[$i] . "<br/>
						----------------------------------------------------------------------<br/>
						<br/>
						You may also want to <a href=\"http://www.lexulous.com/email_scrabble\">start a new game!</a><br/>
						<br/>
						Best Regards,<br/>
						The lexulous Team.<br/>
						<br/>
						www.lexulous.com - Everything Scrabble.";
						phpmail($USER_EMAIL_ARRAY[$i], $mailsubject, $mailbody, $from_email, "html");
					}
				}
            }
        }

    }
}

function mailsend($array)
{
	global $originalRackTileRow;

	global $PLAYER_NO,$MAINWORD,$SCORE;

	global $USER_PASSWORD_ARRAY, $USER_NICKNAME_ARRAY, $USER_NOTRESIGNED_ARRAY, $USER_EMAIL_ARRAY;
	// global $USER_ID_ARRAY, $USER_PLAYERID_ARRAY;

    $move_type = $array["move_type"];
    $type = $array["type"];
    $move_id = $array["move_id"];
    $game_id = $array["game_id"];
    //echo $game_id."<br>";
    $player_id2 = $array["player_id2"];
    $p1_nickname = $array["p1_nickname"];
    //echo $player_id2."<br>";
    $player_id1 = $array["player_id1"];
    $message = $array["message"];
    $game_result = $array["game_result"];
    $word = $array["word"];

	$all_user = "";
	$other_user = "";

	//foreach ($USER_PLAYERID_ARRAY as $key => $val)
	foreach ($USER_NICKNAME_ARRAY as $key => $val)
	{
		//$all_user .= $USER_NICKNAME_ARRAY[$val] . ',';
		$all_user .= $val . ',';

		/*if(($val != $player_id1) && ($val != $player_id2)) {
			$other_user .= $USER_NICKNAME_ARRAY[$val] . ',';*/

		if(($key != $player_id1) && ($key != $player_id2)) {
			$other_user .= $val . ',';
		}
	}

	$all_user = rtrim($all_user, ",");
	$other_user = rtrim($other_user, ",");

	$to_email = $USER_EMAIL_ARRAY[$player_id2];
    $to_name = $USER_NICKNAME_ARRAY[$player_id2];
    $to_password = $USER_PASSWORD_ARRAY[$player_id2];

	$player1_mail = $USER_EMAIL_ARRAY[$player_id1];
	$player1_name = $USER_NICKNAME_ARRAY[$player_id1];
    $player1_password = $USER_PASSWORD_ARRAY[$player_id1];

    if ($type == "game_start_seek")
    {
        $mailsubject = "lexulous - Game #$game_id has now started";

        $mailbody = "Hello $player1_name,<br/>
		<br/>
		$p1_nickname has joined the game setup by you.<br/>
		<font color=\"ff6600\">It is now your turn.</font><br/>
		<br/>
		----------------------------------------------------------------------<br/>
		To play your move <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
		<br/>
		http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password<br/>
		----------------------------------------------------------------------<br/>
		<br/>
		Good luck and happy tiling!<br/>
		<br/>
		Best Regards,<br/>
		The lexulous Team.<br/>
		<br/>
		www.lexulous.com - Everything Scrabble.<br/>
		<br/>
		** If you do not wish to play the game, simply delete this email.<br/>
		You may also stop all further emails from lexulous if you want. **";

        phpmail($player1_mail, $mailsubject, $mailbody, $from_email, "html");

    }
    elseif ($type == "game_delete")
    {
        $plist = array();
        foreach($USER_NICKNAME_ARRAY as $key => $val)
        {
            $to_email = $USER_EMAIL_ARRAY[$key];
            $nickname = $val;
            if ($key != $player_id1)
            {
                array_push($plist, $nickname);
                if ($_GET['notify_fb'] == 'y') {
	                notifyFaceBook($to_email, " has deleted lexulous Game #$game_id", $game_id);
				} else {
					$mailsubject = "lexulous - $player1_name has deleted game #$game_id";
					$mailbody = "";
					$mailbody .= "Hello $nickname,<br/>
					<br/>
					$player1_name has deleted the game. If you think they did it on purpose, you can add their email to your blacklist and avoid playing games in future.<br/>
					<br/>
					Alternatively, feel free to <a href=\"http://www.lexulous.com/email_scrabble\">start a new game!</a><br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";

					phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
				}
            }
            else
            {
                $to_deleter = $to_email;
                $nick_deleter = $nickname;
            }
        }

        if (!($_GET['notify_fb'] == 'y')) {
			$nameslist = join(',', $plist);
			$nameslist = substr($nameslist, 0, strlen($nameslist) - 1);

			$subject_deleter = "lexulous - You have deleted game #$game_id";
			$mailbody_deleter = "";

			$mailbody_deleter .= "Hello $nick_deleter,<br/>
			<br/>
			You have deleted the game with $nameslist.<br/>
			Feel free to <a href=\"http://www.lexulous.com/email_scrabble\">start a new game!</a><br/>
			<br/>
			Best Regards,<br/>
			The lexulous Team.<br/>
			<br/>
			www.lexulous.com - Everything Scrabble.";

			phpmail($to_deleter, $subject_deleter, $mailbody_deleter, $from_email, "html");
        }
    }
    elseif ($type == "first_game_move")
    {
        for ($i = 1; $i <= $PLAYER_NO; $i++)
        {
			$nickname = $USER_NICKNAME_ARRAY[$i];
            $password = $USER_PASSWORD_ARRAY[$i];
            $to_email = $USER_EMAIL_ARRAY[$i];

            if ($i == $player_id1)
            {
                $mailsubject = "lexulous - Game $game_id has now been setup";
                $mailbody = "";
                $mailbody .= "Hello $nickname,<br/>
				<br/>
				You have successfully created a new game of Scrabble.<br/>
				The first move \"$MAINWORD\" for $SCORE points has been accepted.<br/>
				<font color=\"ff6600\">It is now $to_name's turn, a notification has been sent via email.</font><br/>
				<br/>
				----------------------------------------------------------------------<br/>
				To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
				<br/>
				http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
				----------------------------------------------------------------------<br/>
				<br/>
				Good luck and happy tiling!<br/>
				<br/>
				Best Regards,<br/>
				The lexulous Team.<br/>
				<br/>
				www.lexulous.com - Everything Scrabble.<br/>
				<br/>
				** If you do not wish to play the game, simply delete this email.<br/>
				You may also stop all further emails from lexulous if you want. **";

                phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
            }
            elseif ($i == $player_id2)
            {
                $to_email = $USER_EMAIL_ARRAY[$i];

                if ($_GET['notify_fb'] == 'y') {
					notifyFaceBook($to_email, " played a move in lexulous Game #$game_id - it is your turn now",
                    $game_id);
                } else {
					$mailsubject = "lexulous - $player1_name has invited you for a game of Scrabble";
					$mailbody = "";

					$mailbody .= "Hello $nickname,<br/><br/>";
					if ($PLAYER_NO > 2)
					{
						$mailbody .= "$player1_name has invited $other_user and you for a round of Scrabble!<br/>";
					}
					else
					{

						$mailbody .= "$player1_name has invited you for a game of Scrabble at lexulous!<br/>";

					}

					$mailbody .= "$player1_name has played \"$MAINWORD\" scoring $SCORE points.<br/>
					<font color=\"ff6600\">It is now your turn.</font><br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To play your move <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Good luck and happy tiling!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.<br/>
					<br/>
					** If you do not wish to play the game, simply delete this email.<br/>
					You may also stop all further emails from lexulous if you want. **";


					phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
                }
            }
            else
            {
                $mailsubject = "lexulous - $player1_name has invited you for a game of Scrabble";
                $mailbody = "";

                $mailbody .= "Hello $nickname,<br/>
				<br/>
				$player1_name played $MAINWORD scoring $SCORE points.<br/>
				<font color=\"ff6600\">It is now $to_name's turn.</font> You will be notified when it is your turn.<br/>
				<br/>
				----------------------------------------------------------------------<br/>
				To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
				<br/>
				http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
				----------------------------------------------------------------------<br/>
				<br/>
				Good luck and happy tiling!<br/>
				<br/>
				Best Regards,<br/>
				The lexulous Team.<br/>
				<br/>
				www.lexulous.com - Everything Scrabble.<br/>
				<br/>
				** If you do not wish to play the game, simply delete this email.<br/>
				You may also stop all further emails from lexulous if you want. **";

                phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
            }

        }
    }
    elseif ($type == "game_move")
    {
        if ($move_type == "R" || $move_type == "S" || $move_type == "P")
        {

            for ($i = 1; $i <= $PLAYER_NO; $i++)
            {
				$nickname = $USER_NICKNAME_ARRAY[$i];
	            $password = $USER_PASSWORD_ARRAY[$i];
	            $to_email = $USER_EMAIL_ARRAY[$i];

                if (($i != $player_id1))
                {
	                if ($_GET['notify_fb'] == 'y') {
						if ($i == $player_id2)
							notifyFaceBook($to_email, " has played a move in lexulous Game #$game_id - it is your turn",
								$game_id);
					} else {

						$mailsubject = "lexulous - $player1_name has played a move in game #$game_id";

						$mailbody = "";
						$mailbody .= "Hello $nickname,<br/>
						<br/>";

						if ($move_type == "R")
						{
							$mailbody .= "$player1_name has played \"$MAINWORD\" for $SCORE points.<br/>";
						}
						else
							if ($move_type == "S")
							{
								$mailbody .= "$player1_name has swapped his/her tiles.<br/>";
							}
							else
								if ($move_type == "P")
								{
									$mailbody .= "$player1_name has passed his/her turn.<br/>";
								}

						if ($i == $player_id2)
							$mailbody .= "It is now your turn.<br/>";
						else
							$mailbody .= "It is now $to_name's turn.<br/>";

						$mailbody .= "<br/>
						----------------------------------------------------------------------<br/>
						To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
						<br/>
						http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
						----------------------------------------------------------------------<br/>
						<br/>
						Good luck and happy tiling!<br/>
						<br/>
						Best Regards,<br/>
						The lexulous Team.<br/>
						<br/>
						www.lexulous.com - Everything Scrabble.";

						phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
					}
                }
            }
        }

    }
    else
        if ($type == "Resign")
        {
            $txt = "";
           	foreach($USER_NICKNAME_ARRAY as $key => $val)
            {
                if (count($USER_NOTRESIGNED_ARRAY) > 1)
                {
                    if ($key != $player_id1)
                    {

                        $pscore = "p" . $key . "score";
                        $txt .= $val . " - ";
                        $txt .= $originalRackTileRow[$pscore] . " points,";
                    }
                }
                else
                {
                    $pscore = "p" . $key . "score";
                    $txt .= $val . " - ";
                    $txt .= $originalRackTileRow[$pscore] . " points,";
                }
            }

            $txt = rtrim($txt, ",");

            if (count($USER_NOTRESIGNED_ARRAY) > 1)
            {
                foreach ($USER_NOTRESIGNED_ARRAY as $i)
			    {
		            $password = $USER_PASSWORD_ARRAY[$i];
                    $to_email = $USER_EMAIL_ARRAY[$i];
                    $nickname = $USER_NICKNAME_ARRAY[$i];

                    if ($i == $player_id2)
                    {
   		                if ($_GET['notify_fb'] == 'y') {
	                        notifyFaceBook($to_email, " has resigned lexulous Game #$game_id", $game_id);
						} else {
							$mailsubject = "lexulous - $player1_name has resigned from game #$game_id";
							$mailbody = "";
							$mailbody .= "Hello $nickname,<br/>
							<br/>
							$player1_name has resigned and their tiles have been returned to the bag.<br/>
							$txt are still left in the game.<br/>
							It is now your turn.<br/>
							<br/>
							----------------------------------------------------------------------<br/>
							To play your move <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
							<br/>
							http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
							----------------------------------------------------------------------<br/>
							<br/>
							Good luck and happy tiling!<br/>
							<br/>
							Best Regards,<br/>
							The lexulous Team.<br/>
							<br/>
							www.lexulous.com - Everything Scrabble.";

							phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
                        }
                    }
                    elseif ($i == $player_id1)
                    {
                        $mailsubject = "lexulous - You have resigned from game #$game_id";

                        $mailbody = "Hello $nickname,<br/>
						<br/>
						You have resigned from the game.<br/>
						$txt are still left in the game.<br/>
						It is now $to_name's turn.<br/>
						<br/>
						----------------------------------------------------------------------<br/>
						To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
						<br/>
						http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
						----------------------------------------------------------------------<br/>
						<br/>
						<a href=\"http://www.lexulous.com/email_scrabble\">Click here</a> to start a new game!<br/>
						<br/>
						Best Regards,<br/>
						The lexulous Team.<br/>
						<br/>
						www.lexulous.com - Everything Scrabble.";
                        phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
                    }
                    elseif (($i != $player_id1) && ($i != $player_id2))
                    {
		                if ($_GET['notify_fb'] == 'y') {
	                        notifyFaceBook($to_email, " has resigned lexulous Game #$game_id", $game_id);
						} else {
							$mailsubject = "lexulous - $player1_name has resigned from game #$game_id";
							$mailbody = "";
							$mailbody .= "Hello $nickname,<br/>
							<br/>
							$player1_name has resigned and their tiles have been returned to the bag.<br/>
							$txt are still left in the game.<br/>
							It is now $to_name's turn.<br/>
							<br/>
							----------------------------------------------------------------------<br/>
							To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password\">CLICK HERE</a> or paste the link below in your browser:<br/>
							<br/>
							http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$i&password=$password<br/>
							----------------------------------------------------------------------<br/>
							<br/>
							Good luck and happy tiling!<br/>
							<br/>
							Best Regards,<br/>
							The lexulous Team.<br/>
							<br/>
							www.lexulous.com - Everything Scrabble.";

							phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
                        }
                    }

                }//end of while loop
            }//end of if condition(count($USER_NOTRESIGNED_ARRAY) > 1)
            else
            {
                $to_email = $USER_EMAIL_ARRAY[$USER_NOTRESIGNED_ARRAY[0]];
                $nickname = $USER_NICKNAME_ARRAY[$USER_NOTRESIGNED_ARRAY[0]];
                $password = $USER_PASSWORD_ARRAY[$USER_NOTRESIGNED_ARRAY[0]];

                $mailsubject = "lexulous - $player1_name has resigned game #$game_id";
                $mailbody = "";

                if ($_GET['notify_fb'] == 'y') {
	                notifyFaceBook($to_email, " has resigned lexulous Game #$game_id", $game_id);
				} else {

					$mailbody .= "Hello $nickname,<br/>
					<br/>
					$player1_name has resigned the game. The final scores were as follows:<br/>
					<br/>
					$txt<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$USER_NOTRESIGNED_ARRAY[0]&password=$password<\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$USER_NOTRESIGNED_ARRAY[0]&password=$password<<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					<a href=\"http://www.lexulous.com/email_scrabble\">Click here</a>to start a new game!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";

					phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");

					$mailsubject = "Subject: lexulous - You have resigned game #$game_id";
					$mailbody = "";

					$mailbody .= "Hello $player1_name,<br/>
					<br/>
					You have resigned the game. The final scores were as follows:<br/>
					<br/>
					$txt<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					<a href=\"http://www.lexulous.com/email_scrabble\">Click here</a> to start a new game!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";

					phpmail($player1_mail, $mailsubject, $mailbody, $from_email, "html");
				}
            }

        }// end of outer if(Resign).

        elseif ($type == "Challenge")
        {
            if ($game_result == "winner")
            {
                if ($_GET['notify_fb'] == 'y') {
					notifyFaceBook($to_email, " has successfully challenged \"$word\" in lexulous Game #$game_id.",
                    $game_id);
                } else {
					//////////Mail to challenged person who loses///////////

					$mailsubject = "lexulous - $player1_name has challenged your move in game #$game_id";

					$mailbody = "Hello $to_name,<br/>
					<br/>
					$player1_name has challenged the word \"$word\" successfully.<br/>
					The word has been removed and it is now $player1_name's turn.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Good luck and happy tiling!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";


					phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");

					///////////mail to the person who has challenged and won/////////

					////// FIX MAIL BELOW
					////// $word should be the word that was challenged

					$mailsubject = "lexulous - Game #$game_id - Challenge successful";
					$mailbody = "Hello $player1_name,<br/>
					<br/>
					You have challenged the word \"$word\" successfully!<br/>
					The word has been removed and it is now your turn.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To play your move <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Good luck and happy tiling!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";
					phpmail($player1_mail, $mailsubject, $mailbody, $from_email, "html");
                }
            }
            if ($game_result == "loser")
            {
                //////////////Mail to challenged person who won//////////

                ////// FIX MAIL BELOW
                ////// $word should be the word that was challenged
                if ($_GET['notify_fb'] == 'y') {
					notifyFaceBook($to_email, " unsuccessfully challenged the word \"$word\" in lexulous Game #$game_id. Your turn",
                    $game_id);
                } else {
					$mailsubject = "lexulous - $player1_name has challenged your move in game #$game_id";
					$mailbody = "Hello $to_name,<br/>
					<br/>
					$player1_name challenged the word \"$word\" but it is valid!<br/>
					Your move has been accepted and it is now your turn.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To play your move <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Good luck and happy tiling!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";


					phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");

					///////////mail to the person who has challenged and lose/////////

					////// FIX MAIL BELOW
					////// $word should be the word that was challenged

					$mailsubject = "lexulous - Game #$game_id - Challenge unsuccessful";
					$mailbody = "Hello $player1_name,<br/>
					<br/>
					You challenged the word \"$word\". Unfortunately, \"$word\" is valid and your challenge has been unsuccessful.<br/>
					<br/>
					It is now $to_name's turn.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the board <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id1&password=$player1_password<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Good luck and happy tiling!<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble.";

					phpmail($player1_mail, $mailsubject, $mailbody, $from_email, "html");
				}
            }

        }

        else
            if ($type == "Message")
            {
                if ($_GET['notify_fb'] == 'y') {
					notifyFaceBook($to_email, " has sent a message in lexulous Game #$game_id", $game_id);
				} else {
					$mailsubject = "lexulous - $player1_name has sent you a message";
					$mailbody = "Hello $to_name,<br/>
					<br/>
					$player1_name has sent you a message.<br/>
					<br/>
					----------------------------------------------------------------------<br/>
					To view the message <a href=\"http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password\">CLICK HERE</a> or paste the link below in your browser:<br/>
					<br/>
					http://www.lexulous.com/email_scrabble/play.php?gid=$game_id&pid=$player_id2&password=$to_password<br/>
					<br/>
					Once you go to the link above, click on the message icon to reply.<br/>
					----------------------------------------------------------------------<br/>
					<br/>
					Best Regards,<br/>
					The lexulous Team.<br/>
					<br/>
					www.lexulous.com - Everything Scrabble!";

	                phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
	            }
            }
}

function mailsend2($email_to, $nickname_to, $nickname, $id, $more)
{
    $query = "select * from `new_games` where id=$id";
    $result_query = mysql_query($query);
    $row_query = mysql_fetch_array($result_query);

    $to_email = $email_to;

    $mailsubject = "lexulous - " . $nickname . " has joined your game!";
    $mailbody = "Hello  " . $nickname_to . ",<br><br>";
    if ($row_query[p1email] == $email_to)
    {
        $mailbody .= $nickname . " has joined game " . $id .
            " that you hosted at lexulous.";
    }

    else
    {
        $mailbody .= $nickname . " has joined game " . $id . " setup by  " . $row_query[p1nickname] .
            "<br>at lexulous.";
    }

    if ($more != 0)
    {
        $mailbody .= "Waiting for " . $more .
            " more player!<br><br>** If you do not wish to play this game, simply delete this message. You can also stop further emails from lexulous <a href=\"http://www.lexulous.com/email_scrabble/ban_email.php?email=$to_email\">clicking here</a>. **";
    }

    else
    {
        $mailbody .= "<br><br>** If you do not wish to play this game, simply delete this message. You can also stop further emails from lexulous <a href=\"http://www.lexulous.com/email_scrabble/ban_email.php?email=$to_email\">clicking here</a>. **";
    }
    $mailbody .= "<br><br>Best Regards,<br>The lexulous Team.<br><br>www.lexulous.com - Everything Scrabble.";

    phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
}


function mailsend3($array)
{
    $type = $array["type"];
    $email = $array["email"];

    if ($type == "email_ban")
    {
        $to_email = $email;

        $mailsubject = "lexulous - Your E-Mail has been banned successfully";
        $mailbody = "Hello  " . $nickname_to . ",<br><br>";
        $mailbody .= "You successfully ban your E-Mail at lexulous. If you want to unban your E-Mail click to the following link<br><br>";
        $mailbody .= "<a href=\"http://www.lexulous.com/remove_ban.php?email_id=" . $email .
            "\">http://www.lexulous.com/remove_ban.php?email_id=" . $email . "</a>";
        $mailbody .= "<br><br>Best Regards,<br>The lexulous Team.<br><br>www.lexulous.com - Everything Scrabble.";

        phpmail($to_email, $mailsubject, $mailbody, $from_email, "html");
    }
}
function score($gid, $mid, $pid, $array, $mainword, $tilesUsed, $row_array, $col_array)
{
	global $loggedinEmail;
	global $game_type;
	global $language;
	global $fin_games_moves_table;
	global $FILE_ARRAY;
	global $bingo_array;
	
    $cnt = count($array);
    //echo $cnt."<br>";
    $word = array();
    $rowid = array();
    $colid = array();
    $dirn = array();

    for ($i = 0; $i < $cnt; $i++)
    {
        //print_r($array);
        //echo "<br>";
        foreach ($array[$i] as $key => $value)
        {
            // echo $value."<br>";
            if ($key == "word")
            {
                array_push($word, $value);
            }
            if ($key == "row")
            {
                array_push($rowid, $value);
            }
            if ($key == "col")
            {
                array_push($colid, $value);
            }
            if ($key == "dir")
            {
                array_push($dirn, $value);
            }
        }
    }

    $cnt_word = count($word);

    /////customised///////
   $board_str = trim($FILE_ARRAY[0]);
   $exp = explode("|",trim($FILE_ARRAY[2]));
   foreach($exp as  $val)   {
    $exp1 = explode(",",$val);
	if($exp1[1] == '0')
        $tile_val[$exp1[0]]="  ";
	else
	   $tile_val[$exp1[0]]=$exp1[1];
   }

    $count=0;
	for($i=0;$i<15;$i++)   {
		for($j=0;$j<15;$j++)   {
			
			if($board_str[$count] == "R")
					 $CellValue[$i][$j]=$tile_val["R"];
			else if($board_str[$count] == "W")
					 $CellValue[$i][$j]=$tile_val["W"];
			else if($board_str[$count] == "L")
					 $CellValue[$i][$j]=$tile_val["L"];
			else if($board_str[$count] == "B")
					 $CellValue[$i][$j]=$tile_val["B"];
			else if($board_str[$count] == "P")
					 $CellValue[$i][$j]=$tile_val["P"];
			else if($board_str[$count] == "F")
                    $CellValue[$i][$j]=$tile_val["F"];
            else if($board_str[$count] == "G")
                    $CellValue[$i][$j]=$tile_val["G"];
            else if($board_str[$count] == "H")
                    $CellValue[$i][$j]=$tile_val["H"];
            else if($board_str[$count] == "I")
                    $CellValue[$i][$j]=$tile_val["I"];
			
			$count++;
		}
	}

    /*$CellValue = array(array("3W", "  ", "  ", "2L", "  ", "  ", "  ", "3W", "  ",
        "  ", "  ", "2L", "  ", "  ", "3W"), array("  ", "2W", "  ", "  ", "  ", "3L",
        "  ", "  ", "  ", "3L", "  ", "  ", "  ", "2W", "  "), array("  ", "  ", "2W",
        "  ", "  ", "  ", "2L", "  ", "2L", "  ", "  ", "  ", "2W", "  ", "  "), array("2L",
        "  ", "  ", "2W", "  ", "  ", "  ", "2L", "  ", "  ", "  ", "2W", "  ", "  ",
        "2L"), array("  ", "  ", "  ", "  ", "2W", "  ", "  ", "  ", "  ", "  ", "2W",
        "  ", "  ", "  ", "  "), array("  ", "3L", "  ", "  ", "  ", "3L", "  ", "  ",
        "  ", "3L", "  ", "  ", "  ", "3L", "  "), array("  ", "  ", "2L", "  ", "  ",
        "  ", "2L", "  ", "2L", "  ", "  ", "  ", "2L", "  ", "  "), array("3W", "  ",
        "  ", "2L", "  ", "  ", "  ", "2W", "  ", "  ", "  ", "2L", "  ", "  ", "3W"),
        array("  ", "  ", "2L", "  ", "  ", "  ", "2L", "  ", "2L", "  ", "  ", "  ",
        "2L", "  ", "  "), array("  ", "3L", "  ", "  ", "  ", "3L", "  ", "  ", "  ",
        "3L", "  ", "  ", "  ", "3L", "  "), array("  ", "  ", "  ", "  ", "2W", "  ",
        "  ", "  ", "  ", "  ", "2W", "  ", "  ", "  ", "  "), array("2L", "  ", "  ",
        "2W", "  ", "  ", "  ", "2L", "  ", "  ", "  ", "2W", "  ", "  ", "2L"), array("  ",
        "  ", "2W", "  ", "  ", "  ", "2L", "  ", "2L", "  ", "  ", "  ", "2W", "  ",
        "  "), array("  ", "2W", "  ", "  ", "  ", "3L", "  ", "  ", "  ", "3L", "  ",
        "  ", "  ", "2W", "  "), array("3W", "  ", "  ", "2L", "  ", "  ", "  ", "3W",
        "  ", "  ", "  ", "2L", "  ", "  ", "3W"));*/


	 /////customised///////
     $tilevalues = unserialize(trim($FILE_ARRAY[1]));

	/*if($language=="en")
	{
		$tilevalues = array("A" => 1, "B" => 3, "C" => 3, "D" => 2, "E" => 1, "F" => 4,
			"G" => 2, "H" => 4, "I" => 1, "J" => 8, "K" => 5, "L" => 1, "M" => 3, "N" => 1,
			"O" => 1, "P" => 3, "Q" => 10, "R" => 1, "S" => 1, "T" => 1, "U" => 1, "V" => 4,
			"W" => 4, "X" => 8, "Y" => 4, "Z" => 10, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);
	}
	else if($language=="fr") {
		$tilevalues = array("A" => 1, "B" => 3, "C" => 3, "D" => 2, "E" => 1, "F" => 4,
			"G" => 2, "H" => 4, "I" => 1, "J" => 8, "K" => 10, "L" => 1, "M" => 2, "N" => 1,
			"O" => 1, "P" => 3, "Q" => 8, "R" => 1, "S" => 1, "T" => 1, "U" => 1, "V" => 4,
			"W" => 10, "X" => 10, "Y" => 10, "Z" => 10, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);

	} else if($language=="it"){

		$tilevalues = array("A" => 1, "B" => 5, "C" => 2, "D" => 5, "E" => 1, "F" => 5,
			"G" => 8, "H" => 8, "I" => 1, "J" => 8, "K" => 10, "L" => 3, "M" => 3, "N" => 3,
			"O" => 1, "P" => 5, "Q" => 10, "R" => 2, "S" => 2, "T" => 2, "U" => 3, "V" => 5,
			"W" => 10, "X" => 10, "Y" => 10, "Z" => 8, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);
	}*/


    $tot_score = 0;
    $all_words = "";
    for ($k = 0; $k < $cnt_word; $k++)
    {

        $letter = array();
        $letter_row = array();
        $letter_col = array();
        // echo $word[$k]."<br>";
        $string = $word[$k];
        $all_words .= $word[$k] . " ";
        $str_length = strlen($string);

        if ($dirn[$k] == "H")
        {
            $coloumn = $colid[$k];
            for ($h = 0; $h < $str_length; $h++)
            {
                if ($h == 0)
                {
                    $coloumn = $coloumn;
                }
                else
                {
                    $coloumn = $coloumn + 1;
                }
                array_push($letter, $string[$h]);
                array_push($letter_row, $rowid[$k]);
                array_push($letter_col, $coloumn);
            }

        }
        if ($dirn[$k] == "V")
        {
            $rowval = $rowid[$k];
            for ($h = 0; $h < $str_length; $h++)
            {
                if ($h == 0)
                {
                    $rowval = $rowval;
                }
                else
                {
                    $rowval = $rowval + 1;
                }
                array_push($letter, $string[$h]);
                array_push($letter_row, $rowval);
                array_push($letter_col, $colid[$k]);
            }
        }

        //$flag2 = "false";
        // initialise flag2 and flag3 to false whenever a new word is fetched.
        //$flag3 = "false";
        // initialise $wordScore  to 0 whenever a new word is fetched.
        $wordScore = 0;

        $cnt_letter = count($letter);
        // echo "letter ".$cnt_letter."<br>";
        $count2 = 1;
        $count3 = 1;
        $count_array = array();

        for ($j = 0; $j < $cnt_letter; $j++)
        {
            // loop for each fetched  letter.
            $flag1 = "false";
            $tmpScorechar = $letter[$j];
            $lett_val = $tilevalues[$tmpScorechar];

			for($rowcolCnt = 0; $rowcolCnt < count($row_array); $rowcolCnt++) {

				if (($letter_row[$j] == $row_array[$rowcolCnt]) && ($letter_col[$j] == $col_array[$rowcolCnt]))
				{
                    $flag1 = "true";
                    break;
                }
			}

            if ($flag1 == "true")
            {
				if($CellValue[$letter_row[$j]][$letter_col[$j]] == "  ")
					$wordScore = ($wordScore + ($lett_val));
				else {
					$letter_number = $CellValue[$letter_row[$j]][$letter_col[$j]][0];
					$letter_type = $CellValue[$letter_row[$j]][$letter_col[$j]][1];
					if($letter_type == "L")
                        $wordScore = ($wordScore + ($lett_val * $letter_number));
					elseif($letter_type == "W")   {
						$wordScore = ($wordScore + ($lett_val));
						$count_var = "count".$letter_number;
						if(!$count_array[$count_var])
                             $count_array[$count_var] = $letter_number;
						else
                           $count_array[$count_var] = $count_array[$count_var] * $letter_number;
					}
				}

                /*

                if ($CellValue[$letter_row[$j]][$letter_col[$j]] == "2L")
                {
                    // row and col value of each letter.
                    $wordScore = ($wordScore + ($lett_val * 2));
                    // echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
                    //   echo "letter : ".$letter[$j]." cell value ".$CellValue[$letter_row[$j]][$letter_col[$j]]."<br>";
                } elseif ($CellValue[$letter_row[$j]][$letter_col[$j]] == "3L")
                {
                    // row and col value of each letter.
                    $wordScore = ($wordScore + ($lett_val * 3));
                    // echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
                    //   echo "letter : ".$letter[$j]." cell value ".$CellValue[$letter_row[$j]][$letter_col[$j]]."<br>";
                } elseif ($CellValue[$letter_row[$j]][$letter_col[$j]] == "2W")
                {
                    // row and col value of each letter.
                    $flag2 = "true";
                    $wordScore = ($wordScore + ($lett_val));
                    // echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
                    //   echo "letter : ".$letter[$j]." cell value ".$CellValue[$letter_row[$j]][$letter_col[$j]]."<br>";
                    $count2 = $count2 * 2;
                } elseif ($CellValue[$letter_row[$j]][$letter_col[$j]] == "  ")
                {
                    // row and col value of each letter.
                    $wordScore = ($wordScore + ($lett_val));
                    //  echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
                    //  echo "letter : ".$letter[$j]." cell value blank"."<br>";
                } elseif ($CellValue[$letter_row[$j]][$letter_col[$j]] == "3W")
                {
                    // row and col value of each letter.
                    $flag3 = "true";
                    $wordScore = ($wordScore + ($lett_val));
                    // echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
                    $count3 = $count3 * 3;
                    // echo "letter : ".$letter[$j]." cell value ".$CellValue[$letter_row[$j]][$letter_col[$j]]."<br>";
                }

                */
            }
            else
            {
                $wordScore = ($wordScore + ($lett_val));
            }
        }
        // end of inner $j for loop

		if(is_array($count_array)) {
			foreach($count_array as $key => $val)   {
				$wordScore = $wordScore * $val;
			}
		}

        /*

        if ($flag2 == "true")
        {
            $wordScore = $wordScore * $count2;
            //  echo "letter : ".$letter[$j]."  wordscore  ".$wordScore."<br>";
        }
        elseif ($flag3 == "true")
        {
            $wordScore = $wordScore * $count3;
            // echo "  wordscore  ".$wordScore."<br>";
        }
        elseif (($flag2 == "true") && ($flag2 == "true"))
        {
            $wordScore = $wordScore * $count2;
            $wordScore = $wordScore * $count3;
            //echo "  wordscore  ".$wordScore."<br>";
        }

		*/



        $borads = "";
        $phand = "p" . $pid . "hand";
        $string = $rowt[$phand];

        // echo "wordscore : ".$wordScore."<br>";
        $tot_score = ($tot_score + $wordScore);
        //echo "total score of each word : ".$tot_score."<br>";
    }
    // end of outer for loop
    //echo "total score : ".$tot_score."<br>";

    if ($tilesUsed >= 7)
    {
		if($tilesUsed == 7)
        	$tot_score = $tot_score + 40;
        else
        	$tot_score = $tot_score + 50;

        $insertIntoDic = 0;

		if ($game_type == 'R') {
			$insertIntoDic = 1;
		} else {
			// now we have to check if this word is a valid
			// dictionary word or not
			global $dictionarysuffix;
			if(checkDictionary($dictionarysuffix, array($mainword)) == '0') {
				$insertIntoDic = 1;
			}
		}

		if($insertIntoDic == 1) {
			$result = mysql_query("select id from users_stats where email = '$loggedinEmail'");
			$row = mysql_fetch_array($result);
			$userstatid = $row['id'];
			mysql_query("insert into `bingos` set date=NOW(), gameid='$gid',word='$mainword',score='$tot_score', userstatid = $userstatid ");
			//----------ADDED ON 9_7_12 #1120-------//
			mysql_query("UPDATE bingo_count SET totalbingo=totalbingo+1 WHERE uid='{$loggedinEmail}'");
			if (mysql_affected_rows()==0){
				mysql_query("INSERT INTO bingo_count SET totalbingo=1,uid='{$loggedinEmail}'");
			}
			//----------End #1120----------//			
			
			
			$sql_bingo_count = "select totalbingo from bingo_count where uid = '{$loggedinEmail}'";
			$res_bingo = mysql_query($sql_bingo_count);
			$result_bingoCount = mysql_fetch_assoc($res_bingo);
			if ($result_bingoCount['totalbingo'] ==  '30000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo30000';
				$publish_bingo = true;
				$bingo_type = 'bingo30000';////29_8_12
			}else if ($result_bingoCount['totalbingo'] == '20000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo20000';
				$publish_bingo = true;
				$bingo_type = 'bingo20000';
			}else if ($result_bingoCount['totalbingo'] == '10000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo10000';
				$publish_bingo = true;
				$bingo_type = 'bingo10000';
			}else if ($result_bingoCount['totalbingo'] ==  '5000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo5000';
				$publish_bingo = true;
				$bingo_type = 'bingo5000';
			}else if ($result_bingoCount['totalbingo'] ==  '2000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo2000';
				$publish_bingo = true;
				$bingo_type = 'bingo2000';
			}else if ($result_bingoCount['totalbingo']== '1000'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo1000';
				$publish_bingo = true;
				$bingo_type = 'bingo1000';
			}else if ($result_bingoCount['totalbingo']==  '400'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo400';
				$publish_bingo = true;
				$bingo_type = 'bingo400';
			}else if ($result_bingoCount['totalbingo'] == '200'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo200';
				$publish_bingo = true;
				$bingo_type = 'bingo200';
			}else if ($result_bingoCount['totalbingo'] == '20'){
				$achievement_bingo = 'http://aws.rjs.in/wordscraper/achievements/index.php?type=bingo20';
				$publish_bingo = true;
				$bingo_type = 'bingo20';/////29_8-12
			}

			global $access_token;
			
				if ($publish_bingo){
					$achievement_URL = 'https://graph.facebook.com/' . $loggedinEmail . '/achievements';
					$achievement_result = https_post($achievement_URL,
				  	'achievement=' . $achievement_bingo
				  	. '&access_token=' .$access_token
					);
					
					//---29_8_12-
					$sql_ach =  "update achievements_got set achievements = CONCAT_WS(',',achievements,'{$bingo_type}') WHERE uid = " . $loggedinEmail;
					mysql_query($sql_ach);
					if (mysql_affected_rows() == 0){
						$query_ach = "INSERT INTO achievements_got SET achievements='{$bingo_type}',uid='{$loggedinEmail}'";
						mysql_query($query_ach);
					}
					//----29_8_12
									
				}
				
				// publish achievement of bingo
				$og_type = "bingo";
				$wordLength = strlen($mainword);
				if ($tilesUsed == 7){
					$img = "http://dbyxbgd9ds257.cloudfront.net/achievements/bingoplayed40.png";
				}elseif ($tilesUsed == 8){
					$img = "http://dbyxbgd9ds257.cloudfront.net/achievements/bingoplayed50.png";
				}
				
				/////#1725
				$random_num = rand(0, 10);
				global $USERS_INFO;				
				$users_array = explode("|", $USERS_INFO);
				$index = $pid - 1;
				$loginUsersStr = $users_array[$index];
				$loginUsersArr = explode(",", $loginUsersStr);
				$loginUsersName = $loginUsersArr[2];
				
				if($loggedinEmail == '563981417')
					$random_num = 6;
				if ($random_num >= 5){
					$letters = str_shuffle($mainword);
					$query_BingoMake = "INSERT INTO unscramble_game SET word='{$mainword}',letters='{$letters}',userPlayed='{$loggedinEmail}',username='{$loginUsersName}',score={$tot_score},tiles_used={$tilesUsed},success_users=0";
					mysql_query($query_BingoMake);
					$id = mysql_insert_id();
					$title = "a bingo. Can you unscramble it from these letters - $letters?";	
					$allpublish = "http://aws.rjs.in/wordscraper/og/unscramble.php?type=".$og_type."&title=".$title."&score=".$tot_score."&word_length=".$wordLength."&rack_letter_used=".$tilesUsed."&image=".$img."&id=".$id;
				}else{	
					$title = "$mainword - a bingo!";			
					$allpublish = "http://aws.rjs.in/wordscraper/og/bingoachievement.php?type=".$og_type."&title=".$title."&score=".$tot_score."&word_length=".$wordLength."&rack_letter_used=".$tilesUsed."&image=".$img."&id=0";				
				}
				$pubish_url ="https://graph.facebook.com/me/wordscraper:play";				
				$postData = "access_token=".$access_token."&bingo=".rawurlencode($allpublish);
				$achievement_registration_result=https_post($pubish_url,$postData);
		}
		
		$bingo_array = array($mainword , $tot_score);
    }

    return $tot_score;
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

function swap_tiles($row, $letters, $gid, $pid)
{
	global $tmp_games_fre_tiles_table;

    $phand = "p" . $pid . "hand";

    $currenthand = $row[$phand];

    $len = strlen($letters);
    $feed = feed_generate($row);
    $str_length = strlen($letters);

    for ($h = 0; $h < $str_length; $h++)
    {
        $num = strlen($feed);
        $rand = substr($feed, rand(0, strlen($feed) - 1), 1);
        $currenthand .= $rand;

        if ($rand == "*")
            $rand = "blank";

        $sql_string .= "`tile_" . strtolower($rand) . "`=tile_" . strtolower($rand) .
            "- 1,";

        $pos = strpos($feed, $rand);
        $str2 = substr($feed, 0, $pos);
        $str3 = substr($feed, $pos + 1);
        $feed = $str2 . $str3;
    }

    // now add back swapped tiles to the count
    for ($h = 0; $h < $str_length; $h++)
    {

        $rand = $letters[$h];

        // replace the entry in current hand
        $pos = strpos($currenthand, $rand);
        $str2 = substr($currenthand, 0, $pos);
        $str3 = substr($currenthand, $pos + 1);
        $currenthand = $str2 . $str3;

        if ($rand == "*")
            $rand = "blank";

        $sql_string .= " `tile_" . strtolower($rand) . "`=tile_" . strtolower($rand) .
            "+ 1,";

    }

    $sql_string = substr($sql_string, 0, -1);
    mysql_query("UPDATE `$tmp_games_fre_tiles_table` SET $phand = '$currenthand', " . $sql_string .
        " WHERE gameid='$gid' ");

    return $currenthand;
}


function generate_tiles($rowt, $letters, $position, $gid, $pid)
{
    $phand = "p" . $pid . "hand";
    $string = $rowt[$phand];
    $len_string = strlen($string);

    //get length of letters placed
    $len_letters = strlen($letters);

    // generate previous rack variable
    $prev_rack = "p" . $pid . "prev_rack";

    // generate the tile feed string
    // we pass the same row that was obtained above
    $feed = feed_generate($rowt);

    // get total length of the remaining tiles
    $str1 = $string;

    for ($i = 0; $i < $len_letters; $i++)
    {
        // get position of letter in string
        // and set it to blank
        $pos = strpos($str1, $letters[$i]);
        $str2 = substr($str1, 0, $pos);
        $str3 = substr($str1, $pos + 1);
        $str1 = $str2 . $str3;

    }

    $str1_len = strlen($str1);
    $sql_string = "";
    $added = "";
    for ($h = $str1_len; $h < $len_string; $h++)
    {
        // check if any tiles are left in the feed
        if (strlen($feed) > 0)
        {
            // put a random letter from feed into temp string
            $rand = "";
            while (true)
            {
                $rand = substr($feed, rand(0, strlen($feed) - 1), 1);
                if (strlen($rand) > 0)
                {
                    $str1 .= $rand;
					$added = ',';
                    break;
                }
            }

            // letter was selected
            // now remove it from remaining feed tiles
            $pos = strpos($feed, $rand);
            $str2 = substr($feed, 0, $pos);
            $str3 = substr($feed, $pos + 1);
            $feed = $str2 . $str3;

            if ($rand == "*")
            {
                $rand = "blank";
            }

            $sql_string .= " `tile_" . strtolower($rand) . "`=tile_" . strtolower($rand) .
                " - 1,";

            if ($rand == "blank")
            {
                $rand = "*";
            }
        }
        else
            break;
    }

	$sql_string = substr($sql_string, 0, -1);

	$returnArr = array();
	$returnArr[0] = $str1;
	$returnArr[1] = " `$prev_rack`='$string', $phand='$str1' $added $sql_string ";

    return $returnArr;
}

function score_diff($string)
{
	global $language;
	global $FILE_ARRAY;

	//////customised////////
    $tilevalues = unserialize(trim($FILE_ARRAY[1]));

	/*if($language=="en")
	{
		$tilevalues = array("A" => 1, "B" => 3, "C" => 3, "D" => 2, "E" => 1, "F" => 4,
			"G" => 2, "H" => 4, "I" => 1, "J" => 8, "K" => 5, "L" => 1, "M" => 3, "N" => 1,
			"O" => 1, "P" => 3, "Q" => 10, "R" => 1, "S" => 1, "T" => 1, "U" => 1, "V" => 4,
			"W" => 4, "X" => 8, "Y" => 4, "Z" => 10, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);
	}
	else if($language=="fr") {
		$tilevalues = array("A" => 1, "B" => 3, "C" => 3, "D" => 2, "E" => 1, "F" => 4,
			"G" => 2, "H" => 4, "I" => 1, "J" => 8, "K" => 10, "L" => 1, "M" => 2, "N" => 1,
			"O" => 1, "P" => 3, "Q" => 8, "R" => 1, "S" => 1, "T" => 1, "U" => 1, "V" => 4,
			"W" => 10, "X" => 10, "Y" => 10, "Z" => 10, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);

	} else if($language=="it"){

		$tilevalues = array("A" => 1, "B" => 5, "C" => 2, "D" => 5, "E" => 1, "F" => 5,
			"G" => 8, "H" => 8, "I" => 1, "J" => 8, "K" => 10, "L" => 3, "M" => 3, "N" => 3,
			"O" => 1, "P" => 5, "Q" => 10, "R" => 2, "S" => 2, "T" => 2, "U" => 3, "V" => 5,
			"W" => 10, "X" => 10, "Y" => 10, "Z" => 8, "a" => 0, "b" => 0, "c" => 0, "d" => 0,
			"e" => 0, "f" => 0, "g" => 0, "h" => 0, "i" => 0, "j" => 0, "k" => 0, "l" => 0,
			"m" => 0, "n" => 0, "o" => 0, "p" => 0, "q" => 0, "r" => 0, "s" => 0, "t" => 0,
			"u" => 0, "v" => 0, "w" => 0, "x" => 0, "y" => 0, "z" => 0);
	}*/

    $wordScore = 0;
    $str_length = strlen($string);

    for ($h = 0; $h < $str_length; $h++)
    {
        $char = $string[$h];
        $wordScore += $tilevalues[$char];
    }
    return $wordScore;
}


function feed_generate($datarow = '')
{
    global $gid, $tmp_games_fre_tiles_table;

	if(is_array($datarow)) {
		$rowt = $datarow;
	} else {
    	$rest = mysql_query("SELECT * FROM `$tmp_games_fre_tiles_table` WHERE `gameid`='$gid' ");
    	$rowt = mysql_fetch_array($rest);
	}

    $feed = "";
    $feed .= str_repeat("A", $rowt["tile_a"]);
    $feed .= str_repeat("B", $rowt["tile_b"]);
    $feed .= str_repeat("C", $rowt["tile_c"]);
    $feed .= str_repeat("D", $rowt["tile_d"]);
    $feed .= str_repeat("E", $rowt["tile_e"]);
    $feed .= str_repeat("F", $rowt["tile_f"]);
    $feed .= str_repeat("G", $rowt["tile_g"]);
    $feed .= str_repeat("H", $rowt["tile_h"]);
    $feed .= str_repeat("I", $rowt["tile_i"]);
    $feed .= str_repeat("J", $rowt["tile_j"]);
    $feed .= str_repeat("K", $rowt["tile_k"]);
    $feed .= str_repeat("L", $rowt["tile_l"]);
    $feed .= str_repeat("M", $rowt["tile_m"]);
    $feed .= str_repeat("N", $rowt["tile_n"]);
    $feed .= str_repeat("O", $rowt["tile_o"]);
    $feed .= str_repeat("P", $rowt["tile_p"]);
    $feed .= str_repeat("Q", $rowt["tile_q"]);
    $feed .= str_repeat("R", $rowt["tile_r"]);
    $feed .= str_repeat("S", $rowt["tile_s"]);
    $feed .= str_repeat("T", $rowt["tile_t"]);
    $feed .= str_repeat("U", $rowt["tile_u"]);
    $feed .= str_repeat("V", $rowt["tile_v"]);
    $feed .= str_repeat("W", $rowt["tile_w"]);
    $feed .= str_repeat("X", $rowt["tile_x"]);
    $feed .= str_repeat("Y", $rowt["tile_y"]);
    $feed .= str_repeat("Z", $rowt["tile_z"]);
    $feed .= str_repeat("*", $rowt["tile_blank"]);
    return $feed;
}

function rand_str()
{
    $feed = "0123456789abcdefghijklmnopqrstuvwxyz";
    for ($i = 0; $i < 4; $i++)
    {
        $rand_str .= $feed[rand(0, strlen($feed) - 1)];
    }

    return ($rand_str);
}


function valid_email($email)
{
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
    {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++)
    {
        if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
            $local_array[$i]))
        {
            return false;
        }
    }
    if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
    {// Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2)
        {
            return false;// Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++)
        {
            if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
            {
                return false;
            }
        }
    }
    return true;
}


function transferCompletedGame($gid) {
    mysql_query("call procTransferGame($gid)");
	return;
}


?>