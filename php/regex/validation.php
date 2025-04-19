<?php

class Validation {

    public static function validateEmail($email) {
        $email = trim($email); 
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateDate($date) {
    
        $pattern = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
        return preg_match($pattern, $date) === 1;
    }

    public static function validatePhone($phone) {
     
        $pattern = '/^\+?\d{1,3}[-\s]?\d{3,4}[-\s]?\d{3,4}$/';
        return preg_match($pattern, $phone) === 1;
    }

 
    public static function validateNumeric($number, $decimals = 2) {
       
        $pattern = '/^-?\d+(\.\d{1,' . $decimals . '})?$/';
        return preg_match($pattern, $number) === 1;
    }
}


?> 