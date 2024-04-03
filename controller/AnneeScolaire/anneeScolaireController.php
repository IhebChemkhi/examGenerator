<?php
    require 'model/AnneeScolaire/anneeScolaireModel.php';
    require 'model/AnneeScolaire/AnneeScolaire.php';
    
    require_once 'config.php';
    
    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

	class anneeScolaireController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new anneeScolaireModel($this->objconfig);
		}
        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :                    
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;								
				default:
                    $this->liste();
			}
		}		
        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}	
        
        
        // add new record
		public function create(){
            try{
                echo "in create";

                $anneeScolaireDb=new anneeScolaire();
            
                if (isset($_POST['addbtn'])) 
                {
                    // read form value
                    $anneeScolaireDb->ann_annee = trim($_POST['ann_annee']);
                          
                    $pid = $this -> objsm ->insertRecord($anneeScolaireDb);
                    
                        if($pid>0){
                            $this->pageRedirect("list");
                        }else{
                            echo "Somthing is wrong..., try again. \n";
                            $_SESSION['anneeScolaireDb']=serialize($anneeScolaireDb);//add session obj pr reremplir les champs          
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

        public function update()
		{
            try
            {
                $anneeScolaireDb=new anneeScolaire();

                if (isset($_POST['updatebtn'])) 
                {
                    var_dump($_SESSION);
                    $anneeScolaireDb=unserialize($_SESSION['anneeScolaireDb']);
                    
                    $anneeScolaireDb->ann_annee = trim($_POST['ann_annee']);
                    $anneeScolaireDb->ann_id = trim($_POST['ann_id']);


                        $res = $this -> objsm ->updateRecord($anneeScolaireDb);	                        
                        //print_r($res);
                        if($res){			
                            
                           $this->pageRedirect("list");                           
                        }else{
                            
                            echo "Somthing is wrong..., try again. \n";
                            $_SESSION['anneeScolaireDb']=serialize($anneeScolaireDb);      
                            $this->pageRedirect("update");  
                        }
                }elseif(isset($_GET["ann_id"]) && !empty(trim($_GET["ann_id"]))){
                    
                    $ann_id=$_GET['ann_id'];
                    
                    $result=$this->objsm->selectRecord($ann_id);
                    $row=mysqli_fetch_array($result);  

                $anneScolaire=new anneeScolaire();
                $anneScolaire->ann_annee = trim($_POST['ann_annee']);          

                    $_SESSION['anneeScolaireDb']=serialize($anneeScolaireDb);
                    $this->pageRedirect('update');
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


        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "vue/AnneeScolaire/list.php";                                        
        }

        public function insert(){
            if (isset($_SESSION['anneeScolaireDb'])) {
                unset($_SESSION['anneeScolaireDb']);
            }
            
            include "vue/AnneeScolaire/create.php";                                        
        }

        public function read(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }

            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result);  
            
            $anneeScolaireDb=new anneeScolaire();                  
            $anneeScolaireDb->ann_id=$row["ann_id"];
            $anneeScolaireDb->ann_annee=$row["ann_annee"];


            $_SESSION['anneeScolaireDb']=serialize($anneeScolaireDb);
            include "vue/AnneeScolaire/read.php";
        }

        public function edit(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }
            
            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result); 

            $anneeScolaireDb=new anneeScolaire();                  
            $anneeScolaireDb->ann_id=$row["ann_id"];
            $anneeScolaireDb->ann_annee=$row["ann_annee"];


            $_SESSION['anneeScolaireDb']=serialize($anneeScolaireDb);
            include "vue/AnneeScolaire/update.php";
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
                        $this->pageRedirect(ROOTPAGE . "anneeScolaire/list");                           
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