// //////////////////////////////////// regex /////////////////////////////////////
function validateUsername() {
    const usernameInput = document.getElementById('username');
    const usernameRegex = /^[A-Za-z]{4,}$/;
    const usernameValid = usernameRegex.test(usernameInput.value);

    if (!usernameValid) {
        document.getElementById('username-error').textContent = 'Invalid username';
    } else {
        document.getElementById('username-error').textContent = '';
    }

    return usernameValid;
}

function sendDataToController(username) {

    $.ajax({
        type: 'POST',
        url: 'http://localhost/AWS-QUIZZ/controller/ScoreController.php',
        data: { username: username },
        success: function (response) {
            console.log('Data sent successfully!');
        },
        error: function (err) {
            console.error('Error sending data:', err);
        }
    });
}

const submitButton = document.getElementById('submitbutton');
submitButton.addEventListener('click', function () {
    const isValid = validateUsername();
    if (isValid) {
        const username = document.getElementById('username').value;
        sendDataToController(username);
        startCountdown();
    }
});
// var container = document.querySelector('.main');

var scorediv = document.querySelector('#score');
let score = 0;
var questionOBJECT = [];
function fetch_questions() {
    $.ajax({
        url: 'http://localhost/AWS-QUIZZ/controller/QuestionController.php',
        type: 'GET',
        dataType: 'json',
        data: {
            fetching: true
        },
        success: function (response) {
            questionOBJECT = response;
            let i = 0;
            console.log(questionOBJECT);
            console.log(questionOBJECT[i].id);
            document.body.innerHTML = '';
            const Container = document.createElement('div');
            Container.classList.add('main');

            Container.innerHTML = `
            <div id="content" class="flex gap-9 flex-col justify-evenly items-center w-[95%] md:w-3/4 h-full mx-auto">
            <h2 id="score" class="score position-absolute">score : 0</h2>
            <div id="page" class="page position-absolute">1/10</div>

            <div class="counter-container">
            <svg class="counter-svg" width="100" height="100">
                <circle class="counter-circle" cx="50" cy="50" r="40" stroke-width="8" fill="transparent" />
                <text class="counter-text" x="50%" y="50%" text-anchor="middle" dy="7px"></text>
            </svg>
        </div>
        
            <div class="question w-full p-2 border-2 border-gray-400 rounded-xl shadow-xl" data-key="${questionOBJECT[i].id}">
                <p>${questionOBJECT[i].question_desc}</p>
            </div>
            <div class="answers grid grid-cols-2 gap-4 md:gap-8 w-full child:p-2 child:border child:border-gray-400 child:shadow-lg child:rounded-lg">
              
            </div>
            <div class="self-end">
                <button id="NEXT" class="p-1 px-4 bg-[#ff9900] border border-black rounded-xl" onclick="answerid()">Next</button>
            </div>
        </div>
        
        `;
            document.body.appendChild(Container);
            var scorediv = document.querySelector('#score');
            scorediv.textContent = 'score : ' + score;

            timer();
            // progressbar(i);

            sendDataKey();
        },
        error: function (xhr, status, error) {
            console.error('Error fetching questions:', error);
        }
    });
}





/////////////////////////////////////////////////////////////////////////////

function timer() {
    var counter = 15; // Set your countdown value
    var counterText = document.querySelector('.counter-text');
    var counterCircle = document.querySelector('.counter-circle');

    var circumference = parseFloat(counterCircle.getAttribute('r')) * 2 * Math.PI;

    var counterInterval = setInterval(function () {
        counter--;
        counterText.textContent = counter;
        var progress = circumference * (counter / 15);
        counterCircle.style.strokeDashoffset = progress;

        if (counter <= 0) {
            clearInterval(counterInterval);
            answerid();
        }
    }, 1000);
}










function startCountdown() {
    // Remove existing content
    document.body.innerHTML = '';

    // Create a container for the timer
    const timerContainer = document.createElement('div');
    timerContainer.classList.add('timer-container');

    // Add the timer HTML to the container
    timerContainer.innerHTML = `
        <div class="countdown-container">
            <div class="circle-container">
                <svg class="countdown-svg">
                    <circle class="countdown-circle" cx="50%" cy="50%" r="40%" stroke="#333" stroke-width="8" fill="transparent" />
                </svg>
                <div id="countdown" class="countdown-text">5</div>
            </div>
        </div>
    `;

    // Append the timer container to the body
    document.body.appendChild(timerContainer);

    // Timer logic
    let count = 5;
    const countdown = document.getElementById('countdown');
    const circle = document.querySelector('.countdown-circle');

    const timer = setInterval(() => {
        count--;
        countdown.textContent = count;
        circle.style.strokeDashoffset = ((count / 5) * 251.2);

        if (count === 0) {
            clearInterval(timer);
            fetch_questions();
        }
    }, 1000);
}



