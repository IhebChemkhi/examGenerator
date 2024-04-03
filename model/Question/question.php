<?php
class question
{
    // table fields
    public $ques_id;
    public $ques_text;
    public $ques_reponse;
    public $suj_id;
    // constructor set default value
    function __construct()
    {
        $ques_id = 0;
        $ques_text ="";
        $ques_reponse ="";
        $ques_point = 0;
        $suj_id = 0;
    }
}
?>