<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb2d4d1c281fb806c8558ddb7295a87fe
{
    public static $files = array (
        '6632f90381dd49c5fe745d09406b9abb' => __DIR__ . '/..' . '/htmlburger/carbon-field-number/field.php',
        'a5f882d89ab791a139cd2d37e50cdd80' => __DIR__ . '/..' . '/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WpActionNetworkEvents\\' => 22,
        ),
        'C' => 
        array (
            'Carbon_Fields\\' => 14,
            'Carbon_Field_Rest_Api_Select\\' => 29,
            'Carbon_Field_Number\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WpActionNetworkEvents\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Carbon_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-fields/core',
        ),
        'Carbon_Field_Rest_Api_Select\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Carbon_Field_Number\\' => 
        array (
            0 => __DIR__ . '/..' . '/htmlburger/carbon-field-number/core',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb2d4d1c281fb806c8558ddb7295a87fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb2d4d1c281fb806c8558ddb7295a87fe::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
