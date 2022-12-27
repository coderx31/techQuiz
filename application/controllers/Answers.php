<?php

    use chriskacerguis\RestServer\RestController;
    use Ramsey\Uuid\Uuid;

    class Answers extends RestController {
        function __construct() {
            parent::__construct();
        }

        // create and api for testing purposes to get the answers
        public function get_get() {
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
        }

        // create answer
        public function create_post() {
            $question_id = $this->post('question_id');
            $body = $this->post('body');
            // might need to fetch the user id from session
            // will be implemented when the user login feature completed
            $user_id = '25614802-8592-11ed-a1eb-0242ac120002';
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
        }

        // update answer
        public function update_put($answer_id) {
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
        }

        // delete answer
        public function delete_delete($answer_id) {
            if($answer_id === "") {
                $this->response([
                    'code' => -1,
                    'error' => 'mandatory parameters missing',
                    'result' => null
                ], 400);
            } 

            $result = $this->answer_model->delete_answer($answer_id);
            $this->response([], 204);
        }

        // upvote for an answer
        public function upvote_put($answer_id) {
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
        }

        // downvote for an answer
        public function downvote_put($answer_id) {
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
        }
    }

?>