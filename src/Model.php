<?php

final class Model extends ModelHandler
{
    #[Routing(path: '/users/create/')]
    public function usersCreate()
    {
        $request = new UserRequest();

        $parameters = $request->toArray() + [
            'created_at' => date('Y-m-d H:i:s')
        ];

        $request = $this->database->getRequest(
            $this->database->insertQuery('users', array_keys($parameters)),
            $parameters
        );

        if (!isset($request['error'])) {
            $request['message'] = "Пользователь успешно добавлен.";
        }

        $this->setResponse( $request );
    }

    #[Routing(path: '/users/table/')]
    public function usersTable(): void
    {
        $response = $this->database->getRequest(
            "SELECT * FROM `users`"
        );

        $response['result'] = $response['result']->fetchAll(PDO::FETCH_ASSOC);

        $this->setResponse( $response );
    }

    #[Routing(path: '/users/delete/')]
    public function usersDelete(): void
    {
        $this->setResponse(
            $this->database->getRequest(
                "DELETE FROM `users` WHERE `id` = :id", [
                'id' => (int)$_POST['id']
            ]),
        );
    }

    #[Routing(path: '/users/edit/')]
    public function usersEdit(): void
    {
        $request = new UserRequest();

        $this->setResponse(
            $this->database->getRequest(
            "UPDATE `users` SET `name` = :name, `email` = :email, `password` = :password" .
                " WHERE id = :id",
            $request->toArray() + [
                'id' => (int)$_POST['id']
            ])
        );
    }
}