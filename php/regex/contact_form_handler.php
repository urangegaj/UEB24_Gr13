<?php
require_once 'validation.php';
require_once 'string_manipulation.php';
require_once 'dummy_data.php';

class ContactFormHandler {
    private $errors = [];
    private $data = [];
    private $submissions = [];

 
    public function processSubmission($postData) {
        $this->data['name'] = StringManipulation::cleanText($postData['name'] ?? '');
        if (empty($this->data['name'])) {
            $this->errors['name'] = 'Name is required';
        }

        $this->data['email'] = trim($postData['email'] ?? '');
        if (!Validation::validateEmail($this->data['email'])) {
            $this->errors['email'] = 'Invalid email address';
        }

        $this->data['message'] = StringManipulation::cleanText($postData['message'] ?? '');
        if (empty($this->data['message'])) {
            $this->errors['message'] = 'Message is required';
        }

        if (empty($this->errors)) {
            return $this->saveSubmission();
        }

        return false;
    }

    private function saveSubmission() {
        $this->submissions[] = [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'message' => $this->data['message'],
            'date' => date('Y-m-d H:i:s')
        ];
        
        return true;
    }


    public function getErrors() {
        return $this->errors;
    }


    public function getData() {
        return $this->data;
    }

    public function getRecentSubmissions() {

        $dummySubmissions = DummyData::getRecentSubmissions();
        
        return array_merge($this->submissions, $dummySubmissions);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $handler = new ContactFormHandler();
    
    if ($handler->processSubmission($_POST)) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Thank you! Your message has been sent.',
            'recent_submissions' => $handler->getRecentSubmissions()
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'errors' => $handler->getErrors()
        ]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    echo json_encode([
        'contact_info' => DummyData::getContactInfo(),
        'statistics' => DummyData::getStatistics()
    ]);
    exit;
}
?> 