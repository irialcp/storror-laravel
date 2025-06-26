<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STORROR Team</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/team.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <section id="meet-the-team">
            <div id="team-intro">
                <h1>MEET THE TEAM</h1>
                <p>The STORROR team comprises seven members, including two pairs of brothers: Max and Benj Cave, Drew
                    Taylor, Toby Segar, Callum and Sacha Powell, and Josh Burnett-Blake.</p>
                <p>As a professional parkour and specialist stunt performance team, they undertake work for movies,
                    advertising, digital activations, live performances, event guesting and more. The collective is also
                    available to hire as a self-sufficient film production unit for a wide range of projects.</p>
                <p>With parkour stunt roles in 6 Underground, directed by Michael Bay, which was released by Netflix in
                    December 2019 and became its second most-watched film of the year, and other exciting projects on the
                    horizon, the future promises to be more action-packed than ever for the guys.</p>
            </div>
            <div id="team-image">
                <img src="{{ asset('images/team.png') }}" alt="STORROR Team">
            </div>
        </section>
        <section id="team-carousel">
            <div class="carousel-container">
                <div id="statment">
                    <p>For more insight into the seven characters that make STORROR the biggest name in parkour, take a look
                        at their individual profiles.</p>
                </div>
                <div id="carousel">
                    <div class="carousel-item">
                        <img src="{{ asset('images/Max.png') }}" alt="Max Cave">
                        <h3>Max Cave</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Benj.png') }}" alt="Benj Cave">
                        <h3>Benj Cave</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Toby.png') }}" alt="Toby Segar">
                        <h3>Toby Segar</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Drew.png') }}" alt="Drew Taylor">
                        <h3>Drew Taylor</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Callum.png') }}" alt="Callum Powell">
                        <h3>Callum Powell</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Sacha.png') }}" alt="Sacha Powell">
                        <h3>Sacha Powell</h3>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/Josh.png') }}" alt="Josh Burnett-Blake">
                        <h3>Josh Burnett-Blake</h3>
                    </div>
                </div>
            </div>
        </section>
    @endsection

</html>
