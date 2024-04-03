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

        if ($role == "administrateur") {
            ?>




            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2>Modifier le profile</h2>


                            </div><br>
                            <form action="../update" method="POST">

                                <div class="form-group">
                                    <label>Nom :</label>
                                    <input type="text" name="pfl_nom" class="form-control" required="required"
                                        pattern="[A-Za-z0-9]{1,20}" value="<?php echo $profileDb->pfl_nom; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Prenom :</label>
                                    <input type="text" name="pfl_prenom" class="form-control" required="required"
                                        pattern="[A-Za-z0-9]{1,20}" value="<?php echo $profileDb->pfl_prenom; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Date de naissance :</label>
                                    <input type="date" name="pfl_dateNaissance" class="form-control" required="required"
                                        value="<?php echo date("Y-m-d", strtotime($profileDb->pfl_dateNaissance)); ?>"
                                        type="date">
                                </div>
                                <div class="form-group">
                                    <label>Mail :</label>
                                    <input type="mail" name="pfl_mail" class="form-control" required="required"
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2, 4}$"
                                        value="<?php echo $profileDb->pfl_mail; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pseudo :</label>
                                    <input type="text" name="cpt_pseudo" class="form-control" required="required"
                                        pattern="[A-Za-z0-9]+" value="<?php echo $profileDb->cpt_pseudo; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Mot de passe :</label>
                                    <input type="password" name="cpt_mdp" class="form-control" required="required"
                                        pattern="[A-Za-z0-9]+">
                                </div>

                                <div class="form-group">
                                    <label>Role :</label>
                                    <select disabled class="form-select form-select-lg mb-3"
                                        name="roleSelected" aria-label=".form-select-lg example">
                                        <option selected="eleve">Changement de role impossible.</option>
                                        <option value="professeur">Professeur</option>
                                        <option value="eleve">Eleve</option>
                                    </select>
                                </div>
                                <div id="ifYes" style="display: none;">
                                    <!-- cursus -->
                                    <div class="form-group">
                                        <label>Cursus :</label>
                                        <select class="form-select form-select-lg mb-3" name="cursusSelected"
                                            aria-label=".form-select-lg example">
                                            <?php if ($cursus->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($cursus)) { ?>
                                                    <option value=<?php echo $row["cur_id"] ?>><?php echo $row["cur_nom"] ?>
                                                    </option>
                                                <?php }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- annee -->
                                    <div class="form-group">
                                        <label>Annee :</label>
                                        <select class="form-select form-select-lg mb-3" name="anneSelected"
                                            aria-label=".form-select-lg example">
                                            <?php if ($annee->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($annee)) { ?>
                                                    <option value=<?php echo $row["ann_id"] ?>><?php echo $row["ann_annee"] ?>
                                                    </option>
                                                <?php }
                                            }
                                            ?>


                                        </select>
                                    </div>

                                    <!-- classe -->
                                    <div class="form-group">
                                        <label>Classe :</label>
                                        <select class="form-select form-select-lg mb-3" name="classeSelected"
                                            aria-label=".form-select-lg example">
                                            <?php if ($class->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($class)) { ?>
                                                    <option value=<?php echo $row["cla_id"] ?>><?php echo $row["cla_nom"] ?>
                                                    </option>
                                                <?php }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" name="pfl_id" value="<?php echo $profileDb->pfl_id; ?>" />
                               
                                <input type="Submit" name="updatebtn" class="btn btn-primary" value="Submit">
                                <a href="<?php echo ROOTPAGE . "profile"; ?>" class="btn btn-default">Cancel</a>
                                <br>
                                <br>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>









            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs peuvent Modifier les comptes !</h2>

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


<script type="text/javascript">
    function yesnoCheck(that) {
        if (that.value == "eleve") {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
</script>