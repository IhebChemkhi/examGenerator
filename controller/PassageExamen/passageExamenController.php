<?php

require 'model/PassageExamen/passageExamenModel.php';
require 'model/PassageExamen/passageExamen.php';

require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();


$GLOBALS['matiereForExamId'] = 0;
$GLOBALS['sujetForExam'] = [];

class passageExamenController
{

	function __construct()
	{
		$this->objconfig = new config();

		$this->objsm = new passageExamenModel($this->objconfig);

	}
	// mvc handler request
	public function mvcHandler()
	{
		$act = isset($_GET['act']) ? $_GET['act'] : NULL;
		echo $act;
		switch ($act) {
			case 'add':
				echo "here";
				$this->insert();
				break;
			case 'update':
				$this->update();
				break;
			case 'delete':
				$this->delete();
				break;
			default:
				$this->list();
		}
	}
	// page redirection
	public function pageRedirect($url)
	{
		header('Location:' . ROOTPAGE . "passageExamen/" . $url);
		die();
	}

	public function list()
	{
		$result = $this->objsm->selectExamensParProfs($_SESSION['mail']);
		include "vue/PassageExamen/list.php";
	}

    //

    public function insertAtMatiere()
	{
		if (isset($_SESSION['passageExamenDb'])) {
			unset($_SESSION['passageExamenDb']);
		}
        
		$matiere = $this->objsm->selectMatieresParProf($_SESSION['mail']);
		include "vue/PassageExamen/createAtMatiere.php";
	}

    // vvv

	public function createAfterMatiere()
	{
		try {
			echo "in createAfterMatiere";

			if (isset($_POST['addMatiere'])) {
				// read form value
				$matiereForExamId = trim($_POST['matiereSelected']);

                if(isset($matiereForExamId)){
                    $_SESSION["matiereForExamId"] = $matiereForExamId;
					$this->pageRedirect("insertAtSujet");
				} else {
					echo "Somthing is wrong..., try again. \n";
                    $this->pageRedirect("list");
				}
			}
		} catch (Exception $e) {

			var_dump($e);
			$this->close_db();
			throw $e;
		}
	}


    // vvv

	public function insertAtSujet()
	{
		if (isset($_SESSION['passageExamenDb'])) {
			unset($_SESSION['passageExamenDb']);
		}
		$sujet = $this->objsm->selectSujetsParMatiereParProf($_SESSION["matiereForExamId"]);
        var_dump($_SESSION);

		include "vue/PassageExamen/createAtSujet.php";
	}

    // vvv


    public function createAfterSujet()
	{
		try {
			echo "in createAfterSujet";

			if (isset($_POST['addSujet'])) {


                //probleme bdd
                // => On imageine qu'il a selectionner tt les sujets cad Anglais [id 6] at francais [id 5]
				$sujetForExamId = [5, 6];
                //$sujetForExamId = trim($_POST['sujetSelected']);

                if(isset($sujetForExamId)){
                    $_SESSION["sujetForExamId"] = $sujetForExamId;
					$this->pageRedirect("insertAtQuestions");
				} else {
					echo "Somthing is wrong..., try again. \n";
                    $this->pageRedirect("list");
				}
			}
		} catch (Exception $e) {

			var_dump($e);
			$this->close_db();
			throw $e;
		}
	}
    
    // vvv

	public function insertAtQuestions()
	{
		if (isset($_SESSION['passageExamenDb'])) {
			unset($_SESSION['passageExamenDb']);
		}
		$questions = $this->objsm->selectQuestionAleatoires($_SESSION["sujetForExamId"]);
        //var_dump($_SESSION["matiereForExamId"]);

        //probleme bdd
        // => On imageine qu'il a selectionner tt les sujets cad probabilité [1] et suite arithmetiques [2]

        //var_dump($questions);
        if (isset($_SESSION['notes'])) {
			unset($_SESSION['notes']);
		}
        
        if (isset($_SESSION['exam_titre'])) {
			unset($_SESSION['exam_titre']);
		}

		include "vue/PassageExamen/createAtQuestions.php";
	}

    // vvv


    public function addNoteQuestion(){

        try {
			echo "in addNoteQuestion";
            //var_dump($_SESSION);

				// read form value
				$notes = ($_SESSION["notes"]);
                $matiereId = ($_SESSION["matiereForExamId"]);
                $exam_titre = ($_SESSION['exam_titre']);

                var_dump($notes);
                var_dump($matiereId);
                var_dump($exam_titre);

                $res = $this->objsm->ajoutExamAvecNotes($notes, $matiereId, $exam_titre);
                //var_dump($res);

				if (!$res) {
                    echo "<script> location.href='" . ROOTPAGE . "passageExamen/list" . "'; </script>";
                    exit;
					$this->pageRedirect("list");
				} else {
					echo "Somthing is wrong..., try again. \n";
					//$_SESSION['passageExamenDb'] = serialize($passageExamenDb);
					//$this->pageRedirect("insertAtQuestions");
			}
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
        }
    }





}


?>