<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbcd7db03404a9ec896befcc4a3c4e4c5
{
    public static $files = array (
        '9b38cf48e83f5d8f60375221cd213eee' => __DIR__ . '/..' . '/phpstan/phpstan/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'User\\Jenkins\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'User\\Jenkins\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitbcd7db03404a9ec896befcc4a3c4e4c5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbcd7db03404a9ec896befcc4a3c4e4c5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbcd7db03404a9ec896befcc4a3c4e4c5::$classMap;

        }, null, ClassLoader::class);
    }
}
