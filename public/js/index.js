document.addEventListener("DOMContentLoaded", function () {
    loadCarouselContent();
    loadUnsplashImages(); // Chiamiamo questa funzione all'avvio
    const overlay = document.querySelector(".overlay");
    const bottone = document.getElementById("image_button");
    const imageMenuWrap = document.querySelector("#parkour_images_menu");

    if (bottone && imageMenuWrap && overlay) {
        // Aggiunto controllo per assicurare che gli elementi esistano
        bottone.addEventListener("click", () => {
            imageMenuWrap.classList.toggle("active");
            overlay.classList.toggle("active");
            // Non chiamare loadUnsplashImages qui, lo facciamo una volta all'avvio
            // o potresti chiamarlo qui se vuoi ricaricare le immagini ogni volta che apri
            // In questo caso, lo manteniamo all'avavvio per evitare chiamate ripetute se non necessario.
        });

        // Aggiungi un listener per il bottone di chiusura
        const closeButton = document.getElementById("close_button");
        if (closeButton) {
            closeButton.addEventListener("click", () => {
                imageMenuWrap.classList.remove("active");
                overlay.classList.remove("active");
            });
        }
    } else {
        console.warn(
            "Alcuni elementi per la gestione delle immagini Parkour non sono stati trovati (bottone, menu o overlay)."
        );
    }

    if (typeof closeOnClickOutside === "function") {
        closeOnClickOutside([bottone], imageMenuWrap, overlay);
    }
});

async function loadCarouselContent() {
    const carouselContainer = document.getElementById("dynamic-carousel");

    if (!carouselContainer) {
        console.warn(
            "Element with ID 'dynamic-carousel' not found. Carousel content won't load."
        );
        return;
    }

    // URL corretto per l'API Laravel del carosello
    const apiUrl = "/api/carousel-items";

    try {
        const response = await fetch(apiUrl);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const carouselItems = await response.json();

        if (!Array.isArray(carouselItems) || carouselItems.length === 0) {
            console.warn("No carousel items received or data is empty.");
            carouselContainer.innerHTML =
                "<p style='text-align: center; color: #bbb;'>Nessun contenuto disponibile al momento.</p>";
            return;
        }

        // Crea un singolo container con tutte le immagini
        let imagesContent = "";
        carouselItems.forEach((item) => {
            if (item.image) {
                imagesContent += `
                    <a href="${
                        item.product_url || "/shop"
                    }" aria-label="Visita il prodotto">
                        <img src="${
                            item.image
                        }" alt="Immagine prodotto Storror">
                    </a>
                `;
            } else {
                console.warn("Carousel item has no image URL:", item);
            }
        });

        // Crea il container principale con tutte le immagini
        const htmlContent = `<div class="carousel-container">${imagesContent}</div>`;

        carouselContainer.innerHTML = htmlContent;
        carouselContainer.style.display = "none";
        carouselContainer.offsetHeight; // trigger reflow
        carouselContainer.style.display = "block";

        // Aggiungi la classe responsive al container del carousel
        const container = document.querySelector(".carousel-container");
        if (container) {
            container.classList.add("responsive-carousel");
            console.log("Classe responsive-carousel aggiunta al container");
        }
    } catch (error) {
        console.error(
            "Errore durante il caricamento dei contenuti del carosello:",
            error
        );
        carouselContainer.innerHTML =
            "<p style='text-align: center; color: red;'>Impossibile caricare i contenuti. Riprova più tardi.</p>";
    }
}

// Funzione per gestire il comportamento responsive quando necessario
function handleResponsiveCarousel() {
    const container = document.querySelector(
        ".carousel-container.responsive-carousel"
    );

    if (!container) return;

    // Rimuovi eventuali stili inline che potrebbero interferire
    if (window.innerWidth <= 1024) {
        container.removeAttribute("style");

        const images = container.querySelectorAll("img");
        const links = container.querySelectorAll("a");

        images.forEach((img) => img.removeAttribute("style"));
        links.forEach((link) => link.removeAttribute("style"));

        console.log(
            "Stili inline rimossi per permettere al CSS responsive di funzionare"
        );
    }
}

// Funzione debounce per ottimizzare le performance durante il resize
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Gestisce il resize della finestra
window.addEventListener("resize", debounce(handleResponsiveCarousel, 250));

// Carica il carousel al caricamento della pagina
document.addEventListener("DOMContentLoaded", function () {
    loadCarouselContent();
});

// Esporta le funzioni per uso manuale se necessario
window.handleResponsiveCarousel = handleResponsiveCarousel;
window.loadCarouselContent = loadCarouselContent;

// *** NUOVA/MODIFICATA FUNZIONE per caricare le immagini Unsplash dal backend Laravel ***
async function loadUnsplashImages() {
    const container = document.getElementById("parkour_images");
    if (!container) {
        console.warn(
            "Element with ID 'parkour_images' not found. Unsplash images won't load."
        );
        return;
    }

    // URL per l'API Laravel che farà la chiamata a Unsplash
    // Puoi passare 'query' e 'per_page' se vuoi che Laravel li usi
    const apiUrl = "/api/unsplash-images?query=parkour&per_page=7"; // Ho mantenuto 7 come nel tuo errore originale

    try {
        const response = await fetch(apiUrl);

        if (!response.ok) {
            // Se la risposta non è OK, prova a leggere il testo per debug
            const errorText = await response.text();
            throw new Error(
                `HTTP error! status: ${response.status}. Dettagli: ${errorText}`
            );
        }

        const data = await response.json();

        // Controlla se la risposta del tuo backend è come te l'aspetti (dovrebbe essere la stessa di Unsplash)
        if (!data || !Array.isArray(data.results)) {
            console.warn(
                "Struttura dati inattesa dalla tua API Laravel (Unsplash):",
                data
            );
            container.innerHTML =
                "<p style='text-align: center; color: #a0a0a0;'>Struttura dati inattesa.</p>";
            return;
        }

        container.innerHTML = ""; // Pulisce il contenitore

        data.results.forEach((foto) => {
            const img = document.createElement("img");
            img.src = foto.urls.small;
            img.alt = foto.alt_description;
            container.appendChild(img);
        });
    } catch (error) {
        console.error(
            "Errore nel recupero immagini da Unsplash via Laravel:",
            error
        );
        container.innerHTML =
            "<p style='color: red;'>Errore nel caricamento delle immagini Unsplash. Riprova più tardi.</p>";
    }
}

// Assicurati che closeOnClickOutside sia definita o importata
function closeOnClickOutside(triggerElements, menuElement, overlayElement) {
    document.addEventListener("click", (event) => {
        const isClickInsideMenu =
            menuElement && menuElement.contains(event.target);
        const isClickOnTrigger = triggerElements.some(
            (el) => el && el.contains(event.target)
        );

        if (!isClickInsideMenu && !isClickOnTrigger) {
            if (menuElement) {
                menuElement.classList.remove("active");
            }
            if (overlayElement) {
                overlayElement.classList.remove("active");
            }
        }
    });
}
