<?php

namespace OSS;

/**
 * Class Config
 *
 * 执行Sample示例所需要的配置，用户在这里配置好Endpoint，AccessId， AccessKey和Sample示例操作的
 * bucket后，便可以直接运行RunAll.php, 运行所有的samples
 */
final class Config
{
    const OSS_ACCESS_ID = 'LTAIsYqdB9L4l85J';
    const OSS_ACCESS_KEY = 'y6tkU59sczghd9N8Qh4OaAD79HmYD7';
    const OSS_ENDPOINT = 'oss-cn-zhangjiakou.aliyuncs.com';
//    const OSS_ENDPOINT = 'oss-cn-shenzhen.aliyuncs.com';
    const OSS_TEST_BUCKET = 'fruitloan';
}
