<?
if($getzipped == 1){
	ob_start("ob_gzhandler");
}

//post.php?action=MOVE&txt=X,X,X,X,X,X[txt=letter,row,col,y/n and so on & For BLANK tile letter must be smallcase]
//post.php?action=SWAP&str=XXX[str=the letters to be swapped like ASD]
//post.php?action=PASS
//post.php?action=MESSAGE&message=XXXXXXXXXXX
//post.php?action=RESIGN&gid=X&pid=X&password=XXXX
//post.php?action=DELETE&gid=X&pid=X&password=XXXX
//post.php?action=CHALLENGE&gid=X&pid=X&password=XXXX

// set the appropriate table names
// depending on game id passed

// ini_set('display_errors', E_ALL);
ini_set('display_errors', 1);

$proxyarray = array("1391118825"=>"Javon K", "1414340545"=>"Lee M","1365409143"=>"Hugo H","1402162950"=>"Damian R","1286030000"=>"Solomon C","1319119609"=>"Kristy G","1331539528"=>"Lorraine B","1398409799"=>"Lauryn L", "1309759752"=>"Tori C",
		"400001953006601"=>"Craig S","400001953006602"=>"Landen H","400001953006603"=>"Earl K","400001953006604"=>"Ron M","400001953006605"=>"Tanner E","400001953006606"=>"Rene B","400001953006607"=>"Edward T","400001953006608"=>"Raul S",
		"400001953006609"=>"Wesley E","4000019530066010"=>"Pedro O","4000019530066011"=>"Peyton S","4000019530066012"=>"Glenda F","4000019530066013"=>"Shania H","4000019530066014"=>"Erica M","4000019530066015"=>"Amya S",
		"4000019530066016"=>"Sharon W","4000019530066017"=>"Kelsey C","4000019530066018"=>"Rosie W","4000019530066019"=>"Jillian R","4000019530066020"=>"Virginia M","4000019530066021"=>"Homer A");
$proxykeys = array_keys($proxyarray);


include_once("../fbapi/facebook.php"); //needs to change
include_once("personalStatsFunctions.php");
include_once ("systempath.php");
//include_once("xml_achievements_file_functions.php");

global $row17;
global $FileIO;
$FileIO = new FileIOModel();
//include_once("game_file_functions.php");


//////////////////////////////////////////////////
$jsondata = (array)json_decode(stripslashes($json));

$gid                = $jsondata['gid'];
$pid 		    = $jsondata['pid'];
$password 	    = $jsondata['password'];
$action 	    = $jsondata['action'];
$fb_sig_user        = $jsondata['fb_sig_user'];
$fb_sig_session_key = $jsondata['fb_sig_session_key'];
$txt                = $jsondata['txt'];
$str		    = $jsondata['str'];
$message            = $jsondata['message'];
$robotsecret            = $jsondata['robotsecret'];
//////////////////////////////////////////////////


global $facebookclient, $sendfacebook;


$api_key = 'f9aad7bfa944cb308c2afac2cc1ded9c';
$secret  = '805bd71396719fe7e586cd5eaded08f9';
$fbappid = "3052170175";
$pushflagVar = false;$pushflagVarM = false;

//----####### 21_9_12
if(($pid == '') || ($pid > 4) || ($pid < 1)) {
	echo "{\"action\":\"$action\",\"check\":\"Failure\",\"message\":\"Invalid sender\"}";
	exit;
}
//----######21_9_12



//creating facebook object
$facebookclient = new Facebook(array('appId'  => '3052170175','secret' => $secret ,'cookie' => true));
if($robotsecret == 'dTTsgS6j') {
	$userid = $jsondata['fb_sig_user'];
	// always notify facebook due to robot moves
	$_GET['notify_fb'] = 'y';	
} else {
	$userid = authenticate($action,$jsondata['fb_sig_session_key']);	
}

//getting user data
if($userid <> $jsondata['fb_sig_user']) {
		echo "{\"action\":\"$action\",\"check\":\"Failure\",\"message\":\"Invalid user\"}";
		exit;
}

if($fb_sig_user && $fb_sig_user != 'undefined') { $sendfacebook = 'y'; }

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

header("Content-Type: text/plain");

//$memcache = memcache_connect('192.168.200.70', 600);----closed on 20_7_12---#1270

// set this for user online status
if($fb_sig_user && ($_SESSION['showstatus'] == 'y')) {
	//if ($memcache) {
		//$memcache->set($fb_sig_user, 1, false, 180);------#1270
		setMemCache($fb_sig_user, 1, false, 180);
	//}
}


if($action == "CHECKNEW") {
	checkNewMoves($gid, $lastmoveid, $lastmsgid);
}

$xmlstring = "";

$USER_PASSWORD_ARRAY = array();
$USER_NICKNAME_ARRAY = array();
$USER_NOTRESIGNED_ARRAY = array();
$USER_EMAIL_ARRAY = array();

// $USER_ID_ARRAY = array();
// $USER_PLAYERID_ARRAY = array();

$USER_RESIGN_ARRAY = array();

// $id = loginUser($gid, $pid, $password);

$query17 = mysql_query("select * from `games` where game_id=$gid");
if(mysql_num_rows($query17) <= 0) {
	$query17 = mysql_query("select * from `games_over` where game_id=$gid");
	$status = 'F';
	$messages_table.="_over";
}

$row17 = mysql_fetch_array($query17);
$current_move = $row17[current_move];
$dictionary = $row17[dictionary];
$dictionarysuffix = $row17[dictionary];
$allow_msg = $row17[allow_msg];
$PLAYER_NO = $row17[players_no];
$game_type = $row17[game_type];
$passCount = $row17[passes];
$language = $row17[language];
$firstMoveMade = $row17[firstmove];
$USERS_INFO = $row17['users_info'];

mysql_free_result($query17);

include_once("common.php");

if($status != 'F') {
	loginUser($gid, $pid, $password);
}

$finalstring = "";
$val_array = array();
$letterval_array = array();
$rowval_array = array();
$colval_array = array();

$phand = "p" . $pid . "hand";
$pscore = "p" . $pid . "score";

if($language=="en")
   $tmp_games_fre_tiles_table="tmp_games_fre_tiles";
else
   $tmp_games_fre_tiles_table="tmp_games_fre_tiles_".$language;

if($status != 'F') {

	$query4 = mysql_query("SELECT * FROM `$tmp_games_fre_tiles_table` WHERE `gameid`='$gid' ");
	if ((mysql_num_rows($query4) > 0))
	    $originalRackTileRow = mysql_fetch_array($query4);

	mysql_free_result($query4);
}


$total_array = array();
$row_array = array();
$col_array = array();
$letter_array = array();

// THIS GETS INFORMATION FROM FILES

//$file_array = get_file($gid);/////////////////done
$file_array = $FileIO->getFile($gid, "game", $row17['startedon']);////////////////added
$move_info = trim($file_array[0]);
$board_info = trim($file_array[1]);
$exp_move = explode("|", $move_info);
if($move_info != "")
	$total_moves = count($exp_move);
else
	$total_moves = 0;

// END OF GETTING INFORMATION FROM FILES

