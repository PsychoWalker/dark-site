<?php

class CalcApi {

    private $url;

    private $params;

    public function __construct($url, $params)
    {
        $this->url = $url;

        $this->params = $params;
    }

    public function doRequest()
    {
        $curlHandler = curl_init();
        curl_setopt($curlHandler, CURLOPT_URL, $this->url);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curlHandler, CURLOPT_FAILONERROR, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandler, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandler, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandler, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, http_build_query($this->params) );

        curl_setopt($curlHandler, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $responseBody = curl_exec($curlHandler);

        $statusCode = curl_getinfo($curlHandler, CURLINFO_HTTP_CODE);

        curl_close($curlHandler);

        if ($statusCode != 200) {
            $responseBody = '[]';
        }

        return $responseBody;

    }


}

/**
 * Параметры и типы
 * // Сумма
 * double Summ
 * // дата начала гарантии
 * DateTime? StartDate default Now;
 * // Дата окончания гарантии
 * DateTime? EndDate default Now.AddDays(60);
 * // Фз : 44,223,185,Commercial
 * string Fz
 * // Тип бг : execution, participation, avansReturn, warrantyObligations
 * string TypeBg
 * // Чистый убыток за последний год
 * bool NetLossLastYear
 * // Нет опыта
 * bool NoExperience
 * // Блокировка по счетам
 * bool BlockBankAccount
 * // Арбитраж
 * bool Arbitration
 * // Закрытый аукцион
 * bool ClosedTender
 * // Форма заказчика
 * bool СustomerForm
 * // Доставка курьером
 * bool CourierDelivery
 * // Директор не резидент
 * bool NonResident
 * // Рассрочка по оплате
 * bool InstallmentPay
 * // Ip адресс пользователя
 * string IpAdress
 */

/*
Результат:
bankWorkName = Трансстройбанк // Название банка
bankInn = 7730059592  // Инн банка
bankDiscountPrice = 953 // Цена банка без скидки( реальная, которую мы получаем от банка)
bankPrice = 999 // Цена банка со скидкой (фейковые данные).
ourPrice = 886 // Наша цена, которую мы можем предложить(самая низкая)/ ( тоже фейковые данные).
persent = 2.91 // % годовых OurPrice
rejectReasons // Причины отказа
maxPersentDiscount = 10  // % максимальной скидки который мы можем предложить Если банк не делает скидку будет 0
*/


// Пример запроса для отправки с формы ОНЛАЙН-КАЛЬКУЛЯТОР
/*$params = [
    'Summ' => 300000.0,
    'StartDate' => '2022-01-29',
    'EndDate' => '2022-03-29',
    'Fz' => '44',
    'TypeBg' => 'execution',
    'ClosedTender' => 'true',
    'IpAdress' => '122.45.55.20'
];

$c = new CalcApi('https://calcbg.profbg.ru/BankRatesApi/SelectBanksManual', $params);

echo $c->doRequest();*/


// Пример запроса для отправки с формы ФОРМА ИНДИВИДУАЛЬНОГО АВТОПОДБОРА БАНКА

/**
 * Параметры и типы
 * // Инн компании, которая хочет получить гарантию
 * string Inn
 * // Реестровый номер аукциона
 * string Reestr
 * // Ip адресс пользователя
 * string IpAdress
 */

/*$params = [
    'Reestr' => '203750000012000009',
    'Inn' => '7811749315',
    'IpAdress' => '122.45.55.20'
];

$c = new CalcApi('https://calcbg.profbg.ru/BankRatesApi/SelectBanksByInnAndReestr', $params);

echo $c->doRequest(); */

