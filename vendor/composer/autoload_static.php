<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd0b14d746007a9163dcb5245d61a3281
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd0b14d746007a9163dcb5245d61a3281::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd0b14d746007a9163dcb5245d61a3281::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
