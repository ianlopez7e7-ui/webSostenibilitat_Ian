<?php
/**
 * Model de dades per als Components de l'Economia Circular (NoSQL - API Node.js)
 * Utilitza peticions cURL d'entorn servidor per gestionar el CRUD RESTful.
 */

class Component {
    // URL del microservei local de Node.js executant-se a Codespaces
    private $urlAPI = "http://localhost:3000/api/components";

    /**
     * Funció auxiliar per centralitzar les peticions HTTP cap a l'API de Node
     */
    private function ferPeticioHTTP($metode, $url, $dades = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metode);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        
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
        curl_close($ch);

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