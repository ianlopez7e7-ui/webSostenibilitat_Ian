<?php
/**
 * Model de missatges de contacte enviats des de la pàgina de contacte.
 */

require_once __DIR__ . '/../config/sqlite.php';

class Missatge {
    private $db;

    public function __construct() {
        $this->db = ConnexioSQL::obtenirConnexio();
    }

    public function crear($dades) {
        $sql = "INSERT INTO contacte (nom, email, missatge, data_creacio) VALUES (:nom, :email, :missatge, :data_creacio)";
        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nom', $dades['nom'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $dades['email'], PDO::PARAM_STR);
        $stmt->bindValue(':missatge', $dades['missatge'], PDO::PARAM_STR);
        $stmt->bindValue(':data_creacio', date('Y-m-d H:i:s'), PDO::PARAM_STR);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function obtenirTots() {
        $sql = "SELECT id, nom, email, missatge, data_creacio FROM contacte ORDER BY data_creacio DESC";
        $stmt = $this->db->query($sql);
        return $stmt ? $stmt->fetchAll() : [];
    }
}
