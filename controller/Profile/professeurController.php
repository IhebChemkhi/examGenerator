<?php
require 'model/Profile/profileModel.php';
require 'model/Profile/profile.php';
require 'model/Compte/compteModel.php';
require 'model/Compte/compte.php';
require 'model/Matiere/matiereModel.php';
require 'model/Matiere/matiere.php';

require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class professeurController
{

    function __construct()
    {
        $this->objconfig = new config();

        $this->objsm = new matiereModel($this->objconfig);

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
        //echo constant("ROOTPAGE")."/index/profile/liste";
        header('Location:' . ROOTPAGE . "professeur/" . $url);
        die();
    }

    public function delete($id)
    {
        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
        }
        try {
            if ($id != null) {
                $res = $this->objsm->deleteRecordMatiere($id);
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

    public function listSujets()
    {
        $this->objsm = new profileModel($this->objconfig);
        $result = $this->objsm->selectSujetsParProfesseur($_SESSION['mail']);
        include "vue/Profile/Professeur/listSujet.php";
    }

    public function deleteSujet($id)
    {
        $this->objsm = new profileModel($this->objconfig);
        if ($id != null) {
            $result = $this->objsm->deleteSujetParID($id);
            if ($result) {
                $this->pageRedirect('listSujets');
            } else {
                echo "Somthing is wrong..., try again.";
            }
        } else {
            echo "Invalid operation.";
        }

    }



    public function addSujetForm()
    {
        $result = $this->objsm->selectMatieresParProfesseur($_SESSION["mail"]);
        include "vue/Profile/Professeur/createSujet.php";
    }
    public function addSujet()
    {
        $this->objsm = new profileModel($this->objconfig);
        if (isset($_POST['addbtn'])) {
            $titre = trim($_POST['suj_titre']);
            $idMatiere = trim($_POST['matiereSelected']);
            $result = $this->objsm->getProfileIDbyMail($_SESSION["mail"]);
            $rowResult = mysqli_fetch_array($result);
            $result = $this->objsm->ajouterNouveauSujet($titre, $rowResult['pfl_id']);
            if ($result > 0) {
                $this->pageRedirect("listSujets");
            } else {
                echo "Somthing is wrong..., try again. \n";
                $this->pageRedirect("addSujetForm");
            }
            var_dump($result);
        }
    }

    public function editSujet()
    {
        $this->objsm = new profileModel($this->objconfig);

        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
        }
        $res = $this->objsm->selectMatieresParProfesseur($_SESSION["mail"]);
        $result = $this->objsm->selectSujetsParID($id);
        $rowResult = mysqli_fetch_array($result);
       
        //$class=$this->objsm->AfficherClasses();
        //$cursus = $this->objsm->AfficherCursus();
        // $annee= $this->objsm->AfficherAnnee(); 
        include "vue/Profile/Professeur/updateSujet.php";
    }

    public function updateSujet()
    {
        try {
            
            $this->objsm = new profileModel($this->objconfig);
            if (isset($_POST['updatebtn'])) {
                $sujet = trim($_POST['suj_titre']);
                $sujetID = trim($_POST['suj_id']);
                //$matiere = trim($_POST['matiereSelected']);
                $result = $this->objsm->getProfileIDbyMail($_SESSION["mail"]);
                $rowResult = mysqli_fetch_array($result);
                $res = $this->objsm->updateSujet($sujetID, $sujet, $_SESSION["mail"],$rowResult['pfl_id']);
                //print_r($res);
                if ($res) {
                    $this->pageRedirect("listSujets");
                } else {
                    echo "Somthing is wrong..., try again. \n";
                   
                    $this->pageRedirect("updateSujet");
                }
            } elseif (isset($_GET["pfl_id"]) && !empty(trim($_GET["pfl_id"]))) {


                $this->pageRedirect('update');
            } else {
                echo "Invalid operation.";
            }
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }



    public function insert()
    {
        if (isset($_SESSION['matiereDb'])) {
            unset($_SESSION['matiereDb']);
        }
        include "vue/Matiere/add.php";
    }
    public function list()
    {
        $result = $this->objsm->selectMatieresParProfesseur($_SESSION['mail']);
        include "vue/Profile/Professeur/list.php";
    }
}


?>