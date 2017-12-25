# PHP class for encrypt and decrypt data with AES algorithm

## Supports
- custom iv
- auto generated iv
- encode and decode data

## Requirements
PHP >= 7.0

## Installation

Enter in composer.json
```json
{
    "require": {
        "hemiframe/php-aes": "~1.1"
    }
}
```

or run in console: `php composer.phar require hemiframe/php-aes`


## Example

```php
require_once('vendor/autoload.php');

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
```


## Documentation

### Methods
    /**
     * Get encrypt/decrypt key
     * @return string
     */
    public function getKey(): string

    /**
     * Return encoded or decoded string
     * @return mixed
     */
    public function getData();

    /**
     * Get selected cipher method
     * @return string
     */
    public function getMethod(): string

    /**
     * Get available cipher methods
     * @return array
     */
    public function getAvailableMethods(bool $aliases = false): array

    /**
     * Gets selected iv string
     * @return string
     */
    public function getIv(): string

    /**
     * Generate a iv string for selected method
     * @return string|bool
     */
    public function generateIv();

    /**
     * Gets the cipher iv length
     * @return int|bool
     */
    public function getIvLength();

    /**
     * Set encrypt/decrypt key
     * @param string $key
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setKey(string $key): self

    /**
     * Set encrypt/decrypt method
     * @param string $method
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setMethod(string $method);

    /**
     * Set iv string
     * @param string $iv
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setIv(string $iv): self

    /**
     * Set encrypt/decrypt data
     * @param mixed $data
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setData($data): self

    /**
     * Returns the encrypted string on success or FALSE on failure.
     * @return string|bool
     * @throws \InvalidArgumentException
     */
    public function encrypt();

    /**
     * The decrypted string on success or FALSE on failure.
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function decrypt();
```
