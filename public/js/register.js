// public/js/register.js
document.addEventListener('DOMContentLoaded', () => {
    const registerForm = document.getElementById('register-form');
    const registrationStatusMessage = document.getElementById('registration-status-message');

    if (registerForm) {
        registerForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            // CAMBIATO DA 'username' A 'name'
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;

            if (registrationStatusMessage) {
                registrationStatusMessage.textContent = '';
                registrationStatusMessage.style.color = '';
            } else {
                console.error("Errore: Elemento con ID 'registration-status-message' non trovato nel DOM.");
                return;
            }

            if (password !== confirm_password) {
                registrationStatusMessage.textContent = 'Le password non corrispondono.';
                registrationStatusMessage.style.color = 'red';
                return;
            }
            if (password.length < 8) {
                registrationStatusMessage.textContent = 'La password deve essere lunga almeno 8 caratteri.';
                registrationStatusMessage.style.color = 'red';
                return;
            }
            if (!/[A-Z]/.test(password) || !/[0-9]/.test(password)) {
                registrationStatusMessage.textContent = 'La password deve contenere almeno una maiuscola e un numero.';
                registrationStatusMessage.style.color = 'red';
                return;
            }

            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: name,
                        email: email,
                        password: password,
                        confirm_password: confirm_password
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Errore HTTP:', response.status, errorData);

                    if (response.status === 422 && errorData.errors) {
                        let messages = [];
                        for (const field in errorData.errors) {
                            messages = messages.concat(errorData.errors[field]);
                        }
                        registrationStatusMessage.textContent = messages.join('\n');
                    } else {
                        registrationStatusMessage.textContent = errorData.message || 'Si è verificato un errore del server. Riprova più tardi.';
                    }
                    registrationStatusMessage.style.color = 'red';
                    return;
                }

                const result = await response.json();

                if (result.success) {
                    registrationStatusMessage.textContent = result.message;
                    registrationStatusMessage.style.color = 'green';
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1000);
                    registerForm.reset();
                } else {
                    registrationStatusMessage.textContent = result.message;
                    registrationStatusMessage.style.color = 'red';
                }
            } catch (error) {
                console.error('Errore durante la registrazione (catch generale):', error);
                registrationStatusMessage.textContent = 'Si è verificato un errore di rete o di elaborazione. Riprova più tardi.';
                registrationStatusMessage.style.color = 'red';
            }
        });
    }
});