if ($status == 'F')
{
    if ($action == 'MOVE' || $action == 'SWAP' || $action == 'PASS' || $action ==
        'RESIGN')
    {
        $message_check = "Failure";
        $final_message = "Game is over.";
    }
    if ($action == 'NEXTGAME'){
    	$returnArray = array();
    	$returnArray['action'] = $action;
    	$returnArray['gid'] = '';
    	$returnArray['pid'] = '';
    	$returnArray['password'] = '';
    	$message_check = "Success";
    }

}
else
{
    if ($action == 'MOVE')
    {
        $total_array = explode(",", $txt);
        $newcount = count($total_array);
        $len = strlen($txt);
        $count = $len / 4;

        for ($i = 1; $i < $newcount; $i = $i + 4)
        {
            array_push($row_array, $total_array[$i]);

        }
        for ($i = 2; $i < $newcount; $i = $i + 4)
        {
            array_push($col_array, $total_array[$i]);

        }
        for ($i = 0; $i < $newcount; $i = $i + 4)
        {
            array_push($letter_array, $total_array[$i]);
        }

        $rownumber = count($row_array);
        $letter = $originalRackTileRow[$phand];
        $n = strlen($originalRackTileRow[$phand]);
        $tiles = array();
        $tiles1 = array();
        for ($p = 0; $p < $n; $p++)
        {
            $tiles[$p] = $letter[$p];
            $tiles1[$p] = $letter[$p];
        }

        if ($current_move == $pid)
        {
            $turn_check = 1;
        }
        else
        {
            $turn_check = 0;
        }

        if ($turn_check == 0)
        {
            $message_check = "Failure";
            $final_message = "It is not your turn.";
            printOutput($action, $message_check, $final_message);
        }

        $count_tile = count($tiles);

        ////////////////////////////////New Edit//////////////////////

        if ($turn_check == 1)
        {
            if ($rownumber > 1)
            {

                for ($i = 0; $i <= $rownumber - 2; $i++)
                {
                    for ($j = $i + 1; $j <= $rownumber - 1; $j++)
                    {
                        if (($row_array[$i] == $row_array[$j]) && ($col_array[$i] == $col_array[$j]))
                        {
                            $placing_check = 5;
                            break;
                        }
                        else
                        {
                            $placing_check = 10;
                        }
                    }
                    if ($placing_check == 5)
                        break;
                }

            }

            else
                $placing_check = 10;
        }

        if ($placing_check == 5)
        {
            $message_check = "Failure";
            $final_message = "Invalid tiles placed.";
            printOutput($action, $message_check, $final_message);
        }
        if ($placing_check == 10)
        {
            $board_row = array();
            $board_col = array();
            $board_tile = array();

			/* $query5 = mysql_query("select * from `$fin_games_boards_table` where `gameid`='$gid'");
			$arr5 = mysql_fetch_array($query5);
			mysql_free_result($query5);
			if(strlen($arr5['tile_str']) > 0) {
				$temp_arr=explode('|',$arr5['tile_str']);
	            $number = count($temp_arr);
	        } */

			if(strlen($board_info) > 0) {
				$temp_arr=explode('|',$board_info);
	            $number = count($temp_arr);
	        }
			else
				$number = 0;


            if ($number > 0)
            {
				 foreach($temp_arr as $val)
				 {
                     $temp_arr1=explode(',',$val);
					 array_push($board_row, $temp_arr1[1]);
                     array_push($board_col, $temp_arr1[2]);
                     array_push($board_tile, $temp_arr1[0]);

				 }
            }

            if ($number > 0)
            {
                for ($k = 0; $k <= $rownumber - 1; $k++)
                {

                    for ($i = 0; $i < $number; $i++)
                    {
                        if (($board_row[$i] == $row_array[$k]) && ($board_col[$i] == $col_array[$k]))
                        {
                            $database_check = 5;
                            break;
                        }
                        else
                            $database_check = 10;
                    }

                    if ($database_check == 5)
                        break;

                }

            }
            else
                $database_check = 10;
        }

        if ($database_check == 5)
        {
            $message_check = "Failure";
            $final_message = "Tiles are already present.";
            printOutput($action, $message_check, $final_message);
        }

        /////////////////////////////End of New Edit///////////////////

        if ($database_check == 10)
        {
            if ($rownumber > $count_tile)
            {
                $message_check = "Failure";
                $final_message = "Invalid tiles placed.";
                printOutput($action, $message_check, $final_message);
            }
            else
            {

                for ($first = 0; $first < $rownumber; $first++)
                {
                    for ($sec = 0; $sec < $count_tile; $sec++)
                    {
                        $letter_char = $letter_array[$first];

                        $tiles_char = $tiles[$sec];
                        if ($tiles[$sec] != "5")
                        {
                            if ($letter_char == $tiles_char)
                            {
                                $first_check = 1;
                                $tiles[$sec] = "5";
                                break;
                            }
                            else
                            {
                                $ascii = ord($letter_char);
                                if (($ascii >= 97) && ($ascii <= 122) && ($tiles_char == '*'))
                                {
                                    $first_check = 1;
                                    $tiles[$sec] = "5";
                                    break;
                                }
                                else
                                    $first_check = 0;

                            }
                        }

                    }

                    if ($first_check == 0)
                    {
                        $message_check = "Failure";
                        $final_message = "Invalid tiles placed.";
                        printOutput($action, $message_check, $final_message);
                        break;
                    }

                }
            }
        }

        $value2 = $number;

        if ($first_check == 1)
        {
            for ($i = 0; $i < $rownumber; $i++)
            {
                if ((($row_array[$i] == '7') && ($col_array[$i] == '7')) || ($value2 > 0))
                {
                    $val123 = 10;
                    break;
                }

                else
                    $val123 = 5;

            }
        }

        if ($val123 == 10)
        {
            if ($rownumber > 1)
            {

                for ($i = 0; $i < ($rownumber - 1); $i++)
                {
                    if ($row_array[$i] == $row_array[$i + 1])
                        $test = 1;

                    else
                    {

                        $test = 0;
                        break;
                    }
                }
                for ($j = 0; $j < ($rownumber - 1); $j++)
                {
                    if ($col_array[$j] == $col_array[$j + 1])
                        $test1 = 1;

                    else
                    {

                        $test1 = 0;
                        break;
                    }
                }
            }

            if ($rownumber == 1)
            {
                $test = 1;
            }

            if (($test == 0) && ($test1 == 0) && ($rownumber != 1))
            {
                $message_check = "Failure";
                $final_message = "Tiles not in sequence.";
                printOutput($action, $message_check, $final_message);
            }
            if (($test == 1) || ($test1 == 1))
            {
                $test2 = 1;
            }
        }

        ///////////making words/////////////

        $acol = array();
        $word_array = array();
        $word_row = array();
        $word_col = array();
        $left_word = array();
        $left_row = array();
        $left_col = array();

        if ($test2 == 1) //if for checking sequence
        {
            //echo "Tiles are  in sequence<br>";
            if ($test == 1) ///////////////////////////////////if when row same
            {
                //////make a associative array/////
                for ($i = 0; $i < $rownumber; $i++)
                {

                    $tempArray = array($col_array[$i] => $letter_array[$i]);
                    $acol = $acol + $tempArray;

                }

                ksort($acol);
                $col_array = array();
                $letter_array = array();
                foreach ($acol as $key => $val)
                {
                    array_push($col_array, $key);
                    array_push($letter_array, $val);

                }

                ///////increment the col pos (when row same.)/////////
                $check = $col_array[0];
                for ($i = $check; $i <= 14; $i++)
                {
                    foreach ($acol as $key => $val)
                    {
                        while ($check != $key)
                        {
                            ///////Reducing code//////////
                            $flag = 0;
                            /// change code so that it will work off array and not repeat SQL
                            /// then it will make system much faster

                            if ($number > 0)
                            {
                                for ($z = 0; $z < $number; $z++)
                                {

                                    if (($board_row[$z] == $row_array[0]) && ($board_col[$z] == $check))
                                    {

                                        $that_tile = $board_tile[$z];
                                        $flag = 1;
                                        break;
                                    }
                                }
                            }

                            //if (mysql_num_rows($query) > 0)
                            if ($flag == 1)
                            {

                                //array_push($word_array, $arr[tile]);
                                array_push($word_array, $that_tile);
                                array_push($word_row, $row_array[0]);
                                array_push($word_col, $check);

                            }
                            else
                                break;
                            $check = $check + 1;

                        }
                        if ($check == $key)
                        {

                            array_push($word_array, $val);
                            array_push($word_row, $row_array[0]);
                            array_push($word_col, $key);
                            $check = $check + 1;

                        }

                    }
                }

                //echo "CHECK:".$check."<br><br>";
                for ($x = $check + 1; $x <= 14; $x++)
                {
                    if (in_array($x, $col_array))
                    {
                        $final1 = 1;
                        //echo "<font color=red>Tiles are not connected Horizontally.</font><br>";
                        $message_check = "Failure";
                        $final_message = "Tiles not connected horizontally.";
                        printOutput($action, $message_check, $final_message);
                        break;
                    }

                }

                /////end of increment col pos  when row same/////////

                ///////////////decrement the col pos (when row same)////////////
                $lcheck = $col_array[0];
                $lcheck = $lcheck - 1;
                //echo "LEFT".$lcheck;

                while ($lcheck >= 0)
                {
                    $flag = 0;
                    if ($number > 0)
                    {
                        for ($z = 0; $z < $number; $z++)
                        {

                            if (($board_row[$z] == $row_array[0]) && ($board_col[$z] == $lcheck))
                            {
                                $that_tile = $board_tile[$z];
                                $flag = 1;
                                break;
                            }
                        }
                    }

                    if ($flag == 1)
                    {

                        //$tempArray = array($lcheck => $arr[tile]);
                        $tempArray = array($lcheck => $that_tile);
                        $left_word = $left_word + $tempArray;
                        $lcheck = $lcheck - 1;
                    }
                    else
                        break;

                }

                ksort($left_word);


                ////////////end of  decrement the col pos (when row same)///////

                $result = array_merge($left_word, $word_array);


                if (count($result) > 1)
                {
                    for ($a = 0; $a <= count($result); $a++)
                    {
                        $finalstring = $finalstring . $result[$a];
                    }
                    $finalstring = $finalstring . "@";
                    $lcheck = $lcheck + 1;
                    $finalstring1 = $finalstring . $row_array[0] . "@" . $lcheck . "@H@";

                }

                ////////vertically  making of words(when row same)/////

                $vresult = array();

                for ($loop = 0; $loop < $rownumber; $loop++)
                {
                    $vcheck = $row_array[0];
                    $vcheck = $vcheck + 1;
                    $vleft_word = array($row_array[0] => $letter_array[$loop]);

                    while ($vcheck <= 14)
                    {
                        $flag = 0;
                        ///////Reducing code//////////

                        if ($number > 0)
                        {
                            for ($z = 0; $z < $number; $z++)
                            {
                                if (($board_row[$z] == $vcheck) && ($board_col[$z] == $col_array[$loop]))
                                {
                                    $that_tile = $board_tile[$z];
                                    $flag = 1;
                                    break;
                                }
                            }
                        }
                        //if (mysql_num_rows($query) > 0)
                        if ($flag == 1)
                        {
                            //$tempArray = array($vcheck => $arr[tile]);
                            $tempArray = array($vcheck => $that_tile);
                            $vleft_word = $vleft_word + $tempArray;
                            $vcheck = $vcheck + 1;
                        }
                        else
                            break;

                    }

                    ////////for decrement row(when row same)////////
                    $uleft_word = array();
                    $ucheck = $row_array[0];
                    $ucheck = $ucheck - 1;

                    while ($ucheck >= 0)
                    {
                        $flag = 0;
                        ///////Reducing code//////////


                        if ($number > 0)
                        {
                            for ($z = 0; $z < $number; $z++)
                            {
                                if (($board_row[$z] == $ucheck) && ($board_col[$z] == $col_array[$loop]))
                                {
                                    $that_tile = $board_tile[$z];
                                    $flag = 1;
                                    break;
                                }
                            }
                        }
                        //if (mysql_num_rows($query) > 0)
                        if ($flag == 1)
                        {
                            //$tempArray = array($ucheck => $arr[tile]);
                            $tempArray = array($ucheck => $that_tile);
                            $uleft_word = $uleft_word + $tempArray;
                            $ucheck = $ucheck - 1;

                        }
                        else
                            break;

                    }
                    ksort($uleft_word);
                    $result1 = array_merge($uleft_word, $vleft_word);
                    $vnum = count($result1);

                    $ucheck = $ucheck + 1;
                    if (count($result1) > 1)
                    {
                        for ($a = 0; $a <= count($result1); $a++)
                        {
                            $finalstring = $finalstring . $result1[$a];
                            $finalstring1 = $finalstring1 . $result1[$a];
                        }
                        $finalstring = $finalstring . "@";
                        $finalstring1 = $finalstring1 . "@";
                        $finalstring1 = $finalstring1 . $ucheck . "@" . $col_array[$loop] . "@V@";
                    }

                    //break;
                }

                if ((count($result) == 1) && (count($result1) == 1))
                {
                    $final2 = 1;
                    //echo "<font color=red>Tiles are not Horizontally or Vertically connected.</font>";
                    $message_check = "Failure";
                    $final_message = "Tiles are not connected.";
                    printOutput($action, $message_check, $final_message);
                }

                ////////end of decrement row////////

                ////////end of vertically  making of words(same row)/////

            }/////////////////////////////////////////// End of if when row same

            if ($test1 == 1) ////////////////////////////////////if when col same
            {

                //////make a associative array/////
                for ($i = 0; $i < $rownumber; $i++)
                {

                    $tempArray = array($row_array[$i] => $letter_array[$i]);
                    $acol = $acol + $tempArray;

                }

                ksort($acol);

                $row_array = array();
                $letter_array = array();
                foreach ($acol as $key => $val)
                {
                    array_push($row_array, $key);
                    array_push($letter_array, $val);

                }

                //print_r($acol);

                ///////increment the row pos.(when col same)/////////
                $check = $row_array[0];
                for ($i = $check; $i <= 14; $i++)
                {
                    foreach ($acol as $key => $val)
                    {

                        while ($check != $key)
                        {
                            $flag = 0;
                            ///////Reducing code//////////
                            if ($number > 0)
                            {
                                for ($z = 0; $z < $number; $z++)
                                {
                                    if (($board_row[$z] == $check) && ($board_col[$z] == $col_array[0]))
                                    {
                                        $that_tile = $board_tile[$z];
                                        $flag = 1;
                                        break;
                                    }
                                }
                            }

                            //if (mysql_num_rows($query) > 0)
                            if ($flag == 1)
                            {
                                //array_push($word_array, $arr[tile]);
                                array_push($word_array, $that_tile);
                                array_push($word_row, $check);
                                array_push($word_col, $col_array[0]);

                            }
                            else
                                break;
                            $check = $check + 1;

                        }
                        if ($check == $key)
                        {

                            array_push($word_array, $val);
                            array_push($word_row, $key);
                            array_push($word_col, $col_array[0]);
                            $check = $check + 1;

                        }

                    }
                }

                //echo "CHECK:".$check."<br><br>";
                for ($x = $check + 1; $x <= 14; $x++)
                {
                    if (in_array($x, $row_array))
                    {
                        $final3 = 1;
                        //echo "<font color=red>Tiles are not connected Vertically.</font><br>";
                        $message_check = "Failure";
                        $final_message = "Tiles not connected vertically.";
                        printOutput($action, $message_check, $final_message);
                        break;
                    }

                }

                /////end of increment row pos(when col same)/////////

                ///////////////decrement the row pos(when col same)////////////
                $lcheck = $row_array[0];
                $lcheck = $lcheck - 1;
                //echo "LEFT".$lcheck;

                while ($lcheck >= 0)
                {
                    ///////Reducing code//////////
                    $flag = 0;
                    if ($number > 0)
                    {
                        for ($z = 0; $z < $number; $z++)
                        {
                            if (($board_row[$z] == $lcheck) && ($board_col[$z] == $col_array[0]))
                            {
                                $that_tile = $board_tile[$z];
                                $flag = 1;
                                break;
                            }
                        }
                    }
                    //if (mysql_num_rows($query) > 0)
                    if ($flag == 1)
                    {
                        //$tempArray = array($lcheck => $arr[tile]);
                        $tempArray = array($lcheck => $that_tile);
                        $left_word = $left_word + $tempArray;

                        $lcheck = $lcheck - 1;
                    }
                    else
                        break;

                }
                ksort($left_word);

                ////////////end of  decrement the row pos(when col same)///////

                $result = array_merge($left_word, $word_array);
                // echo "Vertically Words:";
                //print_r($result);
                //echo "<br>";
                if (count($result) > 1)
                {
                    for ($a = 0; $a <= count($result); $a++)
                    {
                        $finalstring = $finalstring . $result[$a];
                    }
                    $finalstring = $finalstring . "@";
                    $lcheck = $lcheck + 1;
                    $finalstring1 = $finalstring . $lcheck . "@" . $col_array[0] . "@V@";
                }

                ////////Horizontally  making of words(when col same)/////

                $vresult = array();

                for ($loop = 0; $loop < $rownumber; $loop++)
                {
                    $vcheck = $col_array[0];
                    $vcheck = $vcheck + 1;
                    $vleft_word = array($col_array[0] => $letter_array[$loop]);

                    while ($vcheck <= 14)
                    {
                        $flag = 0;
                        ///////Reducing code//////////
                        if ($number > 0)
                        {
                            for ($z = 0; $z < $number; $z++)
                            {
                                if (($board_row[$z] == $row_array[$loop]) && ($board_col[$z] == $vcheck))
                                {
                                    $that_tile = $board_tile[$z];
                                    $flag = 1;
                                    break;
                                }
                            }
                        }
                        //if (mysql_num_rows($query) > 0)
                        if ($flag == 1)
                        {
                            //$tempArray = array($vcheck => $arr[tile]);
                            $tempArray = array($vcheck => $that_tile);
                            $vleft_word = $vleft_word + $tempArray;
                            $vcheck = $vcheck + 1;
                        }
                        else
                            break;

                    }

                    ////////for decrement col////////
                    $uleft_word = array();
                    $ucheck = $col_array[0];
                    $ucheck = $ucheck - 1;

                    while ($ucheck >= 0)
                    {
                        $flag = 0;
                        ///////Reducing code//////////
                        if ($number > 0)
                        {
                            for ($z = 0; $z < $number; $z++)
                            {
                                if (($board_row[$z] == $row_array[$loop]) && ($board_col[$z] == $ucheck))
                                {
                                    $that_tile = $board_tile[$z];
                                    $flag = 1;
                                    break;
                                }
                            }
                        }
                        //if (mysql_num_rows($query) > 0)
                        if ($flag == 1)
                        {
                            //$tempArray = array($ucheck => $arr[tile]);
                            $tempArray = array($ucheck => $that_tile);
                            $uleft_word = $uleft_word + $tempArray;
                            $ucheck = $ucheck - 1;
                        }
                        else
                            break;

                    }
                    ksort($uleft_word);
                    $result1 = array_merge($uleft_word, $vleft_word);
                    $vnum = count($result1);
                    //echo "<br>";

                    $ucheck = $ucheck + 1;
                    if (count($result1) > 1)
                    {
                        for ($a = 0; $a <= count($result1); $a++)
                        {
                            $finalstring = $finalstring . $result1[$a];
                            $finalstring1 = $finalstring1 . $result1[$a];
                        }
                        $finalstring = $finalstring . "@";
                        $finalstring1 = $finalstring1 . "@";
                        $finalstring1 = $finalstring1 . $row_array[$loop] . "@" . $ucheck . "@H@";

                    }

                    //break;
                }
                //print_r($vresult);

                //echo $finalstring1;

                //echo "<br><br>";

                ////////end of decrement col////////

                ////////end of Horizontally  making of words(same col)/////

            }// End of if when col same
            $check_string = substr($finalstring, 0, -1);
            //echo $check_string."<br>";
            //echo $finalstring1."<br>";

            $pieces12 = explode("@", $check_string);
            $pieces = explode("@", $finalstring1);
            $fcount = count($pieces);
            $fcount12 = count($pieces12);

			$dictionary = "dictionary_" . $dictionary;

            if (($final1 == 1) || ($final2 == 1) || ($final3 == 1))
            {
                //echo "overall checking is not successful before dictionary checking.";

            }
            else
            {
                if ($fcount12 == 1)
                {
                    if ($value2 > 0)
                    {
                        $lastcount = strlen($pieces12[0]);
                        //echo $lastcount;
                        if ($rownumber == $lastcount)
                        {
                            //echo "<font color=red>The words are not connected.</font>";
                            $message_check = "Failure";
                            $final_message = "Words are not connected.";
                            printOutput($action, $message_check, $final_message);
                            $connect = 6;
                        }
                    }
                }
                if ($connect != 6)
                {

                    // check if this is the last move or not

					$remainingTiles = strlen(feed_generate($originalRackTileRow));
					if( ($remainingTiles == 0) && ($rownumber == strlen($originalRackTileRow[$phand])) )
						$challengeLastWordCheck = 1;
					else
						$challengeLastWordCheck = 0;

                    if (($game_type == 'R') || ($challengeLastWordCheck == 1))
                    {

                        // $str_word = "";
                        // $num_word = 0;
                        $unique_word_list = array();

                        for ($i = 0; $i < $fcount - 1; $i = $i + 4)
                        {
                            $w = $pieces[$i];
                            $strU = strtoupper($w);

                            if (!in_array($strU, $unique_word_list))
                            {
                                // $str_word .= "'" . $strU . "',";
                                // $num_word++;
                                array_push($unique_word_list, $strU);
                            }
                        }

                        // $str_word1 = substr($str_word, 0, -1);

						// new word validation check
						$dicCheck = checkDictionary($dictionarysuffix, $unique_word_list); 
						if($dicCheck == '0') {
							$dbcheck = 1;
						} else
							$dbcheck = 0;
						
                        // $query1 = mysql_query("SELECT count(*) cnt FROM `$dictionary` where `words` in ($str_word1)");
                        // $number_word = mysql_fetch_array($query1);
                        // if ($number_word['cnt'] == $num_word)
                        //     $dbcheck = 1;
                        // else
                        // {
                        //     $dbcheck = 0;
                        // }

                    }
                    else
                    {
                        $dbcheck = 1;
                    }
//$dbcheck = 1;///local
                    if ($dbcheck == 0)
                    {
                    	$returnArray['wrong_word'] = $unique_word_list[$dicCheck-1];
                        $message_check = "Failure";
                        $final_message = "Invalid word. Click here.";
                        printOutput($action, $message_check, $final_message);
                    }

                }

                $score_array = array();
                //echo "CONN:".$connect;
                //echo "DBCHECK:".$dbcheck;
                if ($dbcheck == 1)
                {
                    //echo "<font color=red>WORDS ARE VALIDATE WITH DICTIONARY.</font><br>";
                    $MAINWORD = $pieces[0];

					// $total_moves = total_moves_fn($gid);

					$moveid = $total_moves + 1;
					deleteMoveCache($gid, $moveid);


                    $sqlstr = "";
                    for ($i = 0; $i < $fcount - 1; $i = $i + 4)
                    {
                        $w = $pieces[$i];
                        $r = $pieces[$i + 1];
                        $c = $pieces[$i + 2];
                        $d = $pieces[$i + 3];


						$sqlstr .= "('$moveid', '$w', '$gid'),";

                        $array5 = array("word" => $w, "row" => $r, "col" => $c, "dir" => $d);
                        array_push($score_array, $array5);
                    }


					if($game_type == 'C') {
						$sqlstr = substr($sqlstr, 0 , -1);
						mysql_query("delete from `fin_games_words` where gameid = $gid");
						mysql_query("insert into `fin_games_words` (moveid, word, gameid) values $sqlstr");
					}

					$sqlstr = "";
					$tilesUsed = 0;

                    for ($j = 0; $j < $rownumber; $j++)
                    {
                        $ti = $letter_array[$j];
                        $ro = $row_array[$j];
                        $co = $col_array[$j];

                        $tilesUsed++;
                        // $sqlstr .= "('$moveid', '$ti', '$ro', '$co', '$gid'),";
                        $sqlstr .= $ti.",".$ro.",".$co.",".$moveid."|";
                    }

					$sqlstr = substr($sqlstr, 0 , -1);

					if(strlen($board_info) > 0)
						$board_info.="|".$sqlstr;
					else
						$board_info = $sqlstr;

                    // $query = mysql_query("update `$fin_games_boards_table` set `tile_str`=CONCAT(tile_str, '|','$sqlstr') where gameid='$gid'");
					// if(mysql_affected_rows()==0)
                    //     mysql_query("insert into `$fin_games_boards_table` set `tile_str`='$sqlstr', gameid='$gid'");

					// mysql_query("insert into `fin_games_boards` (moveid, tile, row , col, gameid) VALUES $sqlstr");

					unset($sqlstr);

                    $SCORE = score($gid, $moveid, $pid, $score_array, $MAINWORD, $tilesUsed, $row_array, $col_array);

					/////optimised///////
					$today = date("Y-m-d H:i:s");

					if(strlen($move_info) > 0)
                      $move_info.="|".$MAINWORD.",".$pid.",".$today.",".$SCORE.",R,".$letter;////#2481 $letter added
					else
                      $move_info = $MAINWORD.",".$pid.",".$today.",".$SCORE.",R,".$letter;////#2481 $letter added

                    //write_file($gid, $move_info."\r\n".$board_info);/////////////////////done
                    $FileIO->writeFile($gid, "game", $move_info."\r\n".$board_info, $row17['startedon']);////////////added

					/*
					if($total_moves > 0)
					   mysql_query("update `$fin_games_moves_table` set `move_info`=CONCAT(move_info, '|','$move_info') where gameid='$gid'");
				    else
                        mysql_query("insert into `$fin_games_moves_table` set `move_info`='$move_info', gameid='$gid'");
					*/

					$current_move = getCurrentTurn($current_move);
                    mysql_query("update `games` set passes = 0, firstmove = 'n', `current_move`='$current_move',`expirydatetime`= DATE_ADD(NOW(), INTERVAL +14 DAY),lastmove='{$MAINWORD},{$SCORE}' where `game_id`='$gid' ");	////#2481  lastmove added
                    if ($firstMoveMade == 'y')
                    {
                        $type_move = first_game_move;
                    }
                    else
                        $type_move = game_move;

                    $str_letter = "";
                    $str_pos = "";

                    for ($k = 0; $k < $count_tile; $k++)
                    {
                        if ($tiles[$k] == '5')
                        {
                            $str_letter .= $tiles1[$k];
                            $str_pos .= $k;
                        }

                    }

                    $returnArr = generate_tiles($originalRackTileRow, $str_letter, $str_pos, $gid, $pid);

                    $phandscore = $originalRackTileRow[$pscore];
                    $phandscore += $SCORE;

                    $check_hand1 = strlen($returnArr[0]);

					$returnArray = array();
					$returnArray['newRack'] = $returnArr[0];
					$returnArray['currentMove'] = $current_move;
					$returnArray['wordPlayed'] = $MAINWORD;
					$returnArray['lastmoveid'] = $moveid;
					$returnArray['score'] = $SCORE;
                    if ($check_hand1 == '0')
                    {
                        $updatescore = 0;

                        $sqlstr = "";

                        for ($k = 1; $k <= $PLAYER_NO; $k++)
                        {
                            $phand1 = "p" . $k . "hand";
                            $pscore1 = "p" . $k . "score";

                            if ($k != $pid)
                            {
                                $hand_word1 = "";
                                $hand_word = $originalRackTileRow[$phand1];
                                $hand_word1 .= $hand_word;
                                $his_score = $originalRackTileRow[$pscore1];

                                $update_score = score_diff($hand_word1);

                                $his_score -= $update_score;
								$sqlstr .= "`$pscore1`='$his_score',";
                                $updatescore += $update_score;
                                $originalRackTileRow[$pscore1] = $his_score;
                            }

                        }

                        $new_score = $phandscore;
                        $new_score += $updatescore;

						$originalRackTileRow[$pscore] = $new_score;

                        mysql_query("update `$tmp_games_fre_tiles_table` set ". $returnArr[1] . ", $sqlstr `$pscore`='$new_score' where `gameid`='$gid' ");

                    	// update the game winner
                    	$winnerArray = winnerUpdate();
                    	if($WINNER_ID=="-1"){$USER_EMAIL_ARRAY[$WINNER_ID]=$WINNER_ID;}                
						updatePersonalStats($USER_EMAIL_ARRAY['1'],$USER_EMAIL_ARRAY['2'],$USER_EMAIL_ARRAY[$WINNER_ID]);  
						mysql_query("update `games` set `winner`='$WINNER_ID',`winning_score`='$MAXSCORE', `current_move`='0' where  `game_id`='$gid'");
						updateAvgStats();

						updatePlayerRatings($pid);
						mail_gamefinish($gid, $PLAYER_NO);
                        transferCompletedGame($gid);
                        addGameOverToMemCache($gid);
                        $returnArray['gameOver'] = "1";
                        $returnArray['winner'] = $WINNER_ID;
                        $returnArray['p1score'] = $winnerArray[2];
                        $returnArray['p2score'] = $winnerArray[3];
                        $returnArray['p3score'] = $winnerArray[4];
                        $returnArray['p4score'] = $winnerArray[5];
                        $returnArray['winnerNick'] = $winnerArray[6];
						global $winpoints;
						$winpoints = abs($returnArray['p1score'] - $returnArray['p2score']);
                    }
                    else
                    {
                        mysql_query("update `$tmp_games_fre_tiles_table` set  ". $returnArr[1] . ", `$pscore`='$phandscore' where `gameid`='$gid' ");

                        $array = array("type" => $type_move, "move_type" => "R", "move_id" => $moveid,
                            "game_id" => $gid, "player_id2" => $current_move, "player_id1" => $pid);
                            //updateAllCounts($USER_EMAIL_ARRAY);
                       // mailsend($array);

						//sendFBNotif($USER_EMAIL_ARRAY[$current_move]);
                        if (in_array($USER_EMAIL_ARRAY[$current_move], $proxykeys)) {
                        	if (($dictionarysuffix == 'twl') || ($dictionarysuffix == 'sow')) {
                        		global $USER_PASSWORD_ARRAY;
                        		$robot_password = $USER_PASSWORD_ARRAY[$current_move];
                        		$robot_pid = $current_move;
                        		$query_robot = "insert into `robot_turn` set gameid='$gid',dictionary='$dictionarysuffix',userid='{$USER_EMAIL_ARRAY[$current_move]}',password='$robot_password',pid=$robot_pid";
                        		mysql_query($query_robot);
                        	}
                        }else{
                        	///
                        }
                    }

                    //echo "<font color=green>Thank you! Your turn has been validate. And for this move your score is $SCORE. A mail has been sent to your partner.</font>";
                    $message_check = "Success";
                    $final_message = "Thank you! Your turn has been validate. And for this move your score is $SCORE. A mail has been sent to your partner.";
                }

            }

        }// End of if for checking sequence

        /////////end of  word making///////

        if ($val123 == 5)
        {
            //echo "<font color=red>One tile must be in middle position in the board.</font>";
            $message_check = "Failure";
            $final_message = "Start from center of board.";
            printOutput($action, $message_check, $final_message);
        }

    }
	else if ($action == "SWAP")
    {

        if ($current_move == $pid)
        {
            unset($len_string);
            unset($string);

            $cnt = 0;
			$cnt = $originalRackTileRow["tile_a"]+$originalRackTileRow["tile_b"]+$originalRackTileRow["tile_c"]+$originalRackTileRow["tile_d"]+$originalRackTileRow["tile_e"]+$originalRackTileRow["tile_f"]+$originalRackTileRow["tile_g"]+$originalRackTileRow["tile_h"]+$originalRackTileRow["tile_i"]+$originalRackTileRow["tile_j"]+$originalRackTileRow["tile_k"]+$originalRackTileRow["tile_l"]+$originalRackTileRow["tile_m"]+$originalRackTileRow["tile_n"]+$originalRackTileRow["tile_o"]+$originalRackTileRow["tile_p"]+$originalRackTileRow["tile_q"]+$originalRackTileRow["tile_r"]+$originalRackTileRow["tile_s"]+$originalRackTileRow["tile_t"]+$originalRackTileRow["tile_u"]+$originalRackTileRow["tile_v"]+$originalRackTileRow["tile_w"]+$originalRackTileRow["tile_x"]+$originalRackTileRow["tile_y"]+$originalRackTileRow["tile_z"]+$originalRackTileRow["tile_blank"];

		    $hand="p".$pid."hand";

            if ($cnt < 7)
            {
                $message_check = "Failure";
                $final_message = "Too few tiles left for SWAP.";
            }
            else
            {
            	$finalFlag = checkTilesForSwap($str, $originalRackTileRow[$hand]);

                if ($finalFlag == "false") {

                    $message_check = "Failure";
                    $final_message = "Invalid tiles.";

                } else {

					$returnArray = array();

                    $returnArray['newRack'] = swap_tiles($originalRackTileRow, $str, $gid, $pid);
					$tilesToSwapLength = strlen($str);

					$current_move = getCurrentTurn($current_move);

					$returnArray['currentMove'] = $current_move;
					$returnArray['tilesSwapped'] = $tilesToSwapLength;

                    $message_check = "Success";
                    $final_message = "You have swapped your tiles successsfully";

                    mysql_query("update `games` set passes = 0, firstmove = 'n', `current_move`='$current_move', `expirydatetime`= DATE_ADD(NOW(), INTERVAL +14 DAY),lastmove='SWAP,0' where `game_id`='$gid' ");	////#2481 lastmove is added

					/////optimised/////////////
					// $total_moves = total_moves_fn($gid);
                    $moveid = $total_moves + 1;
					$today = date("Y-m-d H:i:s");


					if(strlen($move_info) > 0)
						$move_info.="|".$tilesToSwapLength.",".$pid.",".$today.",0,S,".$originalRackTileRow[$hand];/////#2481 $originalRackTileRow[$hand] added
					else
						$move_info = $tilesToSwapLength.",".$pid.",".$today.",0,S,".$originalRackTileRow[$hand];/////#2481 $originalRackTileRow[$hand] added

                    //write_file($gid, $move_info."\r\n".$board_info);//////////////done
                    $FileIO->writeFile($gid, "game", $move_info."\r\n".$board_info, $row17['startedon']);//////////added

					/*
					$query = mysql_query("update `$fin_games_moves_table` set `move_info`=CONCAT(move_info, '|','$move_info') where gameid='$gid'");
					if(mysql_affected_rows()==0)
                        mysql_query("insert into `$fin_games_moves_table` set `move_info`='$move_info', gameid='$gid'");
					*/

                    deleteMoveCache($gid, $moveid);

					if($game_type == 'C') {
						mysql_query("delete from `fin_games_words` where gameid = $gid");
						mysql_query("insert into `fin_games_words` set `moveid`='$moveid',word='$tilesToSwapLength', gameid = $gid ");
					}

					$returnArray['lastmoveid'] = $moveid;

                    $array = array("type" => "game_move", "move_type" => "S", "move_id" => $moveid,
                        "game_id" => $gid, "player_id2" => $current_move, "player_id1" => $pid);
                    updateAllCounts($USER_EMAIL_ARRAY);
                    //mailsend($array);

					//sendFBNotif($USER_EMAIL_ARRAY[$current_move]);
                    if (in_array($USER_EMAIL_ARRAY[$current_move], $proxykeys)) {
                    	if (($dictionarysuffix == 'twl') || ($dictionarysuffix == 'sow')) {
                    		global $USER_PASSWORD_ARRAY;
                    		$robot_password = $USER_PASSWORD_ARRAY[$current_move];
                    		$robot_pid = $current_move;
                    		$query_robot = "insert into `robot_turn` set gameid='$gid',dictionary='$dictionarysuffix',userid='{$USER_EMAIL_ARRAY[$current_move]}',password='$robot_password',pid=$robot_pid";
                    		mysql_query($query_robot);
                    	}
                    }else{
                    	///
                    }
                }
            }

        }
        else
        {
            //echo "<font color=red>This is not your turn.</font>";
            $message_check = "Failure";
            $final_message = "It is not your turn.";
        }

    }
	else if ($action == "PASS")
    {

        if ($current_move == $pid)
        {
        	$returnArray = array();
			$current_move = getCurrentTurn($current_move);
			$returnArray['currentMove'] = $current_move;

            $message_check = "Success";
            $final_message = "You have passed your turn successsfully";
			$passCount++;

            mysql_query("update `games` set passes = $passCount, firstmove = 'n', `current_move`='$current_move',`expirydatetime`= DATE_ADD(NOW(), INTERVAL +14 DAY),lastmove='PASS,0' where `game_id`='$gid' ");	////#2481 lastmove added

			/////optimised/////////////
			// $total_moves = total_moves_fn($gid);
            $moveid = $total_moves + 1;
			$today = date("Y-m-d H:i:s");

			if(strlen($move_info) > 0)
				$move_info.="|PASS,".$pid.",".$today.",0,P,".$originalRackTileRow["p".$pid."hand"];////#2481 $originalRackTileRow["p".$pid."hand"] added
			else
				$move_info = "PASS,".$pid.",".$today.",0,P,".$originalRackTileRow["p".$pid."hand"];////#2481 $originalRackTileRow["p".$pid."hand"] added

			//write_file($gid,$move_info."\r\n".$board_info);///////////////////done
			$FileIO->writeFile($gid, "game", $move_info."\r\n".$board_info, $row17['startedon']);////////////////added

			/*
			$query = mysql_query("update `$fin_games_moves_table` set `move_info`=CONCAT(move_info, '|','$move_info') where gameid='$gid'");
			if(mysql_affected_rows()==0)
				mysql_query("insert into `$fin_games_moves_table` set `move_info`='$move_info', gameid='$gid'");
			*/

            deleteMoveCache($gid, $moveid);

            $returnArray['lastmoveid'] = $moveid;

			$remainingTiles = strlen(feed_generate($originalRackTileRow));
			if( ($passCount > 5) || ($remainingTiles == 0  &&  $passCount == $PLAYER_NO))
			{
				// this means everyone has passed and no tiles are left in the bag
				// or, 6 passes have been made
				// so we end the game

				$score_array=array("1"=>$originalRackTileRow['p1score'],"2"=>$originalRackTileRow['p2score'],"3"=>$originalRackTileRow['p3score'],"4"=>$originalRackTileRow['p4score']);
		        for($i=1;$i<=$PLAYER_NO;$i++)
				{
					$playerhand="p".$i."hand";
					$str_score="p".$i."score";
					$hand_tile=$originalRackTileRow[$playerhand];
					$score=score_diff($hand_tile);
					$score_array[$i]-=$score;

					for($j=1;$j<=$PLAYER_NO;$j++)
					{
						if($i!=$j)
						{
							$score_array[$j]+=$score;
						}

					}

				}

                $originalRackTileRow[p1score]=$score_array[1];
				$originalRackTileRow[p2score]=$score_array[2];
				$originalRackTileRow[p3score]=$score_array[3];
				$originalRackTileRow[p4score]=$score_array[4];

				mysql_query("update $tmp_games_fre_tiles_table set `p1score`='$score_array[1]',`p2score`='$score_array[2]',`p3score`='$score_array[3]',`p4score`='$score_array[4]' where `gameid`='$gid'");

                // update the game winner
                $winnerArray = winnerUpdate();
                if($WINNER_ID=="-1"){$USER_EMAIL_ARRAY[$WINNER_ID]=$WINNER_ID;}
				updatePersonalStats($USER_EMAIL_ARRAY['1'],$USER_EMAIL_ARRAY['2'],$USER_EMAIL_ARRAY[$WINNER_ID]);  
                addGameOverToMemCache($gid);
				updateAvgStats();
				$returnArray['gameOver'] = "1";
				$returnArray['winner'] = $WINNER_ID;				
                $returnArray['p1score'] = $winnerArray[2];
                $returnArray['p2score'] = $winnerArray[3];
                $returnArray['p3score'] = $winnerArray[4];
                $returnArray['p4score'] = $winnerArray[5];
                $returnArray['winnerNick'] = $winnerArray[6];
                mysql_query("update `games` set `winner`='$WINNER_ID',`winning_score`='$MAXSCORE', `current_move`='0' where  `game_id`='$gid'");
                updatePlayerRatings($pid);
                mail_gamefinish($gid, $PLAYER_NO);
                transferCompletedGame($gid);
			}
            else
            {
                $array = array("type" => "game_move", "move_type" => "P", "move_id" => $moveid,
                    "game_id" => $gid, "player_id2" => $current_move, "player_id1" => $pid);
             
               // mailsend($array);
				//sendFBNotif($USER_EMAIL_ARRAY[$current_move]);
                if (in_array($USER_EMAIL_ARRAY[$current_move], $proxykeys)) {
                	if (($dictionarysuffix == 'twl') || ($dictionarysuffix == 'sow')) {
                		global $USER_PASSWORD_ARRAY;
                		$robot_password = $USER_PASSWORD_ARRAY[$current_move];
                		$robot_pid = $current_move;
                		$query_robot = "insert into `robot_turn` set gameid='$gid',dictionary='$dictionarysuffix',userid='{$USER_EMAIL_ARRAY[$current_move]}',password='$robot_password',pid=$robot_pid";
                		mysql_query($query_robot);
                	}
                }else{
                	///
                }
            }

            $message_check = "Success";
        }
        else
        {
            $message_check = "Failure";
            $final_message = "It is not your turn";
        }

    } else if($action == "NEXTGAME")/////#2481 added on 10_1_13
    {
    	$returnArray = array();
    	
    	$sql = "select games from users_games where email = '{$fb_sig_user}'";
    	$rs = mysql_query($sql);
        $row = mysql_fetch_array($rs);
        $gamelist = substr($row['games'],1,-1);
        $gamelistARR = explode(',', $gamelist);
		if (($key = array_search($gid, $gamelistARR)) !== false) {
		    unset($gamelistARR[$key]);
		}
		
        $game_found = false;
        //print_r ($smaller_arr);print "<br/>";
        //print_r ($bigger_array);print "<br/>";     
        if (count($gamelistARR)>0){ 	
	       	$sql2 = "SELECT game_id,current_move,users_info from games WHERE game_id IN (".implode(",",$gamelistARR).") AND current_move <> 0";      	       	
	       	$res2 = mysql_query($sql2);
	       	while ($row_game = mysql_fetch_assoc($res2)){
	       		//print_r ($row_game);print "<br/>";
	       		$users_info = array();
	       		$users_info = explode("|",$row_game['users_info']);
	       		$current_users_info = $users_info[$row_game['current_move']-1];
	       		//echo "--$current_users_info---";print "<br/>";
	       		$current_users_info_arr = array();
	       		$current_users_info_arr = explode(",", $current_users_info);
	       		if ($current_users_info_arr[0] == $fb_sig_user){
	       			$return_gid = $row_game['game_id'];
	       			$return_pid = $row_game['current_move'];
	       			$return_password = $current_users_info_arr[1];
	       			$game_found = true;
	       			
	       			$returnArray['action'] = $action;
	       			$returnArray['gid'] = $return_gid;
	       			$returnArray['pid'] = $return_pid;
	       			$returnArray['password'] = $return_password;
	       			$message_check = "Success";
	       			break;
	       		}else{
	       			continue;
	       		}
	       	}
        }
        
    	if (!$game_found){
    		$returnArray['action'] = $action;
		    $returnArray['gid'] = '';
		    $returnArray['pid'] = '';
		    $returnArray['password'] = '';
		    $message_check = "Success";
            //$final_message = "No active Game";
    	}      
    } else if ($action == "RESIGN") {
		if($jsondata['forcewin'] == 1) {
			//start copy date:2-8-10
			include_once("mob_resign_function.php");
			$return = startForceWin($gid, $pid, $password);
                        if($return["check"] == "Success" && $return["deny"] == "0") {
                            $returnArray['gameOver'] = "1";
                            $WINNER_ID = $pid;
                        }
			printOutput($action, $return["check"], $return["message"]);
			//end copy
		}
		$allowresign = 0;
	    if(count($USER_NOTRESIGNED_ARRAY) <= 2)   {
	    	$allowresign = 1;
	    }  else   {
	    	if ($current_move == $pid)
	    	{
	        	$allowresign = 1;
	        }  else  {
	               $message_check = "Failure";
	               $final_message = "It is not your turn.";
	        }
	   	}	
        if ($allowresign == 1)
        {
            mysql_query("update `users` set `resign`='y' where `game_id`='$gid' and `player_id`='$pid' ");

			// add this user to the resigned array
			array_push($USER_RESIGN_ARRAY, $pid);

			// remove this user from the not resigned user list
			$tmpArr = array();
			foreach($USER_NOTRESIGNED_ARRAY as $val) {
				if($val != $pid) {
					array_push($tmpArr, $val);
				}
			}
			$USER_NOTRESIGNED_ARRAY = $tmpArr;

            if (count($USER_NOTRESIGNED_ARRAY) < 2)
            {
            	$tmpid = $USER_NOTRESIGNED_ARRAY[0];
				$email = $USER_EMAIL_ARRAY[$USER_NOTRESIGNED_ARRAY[0]];

            	mysql_query("update `games` set `winner`='$tmpid', `current_move`='0', `users_info`='$UPDATE_RESIGN_STRING' where  `game_id`='$gid'");
				mysql_query("update users_stats set won = won + 1 where email = '$email'");

                                $returnArray['gameOver'] = "1";
				$WINNER_ID = $tmpid;
				updatePlayerRatings($pid);
				updatePersonalStats($USER_EMAIL_ARRAY['1'],$USER_EMAIL_ARRAY['2'],$USER_EMAIL_ARRAY[$WINNER_ID]);  
				updateAvgStats();
				transferCompletedGame($gid);
            } else {

				$current_move = getCurrentTurn($current_move);
                mysql_query("update `games` set passes = 0, `current_move`='$current_move',`expirydatetime`= DATE_ADD(NOW(), INTERVAL +14 DAY),`users_info`='$UPDATE_RESIGN_STRING'  where `game_id`='$gid' ");
            	resign($gid, $pid);
				sendFBNotif($USER_EMAIL_ARRAY[$current_move]);
            }

		    mysql_query("UPDATE users_stats set lost = lost + 1 where email = '$loggedinEmail'");

            $array = array("type" => "Resign", "game_id" => $gid, "player_id2" => $current_move,
                "player_id1" => $pid);
                updateAllCounts($USER_EMAIL_ARRAY);
           // mailsend($array);

            $message_check = "Success";
            $final_message = "You have Resigned.";
        }
    }
	else if ($action == "CHALLENGE")
    {

        if ($current_move == $pid)
        {
            if ($game_type == 'R')
            {
                //echo "<font color=red>Challenge not allowed.</font>";
                $message_check = "Failure";
                $final_message = "Challenge not allowed.";
            }
            else
            {
                //////////////////////////////////updates for challenge//////////////
                $flag = "false";
                $dictionary = "dictionary_" . $dictionary;
				///optimised/////

                // $total_moves = total_moves_fn($gid);
				$mid = $total_moves;
				$exp2 = explode(",",$exp_move[$total_moves-1]);

                //if($result_row['move_type'] == 'R')
				if($exp2[4] == 'R')
                {
                    $array = array();
                    $wordlist = "";
                    $wordlist1 = "";
                    $word_num = 0;
					///////optimised//////
                    //$queryUp = mysql_query("select word from `fin_games_words` where `moveid`='$mid'");
					$queryUp = mysql_query("select word from `fin_games_words` where `moveid`='$mid' and gameid = '$gid'");
                    while ($rowUp = mysql_fetch_array($queryUp))
                    {
                    	$val = $rowUp['word'];
                        if (!in_array($rowUp['word'], $array))
                        {
                            array_push($array, $rowUp[word]);
                            $wordlist = $wordlist . $val . ",";
                            $wordlist1 .= "'" . $val . "'" . ",";
                            $word_num++;
                        }
                    }

                    $wordlist = substr($wordlist, 0, strlen($wordlist) - 1);
                    $wordlist1 = substr($wordlist1, 0, strlen($wordlist1) - 1);

					// new word validation check
					if(checkDictionary($dictionarysuffix, $array) == '0') {
						$flag = "false";
					} else
						$flag = "true";

                    //$result_query = mysql_query("SELECT count(*) cnt FROM `$dictionary` where `words` in($wordlist1)");
                    //$number_word = mysql_fetch_array($result_query);

                    //if ($number_word['cnt'] == $word_num)
                    //    $flag = "false";
                    //else
                    //{
                    //    $flag = "true";
                    //}

                    if ($flag == "true") // mismatch.
                    {
                         ///////////////optimised//////////////
                        //$total_move_score = $result_row[total_move_score];
						 $total_move_score = $exp2[3];

                        //////optimised////////
                        $exp2[4]='C';
						$exp2[3]=0;
						$comma_separated = implode(",", $exp2);
						$exp_move[$total_moves-1] = $comma_separated;
						$final_move_str = implode("|", $exp_move);

                        // $result3 = mysql_query("UPDATE `$fin_games_moves_table` SET `move_info`='$final_move_str' WHERE  gameid='$gid'");
						deleteMoveCache($gid, "999999999999");
                        // $player_id = $USER_PLAYERID_ARRAY[$result_row['playedby']];
						///////////////optimised//////////////
						//$player_id = $result_row['playedby'];
						$player_id = $exp2[1];

                        $prehand = "p" . $player_id . "hand";
                        $p_prev_rack = "p" . $player_id . "prev_rack";
                        $tiles_boards = array();

						// $result = mysql_query("select tile_str from `$fin_games_boards_table` where `gameid`='$gid'");
                        // $row = mysql_fetch_array($result);

				        $temp_arr=explode('|',$board_info);
						$newstring="";
				        foreach($temp_arr as $val)
				        {
							$oldval = "";

								 $temp_arr1=explode(',',$val);
								 if ($temp_arr1[0] == strtolower($temp_arr1[0]))
								 {
								 	$oldval = $temp_arr1[0];
									$temp_arr1[0] = "blank";
								 }

								if ($tiles_boards[$temp_arr1[0]] > 0)
									$tiles_boards[$temp_arr1[0]] += 1;
								else
									$tiles_boards[$temp_arr1[0]] = 1;

								if($temp_arr1[3]!=$mid)
								{
									if(strlen($oldval) > 0)
										$temp_arr1[0] = $oldval;

									$string=implode(',',$temp_arr1);
									$newstring.=$string."|";
								}

					    }

                        $newstring = substr($newstring, 0, -1);

                        /*
                        $result = mysql_query("select tile from `fin_games_boards` where `moveid`='$mid'");
                        while ($row = mysql_fetch_array($result))
                        {
                            if ($row['tile'] == strtolower($row['tile']))
                            {
                                $row['tile'] = "blank";
                            }

                            if ($tiles_boards[$row['tile']] > 0)
                                $tiles_boards[$row['tile']] += 1;
                            else
                                $tiles_boards[$row['tile']] = 1;

                        }
                        */

                        $prescore = "p" . $player_id . "score";
                        $SCORE = $originalRackTileRow[$prescore];
                        $score_diff = $SCORE - $total_move_score;

                        $c_rack = $originalRackTileRow[$prehand];
                        $prev_rack = $originalRackTileRow[$p_prev_rack];
                        $len_c_rack = strlen($c_rack);
                        $len_prev_rack = strlen($prev_rack);

                        $tiles = array();
                        $tiles_prev = array();
                        $tiles_not_used = array();
                        $tiles_bag = array();
                        $tiles_current = array();

                        for ($i = 0; $i < $len_prev_rack; $i++)
                        {
                            if ($tiles_prev[$prev_rack[$i]] > 0)
                                $tiles_prev[$prev_rack[$i]] += 1;

                            else
                                $tiles_prev[$prev_rack[$i]] = 1;

                        }
                        //echo "Tiles previous :  ".print_r($tiles_prev)."<br>";
                        foreach ($tiles_prev as $key1 => $value1)
                        {
                            foreach ($tiles_boards as $key2 => $value2)
                            {
                                if ($key1 == $key2)
                                {
                                    if ($value1 >= $value2)
                                    {
                                        $diff = $value1 - $value2;
                                        $tiles[$key1] = $diff;
                                    }
                                    /* else
                                    {
                                    $tiles[$key1]=0;
                                    } */
                                    break;
                                }
                                else
                                {
                                    $tiles[$key1] = $value1;
                                }
                            }
                        }
                        //echo "check Tiles Boards with tiles previous:  ".print_r($tiles)."<br>";
                        foreach ($tiles as $key => $value)
                        {
                            if ($value != 0)
                            {
                                $tiles_not_used[$key] = $value;
                            }
                        }
                        //echo "Tiles not used :  ".print_r($tiles_not_used)."<br>";

                        for ($i = 0; $i < $len_c_rack; $i++)
                        {
                            if ($tiles_current[$c_rack[$i]] > 0)
                                $tiles_current[$c_rack[$i]] += 1;

                            else
                                $tiles_current[$c_rack[$i]] = 1;

                        }
                        //echo "Tiles current :  ".print_r($tiles_current)."<br>";

                        $num_notused = count($tiles_not_used);
                        if ($num_notused != 0)
                        {
                            foreach ($tiles_current as $key1 => $value1)
                            {
                                foreach ($tiles_not_used as $key2 => $value2)
                                {
                                    if ($key1 == $key2)
                                    {
                                        if ($value1 >= $value2)
                                        {
                                            $diff = $value1 - $value2;
                                            $tiles_bag[$key1] = $diff;
                                        }
                                        /* else
                                        {
                                        $tiles_bag[$key1]=0;
                                        } */
                                        break;
                                    }
                                    else
                                    {
                                        $tiles_bag[$key1] = $value1;
                                    }

                                }
                            }
                        }
                        else
                        {
                            $tiles_bag = $tiles_current;
                        }
                        //echo "Tiles Bag :  ".print_r($tiles_bag)."<br>";
                        $sql_string = "";
                        foreach ($tiles_bag as $key => $value)
                        {
                            if ($value != 0)
                            {
                                if ($key == "*")
                                    $key = "blank";
                                $sql_string .= "`tile_" . strtolower($key) . "`=tile_" . strtolower($key) . "+" .
                                    $value . ",";
                            }
                        }

						$prev_rack = $originalRackTileRow[$p_prev_rack];

                        if (strlen($sql_string) > 0)
                        {
                            $sql_string = substr($sql_string, 0, -1);
                            mysql_query("UPDATE `$tmp_games_fre_tiles_table` SET `$prescore`='$score_diff', $prehand='$prev_rack', " . $sql_string . " WHERE gameid='$gid' ");
                        } else {
                        	mysql_query("UPDATE `$tmp_games_fre_tiles_table` SET `$prescore`='$score_diff', $prehand='$prev_rack' WHERE gameid='$gid' ");
                        }

                        // mysql_query("UPDATE `$fin_games_boards_table` set tile_str = '$newstring' where `gameid`='$gid'");

						//write_file($gid,$final_move_str."\r\n".$newstring);//////////////////////done
						$FileIO->writeFile($gid, "game", $final_move_str."\r\n".$newstring, $row17['startedon']);////////////////added

						mysql_query("update `games` set lastmove='{$exp2[0]},{$exp2[3]}' where `game_id`='$gid' ");	

                        $array = array("type" => "Challenge", "game_result" => "winner", "game_id" => $gid,
                            "player_id2" => $player_id, "player_id1" => $pid, "word" => $wordlist);
                       updateAllCounts($USER_EMAIL_ARRAY);
                       // mailsend($array);
						$returnArray = array();
						$returnArray['currentMove'] = $pid;

                        $message_check = "Success";
                    }
                    else
                    {
                        if ($pid == $PLAYER_NO)
                            $current_move = 1;
                        else
                            $current_move = $pid + 1;


					   /////////optimised

						$moveid = $mid + 1;

						$today = date("Y-m-d H:i:s");
						if(strlen($move_info) > 0)
							$move_info.="| ,".$pid.",".$today.",0,C";
						else
							$move_info = " ,".$pid.",".$today.",0,C";

						//write_file($gid,$move_info."\r\n".$board_info);//////////////////done
						$FileIO->writeFile($gid, "game", $move_info."\r\n".$board_info, $row17['startedon']);//////////////added

					    // mysql_query("update `$fin_games_moves_table` set `move_info`=CONCAT(move_info, '|','$move_info') where gameid='$gid'");
                        deleteMoveCache($gid, $moveid);

                        mysql_query("update `games` set passes = 0, firstmove = 'n', `current_move`='$current_move',`expirydatetime`= DATE_ADD(NOW(), INTERVAL +14 DAY)  where  `game_id`='$gid'");
                        mysql_query("delete from fin_games_words where gameid = $gid ");
                        mysql_query("insert into `fin_games_words` set `moveid`='$moveid',`word`='', gameid = $gid ");

                        $array = array("type" => "Challenge", "game_result" => "loser", "game_id" => $gid,
                            "player_id2" => $current_move, "player_id1" => $pid, "word" => $wordlist);
                        mailsend($array);

						sendFBNotif($USER_EMAIL_ARRAY[$current_move]);
						
						$returnArray = array();                    
						$returnArray['currentMove'] = $current_move;
						
                        $message_check = "Failure";
                        $final_message = "Challenge is invalid!";
                    }
                }
                else
                {
                    //echo "Challenge not allowed.";
                    $message_check = "Failure";
                    $final_message = "You cannot challenge this move.";
                }
            }
        }
        else
        {
            //echo "<font color=red>This is not your turn.</font>";
            $message_check = "Failure";
            $final_message = "It is not your turn.";
        }

    }


}//End of else part if action is success

