<?php
class profile
{
    // table fields
    public $pfl_id;
    public $pfl_nom;
    public $pfl_prenom;
    public $pfl_dateNaissance;
    public $pfl_mail;
    public $cpt_pseudo;

    // constructor set default value
    function __construct()
    {
        $pfl_id = 0;
        $pfl_nom = "";
        $pfl_prenom = "";
        $pfl_dateNaissance = "";
        $pfl_mail = "";
        $cpt_pseudo = "";
    }
}
?>