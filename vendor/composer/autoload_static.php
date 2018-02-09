<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaf0a0e2c63a334fab6042884737ad9ba
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaf0a0e2c63a334fab6042884737ad9ba::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaf0a0e2c63a334fab6042884737ad9ba::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}