<?php 

    class User_model extends CI_Model {
        public function __construct(){
            $this->load->database();
        }

        // insert user to database
        public function register($data) {
            // to be implemented
        }

        // user login
        public function login() {
            // to be implemented
        }

        // check email availability
        public function check_email_exists($email) {
            // to be implemented
            $query = $this->db->get_where('users', array( 'email' => $email ));
            if(empty($query->row_array())) {
                return true;
            } else {
                return false;
            }
        }

        // check username availability
        public function check_username_exists($username) {
            // to be implemented
            $query = $this->db->get_where('users', array( 'username' => $username ));
            if(empty($query->row_array())) {
                return true;
            } else {
                return false;
            }
        }
    }


?>