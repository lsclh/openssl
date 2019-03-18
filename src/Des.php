<?php
// +----------------------------------------------------------------------
// | Created by PhpStorm.©️
// +----------------------------------------------------------------------
// | User: 程立弘©️
// +----------------------------------------------------------------------
// | Date: 2019-03-02 16:51
// +----------------------------------------------------------------------
// | Author: 程立弘 <1019759208@qq.com>©️
// +----------------------------------------------------------------------

namespace Lsclh\Openssl;




use EasySwoole\Component\Openssl;

/**
 * Des对称加密算法
 * Class Des
 * @package Utility\Openssl
 */
class Des{
    private $key = 'wSPLzittVrsTWEY2cRDCVNTuI0LDspqW';

    /**
     * 加密
     * @param $data
     * @return string
     */
    public function lock($data){
        return (new Openssl($this->key))->encrypt($data);
    }

    /**
     * 解密
     * @param $data
     * @return string
     */
    public function unlock($data){
        return (new Openssl($this->key))->decrypt($data);
    }
}