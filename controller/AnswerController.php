<?php 
require_once '../model/Answer.php';

class AnswerController {

    private $answer;


    public function __construct() {
        $this->answer= new Answer();
    }

    public function getAnswerCLASS () {
        return $this->answer;
    }
    public function answer_by_question ($id) {
        $array_4_answers = $this->answer->fetch_reponse_for_question($id);
        return $array_4_answers;
    }



}

$answer_cont = new AnswerController();
// die($_POST['dataKey']);
if (isset($_POST['dataKey'])) {
    $answers = $answer_cont->answer_by_question($_POST['dataKey']);
    // var_dump($answers);
    ?>
<?php foreach ($answers as $answer): ?>
    <label class="answer-option  flex items-center border-2 border-gray-400 rounded-lg p-3 cursor-pointer hover:bg-gray-200" 
    onclick="setdata(<?php echo $answer->getAnswerId()?>)">
    <input type="radio" name="selectedAnswer" value="<?php echo $answer->getAnswerId(); ?>" class="hidden answser1 ">
        <span class="custom-radio inline-block w-8 h-8 border-2 border-gray-500 rounded-full mr-3 relative">
            <span class="checkmark absolute inset-0 rounded-full bg-gray-500 opacity-0 flex items-center justify-center">
                <!-- SVG checkmark -->
                <svg class="w-6 h-8 text-white fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.293 10.293a1 1 0 011.414 0L11 14.586l7.293-7.293a1 1 0 111.414 1.414l-8 8a1 1 0 01-1.414 0l-8-8a1 1 0 010-1.414 1 1 0 011.414 0z"/>
                </svg>
            </span>
        </span>
        <?php echo $answer->getAnswerdesc(); ?>
    </label>
<?php endforeach; ?>

<?php } 
?>