if ($action == "DELETE")
{
	// check if less than 4 moves are played
	/*$res = mysql_query("select count(*) cnt from fin_games_moves where gameid = $gid");
	$row = mysql_fetch_array($res);*/
	//if($row['cnt'] < 4) {
      if($total_moves < 4) {
		$allowdelete = 1;
	} else
		$allowdelete = 0;

	if($allowdelete == 1) {
        delete($gid, $pid);
        $message_check = "Success";
		$final_message = "Game has been deleted.";
	} else {
        $message_check = "Failure";
        $final_message = "More than 4 moves, cannot Delete.";		
	}
}
else if ($action == "MESSAGE")
{
	if($jsondata['encrypted'] == 'y') {
	            $message = base64_decode($message);
	            $message = str_replace("'", "\'", $message);
	            sendMessage($gid, $pid, $message, $loggedinUsername);
	    } else {
	            sendMessage($gid, $pid, urldecode($message), $loggedinUsername);
	        }
	    $message_check = "Success";
}

printOutput($action, $message_check, $final_message);

function printOutput($action, $message_check, $final_message)
{
	$jsonArr = array();
	global $returnArray;
	global $WINNER_ID, $pid, $gid;
	global $bingo_array, $facebookclient;
	global $fb_sig_user, $winpoints, $sendfacebook, $USER_EMAIL_ARRAY;
	global $USERS_INFO;
	
	$str = "";

	if(is_array($returnArray)) {
		foreach($returnArray as $key => $val) {
			$str .= "&$key=$val";
			$jsonArr[$key] = (string)$val; //json
		}
	}
	if(($action=="MOVE" || $action=="PASS") && $jsonArr["gameOver"] != 1) { $jsonArr["gameOver"] = "0"; }
	
	///////////////////////////////////
	$jsonArr["action"] = $action;
	$jsonArr["check"] = $message_check;
	///////////////////////////////////
	
    $xmlstring = "&action=$action&check=$message_check";
    if ($message_check == 'Failure')
    {
        $xmlstring .= "&message=$final_message";
		$jsonArr['message'] = $final_message;
    }

	
	$bingostr = "";
	
	if(count($bingo_array) > 0) {
		//update text file
		//$filename =  get_xml_ach_filename($gid);/////////////done
		$game_data_file_arr = array();

		/*if(file_exists($filename)) {///////////done
			$serialize_file = file($filename);///////////////
			$game_data_file_arr = unserialize($serialize_file[0]);/////////////////
		}//////////////////////*/
		
		global $FileIO;///////////////////////added
		//$inputstring = $FileIO->getFile($gid,"achievement");//////added
		$game_data_file_arr = unserialize($inputstring[0]);////////added
		
		$user_bingo_count = 1;
		$prebingos = "";
		if(count($game_data_file_arr)>0 && $game_data_file_arr[$fb_sig_user]) {
			foreach($game_data_file_arr[$fb_sig_user] as $per_user_data) {
				if($per_user_data!="") {
					$user_bingo_count = count(explode("|",$per_user_data))+1;
					$prebingos = $per_user_data;
				} else {
					$user_bingo_count = 1;
					$prebingos = "";
				}
			}
		}
		if($user_bingo_count>1) {
			$bingostr ="&conbingos=".$user_bingo_count . "&prebingos=" . $prebingos . "|";
		} else {
			$bingostr ="&conbingos=".$user_bingo_count;
		}
		
		if(!$game_data_file_arr[$fb_sig_user]) {
			$game_data_file_arr[$fb_sig_user] = array();
			$game_data_file_arr[$fb_sig_user][] = "$bingo_array[0],$bingo_array[1]";
		} else {
			if($game_data_file_arr[$fb_sig_user][count($game_data_file_arr[$fb_sig_user])-1] == "") {
				$game_data_file_arr[$fb_sig_user][] = "$bingo_array[0],$bingo_array[1]";
			} else {
				$game_data_file_arr[$fb_sig_user][count($game_data_file_arr[$fb_sig_user])-1] .= "|$bingo_array[0],$bingo_array[1]";
			}
		}
		//$FileIO->writeFile($gid,"achievement",serialize($game_data_file_arr));//////////////added
		/*$fh = fopen($filename, 'w');////////////done
		fwrite($fh, serialize($game_data_file_arr));///////////////////
		fclose($fh);///////////////////
		chmod($filename, 0777);////////////////*/
	} else if($action == "MOVE"){
		//$filename = get_xml_ach_filename($gid);/////////////////done
		$game_data_file_arr = array();
		/*if(file_exists($filename)) {//////////////////////done
			$serialize_file = file($filename);///////////////
			$game_data_file_arr = unserialize($serialize_file[0]);///////////////////////
		}/////////////////////*/
		global $FileIO;///////////////////////added
		//$inputstring = $FileIO->getFile($gid,"achievement");////////////added
		$game_data_file_arr = unserialize($inputstring[0]);////////added
		
		if(!$game_data_file_arr[$fb_sig_user]) {
			$game_data_file_arr[$fb_sig_user] = array();
			$game_data_file_arr[$fb_sig_user][] = "";
		} else
			if($game_data_file_arr[$fb_sig_user][count($game_data_file_arr[$fb_sig_user])-1] != "") {
				$game_data_file_arr[$fb_sig_user][] = "";
			}
		//$FileIO->writeFile($gid,"achievement",serialize($game_data_file_arr));/////////////added		
		/*$fh = fopen($filename, 'w');/////////////////done
		fwrite($fh, serialize($game_data_file_arr));////////////////////////
		fclose($fh);//////////////////////////////////
		chmod($filename, 0777);////////////////////*/
	}

	$gamefinishstr ="";
	
	if($returnArray['gameOver'] == 1) {
		$final_score_arr = array();
		$game_user_arr = explode("|",$USERS_INFO);
		
		for($i=0;$i<count($game_user_arr);$i++) {
			$game_user_info = explode(",",$game_user_arr[$i]);
			$a_index = $i+1;
			$final_score_arr[$game_user_info[0]]= $returnArray["p{$a_index}score"];
		}
		arsort($final_score_arr);
		
		$final_score_keys = array_keys($final_score_arr);

		$filesavetxt = array();
		for($i=1;$i<count($final_score_arr);$i++) {
			if(($final_score_arr[$final_score_keys[0]]-$final_score_arr[$final_score_keys[$i]]) == 1) {
				if($final_score_keys[0] == $fb_sig_user) {
					$gamefinishstr = "&winby=1";
				} else if($final_score_keys[$i] == $fb_sig_user) {
					$gamefinishstr = "&lostby=1";
				}
				if(!$filesavetxt) {
					$filesavetxt[$final_score_keys[0]] = "winby,{$final_score_arr[$final_score_keys[0]]},1";
					$filesavetxt[$final_score_keys[$i]]= "lostby,{$final_score_arr[$final_score_keys[$i]]},1";
				} else {
					$filesavetxt[$final_score_keys[$i]]= "lostby,{$final_score_arr[$final_score_keys[$i]]},1";
				}
			} else if(($final_score_arr[$final_score_keys[0]]-$final_score_arr[$final_score_keys[$i]]) == 2) {
				if($final_score_keys[0] == $fb_sig_user) {
					$gamefinishstr = "&winby=2";
				} else if($final_score_keys[$i] == $fb_sig_user) {
					$gamefinishstr = "&lostby=2";
				}
				if(!$filesavetxt) {
					$filesavetxt[$final_score_keys[0]] = "winby,{$final_score_arr[$final_score_keys[0]]},2";
					$filesavetxt[$final_score_keys[$i]] = "lostby,{$final_score_arr[$final_score_keys[$i]]},2";
				} else {
					$filesavetxt[$final_score_keys[$i]] = "lostby,{$final_score_arr[$final_score_keys[$i]]},2";
				}
			}
		}

		if($gamefinishstr) {
			//update text file
			//$filename = get_xml_ach_filename($gid);///////////////////done
			$game_data_file_arr = array();
			/*if(file_exists($filename)) {///////////////////////done
				$serialize_file = file($filename);//////////////////
				$game_data_file_arr = unserialize($serialize_file[0]);///////////////////////
			}////////////////////////*/
			global $FileIO;///////////////////////added
			//$inputstring = $FileIO->getFile($gid,"achievement");////////////added
			$game_data_file_arr = unserialize($inputstring[0]);////////added
			
			foreach($filesavetxt as $fuid=>$filetxt) {
				$game_data_file_arr[$fuid][] = $filetxt;
			}
			
			//$FileIO->writeFile($gid,"achievement",serialize($game_data_file_arr));/////////////added
			/*$fh = fopen($filename, 'w');//////////////done
			fwrite($fh, serialize($game_data_file_arr));//////////////////////////

			fclose($fh);/////////////////////////////
			chmod($filename, 0777);/////////////////////*/
		}
	}
	/*
		end
	*/

	// archiving logic
    global $game_type,$language;
    	
	if($returnArray['gameOver'] == 1) {
		
		$gameplayers = array();
		$user_info_arr = explode("|",$USERS_INFO);
		for($i=0;$i<count($user_info_arr);$i++) {
			$uinfo = explode(",",$user_info_arr[$i]);
			$gameplayers[$i+1] = array("uid"=>$uinfo[0],"name"=>$uinfo[2],"password"=>$uinfo[1]);
		}
		
		//include_once("archive_file_path.php");///////////////////////////////done
		/*
		foreach($gameplayers as $kpid=>$data)
		{
			//$fileinfo  = get_archive_file_path($data['uid']);//////////////////////////////////done
			//$serverdir = $fileinfo[0]; $altserverdir = $fileinfo[1]; $filename = $fileinfo[2];///////////done

			//if(!is_dir($serverdir)) { $filename = $altserverdir; }/////////////////////////////done
			$archive_file_arr = array();

			/*if(file_exists($filename)) {/////////////////done
				$serialize_file = file($filename);/////////////////////
				$archive_file_arr = unserialize($serialize_file[0]);/////////////////////////////
			}/////////////////////////
			
			global $FileIO;///////////////////////added
			$inputstring = $FileIO->getFile($data['uid'],"archive");////////////added
			$archive_file_arr = unserialize($inputstring[0]);////////added
			
			
			if($WINNER_ID == -1)
				$winneruid = -1;
			else
				$winneruid = $gameplayers[$WINNER_ID]['uid'];
			
			$modifiedPlr = "";

			foreach($gameplayers as $innerPid=>$innerData) {
				if($data['uid'] == $innerData['uid']) {
					$modifiedPlr .= "{$innerData['uid']},{$innerData['name']},{$innerData['password']}|";
				} else {
					$modifiedPlr .= "{$innerData['uid']},{$innerData['name']}|";
				}
			}
			
			$modifiedPlr = substr($modifiedPlr,0,-1);
			
			$archive_file_arr[] = array("gid"=>$gid,"winuid"=>$winneruid,"players"=>$modifiedPlr,"date"=>strtotime("now"),"gtype"=>$game_type,"lang"=>$language);
			
			$FileIO->writeFile($data['uid'],"archive",serialize($archive_file_arr));/////////////added
			/*$file = fopen($filename, 'w');////////////////////////////////done
			fwrite($file, serialize($archive_file_arr));//////////////////////////////
			fclose($file);///////////////////////////
			chmod($filename, 0777);/////////////////////////
		}*/
	}
		
	// end of archive logic

    //echo $xmlstring . $str . $bingostr . $gamefinishstr;
	if($_REQUEST['callback']) {//////#2481
        echo $_REQUEST['callback']."(".json_encode($jsonArr).")";
    }else{
        echo json_encode($jsonArr);
    }


	if($sendfacebook == 'y') {
		if($WINNER_ID) {
			// send out notification of game over
			$notiflist = "";
			foreach($USER_EMAIL_ARRAY as $val)  {
				$notiflist = $notiflist . $val . ",";
			}
			$notiflist = substr($notiflist, 0, -1);
			$to_user = explode(",",$notiflist);
			incrementCount($to_user);
			//$facebookclient->api_client->dashboard_multiIncrementCount($to_user);
		}
	}
    exit;
}

