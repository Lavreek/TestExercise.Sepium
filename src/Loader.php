<?php

declare(strict_types = 1);

final class Loader
{
    public static function initialize(): void
    {
        (new Loader)->init(PROJECT_SRC_PATH);
    }

    public static function initializeBundles() : void
    {
        (new Loader)->init(PROJECT_BUNDLE_PATH);
    }

    public static function initializeOther(string $path) : void
    {
        (new Loader)->init($path);
    }

    private function init(string $path) : void
    {
        $files = $this->getFiles($path);

        foreach ($files as $file) {
            $filepath = $path . $file;

            spl_autoload_register(function () use ($filepath) {
                require_once $filepath;
            });
        }
    }

    public function getFiles($path, $extension = 'php') : ?array
    {
        $dir_files = scandir($path);
        $files = [];

        if (!empty($dir_files)) {
            foreach ($dir_files as $file) {
                $info = pathinfo($file);

                if (isset($info['extension']) && !empty($info['extension']) && $info['extension'] == $extension) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }
}