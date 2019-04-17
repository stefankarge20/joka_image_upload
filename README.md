# joka_image_upload

## Installation
* Persistence MySQL, DataBase="api_db", Username="api_db", Password="§%&ergsdg54"

### Dummy bzw. Testdaten 
Eine Dummy-SQL Dump liegt im root Verzeichnis: api_db.sql

## Projekt
### Struktur
* api (REST Schnittstelle und DB) Aufbau der Artikel entspricht einer Baumstruktur mit 1) Kategorie, 2) Kollektion) 3) Produkt 4) Bildern
    * objects --> Klassen deren Instancen die Elemente darstellen 
    * config --> Klasse zur Datenbankschnittstelle
    * category --> REST-Schnitstelle und DB Zugriff für  Kategorie
    * collection --> REST-Schnitstelle und DB Zugriff für Kollektion
    * product --> REST-Schnitstelle und DB Zugriff für Produkt
    * image --> REST-Schnitstelle und DB Zugriff
    * controller --> Volltextsuche
* view
    * css --> Stylesheets + Icon
    * header (JS/CSS importe + Headline),  frontend (Body), footer (import JS für eigene Lgik)
    * javsscript (Vue-Componenten und Vue App)
    
## Layout
* CSS-Tree: https://bootsnipp.com/snippets/eNG7v
* Card: https://codepen.io/jstneg/pen/EVKYZj
 
 
 ## Image upload
 * https://github.com/kartik-v/bootstrap-fileinput
 * Configure The "php.ini" File 
 ** First, ensure that PHP is configured to allow file uploads. 
 ** In your "php.ini" file, search for the file_uploads directive, and set it to On: