<?php
    use chriskacerguis\RestServer\RestController;

    class Contact extends RestController {
        function __construct(){
            parent::__construct();
        }


        public function index_get() {
            $this->load->view('templates/header');
            $this->load->view('contact');
            $this->load->view('templates/footer');
        }
    }

?>