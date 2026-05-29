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

                // Crear la taula de notícies si no existeix
                self::$instancia->exec(
                    "CREATE TABLE IF NOT EXISTS noticies (" .
                    "id INTEGER PRIMARY KEY AUTOINCREMENT, " .
                    "titol TEXT NOT NULL, " .
                    "resum TEXT NOT NULL, " .
                    "contingut TEXT NOT NULL, " .
                    "autor TEXT NOT NULL, " .
                    "url TEXT, " .
                    "data_publicacio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP" .
                    ")"
                );

                $conte = self::$instancia->query("SELECT COUNT(*) FROM noticies")->fetchColumn();
                if ($conte == 0) {
                    $stm = self::$instancia->prepare(
                        "INSERT INTO noticies (titol, resum, contingut, autor, url) VALUES (:titol, :resum, :contingut, :autor, :url)"
                    );

                    $stm->execute([
                        ':titol' => 'Open Data Barcelona per a projectes sostenibles',
                        ':resum' => 'Recursos oberts municipals que ajuden a il·lustrar el potencial local de l’ODS 7.',
                        ':contingut' => 'L’Ajuntament ofereix conjunts de dades sobre energia, mobilitat i infraestructures que poden alimentar mapes interactius i anàlisis de distribució energètica sostenible.',
                        ':autor' => 'Redacció ODS 7',
                        ':url' => 'https://opendata-ajuntament.barcelona.cat/es/'
                    ]);

                    $stm->execute([
                        ':titol' => 'Guia ODS 7 de la ONU',
                        ':resum' => 'Definició i mètriques clau per fer un projecte energètic responsable.',
                        ':contingut' => 'L’ODS 7 estableix objectius globals per a l’accés a energia assequible, fiable i sostenible, un marc excel·lent per justificar l’impacte del projecte a nivell social i ambiental.',
                        ':autor' => 'Comunicació ODS',
                        ':url' => 'https://www.un.org/sustainabledevelopment/es/sustainable-development-goals/'
                    ]);
                }

                self::$instancia->exec(
                    "CREATE TABLE IF NOT EXISTS contacte (" .
                    "id INTEGER PRIMARY KEY AUTOINCREMENT, " .
                    "nom TEXT NOT NULL, " .
                    "email TEXT NOT NULL, " .
                    "missatge TEXT NOT NULL, " .
                    "data_creacio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP" .
                    ")"
                );
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