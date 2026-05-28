<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titol) ? $titol : 'Hub d\'Energia Circular'; ?></title>
    <!-- Estils globals minimitzats per complir el criteri d'eficiència a la xarxa RA5 -->
    <link rel="stylesheet" href="/css/estil.css">
    <script>
        // Lògica immediata inline per evitar el "flash" de llum en pantalles OLED (Eficiència RA5)
        if (localStorage.getItem('mode-fosc') === 'activat') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
    <?php
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $hostnameParts = explode(':', $host);
        $hostname = $hostnameParts[0];
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        if (str_ends_with($hostname, '.app.github.dev')) {
            $apiHost = preg_replace('/-\d+\.app\.github\.dev$/', '-3000.app.github.dev', $hostname);
        } else {
            $apiHost = $hostname . ':3000';
        }
    ?>
    <script>
        window.__API_BASE__ = '<?php echo $scheme . '://' . $apiHost; ?>';
    </script>
</head>
<body>
    <header class="capcalera-global">
        <div class="contenidor-nav">
                <div class="logo">
                <a href="/index.php?url=inici">🌱 ODS 7 Circular</a>
            </div>
            <!-- Barra de navegació totalment funcional de 10 elements integrats -->
            <nav class="navbar" id="main-navbar">
                <ul>
                    <li><a href="/index.php?url=inici">Inici (Repte)</a></li>
                    <li><a href="/index.php?url=ods">ODS & ASG</a></li>
                    <li><a href="/index.php?url=desenvolupament">Pràctiques Pro</a></li>
                    <li><a href="/index.php?url=programacio">Codi Eficient</a></li>
                    <li><a href="/index.php?url=empresa">Informe Empresa</a></li>
                    <li><a href="/index.php?url=projectes">Projectes i Tecnologies</a></li>
                    <li><a href="/index.php?url=marketplace">Marketplace</a></li>
                    <li><a href="/index.php?url=marketplace/panell" class="ruta-protegida" style="display:none;">El Meu Panell</a></li>
                    <li><a href="/index.php?url=contacte">Contacte</a></li>
                    <li><a href="/index.php?url=comunitat" id="enllac-comunitat">Entrar / Registrar-se</a></li>
                    <li><a href="#" id="boto-sortir" style="display:none;">Sortir</a></li>
                </ul>
            </nav>
            <!-- Visual Anchor: Botó de canvi d'energia/mode fosc en pantalla -->
            <button id="alternador-mode" class="boto-sostenible" aria-label="Cambiar mode d'energia">🌙 Mode</button>
        </div>
    </header>
    <main class="contingut-principal">