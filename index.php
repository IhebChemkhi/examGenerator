<?php

require_once('config.php');

    $url = $_SERVER['REQUEST_URI'];
    $parts = explode('/', $url);

    //var_dump($parts);

    $controller = (isset($parts[2])) ? $parts[2] : null;
    $action = (isset($parts[3])) ? $parts[3] : null;
    $idGet = (isset($parts[4])) ? $parts[4] : null;

    if ($action == null){
        $action = "list";
    }


    if ($controller == null) {
        $action = "afficheAccueil";
        require_once('controller/Accueil/accueilController.php');
        $controller = new accueilController();
    } else {
        switch ($controller) {
            case 'accueil':
                if ($action == "list"){
                    $action = "afficheAccueil";
                }
                require_once('controller/Accueil/accueilController.php');
                $controller = new accueilController();
                break;
            case 'compte':
                require_once('controller/Compte/compteController.php');
                $controller = new compteController();
                break;
            case 'profile':
                require_once('controller/Profile/profileController.php');
                $controller = new profileController();
                break;
            case 'matiere':
                require_once('controller/Matiere/matiereControler.php');
                $controller = new matiereControler();
                break;
            case 'cursus':
                require_once('controller/Cursus/cursusControler.php');
                $controller = new cursusControler();
                break;
            case 'professeur':
                require_once('controller/Profile/professeurController.php');
                $controller =new professeurController();
                break;
            case 'anneeScolaire':
                require_once('controller/anneeScolaire/anneeScolaireController.php');
                $controller =new anneeScolaireController();
                break;
            case 'classe':
                require_once('controller/classe/classeController.php');
                $controller =new classeController();
                break;
            case 'question':
                require_once('controller/Question/questionController.php');
                $controller =new questionController();
                break;
            case 'examen':
                require_once('controller/Questions/questionController.php');
                $controller =new questionController();
                break;
            case 'passageExamen':
                    require_once('controller/PassageExamen/passageExamenController.php');
                    $controller =new passageExamenController();
                    break;
            default:
                die(' => Error: no such page');
        }
    }
    if(isset($idGet)){
        $controller->{$action}($idGet);
    }else{
        $controller->{$action}();
    }

?>
