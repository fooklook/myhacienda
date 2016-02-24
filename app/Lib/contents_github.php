<?php
namespace App\Lib;
use Guzzle\Tests\Common\Cache\NullCacheAdapterTest;

/**
 * 获取api.github中的内容，并且解析
 * Class contents_github
 * @package App\Lib
 */

class contents_github
{
    //获取的结果
    private $result;

    /**
     * 获取github上的内容
     * @param string $filename 地址
     */
    public function __construct($filename){
        $client = new \Github\Client();
        $token = env('GITHUB_TOKEN');
        $username = env('GITHUB_USERNAME');
        $repository = env('GITHUB_REPOSITORY');
        $client->authenticate($token, null, \Github\Client::AUTH_HTTP_TOKEN);
        $this->result = $client->api('repo')->contents()->show($username, $repository, $filename);
        $this->result['content'] = base64_decode($this->result['content']);
    }

    /**
     * 获取相关信息
     * @param string $property_name 属性名称
     * @return null
     */
    public function __get($property_name){
        if(isset($this->result[$property_name])){
            return $this->result[$property_name];
        }
        return null;
    }
}