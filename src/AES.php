<?php

/**
  AES encryption
 */
class AES {

	private $key = AES_KEY;
	private $type = "AES-256-CBC";
	private $data = null;

	/**
	 *
	 * @param string $data
	 * @param string $key
	 * @param string $type
	 */
	function __construct($data = null, $key = null, $type = null) {
		if (!empty($data)) {
			$this->setData($data);
		}
		if (!empty($key)) {
			$this->setKey($key);
		}
		if (!empty($type)) {
			$this->setType($type);
		}
	}

	/**
	 *
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 *
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 *
	 * @param string $key
	 * @return $this
	 */
	public function setKey($key) {
		$this->key = $key;
		return $this;
	}

	/**
	 * [0] => AES-128-CBC
	 * [1] => AES-128-CFB
	 * [2] => AES-128-CFB1
	 * [3] => AES-128-CFB8
	 * [4] => AES-128-ECB
	 * [5] => AES-128-OFB
	 * [6] => AES-192-CBC
	 * [7] => AES-192-CFB
	 * [8] => AES-192-CFB1
	 * [9] => AES-192-CFB8
	 * [10] => AES-192-ECB
	 * [11] => AES-192-OFB
	 * [12] => AES-256-CBC
	 * [13] => AES-256-CFB
	 * [14] => AES-256-CFB1
	 * [15] => AES-256-CFB8
	 * [16] => AES-256-ECB
	 * [17] => AES-256-OFB
	 * @param string $type
	 * @return $this
	 */
	public function setType($type = "AES-256-CBC") {
		$this->type = $type;
		return $this;
	}

	/**
	 *
	 * @param string $data
	 * @return $this
	 */
	public function setData($data) {
		$this->data = $data;
		return $this;
	}

	/**
	 *
	 * @return boolean
	 */
	public function validateParams() {
		if (!empty($this->data) && !empty($this->type) && !empty($this->key)) {
			return true;
		}
		return false;
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	public function encrypt() {
		$this->validateParams();
		return base64_encode(openssl_encrypt($this->data, $this->type, $this->key, 0, $this->getIv())) . ":iv:" . base64_encode($this->getIv());
	}

	/**
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function decrypt() {
		$this->validateParams();
		$dataArray = explode(":iv:", $this->data);
		return openssl_decrypt(base64_decode($dataArray[0]), $this->type, $this->key, 0, base64_decode($dataArray[1]));
	}

	private function getIv() {
		return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->type));
	}

}
