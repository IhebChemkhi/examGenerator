<?php
class profileModel
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


	// insert record
	public function insertRecord($objPfl, $objCpt, $role, $cursusSelected, $anneSelected, $classeSelected)
	{
		try {

			$this->open_db();
			var_dump($objPfl);
			var_dump($objCpt);
			$queryCpt = $this->condb->prepare("INSERT INTO t_compte_cpt (cpt_pseudo,cpt_mdp) VALUES (?, ?)");
			$queryCpt->bind_param("ss", $objCpt->cpt_pseudo, $objCpt->cpt_mdp);
			$queryCpt->execute();
			$res = $queryCpt->get_result();
			$last_id_cpt = $this->condb->insert_id;
			$queryCpt->close();
			var_dump($queryCpt);


			$queryPfl = $this->condb->prepare("INSERT INTO t_profile_pfl (pfl_nom, pfl_prenom, pfl_dateNaissance, pfl_mail, cpt_id) VALUES (?, ?, ?, ?, (SELECT cpt_id from t_compte_cpt WHERE cpt_pseudo=?))");
			$queryPfl->bind_param("sssss", $objPfl->pfl_nom, $objPfl->pfl_prenom, $objPfl->pfl_dateNaissance, $objPfl->pfl_mail, $objCpt->cpt_pseudo);
			$queryPfl->execute();
			$res = $queryPfl->get_result();
			$queryPfl->close();

			var_dump($queryPfl);

			$last_id = $this->condb->insert_id;


			$table = null;

			if ($role == 'Administrateur') {
				$queryRoleSelected = $this->condb->prepare("INSERT INTO t_administrateur_admin (pfl_id) VALUES ((SELECT pfl_id from t_profile_pfl where cpt_id in (SELECT cpt_id from t_compte_cpt where cpt_pseudo = ?)))");
				$queryRoleSelected->bind_param("s", $objCpt->cpt_pseudo);
				$queryRoleSelected->execute();
				$res = $queryRoleSelected->get_result();
				$queryRoleSelected->close();

			} else if ($role == 'professeur') {
				$queryRoleSelected = $this->condb->prepare("INSERT INTO t_professeur_prof (pfl_id) VALUES ((SELECT pfl_id from t_profile_pfl where cpt_id in (SELECT cpt_id from t_compte_cpt where cpt_pseudo = ?)))");
				$queryRoleSelected->bind_param("s", $objCpt->cpt_pseudo);
				$queryRoleSelected->execute();
				$res = $queryRoleSelected->get_result();
				$queryRoleSelected->close();
			} else if ($role == 'eleve') {
				$queryRoleSelected = $this->condb->prepare("INSERT INTO t_etudiant_etd (pfl_id,cur_id,ann_id,cla_id) VALUES ((SELECT pfl_id from t_profile_pfl where cpt_id in (SELECT cpt_id from t_compte_cpt where cpt_pseudo = ?)),?,?,?)");
				$queryRoleSelected->bind_param("siii", $objCpt->cpt_pseudo, $cursusSelected, $anneSelected, $classeSelected);
				$queryRoleSelected->execute();
				$res = $queryRoleSelected->get_result();
				$queryRoleSelected->close();
			}






			$this->close_db();
			return $last_id;
		} catch (Exception $e) {
			var_dump($queryRoleSelected);
			$this->close_db();
			throw $e;
		}
	}


	//update record
	public function updateRecord($objPfl, $objCpt, /**$roleSelected,**/ $cursusSelected, $anneSelected, $classeSelected)
	{
		try {
			$this->open_db();
			var_dump($objCpt);
			var_dump($objPfl);
			$queryCpt = $this->condb->prepare("UPDATE t_compte_cpt SET cpt_pseudo=?,cpt_mdp=? WHERE cpt_id in (SELECT cpt_id from t_profile_pfl where pfl_id =?) ");
			$queryCpt->bind_param("ssi", $objCpt->cpt_pseudo, $objCpt->cpt_mdp, $objPfl->pfl_id);
			$queryCpt->execute();
			$res = $queryCpt->get_result();
			$last_id_cpt = $this->condb->insert_id;
			$queryCpt->close();


			$queryPfl = $this->condb->prepare("UPDATE t_profile_pfl SET pfl_nom=?,pfl_prenom=?,pfl_dateNaissance=?,pfl_mail=? WHERE pfl_id=?");
			$queryPfl->bind_param("ssssi", $objPfl->pfl_nom, $objPfl->pfl_prenom, $objPfl->pfl_dateNaissance, $objPfl->pfl_mail, $objPfl->pfl_id);
			$queryPfl->execute();
			$res = $queryPfl->get_result();
			$queryPfl->close();

/*
			if ($roleSelected == 'eleve') {
				$queryPfl = $this->condb->prepare("UPDATE t_etudiant_etd SET cur_id=?,ann_id=?,cla_id=? WHERE pfl_id=?");
				$queryPfl->bind_param("iiii", $cursusSelected, $anneSelected, $classeSelected, $objPfl->pfl_id);
				$queryPfl->execute();
				$res = $queryPfl->get_result();
				$queryPfl->close();

			}
			$this->close_db();

			*/
			return true;



		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	// delete record
	public function deleteRecord($id)
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("DELETE FROM t_compte_cpt WHERE cpt_id = ?");
			$query->bind_param("i", $id);
			$query->execute();
			$res = $query->get_result();
			$query->close();
			$this->close_db();
			return true;
		} catch (Exception $e) {
			$this->closeDb();
			throw $e;
		}
	}

	// select record     
	public function selectRecord($id)
	{
		try {
			$this->open_db();
			if ($id > 0) {
				$query = $this->condb->prepare("SELECT * FROM t_profile_pfl JOIN t_compte_cpt USING (cpt_id) WHERE pfl_id=?");
				$query->bind_param("i", $id);
			} else {
				$query = $this->condb->prepare("SELECT * FROM t_profile_pfl JOIN t_compte_cpt USING (cpt_id)");
			}

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

	public function AfficherClasses()
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * from t_class_cla ");
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

	public function AfficherCursus()
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * from t_cursus_cur ");
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

	public function AfficherAnnee()
	{
		try {
			$this->open_db();
			$query = $this->condb->prepare("SELECT * from t_anneeScolaire_ann ");
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
	public function selectSujetsParID($id)
	{
		$this->open_db();
		$query = $this->condb->prepare("SELECT * from t_sujets_suj where suj_id = ?");
		$query->bind_param('i', $id);
		$query->execute();
		$res = $query->get_result();
		$query->close();
		$this->close_db();
		return $res;
	}

	public function selectSujetsParProfesseur($mail)
	{
		$this->open_db();
		$query = $this->condb->prepare("SELECT * from t_sujets_suj JOIN t_professeur_prof USING(pfl_id) JOIN t_profile_pfl USING(pfl_id) WHERE pfl_mail=?");
		$query->bind_param('s', $mail);
		$query->execute();
		$res = $query->get_result();
		$query->close();
		$this->close_db();
		return $res;
	}

	public function ajouterNouveauSujet($titre, $matiere)
	{
		$this->open_db();
		$query = $this->condb->prepare("INSERT INTO t_sujets_suj (suj_titre,pfl_id) VALUES (?,?)");
		$query->bind_param('si', $titre, $matiere);
		$query->execute();
		$query->close();
		$this->close_db();
		return true;
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
	public function getProfileIDbyMail($mail){
		$this->open_db();
		$query1 = $this->condb->prepare("SELECT pfl_id from t_professeur_prof join t_profile_pfl using (pfl_id) where pfl_mail=?");
		$query1->bind_param('s', $mail);
		$query1->execute();
		$res = $query1->get_result();
		return $res;
	}

	public function updateSujet($id, $titre,$mail,$pfl_id)
	{
		$this->open_db();
		$query = $this->condb->prepare("UPDATE t_sujets_suj SET suj_titre = ?, pfl_id = ? where suj_id= ?");
		$query->bind_param('sii', $titre,$pfl_id, $id);
		$query->execute();
		$this->close_db();
		return true;
	}

	public function deleteSujetParID($id)
	{
		$this->open_db();
		$query = $this->condb->prepare("DELETE FROM t_question_ques where suj_id=?");
		$query->bind_param('i', $id);
		$query->execute();

		$query = $this->condb->prepare("DELETE FROM t_sujets_suj where suj_id=?");
		$query->bind_param('i', $id);
		$query->execute();
		$query->close();
		$this->close_db();

		return true;

	}

	public function selectQuestionParProf($mail)
	{
		$this->open_db();
		$query = $this->condb->prepare("SELECT * FROM t_question_ques 
										left JOIN t_sujets_suj USING (suj_id) 
										left JOIN t_professeur_prof USING (pfl_id) 
										left JOIN t_profile_pfl USING (pfl_id) 
										where pfl_mail = ?");
		$query->bind_param('s', $mail);
		$query->execute();
		$res = $query->get_result();
		$this->close_db();
		return $res;
	}

	
	public function getCompteByPseudo($cpt_pseudo){
		$this->open_db();
		$query = $this->condb->prepare("SELECT cpt_id FROM t_compte_ccpt where cpt_pseudo = ?");
		$query->bind_param("s", $cpt_pseudo);
		$query->execute();
		$res = $query->get_result();
		$this->close_db();
		return $res;
	}

	public function createCompte($cpt_pseudo, $mdp){
		$this->open_db();
		$query = $this->condb->prepare("INSERT INTO t_compte_cpt(cpt_pseudo, cpt_mdp) VALUES (?, ?)");
		$query->bind_param("ss",$cpt_pseudo, $mdp);
		$query->execute();
		$compte_id = $query->insert_id;
		//$res = $query->get_result();
		$this->close_db();
		return $compte_id;
	}

	public function createProfile($pfl_nom,$pfl_prenom,$pfl_dateNaissance,$pfl_mail,$compte_id){
		$this->open_db();
		$query = $this->condb->prepare("INSERT INTO t_profile_pfl(pfl_nom, pfl_prenom, pfl_dateNaissance, pfl_mail, cpt_id) VALUES (?, ?, ?, ?, ?)");
		$query->bind_param("ssssi",$pfl_nom,$pfl_prenom,$pfl_dateNaissance,$pfl_mail,$compte_id);
		$query->execute();
		$profile_id = $query->insert_id;
		//$res = $query->get_result();
		$this->close_db();
		return $profile_id;
	}



	public function insertCompte($cpt_pseudo){
		$this->open_db();
		$query = $this->condb->prepare("SELECT * FROM t_compte_ccpt where cpt_pseudo = ?");
		$query->bind_param("s", $cpt_pseudo);
		$query->execute();
		$res = $query->get_result();
		$this->close_db();
		return $res;
	}



}

?>