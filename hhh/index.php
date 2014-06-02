<?

/////////////
///take each variable from GET
//if last character is / then delete that character
//reset variable value
foreach($_GET as $key=>$value){
$last = substr($value, -1);	
	if ($last == "/"){
		$val = substr($value, 0,-1);
		$GLOBALS[$key] = $val;
		$_REQUEST[$key] = $val;
	}
}
/////////////

include_once("constants.php");

session_start();
ob_start('ob_gzhandler');

include_once("library/timer.php");
$time = new Timer;
$time->starttime();
///////////////////

// to delete games via admin panel
if($action == "adminDelete") {
    if($password == "R@J@") {
	    DB::connect();
        mysql_query("call procDeleteGame(" . $gameid . ")");
        exit;
    }
}

header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array('appId'  => FB_APP_ID,'secret' => FB_SECRET,'cookie' => true,));

if($_REQUEST['utm_trk']) {
	$tracker = "&utm_trk=" . $_REQUEST['utm_trk'];
} else
	$tracker = '';

////////////////Authorization Part//////////////////////
if($_SERVER['HTTPS'] != 'on'){
	$auth_url = "http://www.facebook.com/dialog/oauth?&client_id=" . FB_APP_ID . "&scope=publish_actions&redirect_uri=" . urlencode(FB_APP_PATH . "?&inst=1" . $tracker);////changed on 2_8_12
} else {
	$auth_url = "https://www.facebook.com/dialog/oauth?&client_id=" . FB_APP_ID . "&scope=publish_actions&redirect_uri=" . urlencode(FB_APP_PATH . "?&inst=1" . $tracker);////changed on 2_8_12
}
$signed_request = $_REQUEST["signed_request"];
list($encoded_sig, $payload) = explode('.', $signed_request, 2);
$data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
if (empty($data["user_id"])) {
	if ($_REQUEST['request_ids']) {/////if added #2481
    	$auth_url = "{$URLPREFIX}www.facebook.com/dialog/oauth?scope=publish_actions&client_id=" . FB_APP_ID . "&redirect_uri=" . urlencode(FB_APP_PATH . "?&inst=1&request_ids={$_REQUEST['request_ids']}") . "" . $tracker;
    	echo("<script> top.location.href='" . $auth_url . "'</script>");
    	exit;
    }///#2481
	if($action) {
		echo("<script> top.location.href='" . $auth_url . "'</script>");
	} else {
		$ip = get_client_ip();
		if(!DB::$connected) { DB::connect(); }
		$ip_insert_query= mysql_query("insert DELAYED into ip_tracking set ip_address='".$ip."',user_id='".$user."',date_added=now(),status='n',last_update=now()");
		//include "splash.php"; ///new layout location changed.
		echo("<script> top.location.href='" . $auth_url . "'</script>");
	}
    exit;
} 


$user=$facebook->getUser();
$key=$facebook->getAccessToken();
if($_REQUEST['jsonGameData']){
	$json=base64_decode($_REQUEST['jsonGameData']);
	$jsondata = (array)json_decode(stripslashes($json));
	$json='{"fb_sig_user":"'.$user.'","fb_sig_session_key":"'.$key.'","oppid":"'.$jsondata['oppid'].'","dic":"'.$jsondata['dic'].'","rack":"'.$jsondata['rack'].'","type":"'.$jsondata['type'].'","turn":"'.$jsondata['turn'].'"}';
	
	$postdata="?json=".$json;
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 	curl_setopt($ch, CURLOPT_POST, false);
 	curl_setopt($ch,CURLOPT_URL,'http://aws.rjs.in/fblexulous/mob_quickgame_v12.php'.$postdata);	
 	$splash_game_start=curl_exec($ch);
 	curl_close($ch);

	$data_array=json_decode($splash_game_start,true);
	$wordPlayed=$data_array['wordPlayed'];
	$score=$data_array['score'];
	$gameid=$data_array['gid'];
	$playedWith=$jsondata['oppid'];
	$json_data='{"wordPlayed":"'.$wordPlayed.'","score":"'.$score.'","playedWith":"'.$playedWith.'","gameid":"'.$gameid.'"}';
	$json_data=base64_encode($json_data);
	$url = FB_APP_PATH . "?action=previousgame&json=".$json_data;
	echo "<script type='text/javascript'>top.location.href = '$url';</script>";
	exit;
}

//-------new logic--2_8_12
$checkSession = false;
if ($_SESSION['fbLexUserData']) {
   if ($_SESSION['fbLexUserData']['id'] == $data["user_id"]) {
      $me = $_SESSION['fbLexUserData'];
       $checkSession = true;
   } else {
     $checkSession = false;
   }
} else {
     $checkSession = false;
}

if (!$checkSession || ($inst == 1)){	//----#1774
	try {
	    $me = $facebook->api('/me?fields=id,name,first_name,last_name,picture,permissions,third_party_id');
	    $_SESSION['fbLexUserData'] = $me;
	  } catch (FacebookApiException $e) { 
	  }
}
//----new logic ends.2_8_12

if(!isset($_COOKIE['last_online'])){
	if(!DB::$connected) { DB::connect(); }
	$update_lastonline_query="INSERT INTO user_lastonline (userid,lastonline) VALUES('".$user."',now()) ON DUPLICATE KEY UPDATE lastonline=now()";
	mysql_query($update_lastonline_query);
	setcookie('last_online', 'y', time() + 3600 * 24 );
}


