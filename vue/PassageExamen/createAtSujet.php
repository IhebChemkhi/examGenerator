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
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Ajouter un examen</h2>
                                
                    </div><br>
                    <form action="createAfterSujet" method="POST" id="form">


                    <div class="form-group">
                        <label>Ajouter un examen avec quelles sujets ? :</label>
                         <select class="form-select form-select-lg mb-3" name="sujetSelected" aria-label=".form-select-lg example">



                         
                          <?php
                         if ($sujet->num_rows > 0) {
                         while ($row = mysqli_fetch_array($sujet)) {
                          if (array_key_exists("suj_id", $row)) {
                          $suj_id = $row["suj_id"];
                          } else {
                           $suj_id = "";
                             }
                         if (array_key_exists("suj_titre", $row)) {
                       $suj_titre = $row["suj_titre"];
                          } else {
                        $suj_titre = "";
                           }

                           ?>
                         <option value="<?php echo $suj_id ?>"><?php echo $suj_id ?> - <?php echo $suj_titre ?></option>
                         <?php 
                                 }
                           }
                           ?>
                     </select>
                    </div>



               <div class = "my-3">         
                 <input type="hidden" name="exam_id" value="<?php echo $passageExamenDb->exam_id; ?>"/>
                <input type="Submit" name="addSujet" class="btn btn-primary" value="Submit">
                <a href="<?php echo ROOTPAGE . "passageExamen";?>" class="btn btn-default">Cancel</a>
                </div>
                    </form>
                </div>
            </div>        
        </div>
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

