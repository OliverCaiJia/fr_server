<?php

namespace App\Helpers;

/**
 * @author zhaoqiying
 */
class AdminResponseFactory
{

    /**
     * 
     * @param type $tabid
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function ok($tabid = '', $forward = '', $forwardConfirm = '')
    {
        return response()->json(
                [
                "statusCode" => "200",
                "message" => "操作成功!",
                "closeCurrent" => true,
                "tabid" => $tabid,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 200, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $tabid
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function handleOk($tabid = '', $forward = '', $forwardConfirm = '')
    {
        return response()->json(
                [
                "statusCode" => "200",
                "message" => "操作成功",
                "closeCurrent" => false,
                "tabid" => $tabid,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 200, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $message
     * @param type $tabid
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function error($message = '操作失败', $tabid = '', $forward = '', $forwardConfirm = '')
    {
        return response()->json(
                [
                "statusCode" => "500",
                "message" => $message,
                "closeCurrent" => false,
                "tabid" => $tabid,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 500, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $message
     * @return type
     */
    public static function ajaxError($message = '操作失败')
    {
        return response()->json(
                [
                "statusCode" => "300",
                "message" => $message,
                ], 300, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $dialogid
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function dialogOk($dialogid = '', $forward = '', $forwardConfirm = '')
    {
        return response()->json(
                [
                "statusCode" => "200",
                "message" => "操作成功!",
                "closeCurrent" => false,
                "dialogid" => $dialogid,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 200, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $dialogid
     * @param type $message
     * @param type $close
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function dialogOkClose($dialogid = '', $message = '操作成功!', $forward = '', $forwardConfirm = '', $close = true)
    {
        return response()->json(
                [
                "statusCode" => "200",
                "message" => $message,
                "closeCurrent" => $close,
                "dialogid" => $dialogid,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 200, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $forward
     * @param type $forwardConfirm
     * @return type
     */
    public static function timeout($forward = '', $forwardConfirm = '')
    {
        return response()->json(
                [
                "statusCode" => "301",
                "message" => "会话超时",
                "closeCurrent" => false,
                "forward" => $forward,
                "forwardConfirm" => $forwardConfirm
                ], 301, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

    /**
     * 
     * @param type $filename
     * @return type
     */
    public static function upload($filename = '', $hostname = '')
    {
        return response()->json(
                [
                "statusCode" => "200",
                "message" => "上传成功！",
                "filename" => $filename,
                "hostname" => $hostname,
                ], 200, ['Content-Type' => "application/json; charset=utf-8"], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }

}
