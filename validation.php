<?php
class Validation {

    public static function validateEmail($email) {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Adresa e emailit nuk është valide.");
        }
        return true;
    }

    public static function validateDate($date) {
        $pattern = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/';
        if (!preg_match($pattern, $date)) {
            throw new Exception("Data nuk është në formatin e duhur (YYYY-MM-DD).");
        }
        return true;
    }

    public static function validatePhone($phone) {
        //lejon formate si: +383 49 123 456 ose 044-123-456
        $pattern = '/^\+?\d{2,3}[\s-]?\d{2,3}[\s-]?\d{3,4}$/';
        if (!preg_match($pattern, $phone)) {
            throw new Exception("Numri i telefonit nuk është në formatin e duhur.");
        }
        return true;
    }

    public static function validateNumeric($number, $decimals = 2) {
        $pattern = '/^-?\d+(\.\d{1,' . $decimals . '})?$/';
        if (!preg_match($pattern, $number)) {
            throw new Exception("Vlera numerike nuk është e vlefshme. Lejohen deri në $decimals decimal.");
        }
        return true;
    }
}
?>
