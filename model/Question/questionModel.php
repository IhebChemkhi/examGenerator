<?php
class questionModel
{
	// set database config for mysql
	function __construct($consetup)
	{
		$this->host = $consetup->host;
		$this->user = $consetup->user;
		$this->pass = $consetup->pass;
		$this->db = $consetup->db;
	}
	// open mysql data base
	public function open_db()
	{
		$this->condb = new mysqli($this->host, $this->user, $this->pass, $this->db);
		if ($this->condb->connect_error) {
			die("Erron in connection: " . $this->condb->connect_error);
		}
	}
	// close database
	public function close_db()
	{
		$this->condb->close();
	}



	public function selectQuestionParProf($mail){
		$this->open_db();
		$query = $this->condb->prepare("SELECT * FROM t_question_ques JOIN t_sujets_suj USING (suj_id) JOIN t_professeur_prof USING (pfl_id) JOIN t_profile_pfl USING (pfl_id) where pfl_mail = ?");
		$query-> bind_param('s',$mail);
		$query->execute();
		$res = $query->get_result();
		$this->close_db();
		return $res;
	}

	public function selectSujetsBy($objQues)
	{
		try {
			
			$this->open_db();
			var_dump($objQues);
			$objQues = $this->condb->prepare("");
			$objQues->bind_param("ss", $objQues->ques_text, $objQues->ques_reponse,$objQues->suj_id);
			$objQues->execute();
			$res = $objQues->get_result();
			$last_id = $this->condb->insert_id;
			$objQues->close();
			var_dump($objQues);



			$this->close_db();
			return $last_id;
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}


    public function selectSujetsByProf($mailProf){

        try {			
			$this->open_db();
			$query = $this->condb->prepare("SELECT * FROM t_sujets_suj  JOIN t_professeur_prof USING (pfl_id) JOIN t_profile_pfl USING (pfl_id) where pfl_mail = ?");
            $query->bind_param("s", $mailProf);
			$query->execute();
			$res = $query->get_result();
			$last_id = $this->condb->insert_id;
			$query->close();

			$this->close_db();
			return $res;
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}

    }

	public function selectRecord($id){
		try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM t_question_ques WHERE ques_id=?");
					$query->bind_param("i",$id);
				}
                else
                {$query=$this->condb->prepare("SELECT * FROM t_question_ques");	}		
				
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


    // insert record
	public function insertRecord($objQues)
	{
		try {			
			$this->open_db();

            var_dump($objQues->ques_text);

			$query = $this->condb->prepare("INSERT INTO t_question_ques (ques_text,ques_reponse,suj_id) VALUES (?, ?, ?)");
            $query->bind_param("ssi", $objQues->ques_text, $objQues->ques_reponse, $objQues->suj_id);
			$query->execute();
			$res = $query->get_result();
			$last_id = $this->condb->insert_id;

            var_dump($objQues);

			$query->close();


			$this->close_db();
			return $last_id;
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}
	
	//update record
	public function updateRecord($objQues)
	{
		try {

			$this->open_db();
			$query = $this->condb->prepare("UPDATE t_question_ques SET ques_text=?,ques_reponse=?,suj_id=? WHERE t_question_ques.ques_id = ?");
			$query->bind_param("ssii", $objQues->ques_text, $objQues->ques_reponse, $objQues->suj_id, $objQues->ques_id);
			$query->execute();
			$res = $query->get_result();
			$last_id_cpt = $this->condb->insert_id;
			$query->close();


			$this->close_db();
				return true;



		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}
	public function deleteRecord($id){

		try{
			$this->open_db();
			$query=$this->condb->prepare("DELETE FROM t_question_ques WHERE ques_id=?");
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

    ?>