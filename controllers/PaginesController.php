<?php
/**
 * Controlador de Pàgines Estructurals
 * Gestiona el renderitzat i la càrrega de les vistes del patró MVC.
 */

class PaginesController {

    private $modelComponent;

    public function __construct()
    {
        require_once __DIR__ . '/../models/Component.php';
        $this->modelComponent = new Component();
    }

    /**
     * Funció auxiliar per carregar una vista injectant la capçalera i el peu
     */
    private function carregarVista($nomVista, $dades = []) {
        // Extraurem les variables per fer-les disponibles directament a la vista HTML
        extract($dades);
        
        $rutaVista = __DIR__ . "/../views/" . $nomVista . ".php";
        
        if (file_exists($rutaVista)) {
            require_once __DIR__ . "/../views/templates/header.php";
            require_once $rutaVista;
            require_once __DIR__ . "/../views/templates/footer.php";
        } else {
            http_response_code(404);
            die("La vista sol·licitada no existeix al sistema.");
        }
    }

    public function inici() {
        $this->carregarVista('pagines/inici', ['titol' => 'Hub d\'Energia Sostenible i Transició']);
    }

    public function ods() {
        $this->carregarVista('pagines/ods', ['titol' => 'ODS 7 - Impacte Ambiental, Social i Governança']);
    }

    public function desenvolupament() {
        $this->carregarVista('pagines/desenvolupament', ['titol' => 'Pràctiques de Desenvolupament Sostenible']);
    }

    public function programacio() {
        $this->carregarVista('pagines/programacio', ['titol' => 'Eficiència Energètica en Programació Web']);
    }

    public function noticies() {
        $this->carregarVista('pagines/noticies', ['titol' => 'Notícies i Novetats']);
    }

    public function recursos() {
        $this->carregarVista('pagines/recursos', ['titol' => 'Recursos i Referències']);
    }

    public function empresa() {
        $this->carregarVista('pagines/empresa', ['titol' => 'Anàlisi de Sostenibilitat Empresarial Real']);
    }

    public function contacte() {
        $this->carregarVista('pagines/contacte', ['titol' => 'Contacte i Col·laboracions']);
    }

    public function marketplaceLlistat() {
        $this->carregarVista('marketplace/llistat', ['titol' => 'Banc de Recursos i Marketplace Circular']);
    }

    public function marketplaceDetall() {
        $this->carregarVista('marketplace/detall', ['titol' => 'Detall del Component']);
    }

    public function marketplacePanell() {
        $this->carregarVista('marketplace/panell', ['titol' => 'El Meu Panell de Recursos Excedents']);
    }

    public function projectes() {
        $components = $this->modelComponent->obtenirTots();
        $this->carregarVista('pagines/projectes', [
            'titol' => 'Projectes i Tecnologies de la Comunitat',
            'projectes' => $components
        ]);
    }

    public function projecteDetall() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $component = $this->modelComponent->obtenirPerId($id);

        if (!$component) {
            http_response_code(404);
            die("Projecte no trobat o identificador invàlid.");
        }

        require_once __DIR__ . '/../models/Usuari.php';
        $usuariModel = new Usuari();
        $propietari = $usuariModel->cercarPerId($component['propietari_id']);

        $this->carregarVista('pagines/projecte_detall', [
            'titol' => 'Detall de la Tecnologia / Projecte',
            'projecte' => $component,
            'propietari' => $propietari
        ]);
    }

    public function loginRegistre() {
        $this->carregarVista('pagines/autenticacio', ['titol' => 'Accés i Registre de la Comunitat']);
    }
}