<?php

namespace App\Lib;

use App\Contracts\Token\TokenInterface;
use App\Lib\Constans;
use App\Repositories\Token\AdminToken;
use App\Repositories\Token\Token;

/**
 * JWT 认证
 *
 * ```sh
 * # 生成私钥
 * openssl genrsa -out pri_key.pem 1024
 * # 生成公钥
 * openssl rsa -in pri_key.pem -pubout -out pub_key.pem
 * ```
 */
class Jwt extends \Firebase\JWT\JWT implements TokenInterface
{

    private $privateKey = <<<EOF
-----BEGIN RSA PRIVATE KEY-----
MIICXwIBAAKBgQCsGrqBPGNyqB0ZteHWZCDK299M30F+99N13r+ZzjsTEjsotdmL
TnbG8bj60P6fzQE17+zq5sPHE8Dx3Rt+YL01qw/NMuvVrxF9Pa6mUQ2F89lNgn/p
ip6sGfTAZnfYB7uyGbV4AXge0Ks/PEf9sP2E0vcBOGVnm3jI2UaoBJrcRQIDAQAB
AoGBAKGM3XEejIM+B0LxFjK2/oktZyizkLlsTFSiaNwpWA6I2HtYaAJ5/si0cl0N
/VVnjDFjK9M8Fp4yjrT6RiqVCEVkWrBvolmqV2rCNPR7a2vFQcL2gC5Fu9ZkIaV2
88c3WCqb+FJ5bfWUO1/kTyQrChvVY7cCTIAg0E8jxUt3nMGBAkEA1JUSjDmzfo2z
TAsKbQi6IC6y9G6NsfyvAQPukzRUKNapOWgxwqGgJWuEaJ6O94ybyHHqL4g+Q0Ov
A8/IactckQJBAM9BQdHjQeeaVKT2byvAyTGqa3JudDt3FZMm7XiS3RpL/MydWIxa
tMH/2h8pZKDL0xiWVUWwURBMAV92XFFPrnUCQQCfYDwNoVzu7nGT+1sPr9FLO3ez
Rgc5f8X8ruP4vOyzyWwJvBJCZ0ZXh6o3fViWQ3av6qe2hyCW8XGPHAKXPn3hAkEA
yQzd49SYPyr4R5qD16bJxbMzTiuV94Wa2Ufe/6NAd10VXAybNHRdewBOQQJvioiP
O//BsrvKt4tznX59KaepbQJBANSJ7M39RMCbTMFxxURVyxRFW5pm8j0dWpfswAqo
4uvw/lc1kjLahRQOqGCQ4I7ErTh6SJ9AtbCw555AU+TBXrQ=
-----END RSA PRIVATE KEY-----
EOF;

    private $publicKey = <<<EOF
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCsGrqBPGNyqB0ZteHWZCDK299M
30F+99N13r+ZzjsTEjsotdmLTnbG8bj60P6fzQE17+zq5sPHE8Dx3Rt+YL01qw/N
MuvVrxF9Pa6mUQ2F89lNgn/pip6sGfTAZnfYB7uyGbV4AXge0Ks/PEf9sP2E0vcB
OGVnm3jI2UaoBJrcRQIDAQAB
-----END PUBLIC KEY-----
EOF;

    /**
     * Undocumented variable
     *
     * @var object
     */
    protected $payload;

    /**
     * Undocumented variable.
     * 'ES256', 'HS256', 'HS384', 'HS512', 'RS256', 'RS384', and 'RS512'
     *
     * @var string
     */
    private $alg = 'RS256';

    /**
     * redis 实例
     *
     * @var Token
     */
    protected $Token;

    public function __construct()
    {
        // $this->Token = TokenRedis::singleton();
        //默认就是后台存储Token的仓库
        $this->use(AdminToken::singleton());
    }

    /**
     * 该方法区分使用哪个存储token的仓库
     *
     * @param Token $token
     */
    public function use($token)
    {
        $this->Token = $token;
        return $this;
    }

    public function getPayload(string $token = ''): \stdClass
    {
        return $this->parse($token);
    }

    /**
     *
     * @param int $uid
     * @return string
     */
    protected function make(int $uid): string
    {
        $iat = time();
        $this->payload = (object) [
            "iss" => "codebook.org", //签发者 可以为空
            "aud" => "codebook.com", //面象的用户，可以为空
            "iat" => $iat, //签发时间
            "nbf" => $iat, //在什么时候jwt开始生效
            "exp" => $iat + Constans::TOKEN_EXP_TIME, //token 过期时间
            "uid" => $uid,
        ];
        return static::encode($this->payload, $this->privateKey, $this->alg);
    }

    /**
     * 解析 TOKEN
     *
     * @param string $token
     * @return ->iss //签发者 可以为空
     * @return ->aud //面象的用户，可以为空
     * @return ->iat //签发时间
     * @return ->nbf //在什么时候jwt开始生效
     * @return ->exp //token 过期时间
     * @return ->id //记录的id的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
     */
    protected function parse(string $token = ''): object
    {
        if (!$token) {
            return $this->payload ? $this->payload : (object) [];
        }
        return static::decode($token, $this->publicKey, [$this->alg]);
    }

    /**
     * 创建一个 token 并存入 redis
     *
     * @param array $payload
     * @return string
     */
    public function create(array $payload): string
    {
        if (empty($uid = (int) $payload['uid']) || !is_numeric($uid)) {
            return '';
        }
        $token = $this->make($uid);
        // 有效时间 = 过期时间 - 当前时间
        return $this->Token->create($uid, $token, $this->payload->exp - time()) ? $token : '';
    }

    /**
     * 检查一个 token 与 在 redis 中用户的 token 是否一致
     *
     * @param string $token
     * @return boolean
     */
    public function check(string $token): bool
    {
        try {
            $this->payload = $this->parse($token);
            // 与 redis 中比较
            $rediToken = $this->Token->getToken((int) $this->payload->uid);
            return empty($rediToken) ? false : $token === $rediToken;
        } catch (\Throwable $th) {
            return false;
        }
        return false;
    }

    /**
     * 刷新TOKEN.
     *
     * PS:该方法最好是在验证ok后调用
     *
     * @param string $token
     * @return boolean
     */
    public function refresh(string $token): bool
    {
        $payload = $this->parse($token);
        // 如果一个天后将过期则刷新，否则不刷新
        if ($payload->exp - time() < Constans::TIME_DAY) {
            return $this->Token->create($payload->uid, $token, time() + Constans::TIME_DAY);
        }
        return true;
    }

    /**
     * 作废 token
     *
     * PS:就是从redis删除该用户TOKEN
     *
     * @return boolean
     */
    public function invalid(string $token): bool
    {
        if (!$this->payload->uid) {
            return false;
        }
        return $this->Token->remove($this->payload->uid);
    }
}
