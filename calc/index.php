<?php

date_default_timezone_set('Europe/Moscow');

require_once __DIR__ . '/block.php';
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

switch (filter_input(INPUT_POST, 'fz', FILTER_DEFAULT)) {
  case 'fz44':
    $fz = 44;
    break;
  case 'fz223':
    $fz = 223;
    break;
  case 'fz185':
    $fz = 185;
    break;
  case 'kontrakt':
    $fz = 'Commercial';
    break;
  default:
    $fz = 44;
}
$params['Fz'] = $fz;

switch (filter_input(INPUT_POST, 'garant', FILTER_DEFAULT)) {
  case '1':
    $typeBg = 'participation';
    break;
  case '2':
    $typeBg = 'execution';
    break;
  case '3':
    $typeBg = 'warrantyObligations';
    break;
  case '4':
    $typeBg = 'avansReturn';
    break;
  default:
    $typeBg = 'participation';
}
$params['TypeBg'] = $typeBg;

$summ = str_replace(' ', '', filter_input(INPUT_POST, 'summ', FILTER_DEFAULT));
$params['Summ'] = $summ;

$params['StartDate'] = filter_input(INPUT_POST, 'date-begin', FILTER_DEFAULT);
$params['EndDate'] = filter_input(INPUT_POST, 'date-end', FILTER_DEFAULT);

switch (filter_input(INPUT_POST, 'dop', FILTER_DEFAULT)) {
    case 'minus':
      $params['NetLossLastYear'] = 'true';
      break;
    case 'exp':
      $params['NoExperience'] = 'true';
      break;
    case 'form':
      $params['СustomerForm'] = 'true';
      break;
    case 'block':
      $params['BlockBankAccount'] = 'true';
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
        <table class="tableBank">
          <tbody>
          <tr>
            <td>Банк</td>
            <td>Цена БГ в банке</td>
            <td>Тариф банка</td>
            <td>Наша цена со скидкой</td>
            <td>Наш тариф</td>
            <td></td>
          </tr>
TABLE;

foreach ($result as $row) {
    // Не выводить банки с 0
    if ($row['bankPrice'] == 0) {
        continue;
    }
    $table .= '<tr>';
    $table .= '<td>' . $row['bankWorkName'] . '</td>';
    $table .= '<td>' . number_format($row['bankPrice'], 0, '.', ' ') . '</td>';
    $table .= '<td>' . $row['bankDiscountPricePersent'] . '</td>';
    $table .= '<td>' . number_format($row['ourPrice'], 0, '.', ' ') . '</td>';
    $table .= '<td>' . $row['ourPricePersent'] . '</td>';
    $table .= '<td><button class="btn-header">Получить</button></td>';
    $table .= '</tr>';
}

$table .= <<<TABLE
          </tbody>
        </table>
TABLE;

echo $table;