function sendDataKey() {
    var questionElement = $('.question');
    var reponseElement = $('.answers');

    if (questionElement.length > 0) {
        var dataKey = questionElement.attr('data-key');
        // console.log(dataKey);

        $.ajax({
            url: 'http://localhost/AWS-QUIZZ/controller/AnswerController.php',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: {
                dataKey: encodeURIComponent(dataKey)
            },
            success: function (response) {
                reponseElement.html(response);

            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    } else {
        console.error("Element with class '.question' not found.");
    }
}


var id = '';

var answers = document.querySelectorAll('.answser1');
var N = document.querySelector('.next');




function setdata(idd) {
    id = idd;
    console.log(id);
}

function answerid() {
    // let nextButton = $('.NEXT');
    let question = $('.question');
    let idquestion = question.attr('data-key');

    console.log("answer = " + id);
    console.log("question = " + idquestion);

    $.ajax({
        url: 'http://localhost/AWS-QUIZZ/controller/QuestionController.php',
        type: 'POST',
        dataType: 'json',
        data: {
            useranswer: id,
            question: idquestion
        },
        success: function (responseObject) {
            let htmlResponse = responseObject.htmlResponse;
            $('.main').html(htmlResponse);
            let returnedScore = responseObject.score;
            score = returnedScore;

            setTimeout(() => {
                nextquestion();
            }, 5000);
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}


var index = 1;
function nextquestion() {
    // // scorediv.text("score : " + score);
    // var scorediv = document.querySelector('#score');
    // var pagediv = document.querySelector('#page'); 
    // scorediv.textContent = 'score : ' + score;

    // pagediv.text(`${index + 1}/${questionOBJECT.length}`);
    document.body.innerHTML = '';
    const Container = document.createElement('div');
    Container.classList.add('main');

    // var Container = document.querySelector('.main');

    var scorediv, pagediv; // Declare them here
    if (index < 10) {
        scorediv = document.createElement('h2');
        scorediv.classList.add('score', 'position-absolute');
        scorediv.id = 'score'; // Set the ID for scorediv

        pagediv = document.createElement('div');
        pagediv.classList.add('page', 'position-absolute');
        pagediv.id = 'page';
        console.log(questionOBJECT);
        Container.innerHTML = `
        <div id="content" class="flex gap-9 flex-col justify-evenly items-center w-[95%] md:w-3/4 h-full mx-auto">
        ${scorediv.outerHTML}
        ${pagediv.outerHTML}
        
        <div class="counter-container">
        <svg class="counter-svg" width="100" height="100">
            <circle class="counter-circle" cx="50" cy="50" r="40" stroke-width="8" fill="transparent" />
            <text class="counter-text" x="50%" y="50%" text-anchor="middle" dy="7px"></text>
        </svg>
    </div>
    
        <div class="question w-full p-2 border-2 border-gray-400 rounded-xl shadow-xl" data-key="${questionOBJECT[index].id}">
            <p>${questionOBJECT[index].question_desc}</p>
        </div>
        <div class="answers grid grid-cols-2 gap-4 md:gap-8 w-full child:p-2 child:border child:border-gray-400 child:shadow-lg child:rounded-lg">
          
        </div>
        <div class="self-end">
            <button id="NEXT" class="p-1 px-4 bg-[#ff9900] border border-black rounded-xl" onclick="answerid()">Next</button>
        </div>
    </div>
           
        `;
        document.body.appendChild(Container);
        scorediv = document.querySelector('#score');
        pagediv = document.querySelector('#page');

        scorediv.textContent = 'score : ' + score;
        pagediv.textContent = `${index + 1}/${questionOBJECT.length}`;

        index++;
        timer(); 
        sendDataKey();
        setdata();
        answerid();
    } else {
        $.get('http://localhost/AWS-QUIZZ/view/final.php', function (data) {
            $('.main').html(data);
            console.log(data);
            // pagediv.addClass('hidden');
            // scorediv.addClass('hidden');
            // progresscontainer.addClass('hidden');
        });
    }
}


// document.addEventListener("DOMContentLoaded", startCountdown);





// $(document).ready(function () {
//     $('#submitbutton').on('click', function (e) {
//         e.preventDefault();
//         var formdata = $('#myform').serialize();


//         $.ajax({
//             type: 'POST',
//             url: '../../../controller/QuestionController.php',
//             Data: formdata,
//             success: function (response) {
//                 console.log(response);
//             },
//             error: function (xhr, status, error) {
//                 console.log(error);
//             }


//         })

//     })
// })