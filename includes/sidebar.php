<?php

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();


if (isset($_SESSION['isLogged']) && isset($_SESSION['mail'])) {
  if ($_SESSION['isLogged'] == true) {
    $mail = $_SESSION['mail'];
    $role = $_SESSION['role'];
  }
} else {
  $_SESSION['isLogged'] = false;
}

?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.108.0">
  <title>Dashboard Template · Bootstrap v5.3</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>





  <link href="/docs/5.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/5.3/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.3/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.3/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
  <link rel="icon" href="/docs/5.3/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#712cf9">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .card-img-top {
      width: 15vw;
      height: 15vw;
      object-fit: cover;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>


  <link href="checkout.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check2" viewBox="0 0 16 16">
      <path
        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
    </symbol>
    <symbol id="circle-half" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
    </symbol>
    <symbol id="moon-stars-fill" viewBox="0 0 16 16">
      <path
        d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
      <path
        d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
    </symbol>
    <symbol id="sun-fill" viewBox="0 0 16 16">
      <path
        d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
    </symbol>
  </svg>

  <!-- Custom styles for this template 
    <link href="dashboard.css" rel="stylesheet">
  </head>-->

  <body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">examgenerator</a>
      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search"
        aria-label="Search">
      <div class="navbar-nav">
        <div class="nav-item text-nowrap">
          <?php
          if ($_SESSION['isLogged'] == false) {
            ?>
            <a style="color: green;" class="nav-link px-3" href="<?php echo ROOTPAGE . "accueil/afficheLogin"; ?>">Sign
              in</a>
            <?php
          } else {
            ?>
            <a style="color: red;" class="nav-link px-3" href="<?php echo ROOTPAGE . "accueil/exit"; ?>">Sign out</a>
            <?php
          }

          ?>
        </div>
      </div>
    </header>

    <div class="container-fluid">
      <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3 sidebar-sticky">
            <ul class="nav flex-column">
              <?php
              if ($_SESSION['isLogged'] == true) {

                ?>

<a style="font-size: 25;" class="nav-link active" aria-current="page" href="<?php echo ROOTPAGE . "accueil"; ?>">
                  <span data-feather="home" class="align-text-bottom"></span>
                  <b>Home <?php 
                  if(isset($role)){
                    echo $role;
                  }
                  ?>
                  </b>
                </a>


                <?php

                if ($role == "administrateur") {
                  ?>

                  <!-- Profiles -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#ProfilesCollapse" role="button"
                    aria-expanded="false" aria-controls="ProfilesCollapse">Profiles</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="ProfilesCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "profile/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les Profiles
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "profile/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter un Profiles
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                  <!-- Matieres -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#MatieresCollapse" role="button"
                    aria-expanded="false" aria-controls="MatieresCollapse">Matières</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="MatieresCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "matiere/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les matières
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "matiere/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une matière
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                   <!-- Cursus -->
                   <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#CursusCollapse" role="button"
                    aria-expanded="false" aria-controls="CursusCollapse">Cursus</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="CursusCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "cursus/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les cursus
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "cursus/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter un cursus
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>


                  <!-- Annee scolaire -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#AnneeScolaireCollapse" role="button"
                    aria-expanded="false" aria-controls="AnneeScolaireCollapse">Annee scolaire</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="AnneeScolaireCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "anneeScolaire/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les annees scolaires
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "anneeScolaire/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une annee scolaire
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                                      <!-- Classes -->
                                      <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#ClassesCollapse" role="button"
                    aria-expanded="false" aria-controls="ClassesCollapse">Classes</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="ClassesCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "classe/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les classes
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "classe/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une classe
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>


                  <?php
                } else if ($role == "professeur") {
                  ?>


                    <!-- Gestion des examens -->
                    <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#ExamsCollapse" role="button"
                    aria-expanded="false" aria-controls="ExamsCollapse">Gestion des examens</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="ExamsCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "professeur/listSujets"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les sujets
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "professeur/addSujetForm"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter un sujet
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                  <!-- Profiles -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#ProfilesCollapse" role="button"
                    aria-expanded="false" aria-controls="ProfilesCollapse">Gestions des eleves</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="ProfilesCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "profile/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les eleves
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "profile/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter un eleve
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                  <!-- Matieres -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#MatieresCollapse" role="button"
                    aria-expanded="false" aria-controls="MatieresCollapse">Matières</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="MatieresCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "matiere/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les matières
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "matiere/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une matière
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                   <!-- Cursus -->
                   <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#CursusCollapse" role="button"
                    aria-expanded="false" aria-controls="CursusCollapse">Cursus</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="CursusCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "cursus/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les cursus
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "cursus/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter un cursus
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>


                  <!-- Annee scolaire -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#AnneeScolaireCollapse" role="button"
                    aria-expanded="false" aria-controls="AnneeScolaireCollapse">Annee scolaire</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="AnneeScolaireCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "anneeScolaire/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les annees scolaires
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "anneeScolaire/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une annee scolaire
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                                      <!-- Classes -->
                                      <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#ClassesCollapse" role="button"
                    aria-expanded="false" aria-controls="ClassesCollapse">Classes</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="ClassesCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "classe/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir les classes
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "classe/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une classe
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                  <!-- Questions -->
                  <a style="font-size: 25;" class="nav-link" data-bs-toggle="collapse" href="#QuestionsCollapse" role="button"
                    aria-expanded="false" aria-controls="QuestionsCollapse">Questions</a>
                  <div class="row">
                    <div class="col">
                      <div class="collapse multi-collapse" id="QuestionsCollapse">
                      <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "question/"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Voir mes Questions
                            </a>
                          </ul>
                          <ul>
                            <a class="nav-link" href="<?php echo ROOTPAGE . "question/insert"; ?>">
                              <span data-feather="file" class="align-text-bottom"></span>
                              Ajouter une question
                            </a>
                          </ul>
                          <br>
                      </div>
                    </div>
                  </div>

                  <?php
                } else if ($role == "eleve") {
                  ?>

                <?php }
                ?>


                <?php

              } else {

                ?>
            <a style="color: green; font-size: 25;" class="nav-link px-3" href="<?php echo ROOTPAGE . "accueil/afficheLogin"; ?>">Sign
              in</a>
            <?php

              }
              ?>
        </nav>