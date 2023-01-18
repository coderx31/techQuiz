<?php
    class Answer_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }


        // get answers with or without id
        public function get_answers($question_id = null) {

            $query = $this->db->get_where('answers', array('question_id' => $question_id));
            return $query->result_array();
        }

        public function get_answer($answer_id) {
            $query = $this->db->get_where('answers', array('answer_id' => $answer_id));
            return $query->row_array();
        }

        public function get_user($answer_id) {
            $this->db->select('user_id');
            $query = $this->db->get_where('answers', array('answer_id' => $answer_id));
            return $query->row_array();
        }

        // create answer
        public function create_answer($data) {
            return $this->db->insert('answers', $data);
        }

        // update answer
        public function update_answer($answer_id, $data) {
            $this->db->where('answer_id', $answer_id);
            return $this->db->update('answers', $data);
        }

        // delete answer
        public function delete_answer($answer_id) {
            $this->db->where('answer_id', $answer_id);
            $this->db->delete('answers');
            return true;
        }

        // upvote for an answer
        public function increase_vote($answer_id) {
            $this->db->where('answer_id', $answer_id);
            $this->db->set('votes', 'votes+1', FALSE);
            $this->db->update('answers');
            return true;
        }

        // downvote for an answer
        public function decrease_vote($answer_id) {
            $this->db->where('answer_id', $answer_id);
            $this->db->set('votes', 'votes-1', FALSE);
            $this->db->update('answers');
        }
    }

?>