<?php
function myErrorHandler($errno, $errstr, $errfile, $errline) {
    $pershkrimi = match ($errno) {
        E_USER_ERROR   => "Gabim kritik",
        E_USER_WARNING => "Paralajmërim",
        E_USER_NOTICE  => "Njoftim",
        E_NOTICE       => "Njoftim nga PHP",
        E_WARNING      => "Paralajmërim nga PHP",
        default        => "Gabim i panjohur"
    };

    echo "<div style='color:red; font-weight:bold;'>
        [$pershkrimi] - $errstr<br>
        Skedari: $errfile<br>
        Rreshti: $errline
    </div>";

    $logFile = __DIR__ . "/gabimet.txt";
    $logMsg = date("Y-m-d H:i:s") . " - [$pershkrimi] $errstr në $errfile linja $errline\n";
    error_log($logMsg, 3, $logFile);

    return true;
}

// Aktivizimi i handlerit
set_error_handler("myErrorHandler");
?>
