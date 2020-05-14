<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yeahcheese</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link
          type="text/css"
          rel="stylesheet"
          href="https://unpkg.com/bootstrap/dist/css/bootstrap.min.css"
        />
        <link
          type="text/css"
          rel="stylesheet"
          href="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.css"
        />
    </head>
    <body>
        <div id="app">
            
        </div>
        <script src="https://unpkg.com/vue"></script>
        <script src="https://unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.js"></script>
        <script src=" {{ mix('js/app.js') }} "></script>
    </body>
</html>
