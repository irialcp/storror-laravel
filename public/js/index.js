document.addEventListener('DOMContentLoaded', function() {
    loadCarouselContent();
    loadUnsplashImages();
    const overlay = document.querySelector(".overlay");
    const bottone = document.getElementById('image_button');
    const imageMenuWrap = document.querySelector("#parkour_images_menu");
    if (typeof closeOnClickOutside === 'function') { 
        closeOnClickOutside([bottone], imageMenuWrap, overlay);
    }
});

async function loadCarouselContent() {
    const carouselContainer = document.getElementById('dynamic-carousel');

    if (!carouselContainer) {
        console.warn("Element with ID 'dynamic-carousel' not found. Carousel content won't load.");
        return;
    }
    const apiUrl = '/api/carousel-items';

    try {
        const response = await fetch(apiUrl);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const carouselItems = await response.json();

        if (!Array.isArray(carouselItems) || carouselItems.length === 0) {
            console.warn("No carousel items received or data is empty.");
            carouselContainer.innerHTML = "<p style='text-align: center; color: #bbb;'>Nessun contenuto disponibile al momento.</p>";
            return;
        }

        let htmlContent = '';
        carouselItems.forEach(item => {
            // Assicurati che la tua colonna nel database sia 'image' e che contenga il percorso completo
            if (item.image) {
                // Se i percorsi delle immagini sono relativi e necessitano del base URL di Laravel,
                // potresti doverlo aggiungere qui, o assicurarti che il database contenga percorsi completi.
                // Es: `img src="/storage/${item.image}"` se le immagini sono in storage/app/public e linkate.
                // Per ora, assumiamo che `item.image` sia già un percorso URL valido.
                htmlContent += `
                    <div class="carousel-item"> <a href="{{ url('shop') }}" target="_blank" aria-label="Visita il prodotto">
                            <img src="${item.image}" alt="Immagine prodotto Storror">
                        </a>
                    </div>
                `;
            } else {
                console.warn("Carousel item has no image URL:", item);
            }
        });

        carouselContainer.innerHTML = htmlContent;

    } catch (error) {
        console.error('Errore durante il caricamento dei contenuti del carosello:', error);
        carouselContainer.innerHTML = "<p style='text-align: center; color: red;'>Impossibile caricare i contenuti. Riprova più tardi.</p>";
    }

    // Le funzioni relative ai pulsanti delle immagini parkour dovrebbero stare fuori da loadCarouselContent
    // se non dipendono dal caricamento del carosello principale. Le ho spostate un po'.
    // Visto che 'bottone' e 'imageMenuWrap' sono già fuori dalla async function loadCarouselContent
    // nel tuo JS originale, assicurati che siano accessibili nello scope corretto o passali come argomenti.

    const bottone = document.getElementById('image_button');
    const imageMenuWrap = document.querySelector("#parkour_images_menu");
    const overlay = document.querySelector(".overlay"); // Assicurati di avere un elemento con classe 'overlay' nel tuo HTML

    if (bottone && imageMenuWrap) { // Aggiunto controllo per null
        bottone.addEventListener('click', () => {
            imageMenuWrap.classList.toggle("active");
            if (overlay) {
                overlay.classList.toggle("active");
            }
            cercaImmaginiParkour();
        });
    }

    const closeButton = document.getElementById('close_button');
    if (closeButton) { // Aggiunto controllo per null
        closeButton.addEventListener('click', () => {
            imageMenuWrap.classList.remove("active");
            if (overlay) {
                overlay.classList.remove("active");
            }
        });
    }
}

async function cercaImmaginiParkour() {

    const container = document.getElementById('parkour_images');
    if (!container) {
        console.warn("Elemento con ID 'parkour_images' non trovato. Impossibile caricare immagini Unsplash.");
        return;
    }

    // Chiamata al tuo endpoint Laravel per Unsplash
    // Puoi passare la 'query' e 'per_page' come query parameters
    const apiEndpoint = '/api/unsplash-images?query=parkour&per_page=7';

    try {
        const response = await fetch(apiEndpoint);

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(`Server Error: ${response.status} - ${errorData.error || response.statusText}`);
        }

        const data = await response.json();

        container.innerHTML = '';

        if (data.results && Array.isArray(data.results)) {
            data.results.forEach(foto => {
                const img = document.createElement('img');
                img.src = foto.urls.small;
                img.alt = foto.alt_description;
                container.appendChild(img);
            });
        } else {
            console.warn("Nessun risultato 'results' trovato nella risposta Unsplash.");
            container.innerHTML = "<p style='text-align: center; color: #a0a0a0;'>Nessuna immagine trovata.</p>";
        }

    } catch (error) {
        console.error('Errore nel recupero immagini da Unsplash via Laravel:', error);
        container.innerHTML = "<p style='color: red;'>Errore nel caricamento delle immagini.</p>";
    }
}

// Assicurati che closeOnClickOutside sia definita o importata
function closeOnClickOutside(triggerElements, menuElement, overlayElement) {
    document.addEventListener('click', (event) => {
        const isClickInsideMenu = menuElement && menuElement.contains(event.target);
        const isClickOnTrigger = triggerElements.some(el => el && el.contains(event.target));

        if (!isClickInsideMenu && !isClickOnTrigger) {
            if (menuElement) {
                menuElement.classList.remove('active');
            }
            if (overlayElement) {
                overlayElement.classList.remove('active');
            }
        }
    });
}