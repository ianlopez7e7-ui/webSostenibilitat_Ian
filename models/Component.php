<?php
/**
 * Model de dades per als Components de l'Economia Circular (NoSQL - API Node.js)
 * Utilitza peticions cURL d'entorn servidor per gestionar el CRUD RESTful.
 */

class Component {
    // L'URL base de l'API es llegeix des d'una variable d'entorn `API_BASE` o fa fallback a localhost:3000
    private $urlAPI;

    public function __construct()
    {
        $base = getenv('API_BASE') ?: getenv('API_HOST') ?: 'http://localhost:3000';
        // Accepta valors com "//host:3000" o "http://host:3000"
        if (str_starts_with($base, '//')) $base = 'http:' . $base;
        if (!str_starts_with($base, 'http')) $base = 'http://' . $base;
        $this->urlAPI = rtrim($base, '/') . '/api/components';
    }

    /**
     * Funció auxiliar per centralitzar les peticions HTTP cap a l'API de Node
     */
    private function ferPeticioHTTP($metode, $url, $dades = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metode);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        
        // Estalvi de recursos i optimització de trànsit intern (RA5)
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        if ($dades !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dades));
        }

        $resposta = curl_exec($ch);
        $codiEstat = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($ch);
        $curlErr = curl_error($ch);
        curl_close($ch);

        if ($curlErrNo !== 0) {
            error_log("Component::ferPeticioHTTP curl error ({$curlErrNo}): {$curlErr}");
            return false;
        }

        if ($codiEstat >= 200 && $codiEstat < 300) {
            return json_decode($resposta, true);
        }
        return false;
    }

    /**
     * READ: Retorna tot el catàleg d'elements del Marketplace circular
     */
    public function obtenirTots() {
        $res = $this->ferPeticioHTTP('GET', $this->urlAPI);
        return $res ? $res : [];
    }

    /**
     * Retorna un component concret per ID a partir del catàleg del microservei.
     */
    public function obtenirPerId($id) {
        $components = $this->obtenirTots();
        foreach ($components as $component) {
            if ((int)$component['id'] === (int)$id) {
                return $component;
            }
        }
        return null;
    }

    /**
     * CREATE: Afegeix un nou component excedent (Panell, Bateria...) al banc
     */
    public function crear($dades) {
        return $this->ferPeticioHTTP('POST', $this->urlAPI, $dades);
    }

    /**
     * UPDATE: Modifica els paràmetres d'un component existent
     */
    public function actualitzar($id, $dades) {
        return $this->ferPeticioHTTP('PUT', $this->urlAPI . "/" . $id, $dades);
    }

    /**
     * DELETE: Elimina del catàleg un component retirat o reciclat definitivament
     */
    public function suprimir($id) {
        return $this->ferPeticioHTTP('DELETE', $this->urlAPI . "/" . $id);
    }
}