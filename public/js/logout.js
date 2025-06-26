document.addEventListener("DOMContentLoaded", () => {
    const logoutIcon = document.getElementById("logout-icon");

    if (logoutIcon) {
        logoutIcon.addEventListener("click", async (event) => {
            event.preventDefault();

            try {
                const response = await fetch("/storror_clone/logout.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = "/storror_clone/index.php";
                } else {
                    console.error("Errore durante il logout:", result.message);
                    alert(
                        "Impossibile effettuare il logout: " + result.message
                    );

                    if (result.message === "Utente non autenticato") {
                        window.location.href = "/storror_clone/index.php";
                    }
                }
            } catch (error) {
                console.error("Errore di rete durante il logout:", error);
                alert("Si è verificato un errore di rete. Riprova più tardi.");
            }
        });
    }
});
