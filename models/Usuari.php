<?php
/**
 * Model de dades per a la gestió d'Usuaris (SQL - SQLite)
 * Abstrau les consultes i garanteix la integritat de l'accés.
 */

require_once __DIR__ . '/../config/sqlite.php';

class Usuari {
    private $db;

    public function __construct() {
        $this->db = ConnexioSQL::obtenirConnexio();
    }

    /**
     * Registra un nou usuari a la plataforma aplicant hash segur
     */
    public function registrar($nom, $email, $contrasenya, $rol = 'usuari') {
        try {
            $sql = "INSERT INTO usuaris (nom, email, contrasenya, rol) VALUES (:nom, :email, :contrasenya, :rol)";
            $stmt = $this->db->prepare($sql);
            
            // Encriptació de la contrasenya de forma segura abans de desar-la
            $hashContrasenya = password_hash($contrasenya, PASSWORD_BCRYPT);
            
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':contrasenya', $hashContrasenya, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar l'usuari: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cerca un usuari mitjançant el seu correu per comprovar el Login
     */
    public function cercarPerEmail($email) {
        try {
            $sql = "SELECT id, nom, email, contrasenya, rol FROM usuaris WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en cercar l'usuari: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cerca un usuari per ID per mostrar dades de contacte i perfil.
     */
    public function cercarPerId($id) {
        try {
            $sql = "SELECT id, nom, email, rol, creat_el FROM usuaris WHERE id = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error en cercar l'usuari per id: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Llista tots els usuaris (Funció exclusiva d'Administrador - Mòdul Servidor)
     */
    public function obtenirTots() {
        try {
            $sql = "SELECT id, nom, email, rol, creat_el FROM usuaris ORDER BY id DESC";
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error en llistar els usuaris: " . $e->getMessage());
            return [];
        }
    }
}