<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrazione - STORROR</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <script src="{{ asset('js/signin.js') }}" defer></script>
</head>
<body class="register-page">
    @include('partials.header')

    <div class="registration-content-wrapper">
        <form id="register-form">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm_password">Conferma Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required class="form-control">
            </div>
            <button type="submit">Registrati</button>
        </form>
        <p id="registration-status-message" style="margin-top: 10px;"></p>
        <span>Hai già un account? <a href="{{ route('login') }}">Accedi qui</a></span>
    </div>

    @include('partials.footer')
</body>
</html>