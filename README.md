Evaluation project "Jam storage" based on Symfony
========================

Small evaluation project to build an app to track jars of jam based on Symfony 3.3 and Sonata bundle

Steps to deploy the project locally:
--------------

1. Prepare empty database

2. Run installation process through composer (db details will be asked in the end):
    ```
    $ composer install
    ```

3. Create database structure:
    ```
    $  bin/console doctrine:schema:create
    ```

4. Fill in the database with test data:
    ```
    $ bin/console hautelook:fixture:load
    ```

5. Start dev web-server (optional):
    ```
    $ bin/console server:start
    ```

The dashboard page is accessible from the root URL (http://localhost:8001/app.php/admin in case of utilizing built-in web-server)
