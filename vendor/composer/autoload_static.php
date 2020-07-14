<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9e859f0a5ff060198020e98e45635b20
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Container\\' => 14,
        ),
        'D' => 
        array (
            'Dealbao\\Open\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'Dealbao\\Open\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealbao/service/src/Open',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9e859f0a5ff060198020e98e45635b20::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9e859f0a5ff060198020e98e45635b20::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9e859f0a5ff060198020e98e45635b20::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}