<?php
/**
 * Gestor d'autenticació segur mitjançant JSON Web Tokens (JWT)
 * Implementació nativa en PHP pur per a entorns lleugers i eficients (RA5).
 */

class GestorJWT {
    // Clau secreta per signar els tokens (En entorns reals es llegeix del fitxer .env)
    private static $clauSecreta = "ODS7_Energia_Circular_Secret_Key_2026";

    /**
     * Genera un token JWT vàlid per a un usuari autenticat
     */
    public static function crearToken($idUsuari, $nom, $rol) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        
        $payload = json_encode([
            'iss' => 'hub-energia-circular', // Emissor
            'iat' => time(),                 // Temps de creació
            'exp' => time() + (3600 * 4),    // Expiració (Vàlid per a 4 hores)
            'id' => $idUsuari,
            'nom' => $nom,
            'rol' => $rol
        ]);

        // Codificació en Base64Url
        $base64UrlHeader = self::base64UrlEncode($header);
        $base64UrlPayload = self::base64UrlEncode($payload);

        // Creació de la signatura criptogràfica HMAC-SHA256
        $signatura = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$clauSecreta, true);
        $base64UrlSignatura = self::base64UrlEncode($signatura);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignatura;
    }

    /**
     * Valida un token JWT rebut de les peticions asíncronas de JS
     */
    public static function validarToken($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) return false;

        list($header, $payload, $signatura) = $parts;

        // Verificar la signatura recalculant-la de nou
        $signaturaVerificacio = hash_hmac('sha256', $header . "." . $payload, self::$clauSecreta, true);
        $base64UrlSignaturaVerificacio = self::base64UrlEncode($signaturaVerificacio);

        if ($base64UrlSignaturaVerificacio !== $signatura) {
            return false; // El token ha estat manipulat
        }

        $dadesPayload = json_decode(self::base64UrlDecode($payload), true);

        // Verificar si el token ha expirat
        if (isset($dadesPayload['exp']) && $dadesPayload['exp'] < time()) {
            return false;
        }

        return $dadesPayload; // Retorna les dades de l'usuari si és vàlid
    }

    // Funcions d'ajuda per a la codificació compatible amb JWT estàndard
    private static function base64UrlEncode($data) {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
    }

    private static function base64UrlDecode($data) {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $data .= str_repeat('=', $padlen);
        }
        return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
    }
}