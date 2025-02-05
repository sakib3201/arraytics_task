<?php

namespace App\Controllers;

use App\Models\Submission;
use Core\Controller;
use Exception;
use RuntimeException;

class SubmissionController extends Controller {
    public function index() {
        $this->render('form');
    }

    public function submitForm() {
        if (isset($_COOKIE['submitted'])) {
            echo json_encode(["status" => "error", "message" => "You can only submit once every 24 hours. Triggered from backend"]);
            exit;
        }

        $errors = $this->validateRequest($_POST);
        
        if (!empty($errors)) {
            echo json_encode(["status" => "error", "message" => "Validation errors:". implode("<br>",$errors), ]);
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
            "phone" => $_POST['phone'], // 880 is prepended via JS
            "entry_at" => date("Y-m-d"),
            "entry_by" => $_POST['entry_by'],
            "hash_key" => generateHashKey($_POST['receipt_id']),
        ];

        if ($submission->addSubmission($data)) {
            setcookie("submitted", "true", time() + 86400, "/");
            echo json_encode(["status" => "success", "message" => "Form submitted successfully. You need to wait 24 hours before you can submit again."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Submission failed."]);
        }
    }

    private function validateRequest($request) {
            $errors = [];

            // Validate amount
            if (!preg_match('/^\d+$/', $request['amount'])) {
                $errors['amount'] = "Amount must be a number.";
            }

            // Validate buyer
            if (!preg_match('/^[\p{L}\s\d]{1,20}$/u', $request['buyer'])) {
                $errors['buyer'] = "Buyer must be text, spaces, numbers, and not more than 20 characters.";
            }

            // Validate receipt_id
            if (!is_string($request['receipt_id'])) {
                $errors['receipt_id'] = "Receipt ID must be text.";
            }

            // Validate items
            $items = implode(",", $request['items']);
            if (!is_string($items)) {
                $errors['items'] = "Items must be text.";
            }

            // Validate buyer_email
            if (!filter_var($request['buyer_email'], FILTER_VALIDATE_EMAIL)) {
                $errors['buyer_email'] = "Invalid email format.";
            }

            // Validate note
            if (str_word_count($request['note']) > 30 || !is_string($request['note'])) {
                $errors['note'] = "Note must be less than 30 words and can contain Unicode characters.";
            }

            // Validate city
            if (!preg_match('/^[\p{L}\s]+$/u', $request['city'])) {
                $errors['city'] = "City must contain only text and spaces.";
            }

            // Validate phone
            if (!preg_match('/^\d+$/', $request['phone'])) {
                $errors['phone'] = "Phone must contain only numbers.";
            }
            
            // Validate entry_by
            if (!preg_match('/^\d+$/', $request['entry_by'])) {
                $errors['entry_by'] = "Entry By must be a number.";
            }

            return $errors;
    }

    public function showSubmissions() {
        $userId = $_GET['id'] ?? null;
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;
        
        try {
            $submission = new Submission();
            $filteredSubmissions = $submission->filterSubmissions($startDate, $endDate, $userId);
        } catch (Exception $e) {
            throw new RuntimeException('Failed to retrieve submissions data', 0, $e);
        }

        $this->render('report', ['submissions' => $filteredSubmissions]);
    }
}
