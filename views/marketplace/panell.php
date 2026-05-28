<?php
/**
 * Vista: Panell Privat de l'Usuari Autenticat
 * Interfície operativa per afegir, visualitzar i suprimir elements excedents del propi usuari.
 */
?>
<section class="seccio-panell-privat">
    <div class="capcalera-panell">
        <h1>El Meu Panell de Gestió Circular</h1>
        <p>Benvingut/da, <strong id="nom-usuari-panell">...</strong>. Des d'aquí pots reintroduir materials al cicle de vida productiu.</p>
    </div>

    <div class="grid-panell-privat">
        
        <!-- Formulari del CRUD per afegir components al banc de dades NoSQL des de client -->
        <div class="caixa-formulari-crud">
            <h3>📥 Reintroduir un Component Excedent</h3>
            <form id="formulari-afegir-component" novalidate>
                <div class="grup-camp">
                    <label for="comp-titol">Títol del Component *</label>
                    <input type="text" id="comp-titol" required placeholder="Ex: Inversor Onda Pura 3000W">
                    <span class="error-validacio" id="error-comp-titol"></span>
                </div>

                <div class="grup-camp">
                    <label for="comp-categoria">Categoria de Material *</label>
                    <select id="comp-categoria" required>
                        <option value="1">Panells Solars</option>
                        <option value="2">Bateries i Acumuladors</option>
                        <option value="3">Inversors Elèctrics</option>
                        <option value="4">Eines de Diagnòstic</option>
                    </select>
                </div>

                <div class="grup-camp">
                    <label for="comp-tipus">Destinació Sostenible *</label>
                    <select id="comp-tipus" required>
                        <option value="intercanvi">Intercanvi lliure de components</option>
                        <option value="donacio">Donació altruista a entitats</option>
                        <option value="lloguer">Lloguer per evitar consum de material nou</option>
                    </select>
                </div>

                <div class="grup-camp">
                    <label for="comp-estat">Estat de Conservació *</label>
                    <select id="comp-estat" required>
                        <option value="nou-excedent">Nou (Excedent d'obra/instal·lació)</option>
                        <option value="usat">Usat (Totalment operatiu)</option>
                        <option value="reparat">Reparat / Recondicionat</option>
                    </select>
                </div>

                <div class="grup-camp">
                    <label for="comp-ubicacio">Ubicació Geogràfica *</label>
                    <input type="text" id="comp-ubicacio" required placeholder="Ex: Olot (Garrotxa)">
                    <span class="error-validacio" id="error-comp-ubicacio"></span>
                </div>

                <div class="grup-camp">
                    <label for="comp-descripcio">Descripció Tècnica del Recurs *</label>
                    <textarea id="comp-descripcio" required placeholder="Detalla la vida útil restant, rendiment o motiu del reciclatge..."></textarea>
                    <span class="error-validacio" id="error-comp-descripcio"></span>
                </div>

                <button type="submit" class="boto-principal">Publicar al Banc de Recursos</button>
            </form>
            <div id="missatge-servidor-crud" class="missatge-alerta"></div>
        </div>

        <!-- Llistat de control de materials propis de l'usuari connectat -->
        <div class="caixa-llistat-crud">
            <h3>📋 Els teus recursos publicats al catàleg</h3>
            <p class="consell-sostenible">Quan un element hagi estat lliurat o intercanviat, suprimeix-lo per tancar el flux del material.</p>
            
            <div id="llistat-recursos-propis" class="llistat-vertical-crud">
                <!-- S'omplirà de forma asíncrona mitjançant l'API de Node -->
                <p class="alerta-buida">No tens cap component registrat actualment sota el teu perfil.</p>
            </div>
        </div>

    </div>
</section>