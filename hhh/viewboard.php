<div class="body_container">	
<?
	if ($_REQUEST['prev'] == 1){
		echo "<div class=\"yellow_box\"><span class=\"yellow_box_left\"></span><div class=\"yellow_box_mid\"><span class=\"text_grey_14\">This game board is over 4 months old. We store boards for the past 3 months only.</span></div><span class=\"yellow_box_right\"></span><div style=\"clear:both;\"></div></div><br /><br />";
		exit();
	}

$analyzeUser = false;
	$sql = "SELECT * FROM  `subscribe_users_analyzer`  WHERE uid = '$user' AND `expire` > NOW()";
	$res = mysql_query($sql);
	if (mysql_num_rows($res) > 0){
		$analyzeUser = true;
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
	}else{
		$analyzeUser = false;
	}	

if($newgame==1) {
		$friendsId=getfriendList($user,$uids);

		$uidList=explode(',',$uids);
		$userNames=explode(',',$with);
		for($i=0;$i<count($uidList);$i++)
		{
			if (in_array($uidList[$i], $friendsId)) {
		    $withFrnd=$withFrnd .", ".$userNames[$i];
		    $uidlst=$uidlst .",".$uidList[$i];
			}
		}  
		$withFrnd= substr($withFrnd, 1);
		$uidlst= substr($uidlst, 1);
		if( (count($friendsId)>0) & (!isset($_REQUEST['notification'])) ){
			$message = "Let $withFrnd know you've started a game";
    		echo "<div class=\"yellow_box\"><span class=\"yellow_box_left\"></span><div class=\"yellow_box_mid\"><span class=\"text_grey_14\"><a href=\"#\" class=\"text_blue_12\" onclick=\"showNewGamePublish_new('$user','$uidlst');\">$message</a></span></div><span class=\"yellow_box_right\"></span><div style=\"clear:both;\"></div></div>";
		}
	}
