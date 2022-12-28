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
                    'user_id' => Uuid::uuid1(),
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

        public function isEmailAvailable_get() {
            // get the email
            // check in db
            // return the response
            $email = $this->get('email');
            if(!$email) {
                $this->response([
                    'code' => -1,
                    'error' => 'email is empty',
                    'result' => null
                ], 400);
            }

            $result = $this->user_model->check_email_exists($email);
            $this->response([
                'code' => 0,
                'error' => null,
                'result' => $result
            ], 200);

        }

        public function isUsernameAvailable_get() {
            // get the username
            // check in db
            // return the response
            $username = $this->get('username');
            if (!$username) {
                $this->response([
                    'code' => -1,
                    'error' => 'username is empty',
                    'result' => null
                ], 200);
            }

            $result = $this->user_model->check_username_exists($username);
            $this->response([
                'code' => 0,
                'error' => null,
                'result' => $result
            ], 200);
        }
    }

?>