<?php
namespace Awz\IpTown;

use Bitrix\Main\Application;
use Bitrix\Main\Result;
use Bitrix\Main\Text\Encoding;

class CityResult extends Result {

    public function setResult($data){
        if(!is_array($data))
            throw new \Bitrix\Main\ArgumentException('$data is not array');
        if(!is_array($data['city']))
            throw new \Bitrix\Main\ArgumentException('city is not array');
        $this->setData($data);
    }

    public function getCityId(){
        $data = $this->getData();
        return $data['city']['id'] ?? '';
    }

    public function getCityLat(){
        $data = $this->getData();
        return $data['city']['lat'] ?? '';
    }

    public function getCityLon(){
        $data = $this->getData();
        return $data['city']['lon'] ?? '';
    }

    public function getCityRu(){
        $data = $this->getData();
        $city = $data['city']['name_ru'] ?? '';
        if($city && !Application::getInstance()->isUtfMode()){
            return Encoding::convertEncodingToCurrent($city);
        }
        return $city;
    }

    public function getCityEn(){
        $data = $this->getData();
        return $data['city']['name_en'] ?? '';
    }

    public function getRegionId(){
        $data = $this->getData();
        return $data['region']['id'] ?? '';
    }

    public function getRegionIso(){
        $data = $this->getData();
        return $data['region']['iso'] ?? '';
    }

    public function getRegionRu(){
        $data = $this->getData();
        $city = $data['region']['name_ru'] ?? '';
        if($city && !Application::getInstance()->isUtfMode()){
            return Encoding::convertEncodingToCurrent($city);
        }
        return $city;
    }

    public function getRegionEn(){
        $data = $this->getData();
        return $data['region']['name_en'] ?? '';
    }

    public function getCountryId(){
        $data = $this->getData();
        return $data['country']['id'] ?? '';
    }

    public function getCountryIso(){
        $data = $this->getData();
        return $data['country']['iso'] ?? '';
    }

    public function getCountryRu(){
        $data = $this->getData();
        $city = $data['country']['name_ru'] ?? '';
        if($city && !Application::getInstance()->isUtfMode()){
            return Encoding::convertEncodingToCurrent($city);
        }
        return $city;
    }

    public function getCountryEn(){
        $data = $this->getData();
        return $data['country']['name_en'] ?? '';
    }

}