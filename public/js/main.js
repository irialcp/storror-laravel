document.addEventListener('DOMContentLoaded', () => {

    let lastScroll = 0;
    const header = document.querySelector("#header");
    const scrollThreshold = 10;
    let ticking = false; 

    if (header) {
        window.addEventListener("scroll", function() {
            if(!ticking){
                window.requestAnimationFrame(function() {
                    const currentScroll = window.scrollY;
                    const headerHeight = header.offsetHeight; 

                    if (currentScroll < lastScroll && currentScroll > scrollThreshold) {
                        header.style.top = "0";
                    } else if (currentScroll > lastScroll && currentScroll > headerHeight) {
                        header.style.top = `-${headerHeight}px`;
                    }

                    if (currentScroll < scrollThreshold) {
                        header.style.top = "0";
                    }

                    lastScroll = currentScroll;
                    ticking = false;
                });
                ticking = true;
            }
        });
    } else {
        console.warn("Elemento #header non trovato. La funzionalità di scroll dell'header non sarà attiva.");
    }

    const logoutButton = document.getElementById('logout_button');
    const logoutButtonDesktop = document.getElementById('logout_button_desktop');

    [logoutButton, logoutButtonDesktop].forEach(button => {
        if (button) {
            button.addEventListener('click', async (event) => {
                event.preventDefault();

                try {
                    const response = await fetch('/logout', { // Usa /logout per percorso assoluto
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            // *** DEVI RI-AGGIUNGERE QUESTO! ***
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({}) // Corpo vuoto necessario per Content-Type: application/json
                    });

                    // Se il backend fa un reindirizzamento, non c'è bisogno di parsare JSON
                    if (response.redirected) {
                        // La richiesta è stata reindirizzata, significa che il logout è avvenuto con successo
                        // Il browser ha già seguito il reindirizzamento alla pagina 'home'
                        // Non fare nulla qui o reindirizza esplicitamente se vuoi controllare il flow
                        window.location.href = response.url; // Ti reindirizza all'URL finale del redirect
                    } else if (response.ok) {
                        // Questo blocco verrebbe eseguito se il logout restituisse JSON anziché un redirect
                        // Se non ti aspetti JSON, puoi rimuovere il tentativo di parsing
                        const result = await response.json(); // Tenta di parsare solo se non c'è redirect
                        if (result.success) {
                            window.location.href = '/'; // O a 'home' se Laravel reindirizza a '/' per default
                        } else {
                            console.error('Errore durante il logout:', result.message || 'Errore sconosciuto.');
                            alert('Si è verificato un errore durante il logout: ' + (result.message || 'Errore sconosciuto.'));
                        }
                    } else {
                        // Gestisci altri errori HTTP se la risposta non è OK e non è un redirect
                        const errorText = await response.text();
                        console.error('Errore HTTP durante il logout:', response.status, errorText);
                        alert('Si è verificato un errore durante il logout: ' + errorText);
                    }
                } catch (error) {
                    console.error('Errore di rete o di elaborazione durante il logout:', error);
                    alert('Si è verificato un errore di rete o di elaborazione. Riprova più tardi.');
                }
            });
        }
    });


    const menuButton = document.querySelector("#menu_button");
    const menuWrap = document.querySelector("#wrapper");
    const menuClose = document.querySelector("#close");
    const overlay = document.querySelector(".overlay");

    function openMenu() {
        if (menuWrap) menuWrap.classList.add("active");
        if (overlay) overlay.classList.add("active");
    }

    function closeMenu() {
        if (menuWrap) menuWrap.classList.remove("active");
        if (overlay) overlay.classList.remove("active");
    }

    if (menuButton) {
        menuButton.addEventListener("click", openMenu);
    }

    if (menuClose) {
        menuClose.addEventListener("click", closeMenu);
    }

    if (overlay) {
        overlay.addEventListener("click", closeMenu);
    }

    const imageButton = document.getElementById('image_button');
    const parkourImagesMenu = document.querySelector("#parkour_images_menu");
    const UNSPLASH_KEY = "YOUR_UNSPLASH_API_KEY_HERE";

    if (imageButton && parkourImagesMenu && overlay) {
        imageButton.addEventListener('click', () => {
            parkourImagesMenu.classList.add("active");
            overlay.classList.add("active");
            cercaImmaginiParkour();
        });

        overlay.addEventListener('click', () => {
            if (parkourImagesMenu.classList.contains('active')) {
                parkourImagesMenu.classList.remove('active');
                overlay.classList.remove('active');
            }
        });
    } else {
        
    } 

    const chatButton = document.querySelector("#chat_button");
    const chatContainer = document.querySelector("#chat_container");
    const chatInput = document.getElementById('chat_input');
    const chatSendButton = document.getElementById('chat_send_button');
    const chatMessages = document.getElementById('chat_messages');
    const CHATGPT_API_KEY = 'YOUR_CHATGPT_API_KEY_HERE';

    if (chatButton && chatContainer && overlay) {
        chatButton.addEventListener('click', () => {
            chatContainer.classList.add("active");
            overlay.classList.add("active");
        });

        overlay.addEventListener('click', () => {
            if (chatContainer.classList.contains('active')) {
                chatContainer.classList.remove('active');
                overlay.classList.remove('active');
            }
        });

        if (chatInput && chatSendButton && chatMessages) {
            chatSendButton.addEventListener('click', sendMessage);
            chatInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });
        }
    } else {
        console.warn("Elementi per la chat (chat_button, chat_container) non trovati. Funzionalità chat limitata.");
    }

    function appendMessage(sender, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('chat-message', sender);
        messageElement.textContent = message;
        if (chatMessages) {
            chatMessages.appendChild(messageElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }

    async function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        appendMessage('user', message);
        chatInput.value = '';

        if (CHATGPT_API_KEY === "YOUR_CHATGPT_API_KEY_HERE") {
            appendMessage('bot', "ATTENZIONE: Chiave API ChatGPT non configurata. Non posso rispondere.");
            console.error("ATTENZIONE: Chiave API ChatGPT non configurata.");
            return;
        }

        try {
            const response = await fetch('https://api.openai.com/v1/chat/completions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${CHATGPT_API_KEY}`
                },
                body: JSON.stringify({
                    model: "gpt-3.5-turbo",
                    messages: [{ role: "user", content: message }],
                    max_tokens: 150
                })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(`API Error: ${response.status} - ${errorData.error.message}`);
            }

            const data = await response.json();
            const botReply = data.choices[0].message.content;
            appendMessage('bot', botReply);

        } catch (error) {
            console.error("Errore API ChatGPT:", error);
            appendMessage('bot', `Errore nella chiamata API: ${error.message}. Riprova più tardi.`);
        }
    }
});