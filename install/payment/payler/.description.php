<?if ( !defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true )
{
	die();
}

include( GetLangFileName(dirname(__FILE__) . "/", "/.description.php") );


$psTitle = GetMessage('PAYLER_PSTITLE');
$psDescription = GetMessage('PAYLER_PSDESCR');


$array = array("payler_debug","payler_key","payler_password","payler_type","payler_order_list","payler_order_detail","payler_order_success","payler_order_error");

$arPSCorrespondence = array(

	"PAYLER_KEY"  => array(
		"NAME"  => GetMessage("PAYLER_KEY_NAME"),
		"DESCR" => GetMessage("PAYLER_KEY_DESCR"),
		"VALUE" => GetMessage("PAYLER_KEY_VAL"),
		"TYPE"  => ""
	),
	"PAYLER_PASSWORD"  => array(
		"NAME"  => GetMessage("PAYLER_PASSWORD_NAME"),
		"DESCR" => GetMessage("PAYLER_PASSWORD_DESCR"),
		"VALUE" => GetMessage("PAYLER_PASSWORD_VAL"),
		"TYPE"  => ""
	),
	"PAYLER_ORDER_LIST"  => array(
		"NAME"  => GetMessage("PAYLER_ORDER_LIST_NAME"),
		"DESCR" => GetMessage("PAYLER_ORDER_LIST_DESCR"),
		"VALUE" => GetMessage("PAYLER_ORDER_LIST_VAL"),
		"TYPE"  => ""
	),
	"PAYLER_ORDER_DETAIL"  => array(
		"NAME"  => GetMessage("PAYLER_ORDER_DETAIL_NAME"),
		"DESCR" => GetMessage("PAYLER_ORDER_DETAIL_DESCR"),
		"VALUE" => GetMessage("PAYLER_ORDER_DETAIL_VAL"),
		"TYPE"  => ""
	),
	"PAYLER_ORDER_SUCCESS"  => array(
		"NAME"  => GetMessage("PAYLER_ORDER_SUCCESS_NAME"),
		"DESCR" => GetMessage("PAYLER_ORDER_SUCCESS_DESCR"),
		"VALUE" => GetMessage("PAYLER_ORDER_SUCCESS_VAL"),
		"TYPE"  => ""
	),
	"PAYLER_ORDER_ERROR"  => array(
		"NAME"  => GetMessage("PAYLER_ORDER_ERROR_NAME"),
		"DESCR" => GetMessage("PAYLER_ORDER_ERROR_DESCR"),
		"VALUE" => GetMessage("PAYLER_ORDER_ERROR_VAL"),
		"TYPE"  => ""
	),
    "PAYLER_DEBUG" => array(
        "NAME" => GetMessage("PAYLER_DEBUG_NAME"),
        "DESCR" => GetMessage("PAYLER_DEBUG_DESCR"),
        "VALUE" => array(
            "Y" => array('NAME' => GetMessage("PAYLER_DEBUG_VAL_Y")),
            "N" => array('NAME' => GetMessage("PAYLER_DEBUG_VAL_N")),
        ),
        "TYPE" => "SELECT",
    ),
	"PAYLER_TYPE"  => array(
		"NAME"  => GetMessage("PAYLER_TYPE_NAME"),
		"DESCR" => GetMessage("PAYLER_TYPE_DESCR"),
        "VALUE" => array(
            "Pay" => array('NAME' => GetMessage("PAYLER_TYPE_VAL_PAY"))
        ),
		"TYPE"  => "SELECT"
	),

);
?>
