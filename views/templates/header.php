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
</head>
<body>
    <header class="capcalera-global">
        <div class="contenidor-nav">
            <div class="logo">
                <a href="/inici">🌱 ODS 7 Circular</a>
            </div>
            <!-- Barra de navegació totalment funcional de 10 elements integrats -->
            <nav class="navbar" id="main-navbar">
                <ul>
                    <li><a href="/inici">Inici (Repte)</a></li>
                    <li><a href="/ods">ODS & ASG</a></li>
                    <li><a href="/desenvolupament">Pràctiques Pro</a></li>
                    <li><a href="/programacio">Codi Eficient</a></li>
                    <li><a href="/empresa">Informe Empresa</a></li>
                    <li><a href="/marketplace">Marketplace</a></li>
                    <li><a href="/marketplace/panell" class="ruta-protegida" style="display:none;">El Meu Panell</a></li>
                    <li><a href="/contacte">Contacte</a></li>
                    <li><a href="/comunitat" id="enllac-comunitat">Entrar / Registrar-se</a></li>
                    <li><a href="#" id="boto-sortir" style="display:none;">Sortir</a></li>
                </ul>
            </nav>
            <!-- Visual Anchor: Botó de canvi d'energia/mode fosc en pantalla -->
            <button id="alternador-mode" class="boto-sostenible" aria-label="Cambiar mode d'energia">🌙 Mode</button>
        </div>
    </header>
    <main class="contingut-principal">