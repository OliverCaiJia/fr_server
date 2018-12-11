<?php

/**
 * Created by PhpStorm.
 * User: sudai
 * Date: 17-9-4
 * Time: 下午1:50
 */

namespace App\Services\Core\Validator\Scorpion\Mozhang;


class MozhangConfig
{

    const SCORPIO_URL = 'https://api.51datakey.com'; //魔蝎ApiUrl

    const SCORPIO_METHOD = [
        'anti-fraud'=>'moxie.api.risk.magicwand2.anti-fraud', //魔杖2.0系列-反欺诈
        'application'=>'moxie.api.risk.magicwand2.application', //魔杖2.0系列-申请准入
        'evaluation'=>'moxie.api.risk.magicwand2.credit.evaluation', //魔杖2.0系列-额度评估(账户)
        'credit.qualification'=>'moxie.api.risk.magicwand2.credit.qualification', //魔杖2.0系列-额度评估(电商)
        'post-load'=>'moxie.api.risk.magicwand2.post-load', //魔杖2.0系列-贷后行为
        'black-gray'=>'moxie.api.risk.magicwand2.black-gray', //魔杖2.0系列-黑灰名单
        'multi-info'=>'moxie.api.risk.magicwand2.multi-info', //魔杖2.0系列-多头报告
    ];


    /**
     * 魔蝎app_id
     *
     * @param string $app_id
     * @return string
     */
    public static function getScorpioAppId()
    {
        return PRODUCTION_ENV ? "d23fea57397d43a79271dbb706e93478" : "d47c3d555b9040ad857d05839a671537";
    }

