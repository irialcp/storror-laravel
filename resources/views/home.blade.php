<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Storror Clone - Homepage</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}" defer></script>
</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="overlay"></div>
        <button id="image_button">Parkour Images</button>
        <div id="parkour_images_menu">
            <div id="parkour_images">

            </div>
            <button id="close_button">Close</button>
        </div>

        <section class="carousel-section">
            <div id="dynamic-carousel" class="carousel-container">
            </div>
        </section>
        <section class="cta-buttons-section">
            <a href="{{ url('shop') }}" class="cta-button">Shop</a>
            <a href="{{ url('team') }}" class="cta-button">Team</a>
        </section>

        <section id="info-section">
            <div id="info-text">
                <h3>NEW DOCUMENTARY</h3>
                <h1>WE ARE STORROR</h1>
                <p>At the peak of a death-defying career, the 7 friends of parkour team Storror embark on what could
                    be their final project: a globetrotting quest to conquer 4 extreme environments. Faced with harrowing
                    accidents and personal conflicts, the team grapples to maintain the bonds that have united them
                    since their beginnings as ragtag street kids. From Michael Bay, this immersive documentary delves
                    into these thrilling athletes who command over 10 million YouTube subscribers and nearly 3 billion
                    views. Equal parts adrenaline and heart, the film takes you to the edge and asks: What's truly
                    worth risking your life for?
                </p>
                <spam>More release info coming soon.</spam>
                <a href="team.php"></a>
            </div>
            <div id="info-image">
                <img src="{{ asset('images/info.png') }}" alt="Informazioni">
            </div>
        </section>
        <section id="text_with_icon">
            <div id="information">
                <div class="block_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false"
                        stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-box"
                        viewBox="0 0 24 24">
                        <path
                            d="M2.22 5.472a.742.742 0 0 0-.33.194.773.773 0 0 0-.175.48c-.47 4.515-.48 7.225 0 11.707a.792.792 0 0 0 .505.737l9.494 3.696.285.079.286-.08 9.494-3.694a.806.806 0 0 0 .505-.737c.5-4.537.506-7.153 0-11.648a.765.765 0 0 0-.175-.542.739.739 0 0 0-.33-.257v.002"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M22.269 5.997a.771.771 0 0 0-.16-.335.744.744 0 0 0-.33-.257l-9.494-3.629a.706.706 0 0 0-.571 0L6.967 3.623 2.22 5.47a.742.742 0 0 0-.33.192.771.771 0 0 0-.16.336.806.806 0 0 0 .49.592l9.494 3.696h.57l5.216-2.03L21.78 6.59a.794.794 0 0 0 .492-.593h-.002Z"
                            fill="currentColor" fill-opacity="0" />
                        <path
                            d="m17.5 8.255-5.215 2.03h-.571L2.22 6.59a.806.806 0 0 1-.49-.592.771.771 0 0 1 .16-.336.742.742 0 0 1 .33-.192l4.747-1.847M17.5 8.255 21.78 6.59a.794.794 0 0 0 .492-.593h-.002a.771.771 0 0 0-.16-.335.744.744 0 0 0-.33-.257l-9.494-3.629a.706.706 0 0 0-.571 0L6.967 3.623M17.5 8.255 6.967 3.623M12 22.365v-12.08M15.5 17l4-1.5"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h6>WORLDWIDE SHIPPING</h6>
                    <P>Tracked and efficient shipping to all major countries.</P>
                </div>
                <div class="block_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false"
                        stroke-width="1" width="24" height="24"
                        class="hidden sm:block icon icon-picto-customer-support" viewBox="0 0 24 24">
                        <path
                            d="M1.714 14.143c0-3.919 2.613-4.898 3.92-4.898 2.35 0 2.938 1.96 2.938 2.938v3.92c0 2.35-1.96 2.938-2.939 2.938-1.306 0-3.919-.98-3.919-4.898ZM22.286 14.143c0-3.919-2.613-4.898-3.92-4.898-2.35 0-2.937 1.96-2.937 2.938v3.92c0 2.35 1.96 2.938 2.938 2.938 1.306 0 3.919-.98 3.919-4.898Z"
                            fill="currentColor" fill-opacity="0" />
                        <path
                            d="M1.714 14.143c0-3.919 2.613-4.898 3.92-4.898 2.35 0 2.938 1.96 2.938 2.938v3.92c0 2.35-1.96 2.938-2.939 2.938-1.306 0-3.919-.98-3.919-4.898ZM22.286 14.143c0-3.919-2.613-4.898-3.92-4.898-2.35 0-2.937 1.96-2.937 2.938v3.92c0 2.35 1.96 2.938 2.938 2.938 1.306 0 3.919-.98 3.919-4.898Z"
                            stroke="currentColor" />
                        <path
                            d="M2.38 11.263C2.524 6.537 4.929 1.286 12 1.286c7.06 0 9.468 5.232 9.617 9.951m.106 5.666s.134 3.079-1.447 4.42c-1.58 1.336-5.57 1.31-5.57 1.31"
                            stroke="currentColor" stroke-linecap="round" />
                    </svg>
                    <h6>24/7 SUPPORT</h6>
                    <P>Here to help at all hours of the day.</P>
                </div>
                <div class="block_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false"
                        stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-credit-card"
                        viewBox="0 0 24 24">
                        <path
                            d="M1.714 16.882c0 1.36 1.063 2.48 2.4 2.71 1.773.307 3.456.714 7.886.714s6.113-.407 7.886-.713c1.337-.232 2.4-1.351 2.4-2.709V6.708c0-1.183-.806-2.203-1.975-2.39A53.325 53.325 0 0 0 12 3.694c-4.43 0-6.114.407-7.887.713-1.337.232-2.4 1.351-2.4 2.709v9.766Z"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M22.286 9.588H1.714V7.02c0-1.305 1.02-2.378 2.306-2.597.235-.04.466-.08.703-.124 1.584-.288 3.351-.605 7.277-.605 3.69 0 6.617.352 8.39.638 1.12.182 1.896 1.162 1.896 2.297v2.959Z"
                            fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M14.666 15.804h3.485" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <h6>PAY LATER</h6>
                    <P>Buy now and pay later with Klarna.</P>
                </div>
                <div class="block_icon">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false"
                        stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-return"
                        viewBox="0 0 24 24">
                        <path
                            d="M2.04 17.208a5.362 5.362 0 0 0 4.721 4.731c1.706.189 3.456.347 5.24.347 1.782 0 3.532-.158 5.238-.347a5.362 5.362 0 0 0 4.72-4.731c.18-1.697.327-3.435.327-5.208 0-1.773-.148-3.513-.326-5.208a5.362 5.362 0 0 0-4.721-4.731c-1.706-.189-3.456-.347-5.239-.347s-3.533.158-5.239.347a5.362 5.362 0 0 0-4.72 4.731c-.18 1.697-.327 3.435-.327 5.208 0 1.773.148 3.513.326 5.208Z"
                            fill="currentColor" fill-opacity="0" stroke="currentColor" />
                        <path
                            d="M6.857 13.977h5.907a3.429 3.429 0 0 0 3.429-3.429V7.293M10.2 10.635c-1.468 1.2-2.2 1.934-3.343 3.343C8 15.384 8.732 16.118 10.2 17.32"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <h6>30 DAYS RETURNS</h6>
                    <P>Return or exchange your order within 30 days.</P>
                </div>
        </section>
    @endsection

</body>

</html>
