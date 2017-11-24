<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nerd of the Night</title>

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

            .black {
                color: #101010;
                font-family: 'Calibri', sans-serif;
                font-weight: 100;
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
        </style>
    </head>
    <body>
        <div class="flex-center">
            <div class="content">
                <div class="col-md-12">
                    <h1>
                        Nerd Of The Night Scoreboard
                    </h1>
                    <div class="table-responsive">
                        <table class="table black col-md-12">
                            <thead>
                                <tr>
                                    <td class="col-md-9">Naam</td>
                                    <td class="col-md-1">Unlocks</td>
                                    <td class="col-md-1">Bonussen</td>
                                    <td class="col-md-1">Totaal</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($scores as $score)
                                <tr>
                                    <td>
                                        {{ $score['name'] }}
                                    </td>
                                    <td>
                                        {{ $score['unlock'] }}
                                    </td>
                                    <td>
                                        {{ $score['bonus'] }}
                                    </td>
                                    <td>
                                        {{ $score['total'] }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script src="/js/app.js"></script>
</html>
