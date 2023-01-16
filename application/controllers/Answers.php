<?php

    use chriskacerguis\RestServer\RestController;
    use Ramsey\Uuid\Uuid;

    class Answers extends RestController {
        function __construct() {
            parent::__construct();
        }

        // create and api for testing purposes to get the answers
        public function get_get() {
            try {
                $answer_id = $this->get('answer_id');
                $answers = $this->answer_model->get_answers($answer_id);
                if($answers) {
                    $this->response([
                        'code' => 0,
                        'error' => null,
                        'result' => $answers
                    ], 200);
                } else {
                    $this->response([
                        'code' => -1,
                        'error' => 'No answers yet',
                        'result' => null
                    ], 404);
                }
            } catch (Exception $e) {
                // TODO need to update the error message and added the loggin support when ready to release
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        // create answer
        public function create_post() {
            try {
                // user authentication
                // validate the user
                $token = $this->input->request_headers()['x-auth'];
                $isValid = validateJWTToken($token);
                $decodedToken = (array)decodeJWTToken($token);
                if ($isValid && $this->session->userdata('logged_in')) {
                    $question_id = $this->post('question_id');
                    $body = $this->post('body');
                    $user_id = $decodedToken['user_id'];
                    if($question_id === "" || $body === "" || $user_id === "" ) {
                        $this->response([
                            'code' => -1,
                            'error' => 'mandatory parameters are missing',
                            'result' => null,
                        ], 400);
                    }
                    $data = array(
                        'answer_id' => Uuid::uuid1(),
                        'question_id' => $question_id,
                        'user_id' => $user_id,
                        'body' => $body
                    );

                    $result = $this->answer_model->create_answer($data);
                    $this->response([
                        'code' => 0,
                        'error' => null,
                        'result' => $result
                    ], 201);
                } else {
                    $this->response([
                        'code' => -1,
                        'error' => 'unauthorized',
                        'result' => null
                    ], 401);
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

        // update answer
        public function update_put($answer_id) {
            try {
                $token = $this->input->request_headers()['x-auth'];
                $isValid = validateJWTToken($token);
                $decodedToken = (array)decodeJWTToken($token);
                $user_id = $this->answer_model->get_user($answer_id);
                // only created user can edit the question
                if ($isValid && $this->session->userdata('logged_in') && $user_id === $decodedToken['user_id']) {
                    $body = $this->put('body');
                    if ($body === "" || $answer_id === "" ) {
                        $this->response([
                            'code' => -1,
                            'error' => 'mandatory parameters missing',
                            'result' => null
                        ], 400);
                    }
    
                    $data = array(
                        'body' => $body
                    );
    
                    $result = $this->answer_model->update_answer($answer_id, $data);
                    $this->response([
                        'code' => 0,
                        'error' => null,
                        'result' => $result
                    ], 200);
                } else {
                    $this->response([
                        'code' => -1,
                        'error' => 'unauthorized',
                        'result' => null
                    ], 401);
                }
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error'=> $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        // delete answer
        public function delete_delete($answer_id) {
            try {
                $token = $this->input->request_headers()['x-auth'];
                $isValid = validateJWTToken($token);
                $decodedToken = (array)decodeJWTToken($token);
                $user_id = $this->answer_model->get_user($answer_id);
                if ($isValid && $this->session->userdata('logged_in') && $user_id === $decodedToken['user_id']) {
                    if($answer_id === "") {
                        $this->response([
                            'code' => -1,
                            'error' => 'mandatory parameters missing',
                            'result' => null
                        ], 400);
                    } 
        
                    $result = $this->answer_model->delete_answer($answer_id);
                    $this->response([], 204);
                } else {
                    $this->response([
                        'code' => -1,
                        'error' => 'unauthorized',
                        'result' => null
                    ], 401);
                }
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => 1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        // upvote for an answer
        public function upvote_put($answer_id) {
            try {
                $token = $this->input->request_headers()['x-auth'];
                $isValid = validateJWTToken($token);
                if ($isValid && $this->session->userdata('logged_id')) {
                    if ($answer_id === "" ) {
                        $this->response([
                            'code' => -1,
                            'error' => 'mandatory parameters missing',
                            'result' => null,
                        ], 400);
                    }
        
                    $result = $this->answer_model->increase_vote($answer_id);
                    $this->response([
                        'code' => 0,
                        'error' => null,
                        'result' => $result
                    ], 200);
                } else {
                    $this->response([
                        'code' => -1,
                        'error' => 'unauthorized',
                        'result' => null
                    ], 401);
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

        // downvote for an answer
        public function downvote_put($answer_id) {
           try {
            $token = $this->input->request_headers()['x-auth'];
            $isValid = validateJWTToken($token);
            if ($isValid && $this->session->userdata('logged_in')) {
                if (!$answer_id) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters',
                        'result' => null
                    ], 400);
                }
    
                $result = $this->answer_id->decrease_model($answer_id);
                $this->response([
                    'code' => 0,
                    'error' => null,
                    'result' => $result
                ], 200);
            } else {
                $this->response([
                    'code' => -1,
                    'error' => 'unauthorized',
                    'result' => null
                ], 401);
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
    }

?>