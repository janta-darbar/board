<?

class Application_Model_FileIO {

    private $id = null;
    private $type = null;
    private $table = null;
    private $dyDB = null;
    private $tableDesc = null;
    private $currentRetry = 0;

    public function __construct($id, $type, $date='') {
        $this->id = (string) $id;
        $this->type = $type;

        switch ($this->type) {
            case "game":
                $pDate = date_parse($date);
                $mth = strlen($pDate['month']) == 2 ? $pDate['month'] : "0" . $pDate['month'];
                $this->table = 'LexulousAsyncGame' . $mth . substr($pDate['year'], 2);
                break;
            case "archive":
                $this->table = 'LexulousAsyncArchive';
                break;
            case "note":
                $this->table = 'LexulousAsyncNote';
                break;
            case 'userstats':
                $this->table = "LexulousComStats";
                break;
        }
        
    }

    public function getFile() {
    	/*if($this->type == "game") {
	    	//memcache
	    	$cache = Application_Model_Cache_MemCache::getMemCache("iDYNAMODB_READ_" . $this->id);
	    	if($cache !== false) {
	    		$tCache = @unserialize($cache);
	    		if($tCache !== false) {
	    			$cache = $tCache;
	    		}
	    		return $cache;
	    	}
    	}*/
    	
    	if($this->dyDB == null)
    		$this->dyDB = new AmazonDynamoDB();
    	do {
    		$retry = false;
        switch ($this->type) {
            case "game":
                $attr = array('moveInfo', 'boardInfo');
                break;
            case "archive":
            case "note":
                $attr = array('data');
                break;
        }
        $response = $this->dyDB->get_item(array(
            'TableName' => $this->table,
            'Key' => array(
                'HashKeyElement' => array(
                    AmazonDynamoDB::TYPE_STRING => $this->id
                )
            ),
            'AttributesToGet' => $attr,
            'ConsistentRead' => 'true'
                ));

        if ($response->isOK()) {
        	if ((string) $response->body->Item->count() == 0) {
        		$this->currentRetry = 0;
        		return array();
			}
			$arr = array();
            switch ($this->type) {
                case "game":
                    $arr[] = trim((string) $response->body->Item->moveInfo->{AmazonDynamoDB::TYPE_STRING});
                    $arr[] = trim((string) $response->body->Item->boardInfo->{AmazonDynamoDB::TYPE_STRING});
                    
                    //memcache
                    //Application_Model_Cache_MemCache::setMemCache("iDYNAMODB_READ_" . $this->id, $arr, 60 * 60 * 15);
                    break;                    
                case "archive":
                case "note":
                    $arr[] = (string) $response->body->Item->data->{AmazonDynamoDB::TYPE_STRING};
                    break;
                case "userstats":
                        $arr[] = trim((string) $response->body->Item->data->{AmazonDynamoDB::TYPE_STRING});
                        break;
            }
            return $arr;
        } else {
				$exception = $response->body->to_array()->getArrayCopy();
				$exception = explode("#", $exception[__type]);				
				if($response->status == "500" || $exception[1] == 'ProvisionedThroughputExceededException') {
					$retry = true;
				} else if($response->status == "400") {
					$this->currentRetry = 0;
					return array();
				} 
			}
			
			if($retry) {
				$micro_seconds = ((pow(2,$this->currentRetry)*50)*1000);
				usleep($micro_seconds);
				$this->currentRetry += 1;
			}
    	}while($retry && $this->currentRetry<3);
		
		$this->currentRetry = 0;
		$this->recover("READ");
		return array();
    }

    public function writeFile($str) {
    	
    	if($this->dyDB == null)
    		$this->dyDB = new AmazonDynamoDB();
    	do {
    		$retry = false;
        $queue = new CFBatchRequest();
        $queue->use_credentials($this->dyDB->credentials);
        $item = array();

        switch ($this->type) {
            case "game":
                $data = explode("\r\n", $str);
                $item = array(
                    'id' => array(AmazonDynamoDB::TYPE_STRING => $this->id),
                    'moveInfo' => array(AmazonDynamoDB::TYPE_STRING => $data[0] . " "),
                    'boardInfo' => array(AmazonDynamoDB::TYPE_STRING => $data[1] . " ")
                );
                
                //memcache
                //Application_Model_Cache_MemCache::setMemCache("iDYNAMODB_READ_" . $this->id, array($data[0],$data[1]), 60 * 60 * 15);
                break;
            case "archive":
                $item = array(
                    'id' => array(AmazonDynamoDB::TYPE_STRING => $this->id),
                    'data' => array(AmazonDynamoDB::TYPE_STRING => $str)
                );
                break;
            case 'note':
                $item = array(
                    'id' => array(AmazonDynamoDB::TYPE_STRING => $this->id),
                    'data' => array(AmazonDynamoDB::TYPE_STRING => $str)
                );
                break;
            case "userstats":
                    $item = array(
                    'id' => array(AmazonDynamoDB::TYPE_STRING => $this->id),
                    'data' => array(AmazonDynamoDB::TYPE_STRING => $str)
                    );
                    break;
        }
        $this->dyDB->batch($queue)->put_item(array(
            'TableName' => $this->table,
            'Item' => $item
        ));

       $response = $this->dyDB->batch($queue)->send();
       $resp_arr = $response->getArrayCopy();
       $exception = $resp_arr[0]->body->to_array()->getArrayCopy();
	   if($resp_arr[0]->status == "500" || $exception[1] == 'ProvisionedThroughputExceededException') {
	   				$retry = true;
	   } else if($resp_arr[0]->status == "400") {
			$retry = true;
		}
			
			if($retry) {
				$micro_seconds = ((pow(2,$this->currentRetry)*50)*1000);
				usleep($micro_seconds);
				$this->currentRetry += 1;
			}
		}while($retry && $this->currentRetry<3);
		
		if($this->currentRetry>0) {
			$this->currentRetry = 0;
			if($this->type == "game") {
				$sp = explode("\r\n",$str);
				$data = array($sp[0],$sp[1]);
			} else {
				$data = array($str);
			}
			$this->recover("WRITE",$data);
		}
    }

