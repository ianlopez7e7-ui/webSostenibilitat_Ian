<?php
/**
 * Controlador per a emmagatzemar missatges enviats des de la pàgina de contacte.
 */

require_once __DIR__ . '/../models/Missatge.php';

class ContacteController {
    private $modelMissatge;

    public function __construct() {
        $this->modelMissatge = new Missatge();
    }

    public function enviar() {
        header('Content-Type: application/json');

        $dades = json_decode(file_get_contents('php://input'), true);
        if (empty($dades['nom']) || empty($dades['email']) || empty($dades['missatge'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Cal indicar nom, correu electrònic i missatge.']);
            return;
        }

        $id = $this->modelMissatge->crear($dades);
        if ($id) {
            http_response_code(201);
            echo json_encode(['missatge' => 'El teu missatge s\'ha emmagatzemat correctament.', 'id' => $id]);
            return;
        }

        http_response_code(500);
        echo json_encode(['error' => 'No s\'ha pogut desar el missatge.']);
    }
}