    /**
     * 魔蝎secret
     *
     * @param string $secret
     * @return string
     */
    public static function getScorpioSecret()
    {
        return PRODUCTION_ENV ? "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAL8sAEEuFBsXGtbfwzkujo0zmezingMPK+fHpUycETSyQdNivKmVU2A6/V93f1FYk4OLmyeGxuVMtclNiyADJcAsWWgDvNn8Gxfac5rsobr0a086TuaC+c+RiMDEYCRMVHrY6JSUc7aQYpDYwkB9GBXFRDdui651YlSD5G830+drAgMBAAECgYBmrPxKBbSYxDUPGUliKeY4YnGWsDRL0lczeqAGYIBBPEhsf0hzEJeiRKyXHLhN+XPpIA8qEJI8z5GHV9WUUPxxp/gdIWmx5eduBNXavxGhMqFvwk33MQL9CYO2A6EdP36cIb5gpkQOVOPzuHcvGL/3mj8IvxFmz3irKXpIXZxyWQJBAOAlpSr7b/ahSlr2apqyosEJsiP1VcmE1pdQ6MpR5N5aZcjGAahh/zBGn+ZnGfvKjbaxKJETEFKA+DCz+80vqucCQQDaVrxmKDyTY+H2TPNO1xlkPlgmJ+yH5dkgJfhgDsAgg47YggkcI17i0tJrTj5/vRw6E5XdVPd4erD5PABcCfLdAkEAnAOX40L/u3qodofty59rCVHmXID3JT0A4HHAlpJJ6zqgfg7UOI99P+zof0ZkH43s9ax5wAC067g5CC0+pqL3IQJAa+X/NrDdtqzepvxCJQ0RhEN3BmwmbMY+ta9t/fJsKeU5u28Pl3M3Wfp7eAHzyuamw2CYaAesQELJoHFxcAqOlQJAXWh1tWvd5WPruXncIrJcz2v1RPw6CxbWH42Wk1s7h+e7KZ9SqyJlcMlreLCzgxiG+TQ1qku/aEv7lE7DYzHqbQ==" : "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDKJKi7UkWWcLzuXmc6Pa4tUAYEDlU5zuU8+LxOEs2ogPUjEF2QnHM/hDNpecHpWiWxR01lMhDqoOcQevZdzH2/2edtl5byPmGywMIknjxEbiK/hAcD0XaGuxH2yHsbLL2pnqY7ySKpBCT6rBW8LrZg8DsOTeF7cjc+0CVSCOGGH7itQxf7c8JtsjnM0gLMTdw+V8cFjVAT5ZESqnTU6mrRiLRAsKrSNz1z0p1i8LAmiFbAC46WNsPGLeLFbJHjGn56odIpzPRso2UEL+sZ2aO8Paf4NJ6uci11xKfzAEiQo8L2gT5y9CYZPihOqlj7tFmFtWRyYsNNVZuGhEBrPAD9AgMBAAECggEBALy4RvNDlwYh0LF2X0dniHJzcHpe60BiIXCwBBWbxndXlgUbZU76UTpucRU7AEecyu3cVKxydoqml7KyKcpefNQdWsvdJ6aXiNy6y0YmmLuGW1iTqXzuFIsqoVXVy+EN/zAZlrbgTEShQujoug4LSmfsQCZVnXqDooI5D26sLejpkDAFpFqOq5p6oPEAWJOH5E5AZwOTbsIU4pSQyiJ+WqGiiyR8eF7yqO/oUT59hHOnxxorpKcWJr94Ao8r2AoO1HviZPAwSsOPRWF1uL9XVuB6D5unpbXTp5Z3gPvQIy4s+hU98JjIlKUsNpOFxT111J4c9Mi+hquvw6Cx0o51HZ0CgYEA+JwoLTSQZG0khQPB258+ZJd5jQsfGRonU9qtcuWheG4V6/5mOej/E2D4RcV7zSqF5f4YUzaQyt3W5vqbkIUWTrFV4vCIOizjrwJq+5lpksmaaYETEgWlPFZTx8GPxdwu7s/eqM348yRvPYwQfQa2WMcFEil3WDYmUFgRvNUupHsCgYEA0CbnmBy1/rB1KB6qzQGnP34/HF4xVe9sL//ctlcykOAehnCXyJK24vjV5NxErbERgQVrMFmOpJAyH0OC8nj2SgrU5TNUkpoMasVRZZZevk9MKVD2lyjIzVlNMDHWIvTKFNsmn/nahRxcStbVYuyussz/+0zRXNSbSmSWOUKD4ucCgYBR9flw3dF0ql7N021H4HoLY7zY+P+poOuyQ3fHV1kigPiNMvO0x9HAK8nuBqtH+mrmZhzS4jxeBUDiKWC8BoRSMTildrMSqtXtTpjCldMuZ3SWr8z/tgjBmZxJUND7ZBm89Z7se+tFDY/29IRDE8FuBz7uu+jylfePqVk/rfCQnQKBgAvP2V6Zan58dvmC3ABsMph4yo4KjlQpFQOYSmcSha0Q+sp4QzS/lp9EraaiFUeh/7NJom6I9n5CLIX3p8uor5k+ChzDj+4NzdyVO+w+3zt/dnv1uziSuOpmQeoVOeib6YfLc+KqJAtfs6EPleZaNgOxfGk/T7Yr3nAXSysOqjtLAoGANOMg2AQWuN2l5oqAEHJYhPQ6xrqCCA0OOMqDlfv7P+XoVVrhso7ZXqAdSDrcLFZVqUzKnkSN546s0HwhcqXWVKkxEFERnwqkug3glbn+6GppM+ysYhgx74Nzs1DFoZDNWM/y/YP+l8HGc4xp/Mm5HjS3ECbXWnBQCQUYO8W5fIw=";
    }

    /**
     * 魔蝎format
     *
     * @param string $format
     * @return string
     */
    public static function getScorpioFormat()
    {
        return "JSON";
    }

    /**
     * 魔蝎sign_type
     *
     * @return string
     */
    public static function getScorpioSignType()
    {
        return "RSA";
    }

    /**
     * 魔蝎version
     *
     * @return string
     */
    public static function getScorpioVersion()
    {
        return "1.0";
    }

}