if ($inst == 1){
	$ip = get_client_ip();
	if(!DB::$connected) { DB::connect(); }

	$query_notification = "insert into notification_logs set userid='".$user."', install_datetime=now(), datetime='0000-00-00 00:00:00', messagetext='', clicked='n', friend_list=''";
	mysql_query($query_notification);
		
			
	try {
		$app_using_friends = $facebook->api(array(
				'method' => 'fql.query',
				'query' => 'SELECT uid, name FROM user WHERE uid IN(SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1 limit 5'
		));
		
		$range = count($app_using_friends);
		$rand = rand(0, $range-1);
		$friend_listArr = $app_using_friends[$rand];
		$friend_list = $friend_listArr['name']."||".$friend_listArr['uid'];
		$query_notification = "update notification_logs set friend_list='".addcslashes($friend_list,"'")."' where userid='".$user."'";
		mysql_query($query_notification);
	} catch (FacebookApiException $e) {
	}
	
	//$ip_update_query= mysql_query("update ip_tracking set user_id='".$user."', status='i',last_update=now() where ip_address='".$ip."' and status='n'");
	//$ip_insert_query= mysql_query("insert DELAYED into ip_tracking set ip_address='".$ip."',user_id='".$user."',date_added=now(),status='i',last_update=now()");
	//$cookie_time= 6*3600;
	//$cookie_time= 60;
	//setcookie("set_ip_add1","1",time()+$cookie_time);
}else{
	/*if(!isset($_COOKIE['set_ip_add1_'.$user])){
		//$cookie_time= 6*3600;
		//$cookie_time= 60;
		//$ip = get_client_ip();
		if(!DB::$connected) { DB::connect(); }
		//$ip_insert_query= mysql_query("update ip_tracking set last_update=now() where user_id='".$user."' and ip_address='".$ip."' and status='e'");
		//$affected_rows = mysql_affected_rows();
		//if($affected_rows ==0){
			//$ip_insert_query= mysql_query("insert DELAYED into ip_tracking set ip_address='".$ip."',user_id='".$user."',date_added=now(),status='e',last_update=now()");
		//}
		$sql_daily_user = "insert DELAYED into daily_user set date=now(),userid='".$user."'";
		//mysql_query($sql_daily_user);
		setcookie("set_ip_add1_".$user,"1",time()+$cookie_time);
	}*/
}

//--------#1774-------
$showActionPublish = true;
if( array_key_exists('publish_actions', $me['permissions']['data'][0]) ) {
	$showActionPublish = false;
}else {
	$showActionPublish = true;
}

if(($inst == 1) || ($rajat == 1)) {
	include_once("library/resign_functions.php");
	$achievement_URL = 'https://graph.facebook.com/' . $user . '/achievements';
	$achievement = 'http://aws.rjs.in/fblexulous/achievements/index.php?type=started_playing';
	$achievement_result = https_post($achievement_URL,
			'achievement=' . $achievement
			. '&access_token=' . FB_APP_ID.'|'.FB_SECRET
	);
}


if($postFriendAch) {	
	if($_GET['user'] == $user) {				
		setcookie('friend_achievement',"1", time() + 3600 * 24 * 1);
		if(!DB::$connected) { DB::connect(); }
		$sql = "update friendCountAchievement set friendsNumber={$active_frnd} WHERE fb_userid='{$user}'";
		mysql_query($sql);
		if (mysql_affected_rows() == 0){
			$query = "INSERT INTO friendCountAchievement SET friendsNumber='{$active_frnd}',fb_userid='{$user}'";
			mysql_query($query);
		}
	}
	exit;
}

/*
if ($dailyAchievement){  
	include_once 'ajax/dailypostAch.php';
	exit;
}
*/
if (!$_COOKIE['user_achievements']){
	$dailyachievementposted = false;
}else{
	$dailyachievementposted = true;
}

//-----#1774---------

 if ($user) {
	if ($_REQUEST['count'] > 0 || $_REQUEST['request_ids'] || ($_REQUEST['ref'] == 'bookmarks') || ($_REQUEST['ref'] == 'sidebar_bookmark')) {
	   $data = $facebook->api('/me/apprequests/');
       $total_request_ids = array();
       $request_from_users = array();/////#2481
       for ($i = 0; $i < count($data['data']); $i++) {
       	$total_request_ids[] = $data['data'][$i]['id'];
       	if($data['data'][$i]['from']['id'] > 1)
			$request_from_users[]= $data['data'][$i]['from']['id'];//////#2481
       }

       if (count($total_request_ids) > 0) {
 			$reqid = implode(",", $total_request_ids);
       
	   	$token = $facebook->getAccessToken();

       	$batched_request[] = array();
       	$array_requests = explode(",", $reqid);
       	$count = 0;
		$batchesrun = 0;
       	foreach ($array_requests as $val) {
           	$count++;
           	$batched_request[] = array("method" => "DELETE", "relative_url" => "$val");
           	if ($count == 19) {
               startRequest($batched_request, $token);	
               	$batched_request = array();
               	$count = 0;
           	}
			$batchesrun++;
			if($batchesrun == 2) {
				$count = 0;
				break;
			}
       	}
       	if ($count > 0) {
           	startRequest($batched_request, $token);	 
       	}
       }
       ///////#2481 start game directly from app request
       if (count($request_from_users)>0){
       		$firstVar = array();
       		$request_from_unique_users = array_unique($request_from_users);
       		if ($_COOKIE['settingCookie']){
       			$cookie_arr = explode(',', $_COOKIE['settingCookie']);
       			$language = $cookie_arr[2];
       		}else{
       			$language = "sow";
       		}
       		foreach ($request_from_unique_users as $key=>$value){
	       		$ids = array();
	            array_push($ids, $value);
	       		if(!DB::$connected) { DB::connect(); }
	            $result = startnewgame($user, $ids, $language, "R","");
	       		if(count($firstVar) == 0) {
	               $firstVar = $result;
	            }
       		}
            $url = FB_APP_PATH . "?action=viewboard&gid={$firstVar[1]}&pid={$firstVar[2]}&password={$firstVar[3]}&newgame=1&lang={$firstVar[4]}&uids={$firstVar[5]}&with=" . urlencode($firstVar[0]);
            echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            exit;
       }
       /////#2481 End	   
    }
}
////////////////////////////
//-------------#1142(5)-----------------


