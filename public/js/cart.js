// public/js/cart.js
document.addEventListener("DOMContentLoaded", function () {
    loadCart();
});

async function loadCart() {
    const cartContainer = document.getElementById("cart-container");
    if (!cartContainer) {
        console.error(
            "Elemento con ID 'cart-container' non trovato. Impossibile caricare il carrello."
        );
        return;
    }

    const apiUrl = "/api/cart-items";
    const shopUrl = "/shop";

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            const errorText = await response.text();
            console.error("Errore HTTP!", response.status, errorText);
            cartContainer.innerHTML = `<p style='text-align: center; color: red;'>Errore durante il caricamento del carrello: ${response.status}</p>`;
            return;
        }

        const cartItems = await response.json();

        if (cartItems.success === false) {
            console.error("Errore logico dal server:", cartItems.message);
            cartContainer.innerHTML = `<p style='text-align: center; color: red;'>${cartItems.message}</p>`;
            return;
        }

        if (!cartItems || !Array.isArray(cartItems) || cartItems.length === 0) {
            console.warn("Nessun articolo nel carrello o dati vuoti dall'API.");
            cartContainer.innerHTML = `
                <p class="empty-cart-message">Il tuo carrello è vuoto. Inizia ad aggiungere prodotti!</p>
                <a href="${shopUrl}" class="button-primary">Torna allo Shop</a>
            `;
            return;
        }

        let htmlItemsContent = "";
        let total_price = 0;

        cartItems.forEach((item) => {
            const itemPrice = parseFloat(item.price) || 0;
            const itemQuantity = parseInt(item.quantity) || 0;
            const cartId = item.cart_id;

            const subtotal = itemQuantity * itemPrice;
            total_price += subtotal;

            htmlItemsContent += `
                <div class="cart-item" data-cart-id="${cartId}">
                    <div class="cart-item-image">
                        <img src="${htmlspecialchars(
                            item.image
                        )}" alt="${htmlspecialchars(item.NAME)}">
                    </div>
                    <div class="cart-item-details">
                        <h2>${
                            item.NAME
                                ? htmlspecialchars(item.NAME)
                                : "Nome Prodotto Sconosciuto"
                        }</h2>
                        <p>Prezzo unitario: €${itemPrice.toFixed(2)}</p>
                        <div class="quantity-control">
                            <button class="quantity-minus" data-cart-id="${cartId}">-</button>
                            <input type="number" class="quantity-input" value="${itemQuantity}" min="1" data-cart-id="${cartId}">
                            <button class="quantity-plus" data-cart-id="${cartId}">+</button>
                        </div>
                        <p>Subtotale: €${subtotal.toFixed(2)}</p>
                        <button class="button-secondary remove-item-button" data-cart-id="${cartId}">Rimuovi Completamente</button>
                    </div>
                </div>
            `;
        });

        const fullCartHtml = `
            ${htmlItemsContent}
            
            <div class="cart-summary">
                <h2>Totale Carrello: €${total_price.toFixed(2)}</h2>
                <button class="button-primary">Procedi al Checkout</button>
                <a href="${shopUrl}" class="button-secondary">Continua lo Shopping</a>
            </div>
        `;

        cartContainer.innerHTML = fullCartHtml;

        document.querySelectorAll(".remove-item-button").forEach((button) => {
            button.addEventListener("click", function () {
                const cartId = this.dataset.cartId;
                if (
                    confirm(
                        "Sei sicuro di voler rimuovere completamente questo prodotto dal carrello?"
                    )
                ) {
                    removeFromCart(cartId);
                }
            });
        });

        document.querySelectorAll(".quantity-input").forEach((input) => {
            input.addEventListener("change", function () {
                const cartId = this.dataset.cartId;
                const newQuantity = parseInt(this.value);
                if (!isNaN(newQuantity) && newQuantity >= 1) {
                    updateCartItemQuantity(cartId, newQuantity);
                } else if (newQuantity === 0) {
                    if (
                        confirm(
                            "Impostando la quantità a 0, il prodotto verrà rimosso completamente. Vuoi procedere?"
                        )
                    ) {
                        removeFromCart(cartId);
                    } else {
                        this.value = parseInt(
                            this.dataset.previousQuantity || 1
                        );
                    }
                } else {

                    this.value = parseInt(this.dataset.previousQuantity || 1);
                }
            });
            input.dataset.previousQuantity = input.value;
        });

        document.querySelectorAll(".quantity-minus").forEach((button) => {
            button.addEventListener("click", function () {
                const cartId = this.dataset.cartId;
                const inputElement = document.querySelector(
                    `.quantity-input[data-cart-id="${cartId}"]`
                );
                let currentQuantity = parseInt(inputElement.value);
                if (currentQuantity > 1) {
                    updateCartItemQuantity(cartId, currentQuantity - 1);
                } else if (currentQuantity === 1) {
                    if (
                        confirm(
                            "Vuoi rimuovere completamente questo prodotto dal carrello?"
                        )
                    ) {
                        removeFromCart(cartId);
                    }
                }
            });
        });

        document.querySelectorAll(".quantity-plus").forEach((button) => {
            button.addEventListener("click", function () {
                const cartId = this.dataset.cartId;
                const inputElement = document.querySelector(
                    `.quantity-input[data-cart-id="${cartId}"]`
                );
                let currentQuantity = parseInt(inputElement.value);
                updateCartItemQuantity(cartId, currentQuantity + 1);
            });
        });
    } catch (error) {
        console.error("Errore durante il caricamento del carrello:", error);
        cartContainer.innerHTML =
            "<p style='text-align: center; color: red;'>Si è verificato un errore durante il caricamento del carrello. Riprova più tardi.</p>";
    }
}

async function removeFromCart(cartId) {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch("/api/cart/remove", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ cart_id: cartId }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            alert("Prodotto rimosso completamente dal carrello!");
            loadCart();
        } else {
            const message =
                result.message ||
                "Errore sconosciuto durante la rimozione completa dal carrello.";
            alert("Errore: " + message);
        }
    } catch (error) {
        console.error(
            "Errore durante la rimozione completa dal carrello:",
            error
        );
        alert(
            "Si è verificato un errore durante la rimozione completa dal carrello."
        );
    }
}

async function updateCartItemQuantity(cartId, newQuantity) {
    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const response = await fetch("/api/cart/update-quantity", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ cart_id: cartId, quantity: newQuantity }),
        });

        const result = await response.json();

        if (response.ok && result.success) {
            loadCart();
        } else {
            const message =
                result.message ||
                "Errore sconosciuto durante l'aggiornamento della quantità.";
            alert("Errore: " + message);
            const inputElement = document.querySelector(
                `.quantity-input[data-cart-id="${cartId}"]`
            );
            if (inputElement) {
                inputElement.value = inputElement.dataset.previousQuantity;
            }
        }
    } catch (error) {
        console.error("Errore durante l'aggiornamento della quantità:", error);
        alert(
            "Si è verificato un errore durante l'aggiornamento della quantità."
        );
        const inputElement = document.querySelector(
            `.quantity-input[data-cart-id="${cartId}"]`
        );
        if (inputElement) {
            inputElement.value = inputElement.dataset.previousQuantity;
        }
    }
}

function htmlspecialchars(str) {
    if (typeof str !== "string") {
        return str;
    }
    const map = {
        "&": "&amp;",
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#039;",
    };
    return str.replace(/[&<>"']/g, function (m) {
        return map[m];
    });
}
