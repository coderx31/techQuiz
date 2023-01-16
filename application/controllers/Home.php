<?php
    use chriskacerguis\RestServer\RestController;

    class Home extends RestController {
        function __construct(){
            parent::__construct();
        }


        public function index_get() {
            $this->load->view('templates/header');
            $this->load->view('home');
            $this->load->view('templates/footer');
        }
    }

?>