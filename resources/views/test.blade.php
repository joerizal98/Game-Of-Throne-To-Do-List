<!DOCTYPE html>
<html>
    <head>
        @vite(['resources/js/app.js' , 'resources/css/app.css'])
    </head>
    <body>
    <div id="app">
    <todo />
    <test :quote="{{ json_encode($quote) }}"></test>

</div>
    </body>
</html>