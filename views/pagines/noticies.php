<?php /** Vista: Notícies i Novetats sobre Energies Renovables i Economia Circular */ ?>
<section class="seccio-noticies">
    <div class="capcalera-noticies">
        <h1>Notícies i Resums Externs</h1>
        <p>Aquest espai recull notícies, textos i recursos sobre energia renovable, economia circular i iniciatives ODS.</p>
    </div>

    <div class="grid-noticies">
        <div class="noticies-llista">
            <h2>Notícies publicades</h2>
            <div id="llistat-noticies">
                <p class="alerta-carrega">Carregant notícies...</p>
            </div>
        </div>

        <aside class="noticies-admin">
            <h2>Gestiona les notícies</h2>
            <p>Afegeix, edita o suprimeix entrades de notícies. Aquest CRUD utilitza la base de dades local SQLite.</p>
            <form id="formulari-noticia" class="formulari-crud-noticia" novalidate>
                <input type="hidden" id="noticia-id" value="">

                <label for="noticia-titol">Títol *</label>
                <input type="text" id="noticia-titol" placeholder="Títol de la notícia" required>

                <label for="noticia-resum">Resum breu *</label>
                <textarea id="noticia-resum" placeholder="Descripció curta" required></textarea>

                <label for="noticia-contingut">Contingut complet *</label>
                <textarea id="noticia-contingut" placeholder="Contingut de la notícia" required></textarea>

                <label for="noticia-autor">Autor *</label>
                <input type="text" id="noticia-autor" placeholder="Nom de l'autor" required>

                <label for="noticia-url">Enllaç extern (opcional)</label>
                <input type="url" id="noticia-url" placeholder="https://...">

                <button type="submit" id="boto-guardar-noticia" class="boto-principal">Publicar notícia</button>
                <div id="missatge-noticies" class="missatge-alerta"></div>
            </form>
        </aside>
    </div>
</section>
