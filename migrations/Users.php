<?php

class Users
{
    #[PDOTypes(type: 'INTEGER', length: 11, nullable: false, primary: true, auto_increment: true)]
    public $id;

    #[PDOTypes(type: 'VARCHAR',  length: 255, nullable: false)]
    private $name;

    #[PDOIndexes(type: 'unique')]
    #[PDOTypes(type: 'VARCHAR', length: 255, nullable: false)]
    private $email;

    #[PDOTypes(type: 'DATETIME', nullable: false)]
    private $created_at;

    #[PDOTypes(type: 'VARCHAR', length: 255, nullable: false)]
    private $password;

}