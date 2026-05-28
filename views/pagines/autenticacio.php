<?php
/**
 * Vista: Formulari d'Autenticació i Registre de la Comunitat
 * Interfície neta preparada per a la interacció asíncrona de Front-end.
 */
?>
<section class="seccio-autenticacio">
    <div class="contenidor-formulari-doble">
        
        <!-- Formulari d'Accés / Login -->
        <div class="caixa-autenticacio" id="bloc-login">
            <h2>Accés a la Comunitat Circular</h2>
            <p class="descripcio-formulari">Inicia sessió per gestionar els teus excedents de components o contactar amb creadors.</p>
            
            <form id="formulari-login" novalidate>
                <div class="grup-camp">
                    <label for="login-email">Correu Electrònic *</label>
                    <input type="email" id="login-email" required placeholder="exemple@correu.com">
                    <span class="error-validacio" id="error-login-email"></span>
                </div>
                
                <div class="grup-camp">
                    <label for="login-pass">Contrasenya *</label>
                    <input type="password" id="login-pass" required placeholder="Introdueix la teva contrasenya">
                    <span class="error-validacio" id="error-login-pass"></span>
                </div>
                
                <button type="submit" class="boto-principal">Entrar de forma segura</button>
            </form>
            <div id="missatge-servidor-login" class="missatge-alerta"></div>
        </div>

        <!-- Formulari de Registre Nou -->
        <div class="caixa-autenticacio" id="bloc-registre">
            <h2>Registra't al Hub Sostenible</h2>
            <p class="descripcio-formulari">Uneix-te per allargar el cicle de vida dels materials elèctrics (ODS 7).</p>
            
            <form id="formulari-registre" novalidate>
                <div class="grup-camp">
                    <label for="registre-nom">Nom Complet o de l'Entitat *</label>
                    <input type="text" id="registre-nom" required placeholder="Ex: Cooperativa Solar o Joana Pi">
                    <span class="error-validacio" id="error-registre-nom"></span>
                </div>

                <div class="grup-camp">
                    <label for="registre-email">Correu Electrònic Actiu *</label>
                    <input type="email" id="registre-email" required placeholder="entitat@domini.org">
                    <span class="error-validacio" id="error-registre-email"></span>
                </div>

                <div class="grup-camp">
                    <label for="registre-pass">Contrasenya Segura *</label>
                    <input type="password" id="registre-pass" required placeholder="Mínim 8 caràcters">
                    <span class="error-validacio" id="error-registre-pass"></span>
                </div>

                <button type="submit" class="boto-secundari">Crear el meu compte verda</button>
            </form>
            <div id="missatge-servidor-registre" class="missatge-alerta"></div>
        </div>

    </div>
</section>