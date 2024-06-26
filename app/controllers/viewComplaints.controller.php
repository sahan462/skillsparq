<?php

class viewComplaints extends Controller
{

    private $inquiryHandlerModel;
    public function __construct()
    {

        $this->inquiryHandlerModel = $this->model('inquiryHandler');
    }

    public function index()
    {

        $inquiry_id = isset($_GET['inquiry_id']) ? $_GET['inquiry_id'] : null;

        $data['var'] = "viewComplaints";
        $data['title'] = "SkillSparq";
        $data['inquiryId'] = $inquiry_id;
        $viewComplaint = $this->inquiryHandlerModel->viewComplaints($inquiry_id);
        $data['viewComplaint'] = $viewComplaint;
        $deliveries = $this->inquiryHandlerModel->getDeliverables($inquiry_id);
        $data['deliveries'] = $deliveries;



        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['user_id_to_blacklist'])) {
                $user_id = $_POST['user_id_to_blacklist'];
                $user_email = $_POST['user_email_to_blacklist'];
                $days = $_POST['blacklistUntil'];
                $reason = $_POST['reason'];

                // Process the blacklist update in database
                // Send email notification



                $today = new DateTime();

                $today->modify("+$days days");

                $endDate = $today->format('Y-m-d');
                $body = "<!DOCTYPE html>
                <html>
                <head>
                    <style>
                        .container {
                            font: 400 16px/24px Macan, Helvetica Neue, Helvetica, Arial, sans-serif;
                            background-color: #ffffff;
                            padding: 32px 16px 32px 16px;
                            border-radius: 10px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                            max-width: 600px;
                            margin: 0 auto;
                        }
                        .header {
                            text-align: center;
                            font-size: 24px;
                            font-weight: bold;
                            margin-bottom: 32px;
                        }
                        .content {
                            font-size: 16px;
                            color: #333;
                        }
                        .methods{
                            margin-top: 16px;
                            margin-bottom: 16px;
                        }
                        p{
                            margin: 0;
                            margin-bottom: 8px;
                        }
                        .btn {
                            display: inline-block;
                            width: 230px;
                            text-align: center;
                            margin-bottom: 16px;
                            padding: 10px 20px;
                            background-color: #4CAF50;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            font-size: 16px;
                            text-decoration: none;
                            cursor: pointer;
                        }
                        .otp {
                            background-color: #4CAF50;
                            text-align: center;
                            width: 250px;
                            color: #fff;
                            font-size: 20px;
                            font-weight: bold;
                            border-radius: 5px;
                            display: inline-block;
                            padding: 10px;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>Account Suspension Notice</div>
                        <div class='content'>
                            <p>Hello  ID: $user_id,</p>
                            <p>We regret to inform you that your account has been suspended from SKILLSPARQ due to $reason. This suspension will last until $endDate. During this period, you will not be able to access your account or use any services provided by SKILLSPARQ.</p>
                            <p>Please note that any ongoing or pending projects may be affected by this suspension. It is important to resolve the issues as outlined to prevent future suspensions.</p>
                            <p>If you believe this to be a mistake or wish to discuss this further, please contact our support team directly.</p>
                            <p>Thank you for your attention to this matter.</p>
                            <p>Best Regards,</p>
                            <p>The SKILLSPARQ Team</p>
                        </div>
                    </div>
                </body>
                </html>
                ";
                $this->sendVerificationMail($user_email, $user_id, "Sorry You have been banned from skillsparq website", $body, "");
                $this->inquiryHandlerModel->blackListBuyer();
            } elseif (isset($_POST['payment_id'])) {
                $payment_id = $_POST['payment_id'];
                $this->inquiryHandlerModel->refund();
            } elseif (isset($_POST['seller_id_email'])) {
                $seller_id = $_POST['seller_id_email'];
                $buyer_id = $_POST['buyer_id_email'];
                $buyer_reason = $_POST['resolveBuyer'];
                $viewComplaint = $_POST['complaint_id'];
                $subject = "Solution regarding the complaint_id: $viewComplaint";
                $this->sendVerificationMail($seller_id, 1, $subject, $buyer_reason, "");
                $this->sendVerificationMail($buyer_id, 1, $subject, $buyer_reason, "");
                $this->inquiryHandlerModel->updateInquiry();
            }
        }

        $this->view('viewComplaints', $data);
    }
}
