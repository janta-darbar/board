<?

if($chl == 1) {
	echo "<script>_gaq.push(['_trackEvent', 'Incoming Challenge', 'Accepted', '".$uids."']);</script>";
}

if($_COOKIE['showNewFlash'] == 'y') {
	$flash_name = NEW_BOARD_FLASH_PROTOCOL;	
	$flash_width = 700;
	$flash_height = 540;
}
elseif($_COOKIE['showCircleFlash'] == 'y') {
	$flash_name = WS_BOARD_CIRCLES;
	$flash_width = 590;
	$flash_height = 376;
}
elseif($_COOKIE['showBlackFlash'] == 'y') {
	$flash_name = WS_BOARD_BLACK;
	$flash_width = 590;
	$flash_height = 376;
}
else {
	$flash_name = WS_BOARD_LEGACY;
	$flash_width = 590;
	$flash_height = 376;
}

if(!DB::$connected) { DB::connect(); }
$res = mysql_query("select dictionary, users_info, boardCreated, startedon, locked from games where game_id  = $gid"); /////locked added on 10_7_12
if(mysql_num_rows($res) > 0) {
	$row = mysql_fetch_array($res);
	$users_info=$row['users_info'];
	if($row['boardCreated'] == 'N') {
		$functionValue = false;
	} else 
		$functionValue = true;
		
	//---added on 10_7_12--------//
	if ($row['locked'] == 'y'){
		echo "<div class=\"yellow_box\"><span class=\"yellow_box_left\"></span><div class=\"yellow_box_mid\"><span class=\"text_grey_14\">This game board is temporarily unavailable. Please try again after 10 minutes.</span></div><span class=\"yellow_box_right\"></span><div style=\"clear:both;\"></div></div><br /><br />";
		exit;
	}
	//----End 10_7_12---------//
} else {
	//$res = mysql_query("select dictionary, startedon from games_over where game_id  = $gid"); 
	$res = mysql_query("SELECT dictionary, startedon, GROUP_CONCAT( email SEPARATOR ', ' ) AS emails, GROUP_CONCAT( nickname SEPARATOR ', ' ) AS nicknames FROM games_over, users_over WHERE games_over.game_id = users_over.game_id AND games_over.game_id ={$gid}");
	//if(mysql_num_rows($res) > 0) {
	//	$row = mysql_fetch_array($res);
	//}
	$row = mysql_fetch_assoc($res);
	if(!$row['startedon']) {
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
	
			$res = mysql_query("SELECT dictionary, startedon, GROUP_CONCAT( email SEPARATOR ', ' ) AS emails, GROUP_CONCAT( nickname SEPARATOR ', ' ) AS nicknames FROM $games_overTable, $users_overTable WHERE $games_overTable.game_id = $users_overTable.game_id AND $games_overTable.game_id ={$gid}");
			$row = mysql_fetch_assoc($res);
			//print_r ($row);
			if($row['startedon']) {
				break;
			}
		}
	}
}

$dic=$row['dictionary'];

if($dic=="sow")
	$dictionary=" ,UK English";
else if($dic=="twl")	
	$dictionary=" ,US English";
else if($dic=="fr")	
	$dictionary=" ,French";
else if($dic=="it")	
	$dictionary=" ,Italian";

