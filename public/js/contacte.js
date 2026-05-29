/**
 * Front-end per enviar i emmagatzemar missatges des de la pàgina de contacte.
 */

document.addEventListener('DOMContentLoaded', () => {
    const formulari = document.getElementById('formulari-contacte');
    if (!formulari) return;

    formulari.addEventListener('submit', async (event) => {
        event.preventDefault();

        const nom = document.getElementById('cont-nom').value.trim();
        const email = document.getElementById('cont-email').value.trim();
        const missatge = document.getElementById('cont-missatge').value.trim();
        const output = document.getElementById('missatge-contacte');

        if (!nom || !email || !missatge) {
            mostrarMissatgeContacte('Completa tots els camps abans d\'enviar.', true);
            return;
        }

        if (!validarEmail(email)) {
            mostrarMissatgeContacte('Introdueix un correu electrònic vàlid.', true);
            return;
        }

        try {
            const resposta = await fetch('/index.php?url=api/contacte/enviar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nom, email, missatge })
            });

            const resultat = await resposta.json();
            if (!resposta.ok) {
                mostrarMissatgeContacte(resultat.error || 'Error en enviar el missatge.', true);
                return;
            }

            mostrarMissatgeContacte(resultat.missatge || 'Missatge enviat amb èxit.');
            formulari.reset();
        } catch (error) {
            console.error(error);
            mostrarMissatgeContacte('Error de connexió amb el servidor.', true);
        }
    });
});

function mostrarMissatgeContacte(text, esError = false) {
    const output = document.getElementById('missatge-contacte');
    if (!output) return;
    output.textContent = text;
    output.className = `missatge-alerta ${esError ? 'error-text' : 'exit-text'}`;
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
