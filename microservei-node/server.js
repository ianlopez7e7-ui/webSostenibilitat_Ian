/**
 * Backend de Suport - Node.js i Express.js
 * Centralitza les operacions en paral·lel (Usuaris simulats i Marketplace NoSQL).
 */

const express = require('express');
const fs = require('fs');
const path = require('path');
const cors = require('cors');

const app = express();
app.use(express.json());
app.use(cors({
    origin: '*',
    methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    allowedHeaders: ['Content-Type', 'Authorization'],
    credentials: false
}));

const RUTA_BD = path.join(__dirname, 'db.json');

// Llegir dades del fitxer JSON mitjançant promeses asíncronas
const llegirDades = () => {
    return new Promise((resolve, reject) => {
        fs.readFile(RUTA_BD, 'utf8', (err, data) => {
            if (err) reject(err);
            else resolve(JSON.parse(data));
        });
    });
};

// Escriure dades al fitxer JSON mitjançant promeses asíncronas
const escriureDades = (dades) => {
    return new Promise((resolve, reject) => {
        fs.writeFile(RUTA_BD, JSON.stringify(dades, null, 2), 'utf8', (err) => {
            if (err) reject(err);
            else resolve();
        });
    });
};

// ==========================================
// ENDPOINTS: GESTIÓ D'USUARIS (SQL SIMULAT)
// ==========================================

// POST: API de Registre d'usuaris al fitxer local
app.post('/api/simulat/registre', async (req, res) => {
    try {
        const dades = await llegirDades();
        const { nom, email, contrasenya } = req.body;

        const usuariExistent = dades.usuaris.find(u => u.email === email);
        if (usuariExistent) {
            return res.status(409).json({ error: "Aquest correu ja està registrat." });
        }

        const nouUsuari = {
            id: dades.usuaris.length > 0 ? dades.usuaris[dades.usuaris.length - 1].id + 1 : 1,
            nom,
            email,
            contrasenya,
            rol: "usuari"
        };

        dades.usuaris.push(nouUsuari);
        await escriureDades(dades);
        res.status(201).json({ missatge: "Usuari registrat correctament en local." });
    } catch (error) {
        res.status(500).json({ error: "Error en el registre local." });
    }
});

// POST: API de Login simulat
app.post('/api/simulat/login', async (req, res) => {
    try {
        const dades = await llegirDades();
        const { email, contrasenya } = req.body;

        const usuarisLlista = dades.usuaris || [];
        const usuari = usuarisLlista.find(u => u.email === email && u.contrasenya === contrasenya);

        if (usuari) {
            const tokenSimulat = "token_simulat_client_m06_" + Buffer.from(usuari.email).toString('base64');
            res.json({
                missatge: "Autenticació correcta simulada.",
                token: tokenSimulat,
                usuari: { nom: usuari.nom, rol: usuari.rol }
            });
        } else {
            res.status(401).json({ error: "Credencials invàlides en el fitxer local." });
        }
    } catch (error) {
        res.status(500).json({ error: "Error en el login local." });
    }
});

// ==========================================
// ENDPOINTS: MARKETPLACE CIRCULAR (NoSQL)
// ==========================================

// GET: Obtenir tots els components per al catàleg públic
app.get('/api/components', async (req, res) => {
    try {
        const dades = await llegirDades();
        res.json(dades.components || []);
    } catch (error) {
        res.status(500).json({ error: "Error al llegir el catàleg circular." });
    }
});

// POST: Afegir un component excedent al Marketplace
app.post('/api/components', async (req, res) => {
    try {
        const dades = await llegirDades();
        const componentsLlista = dades.components || [];
        
        const nouComponent = {
            id: componentsLlista.length > 0 ? componentsLlista[componentsLlista.length - 1].id + 1 : 1,
            ...req.body
        };
        
        dades.components = [...componentsLlista, nouComponent];
        await escriureDades(dades);
        res.status(201).json(nouComponent);
    } catch (error) {
        res.status(500).json({ error: "No s'ha pogut desar el component." });
    }
});

// DELETE: Eliminar un component per ID
app.delete('/api/components/:id', async (req, res) => {
    try {
        const dades = await llegirDades();
        const id = parseInt(req.params.id);
        const componentsLlista = dades.components || [];
        
        const componentsFiltrats = componentsLlista.filter(c => c.id !== id);
        
        if (componentsLlista.length === componentsFiltrats.length) {
            return res.status(404).json({ error: "El component no existeix." });
        }
        
        dades.components = componentsFiltrats;
        await escriureDades(dades);
        res.json({ missatge: "Component eliminat correctament." });
    } catch (error) {
        res.status(500).json({ error: "Error al suprimir l'element." });
    }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, '0.0.0.0', () => {
    console.log(`[NODE] API REST en paral·lel activa al port ${PORT}`);
});