<?php

class cursusModel{

    function __construct($consetup)
		{
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;            					
		}
		// open mysql data base
		public function open_db()
		{
			$this->condb=new mysqli($this->host,$this->user,$this->pass,$this->db);
			if ($this->condb->connect_error) 
			{
    			die("Erron in connection: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}

		public function insertCursus($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO t_cursus_cur (cur_nom) VALUES (?)");
				$query->bind_param("s",$obj->cur_nom);
				var_dump($query);
				$query->execute();
				$res= $query->get_result();
				$last_id=$this->condb->insert_id;
				$query->close();
				$this->close_db();
				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}

		public function selectRecordCursus($id)
		{
			try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM t_cursus_cur WHERE cur_id=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM t_cursus_cur");	}		
				
				$query->execute();
				$res=$query->get_result();	
			//	var_dump($query);
				$query->close();				
				$this->close_db();                
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
			
		}


		public function updateRecordCursus($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("UPDATE t_cursus_cur SET cur_nom=? WHERE cur_id=?");
				$query->bind_param("si", $obj->cur_nom,$obj->cur_id);
				var_dump($query);
				$query->execute();
				$res=$query->get_result();	
								//var_dump($res);
								//var_dump($query);
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}
        }

		public function deleteRecordCursus($id){

			try{
				$this->open_db();
				$query=$this->condb->prepare("DELETE FROM t_cursus_cur WHERE cur_id=?");
				$query->bind_param("i",$id);
				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
				return true;	
			}
			catch (Exception $e) 
			{
            	$this->closeDb();
            	throw $e;
        	}		

		}
		


        
    
}