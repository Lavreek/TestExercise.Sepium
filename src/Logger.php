<?php

final class Logger
{
    const FILENAME = 'fpm.log';

    public static function write(mixed $message)
    {
        (new Logger())
            ->createConfiguration()
            ->writeMessage($message);
    }

    private function writeMessage($message) : void
    {
        $file = $this->openFile();

        fwrite($file, "\n". date('Y-m-d H:i:s') .' / '. print_r($message, true));

        fclose($file);
    }

    private function openFile() : mixed
    {
        return fopen(PROJECT_LOG_PATH . self::FILENAME, 'a+');
    }

    private function createConfiguration() : mixed
    {
        $directory = PROJECT_LOG_PATH;
        $filepath = $directory . self::FILENAME;

        if (!file_exists($filepath)) {
            if (!is_dir($directory)) {
                mkdir($directory, recursive: true);
            }

            touch($filepath);
        }

        return $this;
    }
}