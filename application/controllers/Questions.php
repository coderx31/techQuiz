<?php
    use chriskacerguis\RestServer\RestController;
    use Ramsey\Uuid\Uuid;

    class Questions extends RestController {
        function __construct(){
            parent::__construct();
        }


        // sample api with mock data
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

        public function index_get() {
            $this->load->view('templates/header');
            $this->load->view('questions');
            $this->load->view('templates/footer');
        }

        // get questions (all or with id)
        public function get_get() {
            try {
                $question_id = $this->get('question_id');
                $page = $this->get('page');

                $questions = null;
                $answers = null;

                if ($question_id){
                    // fetch the related question with all the details
                    $questions = $this->question_model->get_questions($question_id);
                    $answers   =  $this->answer_model->get_answers($question_id);

                    if ($questions) {
                        $this->response([
                            'code' => 0,
                            'error' => null,
                            'result' => [
                                'questions' => $questions,
                                'answers' => $answers
                            ]
                        ], 200);
                    } else {
                        $this->response([
                            'code' => -1,
                            'error' => 'no question found for given id',
                            'result' => null
                        ], 404);
                    }
                    
                } else {
                    // need to get the all the questions with the help of pagination
                    if (!$page) {
                        $page = 1;
                    }
                    $questions = $this->question_model->get_questions(null, $page);
                    if ($questions) {
                        $this->response([
                            'code' => 0,
                            'error' => null,
                            'result' => $questions
                        ], 200);
                    } else {
                        $this->response([
                            'code' => -1,
                            'error' => null,
                            'result' => null
                        ], 404);
                    }
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

        // create question
        public function create_post() {
            try {
                $user_id = '25614802-8592-11ed-a1eb-0242ac120002';
                $title = $this->post('title');
                $body = $this->post('body');
                if ($user_id === null || $title === null || $body === null || $user_id === "" || $title === "" || $body === "" ) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters missing',
                        'result' => null
                    ], 400);
                }
                $data = array(
                    'question_id' => Uuid::uuid1(),
                    'user_id' => $user_id,
                    'title' => $title,
                    'body' =>$body
                );

                $result = $this->question_model->create_question($data);

                $this->response([
                    'code' => 0,
                    'error' => null,
                    'result' => $result
                ], 201);
            } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
            }
        }

        // update question
        public function update_put($question_id) {
            // need to update the updateAt timestamp and updated value
            // get the details from parameters
            try {
                $user_id = '25614802-8592-11ed-a1eb-0242ac120002';
                $title = $this->put('title');
                $body = $this->put('body');
                if( $user_id === "" || $title === "" || $body === "" ) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters are empty',
                        'result' => null
                    ], 400);
                }

                $timestamp = time();
                // 2022-12-27 11:12:02

                $data = array(
                    'title' => $title,
                    'body' => $body,
                    'updatedAt' => date("Y-m-d h:m:s",$timestamp),
                    'updated' => 1
                );
                
                $result = $this->question_model->update_question($question_id, $data);
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

        // delete question
        public function delete_delete($question_id) {
           try {
                if ($question_id === null || $question_id === "" ) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters missing',
                        'result' => null
                    ], 400);
                }
                $result = $this->question_model->delete_question($question_id);
                $this->response([], 204);
           } catch(Exception $e) {
                log_message('error', 'error =>'.$e->getMessage());
                $this->response([
                    'code' => -1,
                    'error' => $e->getMessage(),
                    'result' => null
                ], 500);
           }
        }

        // increase votes
        public function upvote_put($question_id) {
            try {
                if($question_id === null || $question_id === "" ) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters are missing',
                        'result' => null
                    ], 400);
                }
                $result = $this->question_model->increase_votes($question_id);
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


        // decrease votes
        public function downvote_put($question_id) {
            try {
                if($question_id === null || $question_id === "" ) {
                    $this->response([
                        'code' => -1,
                        'error' => 'mandatory parameters missing',
                        'result' => null
                    ], 400);
                }
                $result = $this->question_model->decrease_votes($question_id);
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
    }


?>