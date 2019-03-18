<?php
namespace Lsclh\Openssl;
/**
 * Aes对称性加密
 * Class Aes
 * @package Utility\Openssl
 */
class Aes{

    private $encryptMethod = 'aes-256-cbc'; //加密的算法方式

    private $key = 'secret';

    private $iv = 'eSt58yvMGaIUHRfsLlXhMg==';

    public function __construct($key){
        $this->key = $key;
    }

    /**
     * 获取加密算法的偏移量IV 同一组数据 必须使用同一个iv才能加解密
     * @return string
     */
    private function getIV(){
        $ivLength = openssl_cipher_iv_length($this->encryptMethod);
        return openssl_random_pseudo_bytes($ivLength, $isStrong);
    }

    /**
     * 加密
     * @param $data 明文
     * @return string
     */
    public function lock($data){
        $iv = $this->getIV();
        $data = openssl_encrypt($data, $this->encryptMethod, $this->key, 0,$iv);
        return ['iv'=>base64_encode($iv),'data'=>$data];
    }

    /**
     * 解密
     * @param $data 密文
     * @param $iv 偏移量
     * @return string
     */
    public function unlock($data,$iv){
        return openssl_decrypt($data, $this->encryptMethod, $this->key, 0, base64_decode($iv));
    }

}
