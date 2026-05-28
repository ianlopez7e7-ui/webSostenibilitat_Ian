<?php
/**
 * Fitxer de configuració i connexió segura a la BD SQL (SQLite)
 * Utilitza PDO per garantir l'abstracció del motor de dades.
 */

class ConnexioSQL {
    private static $instancia = null;

    public static function obtenirConnexio() {
        if (self::$instancia === null) {
            try {
                // Ruta absoluta cap a l'arxiu .db situat a l'arrel del projecte
                $rutaBD = __DIR__ . '/../dades_projecte.db';
                
                // Inicialitzem PDO amb SQLite
                self::$instancia = new PDO("sqlite:" . $rutaBD);
                
                // Configurem el mode d'errors per a que llanci excepcions i poder-los capturar
                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Retornem les dades com a vectors associatius per defecte
                self::$instancia->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                // Per seguretat, en producció no es mostra el missatge d'error de la BD directament al client
                error_log("Error de connexió a la BD: " . $e->getMessage());
                die(json_encode([
                    "error" => "Error intern del servidor. No s'ha pogut establir la connexió segura."
                ]));
            }
        }
        return self::$instancia;
    }
}