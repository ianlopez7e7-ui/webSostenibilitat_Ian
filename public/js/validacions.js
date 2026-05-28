/**
 * Script de Front-end: Validacions de Formularis, DOM i Eficiència Energètica
 * Cobreix el RA7 (Interació DOM) i el RA5 (Mode Fosc per a pantalles OLED).
 */

document.addEventListener('DOMContentLoaded', () => {
    inicialitzarModeFosc();
    inicialitzarEstructuraNavbar();
    configurarValidacionsAutenticacio();
    configurarValidacionsCRUD();
});

/**
 * RA5: Gestió del Mode Fosc per a l'estalvi d'energia en pantalles
 */
function inicialitzarModeFosc() {
    const botoAlternador = document.getElementById('alternador-mode');
    if (!botoAlternador) return;

    botoAlternador.addEventListener('click', (e) => {
        e.preventDefault();
        document.documentElement.classList.toggle('dark-mode');
        
        if (document.documentElement.classList.contains('dark-mode')) {
            localStorage.setItem('mode-fosc', 'activat');
            botoAlternador.textContent = '☀️ Mode';
        } else {
            localStorage.setItem('mode-fosc', 'desactivat');
            botoAlternador.textContent = '🌙 Mode';
        }
    });

    // Sincronitzar el text del botó segons l'estat actual cargolat inline al header
    if (document.documentElement.classList.contains('dark-mode')) {
        botoAlternador.textContent = '☀️ Mode';
    }
}

/**
 * Modifica dinàmicament els elements de la Navbar segons si l'usuari està logat
 */
function inicialitzarEstructuraNavbar() {
    const token = localStorage.getItem('jwt_token');
    const rutesProtegides = document.querySelectorAll('.ruta-protegida');
    const enllacComunitat = document.getElementById('enllac-comunitat');
    const botoSortir = document.getElementById('boto-sortir');

            if (token) {
        // Usuari autenticat: Mostrem opcions privades i botó de tancar sessió
        rutesProtegides.forEach(el => el.style.display = 'inline-block');
        if (botoSortir) botoSortir.style.display = 'inline-block';
        if (enllacComunitat) {
            const nomUsuari = localStorage.getItem('usuari_nom') || 'Perfil';
                    enllacComunitat.textContent = `👤 ${nomUsuari}`;
                    enllacComunitat.href = '/index.php?url=marketplace/panell';
        }
    }

    if (botoSortir) {
        botoSortir.addEventListener('click', (e) => {
            e.preventDefault();
            localStorage.clear();
            window.location.href = '/index.php?url=inici';
        });
    }
}

/**
 * Validacions estructurals per als formularis de Login i Registre
 */
function configurarValidacionsAutenticacio() {
    const formLogin = document.getElementById('formulari-login');
    const formRegistre = document.getElementById('formulari-registre');

    if (formLogin) {
        formLogin.addEventListener('submit', (e) => {
            const email = document.getElementById('login-email').value.trim();
            const pass = document.getElementById('login-pass').value.trim();
            let valid = true;

            document.getElementById('error-login-email').textContent = '';
            document.getElementById('error-login-pass').textContent = '';

            if (!validarEmail(email)) {
                document.getElementById('error-login-email').textContent = 'Introdueix un correu electrònic vàlid.';
                valid = false;
            }
            if (pass.length < 4) {
                document.getElementById('error-login-pass').textContent = 'La contrasenya no pot estar buida.';
                valid = false;
            }

            if (!valid) e.preventDefault(); // Atura l'enviament si falla la validació
        });
    }

    if (formRegistre) {
        formRegistre.addEventListener('submit', (e) => {
            const nom = document.getElementById('registre-nom').value.trim();
            const email = document.getElementById('registre-email').value.trim();
            const pass = document.getElementById('registre-pass').value.trim();
            let valid = true;

            document.getElementById('error-registre-nom').textContent = '';
            document.getElementById('error-registre-email').textContent = '';
            document.getElementById('error-registre-pass').textContent = '';

            if (nom.length < 3) {
                document.getElementById('error-registre-nom').textContent = 'El nom ha de tenir com a mínim 3 caràcters.';
                valid = false;
            }
            if (!validarEmail(email)) {
                document.getElementById('error-registre-email').textContent = 'El format del correu no és correcte.';
                valid = false;
            }
            if (pass.length < 8) {
                document.getElementById('error-registre-pass').textContent = 'La contrasenya ha de tenir un mínim de 8 caràcters per seguretat.';
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    }
}

/**
 * Validacions del formulari d'inserció de components al Marketplace
 */
function configurarValidacionsCRUD() {
    const formCRUD = document.getElementById('formulari-afegir-component');
    if (!formCRUD) return;

    formCRUD.addEventListener('submit', (e) => {
        const titol = document.getElementById('comp-titol').value.trim();
        const ubicacio = document.getElementById('comp-ubicacio').value.trim();
        const descripcio = document.getElementById('comp-descripcio').value.trim();
        let valid = true;

        document.getElementById('error-comp-titol').textContent = '';
        document.getElementById('error-comp-ubicacio').textContent = '';
        document.getElementById('error-comp-descripcio').textContent = '';

        if (titol.length < 5) {
            document.getElementById('error-comp-titol').textContent = 'El títol del component ha de ser descriptiu (mínim 5 caràcters).';
            valid = false;
        }
        if (ubicacio.length < 3) {
            document.getElementById('error-comp-ubicacio').textContent = 'Indica una població o comarca vàlida.';
            valid = false;
        }
        if (descripcio.length < 15) {
            document.getElementById('error-comp-descripcio').textContent = 'Afegeix especificacions de vida útil o estat (mínim 15 caràcters).';
            valid = false;
        }

        if (!valid) e.preventDefault();
    });
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}