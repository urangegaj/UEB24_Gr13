<?php

class StringManipulation {

    public static function formatPhoneNumber($phone) {

        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        
        return preg_replace('/(\d{3})(?=\d)/', '$1-', $cleaned);
    }

    public static function formatCreditCard($cardNumber) {

        $cleaned = preg_replace('/[^0-9]/', '', $cardNumber);
        
        return preg_replace('/(\d{4})(?=\d)/', '$1 ', $cleaned);
    }

    public static function cleanText($text) {

        $cleaned = preg_replace('/[^a-zA-Z0-9\s]/', '', $text);

        return preg_replace('/\s+/', ' ', trim($cleaned));
    }

    public static function extractEmails($text) {
        $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';
        preg_match_all($pattern, $text, $matches);
        return $matches[0];
    }


    public static function formatDate($date) {
        $patterns = [
            '/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/',
            '/^(\d{1,2})-(\d{1,2})-(\d{4})$/',
            '/^(\d{4})\/(\d{1,2})\/(\d{1,2})$/',
            '/^(\d{4})-(\d{1,2})-(\d{1,2})$/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $date, $matches)) {
                if (strlen($matches[1]) === 4) {
                    return sprintf('%04d-%02d-%02d', 
                        $matches[1], 
                        $matches[2], 
                        $matches[3]
                    );
                }
                return sprintf('%04d-%02d-%02d', 
                    $matches[3], 
                    $matches[1], 
                    $matches[2]
                );
            }
        }
        return '';
    }
}
?> 