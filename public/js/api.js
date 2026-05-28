/**
 * Script de Front-end: Consum de l'API REST de forma asíncrona
 * Cobreix el RA7 (Mètode fetch, Async/Await i tractament de promeses).
 */

document.addEventListener('DOMContentLoaded', () => {
    // Detectar de forma automàtica quina pàgina de l'arquitectura estem visitant
    const graellaComponents = document.getElementById('graella-components');
    const panellPrivat = document.getElementById('llistat-recursos-propis');
    
    if (graellaComponents) {
        carregarCatalegPublic();
        configurarEsdevenimentsFiltres();
    }
    
    if (panellPrivat) {
        configurarFluxPanellPrivat();
    }

    configurarPeticionsFormularis();
});

/**
 * Operació READ asíncrona: Llista i renderitza el catàleg públic aplicant filtres
 */
async function carregarCatalegPublic() {
    const graella = document.getElementById('graella-components');
    if (!graella) return;

    // Obtenir paràmetres actius de la barra de filtres en pantalla
    const cerca = document.getElementById('filtre-cerca').value;
    const categoria = document.getElementById('filtre-categoria').value;
    const tipus = document.getElementById('filtre-tipus').value;
    const ordre = document.getElementById('filtre-ordre').value;

    const urlParams = new URLSearchParams({ cerca, categoria_id: categoria, tipus, ordre });

    try {
        // Crida de xarxa asíncrona neta cap al Front Controller de PHP
        const resposta = await fetch(`/api/components/llistar?${urlParams.toString()}`);
        
        if (!resposta.ok) throw new Error('Error en la resposta de la xarxa.');
        
        const components = await resposta.json();
        
        // Netejar el node del DOM per evitar acumulacions ineficients (RA5)
        graella.innerHTML = '';

        if (components.length === 0) {
            graella.innerHTML = '<p class="alerta-buida">No s\'ha trobat cap component excedent que coincideixi amb els criteris.</p>';
            return;
        }

        // Construcció del DOM dinàmic mitjançant fragments estructurals
        components.forEach(comp => {
            const targeta = document.createElement('div');
            targeta.className = `targeta-recurs circular-${comp.tipus}`;
            targeta.innerHTML = `
                <div class="capsula-tipus">${comp.tipus.toUpperCase()}</div>
                <h3>${comp.titol}</h3>
                <p class="desc-comp">${comp.descripcio}</p>
                <div class="detalls-comp-linia">
                    <span>📍 <strong>Ubicació:</strong> ${comp.ubicacio}</span>
                    <span>⚙️ <strong>Estat:</strong> ${comp.estat}</span>
                </div>
                <button class="boto-secundari" onclick="alert('Inicia sessió o registra\\'t per visualitzar el contacte amb el cedent de l\\'objecte.')">Contactar</button>
            `;
            graella.appendChild(targeta);
        });

    } catch (error) {
        console.error('Error asíncron:', error);
        graella.innerHTML = '<p class="error-validacio">No s\'ha pogut sincronitzar el banc de recursos. Comprova que l\'API de Node està oberta.</p>';
    }
}

/**
 * Escolta canvis en els inputs de filtres per refrescar el DOM a temps real sense recarregar la pàgina
 */
function configurarEsdevenimentsFiltres() {
    const formFiltres = document.getElementById('formulari-filtres');
    if (!formFiltres) return;

    // Escoltador general d'esdeveniments sobre els camps selectors de la barra
    formFiltres.addEventListener('input', () => {
        carregarCatalegPublic();
    });
}

/**
 * Envia de forma asíncrona les dades dels formularis d'accés (JWT) i CRUD
 */
function configurarPeticionsFormularis() {
    const formLogin = document.getElementById('formulari-login');
    const formRegistre = document.getElementById('formulari-registre');

    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const contrasenya = document.getElementById('login-pass').value;
            const missatgeServidor = document.getElementById('missatge-servidor-login');

            try {
                const resposta = await fetch('/api/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, contrasenya })
                });

                const resultat = await resposta.json();

                if (resposta.ok) {
                    // Desem el token JWT rebut i metadades al magatzem local del navegador de manera persistent
                    localStorage.setItem('jwt_token', resultat.token);
                    localStorage.setItem('usuari_nom', resultat.usuari.nom);
                    localStorage.setItem('usuari_rol', resultat.usuari.rol);
                    
                    window.location.href = '/marketplace/panell';
                } else {
                    missatgeServidor.className = "missatge-alerta error-text";
                    missatgeServidor.textContent = resultat.error || 'Error d\'accés.';
                }
            } catch (error) {
                missatgeServidor.textContent = 'Error de connexió de xarxa.';
            }
        });
    }

    if (formRegistre) {
        formRegistre.addEventListener('submit', async (e) => {
            e.preventDefault();
            const nom = document.getElementById('registre-nom').value;
            const email = document.getElementById('registre-email').value;
            const contrasenya = document.getElementById('registre-pass').value;
            const missatgeServidor = document.getElementById('missatge-servidor-registre');

            try {
                const resposta = await fetch('/api/registre', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nom, email, contrasenya })
                });

                const resultat = await resposta.json();

                if (resposta.ok) {
                    missatgeServidor.className = "missatge-alerta exit-text";
                    missatgeServidor.textContent = resultat.missatge + " Ara ja pots iniciar sessió.";
                    formRegistre.reset();
                } else {
                    missatgeServidor.className = "missatge-alerta error-text";
                    missatgeServidor.textContent = resultat.error || 'Error de registre.';
                }
            } catch (error) {
                missatgeServidor.textContent = 'Error crític del servidor.';
            }
        });
    }
}

