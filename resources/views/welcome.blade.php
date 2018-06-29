<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Documentation</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
                <button>ajax</button>
            </div>
        </div>
        <script>
            $(document).ready(function(){
            $("button").click(function(){

                    var data = {
                        question_id: 33,
                        vacancy_id: 1,
                        user_id: 1,
                        answer_id: 52
                    };
                    // var data = {
                    //     userId:5,
                    // };
                    
                    // var data = {
                    //     user_id:5,
                    //     name:'what is a css',
                    //     vacancy_id: 1,
                    //     status:1,
                    //     answers: [
                    //         {
                    //             name: 'planguage', 
                    //             status: 0,
                    //             // id: 1,
                    //         },
                    //         {
                    //             name: 'humanLanguage', 
                    //             status: 0,
                    //             // id: 2,
                    //         },
                    //         {
                    //             name: 'book', 
                    //             status: 0,
                    //             // id: 3,
                    //         },
                    //         {
                    //             name: 'technique', 
                    //             status: 1,
                    //             // id: 4,
                    //         },
                    //     ]
                    // };
                    // var url = 'vacancies/4';
                    // var data = {
                    //     userId:5,
                    //     name:'fotographer',
                    //     status:1
                    // };
                    // var url = 'vacancies';
                    // var data = {
                    //     name: 'miha',
                    //     phone: '8(342)23412342',
                    //     password: '123123',
                    //     email: 'miha@gmail.com',
                    //     role: 2
                    // };
                    // var url = 'auth';
                    // var id = 21;
                    // var url = 'questions';
                    var url = 'results';
                    var baseUrl = 'http://php_server.ua/api/' + url;

                    $.post(baseUrl,
                    data,
                    function(data,status){
                        console.log(data);
                    });
                    // $.ajax({
                    //     url: baseUrl,
                    //     // method: 'PUT',
                    //     method: 'DELETE',
                    //     data: data,
                    //     success: function(result) {
                    //         console.log(result);
                    //     },
                    //     error: function(request,msg,error) {
                    //         // handle failure
                    //     }
                    // });
                });
            });

            
        </script>
    </body>
</html>
