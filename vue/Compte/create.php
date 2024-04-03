<?php
    require_once(constant("ROOT").'/model/Profile/profile.php');        
    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();             
    $compteDb=isset($_SESSION['compteDb'])?unserialize($_SESSION['compteDb']):new compte();            
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Ajout compte</h2>
                    </div>
                    <form action="../index.php?act=add" method="post">
                        <div class="form-group <?php echo (!empty($compteDb->cpt_pseudo)) ? 'has-error' : ''; ?>">
                            <label>compte pseudo</label>
                            <input type="text" name="pseudo" class="form-control" value="<?php echo $compteDb->cpt_pseudo; ?>">
                            <span class="help-block"><?php echo $compteDb->cpt_pseudo;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($compteDb->cpt_mdp)) ? 'has-error' : ''; ?>">
                            <label>Compte mdp</label>
                            <input type="text" name="mdp" class="form-control" value="<?php echo $compteDb->cpt_mdp; ?>">
                            <span class="help-block"><?php echo $compteDb->cpt_mdp;?></span>
                        </div>
                        <input type="submit" name="addbtn" class="btn btn-primary" value="Submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>