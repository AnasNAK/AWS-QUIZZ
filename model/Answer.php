<?php 
require_once 'Database.php';


class Answer {

    private $db;

    private $Answer_id;
    private $Answer_text;
    private $Answer_points;
    private $Question_id;

    public function __construct() {
        $this->db = Database::getconnection();
    }

    // Setters
    public function setAnswerId($id) {
        $this->Answer_id = $id;
    }

    public function setAnswerdesc($text) {
        $this->Answer_text = $text;
    }

    public function setAnswerPoints($points) {
        $this->Answer_points = $points;
    }


    public function setQuestionID ($questionID) {
        $this->Question_id = $questionID;
    }

    // Getters
    public function getAnswerId() {
        return $this->Answer_id;
    }

    public function getAnswerdesc() {
        return $this->Answer_text;
    }

    public function getAnswerPoints() {
        return $this->Answer_points;
    }


    public function getQuestionID () {
        return $this->Question_id;
    }
    public function set_response_for_question() {
        $fetch = $this->db->prepare("SELECT response_desc FROM response WHERE id_question = :Q_id LIMIT 1");
        $fetch->bindValue(':Q_id', $this->getQuestionID(), PDO::PARAM_INT);
        $fetch->execute();
        $result = $fetch->fetch(PDO::FETCH_ASSOC);
        $this->setAnswerdesc($result['response_desc']);
    }


    public function fetch_reponse_for_question ($question_id) {
        $fetch = $this->db->prepare("SELECT * FROM response WHERE id_question = :Q_id");
        $fetch->bindValue(':Q_id' , $question_id,PDO::PARAM_INT);
        $fetch->execute();
        $result = $fetch->fetchAll(PDO::FETCH_ASSOC);
        $answers = [];
        foreach($result as $reponse) {
            $answer = new Answer();
            $answer->setAnswerId($reponse['id']);
            $answer->setAnswerdesc($reponse['response_desc']);
            $answer->setQuestionID($reponse['id_question']);
            $answers [] = $answer;
        }
        return $answers;

    }

}





?>