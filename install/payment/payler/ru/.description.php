<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $MESS;


$MESS["PAYLER_PSTITLE"] = "Payler";
$MESS["PAYLER_PSDESCR"] = 'Интернет-эквайринг <a href="http://payler.ru" target="_blank">Payler.ru</a>. Для обратной ссылки из системы Payler укажите http://ваш_сайт/bitrix/tools/result.php';

$MESS["PAYLER_DEBUG_NAME"] = "Режим отладки";
$MESS["PAYLER_DEBUG_DESCR"] = "Включает возможность приема тестовых платежей";
$MESS["PAYLER_DEBUG_VAL_Y"] = "Включить";
$MESS["PAYLER_DEBUG_VAL_N"] = "Выключить";

$MESS["PAYLER_KEY_NAME"] = "Идентификатор продавца";
$MESS["PAYLER_KEY_DESCR"] = "Ваш идентификатор в системе Payler.ru";
$MESS["PAYLER_KEY_VAL"] = "";

$MESS["PAYLER_PASSWORD_NAME"] = "Платежный пароль";
$MESS["PAYLER_PASSWORD_DESCR"] = "Ваш платежный пароль в системе Payler.ru";
$MESS["PAYLER_PASSROD_VAL"] = "";

$MESS["PAYLER_TYPE_NAME"] = "Тип платежей";
$MESS["PAYLER_TYPE_DESCR"] = "Выбор метода работы с транзакциями";
$MESS["PAYLER_TYPE_VAL_PAY"] = "PAY - стандартная оплата";

$MESS["PAYLER_ORDER_LIST_NAME"] = "Страница со список заказов";
$MESS["PAYLER_ORDER_LIST_DESCR"] = "Укажите ссылку на список заказов. Например /personal/order/";
$MESS["PAYLER_ORDER_LIST_VAL"] = "/personal/order/";

$MESS["PAYLER_ORDER_DETAIL_NAME"] = "Страница детального отображения заказа";
$MESS["PAYLER_ORDER_DETAIL_DESCR"] = "Укажите ссылку на страницу заказа, где #ID# - номер заказа. Например /personal/order/detail/#ID#/";
$MESS["PAYLER_ORDER_DETAIL_VAL"] = "/personal/order/detail/#ID#/";


$MESS["PAYLER_ORDER_SUCCESS_NAME"] = "Страница с поздравлением об успешной оплате";
$MESS["PAYLER_ORDER_SUCCESS_DESCR"] = "Укажите ссылку на страницу УСПЕШНО ВЫПОЛНЕНГО заказа, где #ID# - номер заказа. Например /personal/order/success_payd/#ID#/";
$MESS["PAYLER_ORDER_SUCCESS_VAL"] = "/personal/order/success_payd/#ID#/";


$MESS["PAYLER_ORDER_ERROR_NAME"] = "Страница с ошибкой";
$MESS["PAYLER_ORDER_ERROR_DESCR"] = "Укажите ссылку на страницу ОШИБКИ при заказе, где #ID# - номер заказа. Например /personal/order/error_payd/#ID#/";
$MESS["PAYLER_ORDER_ERROR_VAL"] = "/personal/order/error_payd/#ID#/";
?>