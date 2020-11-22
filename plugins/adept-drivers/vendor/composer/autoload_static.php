<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd49fdb7904759da37bb4f59975132b20
{
    public static $prefixLengthsPsr4 = array (
        'z' => 
        array (
            'zcrmsdk\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'zcrmsdk\\' => 
        array (
            0 => __DIR__ . '/..' . '/zohocrm/php-sdk/src',
        ),
    );

    public static $classMap = array (
        'Adept_Drivers_Logger' => __DIR__ . '/../..' . '/logs/adept-drivers-logger.php',
        'MoodleRest' => __DIR__ . '/..' . '/llagerlof/moodlerest/MoodleRest.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$classMap;

        }, null, ClassLoader::class);
    }
}
