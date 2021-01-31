<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <title>@yield('titulo')</title>
</head>
<body style="background-color:rgb(206, 195, 38);">
    <h3 class="mt-3 text-center">@yield('cabecera')</h3>
    <div class="container mt-3">
        @yield('contenido')
    </div>
</body>
</html>
