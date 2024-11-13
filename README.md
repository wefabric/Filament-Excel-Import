# Wefabric Excel Import


## Installatie

Om de package toe te voegen aan een Laravel-project, volg je de onderstaande stappen:

1. **Voeg de repository toe aan je `composer.json`:**

   Open je `composer.json` bestand en voeg de volgende repository en vereiste toe:

   ```json
   "repositories": [
       {
           "type": "vcs",
           "url": "https://bitbucket.org/slicklabs/excel-import"
       }
   ],
   ```
2. **Doe vervolgens:**

    Doe vervolgens 
    ```bash
    composer require wefabric/excel-import
    ```
   
3. **Publiceer de configuratie- en migratiebestanden::**
    ```bash
    php artisan vendor:publish --provider="Wefabric\ExcelImport\ExcelImportServiceProvider"
    ```
