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
<main class="col-md-9 col-lg-10 px-md-4"><!--
  <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Accueil</h1>
  </div>-->

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

      <div style="padding-top: 100;">
        <h2 style="color: red;" class="pull-left">Bonjour, Vous n'etes pas connecté. Pour acceder aux pages veuilez vous
          connecter.</h2>
      </div><br><br>

      <?php

    }
    ?>

    <?php

    if ($role == "administrateur") {
      ?>

      <div class="container text-center">
        <div class="row">

          <div class="col">

            <div class="card" style="width: 18rem;">
              <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "profile"; ?>">
                <img
                  src="https://img.freepik.com/vecteurs-premium/ensemble-vecteurs-signes-enfants-nationalite-differente-dans-style-plat-mode-icones-applications-visages-portraits-filles-garcons-pour-web-avatars-enfants-eleves-collection-images-etudiants_258190-530.jpg?w=2000"
                  class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <p class="card-text">Voir les profiles</p>
              </div>
            </div>

          </div>

          <div class="col">

            <div class="card" style="width: 18rem;">
              <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "matiere"; ?>">
                <img
                  src="https://edukiya.com/wp-content/uploads/2020/07/article-orientation-scolaire-afrique-mati%C3%A8res-classe-personnalit%C3%A9-1024x536.jpg"
                  class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <p class="card-text">Voir les matieres</p>
              </div>
            </div>



          </div>

          <div class="col">

            <div class="card" style="width: 18rem;">
              <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "cursus"; ?>">
                <img src="https://www.unicaen.fr/wp-content/uploads/2021/02/2021-02-24_Schema_des_etudes.jpg"
                  class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <p class="card-text">Voir les cursus</p>
              </div>
            </div>

          </div>

          <div class="col">

            <div class="card" style="width: 18rem;">
              <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "anneeScolaire"; ?>">
                <img src="https://demarchesadministratives.fr/images/actualites/5039/vacances-scolaires-2022.jpg"
                  class="card-img-top" alt="...">
              </a>
              <div class="card-body">
                <p class="card-text">Voir les annees scolaires</p>
              </div>
            </div>

          </div>

        </div>
        <br>
        <div class="row">
          <div class="col">
            <div class="card" style="width: 18rem;">
              <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "classe"; ?>">
                <img src="https://www.foucarmont.com/wp-content/uploads/2018/08/Nouvelle-classe.jpg" class="card-img-top"
                  alt="...">
              </a>
              <div class="card-body">
                <p class="card-text">Voir les classes</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <?php
    } else if ($role == "professeur") {
      ?>

        <div class="container text-center">
          <div class="row">

            <div class="col">

              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "profile"; ?>">
                  <img
                    src="https://img.freepik.com/vecteurs-premium/ensemble-vecteurs-signes-enfants-nationalite-differente-dans-style-plat-mode-icones-applications-visages-portraits-filles-garcons-pour-web-avatars-enfants-eleves-collection-images-etudiants_258190-530.jpg?w=2000"
                    class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Voir les eleves</p>
                </div>
              </div>

            </div>

            <div class="col">

              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "professeur/list"; ?>">
                  <img
                    src="https://edukiya.com/wp-content/uploads/2020/07/article-orientation-scolaire-afrique-mati%C3%A8res-classe-personnalit%C3%A9-1024x536.jpg"
                    class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Voir les matieres</p>
                </div>
              </div>

            </div>

            <div class="col">

              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "question"; ?>">
                  <img src="https://i.la-croix.com/1400x933/smart/2020/01/15/1201071898/questions-reponses_0.jpg"
                    class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Voir les questions</p>
                </div>
              </div>

            </div>

            <div class="col">

              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "anneeScolaire"; ?>">
                  <img src="https://demarchesadministratives.fr/images/actualites/5039/vacances-scolaires-2022.jpg"
                    class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Voir les annees scolaires</p>
                </div>
              </div>

            </div>

          </div>
          <br>
          <div class="row">
            <div class="col">
              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "classe"; ?>">
                  <img src="https://www.foucarmont.com/wp-content/uploads/2018/08/Nouvelle-classe.jpg" class="card-img-top"
                    alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Voir les classes</p>
                </div>
              </div>
            </div>





            <div class="col">
              <div class="card" style="width: 18rem;">
                <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "professeur/listSujets"; ?>">
                  <img
                    src="https://st4.depositphotos.com/1112664/28107/i/450/depositphotos_281074218-stock-photo-test-answer-sheet-with-pencil.jpg"
                    class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                  <p class="card-text">Sujets</p>
                </div>
              </div>
            </div>


            <div class="col">
                <div class="card" style="width: 18rem;">
                  <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "passageExamen/list"; ?>">
                    <img src="https://blogs.ibo.org/files/2019/11/Second-Image-1200x800.jpg" class="card-img-top" alt="...">
                  </a>
                  <div class="card-body">
                    <p class="card-text">Voir les examens</p>
                  </div>
                </div>
              </div>



            <div class="col">
              <!-- contenu card ici -->
            </div>

          </div>
        </div>

      <?php
    } else if ($role == "etudiant") {
      ?>

          <div class="container text-center">
            <div class="row">
              <div class="col">
                <div class="card" style="width: 18rem;">
                  <a style="text-decoration: none;" href="<?php echo ROOTPAGE . "passageExamen/list"; ?>">
                    <img src="https://blogs.ibo.org/files/2019/11/Second-Image-1200x800.jpg" class="card-img-top" alt="...">
                  </a>
                  <div class="card-body">
                    <p class="card-text">Passage examens</p>
                  </div>
                </div>
              </div>
              <div class="col">
                
              </div>
              <div class="col">
                
              </div>
            </div>
          </div>
    <?php }
    ?>

    <br><br><br><br><br><br><br>
  </body>
  </table>
  </div>
</main>
</div>
</div>

<?php include("./includes/footer.php"); ?>