function debugUser($user, $msg) {
	if($user == '608036521') {
		echo $msg;
		exit;
		
	}
}

if(!DB::$connected) { DB::connect(); }

///For new layout  #2481
if(!DB::$connected) { DB::connect(); }
$new_playerCookie = $_COOKIE['new_player'];
if (!$new_playerCookie){
	$sql_newPlayer = "SELECT dateadded FROM facebookusers WHERE uid={$user}";
	$sql_result = mysql_query($sql_newPlayer);
	if (mysql_numrows($sql_result) == 0){
		setcookie('new_player','y', time() + 3600 * 24 * 7);

		$new_playerCookie = 'y';
	}else{
		$newPlayerDate = mysql_fetch_assoc($sql_result);
		$playerDateAdded = strtotime($newPlayerDate['dateadded']);
		$lexUpdateTime = strtotime("2013-01-30");
		if ($playerDateAdded > $lexUpdateTime){
			//$_COOKIE['new_player'] = 'y';
			setcookie('new_player','y', time() + 3600 * 24 * 7);
			$new_playerCookie = 'y';
		}else{
			//$_COOKIE['new_player'] = 'n';
			setcookie('new_player','n', time() + 3600 * 24 * 7);
			$new_playerCookie = 'n';
		}	
	}
} else {
	setcookie('new_player', $new_playerCookie, time() + 3600 * 24 * 7);
}


$settingsTableChange = 'n';

if(($_REQUEST['vers']) && ($new_playerCookie == 'n')){    
	$vers=substr($_REQUEST['vers'],0,1);
	$status=array();
	$sql="SELECT * FROM settings WHERE user_id='{$user}'";
	$sqlres=mysql_query($sql);
	if(mysql_num_rows($sqlres)>0){		
		$status=mysql_fetch_assoc($sqlres);
		if($status['version']!=$vers){
			$q1="UPDATE settings SET version='$vers' WHERE user_id='{$user}'";
		}	
	}else{
		$q1="INSERT INTO settings(user_id,version,date) VALUES('$user','$vers',NOW())";
	}
	mysql_query($q1);  
	$settingsTableChange = 'y'; 
}


if ($new_playerCookie == 'n'){
	if(!$_COOKIE['visitNotFirst']){
		$sql1=mysql_query("SELECT '' FROM settings WHERE user_id='$user'");
		if(mysql_num_rows($sql1)>0){
			setcookie('visitNotFirst',true, time() + 3600 * 24 * 365 * 1);
		}else{
			// users who are returning from 7th July onwards will get the new layout.
			$q1="INSERT INTO settings(user_id,version,header_menu,date) VALUES('$user','n','h',NOW())";
			mysql_query($q1);  
			
			//$url = FB_APP_PATH."firstnewlayout.php";
			//echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			//exit;
		}
	}
}


$header_menu = $_COOKIE['header_menu'];
if ($new_playerCookie == 'n'){
	if (($settingsTableChange == 'y') || ($header_menu == '')){
		$q="SELECT * FROM settings WHERE user_id='$user'";
		$qres=mysql_query($q);
		if(mysql_num_rows($qres)>0){
			$status=mysql_fetch_assoc($qres);
			$version=$status['version'];
			$header_menu=$status['header_menu'];
			setcookie('header_menu',$header_menu, time() + 3600 * 24 * 7);
			setcookie('fb_version',$version, time() + 3600 * 24 * 7);
			if($version=='o'){
				$version="old";
			}else{
				$version="new";
			}
		}else{
			$version="old";
		}
	}else{
		$header_menu = $_COOKIE['header_menu'];
		if ($_COOKIE['fb_version'] == 'n'){
			$version = "new";
		}else if ($_COOKIE['fb_version'] == 'o'){
			$version = "old";
		}
	}
}else{
	$version="new";
}

if($action == "changesettings"){
	$html5boardChangeValue = $_REQUEST['html5board'];
}

//// set user source from campaign
//set_user_advt_source($user,$cmp);

//for next game showing
if($action == "jump") { 
    $tmp = getNextGame($user, $skipgid);
    if(!($tmp == false)) {
    	echo "<script type='text/javascript'>top.location.href = '$tmp';</script>";
        exit;
    }
    $action = "";
}

if(($action == "newgame") && ($sendmessage == "Send A Message")) { 
   $url = "http://www.facebook.com/message.php?id=".$with;
   echo "<script type='text/javascript'>top.location.href = '$url';</script>";
   exit;
}

