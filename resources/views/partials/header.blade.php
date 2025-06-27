<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Storror Clone</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>

<body>
    <header id="header">
        <div id="hidden_header">
            <div id="menu_button">
                <button class="button">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1" focusable="false"
                        width="22" height="22" class="icon icon-hamburger" viewBox="0 0 22 22 "color="white">
                        <path d="M1 5h20M1 11h20M1 17h20" stroke="currentColor" stroke-linecap="round" />
                    </svg>
                </button>
            </div>
            <div class="overlay"></div>
            <div id="wrapper">
                <div id="menu-wrap">
                    <button id="close">
                        <svg xmlns="http://www.w3.org/2000/svg" class="" viewBox="0 0 24 24" color="black">
                            <path
                                d="M19 6.41l-1.41-1.41-5.59 5.59-5.59-5.59-1.41 1.41 5.59 5.59-5.59 5.59 1.41 1.41 5.59-5.59 5.59 5.59 1.41-1.41-5.59-5.59z" />
                            <path d="M0 0h24v24h-24z" fill="none" />
                        </svg>
                    </button>
                    <ul class="list">
                        <li><a href="{{ url('shop') }}">NEW</a></li>
                        <li><a href="{{ url('shop') }}">CLOTHING</a></li>
                        <li><a href="{{ url('shop') }}">ACCESSORIES</a></li>
                        <li><a href="{{ url('shop') }}">GIFT CARD</a></li>
                        <li><a href="{{ url('shop') }}">THE SAFE</a></li>
                    </ul>
                    <ul class="list">
                        <li><a href="{{ url('team') }}">TEAM</a></li>
                        <li><a href="{{ url('team') }}">VIDEO GAME</a></li>
                        <li><a href="{{ url('team') }}">SUPPORT</a></li>
                    </ul>
                </div>
            </div>
            <div id="hidden_img">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="storrorlogo"
                        width="60"></a>
            </div>
            <nav id="hidden_nav">
                <a href="{{ url('cart') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1" focusable="false"
                        width="22" height="22" class="icon icon-cart" viewBox="0 0 22 22">
                        <path
                            d="M9.182 18.454a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.818 0Zm7.272 0a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.819 0Z"
                            fill="currentColor" />
                        <path
                            d="M5.336 6.636H21l-3.636 8.182H6.909L4.636 3H1m8.182 15.454a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.818 0Zm7.272 0a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.819 0Z"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
                @auth
                    <button id="logout_button_desktop" title="Logout">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1" focusable="false"
                                width="22" height="22" class="icon icon-logout" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </a>
                    </button>
                @endauth
                @guest
                    <a href="{{ url('login') }}" title="Login">
                        <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1" focusable="false"
                            width="22" height="22" class="icon icon-account" viewBox="0 0 22 22">
                            <circle cx="11" cy="7" r="4" fill="none" stroke="currentColor" />
                            <path d="M3.5 19c1.421-2.974 4.247-5 7.5-5s6.079 2.026 7.5 5" fill="none"
                                stroke="currentColor" stroke-linecap="round" />
                        </svg>
                    </a>
                @endguest
            </nav>
        </div>
        <div id="header_desktop">
            <nav class="nav">
                <a id="yellow" href="{{ url('shop') }}">NEW</a>
                <a href="{{ url('shop') }}">CLOTHING</a>
                <a href="{{ url('shop') }}">ACCESSORIES</a>
                <a href="{{ url('shop') }}">GIFT CARD</a>
                <a href="{{ url('shop') }}">THE SAFE</a>
            </nav>
            <div id="logo">
                <a id="logo" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}"
                        alt="storrorlogo" width="60"></a>
            </div>
            <nav class="nav">
                <a href="{{ url('team') }}">TEAM</a>
                <a href="{{ url('team') }}">VIDEO GAME</a>
                <a href="{{ url('team') }}">SUPPORT</a>
                <div id="icons_nav">
                    <a href="{{ url('cart') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1"
                            focusable="false" width="22" height="22" class="icon icon-cart"
                            viewBox="0 0 22 22">
                            <path
                                d="M9.182 18.454a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.818 0Zm7.272 0a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.819 0Z"
                                fill="currentColor" />
                            <path
                                d="M5.336 6.636H21l-3.636 8.182H6.909L4.636 3H1m8.182 15.454a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.818 0Zm7.272 0a.91.91 0 1 1-1.818 0 .91.91 0 0 1 1.819 0Z"
                                fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                    @auth
                        <button id="logout_button_desktop" title="Logout">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                            <a href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1"
                                    focusable="false" width="22" height="22" class="icon icon-logout"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                            </a>
                        </button>
                    @endauth
                    @guest
                        <a href="{{ url('login') }}" title="Login">
                            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" stroke-width="1"
                                focusable="false" width="22" height="22" class="icon icon-account"
                                viewBox="0 0 22 22">
                                <circle cx="11" cy="7" r="4" fill="none" stroke="currentColor" />
                                <path d="M3.5 19c1.421-2.974 4.247-5 7.5-5s6.079 2.026 7.5 5" fill="none"
                                    stroke="currentColor" stroke-linecap="round" />
                            </svg>
                        </a>
                    @endguest
                </div>
            </nav>
        </div>
    </header>
</body>

</html>
