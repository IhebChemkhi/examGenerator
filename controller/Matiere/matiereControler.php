<?php

require 'model/Matiere/matiereModel.php';
require 'model/Matiere/matiere.php';
require 'model/Profile/profileModel.php';
require 'model/Profile/profile.php';
require_once 'config.php';


session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class matiereControler
{

    function __construct()
    {
        $this->objconfig = new config();
        $this->objsm =  new matiereModel($this->objconfig);
    }

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
        header('Location:' . ROOTPAGE . "matiere/" . $url);
        die();
    }

    public function delete()
    {
        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
            //var_dump($id);
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


    public function create()
    {
        try {
            echo "in create";
            $matiereDb = new matiere();
            $profileDb = new profile();
            //var_dump($profileDb);

            if (isset($_POST['addbtn'])) {


                // read form value
                $matiereDb->mat_nom = trim($_POST['mat_nom']);
                $professeursSelected = trim($_POST['professeursSelected']);
                // $profileDb->pfl_nom = trim($_POST['pfl_nom']);

                //call insert record            
                $pid = $this->objsm->insertMatiere($matiereDb, $profileDb, $professeursSelected);
                if ($pid > 0) {
                    $this->pageRedirect("list");
                } else {
                    echo "Somthing is wrong..., try again. \n";
                    echo "La matière " . $matiereDb->mat_nom . " n'existe pas ?";
                    $_SESSION['matiereDb'] = serialize($matiereDb);
                    $this->pageRedirect("insert");
                    echo "erreur dans la saisie :(";
                }
            }
        } catch (Exception $e) {

            $this->close_db();
            throw $e;
        }
    }

    public function update()
    {
        try {
            $matiereDb = new matiere();

            if (isset($_POST['updatebtnMatiere'])) {
                $matiereDb = unserialize($_SESSION['matiereDb']);
                $matiereDb->mat_id = trim($_POST['mat_id']);
                $matiereDb->mat_nom = trim($_POST['mat_nom']);

                $professeursSelected = trim($_POST['professeursSelected']);

                $res = $this->objsm->updateRecordMatiere($matiereDb, $professeursSelected);
                if ($res) {
                    $this->pageRedirect("list");
                } else {
                    echo "Somthing is wrong..., try again. \n";
                    echo "Le pseudo " . $matiereDb->mat_id . " n'existe pas ?";
                    $_SESSION['matiereDb'] = serialize($matiereDb);
                    $this->pageRedirect("update");
                }
            } elseif (isset($_GET["mat_id"]) && !empty(trim($_GET["mat_id"]))) {
                $mat_id = $_GET['mat_id'];
                $result = $this->objsm->selectRecordMatiere($mat_id);
                $row = mysqli_fetch_array($result);
                $matiereDb = new matiere();
                $matiereDb->mat_id = $row["mat_id"];
                $matiereDb->mat_nom = $row["mat_nom"];
                $professeursSelected = $row["professeursSelected"];

                $_SESSION['matiereDb'] = serialize($matiereDb);
                $this->pageRedirect('update');
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
            //var_dump($id);
        }


        $result = $this->objsm->selectRecordMatiere($id);
        $row = mysqli_fetch_array($result);
        $matiereDb = new matiere();
        $matiereDb->mat_id = $row["mat_id"];
        $matiereDb->mat_nom = $row["mat_nom"];
        $professeur = $this->objsm->selectAllProfesseur();


        $_SESSION['matiereDb'] = serialize($matiereDb);
        include "vue/Matiere/update.php";
    }


    public function read()
    {
        $urlParams = explode('/', $_SERVER['REQUEST_URI']);
        if (sizeof($urlParams) > 3) {
            $id = $urlParams[4];
            var_dump($id);
        }

        $result = $this->objsm->selectRecordMatiere($id);
        $row = mysqli_fetch_array($result);
        $matiereDb = new matiere();
        $matiereDb->mat_id = $row["mat_id"];
        $matiereDb->mat_nom = $row["mat_nom"];


        $_SESSION['matiereDb'] = serialize($matiereDb);
        include "vue/Matiere/read.php";
    }

    public function insert()
    {
        if (isset($_SESSION['matiereDb'])) {
            unset($_SESSION['matiereDb']);
        }
        $professeur = $this->objsm->selectAllProfesseur();

        include "vue/Matiere/create.php";
    }


    public function list()
    {
        $result = $this->objsm->selectRecordMatiere(0);
        include "vue/Matiere/list.php";
    }
}
