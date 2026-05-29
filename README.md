# Hub d'Energia Circular (ODS 7)

## Descripció del projecte
Aquest projecte és una aplicació web modular MVC en PHP complementada amb un microservei Node.js/Express.
El seu objectiu és crear un hub tecnològic i fòrum de divulgació d'energies renovables vinculat a l'ODS 7: Energia Assequible i No Contaminant.
La plataforma integra un marketplace d'economia circular per a components renovables excedents, on es pot oferir donació, intercanvi o lloguer.
Amb un espaï de notícies per mostrar les noves tecnologies, els problemes que hi ha, novetats, etcètera, per així divulgar i conscienciar respecte a les tecnologies i problemes actuals.

## Objectiu i impacte sostenible
La web pretén:
- Promoure el consum responsable i l'allargament del cicle de vida de materials tecnològics.
- Reduir la generació de residus electrònics (residus d'electrònica).
- Facilitar la col·laboració entre empreses, entitats i individus per impulsar solucions sostenibles.
- Contribuir als principis ASG: ambiental, social i governança.

## Instruccions d'instal·lació i execució

### 1. Executar el microservei Node
```bash
cd microservei-node
npm install
npm start
```
El microservei escolta per defecte al port `3000`.

### 2. Executar el servidor PHP
```bash
cd /workspaces/webSostenibilitat_Ian
php -S localhost:8000 -t public
```
I accedir a:
- `http://localhost:8000/index.php?url=inici`
- `http://localhost:8000/index.php?url=marketplace`

### 3. Notes de Codespaces
- Si fas servir GitHub Codespaces, exposa el port `3000` perquè el front pugui cridar l'API Node.
- El projecte adapta l'origen de l'API per a `*.app.github.dev`.

## Arquitectura del projecte

### Interfície de client
- HTML5, CSS i JavaScript.
- MVC des del costat servidor amb PHP.
- Navegació amb una barra de navegació funcional.
- Formes d'interacció amb el DOM i validacions al client.
- Mode Fosc i optimització de càrrega de scripts.

### Sistema de servidor
- Microservei Node.js amb Express al directori `microservei-node/`.
- Base de dades local `db.json` per a components i usuaris simulats (Node API).
- Controlador principal PHP `public/index.php` com a controlador frontal.
- Base de dades SQLite `dades_projecte.db` per a usuaris, notícies i missatges de contacte.

## Pàgines i rutes implementades
L'aplicació disposa de **12 pàgines/rutes principals** més punts finals API:

1. `/index.php?url=inici` — Pàgina inicial del projecte.
2. `/index.php?url=ods` — Explicació de l'ODS 7 i impacte ASG.
3. `/index.php?url=desenvolupament` — Pràctiques sostenibles del desenvolupador.
4. `/index.php?url=programacio` — Codi Eficient i bones pràctiques.
5. `/index.php?url=empresa` — Anàlisi d'una empresa real de sostenibilitat.
6. `/index.php?url=projectes` — Llista de tecnologies / projectes de la comunitat.
7. `/index.php?url=projectes/detall&id=<id>` — Detall de projecte amb dades de contacte.
8. `/index.php?url=marketplace` — Banc de recursos circulars amb filtres i llistat.
9. `/index.php?url=marketplace/panell` — Panell privat per a usuari autenticat.
10. `/index.php?url=noticies` — Notícies CRUD amb administrador.
11. `/index.php?url=contacte` — Pàgina de contacte amb emmagatzematge de missatges.
12. `/index.php?url=comunitat` — Identificació i registre de la comunitat.

## Infraestructura de dades i API

### API Node.js (`microservei-node`)
Punts finals per a components i usuaris simulats. La base de dades és `db.json`.

**Components (Economia Circular):**
- `GET /api/components` — Retorna tots els components del marketplace.
- `POST /api/components` — Afegeix un component nou.
- `DELETE /api/components/:id` — Elimina un component per ID.

**Autenticació simulada (Node):**
- `POST /api/simulat/login` — Identificació simulada amb token.
- `POST /api/simulat/registre` — Registre de nous usuaris.

### API PHP (`public/index.php`)
Punts finals que accedeixen a SQLite `dades_projecte.db`.

**Autenticació (SQLite/JWT):**
- `POST /index.php?url=api/login` — Identificació amb credencials SQLite (JWT).
- `POST /index.php?url=api/registre` — Registre a SQLite.

**Components (Marketplace):**
- `GET /index.php?url=api/components/llistar` — Llista components amb filtres.
- `POST /index.php?url=api/components/crear` — Crea component (JWT requerit).
- `DELETE /index.php?url=api/components/eliminar` — Elimina component (JWT requerit).

**Notícies (CRUD):**
- `GET /index.php?url=api/noticies/llistar` — Llista notícies.
- `POST /index.php?url=api/noticies/crear` — Crea notícia.
- `POST /index.php?url=api/noticies/actualitzar` — Actualitza notícia.
- `POST /index.php?url=api/noticies/eliminar` — Elimina notícia.

**Contacte:**
- `POST /index.php?url=api/contacte/enviar` — Emmagatzema missatge de contacte.

### SQLite (`dades_projecte.db`)
Taules de la base de dades:
- `usuaris` — Usuaris registrats amb rol (usuari/administrador).
- `noticies` — Notícies i blog entries amb metadades.
- `contacte` — Missatges de contacte rebuts.

## Característiques principals del projecte

- Consum asíncron de dades amb `fetch()` i `async/await`.
- CRUD de components: lectura, creació i eliminació.
- CRUD de notícies: lectura, creació, actualització i eliminació.
- Emmagatzematge de missatges de contacte.
- Filtratge i ordenació al costat client.
- Gestió de sessió amb token JWT i navegació privada.
- Mode Fosc per estalviar energia en pantalles OLED.
- Arquitectura MVC separant presentació, lògica i models.
- Models abstrauen accés a BD (PDO/SQLite).
- API REST amb punts finals ben documentats.
- Compatibilitat amb Codespaces adaptant `API_BASE`.

## Cobertura de especificació RA4 (Economia Circular)

### Comparació amb requeriments de la tasca

#### ✅ Implementat correctament

**Públic (sense identificació):**
- ✅ Mostrar productes existents (marketplace llistat)
- ✅ Filtres de cerca per paraula (filtre-cerca)
- ✅ Filtres per categoria (filtre-categoria)
- ✅ Filtres per tipus/model circular (filtre-tipus)
- ✅ Filtres d'ordenació alfabètica (filtre-ordre)
- ✅ Registre d'usuaris (formulari-registre)
- ✅ Identificació autenticada (formulari-login)

**Usuari autenticat (JWT):**
- ✅ Veure informació dels productes (ubicació, estat, descripció)
- ✅ Gestionar els seus productes: afegir-ne (POST /api/components)
- ✅ Gestionar els seus productes: eliminar-ne (DELETE /api/components/:id)

**Arquitectura:**
- ✅ API REST amb punts finals separats
- ✅ Documentació de punts finals
- ✅ Arquitectura MVC (Models, Controladors, Vistes)
- ✅ Models abstrauen accés a BD (PDO amb SQLite)
- ✅ Canvi de SGBD no afecta codi d'aplicació
- ✅ BD SQLite correctament dissenyada
- ✅ Controlador frontal (public/index.php) enruta peticions

#### ⚠️ Parcialment implementat

- ⚠️ **Modificar productes**: es pot afegir i eliminar, però falta edició (PUT/actualitzar)
- ⚠️ **Informació de contacte**: ubicació i estat es mostren, però el botó de contacte no és funcional
- ⚠️ **Panell privat**: mostra tots els productes en lloc de només els de l'usuari identificat
- ⚠️ **Autenticació mixta**: API Node usa `db.json` per identificació/registre, però PHP té sistema SQLite

#### ❌ No implementat (PER FER)

- ❌ **Modificar perfil d'usuari**: No hi ha vista/API per actualitzar dades del usuari
- ❌ **Panell d'administrador**: No existe panell d'administrador
- ❌ **Gestió de categories**: No hi ha CRUD per a categories (estan fixades en codi)
- ❌ **Gestió de tots els productes per admin**: Admin només pot gestionar els seus
- ❌ **Gestió d'usuaris per admin**: No existeix
- ❌ **Protecció JWT correcta**: Els punts finals de creació/eliminació no requereixen JWT actualment a Node
- ❌ **Filtres avançats de preu**: No s'ha implementat filtres per rang de preu

### Arquitectura correcta

✅ **Model-Vista-Controlador:**
- Models (`models/` folder): `Usuari.php`, `Component.php`, `Noticia.php`, `Missatge.php`
- Controladors (`controllers/` folder): `PaginesController.php`, `AutenticacioController.php`, `MarketplaceController.php`, `NoticiesController.php`, `ContacteController.php`
- Vistes (`views/` folder): templates separats per a cada pàgina

✅ **Separació de responsabilitats:**
- Models manejan accés a BD (PDO abstracta)
- Controllers orquesten la lògica
- Views renderitzen la presentació
- Config (`config/sqlite.php`) centralitza connexió

✅ **Abstracció de BD:**
- Tot passa per PDO
- Canviar a MySQL/PostgreSQL seria senzill
- SQL protegit contra injeccions amb prepared statements

## Próxims passos recomanats (PER FER)

1. **Implementar edició de productes** (`PUT /api/components/:id`)
   - Afegir formulari d'edició al panell privat
   - Actualitzar el model `Component.php` amb mètode `actualitzar()`

2. **Filtrar productes per usuari logat**
   - El panell privat ha de mostrar només els productes del usuari
   - Afegir camp `usuari_id` als components

3. **Protegir punts finals amb JWT**
   - Els punts finals Node (`POST /api/components`, `DELETE /api/components/:id`) necessiten validar token JWT
   - Els punts finals PHP ja tenen aquesta protecció

4. **Implementar panell d'administrador**
   - Vista per gestionar tots els usuaris
   - Vista per gestionar tots els components
   - Vista per gestionar categories

5. **Millorar autenticació**
   - Unificar identificació/registre a SQLite (eliminar `db.json` per autenticació)
   - O duplicar usuaris entre Node i SQLite

6. **Afegir filtres de preu**
   - Implementar `filtre-preu-min` i `filtre-preu-max` al llistat públic

7. **Completar gestió de usuaris**
   - Permetre modificar perfil (email, nom, contrasenya)
   - Veure historial de productes afegits

## Cobertura de la rubrica (ODS i ASG)

### RA1 — ODS i ASG
La web té una secció específica de l'ODS 7 amb impactes ambientals, socials i de governança ben definits.
- Estat actual: **bo**.

### RA2 — Identificació del repte
La plataforma descriu la problemàtica dels residus electrònics, la pobresa energètica i la necessitat de consum circular.
- Estat actual: **bo/avançat**.

### RA3 — Pràctiques professionals sostenibles
Hi ha una pàgina dedicada amb pràctiques professionals reals (núvol, apagar equips, paper zero, minimitzar desplaçaments).
- Estat actual: **avançat**.

### RA4 — Economia circular i CRUD
El marketplace/CRUD està orientat a reutilització, donació, intercanvi i lloguer de components.
- Estat actual: **avançat** (veure secció anterior per a detalls).
- Per arribar a **expert**: implementar edició de productes, panell d'administrador, i protecció JWT completa.

### RA5 — Programació eficient
S'ha integrat mode fosc, ús de peticions asíncrones i càrregues dinàmiques del DOM. Nova funcionalitat CRUD de notícies.
- Estat actual: **avançat**.

### RA6 — Anàlisi d'empresa real
Hi ha una pàgina d'empresa, però actualment és genèrica.
- Estat actual: **intermedi**.
- **Recomanació**: Substituir per empresa real amb dades concretes d'informe de sostenibilitat.

## Estructura de carpetes del projecte

```
webSostenibilitat_Ian/
├── config/
│   ├── jwt.php              (Gestió de tokens JWT)
│   └── sqlite.php           (Connexió i inicialització SQLite)
├── controllers/
│   ├── AutenticacioController.php
│   ├── ContacteController.php
│   ├── MarketplaceController.php
│   ├── NoticiesController.php
│   └── PaginesController.php
├── models/
│   ├── Component.php
│   ├── Missatge.php
│   ├── Noticia.php
│   └── Usuari.php
├── public/
│   ├── index.php            (Controlador frontal)
│   ├── js/
│   │   ├── api.js
│   │   ├── contacte.js
│   │   ├── noticies.js
│   │   └── validacions.js
│   └── css/
│       └── estil.css
├── views/
│   ├── marketplace/
│   │   ├── llistat.php
│   │   └── panell.php
│   ├── pagines/
│   │   ├── autenticacio.php
│   │   ├── contacte.php
│   │   ├── desenvolupament.php
│   │   ├── empresa.php
│   │   ├── inici.php
│   │   ├── noticies.php
│   │   ├── ods.php
│   │   ├── programacio.php
│   │   ├── projecte_detall.php
│   │   ├── projectes.php
│   │   ├── recursos.php
│   │   └── recursos.php
│   └── templates/
│       ├── footer.php
│       └── header.php
├── microservei-node/
│   ├── server.js
│   ├── db.json
│   └── package.json
├── dades_projecte.db         (Base de dades SQLite)
└── README.md
```

## Recursos i referències externes
Les següents fonts s'han utilitzat per contextualitzar el projecte i proporcionar materials de suport i dades:

- Open Data Ajuntament de Barcelona: https://opendata-ajuntament.barcelona.cat/es/ — conjunts de dades obertes per a investigació local i mapeig d'instal·lacions.
- Objectius de Desenvolupament Sostenible (ONU): https://www.un.org/sustainabledevelopment/es/sustainable-development-goals/ — definició i objectius de l'ODS 7.
- CSS Zen Garden: https://csszengarden.com/ — referència de separació contingut/estil per millorar accessibilitat i eficiència de la interfície.
- Nacions Unides (ES): https://www.un.org/es/ — informes i documents internacionals rellevants.
- Pacte Mundial — ODS 7: https://www.pactomundial.org/ods/7-energia-asequible-y-no-contaminante/ — guies per a empreses.
- Protocol d'estudi de fauna (Generalitat de Catalunya): https://mediambient.gencat.cat/web/.content/home/ambits_dactuacio/avaluacio_ambiental/energies_renovables/documents/protocol_estudi_fauna_pe_rv_nov_2024_final_def_signed.pdf
- Riscos per exposició a fums Diesel (Generalitat de Catalunya): https://treball.gencat.cat/web/.content/09_-_seguretat_i_salut_laboral/publicacions/imatges/37-RISCOS-PER-EXPOSICIO-A-FUMS-DIESEL.pdf
- Article: Pols dels frens i salut (EcoIndustria): https://ecoindustria.net/noticias/la-contaminacio-per-la-pols-dels-frens-tan-perjudicial-per-a-la-salut-com-el-diesel/

Recomanació: integrar conjunts de dades d'Open Data Barcelona a la secció `Projectes` per generar mapes i gràfics sobre distribució d'instal·lacions i impacte local.