/**
 * Operacions completes de CREATE i DELETE per a l'espai privat de dades de l'usuari
 */
function configurarFluxPanellPrivat() {
    const nomPanell = document.getElementById('nom-usuari-panell');
    if (nomPanell) nomPanell.textContent = localStorage.getItem('usuari_nom') || 'Usuari';

    const formAfegir = document.getElementById('formulari-afegir-component');
    
    // Carregar només els propis materials quan s'obre el panell
    llistarMaterialsPropis();

    if (formAfegir) {
        formAfegir.addEventListener('submit', async (e) => {
            e.preventDefault();
            const token = localStorage.getItem('jwt_token');
            const missatgeServidor = document.getElementById('missatge-servidor-crud');

            const dades = {
                titol: document.getElementById('comp-titol').value,
                categoria_id: parseInt(document.getElementById('comp-categoria').value),
                tipus: document.getElementById('comp-tipus').value,
                estat: document.getElementById('comp-estat').value,
                ubicacio: document.getElementById('comp-ubicacio').value,
                descripcio: document.getElementById('comp-descripcio').value
            };

            try {
                // POST Asíncron: Creació de recurs passant el token JWT a la capçalera
                const resposta = await fetch('/api/components/crear', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify(dades)
                });

                if (resposta.ok) {
                    missatgeServidor.className = "missatge-alerta exit-text";
                    missatgeServidor.textContent = "Component reintroduït amb èxit al cicle de vida circular.";
                    formAfegir.reset();
                    llistarMaterialsPropis(); // Refrescar el llistat dinàmicament
                } else {
                    const err = await resposta.json();
                    missatgeServidor.className = "missatge-alerta error-text";
                    missatgeServidor.textContent = err.error || 'Error en desar.';
                }
            } catch (error) {
                missatgeServidor.className = "missatge-alerta error-text";
                missatgeServidor.textContent = 'Error de comunicació asíncrona.';
            }
        });
    }
}

/**
 * Operació READ per a l'espai privat: Llistat de materials particulars actius
 */
async function llistarMaterialsPropis() {
    const contenidor = document.getElementById('llistat-recursos-propis');
    if (!contenidor) return;

    try {
        const resposta = await fetch('/api/components/llistar');
        
        if (!resposta.ok) throw new Error('Error de xarxa en obtenir els materials.');
        
        const tots = await resposta.json();
        
        // Netejar el contenidor del DOM abans de renderitzar (RA5)
        contenidor.innerHTML = '';

        if (tots.length === 0) {
            contenidor.innerHTML = '<p class="alerta-buida">No has publicat cap excedent encara.</p>';
            return;
        }

        // Renderitzat dinàmic dels elements al panell privat de l'usuari
        tots.forEach(comp => {
            const item = document.createElement('div');
            item.className = 'item-panell-recurs';
            item.innerHTML = `
                <div class="informacio-recurs-propi">
                    <strong>${comp.titol}</strong> <span class="etiqueta-tipus-petita">(${comp.tipus})</span>
                    <p style="margin:4px 0 0 0; font-size:12px; color:gray;">📍 ${comp.ubicacio}</p>
                </div>
                <button class="boto-eliminar" onclick="eliminarRecursDelBanc(${comp.id})">Retirar / Reciclat</button>
            `;
            contenidor.appendChild(item);
        });

    } catch (error) {
        console.error('Error asíncron:', error);
        contenidor.innerHTML = '<p class="error-validacio">Error en sincronitzar els teus elements personals.</p>';
    }
}

/**
 * Operació DELETE asíncrona: Retira un component passant el token JWT a la capçalera HTTP
 */
async function eliminarRecursDelBanc(id) {
    if (!confirm('Segur que vols retirar aquest element del banc de recursos circular?')) return;
    
    const token = localStorage.getItem('jwt_token');

    try {
        // DELETE Asíncron: Eliminació del recurs protegit per l'API del servidor PHP
        const resposta = await fetch(`/api/components/eliminar?id=${id}`, {
            method: 'DELETE',
            headers: { 
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (resposta.ok) {
            alert('Component retirat correctament del mercat circular.');
            llistarMaterialsPropis(); // Refresca el llistat immediatament sense recarregar la pàgina (UI/UX)
        } else {
            const err = await resposta.json();
            alert(err.error || 'No s\'ha pogut completar l\'acció d\'esborrat.');
        }
    } catch (error) {
        alert('Error de connexió de xarxa asíncrona en intentar esborrar.');
    }
}

// Fem la funció accessible a nivell de finestra (window) 
// Això permet que el listener 'onclick' inserit dinàmicament al codi HTML la pugui invocar sense problemes.
window.eliminarRecursDelBanc = eliminarRecursDelBanc;