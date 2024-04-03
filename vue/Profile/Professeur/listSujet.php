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

        if ($role == "professeur") {
            ?>



            <div class="wrapper">

                <div class="container-fluid">
                <a href="<?php echo ROOTPAGE . "accueil";?>" class="btn btn-success"><i class="bi bi-arrow-left"></i> Retour</a>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-5 mb-3 d-flex justify-content-between">
                                <h2 class="pull-left">Liste de vos sujets</h2>
                                <a href="<?php echo ROOTPAGE . "professeur/addSujetForm"; ?>" class="btn btn-success"><i
                                        class="bi bi-plus"></i> Ajouter</a>
                            </div>
                            <?php
                            
                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Titre du Sujet</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['suj_id'] . "</td>";
                                    echo "<td>" . $row['suj_titre'] . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . ROOTPAGE . 'professeur/editSujet/' . $row['suj_id'] . '" class="me-3" ><span class="bi bi-pencil"></span></a>';
                                    echo '<a href="' . ROOTPAGE . 'professeur/deleteSujet/' . $row['suj_id'] . '" ><span class="bi bi-trash"></span></a>';
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








            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les professeurs peuvent consulter leurs sujets !</h2>

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