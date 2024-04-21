# AWZ: Город по IP (awz.iptown)

### [Установка модуля](https://github.com/zahalski/awz.iptown/tree/main/docs/install.md)

<!-- desc-start -->

## Описание
Модуль для определения города по IP по базе [Sypex Geo](https://sypex.net/)

1) Базы IP адресов автоматически обновляются 1 раз в неделю (на агенте).
2) Не требует обращения к внешним API (база IP хранится локально)

**Поддерживаемые редакции CMS Битрикс:**<br>
«Старт», «Стандарт», «Малый бизнес», «Бизнес», «Корпоративный портал», «Энтерпрайз», «Интернет-магазин + CRM»

<!-- desc-end -->

## Документация
<!-- dev-start -->
### Awz\IpTown\Geo::getData

<em>получает информацию по IP адресу</em>

| Параметр |  | Описание |
| --- | --- | --- |
| $ip `string` | По умолчанию, пустая строка (текущий IP адрес посетителя) | IP адрес |

Возвращает объект `Awz\IpTown\CityResult`<br> 
наследник `\Bitrix\Main\Result`

| метод | тип | описание |
| --- | --- | --- |
| **getCityId** | `string` | ид города в базе |
| **getCityLat** | `string` | широта |
| **getCityLon** | `string` | долгота |
| **getCityRu** | `string` | город на русском |
| **getCityEn** | `string` | город на англ. |
| **getRegionId** | `string` | ид региона в базе |
| **getRegionIso** | `string` | код региона |
| **getRegionEn** | `string` | регион на англ. |
| **getRegionRu** | `string` | регион на русском |
| **getCountryId** | `string` | ид страны в базе |
| **getCountryIso** | `string` | код страны |
| **getCountryRu** | `string` | страна на русском |
| **getCountryEn** | `string` | страна на англ. |
| **getData** | `array[]` | полная информация по IP адресу |
| **isSuccess** | `bool` | нет ошибок |
| **getErrors** | `Bitrix\Main\Error[]` | ошибки |
| **getErrorMessages** | `string[]` | ошибки |

#### пример 1

```php
if(\Bitrix\Main\Loader::includeModule('awz.iptown')){
	$townRes = \Awz\IpTown\Geo::getData();
	if($townRes->isSuccess()){
		$townName = $townRes->getCityRu();
		if($townName){
			echo "Ваш город: " . $townName;
		}
	}
}
```

#### пример 2

```php
$ip = '109.197.204.169';
if(\Bitrix\Main\Loader::includeModule('awz.iptown')){
	$townRes = Awz\IpTown\Geo::getData($ip);
	if($townRes->isSuccess()){
		echo $townRes->getCityRu()."\n";
		echo $townRes->getCityLat()."\n";
		echo $townRes->getCityLon()."\n";
		echo $townRes->getRegionRu()."\n";
		echo $townRes->getRegionIso()."\n";
		echo $townRes->getCountryRu()."\n";
		echo $townRes->getCountryIso()."\n";
	}
}
```
<!-- dev-end -->


<!-- cl-start -->
## История версий

https://github.com/zahalski/awz.iptown/blob/master/CHANGELOG.md

<!-- cl-end -->