function loginUser($gid, $pid, $password)
{
	global $USERS_INFO;
    global $loggedinUsername, $loggedinEmail;
	global $USER_PASSWORD_ARRAY, $USER_NICKNAME_ARRAY, $USER_NOTRESIGNED_ARRAY, $USER_EMAIL_ARRAY;
	global $USER_RESIGN_ARRAY,$UPDATE_RESIGN_STRING;

    $exp=explode("|", $USERS_INFO);
	$UPDATE_RESIGN_STRING="";
	$count = 1;
    foreach($exp as $val)  {
		$exp1=explode(',',$val);
		$USER_PASSWORD_ARRAY[$count] = $exp1[1];
		$USER_NICKNAME_ARRAY[$count] = addslashes($exp1[2]);
		if($exp1[3] == 'n')
			array_push($USER_NOTRESIGNED_ARRAY, $count);
		else
			array_push($USER_RESIGN_ARRAY, $count);

		$USER_EMAIL_ARRAY[$count] = $exp1[0];

		 if($pid == $count)
		   //$UPDATE_RESIGN_STRING.=$count.",".$exp1[0].",".$exp1[1].",".$exp1[2].",y|";
		   $UPDATE_RESIGN_STRING.=$exp1[0].",".$exp1[1].",".$exp1[2].",y|";//////#2481
		 else
		   $UPDATE_RESIGN_STRING.=$val."|";
		 $count++;
	}

	$UPDATE_RESIGN_STRING = substr($UPDATE_RESIGN_STRING, 0, -1);

	if ($USER_PASSWORD_ARRAY[$pid] == $password) {
		$loggedinUsername = $USER_NICKNAME_ARRAY[$pid];
		$loggedinEmail = $USER_EMAIL_ARRAY[$pid];
	} else
		printOutput("error", "error", "Invalid Login");
}

