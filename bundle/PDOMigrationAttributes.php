<?php

abstract class PDOMigrationAttributes
{
    private string $table_name = "";

    private array $fields = [];

    private string $field = "";

    private string $indexes = "";

    protected function setTableName(string $name) : void
    {
        $this->table_name = strtolower($name);
    }

    protected function setField($field_name, $attributes) : void
    {
        $this->setFieldName($field_name)
            ->getFieldType($attributes['type'])
        ;

        if (isset($attributes['length'])) {
            $this->setFieldLength($attributes['length']);
        }

        if (isset($attributes['nullable'])) {
            $this->setFieldNullable($attributes['nullable']);
        }

        if (isset($attributes['primary'])) {
            $this->setFieldPrimaryKey($attributes['primary']);
        }

        if (isset($attributes['auto_increment'])) {
            $this->setFieldAI($attributes['auto_increment']);
        }

        $this->closeField();
    }

    protected function setIndex($field_name, $attributes) : void
    {
        $table_name = $this->table_name;
        $type = $attributes['type'];
        $unique = uniqid();

        $this->indexes .= " CREATE {$type} INDEX uniq_{$unique}_$field_name ON `{$table_name}` ({$field_name}); ";
    }

    protected function getQuery() : string
    {
        $table_name = $this->table_name;
        $fields = implode(',', $this->fields);
        $indexes = $this->indexes;

        return "CREATE TABLE {$table_name} ({$fields}); $indexes";
    }

    private function setFieldName(string $name)
    {
        $this->field .= $name;
        return $this;
    }

    private function getFieldType(string $type)
    {
        $this->field .= " {$type} ";
        return $this;
    }

    private function setFieldLength(?int $length = null)
    {
        if (!is_null($length)) {
            $this->field .= " ({$length}) ";
        }

        return $this;
    }

    private function setFieldNullable(bool $nullable)
    {
        if ($nullable) {
            $this->field .= ' NULL ';
        } else {
            $this->field .= ' NOT NULL ';
        }
        return $this;
    }

    private function setFieldPrimaryKey(bool $primary)
    {
        if ($primary) {
            $this->field .= " PRIMARY KEY ";
        }
        return $this;
    }

    private function setFieldAI(bool $ai)
    {
        if ($ai) {
            $this->field .= " AUTO_INCREMENT ";
        }
        return $this;
    }

    private function closeField() : void
    {
        $this->fields[] = $this->field;
        $this->field = '';
    }
}