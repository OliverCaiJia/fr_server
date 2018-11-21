<?php
namespace App\Services\Core\Product;

use App\Helpers\Http\HttpClient;
use App\Services\AppService;

/**
 * Class PushService
 * @package App\Services\Core\Store\Push
 * 推送
 */
class SuDaiZhiJiaProductService extends AppService
{
    /**
     * 获取速贷之家合作贷产品数据
     * @param array $params
     * @return Json
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function productCooperate($data = [])
    {
        //获取config
        $url = SuDaiZhiJiaProductConfig::SUDAIZHIJIA_PRODUCT_URL."?pageSize={$data['pageSize']}&pageNum={$data['pageNum']}&productType=1&terminalType={$data['terminalType']}";
        $response = HttpClient::i()->request('GET', $url);
        $result = $response->getBody()->getContents();
        return $result;
    }

    /**
     * 速贷之家立即申请产品url
     * @param array $data
     * @return Json
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function cooperateApplication($data = [])
    {
        //获取config
        $url = SuDaiZhiJiaProductConfig::SUDAIZHIJIA_APPLY_URL."?productId={$data['productId']}";
        $response = HttpClient::i()->request('GET', $url);
        $result = $response->getBody()->getContents();
        return $result;
    }
}