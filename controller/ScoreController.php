<?php 
require_once '../model/Score.php';

class ScoreController{
    private $score;

    public function __construct(){
        $this->score = new Score();
    }

    public function scoreclass () {
        return $this->score;
    }

    public function insert_score($playerName){
        $this->score->setUserId(session_id());
        $this->score->setUserName($playerName);
        $this->score->insert_score();


    }

    public function get_user_score() {
        $array = $this->score->get_all_scores();
        return $array;
    }
}
// echo 'Reached the controller';

$score_player = new ScoreController();
if(isset($_POST['username'])){
$score_player->insert_score($_POST['username']);
}


?>