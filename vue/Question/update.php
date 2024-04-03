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

        if ($role == "administrateur" || $role == 'professeur') {
            ?>



            <?php var_dump($questionDb) ?>


            <div class="wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h2>Modifier une question</h2>


                            </div><br>
                            <form action="../update" method="POST" id="form">



                                <div class="form-group">
                                    <label>Ennoncé question :</label>
                                    <textarea name="ques_text" pattern="[A-Za-z0-9\s+-]{1,200}" class="form-control"
                                        value="<?php echo $questionDb->ques_text; ?>" required
                                        form="form"><?php echo $questionDb->ques_text; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Reponse question :</label>
                                    <input type="text" name="ques_reponse" pattern="[A-Za-z0-9\s]{0,200}"
                                        value="<?php echo $questionDb->ques_reponse; ?>" required class="form-control">
                                </div>

                                <div class="form-group">
                                    <label>Sujet :</label>
                                    <select class="form-select form-select-lg mb-3" name="sujetSelected"
                                        value="<?php echo $questionDb->pfl_id; ?>" aria-label=".form-select-lg example">
                                        <?php
                                        if ($sujet->num_rows > 0) {
                                            while ($row = mysqli_fetch_array($sujet)) {
                                                if (array_key_exists("suj_id", $row)) {
                                                    $suj_id = $row["suj_id"];
                                                } else {
                                                    $suj_id = "";
                                                }
                                                if (array_key_exists("suj_titre", $row)) {
                                                    $suj_titre = $row["suj_titre"];
                                                } else {
                                                    $suj_titre = "";
                                                }

                                                ?>
                                                <option value="<?php echo $suj_id ?>"><?php echo $suj_id ?> - <?php echo $suj_titre ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>



                                <div class="my-3">
                                    <input type="hidden" name="ques_id" value="<?php echo $questionDb->ques_id; ?>" />
                                    <input type="Submit" name="updatebtn" class="btn btn-primary" value="Submit">
                                    <a href="<?php echo ROOTPAGE . "question"; ?>" class="btn btn-default">Cancel</a>
                                </div>
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
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les profs peuvent Modifier les questions !
            </h2>

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