if($action == "startProxyGame")
{
	$res = mysql_query("select * from proxyusers where user = '$with'");
	if(mysql_num_rows($res) > 0) {
		$return = mysql_fetch_array($res);
	}
	if($return) {
		$ids = array();
		array_push($ids, $return['user']);
		$result = startnewgame($user, $ids, $return['dictionary'], $return['gametype'],$return['name'],'','s');//#3203
		if(count($firstVar) == 0) {
			$firstVar = $result;
		}
	}
	$url = FB_APP_PATH . "?action=viewboard&gid=$firstVar[1]&pid=$firstVar[2]&password=$firstVar[3]&newgame=1&lang=" . $firstVar[4] . "&uids=" . $firstVar[5] . "&with=" . urlencode($firstVar[0]);
	echo "<script type='text/javascript'>top.location.href = '$url';</script>";
	exit;
}


//Needs to check when viewgid comes
if($viewgid > 0) {
    $retval = getGameInfo($user, $viewgid);
    $gid = $viewgid;
    $password = $retval[0];
    $pid = $retval[1];
    $action = "viewboard";
}

if($_COOKIE['bingoupdated'] <> 1) {
	$dailyBingoUpdateCall = 1;
} else {
	setcookie('bingoupdated', 1, time()+60*60*24*365);
}

//check user visits before showing advertisements
$visit=$_COOKIE['uservisit'];
setcookie('uservisit',$visit+1,time()+60*60*24*365);
if($visit>10) { $SHOWADV=true; }
$SHOWADV=true;

// setting for removal of help text in viewboard screen
if(isset($removeVBHelp)){
	if(!DB::$connected) { DB::connect(); }
	mysql_query("update facebookusers set eggadvert='n' where uid = '$user'");
	load_settings($user);
}


/*
//getting email data 
if(!$_COOKIE["emailPerm2"]) {
    if(!DB::$connected) { DB::connect(); }
    $fql = "SELECT email FROM user WHERE uid = '$user'";
    $param  =   array(
       			'method'     => 'fql.query',
        		'query'     => $fql,
      			'callback'    => ''
		);
	$email_per_res   =   $facebook->api($param);
    if($email_per_res[0]['email']) {
        mysql_query("INSERT INTO `email_permission` (`users`) VALUES ('$user')");
        setcookie("emailPerm2",1,time()+ 60*60*24*7);
        $EMAILSETTINGSVAL = 1;
    } else {
        mysql_query("DELETE FROM `email_permission` WHERE `users` = '$user'");
        setcookie("emailPerm2",2,time()+ 60*60*24*7);
        $EMAILSETTINGSVAL = 2;
    }
} else {
    $EMAILSETTINGSVAL = $_COOKIE["emailPerm2"];
}
*/


