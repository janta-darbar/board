<?php
//by khaldar.
class UsersstatsDbModel{
	//protected $_name = "users_stats";
	protected $_name = "all_users_stats";
	
	function __construct(){
		$this->_name;
	}
	public function insertRecord($data) {
	        $game_data="";
		foreach($data as $key=>$valu){
			// if ($key == "bestrating_date") {
			// 	$game_data.="$key=$valu,";
			// }else{
				$game_data.="$key='$valu',";
			// }	
		}
		$usergame_data=trim($game_data,",");
		$sql = "INSERT INTO {$this->_name} set $usergame_data";
		mysql_query($sql);
		
	}
	
	public function updateRecord($userid, $data) {
		$playerRating="";
		foreach($data as $key=>$valu){
			$playerRating.="$key='$valu',";	
		}
		$playerRating_data=trim($playerRating,",");
		//mysql_query("UPDATE {$this->_name} SET $playerRating_data WHERE email = '$userid'");
		mysql_query("UPDATE {$this->_name} SET $playerRating_data WHERE userid = '$userid'");
		return mysql_affected_rows();
	}
	
	public function selectRecord($where) {
		$rs = mysql_query("SELECT * FROM {$this->_name} WHERE $where");
		$result= mysql_fetch_assoc($rs);
		if (!$result) {
			 return array(); 
		}else
		return (array)$result;
	}
	
	public function selectMultipleRow($where) {
		$sql = "SELECT * FROM {$this->_name} WHERE $where";
		$rs = mysql_query($sql);
		$returnArr = array();
		while ($result = mysql_fetch_assoc($rs)){
			$returnArr[]=$result;
		}
		return $returnArr;
	}
	
	public function executeQuery($sql) {
		mysql_query($sql);
		return mysql_affected_rows();
	}
}
