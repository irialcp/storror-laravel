<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Il Mio Carrello - STORROR</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <script src="{{ asset('js/cart.js') }}"></script>
</head>

<body>
    @include('partials.header')

    <main class="cart-page-content">
        <h1>Il Mio Carrello</h1>

        <div id="cart-container">
        </div>

    </main>

    @include('partials.footer')
</body>

</html>