//for forced win action
if($action == "resign") {
    if($user == '563981417') {
        $allowforce = 1;
    } else if($_COOKIE['forcedwintoday']) {
        // see what is current status
        $forced = split(',', $_COOKIE['forcedwintoday']);
        if($forced[0] == 3)
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

    if($allowforce == 1) {
        include_once("library/resign_functions.php");
        $message = startResign($gid, $pid, $password);
    }
    $action = '';
}

//getting mandatory record per user
if((!$_COOKIE['settingCookie'])||(!$_COOKIE['app_dateadded'])) {///////changed from $_COOKIE on 10_7_12 #1142(1)
    $banned = load_settings($user, true);
}

//please see cookie index in load_settings function
if(strlen($_COOKIE['settingCookie']) > 1) {
	$settingCookie = explode(",",$_COOKIE['settingCookie']);/////////closed on 10_7_12 #1142(1)
}

//$settingCookieSession = $_SESSION['lexCookieList'];//////////added on 10_7_12	#1142(1)
//$settingCookie = explode(",",$settingCookieSession);//////////added on 10_7_12	1142(1)

setcookie('lastonline', time(), time() + (3600 * 24 * 30));

//setting user online in game
if($settingCookie[1] == 'y') {
    $diff = $_COOKIE['lastonline'] - time();
    if( ($diff < 0) || ($diff > 179) ) {
        setMemCache($user, 1, false, 180);
    }
}


if(!DB::$connected) { DB::connect(); }
$hide_advert_option = 'n';
$query = "SELECT max(expire_date) AS max_expire_date FROM `no_advert_subscription` where buyer='{$user}' AND expire_date > now()";
$results = mysql_query($query);
$advert = mysql_fetch_array($results);
if ($advert['max_expire_date']){
	$hide_advert_option = 'y';
}else{
	$hide_advert_option = 'n';
}
///------#2481

$totPlayed_results = generic_mem_cache('totalGamePlayed/B' . $user, 3600, "SELECT won,lost,drawn FROM users_stats WHERE email='$user'");
$tot_played = $totPlayed_results[0]['won']+$totPlayed_results[0]['lost']+$totPlayed_results[0]['drawn'];

if ($hide_advert_option == 'n' && $tot_played < 5) $hide_advert_option = 'y';
//if (strtotime($_COOKIE['app_dateadded'])> strtotime("2013-06-01")) $hide_advert_option = 'y';

global $blockedUserArrStr;
$blockedUserArrStr = getBlockUserList($user);

///#3569 -- check for fb_ref -- to get old users into game
if($_REQUEST['fb_ref']) {
	$incomingchallenge = explode("-", $_REQUEST['fb_ref']);
	if ($incomingchallenge[0] == 'inc' ){
		$res = mysql_query("select * from proxyusers where user = " . $incomingchallenge[1]);
		if(mysql_num_rows($res) > 0) {
			$return = mysql_fetch_array($res);
		}			
		if($return) {
			$ids = array();
			array_push($ids, $return['user']);
			$result = startnewgame($user, $ids, $return['dictionary'], $return['gametype'],$return['name']);				
		}
		
		$url = FB_APP_PATH . "?action=viewboard&gid={$result[1]}&pid={$result[2]}&password={$result[3]}&newgame=1&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]) . "&vers=new&chl=1";
		echo "<script type='text/javascript'>top.location.href = '$url';</script>";
		exit;
	}
	
 	if($incomingchallenge[0]=='newinstalled'){
 	
 		mysql_query("update notification_logs set clicked='y' where userid='".$user."'");
		if($incomingchallenge[1]=='move'){
				
			$gid=$incomingchallenge[2];
			$pid=$incomingchallenge[3];
			$pass=$incomingchallenge[4];
			$game_type=$incomingchallenge[5];
			$lang=$incomingchallenge[6];
				
			$url =FB_APP_PATH."?action=viewboard&gid=".$gid."&pid=".$pid."&password=".$pass."&gametype=".$game_type."&lang=".$lang."&notification=y";
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			exit();
				
		}else if($incomingchallenge[1]=='rand_friend'){
			
			$fuid=$incomingchallenge[2];
			$fname=$incomingchallenge[3];
			$url =FB_APP_PATH."?action=startnewgamefromHeader&profileid=".$fuid."&name=".$fname."&notification=y";
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			exit();
					
		}else if($incomingchallenge[1]=='rand_robot'){
		
			$ruid=$incomingchallenge[2];
			$rname=$incomingchallenge[3];
			$url =FB_APP_PATH."?action=randomjoin";
			$url =FB_APP_PATH."?action=startnewgamefromHeader&profileid=".$ruid."&name=".$rname."&notification=y";
			echo "<script type='text/javascript'>top.location.href = '$url';</script>";
			exit();
		}
	
	}
}

///#3569


switch ($action) {
    
	//which page will start after clicking on newgame
	case "newgamestartingpage":
		$pageReqCookie = $page;
		setcookie('newgamesetpage',$pageReqCookie, time() + (3600 * 24));
		echo "<script type='text/javascript'>top.location.href = '".FB_APP_PATH."';</script>";
    	break;

    //when no game found then user can join 5 games at a time ramdomly and opens first join game 
    case "randomjoin":

		$dic = $settingCookie[2];
		if ($dic){
			$dictionary = $dic;
		}else{
			$sql_dic = "SELECT defaultdic FROM facebookusers WHERE uid='{$user}'";
			$res_dic = mysql_query($sql_dic);
			$result_dic = mysql_fetch_array($res_dic);
			$dictionary = $result_dic[0];
		}
		if(!$dictionary) {
			$dictionary = 'twl';
		}

   		//----#2064
		//$tot_games=mysql_query("SELECT won,lost,drawn FROM users_stats WHERE email='$user'");
    	//$played_res=mysql_fetch_assoc($tot_games);
    	//$tot_played=$played_res['won']+$played_res['lost']+$played_res['drawn'];
    	if(($tot_played>10) && ($user != '563981417') && ($user != '100001953006601')){
    		//$req_res = mysql_query("SELECT user FROM fbrequests where user<>'$user' AND dictionary='$dictionary' ORDER BY RAND() LIMIT 1");
    		if (strlen($blockedUserArrStr)>0){
    			$req_res = mysql_query("SELECT user FROM fbrequests where user<>'$user' AND dictionary='$dictionary' AND user NOT IN($blockedUserArrStr) ORDER BY RAND() LIMIT 1");
    		}else{ 
    			$req_res = mysql_query("SELECT user FROM fbrequests where user<>'$user' AND dictionary='$dictionary' ORDER BY RAND() LIMIT 1");
    		}
    		//$req_res = mysql_query("SELECT user FROM fbrequests where user<>'$user' ORDER BY RAND() LIMIT 1");
    		$active_player = 1;
    	}else{
    		$req_res = mysql_query("SELECT user FROM proxyusers where user<>'$user' ORDER BY RAND() LIMIT 1");
    		$active_player = 0;
    	}
    	//$req_res = mysql_query("SELECT user FROM fbrequests where (dictionary = 'sow' or dictionary = 'twl') and user<>'$user' ORDER BY RAND() LIMIT 5");
    	//------#2064
		
		if(mysql_num_rows($req_res)>0) {
            $firstVar = array(); 
            while($dataRow = mysql_fetch_assoc($req_res)) {
                $with = $dataRow['user'];
                if ($active_player == 1){
                	$return = start_gamerequest($with);
                }else if ($active_player == 0){   ///#2064
	        		$res = mysql_query("select * from proxyusers where user = '$with'");
					if(mysql_num_rows($res) > 0) {
						$return = mysql_fetch_array($res);
					}
                }
                if($return) {
                    $ids = array();
                    array_push($ids, $return['user']);
                    $result = startnewgame($user, $ids, $return['dictionary'], $return['gametype'],$return['name']);
                    if(count($firstVar) == 0) {
                            $firstVar = $result;
                    }
                }
            }
            $url = FB_APP_PATH . "?action=viewboard&gid={$firstVar[1]}&pid={$firstVar[2]}&password={$firstVar[3]}&newgame=1&lang={$firstVar[4]}&uids={$firstVar[5]}&with=" . urlencode($firstVar[0]);
            echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            exit;
        } else {
            $action = "default";
            $message = "Sorry, there is no game request! Please try again later.";
            break;
        }
        break;
    
    //setting variables change here 
    case "changesettings":

		$sq="update facebookusers set showprofiles='$profilesRdBttn', defaultdic='$defaultDic', numberedboard='$numberedRdBttn', autoRefreshBoard='$autoRefreshRdBttn', showstatus='$showStatusRdBttn', show_tiles='$showTilesRdBttn', default_newgame='$newgameClick' where uid = '$user'";//#3626
    	mysql_query($sq);

    	$sql = "INSERT INTO `settings`	SET newboard = '$html5boardChangeValue',user_id = '$user',version = 'n' ON DUPLICATE KEY UPDATE newboard = '$html5boardChangeValue'";
    	mysql_query($sql); 


        setcookie('html5board',$html5boardChangeValue,time()+3600*24*7);
		$_COOKIE['html5board'] = $html5boardChangeValue ;  	

        if($showStatusRdBttn == "n") { delMemCache($user);}
        ///#3105
        //setcookie('newgamesetpage',$newgameClick, time() + (3600 * 24));
        ///#3105
        ///#3204
        //setcookie('tiles_remaining',$showTilesRdBttn, time() + (3600 * 24 * 7));
        ///#3204
        $message = "Settings have been saved.";
        load_settings($user);
        $action = "";
        echo "<script type='text/javascript'>top.location.href = '".FB_APP_PATH."?action=mysettings';</script>";
		exit;		
        break;
        
    //inserting contact info in db
    case "sendcontact":
        if(!$contact_email ||!$contact_cemail || !$contact_msg) {
            $message = "Please enter your contact details";
            $action = "contactus";
        } else if($contact_email != $contact_cemail) {
            $message = "Please enter a valid email address.";
            $action = "contactus";
        } else {
            mysql_query("INSERT INTO `contactmsg` (`from` ,`msg` ,`date`) VALUES('$contact_email','$contact_msg',CURDATE())");
            $message = "Thank you for contacting us!";
            $action = "";
        }
        break;
        
    //deleting a game by admin only
    case "admindelete":
        if($user == '563981417') {
            mysql_query("call procDeleteGame($gid)");
        }
        $message = "Game #" . $gid . " has been deleted.";
        break;

    //clears a requested game from join table
    case "clearrequest":
        clear_gamerequest($user);
        break;
        
    /*&%^*&%%*&%&*/
    case "manualstatsupdate":
        $message = do_manual_stats($user);
        $action = "";
        break;

    //hosting a new game
    case "postgamerequest":
        $expiresin = 90;
        $ratingfrom = empty($ratingfrom)?"0":$ratingfrom;
        $ratingto = empty($ratingto)?"9999":$ratingto;
		if (!$adultsonly) $adultsonly = "n";////---------#2481

        $gameReqCookie = "$dictionary,$gametype,$gamespeed,$maxplayers,$adultsonly,$expiresin,$ratingfrom,$ratingto";
        setcookie('gameReqCookie',$gameReqCookie,time() + 3600 * 24 * 7);

        post_gamerequest($user, $dictionary, $gametype, $gamespeed, $maxplayers, $expiresin, $brag, $ratingfrom, $ratingto, $adultsonly);
        $showrequestfeedlink = "1";
        $action = "";
        break;

    //starting a new game from join table
    case "startgamerequest":
        if($with == $user) {
            $message = "Sorry, you cannot match yourself! Please match a friend.";
            $action = "viewrequest";
        } else {
            $return = start_gamerequest($with);
            if($return) {
                $ids = array();
                array_push($ids, $return['user']);
                $result = startnewgame($user, $ids, $return['dictionary'], $return['gametype'],$return['name']);

                $gid = $result[1];
                $pid = $result[2];
                $password = $result[3];

                $url = FB_APP_PATH ."?action=viewboard&gid={$gid}&pid={$pid}&password={$password}&newgame=1&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]);
                echo "<script type='text/javascript'>top.location.href = '$url';</script>";
                exit;
            } else {
                $message = "Sorry, the request was snapped up by someone else! Try again.";
                $action = "viewrequest";
            }
        }
        break;
	
    //starting a new game 
    case "startnewgame":

        if($friends_requests) {
			delete_friends_request($friends_requests);		
		}
        $newGameCookie = "$dictionary,$gametype";
        setcookie('newGameCookie',$newGameCookie,time() + 3600 * 24 * 7);

        if($multiplayer) {
            $ids = split(',', $multiplayer);
        }

        if($with) {
           $ids = array();
           array_push($ids, $with);
        }

        if(count($friends)>0) {
            $ids = array();
            for($i=0;$i<count($friends);$i++) {
                if($friends[$i] == $user || empty($friends[$i])) continue;
                array_push($ids, $friends[$i]);
            }
        }

        $opps = $ids;
        $tmp = $ids;

        if(is_array($tmp)) {
            array_push($tmp, $user);
            $tmp = array_unique($tmp);
        } else {
            $message = "Please fill up all fields to start a game";
            $action = "newgame";
            break;
        }

        if(count($tmp) <> (count($ids) + 1)) {
            $message = "Please ensure all players are different";
            $action = "newgame";
            break;
        }

        if($user && ((count($opps) > 0) && (count($opps) < 4)) && $dictionary && $gametype) {
        	if ($gamenumber > 0){////#3105
        		for ($cnt = 0;$cnt < $gamenumber;$cnt++){
        			$result = array();
            		$result = startnewgame($user, $opps, $dictionary, $gametype, "");
        		}
        	}else{
        		$result = startnewgame($user, $opps, $dictionary, $gametype, "");
        	}
            $gid = $result[1];
            $pid = $result[2];
            $password = $result[3];
            $url = FB_APP_PATH."?action=viewboard&gid={$gid}&pid={$pid}&password={$password}&newgame=1&gametype={$gametype}&lang={$result[4]}&uids={$result[5]}&with=".urlencode($result[0]);	
            echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            exit;
        } else {
            $message = "Please fill up all fields to start a game";
            $action = "newgame";
        }
        break;

        //starting a game from frndlist popup menu #2481
    case "startnewgamefromHeader": 
    		$profileid = $_REQUEST['profileid'];
			$dic = $settingCookie[2];
			if ($dic){
				$dictionary = $dic; 
			}else{
				$sql_dic = "SELECT defaultdic FROM facebookusers WHERE uid='{$user}'";
				$res_dic = mysql_query($sql_dic);
				$result_dic = mysql_fetch_array($res_dic);
				$dictionary = $result_dic[0];
			}

    		//$dictionary = 'sow';  	
    		$gametype = 'R';	
			if ($profileid) {
           	 	$ids = array();
           	 	array_push($ids, $profileid);
        	}   		
        	$result = startnewgame($user, $ids, $dictionary, $gametype, "");
        	//print_r ($result);
            $gid = $result[1];
            $pid = $result[2];
            $password = $result[3];
            if(isset($_REQUEST['notification'])){
            	$url = FB_APP_PATH . "?action=viewboard&notification=y&gid={$gid}&pid={$pid}&password={$password}&newgame=1&gametype={$gametype}&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]);  
            }else{
            	$url = FB_APP_PATH . "?action=viewboard&gid={$gid}&pid={$pid}&password={$password}&newgame=1&gametype={$gametype}&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]);
            }
            //echo $url;exit;
            echo "<script type='text/javascript'>top.location.href = '$url';</script>";
            exit;
        break;
    
	    case "rematch":

	    	$sql_rematch = "SELECT game_type,language,dictionary FROM games WHERE game_id={$_REQUEST['game_id']}";
	    	$res_rematch = mysql_query($sql_rematch);
	    	if (mysql_num_rows($res_rematch) == 0){    	
		    	$sql_rematch = "SELECT game_type,language,dictionary FROM games_over WHERE game_id={$_REQUEST['game_id']}";
		    	$res_rematch = mysql_query($sql_rematch);
		    	if (mysql_num_rows($res_rematch) == 0){
    		
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
		    			$sql_rematch = "SELECT game_type,language,dictionary FROM {$games_overTable} WHERE game_id={$_REQUEST['game_id']}";
						//echo $sql_rematch; exit;
		    			$res_rematch = mysql_query($sql_rematch);
		    			if (mysql_num_rows($res_rematch) == 1){
		    				$cnt = 1;
		    				break;
		    			}
		    		}
		   	 	} else {
		    		$cnt = 1;
		    	}
	    	} else{
	    		$cnt = 1;
	    	}
    	
	    	if ($cnt == 1){
		    	$GAMEROW = mysql_fetch_assoc($res_rematch);
		    	$dictionary = $GAMEROW['dictionary'];
		    	$gametype = $GAMEROW['game_type'];
	    	
		    	if($with) {	    		
		    		$ids = split(',', $with);
		    	}

		    	if ((count($ids) == 1) && (strlen($_REQUEST['name']) > 1)){
		    		$opp_name = $_REQUEST['name'];
		    	}else{
		    		$opp_name = "";
		    	}
	    	
	    	  	    			    		    	
		    	$result = startnewgame($user, $ids, $dictionary, $gametype, $opp_name);
		    	$gid = $result[1];
		    	$pid = $result[2];
		    	$password = $result[3];
		    	$url = FB_APP_PATH . "?action=viewboard&gid={$gid}&pid={$pid}&password={$password}&newgame=1&gametype={$gametype}&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]);
		    	echo "<script type='text/javascript'>top.location.href = '$url';</script>";
		    	exit;
	    	}else {
	    		echo "<script type='text/javascript'>top.location.href = '".FB_APP_PATH."';</script>";
	    		exit;
	    	}
    	
	    	break;

	    
    //when a game is deleted
    case "gamedeleted":
        $action = "";
        $message = "The game has been deleted.";
        break;
    
    //when a game is resigned
    case "gameresigned":
        $action = "";
        $message = "The game has been resigned.";
        break;
}

