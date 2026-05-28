<?php
/**
 * Controlador de gestió del Marketplace de l'Economia Circular
 * Administra les peticions del CRUD dinàmic i els filtres avançats de cerca.
 */

require_once __DIR__ . '/../models/Component.php';
require_once __DIR__ . '/AutenticacioController.php';

class MarketplaceController {
    private $modelComponent;

    public function __construct() {
        $this->modelComponent = new Component();
    }

    /**
     * Endpoint API: Llistar el catàleg aplicant filtres i ordenacions (Públic)
     */
    public function llistar() {
        header('Content-Type: application/json');
        $components = $this->modelComponent->obtenirTots();

        // Aplicació de Filtres via paràmetres GET (Cerca, Categoria, Tipus)
        if (!empty($_GET['cerca'])) {
            $terme = mb_strtolower($_GET['cerca'], 'UTF-8');
            $components = array_filter($components, function($c) use ($terme) {
                return str_contains(mb_strtolower($c['titol'], 'UTF-8'), $terme) || 
                       str_contains(mb_strtolower($c['descripcio'], 'UTF-8'), $terme);
            });
        }

        if (!empty($_GET['categoria_id'])) {
            $catId = (int)$_GET['categoria_id'];
            $components = array_filter($components, function($c) use ($catId) {
                return (int)$c['categoria_id'] === $catId;
            });
        }

        if (!empty($_GET['tipus'])) {
            $tipus = $_GET['tipus']; // donacio, lloguer, intercanvi
            $components = array_filter($components, function($c) use ($tipus) {
                return $c['tipus'] === $tipus;
            });
        }

        // Ordenació alfabètica inversa o directa per títol (Garanteix bones pràctiques)
        $ordre = isset($_GET['ordre']) ? $_GET['ordre'] : 'asc';
        usort($components, function($a, $b) use ($ordre) {
            return $ordre === 'desc' ? strcmp($b['titol'], $a['titol']) : strcmp($a['titol'], $b['titol']);
        });

        echo json_encode(array_values($components));
    }

    /**
     * Endpoint API: Afegir nou recurs (Protegit amb JWT)
     */
    public function crear() {
        header('Content-Type: application/json');
        $usuariAutenticat = AutenticacioController::verificarPermisosRequerits();

        $dades = json_decode(file_get_contents('php://input'), true);

        if (empty($dades['titol']) || empty($dades['categoria_id']) || empty($dades['tipus'])) {
            http_response_code(400);
            echo json_encode(["error" => "Dades del component incompletes."]);
            return;
        }

        // Assignem l'ID del propietari automàticament des del Token JWT verificat del servidor
        $dades['propietari_id'] = $usuariAutenticat['id'];

        $nouComponent = $this->modelComponent->crear($dades);
        if ($nouComponent) {
            http_response_code(21);
            echo json_encode($nouComponent);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No s'ha pogut desar l'element a l'API NoSQL."]);
        }
    }

    /**
     * Endpoint API: Eliminar recurs (Protegit amb JWT - Usuari Propietari o Administrador)
     */
    public function eliminar() {
        header('Content-Type: application/json');
        $usuariAutenticat = AutenticacioController::verificarPermisosRequerits();

        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(["error" => "ID del component no indicat."]);
            return;
        }

        $id = (int)$_GET['id'];
        $tots = $this->modelComponent->obtenirTots();
        $elementIdex = array_search($id, array_column($tots, 'id'));

        if ($elementIdex === false) {
            http_response_code(404);
            echo json_encode(["error" => "Component no trobat al catàleg."]);
            return;
        }

        $element = $tots[$elementIdex];

        // Validació estricta: Només l'administrador o el propietari real de l'objecte poden esborrar-lo
        if ($usuariAutenticat['rol'] !== 'administrador' && (int)$element['propietari_id'] !== (int)$usuariAutenticat['id']) {
            http_response_code(403);
            echo json_encode(["error" => "Operació no autoritzada sobre aquest recurs d'un altre usuari."]);
            return;
        }

        $exit = $this->modelComponent->suprimir($id);
        if ($exit) {
            echo json_encode(["missatge" => "Component retirat amb èxit per reutilització externa."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "No s'ha pogut executar l'esborrat."]);
        }
    }
}