<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfb16de798048d6500c2ad53deb92888f
{
    public static $files = array (
        '5ec26a44593cffc3089bdca7ce7a56c3' => __DIR__ . '/../..' . '/core/helpers.php',
    );

    public static $classMap = array (
        'App\\Controllers\\AdminAuthController' => __DIR__ . '/../..' . '/app/controllers/AdminAuthController.php',
        'App\\Controllers\\AdminBookController' => __DIR__ . '/../..' . '/app/controllers/AdminBookController.php',
        'App\\Controllers\\AdminCategoryController' => __DIR__ . '/../..' . '/app/controllers/AdminCategoryController.php',
        'App\\Controllers\\AdminController' => __DIR__ . '/../..' . '/app/controllers/AdminController.php',
        'App\\Controllers\\AdminPagesController' => __DIR__ . '/../..' . '/app/controllers/AdminPagesController.php',
        'App\\Controllers\\AdminUploadController' => __DIR__ . '/../..' . '/app/controllers/AdminUploadController.php',
        'App\\Controllers\\PublicApiController' => __DIR__ . '/../..' . '/app/controllers/PublicApiController.php',
        'App\\Controllers\\PublicAuthController' => __DIR__ . '/../..' . '/app/controllers/PublicAuthController.php',
        'App\\Controllers\\PublicPagesController' => __DIR__ . '/../..' . '/app/controllers/PublicPagesController.php',
        'App\\Core\\App' => __DIR__ . '/../..' . '/core/App.php',
        'App\\Core\\Auth' => __DIR__ . '/../..' . '/core/Auth.php',
        'App\\Core\\Database\\Connection' => __DIR__ . '/../..' . '/core/database/Connection.php',
        'App\\Core\\Database\\Model' => __DIR__ . '/../..' . '/core/database/Model.php',
        'App\\Core\\Database\\QueryBuilder' => __DIR__ . '/../..' . '/core/database/QueryBuilder.php',
        'App\\Core\\Error' => __DIR__ . '/../..' . '/core/Error.php',
        'App\\Core\\Http\\Controller' => __DIR__ . '/../..' . '/core/http/Controller.php',
        'App\\Core\\Http\\Request' => __DIR__ . '/../..' . '/core/http/Request.php',
        'App\\Core\\Http\\Response' => __DIR__ . '/../..' . '/core/http/Response.php',
        'App\\Core\\Http\\Router' => __DIR__ . '/../..' . '/core/http/Router.php',
        'App\\Core\\Validation' => __DIR__ . '/../..' . '/core/Validation.php',
        'App\\Models\\Book' => __DIR__ . '/../..' . '/app/models/Book.php',
        'App\\Models\\Category' => __DIR__ . '/../..' . '/app/models/Category.php',
        'App\\Models\\User' => __DIR__ . '/../..' . '/app/models/User.php',
        'App\\Services\\ErrorLog' => __DIR__ . '/../..' . '/app/services/LoggingService.php',
        'App\\Services\\ExportService' => __DIR__ . '/../..' . '/app/services/ExportService.php',
        'App\\Services\\LoggingService' => __DIR__ . '/../..' . '/app/services/LoggingService.php',
        'App\\Services\\MailService' => __DIR__ . '/../..' . '/app/services/MailService.php',
        'App\\Services\\PageVisits' => __DIR__ . '/../..' . '/app/services/LoggingService.php',
        'ComposerAutoloaderInitfb16de798048d6500c2ad53deb92888f' => __DIR__ . '/..' . '/composer/autoload_real.php',
        'Composer\\Autoload\\ClassLoader' => __DIR__ . '/..' . '/composer/ClassLoader.php',
        'Composer\\Autoload\\ComposerStaticInitfb16de798048d6500c2ad53deb92888f' => __DIR__ . '/..' . '/composer/autoload_static.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitfb16de798048d6500c2ad53deb92888f::$classMap;

        }, null, ClassLoader::class);
    }
}
