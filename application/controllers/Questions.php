<?php
    use chriskacerguis\RestServer\RestController;

    class Questions extends RestController {
        function __construct(){
            parent::__construct();
        }


        // sample api with mock response
        public function users_get() {
            // users from data store
            $users = [
                ['id' => 0, 'name' => 'Shenal', 'email' => 'shenal.fernando10@gmail.com'],
                ['id' => 1, 'name' => 'John', 'email' => 'john@example.com']
            ];

            $id = $this->get('id');

            if($id === null) {
                // check if the users are availabe
                if($users) {
                    // send the response
                    $this->response($users, 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'No users yet'
                    ], 404);
                }
            } else {
                if(array_key_exists($id, $users)) {
                    $this->response($users[$id], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'No such user found'
                    ], 404);
                }

            } 
        }
    }


?>