<?php include("./includes/sidebar.php"); ?>
<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

$role = "notConnected";
if (isset($_SESSION['isLogged']) && isset($_SESSION['mail'])) {
    if ($_SESSION['isLogged'] == true) {
        $mail = $_SESSION['mail'];
        $role = $_SESSION['role'];
    }
}

require_once(constant("ROOT").'/model/PassageExamen/passageExamen.php');        
$passageExamenDb=isset($_SESSION['passageExamenDb'])?unserialize($_SESSION['passageExamenDb']):new passageExamen();

//var_dump($_SESSION);
?>
<main class="col-md-9 col-lg-10 px-md-4">
    <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Accueil</h1>
    </div>

    <body>
        <?php
        if ($_SESSION['isLogged'] == true) {

            ?>

            <div>
                <h2 class="pull-left">Bonjour
                    <?php echo $mail ?>
                </h2>
                <h3 class="pull-left">Vous etes connecté en tant que <b style="color: blue;">
                        <?php echo $role ?>
                    </b></h3>
            </div><br><br>

            <?php

        } else {

            ?>

            <div>
                <h2 class="pull-left">Bonjour, Vous n'etes pas connecté. Pour acceder aux pages veuilez vous connecter</h2>
            </div><br><br>

            <?php

        }
        ?>

        <?php

        if ($role == "administrateur" || $role == "professeur") {
            ?>



<div class="wrapper">

<div class="container-fluid">
<a href="<?php echo ROOTPAGE . "passageExamen";?>" class="btn btn-success"><i class="bi bi-arrow-left"></i> Retour</a>

    <div class="row">
        <div class="col-md-12">
            <div class="mt-5 mb-3 d-flex justify-content-between">
                <h2 class="pull-left">Ajouter les points pour chaque questions de votre examen : </h2>
            </div>
 
<form action='' method='post'>
 <div class="form-group">
    <label>Nom de l'examen:</label>

    <input type="text" name="exam_titre" class="form-control" required="required"
        pattern="[A-Za-z0-9]{1,20}" value="<?php echo $passageExamenDb->exam_titre; ?>">
</div><br><br>
<?php

            if (count($questions) > 0) {
                echo '<table class="table table-bordered table-striped">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>Ennoncé de la question</th>";
                echo "<th>Reponse attendu</th>";
                echo "<th>Points accordé</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($questions as $ques){

                   
                    echo "<tr>";
                    echo "<td>" . $ques["ques_text"] . "</td>";
                    echo "<td>" . $ques["ques_reponse"] . "</td>";
                    ?>
                    <td><div class='col-sm-6 mb-3'>
                    <input type='number' class='form-control' name='noteQuestion[]' required>
                    <input type="hidden" name="ques_id[]" value="<?php echo $ques["ques_id"] ?>"/>

                            </div></td>

                    </tr><?php

                }?>

                </tbody>
            </table>

                <div class ="my-3">
                <input type="submit" name='addNote' class='btn btn-primary' value='Submit'>
                </div>
                   
                </form><?php

$tabNotage=[];

if (isset($_POST['noteQuestion'])) {
    $tabN = $_POST['noteQuestion'];
$tabI = $_POST['ques_id'];

for ($i=0; $i < sizeof($tabN); $i++) { 
        $valKey = $tabI[$i];
        $valNote = $tabN[$i];

        $tmp = array($valKey, $valNote);
        array_push($tabNotage, $tmp);
}

//var_dump($tabNotage);


$_SESSION["notes"] = $tabNotage;
$_SESSION["exam_titre"] = $_POST['exam_titre'];


//var_dump($_SESSION);

        echo "<script> location.href='" . ROOTPAGE . "passageExamen/addNoteQuestion" . "'; </script>";
        exit;
/*
header('Location:' . ROOTPAGE . "passageExamen/addNoteQuestion");
        die();*/
}




                /* Free result set */
            } else {
                echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
            }
            ?>
        </div>
    </div>
</div><br><br><br><br><br><br><br>
</div>

            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les profs peuvent ajouter !</h2>

            <?php
        }
        ?>


    </body>
    </table>
    </div>
</main>
</div>
</div>

<?php include("./includes/footer.php"); ?>

