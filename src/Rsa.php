<?php
// +----------------------------------------------------------------------
// | Created by PhpStorm.©️
// +----------------------------------------------------------------------
// | User: 程立弘
// +----------------------------------------------------------------------
// | Date: 2018/10/21 17:09
// +----------------------------------------------------------------------
// | Author: 程立弘 <1019759208@qq.com>
// +----------------------------------------------------------------------

namespace Lsclh\Openssl;

/**
 * php非对称加密算法功能封装 RSA算法加密 https的加密方式也是用的这个加密算法
 * Class Rsa
 * @package Utility\Openssl
 */
class Rsa
{

    private $publicKey = '-----BEGIN PUBLIC KEY-----
MFwwDQYJKoZIhvcNAQEBBQADSwAwSAJBAKFIw9sdDfHloQImvKJR8XfoQuQQJeKu
H8G2jJmPPLtmgRXhToPgvb5OGBFsVo8VO/kKfk5jzdN9G9HDE7eq+jMCAwEAAQ==
-----END PUBLIC KEY-----';
    private $privateKey = '-----BEGIN PRIVATE KEY-----
MIIBUwIBADANBgkqhkiG9w0BAQEFAASCAT0wggE5AgEAAkEAoUjD2x0N8eWhAia8
olHxd+hC5BAl4q4fwbaMmY88u2aBFeFOg+C9vk4YEWxWjxU7+Qp+TmPN030b0cMT
t6r6MwIDAQABAkA1ZKFyKGw1aI+k5q4MDpSh3YJHfhEMuhhJSOXC8GhqoT4Q90S2
cJQBQpsPYtuh5nW0HqjWDvk/EbBQfMl9yjoBAiEAyzmVcaS1WpO/uRjKQ4QqEuFK
akBisFhNc095P5pjXOcCIQDLKvWEu82fvw5qFhvnL+WYiwzDYq3d4cJbFEH4bRgi
1QIgLuOVYIghM8ndNYbLvDI1Ru/mLIe4fXmSPSW8Evm7LUcCIAxRBWNPk06c4X3S
60wfnjaaL2Lk549s8UBeQQWTb4QlAiB+3BMxpKo4T4OGSUDFAvhQUnQD5LxNibdy
mYkKsyFNtA==
-----END PRIVATE KEY-----';
    //获取签名的工具在php7的源码编译包里
    private $opensslCnfPath = '/Users/cheng/后端/php7_yuanma/php-7.2.15_yuanma/ext/phar/tests/files/openssl.cnf';

    //获取公钥和私钥
    public function getAllKey(){

        $config = array(
            'config'=>$this->opensslCnfPath, //设置获取密钥的程序路径
            "privateKey_bits" => 512,                     //字节数    512 1024  2048   4096 等
            "privateKey_type" => OPENSSL_KEYTYPE_RSA,     //加密类型 RSA加密算法
        );

        //创建公钥和私钥   返回资源
        $res = openssl_pkey_new($config);
        //从得到的资源中获取私钥  并把私钥赋给$privKey
        openssl_pkey_export($res, $privKey,null,$config);

        //从得到的资源中获取公钥  并把私钥赋给$pubKey
        $pubKey = openssl_pkey_get_details($res);

        $pubKey = $pubKey["key"];
        $data['publicKey'] = $pubKey;
        $data['privateKey'] = $privKey;
        file_put_contents(EASYSWOOLE_ROOT.'/Temp/publicKey.txt',$data['publicKey']);
        file_put_contents(EASYSWOOLE_ROOT.'/Temp/privateKey.txt',$data['privateKey']);
        return $data;
    }

    //个人心得
    //非对称性加密 必须是成对存在的 公钥加密 私钥解密  或者 私钥加密 公钥解密



    /**公加密-私解密**/
    //特点:每次公钥加密的(同一个内容!)的密文是不一样的!!!!!!!!!! 但是私钥都能解的开!!!!!!!!

    //使用公钥加密
    public function lockPublicEncrpt($data){
        $encryptStr = '';
        //参数1:加密数据
        //参数2:得到的加密数据
        //参数3:使用的公钥
        openssl_public_encrypt($data,$encryptStr,$this->publicKey); //公钥加密
        return $encryptStr;
    }

    //使用私钥解密
    public function unlockPrivateDecrpt($data){
        $decryptStr = '';
        openssl_private_decrypt($data,$decryptStr,$this->privateKey); //私钥解密
        return $decryptStr;
    }
    /**公加密-私解密end**/



    /**私加密-公解密**/
    //缺点:相对于 公加密-私解密 私钥加密(同一个内容)的密文是固定的 用公钥解密
    //使用私钥加密
    public function lockPrivateEncrpt($data){
        $encryptStr = '';
        openssl_private_encrypt($data,$encryptStr,$this->privateKey); //公钥加密
        return $encryptStr;
    }

    //使用公钥解密
    public function unlockPublicDecrpt($data){
        $encryptStr = '';
        openssl_public_decrypt($data,$encryptStr,$this->publicKey); //公钥加密
        return $encryptStr;
    }
    /**私加密-公解密end**/










}