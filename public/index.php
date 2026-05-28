<?php
/**
 * Front Controller - Punt d'Entrada Únic de l'Aplicació
 * Centralitza les rutes, gestiona el trànsit i arrenca el patró MVC.
 */

// Activem la gestió d'errors cap a l'arxiu de log per eficiència i seguretat
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Requerim els controladors necessaris
require_once __DIR__ . '/../controllers/PaginesController.php';
require_once __DIR__ . '/../controllers/AutenticacioController.php';
require_once __DIR__ . '/../controllers/MarketplaceController.php';

// Obtenir la ruta sol·licitada (per defecte 'inici')
$ruta = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'inici';

// Instanciem els controladors
$paginesCtrl = new PaginesController();
$autenticacioCtrl = new AutenticacioController();
$marketplaceCtrl = new MarketplaceController();

// Enrutador bàsic i segur basat en estructures condicionals (evita dependències complexes)
switch ($ruta) {
    // === RUTES DE PRESENTACIÓ TEXTUAL I VISTES MVC ===
    case 'inici':
        $paginesCtrl->inici();
        break;
    case 'ods':
        $paginesCtrl->ods();
        break;
    case 'desenvolupament':
        $paginesCtrl->desenvolupament();
        break;
    case 'programacio':
        $paginesCtrl->programacio();
        break;
    case 'empresa':
        $paginesCtrl->empresa();
        break;
    case 'contacte':
        $paginesCtrl->contacte();
        break;
    case 'marketplace':
        $paginesCtrl->marketplaceLlistat();
        break;
    case 'marketplace/detall':
        $paginesCtrl->marketplaceDetall();
        break;
    case 'marketplace/panell':
        $paginesCtrl->marketplacePanell();
        break;
    case 'projectes':
        $paginesCtrl->projectes();
        break;
    case 'projectes/detall':
        $paginesCtrl->projecteDetall();
        break;
    case 'comunitat':
        $paginesCtrl->loginRegistre();
        break;

    // === ENDPOINTS DE L'API REST PHP (Peticions asíncrones d'entrada) ===
    case 'api/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $autenticacioCtrl->login();
        else http_response_code(405);
        break;
        
    case 'api/registre':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $autenticacioCtrl->registre();
        else http_response_code(405);
        break;
        
    case 'api/components/llistar':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') $marketplaceCtrl->llistar();
        else http_response_code(405);
        break;
        
    case 'api/components/crear':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $marketplaceCtrl->crear();
        else http_response_code(405);
        break;
        
    case 'api/components/eliminar':
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') $marketplaceCtrl->eliminar();
        else http_response_code(405);
        break;

    // === ERROR 404 - RUTA NO TROBADA ===
    default:
        http_response_code(404);
        echo "<h1>Error 404: Pàgina no trobada</h1><p>La ruta sol·licitada no està configurada en el sistema circular.</p>";
        break;
}