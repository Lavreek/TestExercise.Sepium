<?php

final class PDOMigrations extends PDOMigrationAttributes
{
    private PDOConnect $connect;

    public function __construct()
    {
        $this->connect = new PDOConnect();
    }

    public function createTable(string $migration)
    {
        $info = pathinfo($migration);

        $table_name = $info['filename'];

        if (file_exists(PROJECT_LOCK_PATH . $table_name .'.lock')) {
            return;
        }

        require_once PROJECT_MIGRATION_PATH . $migration;

        $this->setTableName($table_name);

        $reflection = new ReflectionClass($table_name);
        $class_properties = $reflection->getProperties();

        foreach ($class_properties as $class_property) {
            $property = new ReflectionProperty($table_name, $class_property->getName());

            $attributes = $property->getAttributes();

            foreach ($attributes as $attribute) {
                switch ($attribute->getName()) {
                    case 'PDOTypes' : {
                        $this->setField($class_property->getName(), $attribute->getArguments());
                        break;
                    }
                    case 'PDOIndexes' : {
                        $this->setIndex($class_property->getName(), $attribute->getArguments());
                        break;
                    }
                }
            }
        }

        $this->connect->executeQuery(
            $this->getQuery()
        );

        $this->setTableLock($table_name);
    }

    private function setTableLock($table_name)
    {
        $this->createConfiguration();

        touch(PROJECT_LOCK_PATH . $table_name .'.lock');
    }

    private function createConfiguration() : mixed
    {
        if (!is_dir(PROJECT_LOCK_PATH)) {
            mkdir(PROJECT_LOCK_PATH, recursive: true);
        }

        return $this;
    }
}