function sendMessage($gid, $pid, $message, $loggedinUsername)
{
	global $memcache, $messages_table;
	global $USER_EMAIL_ARRAY, $gid, $facebookclient, $sendfacebook;
	$message = trim($message);

	if(strpos($message, "scrabble")) {
    	mysql_query("insert into `scrab_msgs` (`userid`,`message`,`date`,`gid`) values (" . $_REQUEST["fb_sig_user"] . ",'$message', now(), $gid)");
	}
		
	mysql_query("insert into `$messages_table` (`game_id`,`player`,`message`,`datetime`) values ('$gid','$pid','$message',now())");
	## include "msg_file_functions.php";
    ## $text = serialize(array("userid" => $pid, "message"=> $message, "date"=> date("Y-m-d H:i:s"))) . "\r\n";
    ## append_msg_file($gid, $text);

	//if($memcache) {
		//$memcache->delete("SCMSGS" . $gid);
		//$memcache->set("LMI" . $gid, time(), false, 600);--------#1270
		delMemCache("SCMSGS" . $gid);
		setMemCache("LMI" . $gid, time(), false, 600);
	//}
	
	// send out notification of game over
	if($sendfacebook == 'y') {
		$notiflist = "";
		foreach($USER_EMAIL_ARRAY as $val)  {
			if(!($val == $_REQUEST["fb_sig_user"]))
				$notiflist = $notiflist . $val . ",";
		}
		$notiflist = substr($notiflist, 0, -1);
		//$facebookclient->api_client->notifications_send($notiflist, ' has sent you a message in Lexulous Game #' . $gid . '. <a href="http://apps.facebook.com/lexulous/">Click here to view the message.</a>', 'user_to_user');
		$to_user = explode(",",$notiflist);
		incrementCount($to_user);
		//$facebookclient->api_client->dashboard_multiIncrementCount($to_user);
		
	}
}


