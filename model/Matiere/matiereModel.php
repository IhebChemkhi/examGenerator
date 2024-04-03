<?php

class matiereModel{

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



		public function insertMatiere($objMat, $objPfl, $professeurSelected)
		{
  		  try
    		{   
       		$this->open_db();

        	$query = $this->condb->prepare("INSERT INTO t_matiere_mat (mat_nom, pfl_id) VALUES (?, (SELECT pfl_id FROM t_profile_pfl WHERE pfl_id = ?))");
       		$query->bind_param("si", $objMat->mat_nom, $professeurSelected);
			$query->execute();
        	$last_id = $this->condb->insert_id;
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

		/*public function insertMatiere($objMat, $objPfl, $professeursSelected)
		{
			try
			{	
				$this->open_db();

				// a faire :
				/*
				$query=$this->condb->prepare("INSERT INTO t_matiere_mat (mat_nom,pfl_id,cur_id) VALUES (?, ?,?)");
				$query->bind_param("sii",$obj->mat_nom,$obj->pfl_id,$obj->cur_id);
				

				//$query=$this->condb->prepare("INSERT INTO t_matiere_mat (mat_nom, pfl_id) VALUES (?, (SELECT pfl_id FROM t_profile_pfl)");
				$query = $this->condb->prepare("INSERT INTO t_matiere_mat (mat_nom, pfl_id) VALUES (?, (SELECT pfl_id FROM t_professeur_prof WHERE pfl_nom = ?))");

				$query->bind_param("sii",$objMat->mat_nom,$objPfl->pfl_id, $professeursSelected);


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
		}*/

		public function selectRecordMatiere($id)
		{
			try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM t_matiere_mat WHERE mat_id=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM t_matiere_mat");	}		
				
				$query->execute();
				$res=$query->get_result();	
				//var_dump($query);
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


		public function updateRecordMatiere($obj, $professeursSelected)
		{
			try
			{	
				$this->open_db();
				//UPDATE `t_matiere_mat` SET `mat_nom` = 'da', `pfl_id` = '58' WHERE `t_matiere_mat`.`mat_id` = 11 AND `t_matiere_mat`.`pfl_id` = 4
				$query=$this->condb->prepare("UPDATE t_matiere_mat SET mat_nom = ?, pfl_id = ? WHERE t_matiere_mat.mat_id = ?");
				$query->bind_param("sii", $obj->mat_nom, $professeursSelected, $obj->mat_id);
				$query->execute();
				$res=$query->get_result();						
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

		public function deleteRecordMatiere($id){

			try{
				$this->open_db();
				$query=$this->condb->prepare("DELETE FROM t_matiere_mat WHERE mat_id=?");
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

		public function selectMatieresParProfesseur($mail)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM t_matiere_mat join t_professeur_prof USING (pfl_id) join t_profile_pfl using (pfl_id) where pfl_mail=?");
			$query->bind_param("s", $mail);
			$query->execute();
			$res = $query->get_result();
			$query->close();
			$this->close_db();
			return $res;
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	public function selectAllProfesseur(){
		try{
			$this->open_db();
			$query = $this->condb->prepare("SELECT DISTINCT t_professeur_prof.pfl_id, pfl_nom FROM t_profile_pfl INNER JOIN t_professeur_prof ON t_profile_pfl.pfl_id = t_professeur_prof.pfl_id");
		//	$query = $this->condb->prepare("SELECT DISTINCT t_professeur_prof.pfl_id, t_profile_pfl.pfl_nom FROM t_professeur_prof INNER JOIN t_profile_pfl");

		//	$query -> bind_param("i",);
			$query->execute();
			$res= $query->get_result();
			$query->close();
			return $res;
		}catch(Exception $e){
			$this->close_db();
			throw $e;
		}

	}


        
    
}