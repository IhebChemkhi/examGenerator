<?php

require 'model/Question/questionModel.php';
require 'model/Question/question.php';

require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class questionController
{

	function __construct()
	{
		$this->objconfig = new config();

		$this->objsm = new questionModel($this->objconfig);

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
		header('Location:' . ROOTPAGE . "question/" . $url);
		die();
	}

	public function list()
	{
		$result = $this->objsm->selectQuestionParProf($_SESSION['mail']);
		include "vue/Question/list.php";
	}

	public function insert()
	{
		if (isset($_SESSION['questionDb'])) {
			unset($_SESSION['questionDb']);
		}
		$sujet = $this->objsm->selectSujetsByProf($_SESSION['mail']);
		include "vue/Question/create.php";
	}

	public function create()
	{
		try {
			echo "in create";
			$questionDb = new question();

			if (isset($_POST['addbtn'])) {
				// read form value
				$questionDb->ques_text = trim($_POST['ques_text']);
				$questionDb->ques_reponse = trim($_POST['ques_reponse']);
				$questionDb->suj_id = trim($_POST['sujetSelected']);

				$pid = $this->objsm->insertRecord($questionDb);
				if ($pid > 0) {
					$this->pageRedirect("list");
				} else {
					echo "Somthing is wrong..., try again. \n";
					$_SESSION['questionDb'] = serialize($questionDb);
					//$this->pageRedirect("insert");
					echo "erreur dans la saisie :(";
				}

			}
		} catch (Exception $e) {

			var_dump($e);
			$this->close_db();
			throw $e;
		}
	}

	public function edit()
	{
		$urlParams = explode('/', $_SERVER['REQUEST_URI']);
		if (sizeof($urlParams) > 3) {
			$id = $urlParams[4];
		}

		$sujet = $this->objsm->selectSujetsByProf($_SESSION['mail']);

		$result = $this->objsm->selectRecord($id);
		$row = mysqli_fetch_array($result);

		$questionDb = new question();
		$questionDb->ques_id = $row["ques_id"];
		$questionDb->ques_text = $row["ques_text"];
		$questionDb->ques_reponse = $row["ques_reponse"];
		$questionDb->suj_id = $row["suj_id"];


		//roleSelected

		$_SESSION['questionDb'] = serialize($questionDb);
		include "vue/Question/update.php";
	}

	public function read(){
		$urlParams = explode('/', $_SERVER['REQUEST_URI']);
		if (sizeof($urlParams)>3){
			$id = $urlParams[4];
		}

		$result=$this->objsm->selectRecord($id);
		$row=mysqli_fetch_array($result);  
		
		$questionDb=new question();                  
		$questionDb->ques_id=$row["ques_id"];
		$questionDb->ques_text=$row["ques_text"];
		$questionDb->ques_reponse=$row["ques_reponse"];
		$questionDb->suj_id=$row["suj_id"];


		$_SESSION['questionDb']=serialize($questionDb);
		include "vue/Question/read.php";
	}

	public function update()
	{
		try {
			$questionDb = new question();

			if (isset($_POST['updatebtn'])) {

				$questionDb = unserialize($_SESSION['questionDb']);
				$questionDb->ques_id = trim($_POST['ques_id']);
				$questionDb->ques_text = trim($_POST['ques_text']);
				$questionDb->ques_reponse = trim($_POST['ques_reponse']);
				$questionDb->suj_id = trim($_POST['sujetSelected']);

				$res = $this->objsm->updateRecord($questionDb);
				print_r($res);
				if ($res) {
					$this->pageRedirect("list");
				} else {
					echo "Somthing is wrong..., try again. \n";
					$_SESSION['questionDb'] = serialize($questionDb);
					$this->pageRedirect("update");
				}
			} elseif (isset($_GET["suj_id"]) && !empty(trim($_GET["suj_id"]))) {

				$suj_id = $_GET['suj_id'];

				$result = $this->objsm->selectRecord($suj_id);
				$row = mysqli_fetch_array($result);
				$questionDb = new question();
				$questionDb->ques_text = $row["ques_text"];
				$questionDb->ques_reponse = $row["ques_reponsed"];;
				$questionDb->suj_id = $row["sujetSelected"];

				$_SESSION['questionDb'] = serialize($questionDb);
				$this->pageRedirect('update');
			} else {


				$questionDb = unserialize($_SESSION['questionDb']);
				$questionDb->ques_text = trim($_POST['ques_text']);
				$questionDb->ques_reponse = trim($_POST['ques_reponse']);
				$questionDb->suj_id = trim($_POST['sujetSelected']);
				echo "Invalid operation.";
			}
		} catch (Exception $e) {
			$this->close_db();
			throw $e;
		}
	}

	public function delete()
		{
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }
            try
            {
                if ($id!=null) 
                {
                    $res=$this->objsm->deleteRecord($id);                
                    if($res){
                        $this->pageRedirect("list");                           
                    }else{
                        echo "Somthing is wrong..., try again.";

                    }
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }

}


?>