function deleteMoveCache($gid, $mvid) {
	global $memcache;
	//if($memcache) {
		//$memcache->set("LMV" . $gid, $mvid, false, 600);---------#1270
		//$memcache->delete("gmMv" . $gid);
		setMemCache("WLMV" . $gid, $mvid, false, 600);
		delMemCache("WgmMv" . $gid);
	//}
}

function checkTilesForSwap($tilesToSwap, $tilesInHand) {

	$tilesToSwapLength = strlen($tilesToSwap);
	$tilesInHandLength = strlen($tilesInHand);

	$finalFlag = "false";

    for ($i = 0; $i < $tilesToSwapLength; $i++)
    {
		// now check if each one of these
		// exists in the hand of the player

		$flag1 = "false";
		for($j = 0; $j < $tilesInHandLength; $j++) {

			if($tilesToSwap[$i] == $tilesInHand[$j]) {
				$flag1 = "true";
				$tilesInHand[$j] = " ";
				break;
			}
		}

		if($flag1 == "false") {
			$finalFlag = "false";
			break;
		} else {
			$finalFlag = "true";
		}
	}

	return $finalFlag;
}


function winnerUpdate() {
	global $gid, $MAXSCORE, $WINNER_ID, $originalRackTileRow, $USER_NICKNAME_ARRAY;

	$player_array = array();

	$p1 = $originalRackTileRow[p1score];
	$p2 = $originalRackTileRow[p2score];
	$p3 = $originalRackTileRow[p3score];
	$p4 = $originalRackTileRow[p4score];

	$MAXSCORE = max($p1, $p2, $p3, $p4);

	//echo $MAXSCORE;
	if ($MAXSCORE != 0)
	{
		if ($MAXSCORE == $p1)
		{
			$player = 1;
			array_push($player_array, $player);
		}
		if ($MAXSCORE == $p2)
		{
			$player = 2;
			array_push($player_array, $player);
		}
		if ($MAXSCORE == $p3)
		{

			$player = 3;
			array_push($player_array, $player);
		}
		if ($MAXSCORE == $p4)
		{

			$player = 4;
			array_push($player_array, $player);
		}

		if (count($player_array) > 1)
			$WINNER_ID = -1;
		else
		{
			// $WINNER_ID = $USER_ID_ARRAY[$player];
			$WINNER_ID = $player;
		}
	}

	$returnarr = array();
	$returnarr[0] = $WINNER_ID;
	$returnarr[1] = $MAXSCORE;
	$returnarr[2] = $p1;
	$returnarr[3] = $p2;
	$returnarr[4] = $p3;
	$returnarr[5] = $p4;
	if($WINNER_ID > -1)
		$returnarr[6] = $USER_NICKNAME_ARRAY[$player];
	else
		$returnarr[6] = '';

	return $returnarr;
}

