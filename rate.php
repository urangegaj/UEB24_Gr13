<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'])) {
    $rating = intval($_POST['rating']); 

    if ($rating >= 1 && $rating <= 5) {
        //manipulimi me file
        $file = fopen("ratings.txt", "a");
        if ($file) {
            fwrite($file, $rating . "\n");
            fclose($file);
        }

        function showRatingMessage($rating) {
            switch ($rating) {
                case 5: return "Thank you for your 5-star rating! We're thrilled you loved it!";
                case 4: return "Thank you for your 4-star rating! We appreciate your feedback.";
                case 3: return "Thank you for your 3-star rating! We're glad you liked it.";
                case 2: return "Thank you for your 2-star rating! We're sorry it wasn't perfect.";
                case 1: 
                default: return "Thank you for your 1-star rating! We'll strive to improve!";
            }
        }

        echo showRatingMessage($rating);
    } else {
        echo "Invalid rating.";
    }
}
?>
