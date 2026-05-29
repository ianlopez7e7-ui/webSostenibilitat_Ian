Aquí tens la traducció al català de la primera part del teu fitxer README.md. Com que el text original ja estava parcialment en català, s'han corregit les errades ortogràfiques, s'ha unificat l'estil i s'han mantingut intactes tots els termes web en anglès (com hub, marketplace, front, scripts, etc.) i els blocs de codi.
------------------------------
## Hub d'Energia Circular (ODS 7)## Descripció del projecte
Aquest projecte és una aplicació web modular MVC en PHP complementada amb un microservei Node.js/Express.
El seu objectiu és crear un hub tecnològic i un fòrum de divulgació d'energies renovables vinculat a l'ODS 7: Energia Assequible i No Contaminant.
La plataforma integra un marketplace d'economia circular per a components renovables excedents, on es pot oferir donació, intercanvi o lloguer.
## Objectiu i impacte sostenible
La web pretén:

* Promoure el consum responsable i l'allargament del cicle de vida de materials tecnològics.
* Reduir la generació de residus electrònics (e-waste).
* Facilitar la col·laboració entre empreses, entitats i individus per impulsar solucions sostenibles.
* Contribuir als principis ASG: ambiental, social i governança.

## Instruccions d'instal·lació i execució## 1. Executar el microservei Node

cd microservei-node
npm install
npm start

El microservei escolta per defecte al port 3000.
## 2. Executar el servidor PHP

cd /workspaces/webSostenibilitat_Ian
php -S localhost:8000 -t public

I accedir a:

* http://localhost:8000/index.php?url=inici
* http://localhost:8000/index.php?url=marketplace

## 3. Notes de Codespaces

* Si fas servir GitHub Codespaces, exposa el port 3000 perquè el front pugui cridar l'API Node.
* El projecte adapta l'origen de l'API per a *.app.github.dev.

## Arquitectura del projecte## Interfície de client

* HTML5, CSS i JavaScript.
* MVC des del costat del servidor amb PHP.
* Navegació amb una barra de navegació funcional.
* Formes d'interacció amb el DOM i validacions al client.
* Mode fosc i optimització de càrrega de scripts.

## Sistema de servidor

* Microservei Node.js com Express al directori microservei-node/.
* Base de dades local db.json per a components i usuaris simulats (Node API).
* Controlador principal PHP public/index.php com a controlador frontal (front controller).
* Base de dades SQLite dades_projecte.db per a usuaris, notícies i missatges de contacte.

------------------------------
Si ho necessites, em pots demanar que continuï traduint i revisant la resta de seccions del document, com la Infraestructura de dades o la Cobertura de l'especificació.

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
