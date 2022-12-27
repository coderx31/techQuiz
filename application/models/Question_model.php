<?php 
    class Question_model extends CI_Model {
        public function __construct() {
            $this->load->database();
        }

        // get questions (with or without id)
        public function get_questions($id = null) {
            if($id === null) {
                $this->db->order_by('question_id', 'DESC');
                $query = $this->db->get('questions');
                return $query->result_array();
            } 

            $query = $this->db->get_where('questions', array('question_id' => $id));
            return $query->row_array();
        }

        // create a question -> TODO need to add user validation
        public function create_question($data) {
            return $this->db->insert('questions', $data);
        }


        // update the question
        public function update_question($question_id, $data) {
            $this->db->where('question-id', $question_id);
            return $this->db->update('questions', $data);
        }


        // delete the question
        public function delete_question($question_id) {
            $this->db->where('question-id', $question_id);
            $this->db->delete('questions');
            return true;
        }
    }


?>