<?php

class displayGig extends Controller
{

    public function __construct()
    {
        $this->GigHandlerModel = $this->model('GigHandler');
        $this->sellerHandlerModel = $this->model('sellerHandler');

    }


    public function index(){

        if(!isset($_SESSION["email"]) && !isset($_SESSION["password"])) {

            header("location: loginUser");

        }else{
            $data['var'] = "Display Gig Page";
            $data['title'] = "SkillSparq";
            $data['feedbacks'] = "";

            $gigId = $_GET['gigId'];
            

            //get gig details
            $gig = $this->GigHandlerModel->getGig($gigId);
            if ($gig) {

                $data['gig'] = mysqli_fetch_assoc($gig);

            } else {
                echo "<script>alert('Gig function is not Accessible!')</script>";
            }

            $this->view('displayGig', $data);
        }
    }


}

?>