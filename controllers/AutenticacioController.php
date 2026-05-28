<?php
/**
 * Controlador d'Autenticació de la plataforma
 * Gestiona el flux del login, registre i assignació de JWT.
 */

require_once __DIR__ . '/../models/Usuari.php';
require_once __DIR__ . '/../config/jwt.php';

class AutenticacioController {
    private $modelUsuari;

    public function __construct() {
        $this->modelUsuari = new Usuari();
    }

    /**
     * Endpoint API: Login asíncron d'usuaris
     */
    public function login() {
        // Establir capçalera de retorn de dades en format JSON
        header('Content-Type: application/json');
        
        // Obtenir dades JSON enviades des de fetch() de JS
        $dadesRebudes = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($dadesRebudes['email']) || !isset($dadesRebudes['contrasenya'])) {
            http_response_code(400);
            echo json_encode(["error" => "Camps incomplets obligatoris."]);
            return;
        }

        $usuari = $this->modelUsuari->cercarPerEmail($dadesRebudes['email']);

        // Verificar existència i correspondència de contrasenya (Hash verificat)
        if ($usuari && password_verify($dadesRebudes['contrasenya'], $usuari['contrasenya'])) {
            // Creació del Token JWT
            $token = GestorJWT::crearToken($usuari['id'], $usuari['nom'], $usuari['rol']);
            
            echo json_encode([
                "missatge" => "Autenticació correcta.",
                "token" => $token,
                "usuari" => [
                    "nom" => $usuari['nom'],
                    "rol" => $usuari['rol']
                ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Credencials invàlides d'accés."]);
        }
    }

    /**
     * Endpoint API: Registre asíncron d'usuaris
     */
    public function registre() {
        header('Content-Type: application/json');
        $dadesRebudes = json_decode(file_get_contents('php://input'), true);

        if (empty($dadesRebudes['nom']) || empty($dadesRebudes['email']) || empty($dadesRebudes['contrasenya'])) {
            http_response_code(400);
            echo json_encode(["error" => "Dades del formulari incompletes."]);
            return;
        }

        // Validar si el correu ja es troba registrat a SQLite
        if ($this->modelUsuari->cercarPerEmail($dadesRebudes['email'])) {
            http_response_code(409);
            echo json_encode(["error" => "Aquest correu electrònic ja està registrat."]);
            return;
        }

        $exit = $this->modelUsuari->registrar($dadesRebudes['nom'], $dadesRebudes['email'], $dadesRebudes['contrasenya']);

        if ($exit) {
            http_response_code(201);
            echo json_encode(["missatge" => "Usuari registrat correctament amb èxit."]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error intern en desar l'usuari."]);
        }
    }

    /**
     * Mètode auxiliar per validar els permisos a partir del token JWT passat a la capçalera HTTP
     */
    public static function verificarPermisosRequerits($rolRequerit = null) {
        $capcaleres = getallheaders();
        $authHeader = isset($capcaleres['Authorization']) ? $capcaleres['Authorization'] : '';

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $coincidencies)) {
            $dadesToken = GestorJWT::validarToken($coincidencies[1]);
            if ($dadesToken) {
                if ($rolRequerit && $dadesToken['rol'] !== $rolRequerit) {
                    http_response_code(403);
                    echo json_encode(["error" => "Accés denegat. Permisos insuficients."]);
                    exit;
                }
                return $dadesToken; // Retorna les dades de l'usuari si compleix els criteris
            }
        }

        http_response_code(401);
        echo json_encode(["error" => "Accés no autoritzat. Cal un Token JWT vàlid."]);
        exit;
    }
}