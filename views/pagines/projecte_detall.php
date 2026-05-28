<section class="seccio-projecte-detall">
    <h1><?php echo isset($titol) ? $titol : 'Detall del Projecte'; ?></h1>
    <article class="projecte-detall-card">
        <h2><?php echo htmlspecialchars($projecte['titol']); ?></h2>
        <p class="meta-projecte"><strong>Tipus:</strong> <?php echo htmlspecialchars($projecte['tipus']); ?> · <strong>Estat:</strong> <?php echo htmlspecialchars($projecte['estat']); ?></p>
        <p><strong>Ubicació:</strong> <?php echo htmlspecialchars($projecte['ubicacio']); ?></p>
        <div class="descripcio-projecte">
            <p><?php echo nl2br(htmlspecialchars($projecte['descripcio'])); ?></p>
        </div>

        <section class="contacte-projecte">
            <h3>Dades de contacte</h3>
            <?php if ($propietari): ?>
                <p><strong>Nom:</strong> <?php echo htmlspecialchars($propietari['nom']); ?></p>
                <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($propietari['email']); ?>"><?php echo htmlspecialchars($propietari['email']); ?></a></p>
                <p><strong>Rol:</strong> <?php echo htmlspecialchars($propietari['rol']); ?></p>
                <p>Pots contactar aquest usuari per proposar col·laboracions, preguntes tècniques o intercanvis sostenibles relacionats amb aquest projecte.</p>
            <?php else: ?>
                <p class="alerta-buida">No s'han pogut recuperar les dades de contacte de l'autor. Aquest projecte està disponible però la informació de contacte no està registrada.</p>
            <?php endif; ?>
        </section>

        <a class="boto-principal" href="/index.php?url=projectes">Tornar a la llista de projectes</a>
    </article>
</section>
