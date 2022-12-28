<?php
    use chriskacerguis\RestServer\RestController;
    use Ramsey\Uuid\Uuid;

    class Users extends RestController {
        function __construct(){
            parent::__construct();
        }

        // user registration
        public function register_post() {
            $firstname = $this->post('firstname');
            $lastname = $this->post('lastname');
            $username = $this->post('username');
            $password = $this->post('password');
            $password2 = $this->post('password2');

            if (!$firstname || !$lastname || !$username || !$password || !$password2) {
                $this->response([
                    'code' => -1,
                    'error' => 'mandatory parameters',
                    'result' => null
                ], 400);
            } else if ($password !== $password2) {
                $this->response([
                    'code' => -1,
                    'error' => 'passwords didn\'t match',
                    'result' => null
                ], 400);
            } else {
                $data = array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'username' => $username,
                    'password' => 'encrypted password'
                );
                // encrypts the password
                // save to database
                // return the response
            }
        }

        // user login
        public function login_post() {
            $username = $this->post('username');
            $password = $this->post('password');

            if (!$username || !$password) {
                $this->response([
                    'code' => -1,
                    'error' => 'mandatory parameters missing',
                    'result' => null
                ],400);
            }

            // check the password validation
            // return the response - api key or something
        }

        // user logout
        public function logout_post() {
            // to be implemented
        }
    }

?>