//if banned user then show banned file 
if($banned == 'y') { $action = "banned"; }

#2064
if ($action == "viewrequest"){
	//if(!DB::$connected) { DB::connect(); }
	//$tot_games=mysql_query("SELECT won,lost,drawn FROM users_stats WHERE email='$user'");
	//$played_res=mysql_fetch_assoc($tot_games);
	//$tot_played=$played_res['won']+$played_res['lost']+$played_res['drawn'];
	if ($tot_played < 10){
		$sql = "SELECT user,dictionary,gametype,name FROM proxyusers where user<>'$user' ORDER BY RAND() LIMIT 1";
		$res = mysql_query($sql);
		if(mysql_num_rows($res) > 0) {
			$return = mysql_fetch_array($res);
		}
		$ids = array();
		array_push($ids, $return['user']);
		$result = startnewgame($user, $ids, $return['dictionary'], $return['gametype'],$return['name']);
		$gid = $result[1];
	    $pid = $result[2];
	    $password = $result[3];
		
	    $url = FB_APP_PATH ."?action=viewboard&gid={$gid}&pid={$pid}&password={$password}&newgame=1&lang={$result[4]}&uids={$result[5]}&with=" . urlencode($result[0]);
	    echo "<script type='text/javascript'>top.location.href = '$url';</script>";
	    exit;
	}
}