?>	

	<?if($tot_played >= 10){?>
	
	<div id="game_info_section" class="clear" style="margin-top: 8px;">
		<!--#3175-->
		<?if($hide_advert_option=='n'){?>
			<div style="width:300px;float: left;margin-top: 4px;">

				<script type='text/javascript'>
				<!--//<![CDATA[
				   document.MAX_ct0 ='';
				   var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
				   var m3_r = Math.floor(Math.random()*99999999999);
				   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
				   document.write ("zoneid=65013");document.write("&amp;nodis=1");
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
				
							<br /><a href="<?=FB_APP_PATH?>?action=upgrade" target="_top" style="line-height:14px;font-size:11px;float:right;margin-top: 5px;">Hide this ad</a>
								<div style="clear:both;"></div>
			</div>
		<?}?>
		<?if ($hide_advert_option=='n'){?>
			<div style="width:400px;float: right;">
		<?}else{?>
			<div style="width:400px;float: left;">
		<?}?><!--#3175-->	
				<div id="game_stats">
					<div class="clear" style="margin-bottom: 10px;">
	                	<span style="color: #245dc2;float: left;font-weight: bold;font-size: 12px;">
	                		Game #<span id="currentgame_id"><?=$gid?></span><span id="game_language"></span> 
							<?if($gametype == "C") {?> <a href="#" class="game_name1" onmousemove="showToolTip(event, 'you can challenge your <br />opponent\'s word if you feel <br />it\'s a bluff!');" onmouseout="hideToolTip();">(challenge game)</a><?}?>
						</span>
						<!--<span class="viewboard_refresh_link clear">
							<a href="<?=$_SERVER['HTTP_REFERER']?>" target="_top" style="float: left;margin-right:10px;">refresh</a>
							<a href="<?=FB_APP_PATH?>?action=jump&skipgid=<?=$gid?>" target="_top" style="float: left;">next active game</a>
						</span> //-->												
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
					<div class="players_details_container" id="display_opp_badges">
	
						Loading...
						
					</div>
				</div>
		</div>		
	</div>
	
	
	<?}
	if(isset($_REQUEST['notification'])){ ?>
	
			<div class="notifi_row" id="notif_row" style="margin: 10px 0px 0px 0px;">
				<p>Do you want to disable notifications?</p>
				<div class="noti_btn_sec">
					<a class="red_button2" href="javascript:void(0);" onclick="javascript:notification_disabled(<?=$user?>,'y');"> YES </a>
					<a class="button_gray" href="javascript:void(0);" onclick="javascript:notification_disabled(<?=$user?>,'n');"> NO </a>
				</div>
				<!-- notifi_row End -->
			</div>
			<div class="clr"> &nbsp; </div>
		
	<?}	
	?>

		<div id="headToHeadId"></div>	
	<script type="text/javascript">
    var _JS_loader = {
            count : 0,
            scriptArr : [],
            callBack : null,
            isRunning : false,
            add : function(scriptFl) {
                this.scriptArr.push(scriptFl);
            },
            run : function() {
                this.isRunning = true;
                for(var i=0;i<this.scriptArr.length;i++) {
                    this.eachLoad(this.scriptArr[i]);
                }
            },
            eachLoad : function(jsFileObj) {
                var script = document.createElement("script");
                script.type = "text/javascript";
                if (script.readyState) {
                    script.onreadystatechange = function() {
                        if (script.readyState == "loaded" || script.readyState == "complete") {
                            script.onreadystatechange = null;
                            _JS_loader.afterEachLoad(jsFileObj);
                        }
                    };
                } else {
                    script.onload = function() {
                        _JS_loader.afterEachLoad(jsFileObj);
                    };
                }
                
                script.id = jsFileObj.id;
                script.async = jsFileObj.async;
                script.src = jsFileObj.url;
                document.getElementsByTagName("head")[0].appendChild(script);
            },
            afterEachLoad : function(jsFileObj) {
                this.count++;
                if(this.scriptArr.length == this.count) {
                    $(document).ready(function() {
                        if(typeof commonOnLoad == 'function') {
                            commonOnLoad();
                        }
                    });
                }
            }
        };
    	_JS_loader.add({url:'<?=CDN_URL?>board/js/jquery-ui-1.8.21b.min.js',id:'customJquery',async:true});
        _JS_loader.add({url:'https://192.168.100.1/public/FACEBOOKALL/Lexulous/board/js/xLexulous-1.7.1.js',id:'main',async:true});
	
	</script>
	<link href="https://192.168.100.1/public/MAYUR/FACEBOOK/Lexulous/css/lightbox.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="https://192.168.100.1/public/MAYUR/FACEBOOK/Lexulous/js/lightbox-2.6.min.js"></script>
	<link href="<?=CDN_URL?>board/style/fbstyle1.7.1f.css" type="text/css" rel="stylesheet" />
	<div style="margin: 10px 0;">
	<?php
			if($_COOKIE['html5board']=='y'){

				?>
		<div id="elex_gameContainer" style="padding: 0;height: 480px;">
				<div id="elex_headerPanel"></div>
			<div id="elex_temp_loader" class="tempActivityLoader">
				<div>Loading game, Please wait...</div>
			</div>
			<div id="elex_bodyPanel">
				<div id="elex_leftPanel">
					<div id="elex_boardPanelCont" style="position:relative;">
						<ul id="elex_boardPanel"></ul>
					</div>
					<div id="elex_actionPanel">
						<div id="elex_leftActionPanel"></div>
						<ul id="elex_rackPanel"></ul>
						<div id="elex_rightActionPanel"></div>
						<div style="clear: both;"></div>
					</div>

				</div>
				<div id="elex_rightPanel">
					<div id="elex_menuContainer">
						<div id="elex_optionMenu"></div>
					</div>
					<div id="elex_playerList"></div>
					<div id="elex_infoPanel"></div>
					<div id="elex_combinedPanel"></div>
				</div>
			</div> 
			<div class="analysePopup" style="display:none;margin:30px 0 0 33px" id="join_popup">
	            <div class="analysePopup_container">
	                <div>
	                    <div style="float:left;">
	                        <h2 class="popupHeading_Text">Analyse Games</h2>
	                        <p class="popupHeading_subText">Please select a package below to continue.<br />All packages allow you to analyse unlimited games.</p>
	                    </div>
	                    <span class="cross" onclick="subsribePopup.destroy();return false;">x</span>
	                    <div style="clear:both;"></div>
	                </div>
	                <div style="border-top:1px solid #eaeaea;">
	                    <div class="popup_row">
	                        <!-- <span class="coin"></span> -->
	                        <span class="column2 popupHeading_Text"><span style="font-weight: bold;">1 Month</span> <span class="text2">Analyse unlimited games</span></span>
	                        <!--<span class="filler_column">&nbsp;</span>-->
	                        <div style="float:right;">
	                        	<span class="fbcredit_icon" style="margin: 4px 0 0 0;"></span>
		                        <span class="column2 popupHeading_Text" style="width: 88px;text-align:right;margin-right:10px;"><span style="font-weight: bold;">2.00</span> <span class="text2">USD</span></span>
		                        <input type="submit" value="BUY NOW" onclick="placeOrder('subscribe_one_month');return false;" style="float:left;line-height:16px;width:82px;height:30px;cursor: pointer;padding-top: 2px;" target="_top" class="blue_button" id="submitbutton" />
		                        <!-- <span class="blue_button">BUY</span> -->		                       
		                    </div>
	                        <div style="clear:both;"></div>
	                    </div>
	                    
	                    <div class="popup_row">
	                        <!-- <span class="coin"></span> -->
	                        <span class="column2 popupHeading_Text"><span style="font-weight: bold;">3 Months</span> <span class="text2">Analyse unlimited games</span></span>
	                        <!--<span class="filler_column">&nbsp;</span>-->
	                        <div style="float:right;">
	                        	<span class="fbcredit_icon" style="margin: 4px 0 0 0;"></span>
		                        <span class="column2 popupHeading_Text" style="width: 88px;text-align:right;margin-right:10px;"><span style="font-weight: bold;">5.00</span> <span class="text2">USD</span></span>
		                        <input type="submit" value="BUY NOW" onclick="placeOrder('subscribe_three_month');return false;" style="float:left;line-height:16px;width:82px;height:30px;cursor: pointer;padding-top: 2px;" target="_top" class="blue_button" id="submitbutton" />
		                        <!-- <span class="blue_button">BUY</span> -->		                       
		                    </div>
	                        <div style="clear:both;"></div>
	                    </div>	
	                    
	                    <div class="popup_row">
	                        <!-- <span class="coin"></span> -->
	                        <span class="column2 popupHeading_Text"><span style="font-weight: bold;">6 Months</span> <span class="text2">Analyse unlimited games</span></span>
	                        <!--<span class="filler_column">&nbsp;</span>-->
	                        <div style="float:right;">
	                        	<span class="fbcredit_icon" style="margin: 4px 0 0 0;"></span>
		                        <span class="column2 popupHeading_Text" style="width: 88px;text-align:right;margin-right:10px;"><span style="font-weight: bold;">8.00</span> <span class="text2">USD</span></span>
		                        <input type="submit" value="BUY NOW" onclick="placeOrder('subscribe_six_month');return false;" style="float:left;line-height:16px;width:82px;height:30px;cursor: pointer;padding-top: 2px;" target="_top" class="blue_button" id="submitbutton" />
		                        <!-- <span class="blue_button">BUY</span> -->		                       
		                    </div>
	                        <div style="clear:both;"></div>
	                    </div>
	                    
	                    <div class="popup_row">
	                        <!-- <span class="coin"></span> -->
	                        <span class="column2 popupHeading_Text"><span style="font-weight: bold;">1 Year</span> <span class="text2">Analyse unlimited games</span></span>
	                        <!--<span class="filler_column">&nbsp;</span>-->
	                        <div style="float:right;">
	                        	<span class="fbcredit_icon" style="margin: 4px 0 0 0;"></span>
		                        <span class="column2 popupHeading_Text" style="width: 88px;text-align:right;margin-right:10px;"><span style="font-weight: bold;">12.00</span> <span class="text2">USD</span></span>
		                        <input type="submit" value="BUY NOW" onclick="placeOrder('subscribe_one_year');return false;" style="float:left;line-height:16px;width:82px;height:30px;cursor: pointer;padding-top: 2px;" target="_top" class="blue_button" id="submitbutton" />
		                        <!-- <span class="blue_button">BUY</span> -->		                       
		                    </div>
	                        <div style="clear:both;"></div>
	                    </div>              
	                </div>
	                <!-- <div class="footer">
	                    <span class="footer_text">After you complete the payment, you'll be able to analyse<br />
	                        games without getting this screen till the expiry date.</span>
	                    <span class="logo_array"></span>
	                    <div style="clear:both;"></div>
	                </div>-->
	            </div>
        	</div>
		</div>
				<script type="text/javascript">
				function commonOnLoad() {
		            AppController.init({
		                gid : "<?=$gid?>",
		                pid : "<?=$pid?>",
		                password : "<?=$password?>",
		                authuser : "<?=$user?>",
		                authsecret:"<?=$USER_TOKEN?>",
		                sitecode : 1,
		                msgSize:"<?=$settingCookie[7]?>",		
		                askBeforePlay:"n", 
		                showNumberBoard : "<?=($settingCookie[5]=='y')?true:false?>",
		                showGameOver : "<?=($_REQUEST['showGameOver']==1)?1:0?>",
		                nextGame : "6108034,1,US",
		                analyzeUser : <?=json_encode($analyzeUser)?>,
		                proUser: false,
		                firstTime : <?=($tot_played<10)?'true':'false'?>,
		                autoTilePlace :false,
		                paymentSuccess : "<?(!$_REQUEST['success']) ? print '2':print $_REQUEST['success']?>",
		                protocol:"<?=$URLPREFIX?>",
		                hideAdvert:"<?=$hide_advert_option?>",
		                boardViewing : false,
		                pop : pop           
		            });
		         }
		        </script>
        <?php

			}else{
				?>
				<div style="float:left; width: 584px; height: 390px;margin:0 5px 0 0;">
					<div id="swfContainer"  style="z-index:-1;"></div>
				</div>
				<!-- <div class="board" id="swfContainer1"></div> -->
				<script type="text/javascript">
  
					var flashvars = {
						fb_sig_user:"<?=$user?>",
						serverIP:"aws.rjs.in",
						lang:"<?=strtolower($lang)?>",
						showGameOver:"<?=($_REQUEST['showGameOver']==1)?1:0?>",
						gid:"<?=$gid?>",
						pid:"<?=$pid?>",
						password:"<?=$password?>",
						facebook:"y",
						fb_sig_session_key:"<?=urlencode($facebook->getAccessToken());?>",
						autoRefreshBoard:"<?=$settingCookie[4]?>",
						numberedboardvar:"<?=$settingCookie[5]?>",
						chatvar:"<?=$settingCookie[7]?>",
						autosortvar:"<?=$settingCookie[6]?>"
					};
					var params = {wmode: "transparent", allowscriptaccess: "always"};
					var attributes = {};
					//swfobject.embedSWF("http://play.paltua.com/facebook/flash/<?=$swf?>", "swfContainer", "584", "376", "9.0.0","", flashvars, params, attributes);
					swfobject.embedSWF("https://d35zhpgb1mza1j.cloudfront.net/flash/aws/<?=$swf?>", "swfContainer", "584", "376", "9.0.0","", flashvars, params, attributes);
					
					var flashvars_g = {
						data:"<?=urlencode($charturl);?>"
					};
					var params_g = {wmode: "opaque", allowscriptaccess: "always"};
					var attributes_g = {};
					// swfobject.embedSWF("https://dbyxbgd9ds257.cloudfront.net/flash/open-flash-chart.swf", "swfContainer1", "320", "150", "9.0.0","", flashvars_g, params_g, attributes_g);
				</script>
				<?php
			}



		?>
		
         <script type="text/javascript">
    		if(!_JS_loader.isRunning) {
        	_JS_loader.run();
    		}

    		$('body').on('ANALYZE_POPUP', function() {
            	if(typeof subsribePopup.open() != "undefined") {
            		subsribePopup.open();
            	}
            }); 

    		var subsribePopup = {
    				
    				open : function(userData) {
    					$("#join_popup").show();
    					var left = $("#elex_gameContainer").position().left + ($("#elex_gameContainer").outerWidth(true)/2) - ($("#join_popup").outerWidth(true)/2);
    					var top = $("#elex_gameContainer").position().top + ($("#elex_gameContainer").outerHeight(true)/2) - ($("#join_popup").outerHeight(true)/2);
    					//console.log(left); console.log(top);
    					$("#join_popup").css({"display" : "block",
    						"z-index" : "100001",
    						"position" : "absolute"});//'left':left + "px",'top':top + "px",
    				},
    				
    				destroy : function() {
    					$("#join_popup").hide();
    				}	
    		}
		</script>
	</div>
	<?//}?>

	<div class="game_notes_section clear">
		<div class="game_notes">	<!--#3248-->
				<div class="game_notes_heading clear">
					<ul>
			        	<li><a href="javascript:void(0);" class="active" id="noteTab" onclick="viewboardToggleTab_new('note');">Notes</a></li>
			        	<li><a href="javascript:void(0);" id="graphTab" onclick="viewboardToggleTab_new('graph');">Graph</a></li>
			        </ul>
		        </div>	   <!--#3248-->         
				     <div id="noteDiv">
		                    <span>You can write private notes here. For example, when you think of a nice move, you can write it down in case you forget later.</span><br />
		                    <textarea rows="1" cols="49" type="text" id="notes" value="Write Here" class="input_textarea" style="width:250px;height:80px;"></textarea>
		                    <?
		                    	$fileToSave = base64_encode($gid . '-' . $user);
		                    ?>
		                    <div class="clear">
		                    	<a href="#" class="blue_button blue_button_small flt_left" onclick="saveNote_New(); return false;">Save</a>
		                    	<span style="color:#fe2232;padding-left: 10px;float: left;" id="savedresult"></span>
		                    </div>
		            </div>

		            <div id="graphDiv" style="display: none;">
	                    <span>The graph below shows how the scores progressed during the game. Roll over your mouse to see the scores!</span>
		                    <?
		                        //$charturl = "http://aws.rjs.in/fblexulous/getFlashChartData.php?gid=$gid&pid=$pid&password=$password";                        
		                    ?>		                  
		                  <div id="swfContainer1"></div>
		            </div>
		    
		    
		</div>	
		<div style="float:right;"><!--#3248-->
			<span> 
		<? if ($hide_advert_option=='n'){?>

			<script type='text/javascript'>
			<!--//<![CDATA[
			   document.MAX_ct0 ='';
			   var m3_u = (location.protocol=='https:'?'https://cas.criteo.com/delivery/ajs.php?':'http://cas.criteo.com/delivery/ajs.php?');
			   var m3_r = Math.floor(Math.random()*99999999999);
			   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
			   document.write ("zoneid=65013");document.write("&amp;nodis=1");
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
		</div><!--#3248-->
	</div>	
	
</div>


<script type="text/javascript">

var uidList = '';
var charturl = '';
var gameId;
var head2headStat = {
	     get : function(pid,dic,gametype,usersInfo,gid,pid,password) {
		     
			 charturl = APP_URL_JS+"getFlashChartData.php?gid="+gid+"&pid="+pid+"&password="+password;////chart
			 $("#currentgame_id").text(gid);
			 if(dic == "sow")
				 $("#game_language").text(" ,UK English"); 
			 if(dic == "twl")
				 $("#game_language").text(" ,US English");
			 if(dic == "fr")
				 $("#game_language").text(" ,French");
			 if(dic == "it")
				 $("#game_language").text(" ,Italian");
			 
			 $("#display_opp_badges").text("Loading...");

			 
			 gameId = gid;
			 getGameNote(gid,fb_uid);	
		 
		     var myInfo;
	         var oppInfo = '';
	         var count=0;
	         
	         for(var uid in usersInfo) {
	             if(usersInfo[uid]['pid'] == pid) {
	                 myInfo = uid.substr(1) + "," + usersInfo[uid]['name']; 
	             } else {
	                 oppInfo += uid.substr(1) + "," + usersInfo[uid]['name']+"|";
	             }
	             count++;
	         }
			 	        
	         $.ajax({
	           url : APP_URL_JS + "/ajax/head2headstats.php?myinfo="+myInfo+"&oppinfo="+oppInfo+"&dic="+dic+"&gametype="+gametype+"&gid="+gid,
	           dataType : "jsonp",
	            jsonp : "callback",
	            jsonpCallback: "head2headStat.draw"
	         });	         
	     },
	     draw : function(data) {
		     
	     	if(data['opponent_badges'].length == 2){     
		         var won=(data.h2h.won != null)?data.h2h.won : 0;
		         var lost=(data.h2h.lost != null)?data.h2h.lost : 0;
		         var draw=(data.h2h.drawn != null)?data.h2h.drawn : 0;	
				
		         var str='<div class="headtohead_bg clear">'
	  	             +'<div class="headtohead_user_img clear">'
	  	             +'<span id="newphoto_'+data.h2h.myId+'" onmouseover="$(\'#ministats_'+data.h2h.myId+'\').css(\'display\',\'block\');" onmouseout="document.getElementById(\'ministats_'+data.h2h.myId+'\').style.display=\'none\'"></span>'
	  	             +'<span class="versus">vs.</span>'
	  	             +'<span id="newphoto_'+data.h2h.opp_id+'" onmouseover="$(\'#ministats_'+data.h2h.opp_id+'\').css(\'display\',\'block\');" onmouseout="document.getElementById(\'ministats_'+data.h2h.opp_id+'\').style.display=\'none\'"></span>'
	  	             +'</div><div class="rating_holder clear" style="float: left; width: 290px; padding: 0px 2px; border: medium none; color: rgb(51, 51, 51); margin: 4px 10px 0 0;">'
	  	             +'<div class="rating_text" style="width: 60px; line-height: 8px;font-weight:bold;">Played<br /><span style="font-size:11px;color:#333;">'+((data.h2h.played != null)?data.h2h.played : 0 )+'</span></div>'
	  	             +'<div class="rating_text" style="width: 75px; line-height: 8px;font-weight:bold;">You Won<br /><span style="font-size:11px;color:#333;">'+won+' ('+((data.h2h.played != null)?Math.round((won * 100)/data.h2h.played) : 0 )+'%)</span></div>'
	  	             +'<div class="rating_text" style="width: 75px; line-height: 8px;font-weight:bold;">You Lost<br /><span style="font-size:11px;color:#333;">'+lost+' ('+((data.h2h.played != null)?Math.round((lost * 100)/data.h2h.played) : 0 )+'%)</span></div>'
	  	             +'<div class="rating_text" style="width: 60px; line-height: 8px;font-weight:bold;">Draws<br /><span style="font-size:11px;color:#333;">'+draw+' ('+((data.h2h.played != null)?Math.round((draw * 100)/data.h2h.played) : 0 )+'%)</span></div>'
	  	             +'</div>'
	  	             +'<div class="flt_right" style="margin-top: 4px">'	
	  	             +'<a href="<?=FB_APP_PATH?>?action=rematch&with='+data.h2h.opp_id+'&name='+data.h2h.oppName+'&rematch=1&game_id='+gameId+'" target="_top" class="grey_button flt_left" style="width: 24px;height: 20px;padding-top:2px;" onmousemove="showToolTip_new(event,\'Rematch\',\'default\');" onmouseout="hideToolTip_new()"><img src="<?= APP_IMG_URL_NEW?>refresh_icon_board.png" alt="" /></a>'
	  	             +'<a href="<?=FB_APP_PATH?>?action=jump&skipgid=<?=$gid?>" target="_top" class="grey_button grey_button_normal flt_left" style="font-size: 12px;height: 8px;line-height: 9px;margin:0 8px;">Next Game</a>'           
	  	             +'<a href="<?=FB_APP_PATH?>?" target="_top" class="grey_button grey_button_normal flt_left" style="font-size: 12px;height: 8px;line-height: 9px;">Home</a>'             
					 +'</div>'
					 +'<div id="ministats_'+data.h2h.myId+'" style="z-index: 100; opacity: 1;position: absolute;display: none;margin: 36px 0 0 -14px;" onmouseover="$(\'#ministats_'+data.h2h.myId+'\').css(\'display\',\'\')" onmouseout="document.getElementById(\'ministats_'+data.h2h.myId+'\').style.display=\'none\'"></div>'
					 +'<div id="ministats_'+data.h2h.opp_id+'" style="z-index: 100; opacity: 1;position: absolute;display: none;margin: 36px 0 0 32px;"  onmouseover="$(\'#ministats_'+data.h2h.opp_id+'\').css(\'display\',\'\')" onmouseout="document.getElementById(\'ministats_'+data.h2h.opp_id+'\').style.display=\'none\'"></div>'
					 +'</div>';	
					 
		         $("#headToHeadId").html(str);	        
				
	     	 }else {
		          $("#headToHeadId").empty();
		          BoardPanel.resizeBoard();
		     }

			 var appended_str = $("#display_opp_badges").html();
			    if(appended_str != ''){$("#display_opp_badges").empty();}
		    	var str2 = ''; 		    	
		    	uidList = '';
		    	for (var i=0;i<data['opponent_badges'].length;i++)
		    	{
		    		
		    		str2 += '<div class="user_details clear" style="margin-top:8px;">'
						+'<span style="float:left;margin:4px 8px 0 0;" id="photo_'+data['opponent_badges'][i]['uid']+'"></span>'
						+'<div style="float:left;"><span  id="name_'+data['opponent_badges'][i]['uid']+'">Loading ...</span><br />'
						+'<div style="float:left;margin:3px 5px 0 0;width:62px;">'
						+'<span style="line-height:12px;">'+data['opponent_badges'][i]['rating']+'</span><br />'
						+'<a href="<?=FB_APP_PATH?>?action=profile&profileid='+data['opponent_badges'][i]['uid']+'" target="_top" style="background:#333;padding:2px 3px;border-radius:3px;color:#fff;font-size:10px;">Details</a>'
						+'</div>'
						+'<div class="game_stats_row flt_left" style="padding:0;height:0;">'
						+'<ul class="clear">'
						+'<li>'+data['opponent_badges'][i]['total']+'</li>'
						+'<li>'+data['opponent_badges'][i]['win']+'</li>'
						+'<li>'+data['opponent_badges'][i]['lost']+'</li>'
						+'<li>'+data['opponent_badges'][i]['drawn']+'</li>'
						+'<li>'+data['opponent_badges'][i]['bingo']+'</li>'
						+'</ul>'
						+'</div></div></div>'; 
						uidList += data['opponent_badges'][i]['uid']+',';
		    	}
		    			    			     
		        uidList = uidList.slice(0, -1);
				$("#display_opp_badges").append(str2);	
				if(uidList != ''){							 
					//getUserDataFromFB();	
					uidListArray = uidList.split(',');
					//if(uidListArray.length == 2){
						showMiniStatsForUsers(uidList,"viewboard");
					//}
									
				}
				BoardPanel.resizeBoard();	

				////chart
				var flashvars_g = {
					data:encodeURIComponent(charturl)
				};
				var params_g = {wmode: "opaque", allowscriptaccess: "always"};
				var attributes_g = {};
				swfobject.embedSWF("https://dbyxbgd9ds257.cloudfront.net/flash/open-flash-chart.swf", "swfContainer1", "370", "250", "9.0.0","", flashvars_g, params_g, attributes_g);
				///chart
									
	     }
	 };

</script>

<script>
		var title='';
		var price='';
		var APP_STORE_IMG='https://d35zhpgb1mza1j.cloudfront.net/store/';
		var success_url = '<?=$_SERVER['HTTP_REFERER']?>&success=1';
		var failure_url = '<?=$_SERVER['HTTP_REFERER']?>&success=0';
	    function placeOrder(str) {	     
	      // Only send param data for sample. These parameters should be set
	      // in the callback.
	      
	      switch (str)
			{
			case 'subscribe_one_month':
			  		var title = 'Games Analyser (1 Month)';
			  		var price = 2;
			  		break;
			case 'subscribe_three_month':
			 		var title = 'Games Analyser (3 Months)';
			  		var price = 5;  		
			  		break;
			case 'subscribe_six_month':
		 		var title = 'Games Analyser (6 Months)';
		  		var price = 80;	  		
		  		break;
			case 'subscribe_one_year':
			  		var title = 'Games Analyser (1 Year)';
			  		var price = 12;
			  		break;			
			default:
			  		document.write("I'm looking forward to this weekend!");
			}
				      
	      //alert(item_id);alert(data);alert(title);alert(desc);alert(price);alert(img_url);alert(product_url);
	      FB.ui(
	  				{
		  				method: "pay",
		  				action: "purchaseitem",
		  				product: "http://aws.rjs.in/fblexulous/credits/products-metatag.php?type="+str
	  				},
	  				callback
	  		  	);
	    }

	    var callback = function(data) {
	    	if (data['status']=='completed') {
		    	  var signed_request=data['signed_request'];
			      var payment_id=data['payment_id'];
			      $("#success_message_after_payment").html('<h4>Payment processing...</h4>');
		    	  $.ajax({
		    			type: "POST",
		    		    url: "credits/process-callback.php",
		    		    data: {'signed_request': ''+signed_request+'','payment_id': ''+payment_id+'','user_currency': 'USD'},
		    		    success: function (result) {
		    		    	//$("#success_message_after_payment").html('<h4><span style="color:#009900;font-weight: bold;">SUCCESS:</span> Your purchase of "'+title+'" for USD '+price+' has been successful!</h4>');
		    		    	//alert("Hello");
		    		    	top.location.href =success_url;
							
		    		      }
		    		});
		      } else {
  		    	top.location.href =success_url;
				  
		    }
	    };

	    function writeback(str) {
	     // document.getElementById('output').innerHTML=str;
	    }
	
	  </script>
  

  <?
  $viewboardadvert = getMemCache("fblex/viewboardadvertrocku". $user);
  if (($viewboardadvert == 'y')) {
  	// now check trialpay
  	$viewboardadvert = getMemCache("fblex/trialpayrocku". $user);
  	if (($viewboardadvert == 'y')) {	
  	} else {
  		?>		
  				
  		<?				
  		setMemCache("fblex/trialpayrocku". $user, 'y', false, 3600*24);
  	}
  }else {
  ?>
  		
  <?	
  	setMemCache("fblex/viewboardadvertrocku". $user, 'y', false, 3600*24);
  }
  ?>
  
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
			    
// 		    	$("#notification").hide();    	
		    }
		});
	}
</script>
