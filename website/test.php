<?php


require_once "passwordRecoveryLib.php";

date_default_timezone_set("Europe/Helsinki");
echo "Europe:". time();
echo "<br>";

$time = time();

echo 'Data: '. date('Y-m-d', $time) . "\n";

echo 'Next Week: '. date('Y-m-d', strtotime('+1 week')) ."\n";

$token = generateToken(32);

echo "token: " . $token;
echo "<br>";

echo hash("sha512", $token);


?>