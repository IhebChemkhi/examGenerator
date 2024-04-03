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

require_once(constant("ROOT").'/model/Matiere/matiere.php');        
$matiereDb=isset($_SESSION['matiereDb'])?unserialize($_SESSION['matiereDb']):new matiere();


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

        if ($role == "administrateur") {
            ?>



            
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Ajouter une matière</h2>
                        
                                
                    </div><br>
                    <form action="create" method="POST">

                    <div class="form-group">
              <input type="text" name="mat_nom" class="form-control" value="<?php echo $matiereDb->mat_nom; ?>">
              <span style="color: red;" class="help-block"></span>
              </div>

                    <div class="form-group">
                        <label>Professeur :</label>
                         <select class="form-select form-select-lg mb-3" name="professeursSelected" aria-label=".form-select-lg example">
                          <?php 
                         if ($professeur->num_rows > 0) {
                         while ($row = mysqli_fetch_array($professeur)) { 
                          if (array_key_exists("pfl_id", $row)) {
                          $pfl_id = $row["pfl_id"];
                          } else {
                           $pfl_id = "";
                             }
                         if (array_key_exists("pfl_nom", $row)) {
                       $pfl_nom = $row["pfl_nom"];
                          } else {
                        $pfl_nom = "";
                           }

                           ?>
                         <option value="<?php echo $pfl_id ?>"><?php echo $pfl_id ?> - <?php echo $pfl_nom ?></option>
                         <?php 
                                 }
                           }
                           ?>
                     </select>
                    </div>



               <div class = "my-3">         
                 <input type="hidden" name="mat_id" value="<?php echo $matiereDb->mat_id; ?>"/>
                <input type="Submit" name="addbtn" class="btn btn-primary" value="Submit">
                <a href="<?php echo ROOTPAGE . "matiere";?>" class="btn btn-default">Cancel</a>
                </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs peuvent ajouter !</h2>

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

