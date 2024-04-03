<?php

class anneeScolaireModel{

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

		public function insertRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO t_anneescolaire_ann (ann_annee) VALUES (?)");
				$query->bind_param("s",$obj->ann_annee);
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

		public function selectRecord($id)
		{
			try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM t_anneescolaire_ann WHERE ann_id=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM t_anneescolaire_ann");	}		
				
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


		public function updateRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("UPDATE t_anneescolaire_ann SET ann_annee=? WHERE ann_id=?");
				$query->bind_param("si", $obj->ann_annee,$obj->ann_id);
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

		public function deleteRecord($id){

			try{
				$this->open_db();
				$query=$this->condb->prepare("DELETE FROM t_anneescolaire_ann WHERE ann_id=?");
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