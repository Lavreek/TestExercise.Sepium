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
        if (!file_exists(PROJECT_LOG_PATH)) {
            mkdir(dirname(PROJECT_LOG_PATH), recursive: true);

            touch(PROJECT_LOG_PATH . self::FILENAME);
        }

        return $this;
    }
}