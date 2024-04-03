<?php
class compte
{
    // table fields
    public $cpt_pseudo;

    public $cpt_mdp;

    // constructor set default value
    function __construct()
    {
        $cpt_pseudo = "";
        $cpt_mdp = "";
    }
}
?>