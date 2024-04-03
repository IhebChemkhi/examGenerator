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
                    <a href="<?php echo ROOTPAGE . "accueil"; ?>" class="btn btn-success"><i class="bi bi-arrow-left"></i>
                        Retour</a><br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mt-5 mb-3 d-flex justify-content-between">
                                <h2 class="pull-left">Liste des profiles</h2>
                                <?php if ($role == "administrateur"){ ?>

                                <div>
                                    <form method="post" action="importCSV" enctype="multipart/form-data">
                                        <input type="file" name="csv_file" required>
                                        <br><button name="import" class="btn btn-primary" type="submit">Importer
                                            CSV</button><br>
                                    </form>
                                </div>

                                <a href="<?php echo ROOTPAGE . "profile/insert"; ?>" class="btn btn-success"><i
                                        class="bi bi-plus"></i> Ajouter</a>

<?php } ?>
                                <!--<input type="submit" name="importCSV" class="btn btn-primary" value="Import CSV">-->
                            </div>



                            <?php
                            if ($result->num_rows > 0) {
                                echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>#</th>";
                                echo "<th>Pseudo</th>";
                                echo "<th>Mail</th>";
                                echo "<th>Nom</th>";
                                echo "<th>Prenom</th>";
                                echo "<th>Date de naissance</th>";
                                echo "<th>Actions</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['pfl_id'] . "</td>";
                                    echo "<td>" . $row['cpt_pseudo'] . "</td>";
                                    echo "<td>" . $row['pfl_mail'] . "</td>";
                                    echo "<td>" . $row['pfl_nom'] . "</td>";
                                    echo "<td>" . $row['pfl_prenom'] . "</td>";
                                    echo "<td>" . $row['pfl_dateNaissance'] . "</td>";
                                    echo "<td>";
                                    echo '<a href="' . ROOTPAGE . 'profile/read/' . $row['pfl_id'] . '" class="me-3" ><span class="bi bi-eye"></span></a>';
                                    if ($role == "administrateur"){

                                    echo '<a href="' . ROOTPAGE . 'profile/edit/' . $row['pfl_id'] . '" class="me-3" ><span class="bi bi-pencil"></span></a>';
                                    echo '<a href="' . ROOTPAGE . 'profile/delete/' . $row['cpt_id'] . '" ><span class="bi bi-trash"></span></a>';
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
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les professeur peuvent consulter les
                comptes !</h2>

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