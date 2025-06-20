// public/js/login.js
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const loginMessage = document.getElementById('login-message');

    if (loginForm) {
        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            // Rimuovi la lettura del campo username
            // const username = loginForm.elements.username.value;
            const email = loginForm.elements.email.value;
            const password = loginForm.elements.password.value;

            loginMessage.textContent = '';
            loginMessage.style.color = 'red';

            try {
                const response = await fetch('/login', { // Assicurati che l'URL sia /login per la route Laravel
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        // Rimuovi l'invio del campo username
                        // username: username,
                        email: email,
                        password: password
                    })
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    loginMessage.textContent = result.message;
                    loginMessage.style.color = 'green';
                    window.location.href = 'shop'; 
                } else {
                    if (response.status === 422 && result.errors) {
                        let errorMessages = [];
                        for (const field in result.errors) {
                            errorMessages = errorMessages.concat(result.errors[field]);
                        }
                        loginMessage.textContent = errorMessages.join('\n');
                    } else {
                        loginMessage.textContent = result.message || 'Credenziali non valide.';
                    }
                }
            } catch (error) {
                console.error('Errore durante la richiesta di login:', error);
                loginMessage.textContent = 'Si è verificato un errore durante il login. Riprova.';
            }
        });
    }
});