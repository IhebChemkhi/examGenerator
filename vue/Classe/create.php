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

$classe = isset($_SESSION['classe']) ? unserialize($_SESSION['classe']) : new classe();


?>
<main class="col-md-9 col-lg-10 px-md-4">

    <body>
        <?php
        if ($_SESSION['isLogged'] == true) {

            ?>

            <div style="padding-top: 10;">
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
                                <h2>Inserer une classe</h2>
                            </div>
                            <form action="create" method="post">

                                <div class="form-group">
                                    <label>Classe :</label>
                                    <input type="text" name="cla_nom" class="form-control" required="required" pattern="[a-zA-Z0-9\s]+" value="<?php echo $classe->cla_nom; ?>">
                                </div>
                                

                                <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
                                <a href="<?php echo ROOTPAGE . "classe"; ?>" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br><br><br>








            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs peuvent consulter les comptes !</h2>

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