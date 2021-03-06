<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4c5105920237fa97a2621d436b4bec63
{
    public static $files = array (
        'd50ff9e3b9456e33e602d58c23cb6862' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'BlackSpot\\Starter\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'BlackSpot\\Starter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4c5105920237fa97a2621d436b4bec63::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4c5105920237fa97a2621d436b4bec63::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit4c5105920237fa97a2621d436b4bec63::$classMap;

        }, null, ClassLoader::class);
    }
}
