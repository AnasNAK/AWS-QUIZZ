<?php
require '../controller/QuestionController.php';
require '../controller/ScoreController.php';

if(isset($_SESSION['score'])) {
   
    if(isset($_SESSION['WRONGQUESTIONSID'])) {
        $wronganswer = count($_SESSION['WRONGQUESTIONSID']);
    }
    else {
        $wronganswer = 0;
    }

    $scoreclass = $score_player->scoreclass();
    $scoreclass->last_id_insert_score ();

    $totalcorrect = 10 - count($_SESSION['WRONGQUESTIONSID']);

    $percentage =($totalcorrect/10) * 100;

    if($percentage >= 70) {
        ?>
  <div class="flex flex-col items-center">
    <h1 class="text-4xl font-bold"><?php echo $percentage."%" ?></h1>
    <h3 class="text-2xl mt-4">Congratulations, <?php echo $_SESSION['name'] ?></h3>
    <p class="text-lg mt-2">You have successfully completed the quiz!</p>
</div>
        <?php
    }
    else {
            ?>
       <div class="flex flex-col items-center">
    <h1 class="text-4xl font-bold"><?php echo $percentage."%" ?></h1>
    <h3 class="text-2xl mt-4">Sorry, <?php echo $_SESSION['name'] ?>!</h3>
    <h4 class="text-lg mt-2">Better luck next time</h4>
</div>
            <?php
    }

    ?>
    <div class="flex">
    <img src="./IMGS/PLAY.png" class="PLAY" style="width:6.4rem" onclick="load ()" type="submit" alt="">
    <img type="submit" src="./IMGS/SCOREBOARD.png" class="scoreboard" onclick="scoreboard ()" style="width:10rem"
        alt="">
    <img src="./IMGS/CORRECTION.png" class="correction" onclick="correction()" style="width:10rem" alt="">
</div>
    <?php

}