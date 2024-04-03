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

require_once(constant("ROOT").'/model/Question/question.php');        
$questionDb=isset($_SESSION['questionDb'])?unserialize($_SESSION['questionDb']):new question();


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
                        <h2>Ajouter une question</h2>
                                
                    </div><br>
                    <form action="create" method="POST" id="form">

                    <div class="form-group">
                    <label>Ennoncé question :</label>
                        <textarea name="ques_text" pattern="[A-Za-z0-9\s+-]{1,200}" class="form-control" required form="form"></textarea>
                    </div>

                    <div class="form-group">
                    <label>Reponse question :</label>
              <input type="text" name="ques_reponse" pattern="[A-Za-z0-9\s]{0,200}" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sujet :</label>
                         <select class="form-select form-select-lg mb-3" name="sujetSelected" aria-label=".form-select-lg example">
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



               <div class = "my-3">         
                 <input type="hidden" name="ques_id" value="<?php echo $questionDb->ques_id; ?>"/>
                <input type="Submit" name="addbtn" class="btn btn-primary" value="Submit">
                <a href="<?php echo ROOTPAGE . "question";?>" class="btn btn-default">Cancel</a>
                </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>

            <?php
        } else {
            ?>
            <h2 style="color: red;" class="pull-left">Seul les administrateurs et les profs peuvent ajouter !</h2>

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

