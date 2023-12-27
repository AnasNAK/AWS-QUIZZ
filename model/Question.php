<?php 

require_once 'Database.php';
class Question {

private $db ;

private $question_id;

private $question_desc;

private $question_explic;

private $question_theme;

private $answer_correct;

public function __construct(){

    $this->db = Database::getconnection();
}

public function setQuestionId($question_id) {
    $this->question_id = $question_id;
}

public function setQuestionDesc($question_desc) {
    $this->question_desc = $question_desc;
}

public function setQuestionExplic($question_explic) {
    $this->question_explic = $question_explic;
}

public function setQuestionTheme($question_theme) {
    $this->question_theme = $question_theme;
}

public function setAnswerCorrect($answer_correct) {
    $this->answer_correct = $answer_correct;
}



public function getQuestionId() {
    return $this->question_id;
}

public function getQuestionDesc() {
    return $this->question_desc;
}

public function getQuestionExplic() {
    return $this->question_explic;
}

public function getQuestionTheme() {
    return $this->question_theme;
}

public function getAnswerCorrect() {
    return $this->answer_correct;
}


public function set_correction_by_question_id () {
    $fetch = $this->db->prepare("SELECT * FROM question WHERE id = :questionid");
    $fetch->bindValue(':questionid' , $this->getQuestionId() , PDO::PARAM_INT);
    $fetch->execute();
    $result = $fetch->fetch(PDO::FETCH_ASSOC);
    $this->setAnswerCorrect($result['correct_answer']);
}

public function get_random_questions(){

    $query = $this->db->query('select * from question join sous_theme on sous_theme.id = question.theme_id');
    $result  = $query->fetchAll(PDO::FETCH_ASSOC);

    shuffle($result);
   return $result ;
}


}






?>