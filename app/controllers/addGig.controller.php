<?php

class AddGig extends Controller
{
    public function __construct()
    {
        // $this->JobHandlerModel = $this->model('jobHandler');
        $this->GigHandlerModel = $this->model('GigHandler');
    }

    public function index()
    {
        $data['var'] = "Add Gig";
        $data['title'] = "SkillSparq";
        $data['errors'] = $this->initiate();

        $this->view('addGig', $data);
    }


    public function initiate()
    {
        // Initialize error array
        $errors = array();
        $errors["password"] = "";
        $errors["email"] = "";
        $errors["agreement"] = "";

        return $errors;
    }

    public function CreateGig()
    {
    }

    public function viewGig()
    {
    }
    public function updateGig()
    {
    }

    public function deleteGig()
    {
    }
}