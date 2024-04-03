<?php
    require 'model/Compte/compteModel.php';
    require 'model/Compte/compte.php';
    
    require_once 'config.php';
    
    
	class compteController 
	{

 		function __construct() 
		{          
			$this->objconfig = new config();
			$this->objsm =  new compteModel($this->objconfig);
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
        // check validation
		public function checkValidation($sporttb)
        {    $noerror=true;
            // Validate category        
            if(empty($sporttb->category)){
                $sporttb->category_msg = "Field is empty.";$noerror=false;
            } elseif(!filter_var($sporttb->category, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $sporttb->category_msg = "Invalid entry.";$noerror=false;
            }else{$sporttb->category_msg ="";}            
            // Validate name            
            if(empty($sporttb->name)){
                $sporttb->name_msg = "Field is empty.";$noerror=false;     
            } elseif(!filter_var($sporttb->name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $sporttb->name_msg = "Invalid entry.";$noerror=false;
            }else{$sporttb->name_msg ="";}
            return $noerror;
        }
        
        // add new record
		public function insert()
		{
            try{
                $compteDb=new profile();
                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $compteDb->pseudo = trim($_POST['cpt_pseudo']);
                    $compteDb->mdp = trim($_POST['cpt_mdp']); 
                        //call insert record            
                        $pid = $this -> objsm ->insertRecord($compteDb);
                        if($pid>0){			
                            $this->list();
                        }else{
                            echo "Somthing is wrong..., try again.";
                            $_SESSION['compteDb']=serialize($compteDb);//add session obj           
                        $this->pageRedirect("vue/Compte/create.php"); 
                        }
                }
            }catch (Exception $e) 
            {
                $this->close_db();	
                throw $e;
            }
        }

        public function list(){
            $result=$this->objsm->selectRecord(0);
            include "vue/Compte/list.php";                                        
        }
    }
?>