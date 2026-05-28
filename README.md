# Hub d'Energia Circular (ODS 7)

## Descripció del projecte
Aquest projecte és una aplicació web modular MVC en PHP complementada amb un microservei Node.js/Express.
El seu objectiu és crear un hub tecnològic i fòrum de divulgació d'energies renovables vinculat a l'ODS 7: Energia Assequible i No Contaminant.
La plataforma integra un marketplace d'economia circular per a components renovables excedents, on es pot oferir donació, intercanvi o lloguer.

## Objectiu i impacte sostenible
La web pretén:
- Promoure el consum responsable i l'allargament del cicle de vida de materials tecnològics.
- Reduir la generació de residus electrònics (e-waste).
- Facilitar la col·laboració entre empreses, entitats i individus per impulsar solucions sostenibles.
- Contribuir als principis ASG: ambiental, social i governança.

## Arquitectura del projecte

### Front-end
- HTML5, CSS i JavaScript.
- MVC des del costat servidor amb PHP.
- Navegació amb un `navbar` funcional.
- Formes d'interacció amb el DOM i validacions al client.
- Mode Fosc i optimització de càrrega de scripts.

### Back-end simulat
- Microservei Node.js amb Express al directori `microservei-node/`.
- Base de dades local `db.json` per emular l'API REST de components.
- Controlador principal PHP `public/index.php` com a Front Controller.
- Base de dades SQLite `dades_projecte.db` per a usuaris i autenticació.

## Pàgines i rutes implementades
L'aplicació disposa d'un mínim de 10 pàgines/rutes funcionals:

1. `/index.php?url=inici` — Pàgina inicial del projecte.
2. `/index.php?url=ods` — Explicació de l'ODS 7 i impacte ASG.
3. `/index.php?url=desenvolupament` — Pràctiques sostenibles del desenvolupador.
4. `/index.php?url=programacio` — Codi Eficient i bones pràctiques.
5. `/index.php?url=empresa` — Anàlisi d'una empresa real de sostenibilitat.
6. `/index.php?url=projectes` — Llista de tecnologies / projectes de la comunitat.
7. `/index.php?url=projectes/detall&id=<id>` — Detall de projecte amb dades de contacte.
8. `/index.php?url=marketplace` — Banc de recursos circulars amb filtres i llistat.
9. `/index.php?url=marketplace/panell` — Panell privat per a usuari autenticat.
10. `/index.php?url=contacte` — Pàgina de contacte.
11. `/index.php?url=comunitat` — Login i registre de la comunitat.

A més, hi ha rutes de detall i API que fan l'estructura més completa.

## Infraestructura de dades

### Node API (`microservei-node`)
- `GET /api/components` — Retorna tots els components del marketplace.
- `POST /api/components` — Afegeix un component nou al `db.json`.
- `DELETE /api/components/:id` — Elimina un component per ID.
- `POST /api/simulat/login` — Login simulat d'usuaris locals.
- `POST /api/simulat/registre` — Registre de nous usuaris locals.

### SQLite (`dades_projecte.db`)
- Taula `usuaris` per emmagatzemar comptes reals.
- El model `Usuari` utilitza PDO i SHA seguint pràctiques de seguretat.
- L'autenticació del PHP usa JWT per protegir accions de CRUD quan cal.

## Característiques principals del projecte

- Consum asíncron de dades amb `fetch()` i `async/await`.
- CRUD de components: lectura, creació i eliminació.
- Filtratge i ordenació al front-end.
- Gestió de sessió amb token i navegació privada.
- Mode Fosc per estalviar energia en pantalles OLED.
- Arquitectura MVC separant presentació i lògica.
- API REST simulada amb Express i `db.json`.
- Compatibilitat amb Codespaces adaptant `API_BASE`.

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

## Cobertura de la rubrica

