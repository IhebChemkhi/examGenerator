<?php
	
	class accueilModel
	{
		// set database config for mysql
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
    			die("Error in connection: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}
		public function verifierCompte($mail,$mdp){
			try{
				$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM `t_compte_cpt` join t_profile_pfl USING (cpt_id) WHERE cpt_mdp='" . $mdp . "' and pfl_mail='" . $mail . "';
				");
				$query->execute();
				$res= $query->get_result();
				$num_rows = mysqli_num_rows($res);
				if ($num_rows>=1){
					return true;
				} else
				return false;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}

		public function verifierRole($mail){
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM `t_compte_cpt` 
			JOIN t_profile_pfl USING (cpt_id)
			JOIN t_etudiant_etd USING (pfl_id)
			WHERE pfl_mail = '".$mail."';");
			$query1 = $this->condb->prepare("SELECT * FROM `t_compte_cpt` 
			JOIN t_profile_pfl USING (cpt_id)
			JOIN t_professeur_prof USING (pfl_id)
			WHERE pfl_mail = '".$mail."';");
			$query2 = $this->condb->prepare("SELECT * FROM `t_compte_cpt` 
			JOIN t_profile_pfl USING (cpt_id)
			JOIN t_administrateur_admin USING (pfl_id)
			WHERE pfl_mail = '".$mail."';");

			$query->execute();
			$res = $query->get_result();
			$query1->execute();
			$num_rows = mysqli_num_rows($res);
			$res1 = $query1->get_result();
			$query2->execute();
			$num_rows1 = mysqli_num_rows($res1);
			$res2 = $query2->get_result();
			$num_rows2 = mysqli_num_rows($res2);
			if ($num_rows>=1){
				return "etudiant";
			}
			elseif ($num_rows1>=1){
				return "professeur";
			}
			elseif (mysqli_num_rows($res2)>=1){
				return "administrateur";
			}

		}
		catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}

		}

		public function getUserByMail($email){
			try{

				$this->open_db();
			    $query = $this->condb->prepare("SELECT pfl_mail, pfl_id FROM t_profile_pfl WHERE pfl_mail = '" .$email."';");
				//$query->bind_param("s", $email);
				$query->execute();
				$res= $query->get_result();
				$user = $res->fetch_assoc();
				//return $res;
				return $user;
				//$num_rows = mysqli_num_rows($res);
				/*if ($num_rows>=1){
					return true;
				} else
				return false;*/
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}

		}

		public function updatePassWordPeople($id, $password){
			try{

				$this->open_db();
			    $query = $this->condb->prepare("UPDATE `t_compte_cpt` SET `cpt_mdp` = ? WHERE `t_compte_cpt`.`cpt_id` = ?");
				$query->bind_param("si",$password, $id);
				$query->execute();
				$res= $query->get_result();
				return $res;
				/*$num_rows = mysqli_num_rows($res);
				if ($num_rows>=1){
					return true;
				} else
				return false;*/
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}

		}
	
	}

?>