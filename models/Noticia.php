<?php
/**
 * Model de dades per a la gestió de notícies i entrades del blog.
 * Emmagatzema dades a SQLite dins `dades_projecte.db`.
 */

require_once __DIR__ . '/../config/sqlite.php';

class Noticia {
    private $db;

    public function __construct() {
        $this->db = ConnexioSQL::obtenirConnexio();
    }

    public function obtenirTots() {
        $sql = "SELECT id, titol, resum, contingut, autor, url, data_publicacio FROM noticies ORDER BY data_publicacio DESC";
        $stmt = $this->db->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }

    public function obtenirPerId($id) {
        $sql = "SELECT id, titol, resum, contingut, autor, url, data_publicacio FROM noticies WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crear($dades) {
        $sql = "INSERT INTO noticies (titol, resum, contingut, autor, url, data_publicacio) VALUES (:titol, :resum, :contingut, :autor, :url, :data_publicacio)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titol', $dades['titol'], PDO::PARAM_STR);
        $stmt->bindValue(':resum', $dades['resum'], PDO::PARAM_STR);
        $stmt->bindValue(':contingut', $dades['contingut'], PDO::PARAM_STR);
        $stmt->bindValue(':autor', $dades['autor'], PDO::PARAM_STR);
        $stmt->bindValue(':url', !empty($dades['url']) ? $dades['url'] : null, PDO::PARAM_STR);
        $stmt->bindValue(':data_publicacio', date('Y-m-d H:i:s'), PDO::PARAM_STR);

        return $stmt->execute() ? $this->db->lastInsertId() : false;
    }

    public function actualitzar($id, $dades) {
        $sql = "UPDATE noticies SET titol = :titol, resum = :resum, contingut = :contingut, autor = :autor, url = :url WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titol', $dades['titol'], PDO::PARAM_STR);
        $stmt->bindValue(':resum', $dades['resum'], PDO::PARAM_STR);
        $stmt->bindValue(':contingut', $dades['contingut'], PDO::PARAM_STR);
        $stmt->bindValue(':autor', $dades['autor'], PDO::PARAM_STR);
        $stmt->bindValue(':url', !empty($dades['url']) ? $dades['url'] : null, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function suprimir($id) {
        $sql = "DELETE FROM noticies WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