if($version == 'new')
	$version = 'new/';
else {
	$version = '';
}

if($version == '') {
	$showTRIALHEADER = 'y';
	/*
	$devusers = array("563981417", "100000614294819", "608036521", "100000993864210", "100001625778660", "100001965336534", "100001953006601","100000667989105");
	if(!in_array($user, $devusers)){
			$version = '';
			$showTRIALHEADER = 'n';		
	} else {
		$showTRIALHEADER = 'y';
	}*/	
}


include_once($version . "layout/header.php");	


switch ($action) {

	case "contactus":
        include_once("$version" . "action/contactus.php");
        break;

    case "blitzboard":
        $username = getMemCache("n-". $user);
        if(!$username) {
        	$username = getNickName($user);
            if(!$username) { $username = "Guest"; }
            setMemCache("n-". $user, $username, false, 600);
        }
        $username = str_replace(' ', '', $username);
        include_once("$version" . "action/blitzboard.php");
        break;

    case "solitaire":
        $username = getMemCache("n-". $user);
        if(!$username) {
        	$username = getNickName($user);
            setMemCache("n-". $user, $username, false, 600);
        }
        $username = str_replace(' ', '', $username);
        include_once("$version" . "action/solitaire.php");
        break;

    case "viewboard":    
        include_once("$version" . "action/viewboard" . strtoupper($fb_force_mode) . ".php");       
        break;

    case "previousgame":
       	include_once("$version" . "action/previousgame.php");
        break;
			
    case "newgame":
        include_once("$version" . "action/newgame.php");
        break;

    case "viewfriends":
        include_once("$version" . "action/viewfriends.php");
        break;

    case "faq":
        include_once("$version" . "action/faq.php");
        break;

    case "rules":
        include_once("$version" . "action/rules.php");
        break;

    case "browse":
        include_once("$version" . "action/browse.php");
        break;

    case "banned":
        include_once("$version" . "action/banned.php");
        break;

    case "profile":
        include_once("$version" . "action/mystats.php");
        break;

    case "gamerequest":
        include_once("$version" . "action/gamerequest.php");
        break;

    case "viewrequest":
        include_once("$version" . "action/viewrequest.php");
        break;

    case "resign-ques":
        include_once("$version" . "action/resign-ques.php");
        break;

    case "mystats":
        include_once("$version" . "action/mystats.php");
        break;

    case "completedgamesold":
        include_once("$version" . "action/completedgamesold.php");
        break;

    case "completedgames":
        include_once("$version" . "action/completedgames.php");
        break;

    case "mysettings":
        include_once("$version" . "action/mysettings.php");
        break;

    case "myfriend":
        include_once("$version" . "action/myfriend.php");
        break;

    case "mobile":
        include_once("$version" . "action/mobile.php");
        break;

    case "privacy":
        include_once("$version" . "action/privacy.php");
        break;

    case "playblitz":
        include_once("$version" . "action/playblitz.php");
        break;

    //---#########1774######
    case "achievements":
	    include_once("$version" . "action/achievements.php");
	    break;
	//----######  #1774 #########
		
    case "reportthanks":
        include_once("$version" . "action/reportthanks.php");
        break;


	    //11-10-12 #1999
	    case "mybingo":
	    	include_once ("action/mybingo.php");
	        break;
	    //11-10-12 #1999

		case "mybingonew":
		        include_once ("$version/action/mybingonew.php");
		        break; 
    
        #2481
       case "whatisnew": ////////////ADDED on 19-11-12 for new lay out whatisnew.php
           include_once("$version/action/whatisnew.php");
           break;

       case "feedback": ////////////ADDED on 19-11-12 for new lay out feedback.php
           include_once("$version/action/feedback.php");
           break;    

	       case "showmyid":
		   echo "<br/><br/><h3>Your Lexulous ID is: " . $user . "</h3><br/><br/>";
	        	break;
    
    
      case "upgrade":
       	include_once("$version/action/upgrade.php");
       	break;

       	case "userBlock":
       		include_once("$version/action/userBlock.php");
       		break;

    	
       case "reset_stats":
       	include_once("$version/action/reset_stats.php");
       	break;
    
        case "tos":
           include_once("$version/action/tos.php");
           break;
       #2481
        
		
    default:
        include_once("$version" . "action/default.php");
        break;
}

include_once("$version" . "layout/footer.php");


 
function startRequest($batched_request, $token) {
       $postarray = array();
       $postarray['batch'] = (json_encode($batched_request));
       $postarray['access_token'] = $token;
       $postarray['method'] = "post";
       $result = _callURL("https://graph.facebook.com/", $postarray, "POST");
 }
 
 function _callURL($url, $params = null, $verb = 'GET') {
       $cparams = array(
           'http' => array(
               'method' => $verb,
               'ignore_errors' => true
           )
       );
 
       if ($params !== null) {
           $params = http_build_query($params);
           if ($verb == 'POST') {
               $cparams['http']['content'] = $params;
           } else {
               $url .= '?' . $params;
           }
       }
 
       $context = stream_context_create($cparams);
       $fp = fopen($url, 'rb', false, $context);
 
       if (!$fp) {
           $res = false;
       } else {
           // If you're trying to troubleshoot problems, try uncommenting the
           // next two lines; it will show you the HTTP response headers across
           // all the redirects:
           // $meta = stream_get_meta_data($fp);
           // var_dump($meta['wrapper_data']);
           $res = stream_get_contents($fp);
       }
 
       if ($res === false) {
           return null;
       }
 
       return $res;
 }
    
?>