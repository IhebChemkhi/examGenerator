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

        if ($role == "professeur" || $role == "professeur") {
            ?>


            <div class="wrapper">

                <div class="container-fluid">
                    <a href="<?php echo ROOTPAGE . "accueil"; ?>" class="btn btn-success"><i class="bi bi-arrow-left"></i>
                        Retour</a>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-5 mb-3 d-flex justify-content-between">
                                <h2 class="pull-left">Details profil de la question n°
                                    <?php echo $questionDb->ques_id ?>
                                </h2>
                            </div>
                            <?php
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Ennoncé question</th>";
                            echo "<th>Reponse question</th>";
                            echo "<th>lié au profile</th>";
                            echo "<th>Actions</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            echo "<tr>";
                            echo "<td>" . $row['ques_id'] . "</td>";
                            echo "<td>" . $row['ques_text'] . "</td>";
                            echo "<td>" . $row['ques_reponse'] . "</td>";
                            echo "<td>" . $row['suj_id'] . "</td>";
                            echo "<td>";
                            echo '<a href="' . ROOTPAGE . 'question/edit/' . $row['ques_id'] . '" class="me-3" ><span class="bi bi-pencil"></span></a>';
                            echo '<a href="' . ROOTPAGE . 'question/delete/' . $questionDb->ques_id . '" ><span class="bi bi-trash"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                            echo "</tbody>";
                            echo "</table>";
                            /* Free result set */

                            ?>
                        </div>
                    </div>
                </div>








            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les professeurs peuvent consulter leurs questions !</h2>

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