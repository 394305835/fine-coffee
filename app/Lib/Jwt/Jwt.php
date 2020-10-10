<?php

namespace App\Lib\Jwt;

use App\Contracts\Repository\BaseRepository;
use App\Contracts\Token\TokenInterface;
use App\Lib\Constans;

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
abstract class Jwt extends \Firebase\JWT\JWT implements TokenInterface
{
    use BaseRepository;

    protected $privateKey = <<<EOF
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

    protected $publicKey = <<<EOF
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

    public function __construct()
    {
        $iat = time();
        $this->payload = (object) [
            "iss" => "codebook.org", //签发者 可以为空
            "aud" => "codebook.com", //面象的用户，可以为空
            "iat" => $iat, //签发时间
            "nbf" => $iat, //在什么时候jwt开始生效
            "exp" => $iat + Constans::TOKEN_EXP_TIME, //token 过期时间
            "uid" => 0,
            "idn" => 0,
        ];
    }

    /**
     *
     * @param int $uid
     * @return string
     */
    protected function make(int $uid, string $idn): string
    {
        $this->payload->uid = $uid;
        $this->payload->idn = $idn;
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

    public function getPayload(string $token = ''): \stdClass
    {
        return $this->payload;
    }
    abstract public function create(array $payload): string;
    abstract public function check(string $token): bool;
    abstract public function refresh(string $token): bool;
    abstract public function invalid(string $token): bool;
}
