<section class="seccio-projectes">
    <h1><?php echo isset($titol) ? $titol : 'Projectes i Tecnologies'; ?></h1>
    <p>Descobreix les tecnologies, solucions i propostes d'empreses i individus inscrits a la comunitat de l'ODS 7. Cada projecte està pensat per fomentar la col·laboració sostenible i la reutilització circular.</p>

    <?php if (empty($projectes)): ?>
        <p class="alerta-buida">No hi ha projectes disponibles en aquest moment. Torna més tard o afegeix la teva proposta al marketplace.</p>
    <?php else: ?>
        <div class="grid-projectes">
            <?php foreach ($projectes as $projecte): ?>
                <article class="targeta-projecte">
                    <h2><?php echo htmlspecialchars($projecte['titol']); ?></h2>
                    <p class="meta-projecte"><strong>Tipus:</strong> <?php echo htmlspecialchars($projecte['tipus']); ?> · <strong>Estat:</strong> <?php echo htmlspecialchars($projecte['estat']); ?></p>
                    <p><?php echo htmlspecialchars(substr($projecte['descripcio'], 0, 140)); ?>...</p>
                    <p><strong>Ubicació:</strong> <?php echo htmlspecialchars($projecte['ubicacio']); ?></p>
                    <a class="boto-secundari" href="/index.php?url=projectes/detall&id=<?php echo urlencode($projecte['id']); ?>">Més informació</a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
