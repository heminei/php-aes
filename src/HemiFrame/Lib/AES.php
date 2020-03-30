<?php

namespace HemiFrame\Lib;

class AES
{

    private $key = null;
    private $data = null;
    private $method = "aes-256-cbc";
    private $iv = "1234567891234567";

    /**
     *
     * @param mixed $data
     * @param string $key
     * @param string $method
     */
    function __construct($data = null, ?string $key = null, string $method = "aes-256-cbc")
    {
        if ($data !== null) {
            $this->setData($data);
        }
        if ($key !== null) {
            $this->setKey($key);
        }
        $this->setMethod($method);
    }

    /**
     * Get encrypt/decrypt key
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * Return encoded or decoded string
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get selected cipher method
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get available cipher methods
     * @return array
     */
    public static function getAvailableMethods(bool $aliases = false): array
    {
        return openssl_get_cipher_methods($aliases);
    }

    /**
     * Gets selected iv string
     * @return string
     */
    public function getIv(): string
    {
        return $this->iv;
    }

    /**
     * Generate a iv string for selected method
     * @return string|bool
     */
    public function generateIv()
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * Gets the cipher iv length
     * @return int|bool
     */
    public function getIvLength()
    {
        return openssl_cipher_iv_length($this->method);
    }

    /**
     * Set encrypt/decrypt key
     * @param string $key
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setKey(string $key): self
    {
        if (empty($key)) {
            throw new \InvalidArgumentException("Key is empty.");
        }
        $this->key = $key;
        return $this;
    }

    /**
     * Set encrypt/decrypt method
     * @param string $method
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setMethod(string $method): self
    {
        $method = strtolower($method);

        if (!in_array($method, $this->getAvailableMethods())) {
            throw new \InvalidArgumentException("The method is not available");
        }
        $this->method = $method;
        return $this;
    }

    /**
     * Set iv string
     * @param string $iv
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setIv(string $iv): self
    {
        if (strlen($this->getIv()) != $this->getIvLength()) {
            throw new \InvalidArgumentException("Iv lenght must be " . $this->getIvLength());
        }
        $this->iv = $iv;

        return $this;
    }

    /**
     * Set encrypt/decrypt data
     * @param mixed $data
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setData($data): self
    {
        if (empty($data)) {
            throw new \InvalidArgumentException("Data is empty.");
        }
        $this->data = $data;
        return $this;
    }

    /**
     * Returns the encrypted string on success or FALSE on failure.
     * @return string|bool
     * @throws \InvalidArgumentException
     */
    public function encrypt()
    {
        if (empty($this->getKey())) {
            throw new \InvalidArgumentException("Please set key.");
        }
        if (empty($this->getData())) {
            throw new \InvalidArgumentException("Please set data.");
        }
        return openssl_encrypt($this->data, $this->method, $this->key, 0, $this->getIv());
    }

    /**
     * The decrypted string on success or FALSE on failure.
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function decrypt()
    {
        if (empty($this->getKey())) {
            throw new \InvalidArgumentException("Please set key.");
        }
        if (empty($this->getData())) {
            throw new \InvalidArgumentException("Please set data.");
        }
        return openssl_decrypt($this->data, $this->method, $this->key, 0, $this->getIv());
    }
}
