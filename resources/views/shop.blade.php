<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shop - STORROR</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/shop.js') }}" defer></script>
</head>
<body>
    @include('partials.header')
    

    <section id="round_pics">
        <div id="conteiner-pics">
            <ul id="collector">
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=180 180w, //storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=360 360w, //storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=540 540w, //storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=720 720w, //storror.com/cdn/shop/files/Shp_All_2.png?v=1732794430&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>ALL</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=180 180w, //storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=360 360w, //storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=540 540w, //storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=720 720w, //storror.com/cdn/shop/files/T-Shirt2_c4add26c-58ab-4bb7-91a4-e6536aa2ba20.png?v=1732569365&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>T-SHIRTS</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=180 180w, //storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=360 360w, //storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=540 540w, //storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=720 720w, //storror.com/cdn/shop/files/Hood.png?v=1732569727&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>HOODIES</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=180 180w, //storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=360 360w, //storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=540 540w, //storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=720 720w, //storror.com/cdn/shop/files/Cargos.png?v=1732569727&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>PANTS</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=180 180w, //storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=360 360w, //storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=540 540w, //storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=720 720w, //storror.com/cdn/shop/files/Jacket2.png?v=1732569365&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>JACKETS</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=180 180w, //storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=360 360w, //storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=540 540w, //storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=720 720w, //storror.com/cdn/shop/files/Caps.png?v=1732569728&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>HATS</p>
                </a></li>
                <li><a href="#" class="pic">
                    <div class="pic_cont"><img src="//storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=1000" alt="" srcset="//storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=180 180w, //storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=360 360w, //storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=540 540w, //storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=720 720w, //storror.com/cdn/shop/files/Bag2_bcab75c6-377a-48db-98ca-7065e9948170.png?v=1732569365&amp;width=900 900w" width="1000" height="1000" sizes="300px"></div>
                    <p>ACCESSORIES</p>
                </a></li>
            </ul>
        </div>
   </section>
    <section id="collection">
        <div class="grid-container">
            <div class="filter">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-120v-240h80v80h320v80H520v80h-80Zm-320-80v-80h240v80H120Zm160-160v-80H120v-80h160v-80h80v240h-80Zm160-80v-80h400v80H440Zm160-160v-240h80v80h160v80H680v80h-80Zm-480-80v-80h400v80H120Z"/></svg>
                <p>Filters</p>
            </div>
            <div class="summary"></div>
            <div id="collection_facets">
                <div class="accordion">
                    <span>In stock only</span>
                    <label class="switch">
                        <input type="checkbox" id="inStockToggle">
                        <span class="slider"></span>
                    </label>
                </div>
                <div class="accordion">
                    <span>Collection</span>
                    <span class="custom_button"><svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5C11.9015 14.5005 11.8038 14.4813 11.7128 14.4435C11.6218 14.4057 11.5392 14.3501 11.47 14.28L8 10.78C7.90861 10.6391 7.86719 10.4715 7.88238 10.3042C7.89756 10.1369 7.96848 9.97954 8.08376 9.85735C8.19904 9.73515 8.352 9.65519 8.51814 9.63029C8.68428 9.6054 8.85396 9.63699 9 9.72003L12 12.72L15 9.72003C15.146 9.63699 15.3157 9.6054 15.4819 9.63029C15.648 9.65519 15.801 9.73515 15.9162 9.85735C16.0315 9.97954 16.1024 10.1369 16.1176 10.3042C16.1328 10.4715 16.0914 10.6391 16 10.78L12.5 14.28C12.3675 14.4144 12.1886 14.4931 12 14.5Z" fill="#000000"></path> </g></svg></span>
                </div>
                <div class="accordion">
                    <span>Product type</span>
                    <span class="custom_button"><svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5C11.9015 14.5005 11.8038 14.4813 11.7128 14.4435C11.6218 14.4057 11.5392 14.3501 11.47 14.28L8 10.78C7.90861 10.6391 7.86719 10.4715 7.88238 10.3042C7.89756 10.1369 7.96848 9.97954 8.08376 9.85735C8.19904 9.73515 8.352 9.65519 8.51814 9.63029C8.68428 9.6054 8.85396 9.63699 9 9.72003L12 12.72L15 9.72003C15.146 9.63699 15.3157 9.6054 15.4819 9.63029C15.648 9.65519 15.801 9.73515 15.9162 9.85735C16.0315 9.97954 16.1024 10.1369 16.1176 10.3042C16.1328 10.4715 16.0914 10.6391 16 10.78L12.5 14.28C12.3675 14.4144 12.1886 14.4931 12 14.5Z" fill="#000000"></path> </g></svg></span>
                </div>
                <div class="accordion">
                    <span>Colour</span>
                    <span class="custom_button"><svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5C11.9015 14.5005 11.8038 14.4813 11.7128 14.4435C11.6218 14.4057 11.5392 14.3501 11.47 14.28L8 10.78C7.90861 10.6391 7.86719 10.4715 7.88238 10.3042C7.89756 10.1369 7.96848 9.97954 8.08376 9.85735C8.19904 9.73515 8.352 9.65519 8.51814 9.63029C8.68428 9.6054 8.85396 9.63699 9 9.72003L12 12.72L15 9.72003C15.146 9.63699 15.3157 9.6054 15.4819 9.63029C15.648 9.65519 15.801 9.73515 15.9162 9.85735C16.0315 9.97954 16.1024 10.1369 16.1176 10.3042C16.1328 10.4715 16.0914 10.6391 16 10.78L12.5 14.28C12.3675 14.4144 12.1886 14.4931 12 14.5Z" fill="#000000"></path> </g></svg></span>
                </div>
                <div class="accordion">
                    <span>Size</span>
                    <span class="custom_button"><svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 14.5C11.9015 14.5005 11.8038 14.4813 11.7128 14.4435C11.6218 14.4057 11.5392 14.3501 11.47 14.28L8 10.78C7.90861 10.6391 7.86719 10.4715 7.88238 10.3042C7.89756 10.1369 7.96848 9.97954 8.08376 9.85735C8.19904 9.73515 8.352 9.65519 8.51814 9.63029C8.68428 9.6054 8.85396 9.63699 9 9.72003L12 12.72L15 9.72003C15.146 9.63699 15.3157 9.6054 15.4819 9.63029C15.648 9.65519 15.801 9.73515 15.9162 9.85735C16.0315 9.97954 16.1024 10.1369 16.1176 10.3042C16.1328 10.4715 16.0914 10.6391 16 10.78L12.5 14.28C12.3675 14.4144 12.1886 14.4931 12 14.5Z" fill="#000000"></path> </g></svg></span>
                </div>
            </div>
            <div id="product-list">
                
            </div>
        </div>
    </section>
    <section id="text_with_icon">
    <div id="information">
        <div class="block_icon">
            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false" stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-box" viewBox="0 0 24 24">
                <path d="M2.22 5.472a.742.742 0 0 0-.33.194.773.773 0 0 0-.175.48c-.47 4.515-.48 7.225 0 11.707a.792.792 0 0 0 .505.737l9.494 3.696.285.079.286-.08 9.494-3.694a.806.806 0 0 0 .505-.737c.5-4.537.506-7.153 0-11.648a.765.765 0 0 0-.175-.542.739.739 0 0 0-.33-.257v.002" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.269 5.997a.771.771 0 0 0-.16-.335.744.744 0 0 0-.33-.257l-9.494-3.629a.706.706 0 0 0-.571 0L6.967 3.623 2.22 5.47a.742.742 0 0 0-.33.192.771.771 0 0 0-.16.336.806.806 0 0 0 .49.592l9.494 3.696h.57l5.216-2.03L21.78 6.59a.794.794 0 0 0 .492-.593h-.002Z" fill="currentColor" fill-opacity="0"/>
                <path d="m17.5 8.255-5.215 2.03h-.571L2.22 6.59a.806.806 0 0 1-.49-.592.771.771 0 0 1 .16-.336.742.742 0 0 1 .33-.192l4.747-1.847M17.5 8.255 21.78 6.59a.794.794 0 0 0 .492-.593h-.002a.771.771 0 0 0-.16-.335.744.744 0 0 0-.33-.257l-9.494-3.629a.706.706 0 0 0-.571 0L6.967 3.623M17.5 8.255 6.967 3.623M12 22.365v-12.08M15.5 17l4-1.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h6>WORLDWIDE SHIPPING</h6>
            <p>Tracked and efficient shipping to all major countries.</p>
        </div>
        <div class="block_icon">
            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false" stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-customer-support" viewBox="0 0 24 24">
                <path d="M1.714 14.143c0-3.919 2.613-4.898 3.92-4.898 2.35 0 2.938 1.96 2.938 2.938v3.92c0 2.35-1.96 2.938-2.939 2.938-1.306 0-3.919-.98-3.919-4.898ZM22.286 14.143c0-3.919-2.613-4.898-3.92-4.898-2.35 0-2.937 1.96-2.937 2.938v3.92c0 2.35 1.96 2.938 2.938 2.938 1.306 0 3.919-.98 3.919-4.898Z" fill="currentColor" fill-opacity="0"/>
                <path d="M1.714 14.143c0-3.919 2.613-4.898 3.92-4.898 2.35 0 2.938 1.96 2.938 2.938v3.92c0 2.35-1.96 2.938-2.939 2.938-1.306 0-3.919-.98-3.919-4.898ZM22.286 14.143c0-3.919-2.613-4.898-3.92-4.898-2.35 0-2.937 1.96-2.937 2.938v3.92c0 2.35 1.96 2.938 2.938 2.938 1.306 0 3.919-.98 3.919-4.898Z" stroke="currentColor"/>
                <path d="M2.38 11.263C2.524 6.537 4.929 1.286 12 1.286c7.06 0 9.468 5.232 9.617 9.951m.106 5.666s.134 3.079-1.447 4.42c-1.58 1.336-5.57 1.31-5.57 1.31" stroke="currentColor" stroke-linecap="round"/>
            </svg>
            <h6>24/7 SUPPORT</h6>
            <p>Here to help at all hours of the day.</p>
        </div>
        <div class="block_icon">
            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false" stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-credit-card" viewBox="0 0 24 24">
                <path d="M1.714 16.882c0 1.36 1.063 2.48 2.4 2.71 1.773.307 3.456.714 7.886.714s6.113-.407 7.886-.713c1.337-.232 2.4-1.351 2.4-2.709V6.708c0-1.183-.806-2.203-1.975-2.39A53.325 53.325 0 0 0 12 3.694c-4.43 0-6.114.407-7.887.713-1.337.232-2.4 1.351-2.4 2.709v9.766Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.286 9.588H1.714V7.02c0-1.305 1.02-2.378 2.306-2.597.235-.04.466-.08.703-.124 1.584-.288 3.351-.605 7.277-.605 3.69 0 6.617.352 8.39.638 1.12.182 1.896 1.162 1.896 2.297v2.959Z" fill="currentColor" fill-opacity="0" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14.666 15.804h3.485" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h6>PAY LATER</h6>
            <p>Buy now and pay later with Klarna.</p>
        </div>
        <div class="block_icon">
            <svg xmlns="http://www.w3.org/2000/svg" role="presentation" fill="none" focusable="false" stroke-width="1" width="24" height="24" class="hidden sm:block icon icon-picto-return" viewBox="0 0 24 24">
                <path d="M2.04 17.208a5.362 5.362 0 0 0 4.721 4.731c1.706.189 3.456.347 5.24.347 1.782 0 3.532-.158 5.238-.347a5.362 5.362 0 0 0 4.72-4.731c.18-1.697.327-3.435.327-5.208 0-1.773-.148-3.513-.326-5.208a5.362 5.362 0 0 0-4.721-4.731c-1.706-.189-3.456-.347-5.239-.347s-3.533.158-5.239.347a5.362 5.362 0 0 0-4.72 4.731c-.18 1.697-.327 3.435-.327 5.208 0 1.773.148 3.513.326 5.208Z" fill="currentColor" fill-opacity="0" stroke="currentColor"/>
                <path d="M6.857 13.977h5.907a3.429 3.429 0 0 0 3.429-3.429V7.293M10.2 10.635c-1.468 1.2-2.2 1.934-3.343 3.343C8 15.384 8.732 16.118 10.2 17.32" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <h6>30 DAYS RETURNS</h6>
            <p>Return or exchange your order within 30 days.</p>
        </div>
    </div>
</section>
    @include('partials.footer')
    
</body>
</html>