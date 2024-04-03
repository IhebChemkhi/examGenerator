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
                        <h2>Ajouter un cursus</h2>
                        
                                
                    </div><br>
                    <form action="create" method="post">
                             <div class="col-sm-6 mb-3">
                            <label for="cursus" class="form-label">Nom du cursus</label>
                             <input type="text" class="form-control" name="cur_nom" id="nomCursus" placeholder="" value="<?php echo $cursusDb->cur_nom; ?>" required>
                             <div class="invalid-feedback">
                               Valid last name is required.
                            </div>
                            </div>
                            <!--<div class="col-5 mb-3">
                                <label for="professeur" class="form-label">Nom du professeur référent</label>
                                <select class="form-select" id="professeur" required>
                                    <//?/php
                                    //if ($result->num_rows > 0) {
                                      //  while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                <option value="<//?php echo $row['pfl_id'];?>"><//?php echo $row['pfl_nom'];?></option>
                                <//?php } ?>
                                </select>
                                <div class="invalid-feedback">
                                Choississez un professeur référent s'il vous plait.
                                </div>
                            </div>-->

                            <div class ="my-3">
                         <input type="hidden" name="cur_id" value="<?php echo $cursusDb->cur_id; ?>"/>
                         <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
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
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les professeur peuvent ajouter des cursus !</h2>

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

