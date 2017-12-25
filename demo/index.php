<?php

require_once '../vendor/autoload.php';

$aes = new \HemiFrame\Lib\AES();
$aes->setKey("testkey");
$aes->setData("testdata");

$ivString = $aes->generateIv();
$aes->setIv($ivString);

$encryptedString = $aes->encrypt();
$aes->setData($encryptedString);
$decryptedString = $aes->decrypt();

echo "Available methods: " . implode(",", $aes->getAvailableMethods()) . "<br/><br/>" . PHP_EOL;
echo "IV string: " . $ivString . "<br/>" . PHP_EOL;
echo "Encrypted string: " . $encryptedString . "<br/>" . PHP_EOL;
echo "Decrypted string: " . $decryptedString . "<br/>" . PHP_EOL;
