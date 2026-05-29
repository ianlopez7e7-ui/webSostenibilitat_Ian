<?php
/**
 * Controlador per a la gestió CRUD de les notícies del projecte.
 */

require_once __DIR__ . '/../models/Noticia.php';

class NoticiesController {
    private $modelNoticia;

    public function __construct() {
        $this->modelNoticia = new Noticia();
    }

    public function llistar() {
        header('Content-Type: application/json');
        $noticies = $this->modelNoticia->obtenirTots();
        echo json_encode($noticies);
    }

    public function crear() {
        header('Content-Type: application/json');

        $dades = json_decode(file_get_contents('php://input'), true);
        if (empty($dades['titol']) || empty($dades['resum']) || empty($dades['contingut']) || empty($dades['autor'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falten camps obligatoris per crear la notícia.']);
            return;
        }

        $id = $this->modelNoticia->crear($dades);
        if ($id) {
            http_response_code(201);
            echo json_encode(array_merge(['id' => $id], $dades, ['data_publicacio' => date('Y-m-d H:i:s')]));
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No s\'ha pogut desar la notícia.']);
        }
    }

    public function actualitzar() {
        header('Content-Type: application/json');

        $dades = json_decode(file_get_contents('php://input'), true);
        if (empty($dades['id']) || empty($dades['titol']) || empty($dades['resum']) || empty($dades['contingut']) || empty($dades['autor'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Falten camps obligatoris per actualitzar la notícia.']);
            return;
        }

        $id = (int)$dades['id'];
        $exit = $this->modelNoticia->actualitzar($id, $dades);
        if ($exit) {
            echo json_encode(['id' => $id, 'titol' => $dades['titol'], 'resum' => $dades['resum'], 'contingut' => $dades['contingut'], 'autor' => $dades['autor'], 'url' => $dades['url'] ?? null]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No s\'ha pogut actualitzar la notícia.']);
        }
    }

    public function eliminar() {
        header('Content-Type: application/json');

        $dades = json_decode(file_get_contents('php://input'), true);
        $id = isset($dades['id']) ? (int)$dades['id'] : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de notícia no vàlid.']);
            return;
        }

        $exit = $this->modelNoticia->suprimir($id);
        if ($exit) {
            echo json_encode(['missatge' => 'Notícia suprimit correctament.']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'No s\'ha pogut suprimir la notícia.']);
        }
    }
}
