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

require_once(constant("ROOT").'/model/Cursus/cursus.php');        
$cursusDb=isset($_SESSION['cursusDb'])?unserialize($_SESSION['cursusDb']):new cursus();


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
                        <h2>Modifier le cursus</h2>
                        
                                
                    </div><br>
                    <form action="../update" method="POST">

                    <div class="form-group <?php echo (!empty($cursusDb->cur_id_msg)) ? 'has-error' : ''; ?>">
              <input type="text" name="cur_nom" class="form-control" value="<?php echo $cursusDb->cur_nom; ?>">
              <span style="color: red;" class="help-block"><?php echo $cursusDb->cur_id_msg;?></span>
              </div>
               
                <div class = "my-3">
                <input type="hidden" name="cur_id" value="<?php echo $cursusDb->cur_id; ?>"/>
                <input type="Submit" name="updateBtnCursus" class="btn btn-primary" value="Submit">
                <a href="<?php echo ROOTPAGE . "cursus";?>" class="btn btn-default">Cancel</a>
                 </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>









            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et professeur peuvent Modifier les comptes !</h2>

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