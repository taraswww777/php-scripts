<?php
/**
 * Author: Kovalev Taras
 * Author Email: taraswww777@mail.ru
 * Date: 26.07.2018 23:44
 */

namespace FrontendGulp\Api\Tools;

abstract class Mapper {

    public static function getCurrencyByCode($currencyCode = DEFAULT_CURRENCY) {
        $currencyList = [
            'RUB' => 'P'
//            'RUB' => '<i class="fa fa-rub"></i>'
        ];
        return $currencyList[$currencyCode ? $currencyCode : DEFAULT_CURRENCY];
    }

    /**
     * @param array $section
     * @param string $currencyCode
     * @return array
     */
    public static function convertItemToProduct($section, $currencyCode = 'RUB') {
        return [
            'urlDetail' => $section['DETAIL_PAGE_URL'],
            'imgSrc' => $section['PREVIEW_PICTURE']['SRC'],
            'name' => $section['NAME'],
            'price' => $section['PROPERTIES']['PRICE']['VALUE'],
            'salePrice' => $section['PROPERTIES']['SALE_PRICE']['VALUE'],
            'currencyCode' => $currencyCode,
        ];
    }

    /**
     * @param array $section
     * @param string $currencyCode
     * @return array
     */
    public static function convertSectionToProduct($section, $currencyCode = 'RUB') {
        return [
            'urlDetail' => $section['SECTION_PAGE_URL'],
            'imgSrc' => $section['PICTURE']['SRC'],
            'name' => $section['NAME'],
            'price' => $section['UF_MIN_PRICE'],
            'currencyCode' => $currencyCode,
        ];
    }
}