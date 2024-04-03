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

$profileDb = isset($_SESSION['profileDb']) ? unserialize($_SESSION['profileDb']) : new profile();


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

        if ($role == "professeur") {
            ?>

            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2>Inserer vos questions</h2>
                            </div>
                            <form action="addSujet" method="post">

                                <div class="form-group">
                                    <label>Titre Du Sujet :</label>
                                    <input type="text" name="suj_titre" class="form-control" required="required"
                                         value="">
                                </div>                                
                                <div class="form-group">
                                    <label>Matiere concernée</label>
                                    <select class="form-select form-select-lg mb-3"
                                        name="matiereSelected" aria-label=".form-select-lg example">
                                        <?php 

                                        if ($result->num_rows > 0) {
                                              while ($row = mysqli_fetch_array($result)) { 
                                            if (array_key_exists("mat_id", $row)) {
                                             $mat_id = $row["mat_id"];
                                             } else {
                                            $mat_id = "";
                                                }
                                            if (array_key_exists("mat_nom", $row)) {
                                        $mat_nom = $row["mat_nom"];
                                        } else {
                                        $mat_nom = "";
                                        }

                                        ?>

                                        <option value="<?php echo $mat_id ?>"><?php echo $mat_id ?> - <?php echo $mat_nom ?></option>
                                        <?php 
                                        }
                                    }
                                    ?>


                                        <!--if ($result->num_rows > 0) {
                                                while ($row = mysqli_fetch_array($result)) { ?>
                                                    <option value=</?php echo $row["mat_id"] ?>></?php echo $row["mat_nom"] ?></option>
                                                </?php }
                                            }
                                            ?>-->
                                       
                                    </select>
                                </div>




                                <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
                                <a href="<?php echo ROOTPAGE . "professeur/listSujets"; ?>" class="btn btn-default">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br><br><br><br><br>








            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les professeur peuvent consulter les Sujets !</h2>

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