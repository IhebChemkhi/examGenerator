<?php
    require 'model/Profile/profileModel.php';
    require 'model/Profile/profile.php';
    require 'model/Compte/compteModel.php';
    require 'model/Compte/compte.php';

    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

	class profileController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new profileModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
        echo $act;
			switch ($act) 
			{
            case 'add':
                echo "here";           
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this->delete();
					break;								
				default:
                    $this->list();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
            //echo constant("ROOTPAGE")."/index/profile/liste";
			header('Location:'. ROOTPAGE ."profile/" . $url);
            die();
		}	


        // add new record
		public function create(){
            try{
                echo "in create";

                $profileDb=new profile();
                $compteDb=new compte();
            
                if (isset($_POST['addbtn'])) 
                {
                    // read form value
                    $profileDb->pfl_nom = trim($_POST['pfl_nom']);
                    $profileDb->pfl_prenom = trim($_POST['pfl_prenom']);
                    $profileDb->pfl_dateNaissance = trim($_POST['pfl_dateNaissance']);
                    $profileDb->pfl_mail = trim($_POST['pfl_mail']);
                    $compteDb->cpt_pseudo = trim($_POST['cpt_pseudo']);
                    $compteDb->cpt_mdp = trim($_POST['cpt_mdp']);
                    $roleSelected = trim($_POST['roleSelected']);
                    $cursusSelected = trim ($_POST['cursusSelected']);
                    $anneSelected = trim ($_POST['anneSelected']);
                    $classeSelected = trim($_POST['classeSelected']);
                    var_dump($profileDb);
                    var_dump($compteDb);
                          
                    $pid = $this -> objsm ->insertRecord($profileDb, $compteDb, $roleSelected,$cursusSelected,$anneSelected,$classeSelected);
                    
                        if($pid>0){
                            $this->pageRedirect("list");
                        }else{
                            echo "Somthing is wrong..., try again. \n";
                            echo "Le pseudo ". $profileDb->cpt_pseudo . " n'existe pas ?";
                            $_SESSION['profileDb']=serialize($profileDb);//add session obj pr reremplir les champs          
                            $this->pageRedirect("insert");
                        }
                        var_dump($pid);
                }
            }catch (Exception $e) 
            {
                
                $this->close_db();	
                throw $e;
            }
        }
        
        // update record
        public function update()
		{
            try
            {
                $profileDb=new profile();
                $compteDb=new compte();
                $roleSelected="";

                if (isset($_POST['updatebtn'])) 
                {

                    $profileDb=unserialize($_SESSION['profileDb']);
                    $profileDb->pfl_id = trim($_POST['pfl_id']);
                    $profileDb->pfl_nom = trim($_POST['pfl_nom']);
                    $profileDb->pfl_prenom = trim($_POST['pfl_prenom']);
                    $profileDb->pfl_dateNaissance = trim($_POST['pfl_dateNaissance']);
                    $profileDb->pfl_mail = trim($_POST['pfl_mail']);
                    $compteDb->cpt_pseudo = trim($_POST['cpt_pseudo']);
                    $compteDb->cpt_mdp = trim($_POST['cpt_mdp']);
                    $cursusSelected = trim ($_POST['cursusSelected']);
                    $anneSelected = trim ($_POST['anneSelected']);
                    $classeSelected = trim($_POST['classeSelected']);

                    //$roleSelected = trim($_POST['roleSelected']);         
                        $res = $this -> objsm ->updateRecord($profileDb, $compteDb,/**$roleSelected,**/$cursusSelected,$anneSelected,$classeSelected);	                        
                        print_r($res);
                        if($res){			
                           $this->pageRedirect("list");                           
                        }else{
                            echo "Somthing is wrong..., try again. \n";
                            echo "Le pseudo ". $profileDb->cpt_pseudo . " n'existe pas ?";
                            $_SESSION['profileDb']=serialize($profileDb);      
                            $this->pageRedirect("update");
                        }
                }elseif(isset($_GET["pfl_id"]) && !empty(trim($_GET["pfl_id"]))){
                   
                    $pfl_id=$_GET['pfl_id'];
                    
                    $result=$this->objsm->selectRecord($pfl_id);
                    $row=mysqli_fetch_array($result);  
                    $profileDb=new profile();                  
                    $profileDb->pfl_id=$row["pfl_id"];
                    $profileDb->pfl_nom=$row["pfl_nom"];
                    $profileDb->pfl_prenom=$row["pfl_prenom"];
                    $profileDb->pfl_dateNaissance=$row["pfl_dateNaissance"];
                    $profileDb->pfl_mail=$row["pfl_mail"];
                    $profileDb->cpt_pseudo=$row["cpt_pseudo"];
                    $compteDb->cpt_pseudo = trim($_POST['cpt_pseudo']);
                    $compteDb->cpt_mdp = trim($_POST['cpt_mdp']); 
                    //$roleSelected = trim($_POST['roleSelected']);           

                    $_SESSION['profileDb']=serialize($profileDb);
                    $this->pageRedirect('update');
                }else{


                    $profileDb=unserialize($_SESSION['profileDb']);
                    $compteDb->cpt_pseudo = trim($_POST['cpt_pseudo']);
                    $compteDb->cpt_mdp = trim($_POST['cpt_mdp']);
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                $this->close_db();				
                throw $e;
            }
        }

        // delete record
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
                        $this->pageRedirect('list');
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


        public function edit(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }
            
            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result); 
            $class=$this->objsm->AfficherClasses();
            $cursus = $this->objsm->AfficherCursus();
            $annee= $this->objsm->AfficherAnnee(); 
            $profileDb=new profile();                  
            $profileDb->pfl_id=$row["pfl_id"];
            $profileDb->pfl_nom=$row["pfl_nom"];
            $profileDb->pfl_prenom=$row["pfl_prenom"];
            $profileDb->pfl_dateNaissance=$row["pfl_dateNaissance"];
            $profileDb->pfl_mail=$row["pfl_mail"];
            $profileDb->cpt_pseudo=$row["cpt_pseudo"];

            //roleSelected

            $_SESSION['profileDb']=serialize($profileDb);
            include "vue/Profile/update.php";
        }

        public function insert(){
            if (isset($_SESSION['profileDb'])) {
                unset($_SESSION['profileDb']);
            }
            $class=$this->objsm->AfficherClasses();
            $cursus = $this->objsm->AfficherCursus();
            $annee= $this->objsm->AfficherAnnee();
            include "vue/Profile/create.php";                                        
        }

        public function read(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }

            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result);  
            $profileDb=new profile();                  
            $profileDb->pfl_id=$row["pfl_id"];
            $profileDb->pfl_nom=$row["pfl_nom"];
            $profileDb->pfl_prenom=$row["pfl_prenom"];
            $profileDb->pfl_dateNaissance=$row["pfl_dateNaissance"];
            $profileDb->pfl_mail=$row["pfl_mail"];
            $profileDb->cpt_pseudo=$row["cpt_pseudo"];

            $_SESSION['profileDb']=serialize($profileDb);
            include "vue/Profile/read.php";


        }

        public function importCSV(){

            $compteDb = new compte();
            $profileDb = new profile();


            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
                // Vérifier si le fichier est un fichier CSV
                if ($_FILES['csv_file']['type'] === 'text/csv') {
                $row = 1;
                if (($handle = fopen($_FILES['csv_file']['tmp_name'], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        // Ignorer la première ligne (en-tête)
                        if ($row !== 1) {
                            $cpt_pseudo = $data[0];
                            $pfl_mail = $data[1];
                            $cpt_mdp = $data[5];
                            $pfl_nom = $data[2];
                            $pfl_prenom = $data[3];
                            
                            $pfl_dateNaissance = $data[4];
                           
                           // $role = $data[6];
    
                            // Insérer le compte
                            $cpt_id = $this->objsm->createCompte($cpt_pseudo, $cpt_mdp);
    
                            // Insérer le profil
                           $pfl_id = $this->objsm->createProfile($pfl_nom, $pfl_prenom, $pfl_dateNaissance, $pfl_mail, $cpt_id);
                        }
                        $row++;
                    }
                    fclose($handle);
                }
    
                // Rediriger vers une page de confirmation
                header('Location:'. ROOTPAGE ."profile/");
                exit();
            } else {
                // Afficher une erreur si le fichier n'est pas un fichier CSV
                echo 'Le fichier doit être un fichier CSV.';
            }
        }
        
        // Afficher le formulaire d'importation
        //require 'view/import-form.php';
    }
        



        /*public function importCSV()
        {
         if(isset($_POST["import"])) {
            $filename = explode(".", $_FILES['csv_file']['name']);
            if ($filename[1] == 'csv') {
                $handle = fopen($_FILES['csv_file']['tmp_name'], "r");
                $row = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row == 0) {
                        $row++;
                        continue;
                    }
                    $row++;{

                    $cpt_pseudo = trim($data[0]);
                    $cpt_mdp = trim($data[1]);
                    $pfl_nom = trim($data[2]);
                    $pfl_prenom = trim($data[3]);
                    $pfl_dateNaissance = trim($data[4]);
                    $pfl_mail = trim($data[5]);
                    $role = trim($data[6]);

                    // Vérifier si le compte existe déjà
                    $c_id = $this->objsm->getCompteByPseudo($cpt_pseudo);
                    if($c_id) {
                       continue;
                    }

                    $c_id = $this ->objsm-> createCompte($cpt_pseudo,password_hash($mdp, PASSWORD_DEFAULT));

                    $pfl_id = $this->objsm->createProfile($pfl_nom,$pfl_prenom,$pfl_dateNaissance,$pfl_mail,$c_id);

                    /*switch($role){
                        case 'eleves':
                            $this->obsjm->addRoleEleve($pfl_id);
                            break;
                        case 'admin':
                            $this->obsjm->addRoleAdmin($pfl_id);
                            break;
                        case 'professeurs':
                            $this->obsjm->addRoleProfesseur($pfl_id);
                            break;
                            default: 
                            break;
                    }
                }
                fclose($handle);
                echo "Importation réussie avec succès";
            }

            }else{
                "Le fichier doit être un CSV";
            }
            
             }

             include "vue/Profile/list.php";
        }*/




        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "vue/Profile/list.php";                                        
        }
    	
    }
	
?>