    public function writeEmptyFile() {
    	
    	if($this->dyDB == null)
    		$this->dyDB = new AmazonDynamoDB();
    	do {
    		$retry = false;
        $queue = new CFBatchRequest();
        $queue->use_credentials($this->dyDB->credentials);

        $this->dyDB->batch($queue)->put_item(array(
            'TableName' => $this->table,
            'Item' => array(
                'id' => array(AmazonDynamoDB::TYPE_STRING => $this->id),
                'moveInfo' => array(AmazonDynamoDB::TYPE_STRING => " "),
                'boardInfo' => array(AmazonDynamoDB::TYPE_STRING => " ")
            )
        ));

        $response = $this->dyDB->batch($queue)->send();
        $resp_arr = $response->getArrayCopy();
		$exception = $resp_arr[0]->body->to_array()->getArrayCopy();
		if($resp_arr[0]->status == "500" || $exception[1] == 'ProvisionedThroughputExceededException') {
						$retry = true;
					} else if($resp_arr[0]->status == "400") {
			$retry = true;
				
			} 
				
			if($retry) {
				$micro_seconds = ((pow(2,$this->currentRetry)*50)*1000);
				usleep($micro_seconds);
				$this->currentRetry += 1;
			}
			
		}while($retry && $this->currentRetry<3);
		
		if($this->currentRetry>0) {
			$this->currentRetry = 0;
			$data = array(" "," ");
			$this->recover("WRITE",$data);
		}
    }

    public function removeFile() {
    	
    	if($this->dyDB == null)
    		$this->dyDB = new AmazonDynamoDB();
    	
        $response = $this->dyDB->delete_item(array(
            'TableName' => $this->table,
            'Key' => array(
                'HashKeyElement' => array(
                    AmazonDynamoDB::TYPE_STRING => $this->id
                )
            )
                ));
	}

    public function getBatchFiles($idDates , $attrib = '') {

        if($this->dyDB == null)
            $this->dyDB = new AmazonDynamoDB();
        
        do {
            $retry = false;

            $dataToReturn = array();
            $rng=100;
            for($i=0;$i<count($idDates)/$rng;$i++){
                $filesToGet = array();
                $output = array_slice($idDates, $i*$rng, $rng);
                foreach($output as $key=>$value) {
                    if(!is_array($filesToGet[$this->table]['Keys'])) {
                        $filesToGet[$this->table]['Keys'] = array();
                    }
                    $filesToGet[$this->table]['Keys'][] = array(
                        'HashKeyElement'  => array(AmazonDynamoDB :: TYPE_STRING => $value)
                    );
                    $filesToGet[$this->table]['ConsistentRead'] = 'true';
                    if($attrib)
                        $filesToGet[$this->table]['AttributesToGet'] = $attrib;
                }

                $response = $this->dyDB->batch_get_item(array(
                    'RequestItems' => $filesToGet
                ));

                    foreach ($response->body->Responses->{$this->table}->Items as $item)
                    {
                        if($item->{'id'})
                            $id = (string) $item->{'id'}->{AmazonDynamoDB::TYPE_STRING};
                            if($item->{'data'})
                                $dataToReturn[$id] = trim((string) $item->{'data'}-> {AmazonDynamoDB :: TYPE_STRING });
                    }
            }

            return $dataToReturn;

            if($retry) {
                $micro_seconds = ((pow(2,$this->currentRetry)*50)*1000);
                usleep($micro_seconds);
                $this->currentRetry += 1;
            }
        }while($retry && $this->currentRetry<3);
        
        if($this->currentRetry>0) {
            $this->currentRetry = 0;
            if($this->type == "game") {
                $sp = explode("\r\n",$str);
                $data = array($sp[0],$sp[1]);
            } else {
                $data = array($str);
            }
            $this->recover("WRITE",$data);
        }
    }
    
    private function recover($log_type,$game_data = "") {
    	//insert in log table
    	$log = new Application_Model_LogData();
    	$log->save($this->type . "#" . $log_type);
    	
    	//temporary game data save in mysql table
    	if($log_type == "WRITE") {
    		$dataStr = "";
    		if(count($game_data) == 2) {
    			$dataStr = $game_data[0] . "\r\n" . $game_data[1];
    		} else {
    			$dataStr = $game_data[0];
    		}
    	
    		$game = new Application_Model_GameData();
    		$game->saveTempGameData($this->id,$this->table,$dataStr,$this->type);
    		$game->lockGame($this->id);
    	}
    }

}
