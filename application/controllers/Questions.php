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

        // get questions (all or with id)
        public function get_get() {
            $id = $this->get('id');
            $questions = $this->question_model->get_questions($id);
            if($questions) {
                $data = array(
                    'code' => 0,
                    'error' => null,
                    'result' => $questions
                );
                $this->response($data, 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'No questions yet'
                ], 404);
            }


        }

        // create question
        public function create_post() {

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
        }

        // update question
        public function update_put($question_id) {
            // need to update the updateAt timestamp and updated value
            // get the details from parameters
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

        }

        // delete question
        public function delete_delete($question_id) {
            if ($question_id === null || $question_id === "" ) {
                $this->response([
                    'code' => -1,
                    'error' => 'mandatory parameters missing',
                    'result' => null
                ], 400);
            }
            $result = $this->question_model->delete_question($question_id);
            $this->response([], 204);
        }

        // increase votes
        public function upvote_put($question_id) {
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
        }


        // decrease votes
        public function downvote_put($question_id) {
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
        }
    }


?>