function getCurrentTurn() {

	global $USER_RESIGN_ARRAY, $PLAYER_NO;
	global $pid;

    if ($pid == $PLAYER_NO)
		$current_move = 1;
    else
		$current_move = $pid + 1;

	$i = $current_move;

	while ($i <= $PLAYER_NO)
	{
		if(in_array($i, $USER_RESIGN_ARRAY))
		{
			if ($current_move == $PLAYER_NO)
				$current_move = 1;
			else
				$current_move = $current_move + 1;
		}
		else
			break;

		$i = $current_move;
	}

	return $current_move;
}

function addGameOverToMemCache($gid) {
	global $memcache;

	//if ($memcache) {
		//$memcache->set("GOVER" . $gid, 2, false, 600);---------#1270
		setMemCache("GOVER" . $gid, 2, false, 600);
	//}
}

function getGameOverFromMemCache($gid) {
	global $memcache;

	$returnval = false;

	//if ($memcache) {
		//$returnval = $memcache->get("GOVER" . $gid);---------#1270
		$returnval = getMemCache("GOVER" . $gid);
	//}

	return $returnval;
}

function checkNewMoves($gid, $lastmoveid, $lastmsgid) {
	global $action, $memcache;

	if(getGameOverFromMemCache($gid) > 1) {
		// game is over
		$newmove = 'y';
		$newmsg = 'y';
	} else {
		// check for new messages
		if(!$lastmsgid) {
			$lastmsgid = 0;
		}

		//if ($memcache) {
			//$memcacheMSGID = $memcache->get("LMI" . $gid);-------#1270
			//$memcacheMOVID = $memcache->get("LMV" . $gid);
			$memcacheMSGID = getMemCache("LMI" . $gid);
			$memcacheMOVID = getMemCache("LMV" . $gid);
		//}

		if($memcacheMSGID > $lastmsgid)
			$newmsg = 'y';
		else
			$newmsg = 'n';

		if($memcacheMOVID > $lastmoveid)
			$newmove = 'y';
		else
			$newmove = 'n';
	}

	printOutput($action, $newmove . '&checkmsg=' . $newmsg, $final_message);
}

