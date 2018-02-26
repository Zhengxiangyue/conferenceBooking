<?php
/**
 * Created by PhpStorm.
 * User: Cancel
 * Date: 18/2/2017
 * Time: 11:11 AM
 */

class MY_ssl {

    public $pubkey;
    public $privkey;

    // 公钥 加密 私钥解密

    function set_key($privatekey,$publickey) {
        $this->pubkey = $publickey;
        $this->privkey = $privatekey;
    }

    public function encrypt($data) {
        if (openssl_public_encrypt($data, $encrypted, $this->pubkey))
            $data = base64_encode($encrypted);
        else
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');

        return $data;
    }

    public function decrypt($data) {
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))
            $data = $decrypted;
        else
            $data = false;

        return $data;
    }

}