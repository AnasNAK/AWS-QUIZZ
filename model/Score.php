<?php 
require_once "Database.php";

class Score {

    private $db;
    private $user_id;
    private $user_name;
    private $user_score;

    public function __construct() {
        $this->db = Database::getconnection();
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setUserName($user_name) {
        $this->user_name = $user_name;
    }

    public function setUserScore($user_score) {
        $this->user_score = $user_score;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getUserName() {
        return $this->user_name;
    }
    public function getUserScore() {
        return $this->user_score;
    }

    public function insert_score () {
        $query = $this->db->prepare("INSERT INTO score (user_id,username) VALUES (:userid,:username)");
        $query->bindValue(':userid' , $this->getUserId() , PDO::PARAM_STR);
        $query->bindValue(':username' , $this->getUserName() , PDO::PARAM_STR);
        $query->execute();

        $_SESSION['iduser'] = $this->db->lastInsertId();
    }

    public function get_all_scores(){
        $iduser = $this->getUserId();
        $query = $this->db->prepare('SELECT * FROM score WHERE user_id = :id');
        $query->bindParam(':id' , $iduser , PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $array = [];
        foreach ($result as $row)
        {
            $score = new Score();
            $score->setUserId($row['user_id']);
            $score->setUserName($row['user_name']);
            $score->setUserScore($row['user_score']);
            $array [] = $score;

        }        
        // var_dump($array);
        return $array;
    }
 
    public function last_id_insert_score () {
        $lastid = $_SESSION['iduser'];
        $update = $this->db->prepare("UPDATE score SET score = :score WHERE iD = :id AND username = :name");
        $update->bindValue(':score' , $_SESSION['score'] , PDO::PARAM_INT);
        $update->bindValue(':id' , $lastid , PDO::PARAM_STR);
        $update->bindValue(':name' , $_SESSION['name'] , PDO::PARAM_STR);
        $update->execute();
    }
    
}






?>