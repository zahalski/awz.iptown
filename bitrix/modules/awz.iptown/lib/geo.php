<?php

namespace Awz\IpTown;

use Bitrix\Main\Error;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\IO\File;
use Bitrix\Main\Application;

class Geo {

    const MODULE_ID = 'awz.iptown';
    const SERVICE_URL = 'https://sypexgeo.net/files/SxGeoCity_utf8.zip';
    const SERVICE_UNZIP_URL = 'https://api.zahalski.dev/api/sypexgeo/SxGeoCity';
    const SERVICE_UNZIP_URL_DATE = 'https://api.zahalski.dev/api/sypexgeo/lastDate';
    const BASE_NAME = 'SxGeoCity.dat';

    public static function getBaseDir(){
        $dir = Application::getDocumentRoot().
            '/bitrix/modules/'.
            self::MODULE_ID.
            '/base/';
        return $dir;
    }
    public static function getBasePath(){
        $path = self::getBaseDir().
            self::BASE_NAME;
        return $path;
    }

    public static function loadBase()
    {
        $zipModule = class_exists('ZipArchive');
        try{
            $httpClient = new HttpClient();
            $httpClient->disableSslVerification();

            $file = new File(self::getBasePath());
            $zipFile = new File(self::getBaseDir().'base.zip');
            $timeCacheFile = new File(self::getBaseDir().'lastDate.dat');
            if(!$timeCacheFile->isExists() || !$file->isExists()){
                $lastModify = 0;
            }else{
                $lastModify = $timeCacheFile->getContents() ?? 0;
            }
            $httpClient->setHeader(
                'If-Modified-Since',
                gmdate('D, d M Y H:i:s', $lastModify). ' GMT',
                true
            );
            if($zipModule){
                $res = $httpClient->get(self::SERVICE_URL);
                if($httpClient->getStatus() == 200){
                    $headers = $httpClient->getHeaders()->toArray();
                    if($res && isset($headers['last-modified']['values'][0]) &&
                        strtotime($headers['last-modified']['values'][0])>$lastModify
                    ){
                        $zipFile->putContents($res);
                        $timeCacheFile->putContents(strtotime($headers['last-modified']['values'][0]));
                        $zip = new \ZipArchive();
                        $file->delete();
                        $zip->open($zipFile->getPath());
                        $zip->extractTo(self::getBaseDir());
                        $zipFile->delete();
                    }
                }
            }else{
                $res = $httpClient->get(self::SERVICE_UNZIP_URL_DATE);
                if($httpClient->getStatus() == 200){
                    $headers = $httpClient->getHeaders()->toArray();
                    if($res && isset($headers['last-modified']['values'][0]) &&
                        strtotime($headers['last-modified']['values'][0])>$lastModify
                    ){
                        $res2 = $httpClient->get(self::SERVICE_UNZIP_URL);
                        if($res2 && ($httpClient->getStatus() == 200)){
                            $timeCacheFile->putContents(strtotime($headers['last-modified']['values'][0]));
                            $file->putContents($res2);
                        }
                    }
                }
            }

        }catch(\Exception $e){

        }

        return "\\Awz\\IpTown\\Geo::loadBase();";

    }

    public static function getData($ip=""){

        $result = new CityResult();

        try{
            $file = new File(self::getBasePath());
            if(!$file->isExists()){
                self::loadBase();
            }

            if(!$file->isExists()){
                throw new \Bitrix\Main\SystemException('ip base not loaded');
            }

            if(!$ip){
                $server = Application::getInstance()->getContext()->getServer();
                $ip = $server->getRemoteAddr();
            }

            $baseOb = new SxGeo($file->getPath());

            $city = $baseOb->getCityFull($ip);

            $result->setResult($city);

        }catch (\Exception $e){
            $result->addError(new Error($e->getMessage()));
        }

        return $result;
    }

}