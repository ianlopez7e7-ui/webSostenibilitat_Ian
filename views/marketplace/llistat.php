<?php
/**
 * Vista: Catàleg del Banc de Recursos i Marketplace Circular
 * Incorpora cercadors, filtres i ordenació requerits en servidor.
 */
?>
<section class="seccio-marketplace">
    <div class="capcalera-marketplace">
        <h1>Banc de Recursos: Economia Circular en l'ODS 7</h1>
        <p>Plataforma d'allargament del cicle de vida de components renovables. Evitem de forma real la generació d'e-waste.</p>
    </div>

    <!-- Barra d'Eines d'Alta Eficiència: Filtres de cerca i ordenació requerits -->
    <div class="barra-filtres-sostenible">
        <form id="formulari-filtres" class="grid-filtres">
            <div class="filtre-item">
                <label Brief for="filtre-cerca">Cerca de materials:</label>
                <input type="text" id="filtre-cerca" placeholder="Ex: Panell solar, bateria...">
            </div>

            <div class="filtre-item">
                <label for="filtre-categoria">Categoria:</label>
                <select id="filtre-categoria">
                    <option value="">-- Totes les categories --</option>
                    <option value="1">Panells Solars</option>
                    <option value="2">Bateries i Acumuladors</option>
                    <option value="3">Inversors Elèctrics</option>
                    <option value="4">Eines de Diagnòstic</option>
                </select>
            </div>

            <div class="filtre-item">
                <label for="filtre-tipus">Model Circular:</label>
                <select id="filtre-tipus">
                    <option value="">-- Tots els models --</option>
                    <option value="intercanvi">Intercanvi lliure</option>
                    <option value="donacio">Donació altruista</option>
                    <option value="lloguer">Lloguer temporal</option>
                </select>
            </div>

            <div class="filtre-item">
                <label for="filtre-ordre">Ordre alfabètic:</label>
                <select id="filtre-ordre">
                    <option value="asc">A - Z (Directe)</option>
                    <option value="desc">Z - A (Invers)</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Contenidor on s'injectaran de forma dinàmica les targetes mitjançant fetch() i el DOM -->
    <div class="contenidor-recursos-dinamics" id="graella-components">
        <div class="alerta-carrega">Carregant el banc de recursos circulars de forma asíncrona...</div>
    </div>
</section>