function updatePlayerRatings($pid) {

	global $PLAYER_NO;
	if($PLAYER_NO != 2)  {
		return;
	}

	global $WINNER_ID, $USER_EMAIL_ARRAY;

	$rating_array = array();

	require('elo-calculator.php');

	if($pid == '1')
		$other = 2;
	else if($pid == '2')
		$other = 1;

	$query=mysql_query("select email,rating from users_stats where email = '" . $USER_EMAIL_ARRAY[$pid] . "' or email = '" . $USER_EMAIL_ARRAY[$other] . "'");

	while($row=mysql_fetch_array($query)) {
		if($row[email] == $USER_EMAIL_ARRAY[$pid]  ||  $row[email] == $USER_EMAIL_ARRAY[$other]) {
			if($row[rating] == 0)
				$row[rating] = 1200;

			$rating_array[$row[email]]=$row[rating];
		}
	}

	$R1 = $rating_array[$USER_EMAIL_ARRAY[$pid]];
	$R2 = $rating_array[$USER_EMAIL_ARRAY[$other]];

	if($WINNER_ID == '-1')   {
		$S1 = 1;
		$S2 = 1;
	}
	else if($pid == $WINNER_ID) {
		$S1 = 2;
		$S2 = 1;
	}
	else if($other == $WINNER_ID) {
		$S1 = 1;
		$S2 = 2;
	}

	$R = calculate_rating($S1,$S2,$R1,$R2);

	
	$result = mysql_query("select `bestrating` from `users_stats` where email = '$USER_EMAIL_ARRAY[$pid]' ");
	$row_bestrating_me = mysql_fetch_assoc($result);	
	$bestrating_me=$row_bestrating_me['bestrating'];
	if($bestrating_me < $R[R3]){
		mysql_query("update users_stats set bestrating = '$R[R3]',`bestrating_date`=NOW() where email = '$USER_EMAIL_ARRAY[$pid]' ");
	}
	
	$result = mysql_query("select `bestrating` from `users_stats` where email = '$USER_EMAIL_ARRAY[$other]' ");
	$row_bestrating_opp = mysql_fetch_assoc($result);
	$bestrating_opp=$row_bestrating_opp['bestrating'];
	if($bestrating_opp < $R[R4]){
		mysql_query("update users_stats set bestrating = '$R[R4]',`bestrating_date`=NOW() where email = '$USER_EMAIL_ARRAY[$other]' ");
	}
	
	/* End #2481  */
	
		
	mysql_query("update users_stats set rating = '$R[R3]' where email = '$USER_EMAIL_ARRAY[$pid]' ");
	mysql_query("update users_stats set rating = '$R[R4]' where email = '$USER_EMAIL_ARRAY[$other]' ");
}

/*
function total_moves_fn($gid)   {
	global $fin_games_moves_table, $exp_move;
	$query_move = mysql_query("select * from `$fin_games_moves_table` where gameid='$gid'");
	$result_row = mysql_fetch_array($query_move);
	if(mysql_num_rows($query_move) == 0)   {
				   $total_moves = 0;
	}
	else  {
		$move_info = $result_row['move_info'];
		$exp_move=explode("|", $move_info);
		$total_moves = count($exp_move);
	}

	return $total_moves;
}
*/

function sendFBNotif($uid) {
return;
	global $memcache;
	global $sendfacebook;
	if(!is_numeric($uid))
		return;
		
	//if ($memcache) {
		//$ispending = $memcache->get("LEN" . $uid);---------#1270
		$ispending = getMemCache("LEN" . $uid);
		
		if($ispending != 1) {
			//$memcache->set("LEN" . $uid, 1, false, 1800);-------#1270
			setMemCache("LEN" . $uid, 1, false, 1800);
			$str = $uid .'|'.'Lexulous Facebook - Move Notification'.'|'.'Hi there,<br/><br/>
			
			You have one or more pending moves in your <a href="http://apps.facebook.com/lexulous/?&src=email">Lexulous games</a>. Please <a href="http://apps.facebook.com/lexulous/?&src=email">click here</a> to play your move(s).<br/><br/>
			To start a new Lexulous crossword game, <a href="http://apps.facebook.com/lexulous/?&action=newgame&src=email">click here</a>.
			For any questions, contact <a href="mailto:lexulous@wallabros.com">lexulous@wallabros.com</a>.<br/><br/>
			
			Cheers,<br/>
			The Lexulous Team
			';
			$str = urlencode($str)."\n";
			$fp = fsockopen("192.168.200.79", 15000, $errno, $errstr);
			if (!$fp) {
				return;
			}
			else {
				fputs($fp, $str);
			}
			fclose ($fp);
		}
//	}
}

///functions
function authenticate($action,$authSecret) {
	try {
		$url = "https://graph.facebook.com/me?access_token={$authSecret}&fields=id";
		$authresult = file_get_contents($url);
		if($authresult != false && $authresult != "") {
			$arr_authresult = json_decode($authresult,true);
			return $arr_authresult['id'];
		} else {
			throw new Exception("Invalid user");
		}
	}
	catch (Exception $e) {
			echo "{\"action\":\"$action\",\"check\":\"Failure\",\"message\":\"Invalid user\"}";
			exit;
		//e		exit;
	}
}

function updateAllCounts($array) {
	global $pid;
    unset($array[$pid]);
	$notiflist = "";
	if(count($array) > 0) {
	foreach($array as $val)  {
		$notiflist = $notiflist . $val . ",";
	}
	$notiflist = substr($notiflist, 0, -1);
	incrementCount($notiflist);
 }
}

function incrementCount($uid) {
	global $facebookclient, $fb_sig_session_key, $secret, $fbappid;
	try {
		if(!is_array($uid)){
			$uid = explode(',', $uid);
		}


		foreach($uid as $val) {
			$uri = "https://graph.facebook.com/" . $val . "/apprequests";
			$postdata =  "message=" . urlencode("Your turn in Wordscraper!") . "&data=notif&access_token=".$fbappid."|".$secret;
			https_post($uri, $postdata);
		}

	} catch (Exception $ex) {
		//print_r($ex);
	}	
}

function https_post($uri, $postdata) {
	$sql = "INSERT INTO fbnotification SET url='{$uri}',data='{$postdata}'";
	mysql_query($sql);

	//push_message_notification();
	
}
?>