<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2e13421d20b67246c1ab03f66a7ae157
{
    public static $prefixLengthsPsr4 = array (
        'o' => 
        array (
            'ourcodeworld\\HelloComposer\\' => 27,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ourcodeworld\\HelloComposer\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit2e13421d20b67246c1ab03f66a7ae157::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2e13421d20b67246c1ab03f66a7ae157::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2e13421d20b67246c1ab03f66a7ae157::$classMap;

        }, null, ClassLoader::class);
    }
}