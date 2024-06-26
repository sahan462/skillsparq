<?php

class viewRefunds extends Controller
{
    private $paymentHandlerModel;
    private $inquiryHandlerModel;

    public function __construct()

    {
        $this->inquiryHandlerModel = $this->model('InquiryHandler');
        $this->paymentHandlerModel = $this->model('paymentHandler');
    }

    public function index()
    {

        $data['var'] = "viewRefunds";
        $data['title'] = "SkillSparq";
        $payment_id = isset($_GET['payment_id']) ? $_GET['payment_id'] : null;
        $data['payment_id'] = $payment_id;
        $refund = $this->paymentHandlerModel->viewRefund();
        $data['refund'] = $refund;
        $viewrefund = $this->paymentHandlerModel->viewRefundDetails($payment_id);
        $data['viewrefund'] = $viewrefund;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $response = $_POST['response'];
            $this->inquiryHandlerModel->updateRefund($payment_id, $response);
            // Optionally, redirect to a different page after adding the response

        }



        $this->view('viewRefunds', $data);
    }
}
