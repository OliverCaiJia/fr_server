<?php

return [
    /**
     *  大汉三通
     */
    'dahansantong' => [
        'account' => 'dh74141',
        'password' => '5DtyFJ6E',
        'smsSendUrl' => 'http://www.dh3t.com/json/sms/Submit',
        'subcode' => 7414,
    ],
    /**
     *  广州短信(创蓝)
     */
    'chuanglan' => [
        //速贷之家
        'smsAccount' => 'Vip_sudai',
        'smsPassword' => 'Sudaizhijia2016',
        //'smsSendUrl' => 'http://sapi.253.com/msg/main.do',
        'smsSendUrl' => 'http://222.73.117.158/msg/HttpBatchSendSM',
        //借钱王
        'jqw_smsAccount' => 'vip_jqw1',
        'jqw_smsPassword' => 'Jqw123456',
        //'jqw_smsSendUrl' => 'http://sapi.253.com/msg/main.do',
        'jqw_smsSendUrl' => 'http://222.73.117.158/msg/HttpBatchSendSM',
    ],
    /**
     *  http://c.chanzor.com (畅卓)
     */
    'changzhuo' => [
        'account' => '98a3e0',
        'password' => '656A67BF43D1A5864EF0D76418E43622',
        'smsSendUrl' => 'http://api.chanzor.com/send',
    ],
    /**
     * 微网通联
     */
    'wwtl' => [
        'sname' => 'dlzjwlkj',
        'spwd' => 'Sudaizhijia2016',
        'scorpid' => '',
        'sprdid' => '1012818',
        'smsSendUrl' => 'https://seccf.51welink.com/submitdata/service.asmx/g_Submit',
    ],
	
	  /**
	   * 亿美短信通道
	   */
    'yimei' => [
		'cdkey' => '8SDK-EMY-6699-SBYNS',
		'password' => '777128',
	    'addserial' => '',
		'smsSendUrl' => 'http://hprpt2.eucp.b2m.cn:8080/sdkproxy/sendsms.action',
	]
];
