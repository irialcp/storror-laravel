// js/shop.js
document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM caricato, avvio loadProducts()...");
    loadProducts();
});

let allProducts = [];

// Modifica la funzione loadProducts esistente per salvare i prodotti
async function loadProducts() {
    const productContainer = document.getElementById("product-list");
    if (!productContainer) {
        console.error(
            "Elemento con ID 'product-list' non trovato. Impossibile caricare i prodotti."
        );
        return;
    }
    console.log("Elemento 'product-list' trovato:", productContainer);

    const apiUrl = "/api/products";

    try {
        console.log("Fetching prodotti da:", apiUrl);
        const response = await fetch(apiUrl);

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(
                `Errore HTTP! Stato: ${response.status}. Messaggio: ${errorText}`
            );
        }

        const products = await response.json();
        console.log("Prodotti ricevuti:", products);

        // Salva tutti i prodotti nella variabile globale
        allProducts = products;

        if (!products || !Array.isArray(products) || products.length === 0) {
            console.warn("Nessun prodotto trovato o dati vuoti dall'API.");
            productContainer.innerHTML =
                "<p style='text-align: center; color: #bbb;'>Nessun prodotto disponibile al momento.</p>";
            return;
        }

        // Renderizza tutti i prodotti inizialmente
        renderProducts(products);

        // Aggiungi l'event listener per il filtro "In Stock Only"
        setupStockFilter();
    } catch (error) {
        console.error("Errore nel caricamento dei prodotti:", error);
        productContainer.innerHTML =
            "<p style='text-align: center; color: red;'>Errore nel caricamento dei prodotti. Riprova più tardi.</p>";
    }
}

// Funzione per renderizzare i prodotti
function renderProducts(products) {
    const productContainer = document.getElementById("product-list");

    if (!products || products.length === 0) {
        productContainer.innerHTML =
            "<p style='text-align: center; color: #bbb;'>Nessun prodotto disponibile con i filtri selezionati.</p>";
        return;
    }

    let htmlContent = "";
    products.forEach((product) => {
        console.log("Processing product:", product);

        if (product && product.name && product.price && product.image) {
            // Controlla se il prodotto è in stock per mostrare un indicatore
            const stockStatus = product.in_stock
                ? ""
                : '<span style="color: red; font-size: 0.8em;">(Esaurito)</span>';

            htmlContent += `
                <div class="product-card" data-in-stock="${
                    product.in_stock || false
                }">
                    <div class="product-card__image">
                        <a href="/product/${product.id}"></a> 
                        <img class="main-image" src="${product.image}" alt="${
                product.name
            }">
                        <img class="hover-image" src="${
                            product.image_hover || product.image
                        }" alt="${product.name} Hover"> 
                        <button class="add-to-cart" data-id="${product.id}" ${
                !product.in_stock ? "disabled" : ""
            }>
                            ${product.in_stock ? "Add to Cart" : "Out of Stock"}
                        </button>
                    </div>
                    <div class="product-card__info">
                        <p>${product.name} ${stockStatus}</p>
                        <p>${product.price} €</p>
                    </div>
                </div>
            `;
        } else {
            console.warn(
                "Prodotto con dati mancanti o incompleti, saltato:",
                product
            );
        }
    });

    console.log("HTML generato (htmlContent):", htmlContent);
    productContainer.innerHTML = htmlContent;
    console.log("Contenuto inserito in product-list.");

    // Riattiva gli event listeners per i pulsanti "Add to Cart"
    attachAddToCartListeners();
}

// Funzione per configurare il filtro stock
function setupStockFilter() {
    const stockToggle = document.getElementById("inStockToggle");

    if (stockToggle) {
        stockToggle.addEventListener("change", function () {
            filterByStock(this.checked);
        });
    } else {
        console.warn('Toggle "In Stock Only" non trovato');
    }
}

// Funzione per filtrare i prodotti in base allo stock
function filterByStock(inStockOnly) {
    console.log(
        "Filtraggio per stock:",
        inStockOnly ? "Solo in stock" : "Tutti i prodotti"
    );

    let filteredProducts = allProducts;

    if (inStockOnly) {
        // Filtra solo i prodotti in stock
        filteredProducts = allProducts.filter((product) => {
            // Controlla se in_stock è true, 1, o "1" (per gestire diversi tipi di dato)
            return (
                product.in_stock === true ||
                product.in_stock === 1 ||
                product.in_stock === "1" ||
                (product.stock && product.stock > 0)
            ); // Fallback se usi un campo "stock" numerico
        });

        console.log(
            `Trovati ${filteredProducts.length} prodotti in stock su ${allProducts.length} totali`
        );
    }

    // Renderizza i prodotti filtrati
    renderProducts(filteredProducts);
}

// Funzione separata per gestire gli event listeners dei pulsanti "Add to Cart"
function attachAddToCartListeners() {
    document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();

            // Non aggiungere al carrello se il prodotto non è in stock
            if (this.disabled) {
                alert("Questo prodotto non è disponibile al momento.");
                return;
            }

            const productId = this.dataset.id;
            addToCart(productId);
        });
    });
}

// Funzione opzionale per resettare tutti i filtri
function resetFilters() {
    const stockToggle = document.getElementById("inStockToggle");
    if (stockToggle) {
        stockToggle.checked = false;
    }

    // Mostra tutti i prodotti
    renderProducts(allProducts);
}

/**
 * @param {string} productId - L'ID del prodotto da aggiungere.
 */
async function addToCart(productId) {
    try {
        const response = await fetch("/api/cart/add", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({ product_id: productId }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            alert("Prodotto aggiunto al carrello!");
        } else {
            const message =
                result.message ||
                "Errore sconosciuto durante l'aggiunta al carrello.";
            if (message === "Utente non autenticato.") {
                alert(
                    "Devi effettuare il login per aggiungere prodotti al carrello."
                );
                window.location.href = "/login";
            } else {
                alert("Errore: " + message);
            }
        }
    } catch (error) {
        console.error("Errore durante l'aggiunta al carrello:", error);
        alert("Si è verificato un errore durante l'aggiunta al carrello.");
    }
}
