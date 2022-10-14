<?php

date_default_timezone_set('Europe/Moscow');

require_once __DIR__ . '/../shared/block.php';
require_once __DIR__ . '/CalcApi.class.php';

//if ($_SERVER['REQUEST_METHOD'] != 'POST') {
//  header('HTTP/1.0 403 Forbidden');
//  die();
//}

//if (checkIP(getIp())>3) {
//  header('HTTP/1.0 403 Forbidden');
//  die();
//}

$params = [
  'IpAdress' => getIp()
];

switch (filter_input(INPUT_POST, 'radiogroup-1', FILTER_VALIDATE_INT)) {
  case 1:
    $fz = 44;
    break;
  case 2:
    $fz = 223;
    break;
  case 3:
    $fz = 185;
    break;
  case 4:
    $fz = 'Commercial';
    break;
  default:
    $fz = 44;
}
$params['Fz'] = $fz;

switch (filter_input(INPUT_POST, 'radiogroup-2', FILTER_VALIDATE_INT)) {

  case 1:
    $typeBg = 'participation';
    break;
  case 2:
    $typeBg = 'execution';
    break;
  case 3:
    $typeBg = 'warrantyObligations';
    break;
  case 4:
    $typeBg = 'avansReturn';
    break;
  default:
    $typeBg = 'participation';
}
$params['TypeBg'] = $typeBg;

$summ = str_replace(' ', '', filter_input(INPUT_POST, 'summ', FILTER_DEFAULT));

$params['Summ'] = $summ;

$params['StartDate'] = $_POST['date-1'];
$params['EndDate'] = $_POST['date-2'];

switch (filter_input(INPUT_POST, 'option', FILTER_VALIDATE_INT)) {
    case 1:
        $params['NoExperience'] = 'true';
        break;
    case 2:
        $params['CourierDelivery'] = 'true';
        break;
    case 3:
        $params['СustomerForm'] = 'true';
        break;
}

/*
bool NetLossLastYear  – Убыточная деятельность
bool NoExperience  – Отстутствие опыта
bool BlockBankAccount  – Блокировка расчетного счета
bool Arbitration  – Наличие судебных дел
bool ClosedTender  – Закрытый аукцион
bool СustomerForm  – Форма гарантии от заказчика
bool CourierDelivery  – Доставка курьером
bool InstallmentPay  – Рассрочка по оплате
*/


$c = new CalcApi('https://calcbg.profbg.ru/BankRatesApi/SelectBanksManual', $params);

$dataRes = json_decode($c->doRequest(),true);

$result = $dataRes['banks'];


$table = <<<TABLE
                <table class="bank">
                    <tbody>
                    <tr>
                        <td>№</td>
                        <td>Банк</td>
                        <td>Цена банка</td>
                        <td>Тариф банка</td>
                        <td>Наша цена</td>
                        <td>Наш тариф</td>
                        <td></td>
                    </tr>
TABLE;

$i = 1;
foreach ($result as $row) {
    // Не выводить банки с 0
    if ($row['bankPrice'] == 0) {
        continue;
    }
    $table .= '<tr>';
    $table .= '<td>' . $i . '</td>';
    $table .= '<td>' . $row['bankWorkName'] . '</td>';
    $table .= '<td>' . number_format($row['bankPrice'], 0, '.', ' ') . '</td>';
    $table .= '<td>' . $row['bankPricePersent'] . '</td>';
    $table .= '<td>' . number_format($row['ourPrice'], 0, '.', ' ') . '</td>';
    $table .= '<td>' . $row['ourPricePersent'] . '</td>';
    $table .= '<td><button class="btn btn-rank modal-show">Оформить</button></td>';
    $table .= '</tr>';
    $i++;
}

$table .= <<<TABLE
                </tbody>
            </table>
TABLE;

echo $table;

