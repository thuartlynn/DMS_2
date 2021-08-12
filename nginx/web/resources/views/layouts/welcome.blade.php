<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TIS Service Web</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->
        <link rel="preconnect" href="https://fonts.gstatic.com"> 
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,300;0,400;0,600;1,400&family=Noto+Sans+TC:wght@300;400&display=swap" rel="stylesheet">       

        <!-- Styles -->
        <link rel="stylesheet" href="/css/app.css" >

        <!-- Icons -->
        <script src="https://use.fontawesome.com/releases/v5.0.0/js/all.js"></script>

        
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;  
                font-family: 'Nunito','Noto Sans TC', sans-serif;
                font-weight: 300;
                font-size: 13px;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }
            #app {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }
            .flex-column-design {
                display: flex;
                flex-direction: column;
            }

            #up {
                /* background-color: aquamarine; */
                height: 10vh;
            }

            #center {
                background-color: #eeeeee;
                height: 85vh;
                overflow-y: auto;
            }

            #bottom {
                background: #063356;
                height: 5vh;
            }

            /* .flex-column-design-50 {
                flex: 1 0 auto;
                min-height: 75vh;
                background: #eeeeee;
            } */

            

            /* .position-ref {
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
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            } */
            
            .td-class {
                font-size: 1.1rem;
                /* width:75px; */
            }
            
            @media (max-width: 1000px) {
                .vgt-responsive, .vgt-fixed-header { overflow-x: scroll; }
                .vgt-table thead th {
                    width:12.5%;
                    font-size: 1.1rem;
                }
            }

            @media (max-height: 620px) {
                #up {
                    height: 15vh;
                }

                #center {
                    background-color: #eeeeee;
                    height: 79vh;
                    overflow-y: scroll;
                }

                #bottom {
                    height: 6vh;
                }
            }
        </style>
    </head>
    <body>

        @yield('content')

        <script src="/js/app.js"></script>
    </body>
</html>
