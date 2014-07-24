<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?php

CModule::IncludeModule('currency');
CModule::IncludeModule('sale');

include("/bitrix/php_interface/include/sale_payment/payler/payler.classes.php");
include(GetLangFileName("/bitrix/php_interface/include/sale_payment/payler/result.php"));
include(GetLangFileName("/bitrix/php_interface/include/sale_payment/payler/codes.php"));



$VOUCHER_NUM = $_GET['order_id'];


$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("PERSON_TYPE_ID"=>"1","ACTIVE"=>"Y"));
while ($ptype = $db_ptype->Fetch())
{
    if($ptype["PSA_ACTION_FILE"]=="/bitrix/php_interface/include/sale_payment/payler") $arPaySys = unserialize($ptype["PSA_PARAMS"]);
}

$option = array(
    "DEBUG"=>$arPaySys["PAYLER_DEBUG"]["VALUE"],
    "KEY"=>$arPaySys["PAYLER_KEY"]["VALUE"],
    "PASSWORD"=>$arPaySys["PAYLER_PASSWORD"]["VALUE"],
    "TYPE"=>$arPaySys["PAYLER_TYPE"]["VALUE"],
    "ORDER_LIST"=>$arPaySys["PAYLER_ORDER_LIST"]["VALUE"],
    "ORDER_DETAIL"=>$arPaySys["PAYLER_ORDER_DETAIL"]["VALUE"],
    "ORDER_SUCCESS"=>$arPaySys["PAYLER_ORDER_SUCCESS"]["VALUE"],
    "ORDER_ERROR"=>$arPaySys["PAYLER_ORDER_ERROR"]["VALUE"],
);
if($option["DEBUG"]=="Y") $option["DEBUG"] == true; else $option["DEBUG"] == false;
if($option["ORDER_SUCCESS"]=="") 	$ok_order = str_replace("#ID#",$ORDER_ID,$option["ORDER_SUCCESS"]); 	else $ok_order = str_replace("#ID#",$ORDER_ID,$option["ORDER_DETAIL"]);
if($option["ORDER_ERROR"]=="") 		$error_order = str_replace("#ID#",$ORDER_ID,$option["ORDER_ERROR"]); 	else $error_order = str_replace("#ID#",$ORDER_ID,$option["ORDER_DETAIL"]);


if($VOUCHER_NUM=='') LocalRedirect($error_order);
$arFilter = Array("USER_ID" => $USER->GetID(),"PS_STATUS_MESSAGE"=>$VOUCHER_NUM);
$db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "ASC"), $arFilter);
while ($ar_sales = $db_sales->Fetch()) $ORDER_ID = $ar_sales["ID"];


$payler = new CPayler($option["DEBUG"]);
$data = array (
    "key" => $option["KEY"],
    "order_id" => $VOUCHER_NUM,
);
$result = $payler->POSTtoGateAPI($data, "GetStatus");
if($result['status'] == 'Charged') {
    echo'ok';
    $arOrder = CSaleOrder::GetByID($ORDER_ID);
    $arFields = array(
        "PS_STATUS"=>"Y",
        "PS_STATUS_CODE"=>$result['status'],
        "PS_STATUS_DESCRIPTION"=>$result['message']
    );
    CSaleOrder::PayOrder($ORDER_ID, 'Y', false, null, 0, $arField);
    LocalRedirect($ok_order);
}else{
    $arOrder = CSaleOrder::GetByID($ORDER_ID);
    if ($arOrder)
    {
        $arFields = array(
            "PS_STATUS"=>"N",
            "PS_STATUS_CODE"=>$result['status'],
            "PS_STATUS_DESCRIPTION"=>$result['message']
        );
        CSaleOrder::Update($ORDER_ID, $arFields);
        LocalRedirect($error_order);
    };
};
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>