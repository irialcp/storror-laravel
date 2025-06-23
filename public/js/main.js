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

    const logoutButton = document.getElementById('logout_button');
    const logoutButtonDesktop = document.getElementById('logout_button_desktop');

    [logoutButton, logoutButtonDesktop].forEach(button => {
        if (button) {
            button.addEventListener('click', async (event) => {
                event.preventDefault();

                try {
                    const response = await fetch('/logout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({})
                    });

                    if (response.redirected) {
                        window.location.href = response.url;
                    } else if (response.ok) {
                        const result = await response.json();
                        if (result.success) {
                            window.location.href = '/';
                        } else {
                            console.error('Errore durante il logout:', result.message || 'Errore sconosciuto.');
                            alert('Si è verificato un errore durante il logout: ' + (result.message || 'Errore sconosciuto.'));
                        }
                    } else {
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

    const chatButton = document.getElementById('chat_button');
    const chatContainer = document.getElementById('chat_container');
    const chatMessages = document.getElementById('chat_messages');
    const chatInput = document.getElementById('user_input');


    // Apertura e chiusura chat
    if (chatButton && chatContainer) {
        chatButton.addEventListener('click', () => {
            chatContainer.style.display = 'flex';
        });
    }

    // Invio con "Enter"
    if (chatInput) {
        chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }

    // Debug se elementi mancanti
    if (!chatButton || !chatContainer || !chatInput || !chatMessages) {
        console.warn("⚠️ Elementi della chat mancanti. Chat disabilitata.");
    }
    if (!chatContainer || !chatButton) return;

    const isClickInsideChat = chatContainer.contains(event.target);
    const isClickOnButton = chatButton.contains(event.target);

    if (chatContainer.style.display === 'flex' && !isClickInsideChat && !isClickOnButton) {
        chatContainer.style.display = 'none';
    }


    // Rendi la funzione globale perché usi `onclick="sendMessage()"` nell'HTML
    async function sendMessage() {
        const chatInput = document.getElementById('user_input');
        const chatMessages = document.getElementById('chat_messages');
        const message = chatInput.value.trim();

        if (!message) return;

        appendMessage('user', message);
        chatInput.value = '';

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/chatgpt-message', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(`Errore ${response.status}: ${errorData.error || response.statusText}`);
            }

            const data = await response.json();
            const botReply = data.reply || "Nessuna risposta ricevuta.";
            appendMessage('bot', botReply);

        } catch (error) {
            console.error("Errore nella comunicazione:", error);
            appendMessage('bot', `Errore: ${error.message}`);
        }
    }

    function appendMessage(sender, message) {
        const chatMessages = document.getElementById('chat_messages');
        const messageElement = document.createElement('div');
        messageElement.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    
});