<?php
require 'model/Accueil/accueilModel.php';
require 'model/Accueil/accueil.php';
require_once("controller/Compte/compteController.php");
require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();



class accueilController
{

	function __construct()
	{
		$this->objconfig = new config();
		$this->objsm = new accueilModel($this->objconfig);
	}

	// page redirection
	public function pageRedirectProfile($url)
	{
		header('Location:' . constant("ROOTPAGE") . "index/profile/" . $url);
		die();
	}

	public function afficheAccueil()
	{
		include "vue/Accueil/home.php";
	}

	public function afficheLogin()
	{
		include "vue/Authentification/connectionPage.php";
	}

	public function pageRedirect($url)
		{

			header('Location:'.ROOTPAGE. $url);
            die();
		}

	public function exit(){ 
		session_destroy();
		header('Location:'.ROOTPAGE. "accueil");
	}

	public function notLoggedRedirect(){
		include "vue/Accueil/notLoggedHome.php";
	}


	public function forgetMdp()
	{
		include "vue/Authentification/passwordForget.php";
	}

	public function authentification()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$mdp = trim($_POST['mdp']);
			$email = trim($_POST['email']);
			$result = $this->objsm->verifierCompte($email, $mdp);
			if ($result) {
				$role = $this->objsm->verifierRole($email);
				$_SESSION['mail'] = $email;
				$_SESSION['role'] = $role;
				$_SESSION['isLogged'] = true;
				header('Location:'.ROOTPAGE. "accueil");
				/*
				$compteController = new compteController();
				$compteController->afficherHome();*/
			} else {
				//   header('Location: connectionPage.php');
				echo "NOT CONNECTED";
			}
		}

		//			$this->pageRedirectProfile("list");
	}

	
	public function afficherHome(){
		include "vue/Accueil/home.php";
	}


	public function resetPassWordC(){

		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$email = trim($_POST['email']);
			
			//$pfl_id=$_POST['pfl_id'];

			$result = $this->objsm->getUserByMail($email);
			var_dump($result);
			if(!$result){
				echo "Pas d'email à ce nom";
				return;
			}
			/*if($result->num_rows == 0){
				echo "Pas d'email à ce nom";
				return;
		}
			var_dump($email);

			/*if(!$result){
				echo "Pas d'email à ce nom";
				return;
			}*/

			$newPassword = substr(md5(uniqid()),0,8);
			$hashedPassword=password_hash($newPassword,PASSWORD_DEFAULT);

			/*if (is_object($result)) {
				$this->objsm->updatePassWordPeople($result->id,$hashedPassword);
			  } else {
				 echo "pas un pbject";// gérer le cas où $result n'est pas un objet
			  }*/

			//$user = $result->fetch_object();
			 //$this->objsm->updatePassWordPeople($user->id,$hashedPassword);
			$this->objsm->updatePassWordPeople($result['pfl_id'],$hashedPassword);


			$to = $email;
			$subject = 'Nouveau mot de passe';
			$message = 'Votre nouveau mot de passe est : ' .$newPassword;
			mail($to, $subject, $message);
			include "vue/Authentification/passwordForget.php";
			echo "un email vous a été envoyé";
			echo $hashedPassword;
		}else{
			echo "Erreur";
		}
		
	}
}


?>