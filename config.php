<?php

    /**
     * Archivo de configuración de variables globales de la aplicación.
     * Se cargan las variables de entorno y se definen las constantes necesarias para la aplicación.
     */

    // Dotenv mediante Composer

    require_once 'vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Base de datos

    define('DB_HOST', $_ENV['DB_HOST']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);

    // Controlador y acción por defecto

    define('CONTROLLER_DEFAULT', 'Producto');
    define('ACTION_DEFAULT', 'recomendados');

    // URL base

    define('BASE_URL', 'http://localhost/TFG/');

    // Paginación

    define('ITEMS_PER_PAGE', 10);
    define('PRODUCTS_PER_PAGE', 12); // Conviene que sea un múltiplo de 3 para obtener la vista más óptima

    // SMTP de Gmail

    define('MAIL_USERNAME', $_ENV['MAIL_USERNAME']);
    define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD']);

    // PayPal

    define('PAYPAL_CLIENT_ID', $_ENV['PAYPAL_CLIENT_ID']);
    define('PAYPAL_SECRET', $_ENV['PAYPAL_SECRET']);

?>