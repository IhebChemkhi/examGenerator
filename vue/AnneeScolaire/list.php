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

        if ($role == "administrateur" || $role == "professeur") {
            ?>



            <div class="wrapper">

                <div class="container-fluid">
                <a href="<?php echo ROOTPAGE . "accueil";?>" class="btn btn-success"><i class="bi bi-arrow-left"></i> Retour</a>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-5 mb-3 d-flex justify-content-between">
                                <h2 class="pull-left">Liste des annees scolaires</h2>
                                <?php if ($role == "administrateur"){  ?>

                                <a href="<?php echo ROOTPAGE . "anneeScolaire/insert"; ?>" class="btn btn-success"><i
                                        class="bi bi-plus"></i> Ajouter</a>
                                <?php }?>
                            </div>
                            <?php
                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Annee scolaire</th>";
                                echo "<th>Actions</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ann_id'] . "</td>";
                                    echo "<td>" . $row['ann_annee'] . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . ROOTPAGE . 'anneeScolaire/read/' . $row['ann_id'] . '" class="me-3" ><span class="bi bi-eye"></span></a>';
                                    if ($role == "administrateur"){ 

                                    echo '<a href="' . ROOTPAGE . 'anneeScolaire/edit/' . $row['ann_id'] . '" class="me-3" ><span class="bi bi-pencil"></span></a>';
                                    //echo '<a style="cursor:help" href="#" ><span class="bi bi-trash"></span></a>';
                                    // DELETE MARCHE PAS SI ANNEE SCOLAIRE LIE A UN ETUDIANT !!!!!!!§§§§§§§
                                    echo '<a href="' . ROOTPAGE . 'anneeScolaire/delete/' . $row['ann_id'] . '" ><span class="bi bi-trash"></span></a>';
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                /* Free result set */
                                mysqli_free_result($result);
                            } else {
                                echo '<div class="alert alert-danger"><em>Pas d\'enregistrement</em></div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <br><br><br><br><br><br>





            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les professeurs peuvent consulter les annees scolaires !</h2>

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