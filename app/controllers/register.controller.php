<?php

class Register extends Controller
{

    public function index(){

        $data['var'] = "Home Page";
        $data['title'] = "SkillSparq";

        $this->view('register', $data);
    }

}

?>