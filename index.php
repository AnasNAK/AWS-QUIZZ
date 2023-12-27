<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quizz</title>
    <link rel="stylesheet" type="text/css" href="./view/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
</head>

<body>
    <section class=" overflow-hidden w-3/4 m-auto mt-24 rounded-lg shadow-2xl md:grid md:grid-cols-3">

        <img alt="Trainer" src="./view/assets/img/AWS Cloud Practitioner Cheat Sheets_ Cloud Concepts_ _ AWSBoy.jpg"
            class="img h-32 w-full object-cover md:h-full" />

        <div class="main flex flex-col gap-9 p-4 text-center sm:p-6 md:col-span-2 lg:p-8">


            <h2 class="mt-6 font-black uppercase">
                <span class="text-4xl font-black sm:text-5xl lg:text-6xl"> Quizz AWS </span>

                <span class="mt-2 block text-sm">insert your username firstly</span>
            </h2>

            <div id="myform">
                <div>
                    <input class="border-2 border-gray-400 py-1 w-2/4 rounded-md" type="text" id="username"
                        placeholder="anas" name="username">
                    <div class="error-message" id="username-error"></div>

                </div>

                <button type="submit" id="submitbutton" class="mt-8 inline-block w-3/4 rounded-md bg-black py-4 text-sm font-bold uppercase
                     tracking-widest text-white duration-200 hover:bg-gray-400 hover:text-lg ">
                    Start
                </button>
            </div>


        </div>
    </section>
    <!-- <script src="./view/assets/js/rejex.js"></script> -->
    <script src="./view/assets/js/main.js"></script>
</body>

</html>