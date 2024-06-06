<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd0ff732a112c67eb00a021a4366d6904
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SocketManager\\Library\\Bin\\' => 26,
            'SocketManager\\Library\\' => 22,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SocketManager\\Library\\Bin\\' => 
        array (
            0 => __DIR__ . '/..' . '/socket-manager/library/bin',
        ),
        'SocketManager\\Library\\' => 
        array (
            0 => __DIR__ . '/..' . '/socket-manager/library/src',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd0ff732a112c67eb00a021a4366d6904::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd0ff732a112c67eb00a021a4366d6904::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd0ff732a112c67eb00a021a4366d6904::$classMap;

        }, null, ClassLoader::class);
    }
}