<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - STORROR</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/login.js') }}" defer></script>
</head>
<body class="login-page">
    @include('partials.header')

    <div class="login-content-wrapper">
        <form id="login-form">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>
            <button type="submit">Accedi</button>
        </form>
        <p id="login-message" style="color: red; margin-top: 10px;"></p>
        <span>Non ha ancora un account? <a href="{{ route('register') }}">Registrati qui!</a></span>
    </div>
    
    @include('partials.footer')
    
    <!-- Script corretti - IMPORTANTE: chiudere correttamente i tag -->
</body>
</html>