<?php
require_once '../model/Question.php';
require_once '../model/Answer.php';

class Questionontroller {

    private $question;
    private $answer;
    private $randomQuestions;
    private $questions = [];


    public function __construct() {
        $this->question = new Question();
        $this->answer = new Answer();

        if (!isset($_SESSION['question_id'])) {
            $_SESSION['question_id'] = 1;
            $_SESSION['score'] = 0;
        }
    }


    public function getquestions () {
        return $this->questions;
    }
  
    public function get_question_count() {
        return count($this->questions);
    }

    public function get_index() {
        return $_SESSION['question_id'];
    }

    public function getQuestionclass () {
        return $this->question;
    }
    public function get_question_index($index) {
        if ($index >= 0 && $index < count($this->questions)) {
            return $this->questions[$index];
        }
        return null; 
    }
    public function setArrayQuestion($ArrayQuestion) {
        $this->questions = $ArrayQuestion;
    }

    public function fetch_random_questions() {
        $randomQuestions = $this->question->get_random_questions();
        if ($randomQuestions) {
            $this->questions = $randomQuestions;
        }
    }

    public function get_next_question() {
        $index = $_SESSION['question_id'];
        $_SESSION['question_id']++;
        if ($index < count($this->questions)) {
            
            return $this->get_question_index($index);
        }
        return null; 
    }

}



if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['fetching'])){

    $question_cont = new Questionontroller();


    $question_cont->fetch_random_questions();
    
    $questions = $question_cont->getquestions();
    
    echo json_encode($questions);
    
    $_SESSION['score'] = 0;
    
}
// die('you  are here ');
// echo"we are here ";

if (isset($_POST['useranswer']) && isset($_POST['question'])) {
    $questionID = $_POST['question'];
    $answerid = $_POST['useranswer'];

    $helpers = array("WAY TO GO!", "KEEP PUSHING FORWARD!", "YOU'RE MAKING PROGRESS!", "ALMOST THERE, KEEP IT UP!");

    if ($answerid === '') {
        $htmlResponse = "<div class=\"font-bold text-xl\">Please Don't Be Late</div>";
        $score = $_SESSION['score'] ?? 0; 
        $response = array('htmlResponse' => $htmlResponse, 'score' => $score);

        $_SESSION['WRONGQUESTIONSID'][$questionID] = '';
        echo json_encode($response);
    } else {
        $question = new Question();
        $question->setQuestionId($questionID);
        $question->set_correction_by_question_id();
        $questioncorrect = $question->getAnswerCorrect(); 


        $answer = new Answer();
        $answer->setQuestionID($questionID);
        $answer->set_response_for_question();
        $reponsetext = $answer->getAnswerdesc(); 

        if ($answerid == $questioncorrect) {
            $htmlResponse = "<div id=\"correct\" class=\"d-flex flex-column justify-content-center align-items-center\">" .
                "<h1>CORRECT SIR <span>+20</span></h1>" .
                "<h1>" . $helpers[array_rand($helpers)] . "</h1>" .
                "</div>";

            $_SESSION['score'] = ($_SESSION['score'] ?? 0) + 20; // Ensure the score is properly incremented
            $score = $_SESSION['score'];
            $response = array('htmlResponse' => $htmlResponse, 'score' => $score);
            echo json_encode($response);
        } else {
            $htmlResponse = "<h1>INCORRECT</h1><br>" .
                "<h2>Question ID: " . $questionID . "<br></h2>" .
                "<h2>CORRECT: " . $questioncorrect . "<br></h2>" .
                "<h2>USER_ANSWER: " . $answerid . "<br></h2>" .
                "<h2>Response: Your answer is incorrect.<br></h2>";
            $score = $_SESSION['score'] ?? 0;
            $response = array('htmlResponse' => $htmlResponse, 'score' => $score);
            $_SESSION['WRONGQUESTIONSID'][$questionID] = $answerid;
            echo json_encode($response);
        }
    }
}
?>