### RA1 — ODS i ASG
La web té una secció específica de l'ODS 7 amb impactes ambientals, socials i de governança ben definits.
- Estat actual: **bo**.
- Recomanació: fer servir exemples reals i cites concretes per entrar en nivell Expert.

### RA2 — Identificació del repte
La plataforma descriu la problemàtica de l'e-waste, la pobresa energètica i la necessitat de consum circular.
- Estat actual: **bo/avançat**.
- Recomanació: afegir dades concretes o estadístiques curtes per reforçar l'argument.

### RA3 — Pràctiques professionals sostenibles
Hi ha una pàgina dedicada amb pràctiques professionals reals (núvol, apagar equips, paper zero, minimitzar desplaçaments).
- Estat actual: **avançat**.
- Recomanació: ampliar amb exemples d'eines i processos de treball que s'han usat.

### RA4 — Economia circular i CRUD
El marketplace/CRUD està orientat a reutilització, donació, intercanvi i lloguer de components.
- Estat actual: **avançat/expert**.
- Recomanació: per arribar a Expert, assegura't que no s'hagi percebut com a botiga de coses noves i també implementa la modificació d'elements (`PUT` / editar) si és possible.

### RA5 — Programació eficient
S'ha integrat mode fosc, ús de fetch asíncron i charges dinàmiques del DOM.
- Estat actual: **avançat**.
- Recomanació: descriure a la web les tècniques d'optimització en una secció addicional i evitar recàrregues innecessàries de l'API.

### RA6 — Anàlisi d'empresa real
Hi ha una pàgina d'empresa, però actualment és massa genèrica.
- Estat actual: **intermedi / avançat baix**.
- Recomanació: substituir el text genèric per una empresa real (per exemple: Iberdrola, Siemens Gamesa, Enel Green Power, Acciona Energía) i citar un informe de sostenibilitat concret amb accions, grups d'interès i mètriques.

## Valoració general

### Què funciona bé
- La web és modular MVC amb PHP + Node.
- El marketplace llegeix d'un microservei `db.json` i s'integra amb el front.
- Hi ha 10+ rutes funcionals i una estructura de navegació.
- Hi ha un enfocament clar cap a l'ODS 7.

### Què cal millorar per millorar nota
1. **Fer la pàgina `empresa` més real i concreta** amb una companyia identificada i dades específiques.
2. **Afegir una pàgina de notícies / novetats** (títol i contingut real) per coincidir amb l'objectiu del projecte.
3. **Comentari de programació eficient a la web**: explicar en la interfície què s'ha fet per reduir trànsit i energia.
4. **Completar el CRUD** amb edició/actualització (`PUT`) si vols reforçar l'àmbit complet.
5. **Assegurar el login i l'ús de panell privat** perquè `El Meu Panell` sigui visible i funcional després de l'autenticació.
6. **Possiblement convertir `marketplace` en una pàgina de projectes més explicita** amb notícies i propostes tecnològiques.

## Requisits tècnics documentats

- S'ha utilitzat `npm init` dins `microservei-node`.
- S'ha instal·lat `express` i `cors`.
- L'API REST retorna JSON.
- El frontend consumeix l'API amb `fetch()` i `async/await`.
- La web usa un Front Controller PHP (`public/index.php`) per a les rutes.
- S'ha separat lògica (models, controladors) i vistes (PHP templates).

## Notes finals

Aquesta documentació resumeix l'estat actual del projecte i el seu encaix amb la rubrica. El projecte ja té una base sòlida, però per aspirar al màxim caldrà reforçar especialment:
- la pàgina d'empresa amb dades reals,
- la secció de notícies/propostes tecnològiques,
- i una explicació més explícita de les tècniques d'eficiència i d'economia circular.

---

### Contacte
Per a qualsevol prova o desplegament, executa el node microservei a `microservei-node/` i el servidor PHP en `public/`.

Si vols, puc completar també la pàgina `empresa` amb una empresa real i crear una nova pàgina de notícies per assegurar el 10/10 del projecte.

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
