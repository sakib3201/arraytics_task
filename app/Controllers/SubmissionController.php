<?php

namespace App\Controllers;

use App\Models\Submission;
use Core\Controller;

class SubmissionController extends Controller {
    public function index() {
        $this->render('form');
    }

    public function submitForm() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            if (isset($_COOKIE['submitted'])) {
                echo json_encode(["status" => "error", "message" => "You can only submit once every 24 hours."]);
                exit;
            }

            $submission = new Submission();
            $data = [
                "amount" => $_POST['amount'],
                "buyer" => $_POST['buyer'],
                "receipt_id" => $_POST['receipt_id'],
                "items" => implode(",", $_POST['items']),
                "buyer_email" => $_POST['buyer_email'],
                "buyer_ip" => $_SERVER['REMOTE_ADDR'],
                "note" => $_POST['note'],
                "city" => $_POST['city'],
                "phone" => "880" . $_POST['phone'],
                "entry_at" => date("Y-m-d"),
                "entry_by" => $_POST['entry_by']
            ];

            if ($submission->addSubmission($data)) {
                setcookie("submitted", "true", time() + 86400, "/");
                echo json_encode(["status" => "success", "message" => "Form submitted successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Submission failed."]);
            }
        }
    }

    public function showSubmissions() {
        $userId = $_GET['id'] ?? null;
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        
        $submissionModel = new Submission();
        $filteredSubmissions = $submissionModel->filterSubmissions($startDate, $endDate, $userId);
        
        $this->render('report', ['submissions' => $filteredSubmissions]);
    }
}
