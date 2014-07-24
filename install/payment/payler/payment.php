<?if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true ) die();

CModule::IncludeModule('currency');
include dirname(__FILE__) . "/payler.classes.php";
include( GetLangFileName(dirname(__FILE__) . "/", "/payment.php") );
include( GetLangFileName(dirname(__FILE__) . "/", "/codes.php") );

function _getExplodeMoney($s,$m){
	@list($r,$k) = explode(".",$s);
	if($m) return (int) $k; else return (int) $r;
}

function _covert2utf($s){
	if(SITE_CHARSET!='UTF-8') return iconv(SITE_CHARSET, "UTF-8", $s); else return $s;
}

function genOrderId($oid,$sum){
	$result = md5($oid."-".randString(18));
	$arOrder = CSaleOrder::GetByID($oid);
	if ($arOrder)
	{
	   $arFields = array(
	      "PAY_VOUCHER_NUM"=>$result,
	      "PS_STATUS_MESSAGE"=>$result,
	     // "PAY_VOUCHER_DATE"=>date("Y:m:d H:i:s"),
	      "PS_STATUS"=>"N",
	      "PS_STATUS_CODE"=>"NEW",
	      "PS_STATUS_DESCRIPTION"=>GetMessage("PS_STATUS_CREATED"),
	      "PS_CURRENCY"=>GetMessage("PS_CURRENCY_PAYLER"),
	      "PS_RESPONSE_DATE"=>date("Y:m:d H:i:s"),
	      //"SUM_PAID"=>$sum,
	   );
	   CSaleOrder::Update($oid, $arFields);
	}
	return $result;
}

/* Проверяем заказ */
if(isset($arResult['ORDER_ID'])){
	$ORDER_ID = $arResult['ORDER_ID'];
}elseif(isset($arResult['ID'])){
    $ORDER_ID = $arResult['ID'];
}else{
    $ORDER_ID = (int) $_GET['ORDER_ID'];
};

$arOrder = CSaleOrder::GetByID($ORDER_ID);



/* Конвеертируем валюту в копеейки */
$current_price = _getExplodeMoney($arOrder["PRICE"],false) * CCurrencyRates::GetConvertFactor($arOrder["CURRENCY"], 'RUB') * 100 + _getExplodeMoney($arOrder["PRICE"],true);

/* Данные по корзине товаров (Названия товара и количество) */
$arBasketItems = array();
$arItemNames = "";
$arItemCounts = 0;
$dbBasketItems = CSaleBasket::GetList(array("NAME" => "ASC","ID" => "ASC"), array("LID" => SITE_ID, "ORDER_ID" => $ORDER_ID), false, false, array("NAME","QUANTITY"));
while ($arItems = $dbBasketItems->Fetch()) $arBasketItems[] = $arItems;
foreach ( $arBasketItems as $arItem )
{
	$arItemCounts = $arItemCounts + $arItem['QUANTITY'];
	$arItemNames[] = $arItem["NAME"];
}
$arItemNames = implode(", ",$arItemNames);


/* Параметры платежного обработчика */
$option = array(
	"DEBUG"=>CSalePaySystemAction::GetParamValue("PAYLER_DEBUG"),
	"KEY"=>CSalePaySystemAction::GetParamValue("PAYLER_KEY"),
	"PASSWORD"=>CSalePaySystemAction::GetParamValue("PAYLER_PASSWORD"),
	"TYPE"=>CSalePaySystemAction::GetParamValue("PAYLER_TYPE"),
	"ORDER_LIST"=>CSalePaySystemAction::GetParamValue("PAYLER_ORDER_LIST"),
	"ORDER_DETAIL"=>CSalePaySystemAction::GetParamValue("PAYLER_ORDER_DETAIL"),
);
if($option["DEBUG"]=="Y") $option["DEBUG"] == true; else $option["DEBUG"] == false;

/* Если оплачен - то кидаем его обратно в заказ */
if($arOrder["PAYED"] == "Y") header("Location: ".str_replace("#ID#",$ORDER_ID,$option["ORDER_DETAIL"]));

/* Payler API */
$payler = new CPayler($option["DEBUG"]);
$data = array(
	"key"=>$option["KEY"],
	"type"=>$option["TYPE"],
	"order_id"=>genOrderId($ORDER_ID,$current_price),
	"amount"=>$current_price,
	"product"=>_covert2utf($arItemNames),
	"total"=>$arItemCounts,
);


$session_data = $payler->POSTtoGateAPI($data, "StartSession");
$session_id = $session_data['session_id'];
$pay = $payler->Pay($session_id);

?>
<html>
<head>
<title>Loading...</title>
<script src="http://yandex.st/jquery/2.1.1/jquery.min.js"></script>
<style>
</style>
</head>
<body>
<?=$pay;?>

<script>$(document).ready(function(){$("#submit").click()})</script>
</body>
</html>

