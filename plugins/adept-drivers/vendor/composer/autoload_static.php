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
            0 => __DIR__ . '/..' . '/zohocrm/php-sdk-archive/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mustache' => 
            array (
                0 => __DIR__ . '/..' . '/mustache/mustache/src',
            ),
        ),
    );

    public static $classMap = array (
        'Adept_Drivers' => __DIR__ . '/../..' . '/includes/class-adept-drivers.php',
        'Adept_Drivers_Activator' => __DIR__ . '/../..' . '/includes/class-adept-drivers-activator.php',
        'Adept_Drivers_Deactivator' => __DIR__ . '/../..' . '/includes/class-adept-drivers-deactivator.php',
        'Adept_Drivers_Geocoding' => __DIR__ . '/../..' . '/includes/class-adept-drivers-geocoding.php',
        'Adept_Drivers_Instructors' => __DIR__ . '/../..' . '/includes/class-adept-drivers-instructors.php',
        'Adept_Drivers_LMS' => __DIR__ . '/../..' . '/includes/class-adept-drivers-lms.php',
        'Adept_Drivers_Loader' => __DIR__ . '/../..' . '/includes/class-adept-drivers-loader.php',
        'Adept_Drivers_Logger' => __DIR__ . '/../..' . '/logs/adept-drivers-logger.php',
        'Adept_Drivers_Public_Booking' => __DIR__ . '/../..' . '/includes/class-adept-drivers-bookings.php',
        'Adept_Drivers_Students' => __DIR__ . '/../..' . '/includes/adept-drivers-students.php',
        'Adept_Drivers_Tookan' => __DIR__ . '/../..' . '/includes/class-adept-drivers-tokaan.php',
        'Adept_Drivers_ZCRM' => __DIR__ . '/../..' . '/includes/class-adept-drivers-zcrm.php',
        'Adept_Drivers_i18n' => __DIR__ . '/../..' . '/includes/class-adept-drivers-i18n.php',
        'MoodleRest' => __DIR__ . '/..' . '/llagerlof/moodlerest/MoodleRest.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitd49fdb7904759da37bb4f59975132b20::$classMap;

        }, null, ClassLoader::class);
    }
}