if((!$functionValue) && (!$showGameOver)) {
	// ONLY IF ITS AN ACTIVE GAME THEN SHOW THE BOARD CUSTOMIZATION OPTION
	
	// over here we will show the new Flash Customization Option
	// for the board
?>

<div style="clear: both;margin-top:10px;"></div>
<div class="board" 
	id="swfContainerCustom"></div>
<script type="text/javascript">
    var flashvars = {
        userid:'<?=$user?>',
        serverIP:'<?=SERVER_IP?>',
        gid: "<?=$gid?>",
        pid: "<?=$pid?>",
        protocol:"<?=$URLPREFIX?>",
        password: "<?=$password?>",
        typeOfBoard:"custom"
    };
    var params = {wmode: "transparent", allowscriptaccess: "always"};
    var attributes = {};
    swfobject.embedSWF("<?=APP_CUSTOMIZE_RULE_SWF?>", "swfContainerCustom", "656", "460", "9.0.0","", flashvars, params, attributes);
    </script>
<div style="clear: both;"></div>
	<?
} else {
	$FileIO = new FileIOModel();////////////////////////added
	if(($showGameOver) && (!$FileIO->checkExistFile($gid, "board", date($row['startedon'])))) {
		// this means the game is over and the board was deleted after 90 days.
		echo "<div class=\"yellow_box\"><span class=\"yellow_box_left\"></span><div class=\"yellow_box_mid\"><span class=\"text_grey_14\">Sorry, this game board is unavailable. We store finished games for 90 days only.</span></div><span class=\"yellow_box_right\"></span><div style=\"clear:both;\"></div></div><br /><br />";
		exit;
	}

	$showboard = "true";
	if(!$pid) {
		echo "Due to multiple user requests for privacy, you cannot view games in which you have not played.<br/><br/>To access your own games, please use the \"ARCHIVES\" option in the QUICK LINKS menu above.";
		exit;
	}

	if($showboard == "true") {
	
		if($lang == "EN") { $lang = ""; }
		$skipgameurl = '<a href="'.FB_APP_PATH.'?action=jump&skipgid=' . $gid . '">next active game</a>';
		$similargameurl = '<a href="'.FB_APP_PATH.'?action=newgame&similarto=' . $gid . '" target="_top">start similar game</a>';
		?>

<div>

	<div class="body_container">
	
	<?php if(isset($_REQUEST['notification'])){

		?>
		
			<div class="notifi_row" id="notif_row" style="margin: 10px 0px 0px 0px;">
				<p>Do you want to disable notifications?</p>
				<div class="noti_btn_sec">
					<a class="red_button2" href="javascript:void(0);" onclick="javascript:notification_disabled(<?=$user?>,'y');"> YES </a>
					<a class="button_gray" href="javascript:void(0);" onclick="javascript:notification_disabled(<?=$user?>,'n');"> NO </a>
				</div>
				<!-- notifi_row End -->
			</div>
			<div class="clr"> &nbsp; </div>
		

		<script>
			function notification_disabled(user,notification){
			
				$.ajax({
					type: "POST",	
				    url: "ajax/notification_disabled_ajax.php?fbuserid="+user+"&notification="+notification,
				    success: function (result){
				    	if(notification=='y'){
							var html = "<p>System notifications have been disabled. To enable, please click ";
							html += "<a href='javascript:void(0);' onclick='javascript:notification_disabled(<?=$user?>,\"n\");'> HERE </a>";
							html += ".</p>";
							$("#notif_row").html(html);
						}else if(notification=='n'){
							$("#notif_row").html("<p>System notifications have been enabled.</p>");
						}
				    }
				});
			}
</script>

		
	<?}	?>
	

	<?
	if($newgame==1) {
			$friendsId=getfriendList($user,$uids);
	
			$frienduidList=explode(',',$uids);
			$userNames=explode(',',$with);
			for($i=0;$i<count($frienduidList);$i++)
			{
				if (in_array($frienduidList[$i], $friendsId)) {
			    $withFrnd=$withFrnd .",".$userNames[$i];
			    $uidlst=$uidlst .",".$frienduidList[$i];
				}
			}  
			$withFrnd= substr($withFrnd, 1);
			$uidlst= substr($uidlst, 1);
			if((count($friendsId)>0)& (!isset($_REQUEST['notification'])) ){
				$message = "Let $withFrnd know you've started a game";
	    		echo "<div class=\"yellow_box\"><span class=\"yellow_box_left\"></span><div class=\"yellow_box_mid\"><span class=\"text_grey_14\"><a href=\"#\" class=\"text_blue_12\" onclick=\"showNewGamePublish_new('$user','$uidlst');\">$message</a></span></div><span class=\"yellow_box_right\"></span><div style=\"clear:both;\"></div></div>";
			}
		}
	?>
	<div id="game_info_section" class="clear" style="margin-top: 16px;min-height:185px;margin-bottom:15px;">
		
		<? if ($hide_advert_option=='n'){?>
			<div style="width:300px;float: left;margin-top: 4px;">
			<!-- <img src="<?=APP_IMG_URL_NEW?>adv01.png" alt="" /> --> 

			<script type='text/javascript'>
			<!--//<![CDATA[
			   document.MAX_ct0 ='';
			   var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("zoneid=65016");document.write("&amp;nodis=1");
			   document.write ('&amp;cb=' + m3_r);
			   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
			   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
			   document.write ("&amp;loc=" + escape(window.location));
			   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
			   if (document.context) document.write ("&context=" + escape(document.context));
			   if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {
			       document.write ("&amp;ct0=" + escape(document.MAX_ct0));
			   }
			   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
			   document.write ("'></scr"+"ipt>");
			//]]>--></script>
			<br /><a href="<?=FB_APP_PATH?>?action=upgrade" target="_top" style="line-height:24px;font-size:11px;float:right;">Hide this ad</a>
			<div style="clear:both;"></div>
		
		</div>
		<? } ?>
		<?if ($hide_advert_option=='n'){?>
			<div style="width:400px;float: right;">
		<?}else{?>
			<div style="width:400px;float: left;">
		<?}?>
				<div id="game_stats">
					<div class="clear" style="margin-bottom: 10px;">
	                	<span style="color: #245dc2;float: left;font-weight: bold;font-size: 12px;">
	                		Game #<?=$gid?><?=$dictionary?> 
							<?if($gametype == "C") {?> <a href="#" class="game_name1" onmousemove="showToolTip(event, 'you can challenge your <br/>opponent\'s word if you feel <br/>it\'s a bluff!');" onmouseout="hideToolTip();">(challenge game)</a><?}?>
						</span>
																
					</div>
					<div class="game_stats_hd clear" style="background:#eaf3f9;color:#333;font-weight:bold;">
						<span class="flt_left" style="width:96px;">Players</span>
						<ul class="clear">
							<li>Played</li>
							<li>Won</li>
							<li>Lost</li>
							<li>Drawn</li>
							<li>Bingos</li>							
						</ul>
					</div>				
					<div class="players_details_container">
						<?=display_opponent_badges_New($gid,$user);?>
					</div>
				</div>
		</div>		
	</div>
	<?
	if ($_REQUEST['showGameOver'] != 1){
		$users_infoArr=explode("|",$users_info);
		if(count($users_infoArr)==2){
			$playersCnt = 2;
			$users=array();
			for($i=0;$i<count($users_infoArr);$i++){
				$users=$users_infoArr[$i];
				$info=explode(",",$users);
				if($info[0]!=$user){
					$oppid=$info[0];
					$oppname=$info[2];
				}
			
			}
		}
	}elseif ($_REQUEST['showGameOver'] == 1){
		$emailArr = explode(",", $row['emails']);
		$nicknameArr = explode(",", $row['nicknames']);
		if(count($emailArr)==2){
			$playersCnt = 2;
			foreach ($emailArr as $key=>$value){
				if ($value != $user){
					$oppid = $value;
					$oppname=$nicknameArr[$key];
				}
			}
		}
	}
	
	if($playersCnt == 2){
		$onetoone = get_onetoone_stats($user, $oppid);
	?>
	<div id="headToHeadId">
	<div class="headtohead_bg clear">
	  	<div class="headtohead_user_img clear">
	  	 	<span id="newphoto_<?=$user?>" onmouseover="$('#ministats_<?=$user?>').css('display','block');" onmouseout="document.getElementById('ministats_<?=$user?>').style.display='none'"></span>
	  	 		<span class="versus">vs.</span>
	  	 	<span id="newphoto_<?=$oppid?>" onmouseover="$('#ministats_<?=$oppid?>').css('display','block');" onmouseout="document.getElementById('ministats_<?=$oppid?>').style.display='none'"></span>
	  	  </div>
	  	  <div class="rating_holder clear" style="float: left; width: 274px; padding: 0px 2px; border: medium none; color: rgb(51, 51, 51); margin: 4px 10px 0 0;">
	  	    <div class="rating_text" style="width: 60px; line-height: 8px;font-weight:bold;">Played<br /><span style="font-size:11px;color:#333;"><?=$onetoone['played']?></span></div>
	  	    	<div class="rating_text" style="width: 75px; line-height: 8px;font-weight:bold;">You Won<br /><span style="font-size:11px;color:#333;"><?=$onetoone['won']?> (<?if($onetoone['played']==0)echo 0;else echo round(($onetoone['won']*100)/$onetoone['played']); ?>%)</span></div>
	  	        <div class="rating_text" style="width: 75px; line-height: 8px;font-weight:bold;">You Lost<br /><span style="font-size:11px;color:#333;"><?=$onetoone['lost']?> (<?if($onetoone['played']==0)echo 0;else echo round(($onetoone['lost']*100)/$onetoone['played']); ?>%)</span></div>
	  	        <div class="rating_text" style="width: 60px; line-height: 8px;font-weight:bold;">Draws<br /><span style="font-size:11px;color:#333;"><?=$onetoone['drawn']?> (<?if($onetoone['played']==0)echo 0;else echo round(($onetoone['drawn']*100)/$onetoone['played']); ?>%)</span></div>
	  	    </div>
	  	        <div class="flt_right" style="margin-top: 4px">	
	  	        <a href="<?=FB_APP_PATH?>?action=rematch&with=<?=trim($oppid)?>&name=<?=$oppname?>&gameid=<?=$gid?>&rematch=1" target="_top" class="grey_button flt_left" style="width: 24px;height: 20px;padding-top:2px;margin-right:7px;" onmousemove="showToolTip_new(event,'Rematch','default');" onmouseout="hideToolTip_new()"><img src="<?= APP_IMG_URL_NEW?>refresh_icon_board.png" alt="" /></a>
	  	       	<a href="<?=FB_APP_PATH?>?action=newgame&similarto=<?=$gid?>" target="_top" class="grey_button grey_button_normal flt_left" style="font-size: 12px;height: 8px;line-height: 9px;">Start Similar</a>
	  	        <a href="<?=FB_APP_PATH?>?action=jump&skipgid=<?=$gid?>" target="_top" class="grey_button grey_button_normal flt_left" style="font-size: 12px;height: 8px;line-height: 9px;margin:0 8px;">Next Game</a>           
	  	        <a href="<?=FB_APP_PATH?>?" target="_top" class="grey_button grey_button_normal flt_left" style="font-size: 12px;height: 8px;line-height: 9px;">Home</a>            
				</div>
			<div id="ministats_<?=$user?>" style="z-index: 100; opacity: 1;position: absolute;display: none;margin: 36px 0 0 -14px;" onmouseover="$('#ministats_<?=$user?>').css('display','')" onmouseout="document.getElementById('ministats_<?=$user?>').style.display='none'"></div>
			<div id="ministats_<?=$oppid?>" style="z-index: 100; opacity: 1;position: absolute;display: none;margin: 36px 0 0 32px;" onmouseover="$('#ministats_<?=$oppid?>').css('display','')" onmouseout="document.getElementById('ministats_<?=$oppid?>').style.display='none'"></div>	
		</div>
	</div>
		<?}?>	
	<? /*if ($_REQUEST['analyze'] == 1){
		$amazonTable = '';
		$game_row = array();
		$games_overTable = "games_over";
		$result = mysql_query("select game_id,startedon from $games_overTable where game_id = '{$_REQUEST['gid']}'");
		$cnt = mysql_num_rows($result);
		if($cnt <= 0) {
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
				//echo $games_overTable;
				$result = mysql_query("select game_id,startedon from $games_overTable where game_id = '{$_REQUEST['gid']}'");
				$cnt = mysql_num_rows($result);
				if ($cnt >= 1){	
					$game_row = mysql_fetch_array($result);					 			
					break;
				}
			}
		}else if ($cnt > 0){
			$game_row = mysql_fetch_array($result);
		}else{
			////error
		}
		if (count($game_row) > 0){
			$pDate = date_parse($game_row['startedon']);
            $mth = strlen($pDate['month'])==2?$pDate['month']:"0".$pDate['month'];
            $amazonTable = 'testLexulousGame' . $mth . substr($pDate['year'],2);	
		}
		//echo "-------$amazonTable----------";
		
		
		$res_gameid = mysql_query("select gameid from game_analyzer where userid='{$user}'");
		$result_gameid = mysql_fetch_assoc($res_gameid);		
		$games_arr = explode(",", $result_gameid['gameid']);
		if (in_array($gid, $games_arr)){
			
		}else{	
			mysql_query("update game_analyzer set gameid=concat_ws(',',gameid,'{$gid}') where userid={$user}");
			if (mysql_affected_rows() == 0){				
				mysql_query("INSERT INTO game_analyzer(userid,gameid)VALUES($user,'$gid')");
			}
		}
		
	?>
	<div style="margin:19px 0 0 0;" id="swfContainer">
		<!-- <img src="<?=APP_IMG_URL_NEW?>game_board_new.png" alt="" /> -->
	</div>
	
	
	<script type="text/javascript">
	var flashvars = {
		uid:"<?=$user?>",
		gid:"<?=$gid?>",
		pid:"<?=$pid?>",
		password:"<?=$password?>",
		fb:"y",
		fbTable:"<?=$amazonTable?>",
		liveVersion:"n",
		serverIP:"<?=serverIP?>",
		serverPort:"<?=serverPort?>",
		EserverIP:"<?=EserverIP?>",
		EserverPort:"<?=EserverPort?>"
	};

	var params = {wmode: "transparent", allowscriptaccess: "always"};
	var attributes = {};
	swfobject.embedSWF("<?=CDN_URL?>flash/Lexalizer.swf", "swfContainer", "700", "530", "9.0.0","", flashvars, params, attributes);
	</script>
	
	
	<?}  */?>
	<div  style="float:left; width: 700px; min-height: 400px;">
		<div id="swfContainerMain"  style="z-index:-1;"></div>
	</div>
	
	<div class="game_notes_section clear">
		<div class="game_notes_heading clear">
			<ul>
	        	<li><a href="javascript:void(0);" class="active" id="noteTab" onclick="viewboardToggleTab_new('note');">Notes</a></li>
	        	<li><a href="javascript:void(0);" id="graphTab" onclick="viewboardToggleTab_new('graph');">Graph</a></li>
	        	<li><a href="javascript:void(0);" id="dictionaryTab" onclick="viewboardToggleTab_new('dictionary');">Dictionary</a></li>
	        </ul>
        </div>
		<div class="game_notes">		            
            <div id="noteDiv">
                    <span>You can write private notes here. For example, when you think of a nice move, you can write it down in case you forget later.</span><br />
                    <textarea rows="1" cols="49" type="text" id="notes" value="Write Here" class="input_textarea" style="width:250px;height:80px;"><?=getNotes(base64_encode($gid . '-' . $user));?></textarea>
                    <?
                    	$fileToSave = base64_encode($gid . '-' . $user);
                    ?>
                    <div class="clear">
                    	<a href="#" class="blue_button blue_button_small flt_left" onclick="saveNote('<?=$fileToSave?>'); return false;">Save</a>
                    	<span style="color:#fe2232;padding-left: 10px;float: left;" id="savedresult"></span>
                    </div>
            </div>

            <div id="graphDiv" style="display: none;">
                    <span>The graph below shows how the scores progressed during the game. Roll over your mouse to see the scores!</span><br />
                    <?
                        $charturl = "https://aws.rjs.in/wordscraper/getFlashChartData.php?gid=$gid&pid=$pid&password=$password";
                    ?>		                  
                  <!--<div id="swfContainer1"></div>-->
                  <div id="swfContainerGraph"></div>
            </div>
            
            <div id="dictionaryDiv" style="display: none;">
                    <span>You can search words here.</span><br />
                    <form action="http://www.oneworddaily.com/" method="post" target="_blank" name= "dictionary">
                    	<input type="text" value="" style="width:180px; height: 30px; margin-bottom:15px;margin-top:10px;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 3px 3px 3px 3px;" name="Word" id="Word"/>	                   		
	                    <div class="clear">
	                    	<a href="#" class="blue_button blue_button_small flt_left" onclick="goDictionary(); return false;">Go</a>
	                    </div>
                    </form>
            </div>
		</div>
		<div style="float:right;margin-top:-40px;">
			<span> 
		<? if ($hide_advert_option=='n'){?>

<script type='text/javascript'>
<!--//<![CDATA[
   document.MAX_ct0 ='';
   var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
   var m3_r = Math.floor(Math.random()*99999999999);
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("zoneid=65016");document.write("&amp;nodis=1");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if ((typeof(document.MAX_ct0) != 'undefined') && (document.MAX_ct0.substring(0,4) == 'http')) {
       document.write ("&amp;ct0=" + escape(document.MAX_ct0));
   }
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'></scr"+"ipt>");
//]]>--></script>
			<br /><a href="<?=FB_APP_PATH?>?action=upgrade" target="_top" style="line-height:14px;font-size:11px;float:right;">Hide this ad</a>
			<div style="clear:both;"></div>
		<? } ?>
			</span>
		</div>
	</div>

	<script>
	function gotoURL(path) {
    	document.setLocation(path);
	}
	</script>
	<script type="text/javascript">
		
		var flashvars = {	   
				showGameOver:'<?=$showGameOver?>',     	
	         	gid: "<?=$gid?>",
	         	pid: "<?=$pid?>",
	         	fb:'y',
	         	facebook:'y',
	         	password: "<?=$password?>",	         	         	
	         	fb_sig_user:"<?=$user?>",
				fb_sig_session_key:"<?=urlencode($facebook->getAccessToken());?>",
				fbnexturl:"<?=FB_HOME?>",
				fbhome:"<?=FB_HOME?>",
	         	numberedboardvar:'<?=$settingCookie[5]?>',
		        protocol:"<?=$URLPREFIX?>",
	         	lang: "<?=strtolower($lang)?>",
	         	helpURL:"<?=FB_APP_PATH?>?action=faq"	         	 	
	     	};
	     	var params = {wmode: "transparent", allowscriptaccess: "always"};
	     	var attributes = {};
			<? if($user != '1') { ?>
				swfobject.embedSWF("<?=FLASH_PATH?><?=$flash_name?>", "swfContainerMain", "<?=$flash_width?>", "<?=$flash_height?>", "9.0.0","", flashvars, params, attributes);
			<?  } else { ?>
				swfobject.embedSWF("<?=FLASH_PATH?><?=$flash_name?>", "swfContainerMain", "<?=$flash_width?>", "<?=$flash_height?>", "9.0.0","", flashvars, params, attributes);
			<? } ?>		
	</script>
	<script>
	 var flashvars_g = {data:'<?=urlencode($charturl);?>'};
	 var params_g = {wmode: "transparent", allowscriptaccess: "always"};
	 var attributes_g = {};
	swfobject.embedSWF("https://dbyxbgd9ds257.cloudfront.net/flash/open-flash-chart.swf", "swfContainerGraph", "370", "200", "9.0.0","", flashvars_g, params_g, attributes_g);
	</script>
<? 
	}

}
?>
<script type="text/javascript">

var gid=<?=$gid?>;
window.onload=function(){
	//getGameNote(gid,fb_uid);
	uidListArr = uidList.split(',');//alert(uidList);
	showMiniStatsForUsers(uidList,"viewboard");
};

</script>
