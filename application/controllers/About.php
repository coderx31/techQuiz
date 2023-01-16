<?php
    use chriskacerguis\RestServer\RestController;

    class About extends RestController {
        function __construct(){
            parent::__construct();
        }


        public function index_get() {
            $this->load->view('templates/header');
            $this->load->view('about');
            $this->load->view('templates/footer');
        }
    }

?>