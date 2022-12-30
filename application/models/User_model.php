<?php 

    class User_model extends CI_Model {
        public function __construct(){
            $this->load->database();
        }

        // insert user to database
        public function register($data) {
            return $this->db->insert('users', $data);
        }

        // user login
        public function login($data) {
            // to be implemented
            $this->db->where('username',$data['username']);
           // $this->db->where('password', $data['password']);

            $result = $this->db->get('users');
            if($result->num_rows() == 1) {
                // verify the password
                $isSuccess = password_verify($data['password'], $result->row(0)->password);
                if ($isSuccess) {
                    // return username and password
                    return array('user_id' => $result->row(0)->user_id, 'username' => $result->row(0)->username);
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        // check email availability
        public function check_email_exists($email) {
            $query = $this->db->get_where('users', array( 'email' => $email ));
            if(empty($query->row_array())) {
                return false;
            } else {
                return true;
            }
        }

        // check username availability
        public function check_username_exists($username) {
            // to be implemented
            $query = $this->db->get_where('users', array( 'username' => $username ));
            if(empty($query->row_array())) {
                return false;
            } else {
                return true;
            }
        }
    }


?>