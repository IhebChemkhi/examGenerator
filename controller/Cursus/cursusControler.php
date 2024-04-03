<?php

require 'model/Cursus/cursusModel.php';
require 'model/Cursus/cursus.php';
require_once 'config.php';


session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class cursusControler
{

    function __construct()
    {
        $this->objconfig = new config();
        $this->objsm = new cursusModel($this->objconfig);
    }

    /* public function affichecursus(){
    include "vue/Matiere/listMatiere.php";
    }*/


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

    public function pageRedirect($url)
    {
        //echo constant("ROOTPAGE")."/index/profile/liste";
        header('Location:' . ROOTPAGE . "cursus/" . $url); // Ajout d'un / pour faire fonctionner sur pc Anais
        die();
    }

    public function checkValidation($cursusDb)
    {
        $noerror = true;

        if (empty($cursusDb->cur_nom)) {
            $cursusDb->cur_nom_msg = "Champ vide.";
            $noerror = false;
        } elseif (!filter_var($cursusDb->cur_nom, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
            $cursusDb->cur_nom_msg = "Saisie invalide.";
            $noerror = false;
        } else {
            $cursusDb->cur_nom_msg = "";
        }

        return $noerror;

    }

    public function delete()
    {
        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
            var_dump($id);
        }
        try {
            if ($id != null) {
                $res = $this->objsm->deleteRecordCursus($id);
                if ($res) {
                    $this->pageRedirect('list');
                } else {
                    echo "Somthing is wrong..., try again.";
                }
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }

    }


    public function create()
    {
        try {
            echo "in create";

            $cursusDb = new cursus();

            if (isset($_POST['addbtn'])) {
                // read form value
                $cursusDb->cur_nom = trim($_POST['cur_nom']);
                var_dump($cursusDb);

                //call validation
                //$chk=$this->checkValidation($cursusDb);                    
                // if($chk)
                // {   
                //call insert record            
                $pid = $this->objsm->insertCursus($cursusDb);
                if ($pid > 0) {
                    $this->pageRedirect("list");
                } else {
                    echo "Somthing is wrong..., try again. \n";
                    echo "Le pseudo " . $cursusDb->cur_nom . " n'existe pas ?";
                    $_SESSION['cursusDb'] = serialize($cursusDb);
                    $this->pageRedirect("insert");
                    echo "erreur dans la saisie :(";
                }
                //}else{   
                //add session obj pr reremplir les champs          


            }
        } catch (Exception $e) {

            $this->close_db();
            throw $e;
        }
    }






    /* public function createcursus(){
    try{
    echo "in create";
    $cursusDb=new cursus();
    
    if (isset($_POST['addbtn'])) 
    {
    // read form value
    $cursusDb->mat_nom = trim($_POST['mat_nom']);
    
    //call validation
    $chk=$this->checkValidation($profileDb);                    
    if($chk)
    {   
    //call insert record            
    $pid = $this -> objsm ->insertRecord($profileDb);
    if($pid>0){
    $this->pageRedirect("list");
    }else{
    echo "Somthing is wrong..., try again. \n";
    echo "Le pseudo ". $profileDb->cpt_pseudo . " n'existe pas ?";
    }
    }else{   
    $_SESSION['profileDb']=serialize($profileDb);//add session obj pr reremplir les champs          
    $this->pageRedirect("insert"); 
    echo "erreur dans la saisie :(";
    
    }
    }
    }catch (Exception $e) 
    {
    
    $this->close_db();	
    throw $e;
    }
    }*/

    public function update()
    {
        try {
            var_dump($_POST);
            var_dump($_SESSION);
            $cursusDb = new cursus();

            if (isset($_POST['updateBtnCursus'])) {
                $cursusDb = unserialize($_SESSION['cursusDb']);
                $cursusDb->cur_id = trim($_POST['cur_id']);
                // read form value
                $cursusDb->cur_nom = trim($_POST['cur_nom']);
                var_dump($cursusDb);

                // check validation  
                $chk = $this->checkValidation($cursusDb);
                if ($chk) {
                    $res = $this->objsm->updateRecordCursus($cursusDb);
                    if ($res) {
                        $this->pageRedirect("list");
                    } else {
                        echo "Somthing is wrong..., try again. \n";
                        echo "Le cursus " . $cursusDb->cur_id . " n'existe pas ?";
                    }
                } else {
                    $_SESSION['cursusDb'] = serialize($cursusDb);
                    $this->pageRedirect("updateCursus");
                }
            } elseif (isset($_GET["cur_id"]) && !empty(trim($_GET["cur_id"]))) {
                $cur_id = $_GET['cur_id'];
                $result = $this->objsm->selectRecordCursus($cur_id);
                $row = mysqli_fetch_array($result);
                $cursusDb = new cursus();
                $cursusDb->cur_id = $row["cur_id"];
                $cursusDb->cur_nom = $row["cur_nom"];


                $_SESSION['cursusDb'] = serialize($cursusDb);
                $this->pageRedirect('updateCursus');
            } else {

                echo "Invalid operation.";
            }
        } catch (Exception $e) {
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


        $result = $this->objsm->selectRecordCursus($id);
        $row = mysqli_fetch_array($result);
        $cursusDb = new cursus();
        $cursusDb->cur_id = $row["cur_id"];
        $cursusDb->cur_nom = $row["cur_nom"];
        $_SESSION['cursusDb'] = serialize($cursusDb);
        include "vue/Cursus/update.php";

    }


    public function read()
    {
        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
            var_dump($id);
        }

        $result = $this->objsm->selectRecordCursus($id);
        $row = mysqli_fetch_array($result);
        $cursusDb = new cursus();
        $cursusDb->cur_id = $row["cur_id"];
        $cursusDb->cur_nom = $row["cur_nom"];


        $_SESSION['cursusDb'] = serialize($cursusDb);
        include "vue/Cursus/read.php";
    }

    public function insert()
    {
        if (isset($_SESSION['cursusDb'])) {
            unset($_SESSION['cursusDb']);
        }
        include "vue/Cursus/create.php";
    }

    public function list()
    {
        $result = $this->objsm->selectRecordCursus(0);
        include "vue/Cursus/list.php";
    }
}
?>