<?php

class passageExamenModel
{

    function __construct($consetup)
    {
        $this->host = $consetup->host;
        $this->user = $consetup->user;
        $this->pass = $consetup->pass;
        $this->db = $consetup->db;
    }
    // open mysql data base
    public function open_db()
    {
        $this->condb = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->condb->connect_error) {
            die("Erron in connection: " . $this->condb->connect_error);
        }
    }
    // close database
    public function close_db()
    {
        $this->condb->close();
    }


    public function selectExamensParProfs($mail)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM `t_examen_exam` JOIN t_matiere_mat using (mat_id) JOIN t_professeur_prof using (pfl_id) JOIN t_profile_pfl using (pfl_id) WHERE pfl_mail = ?;");
            $query->bind_param("s", $mail);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }


    public function selectSujetsParMatiereParProf($id)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM t_sujets_suj JOIN tj_examsujets USING(suj_id) JOIN t_examen_exam USING (exam_id) JOIN t_matiere_mat USING (mat_id) WHERE mat_id=?;");
            $query->bind_param("i", $id);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }


    public function selectMatieresParProf($mail)
    {
        try {
            $this->open_db();
            $query = $this->condb->prepare("SELECT * FROM t_matiere_mat JOIN t_professeur_prof using (pfl_id) JOIN t_profile_pfl using (pfl_id) WHERE pfl_mail = ?;");
            $query->bind_param("s", $mail);
            $query->execute();
            $res = $query->get_result();
            $query->close();
            $this->close_db();
            return $res;
        } catch (Exception $e) {
            $this->close_db();
            throw $e;
        }
    }

    public function selectQuestionAleatoires($ids)
    {
        $tabRes = [];

        //10 questions
        for ($i = 0; $i < 10; $i++) {

            $randomSujet = rand(1, sizeof($ids));


            try {
                $this->open_db();

                $query = $this->condb->prepare("SELECT * FROM t_question_ques JOIN t_sujets_suj USING(suj_id) WHERE suj_id = ? ORDER BY RAND() LIMIT 1");
                $query->bind_param("i", $randomSujet);
                $query->execute();
                $res = $query->get_result();
                $query->close();
                $this->close_db();

                array_push($tabRes, mysqli_fetch_array($res));



            } catch (Exception $e) {
                $this->close_db();
                throw $e;
            }

        }

        return $tabRes;
    }


    public function ajoutExamAvecNotes($notes, $matiere, $exam_titre)
    {
        $res="";

        //var_dump($notes);

        foreach ($notes as $value) {
            $laQuestion = (int)$value[0];
            $laNote = (double)$value[1];

            try {
                $this->open_db();

                $query = $this->condb->prepare("UPDATE `t_question_ques` SET `ques_point` = ? WHERE `t_question_ques`.`ques_id` = ?");
                $query->bind_param("di", $laNote, $laQuestion);

                $query->execute();
                //var_dump($query);

                $res = $query->get_result();
                //var_dump($res);

                $query->close();
                $this->close_db();

            } catch (Exception $e) {
                $this->close_db();
                throw $e;
            }


            try {
                $this->open_db();

                $query = $this->condb->prepare("INSERT INTO `t_examen_exam` (`exam_titre`, `mat_id`) VALUES (?, ?)");
                $query->bind_param("di", $laNote, $laQuestion);

                $query->execute();
                //var_dump($query);

                $res = $query->get_result();
                //var_dump($res);

                $query->close();
                $this->close_db();

            } catch (Exception $e) {
                $this->close_db();
                throw $e;
            }


        }
    
        return $res;

    }
}