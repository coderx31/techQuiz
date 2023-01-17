<?php
    use chriskacerguis\RestServer\RestController;
    use Ramsey\Uuid\Uuid;
    use Firebase\JWT\JWT;

    class Users extends RestController {
        function __construct(){
            parent::__construct();
        }

        public function register_get() {
            $this->load->view('templates/header');
            $this->load->view('register');
            $this->load->view('templates/footer');
        }

        // user registration
        public function register_post() {
            try{
                $firstname = $this->post('firstname');
                $lastname = $this->post('lastname');
                $username = $this->post('username');
                $email = $this->post('email');
                $password = $this->post('password');
                $password2 = $this->post('password2');
    
                $isUsernameTaken = $this->user_model->check_username_exists($username);
                $isEmailTaken = $this->user_model->check_email_exists($email);
    
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
                } else if ($isUsernameTaken == true || $isEmailTaken == true) {
                    $this->response([
                        'code' => -1,
                        'error' => 'given username/email is already taken. choose another one',
                        'result' => null
                    ], 400);
                } else {
                    $data = array(
                        'user_id' => Uuid::uuid1(),
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'username' => $username,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    );
                    // encrypts the password
                    // save to database
                    $result = $this->user_model->register($data);
                    // return the response
                    $this->response([
                        'code' => 0,
                        'error' => null,
                        'result' => $result
                    ], 200);
                }
            } catch (Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        public function login_get() {
            $this->load->view('templates/header');
            $this->load->view('login');
            $this->load->view('templates/footer');
        }

        // user login
        public function login_post() {
            try {
                $username = $this->post('username');
                $password = $this->post('password');

                if (!$username || !$password) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters missing',
                        'result' => null
                    ],400);
                }
                $result = $this->user_model->login(array('username' => $username, 'password' => $password));

                // check the password validation
                if(!$result) {
                    // login failed
                    $this->response([
                        'code' => -1,
                        'error' => 'loggin failed',
                        'result' => $result
                    ],400);
                } else {
                    // generate jwt token
                    $key = 'example_key';
                    $payload = [
                        'user_id' => $result['user_id'],
                        'username' => $result['username']
                    ];

                    $jwtToken = JWT::encode($payload, $key, 'HS256');

                    // create the session
                    $user_data = array(
                        'user_id' => $result['user_id'],
                        'username' => $result['username'],
                        'logged_in' => true
                    );
                    $this->session->set_userdata($user_data);
                    // return the response
                    $this-> response([
                        'code' => 0,
                        'error' => null,
                        'user_id' => $result['user_id'],
                        'token' => $jwtToken
                    ],200);
                }
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        // user logout
        public function logout_post() {
            // to be implemented
            // unset the session
           try {
                $this->session->unset_userdata('logged_in');
                $this->session->unset_userdata('user_id');
                $this->session->unset_userdata('username');

                $this->response([
                    'code' => 0,
                    'error' => null,
                    'result' => 'user logged out successfully'
                ], 200);
           } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
           }
        }

        public function isEmailAvailable_get() {
            // get the email
            // check in db
            // return the response
            try {
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
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }

        }

        public function isUsernameAvailable_get() {
            // get the username
            // check in db
            // return the response
            try {
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
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code'=> -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }
    }

?>