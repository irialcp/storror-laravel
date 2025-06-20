// js/shop.js
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM caricato, avvio loadProducts()...');
    loadProducts();
});

async function loadProducts() {
    const productContainer = document.getElementById('product-list');
    if (!productContainer) {
        console.error("Elemento con ID 'product-list' non trovato. Impossibile caricare i prodotti.");
        return;
    }
    console.log("Elemento 'product-list' trovato:", productContainer);


    const apiUrl = '/api/products';

    try {
        console.log('Fetching prodotti da:', apiUrl);
        const response = await fetch(apiUrl);

        if (!response.ok) {
            const errorText = await response.text();
            throw new Error(`Errore HTTP! Stato: ${response.status}. Messaggio: ${errorText}`);
        }

        const products = await response.json();
        console.log('Prodotti ricevuti:', products);


        if (!products || !Array.isArray(products) || products.length === 0) {
            console.warn("Nessun prodotto trovato o dati vuoti dall'API.");
            productContainer.innerHTML = "<p style='text-align: center; color: #bbb;'>Nessun prodotto disponibile al momento.</p>";
            return;
        }

        let htmlContent = '';
        products.forEach(product => {

            console.log('Processing product:', product);

            if (product && product.name && product.price && product.image) {
                htmlContent += `
                    <div class="product-card">
                        <div class="product-card__image">
                            <a href="/product/${product.id}"></a> <img class="main-image" src="${product.image}" alt="${product.name}">
                            <img class="hover-image" src="${product.image_hover || product.image}" alt="${product.name} Hover"> 
                            <button class="add-to-cart" data-id="${product.id}">Add to Cart</button>
                        </div>
                        <div class="product-card__info">
                            <p>${product.name}</p>
                            <p>${product.price} €</p>
                        </div>
                        
                    </div>
                `;
            } else {
                console.warn("Prodotto con dati mancanti o incompleti, saltato:", product);
            }
        });

        console.log('HTML generato (htmlContent):', htmlContent);
        productContainer.innerHTML = htmlContent;
        console.log('Contenuto inserito in product-list.');
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const productId = this.dataset.id;
                addToCart(productId);
            });
        });

    } catch (error) {
        console.error('Errore nel caricamento dei prodotti:', error);
        productContainer.innerHTML = "<p style='text-align: center; color: red;'>Errore nel caricamento dei prodotti. Riprova più tardi.</p>";
    }
}

/**
 * @param {string} productId - L'ID del prodotto da aggiungere.
 */
async function addToCart(productId) {
    try {
        const response = await fetch('/api/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId })
        });

        const result = await response.json();

        if (response.ok && result.success) {
            alert('Prodotto aggiunto al carrello!');
        } else { 
            const message = result.message || 'Errore sconosciuto durante l\'aggiunta al carrello.';
            if (message === 'Utente non autenticato.') {
                alert('Devi effettuare il login per aggiungere prodotti al carrello.');
                window.location.href = '/login'; 
            } else {
                alert('Errore: ' + message);
            }
        }
    } catch (error) {
        console.error('Errore durante l\'aggiunta al carrello:', error);
        alert('Si è verificato un errore durante l\'aggiunta al carrello.');
    }
}