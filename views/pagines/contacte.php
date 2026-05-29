<!-- Vista de Contacte i Aliances -->
<section class="seccio-contacte">
    <div class="capcalera-contacte">
        <h1>Xarxa de Col·laboració i Aliances Sostenibles</h1>
        <p>Forma part del node per a la reducció de residus elèctrics (e-waste) connectant entitats i desenvolupadors.</p>
    </div>

    <form id="formulari-contacte" class="caixa-formulari-crud">
        <div class="grup-camp">
            <label for="cont-nom">Nom o Entitat</label>
            <input type="text" id="cont-nom" required placeholder="Escriu el teu nom o organització">
        </div>

        <div class="grup-camp">
            <label for="cont-email">Correu electrònic</label>
            <input type="email" id="cont-email" required placeholder="exemple@domini.org">
        </div>

        <div class="grup-camp">
            <label for="cont-missatge">Proposta de col·laboració</label>
            <textarea id="cont-missatge" required placeholder="Detalla el teu projecte energètic..."></textarea>
        </div>

        <button type="submit" class="boto-principal">Enviar Proposta</button>
        <div id="missatge-contacte" class="missatge-alerta" style="margin-top:1rem;"></div>
    </form>
</section>
