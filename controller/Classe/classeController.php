<?php
    require 'model/Classe/classeModel.php';
    require 'model/Classe/classe.php';
    
    require_once 'config.php';
    
    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

	class classeController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new classeModel($this->objconfig);
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

                $classeDb=new classe();
            
                if (isset($_POST['addbtn'])) 
                {
                    // read form value
                    $classeDb->cla_nom = trim($_POST['cla_nom']);
                          
                    $pid = $this -> objsm ->insertRecord($classeDb);
                    
                        if($pid>0){
                            $this->pageRedirect("list");
                        }else{
                            echo "Somthing is wrong..., try again. \n";
                            $_SESSION['classeDb']=serialize($classeDb);//add session obj pr reremplir les champs          
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
                $classeDb=new classe();

                if (isset($_POST['updatebtn'])) 
                {
                    var_dump($_SESSION);
                    $classeDb=unserialize($_SESSION['classeDb']);
                    
                    $classeDb->cla_nom = trim($_POST['cla_nom']);
                    $classeDb->cla_id = trim($_POST['cla_id']);


                        $res = $this -> objsm ->updateRecord($classeDb);	                        
                        //print_r($res);
                        if($res){			
                            
                           $this->pageRedirect("list");                           
                        }else{
                            
                            echo "Somthing is wrong..., try again. \n";
                            $_SESSION['classeDb']=serialize($classeDb);      
                            $this->pageRedirect("update");  
                        }
                }elseif(isset($_GET["cla_id"]) && !empty(trim($_GET["cla_id"]))){
                    
                    $cla_id=$_GET['cla_id'];
                    
                    $result=$this->objsm->selectRecord($cla_id);
                    $row=mysqli_fetch_array($result);  

                $classeDb=new classe();
                $classeDb->cla_nom = trim($_POST['cla_nom']);          

                    $_SESSION['classeDb']=serialize($classeDb);
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
            include "vue/Classe/list.php";                                        
        }

        public function insert(){
            if (isset($_SESSION['classeDb'])) {
                unset($_SESSION['classeDb']);
            }
            
            include "vue/Classe/create.php";                                        
        }

        public function read(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }

            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result);  
            
            $classeDb=new classe();                  
            $classeDb->cla_id=$row["cla_id"];
            $classeDb->cla_nom=$row["cla_nom"];


            $_SESSION['classeDb']=serialize($classeDb);
            include "vue/Classe/read.php";
        }

        public function edit(){
            $urlParams = explode('/', $_SERVER['REQUEST_URI']);
            if (sizeof($urlParams)>3){
                $id = $urlParams[4];
            }
            
            $result=$this->objsm->selectRecord($id);
            $row=mysqli_fetch_array($result); 

            $classeDb=new classe();                  
            $classeDb->cla_id=$row["cla_id"];
            $classeDb->cla_nom=$row["cla_nom"];


            $_SESSION['classeDb']=serialize($classeDb);
            include "vue/Classe/update.php";
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
                        $this->pageRedirect(ROOTPAGE . "classe/list");                           
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