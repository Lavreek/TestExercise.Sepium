<?php

class Database extends PDOConnect
{
    public static function createTables()
    {
        $migrations = (new Loader())->getFiles(PROJECT_MIGRATION_PATH);

        foreach ($migrations as $table) {
            $migrationClass = new PDOMigrations();
            $migrationClass->createTable($table);
        }
    }

    public function usersCreate(string $name, string $email, string $password) : array
    {
        $connection = $this->getConnection();

        try {
            $connection->beginTransaction();

            $request = $connection->prepare(
                "INSERT INTO `users` (`name`, `email`, `password`, `created_at`)" .
                " VALUES (:name, :email, :password, :created_at)"
            );

            $request->execute([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            if ($connection->inTransaction()) {
                $connection->commit();
            }

            return [
                'message' => 'Пользователь успешно добавлен',
                'status' => '200',
            ];

        } catch (PDOException $exception) {
            if ($connection->inTransaction()) {
                $connection->rollBack();
            }

            Logger::write($exception);

            return [
                'message' => 'При добавлении произошла ошибка',
                'status' => '500',
                'error' => [
                    'code' => $connection->errorCode(),
                    'info' => $connection->errorInfo(),
                    'message' => $exception->getMessage()
                ]
            ];
        }
    }

    public function getRequest(string $query, array $parameters = []) : array
    {
        try {
            $connection = $this->getConnection();

            $request = $connection->prepare($query);
            $request->execute($parameters);

            return [
                'result' => $request,
                'message' => 'Запрос выполнен.',
            ];

        } catch (PDOException $exception) {
            Logger::write($exception);

            return [
                'message' => 'Во время выполнения произошла ошибка.',
                'error' => [
                    'message' => $exception->getMessage(),
                ]
            ];
        }
    }
}