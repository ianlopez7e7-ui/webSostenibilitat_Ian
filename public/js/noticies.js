/**
 * Front-end CRUD per a la pàgina de notícies.
 * Carrega i gestiona notícies via API PHP.
 */

document.addEventListener('DOMContentLoaded', () => {
    const contenedor = document.getElementById('llistat-noticies');
    const formulariNoticia = document.getElementById('formulari-noticia');

    if (contenedor) {
        carregarNoticies();
    }

    if (formulariNoticia) {
        configurarFormulariNoticia();
    }
});

async function carregarNoticies() {
    const contenedor = document.getElementById('llistat-noticies');
    if (!contenedor) return;

    contenedor.innerHTML = '<p class="alerta-carrega">Carregant notícies...</p>';

    try {
        const resposta = await fetch('/index.php?url=api/noticies/llistar');
        if (!resposta.ok) throw new Error('Error en la resposta de l\'API');

        const noticies = await resposta.json();
        if (!Array.isArray(noticies) || noticies.length === 0) {
            contenedor.innerHTML = '<p class="alerta-buida">Encara no hi ha notícies disponibles.</p>';
            return;
        }

        contenedor.innerHTML = '';
        noticies.forEach(noticia => {
            const article = document.createElement('article');
            article.className = 'noticia';
            article.innerHTML = `
                <h3>${escapeHtml(noticia.titol)}</h3>
                <p class="meta-noticia"><strong>${escapeHtml(noticia.autor)}</strong> · ${escapeHtml(noticia.data_publicacio)}</p>
                <p>${escapeHtml(noticia.resum)}</p>
                <p>${escapeHtml(noticia.contingut)}</p>
                ${noticia.url ? `<a href="${escapeHtml(noticia.url)}" target="_blank" rel="noopener" class="boto-secundari">Més informació</a>` : ''}
                <div class="actions-noticia">
                    <button class="boto-secundari" onclick="editarNoticia(${noticia.id})">Editar</button>
                    <button class="boto-secundari alerta" onclick="esborrarNoticia(${noticia.id})">Suprimir</button>
                </div>
            `;
            contenedor.appendChild(article);
        });
    } catch (error) {
        console.error(error);
        contenedor.innerHTML = '<p class="error-validacio">No s\'ha pogut carregar el llistat de notícies. Torna-ho a intentar més tard.</p>';
    }
}

function configurarFormulariNoticia() {
    const formulari = document.getElementById('formulari-noticia');
    const botóEnviar = document.getElementById('boto-guardar-noticia');
    const campId = document.getElementById('noticia-id');

    formulari.addEventListener('submit', async (event) => {
        event.preventDefault();

        const titol = document.getElementById('noticia-titol').value.trim();
        const resum = document.getElementById('noticia-resum').value.trim();
        const contingut = document.getElementById('noticia-contingut').value.trim();
        const autor = document.getElementById('noticia-autor').value.trim();
        const url = document.getElementById('noticia-url').value.trim();
        const id = campId.value ? parseInt(campId.value, 10) : null;

        if (!titol || !resum || !contingut || !autor) {
            mostrarMissatgeNoticia('Completa tots els camps obligatoris.', true);
            return;
        }

        const dades = { titol, resum, contingut, autor, url };
        const endpoint = id ? '/index.php?url=api/noticies/actualitzar' : '/index.php?url=api/noticies/crear';
        if (id) dades.id = id;

        try {
            const resposta = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dades)
            });

            const resultat = await resposta.json();
            if (!resposta.ok) {
                mostrarMissatgeNoticia(resultat.error || 'No s\'ha pogut desar la notícia.', true);
                return;
            }

            mostrarMissatgeNoticia(id ? 'Notícia actualitzada correctament.' : 'Notícia publicada correctament.');
            formulari.reset();
            campId.value = '';
            botóEnviar.textContent = 'Publicar notícia';
            carregarNoticies();
        } catch (error) {
            console.error(error);
            mostrarMissatgeNoticia('Error de comunicació amb el servidor.', true);
        }
    });
}

function editarNoticia(id) {
    fetch('/index.php?url=api/noticies/llistar')
        .then(res => res.json())
        .then(noticies => {
            const noticia = noticies.find(item => item.id === id);
            if (!noticia) {
                alert('Notícia no trobada.');
                return;
            }

            document.getElementById('noticia-id').value = noticia.id;
            document.getElementById('noticia-titol').value = noticia.titol;
            document.getElementById('noticia-resum').value = noticia.resum;
            document.getElementById('noticia-contingut').value = noticia.contingut;
            document.getElementById('noticia-autor').value = noticia.autor;
            document.getElementById('noticia-url').value = noticia.url || '';
            document.getElementById('boto-guardar-noticia').textContent = 'Actualitzar notícia';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error(error);
            alert('Error en carregar la notícia per editar.');
        });
}

async function esborrarNoticia(id) {
    if (!confirm('Segur que vols suprimir aquesta notícia?')) return;

    try {
        const resposta = await fetch('/index.php?url=api/noticies/eliminar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });

        const resultat = await resposta.json();
        if (!resposta.ok) {
            alert(resultat.error || 'No s\'ha pogut suprimir la notícia.');
            return;
        }

        carregarNoticies();
        alert('Notícia suprimida correctament.');
    } catch (error) {
        console.error(error);
        alert('Error de connexió al suprimir la notícia.');
    }
}

function mostrarMissatgeNoticia(text, ésError = false) {
    const missatge = document.getElementById('missatge-noticies');
    if (!missatge) return;
    missatge.textContent = text;
    missatge.className = `missatge-alerta ${ésError ? 'error-text' : 'exit-text'}`;
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

window.editarNoticia = editarNoticia;
window.esborrarNoticia = esborrarNoticia;
