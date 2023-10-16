<?php
use App\Models\EmployeeModel;

function RowStatus($type){
	if($type == 1){
		$class = "active-border";
	}else{
		$class = "inactive-border";
	}
	return $class;
}
function CheckStatus($value){ 
	if($value == 1){
		$name = "Yes";
	}else{
		$name = "No";
	}
	
	return $name;
}
function StatusInput($status){ 
    if($status != 0 ){ 
			  $html = '<input type="radio" class="" name="status" value="1" id="active" checked>';
		    $html .= '<label for="active" class="mr-1" >Active</label>';
		    $html .= '<input type="radio" class="" name="status" value="0" id="inactive">';
		    $html .= '<label for="inactive" class="mr-1">Inactive</label>';

	}else{ 
		$unchecked = $checked = "";
		if($status == 0){
			$checked = "checked";
		}else{
			$unchecked = "checked";
		}
		 $html = '<input type="radio"  class="" name="status" value="1" id="active" '.$unchecked.'>';
	     $html .= '<label for="active" class="mr-1" >Active</label>';
	     $html .= '<input type="radio" class="" name="status" value="0" id="inactive" '.$checked.' >';
	     $html .= '<label for="inactive" class="mr-1">Inactive</label>';
  	
	}
  return $html;
}
function SubmitButton($id=0){
	if($id == 0){
		$text = "Save";
	}else{
		$text = "Update";
	}
	$html = '<a href="javascript:window.history.go(-1);" type="button" id="btnCancel" class="btn btn-light">Cancel</a>&nbsp;';
	$html .= '<button  type="submit" id="btnSubmit" class="btn btn-info"><i class="fa fa-file-o"></i> '.$text.'</button>';
	return $html;
}
function GetImagePath($img_name,$folder_name){
	$url = base_url()."public/app-assets/images/logo/logo.png";
	if(!empty($img_name)){
		$url = base_url()."public/uploads/".$folder_name."/".$img_name;
	}
	return $url;
}
function dateFormat($value='')
{
	return date('Y-m-d', strtotime($value));
}
/*function GetUserProfile()
{
   $session = session();
     $id = $session->get('id');
     $db = db_connect();
     $commonModel = new CommonModel($db);
     $data = $commonModel->GetProfile($id);
     return $data;
}*/
function numberFormat($value)
{
	return number_format((float)$value, 2, '.', '');
}
function getUserInfo()
{
    $ci =& get_instance();
    p($ci);
}
function getSessionData()
{
	$session = session();
	$role = $session->get('role_name');
	$store = $session->get('store_id');
    $user_id = $session->get('id');

	if($store == "" && $role == "Staff") {
		$empModel = new EmployeeModel();
    	$data['emp'] = $empModel->GetEmployeeData($user_id);

    	if(!empty($data['emp']['stores'])){
            $store = $data['emp']['stores'][0]['store_id'];
        }
	}

    $sessionData = [
		'id' => $session->get('id'),
        'name' => $session->get('name'),
        'role_name' => $role,
        'store_id' => $store,
        'terminal_id' => $session->get('terminal_id'),
        'pos_id' => $session->get('pos_id'),
        'is_super_user' => $session->get('is_super_user'),
        'permissions' => $session->get('permissions')
	];

	return $sessionData;
}
function getEmployeePin()
{
	$session = session();
	$id = $session->get('id');

	$pin = "";
	$date = date('Y-m-d H:i:s');
	$getDefault = date_default_timezone_get();
    $dfDate = new DateTime($date, new DateTimeZone($getDefault));
    
	if(isset($id) && $id != "") {
		$empModel = new EmployeeModel();
		$emp = $empModel->where('id',$id)->first();

		$eTimezone = $emp['timezone'];
		if(!empty($eTimezone)) {

		    $dfDate->setTimezone(new DateTimeZone($eTimezone));
		    $H = $dfDate->format('H');
		    $D = $dfDate->format('d');
		    $M = $dfDate->format('m');

		    $pin = $H * $D + $M; // Hour * day + month e.g. (13 * 9 + 10) At 1:30PM, 9th of October

		    return $pin;

		} else {
    		$H = $dfDate->format('H');
    		$D = $dfDate->format('d');
    		$M = $dfDate->format('m');

    		$pin = $H * $D + $M;

		    return $pin;
		}
	}
	
}
function getCurrencies()
{
	$array = array(
		"AED"=> ["currency_name"=> "UAE Dirham", "currency_symbol"=> "AED", "currency_format" => 1234567.89],
		"AFN"=> ["currency_name"=> "Afghan Afghani", "currency_symbol"=> "AFN", "currency_format" => 1234567.89],
		"ALL"=>["currency_name"=> "Albanian Lek", "currency_symbol"=> "Lek", "currency_format" => 1234567.89],
		"AMD"=>["currency_name"=> "Armenian Dram", "currency_symbol"=> "AMD", "currency_format" => 1234567.89],
		"ANG"=>["currency_name"=> "Netherlands Antillian Guilder", "currency_symbol"=> "ƒ", "currency_format" => 1234567.89],
		"AOA"=>["currency_name"=> "Angolan Kwanza", "currency_symbol"=> "AOA", "currency_format" => 1234567.89],
		"ARS"=>["currency_name"=> "Argentine Peso", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"AUD"=>["currency_name"=> "Australian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"AWG"=>["currency_name"=> "Aruban Guilder", "currency_symbol"=> "ƒ", "currency_format" => 1234567.89],
		"AZN"=>["currency_name"=> "Azerbaijanian Manat", "currency_symbol"=> "AZN", "currency_format" => 1234567.89],
		"BAM"=>["currency_name"=> "Bosnia and Herzegovina Convertible Marks", "currency_symbol"=> "KM", "currency_format" => 1234567.89],
		"BBD"=>["currency_name"=> "Barbadian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"BDT"=>["currency_name"=> "Bangladeshi Taka", "currency_symbol"=> "BDT", "currency_format" => 1234567.89],
		"BGN"=>["currency_name"=> "Bulgarian Lev", "currency_symbol"=> "BGN", "currency_format" => 1234567.89],
		"BHD"=>["currency_name"=> "Bahraini Dinar", "currency_symbol"=> "BHD", "currency_format" => 1234567.89],
		"BIF"=>["currency_name"=> "Burundian Franc", "currency_symbol"=> "BIF", "currency_format" => 1234567.89],
		"BMD"=>["currency_name"=> "Bermudian Dollar (Bermuda Dollar)", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"BND"=>["currency_name"=> "Brunei Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"BOB"=>["currency_name"=> "Bolivian Boliviano", "currency_symbol"=> "$"."b", "currency_format" => 1234567.89],
		"BOV"=>["currency_name"=> "Mvdol", "currency_symbol"=> "BOV", "currency_format" => 1234567.89],
		"BRL"=>["currency_name"=> "Brazilian Real", "currency_symbol"=> "R$", "currency_format" => 1234567.89],
		"BSD"=>["currency_name"=> "Bahamian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"BTN"=>["currency_name"=> "Bhutanese Ngultrum", "currency_symbol"=> "BTN", "currency_format" => 1234567.89],
		"BWP"=>["currency_name"=> "Botswana Pula", "currency_symbol"=> "P", "currency_format" => 1234567.89],
		"BYN"=>["currency_name"=> "Belarussian Ruble", "currency_symbol"=> "p.", "currency_format" => 1234567.89],
		"BZD"=>["currency_name"=> "Belize Dollar", "currency_symbol"=> "BZ$", "currency_format" => 1234567.89],
		"CAD"=>["currency_name"=> "Canadian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"CDF"=>["currency_name"=> "Congolese franc", "currency_symbol"=> "CDF", "currency_format" => 1234567.89],
		"CHE"=>["currency_name"=> "WIR Euro", "currency_symbol"=> "CHE", "currency_format" => 1234567.89],
		"CHF"=>["currency_name"=> "Swiss Franc", "currency_symbol"=> "CHF", "currency_format" => 1234567.89],
		"CHW"=>["currency_name"=> "WIR Franc", "currency_symbol"=> "CHW", "currency_format" => 1234567.89],
		"CLF"=>["currency_name"=> "Chilean Unidades de formento", "currency_symbol"=> "CLF", "currency_format" => 1234567.89],
		"CLP"=>["currency_name"=> "Chilean Peso", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"CNY"=>["currency_name"=> "Yuan Renminbi", "currency_symbol"=> "CNY", "currency_format" => 1234567.89],
		"COP"=>["currency_name"=> "Colombian Peso", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"COU"=>["currency_name"=> "Unidad de Valor Real", "currency_symbol"=> "COU", "currency_format" => 1234567.89],
		"CRC"=>["currency_name"=> "Costa Rican Colon", "currency_symbol"=> "CRC", "currency_format" => 1234567.89],
		"CUC"=>["currency_name"=> "Cuban Convertible Peso", "currency_symbol"=> "CUC$", "currency_format" => 1234567.89],
		"CUP"=>["currency_name"=> "Cuban Peso", "currency_symbol"=> "CUP", "currency_format" => 1234567.89],
		"CVE"=>["currency_name"=> "Cape Verdean Escudo", "currency_symbol"=> "CVE", "currency_format" => 1234567.89],
		"CZK"=>["currency_name"=> "Czech Koruna", "currency_symbol"=> "CZK", "currency_format" => 1234567.89],
		"DJF"=>["currency_name"=> "Djiboutian Franc", "currency_symbol"=> "DJF", "currency_format" => 1234567.89],
		"DKK"=>["currency_name"=> "Danish Krone", "currency_symbol"=> "kr", "currency_format" => 1234567.89],
		"DOP"=>["currency_name"=> "Dominican Peso", "currency_symbol"=> "RD$", "currency_format" => 1234567.89],
		"DZD"=>["currency_name"=> "Algerian Dinar", "currency_symbol"=> "DZD", "currency_format" => 1234567.89],
		"EGP"=>["currency_name"=> "Egyptian Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"ERN"=>["currency_name"=> "Eritrean Nakfa", "currency_symbol"=> "ERN", "currency_format" => 1234567.89],
		"ETB"=>["currency_name"=> "Ethiopian Birr", "currency_symbol"=> "ETB", "currency_format" => 1234567.89],
		"EUR"=>["currency_name"=> "Euro", "currency_symbol"=> "€", "currency_format" => 1234567.89],
		"FJD"=>["currency_name"=> "Fijian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"FKP"=>["currency_name"=> "Falkland Islands Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"GBP"=>["currency_name"=> "Pound Sterling", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"GEL"=>["currency_name"=> "Georgian Lari", "currency_symbol"=> "GEL", "currency_format" => 1234567.89],
		"GGP"=>["currency_name"=> "Guernsey Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"GHS"=>["currency_name"=> "Ghanaian Cedi", "currency_symbol"=> "¢", "currency_format" => 1234567.89],
		"GIP"=>["currency_name"=> "Gibraltar Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"GMD"=>["currency_name"=> "Gambian Dalasi", "currency_symbol"=> "GMD", "currency_format" => 1234567.89],
		"GNF"=>["currency_name"=> "Guinean Franc", "currency_symbol"=> "GNF", "currency_format" => 1234567.89],
		"GTQ"=>["currency_name"=> "Guatemalan Quetzal", "currency_symbol"=> "Q", "currency_format" => 1234567.89],
		"GYD"=>["currency_name"=> "Guyanese Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"HKD"=>["currency_name"=> "Hong Kong Dollar", "currency_symbol"=> "HK$", "currency_format" => 1234567.89],
		"HNL"=>["currency_name"=> "Honduran Lempira", "currency_symbol"=> "L", "currency_format" => 1234567.89],
		"HRK"=>["currency_name"=> "Croatian Kuna", "currency_symbol"=> "kn", "currency_format" => 1234567.89],
		"HTG"=>["currency_name"=> "Haitian Gourde", "currency_symbol"=> "HTG", "currency_format" => 1234567.89],
		"HUF"=>["currency_name"=> "Hungarian Forint", "currency_symbol"=> "Ft", "currency_format" => 1234567.89],
		"IDR"=>["currency_name"=> "Indonesian Rupiah", "currency_symbol"=> "Rp", "currency_format" => 1234567.89],
		"ILS"=>["currency_name"=> "Israeli new shekel", "currency_symbol"=> "ILS", "currency_format" => 1234567.89],
		"IMP"=>["currency_name"=> "Manx Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"INR"=>["currency_name"=> "Indian Rupee", "currency_symbol"=> "Rs.", "currency_format" => 1234567.89],
		"IQD"=>["currency_name"=> "Iraqi Dinar", "currency_symbol"=> "IQD", "currency_format" => 1234567.89],
		"IRR"=>["currency_name"=> "Iranian Rial", "currency_symbol"=> "IRR", "currency_format" => 1234567.89],
		"ISK"=>["currency_name"=> "Icelandic Krona", "currency_symbol"=> "kr", "currency_format" => 1234567.89],
		"JEP"=>["currency_name"=> "Jersey Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"JMD"=>["currency_name"=> "Jamaican Dollar", "currency_symbol"=> "J$", "currency_format" => 1234567.89],
		"JOD"=>["currency_name"=> "Jordanian Dinar", "currency_symbol"=> "JOD", "currency_format" => 1234567.89],
		"JPY"=>["currency_name"=> "Japanese Yen", "currency_symbol"=> "¥", "currency_format" => 1234567.89],
		"KES"=>["currency_name"=> "Kenyan Shilling", "currency_symbol"=> "KES", "currency_format" => 1234567.89],
		"KGS"=>["currency_name"=> "Kyrgyzstani Som", "currency_symbol"=> "KGS", "currency_format" => 1234567.89],
		"KHR"=>["currency_name"=> "Cambodian Riel", "currency_symbol"=> "KHR", "currency_format" => 1234567.89],
		"KMF"=>["currency_name"=> "Comorian Franc", "currency_symbol"=> "KMF", "currency_format" => 1234567.89],
		"KPW"=>["currency_name"=> "North Korean Won", "currency_symbol"=> "₩", "currency_format" => 1234567.89],
		"KRW"=>["currency_name"=> "South Korean Won", "currency_symbol"=> "₩", "currency_format" => 1234567.89],
		"KWD"=>["currency_name"=> "Kuwaiti Dinar", "currency_symbol"=> "KWD", "currency_format" => 1234567.89],
		"KYD"=>["currency_name"=> "Cayman Islands Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"KZT"=>["currency_name"=> "Kazakhstani Tenge", "currency_symbol"=> "KZT", "currency_format" => 1234567.89],
		"LAK"=>["currency_name"=> "Lao Kip", "currency_symbol"=> "LAK", "currency_format" => 1234567.89],
		"LBP"=>["currency_name"=> "Lebanese Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"LKR"=>["currency_name"=> "Sri Lankan Rupee", "currency_symbol"=> "Rs", "currency_format" => 1234567.89],
		"LRD"=>["currency_name"=> "Liberian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"LSL"=>["currency_name"=> "Lesotho Loti", "currency_symbol"=> "LSL", "currency_format" => 1234567.89],
		"LYD"=>["currency_name"=> "Libyan Dinar", "currency_symbol"=> "LYD", "currency_format" => 1234567.89],
		"MAD"=>["currency_name"=> "Moroccan Dirham", "currency_symbol"=> "MAD", "currency_format" => 1234567.89],
		"MDL"=>["currency_name"=> "Moldovan Leu", "currency_symbol"=> "MDL", "currency_format" => 1234567.89],
		"MGA"=>["currency_name"=> "Malagascy Ariary", "currency_symbol"=> "MGA", "currency_format" => 1234567.89],
		"MKD"=>["currency_name"=> "Macedonian Denar", "currency_symbol"=> "MKD", "currency_format" => 1234567.89],
		"MMK"=>["currency_name"=> "Burmese Kyat", "currency_symbol"=> "MMK", "currency_format" => 1234567.89],
		"MNT"=>["currency_name"=> "Mongolian Tugrik", "currency_symbol"=> "MNT", "currency_format" => 1234567.89],
		"MOP"=>["currency_name"=> "Macanese Pataca", "currency_symbol"=> "MOP", "currency_format" => 1234567.89],
		"MRO"=>["currency_name"=> "Ouguiya", "currency_symbol"=> "MRO", "currency_format" => 1234567.89],
		"MRU"=>["currency_name"=> "Ouguiya", "currency_symbol"=> "MRU", "currency_format" => 1234567.89],
		"MUR"=>["currency_name"=> "Mauritian Rupee", "currency_symbol"=> "Rp", "currency_format" => 1234567.89],
		"MVR"=>["currency_name"=> "Maldivian Rufiyaa", "currency_symbol"=> "MVR", "currency_format" => 1234567.89],
		"MWK"=>["currency_name"=> "Malawian Kwacha", "currency_symbol"=> "MWK", "currency_format" => 1234567.89],
		"MXN"=>["currency_name"=> "Mexican Peso", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"MXV"=>["currency_name"=> "Mexican Unidad de Inversion (UID)", "currency_symbol"=> "MXV", "currency_format" => 1234567.89],
		"MYR"=>["currency_name"=> "Malaysian Ringgit", "currency_symbol"=> "RM", "currency_format" => 1234567.89],
		"MZN"=>["currency_name"=> "Mozambican Metical", "currency_symbol"=> "MT", "currency_format" => 1234567.89],
		"NAD"=>["currency_name"=> "Namibian Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"NGN"=>["currency_name"=> "Nigerian Naira", "currency_symbol"=> "NGN", "currency_format" => 1234567.89],
		"NIO"=>["currency_name"=> "Nicaraguan Cordoba Oro", "currency_symbol"=> "C$", "currency_format" => 1234567.89],
		"NOK"=>["currency_name"=> "Norwegian Krone", "currency_symbol"=> "kr", "currency_format" => 1234567.89],
		"NPR"=>["currency_name"=> "Nepalese Rupee", "currency_symbol"=> "Rp", "currency_format" => 1234567.89],
		"NZD"=>["currency_name"=> "New Zealand Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"OMR"=>["currency_name"=> "Omani rial", "currency_symbol"=> "OMR", "currency_format" => 1234567.89],
		"PAB"=>["currency_name"=> "Panamanian Balboa", "currency_symbol"=> "B/.", "currency_format" => 1234567.89],
		"PEN"=>["currency_name"=> "Peruvian Nuevo Sol", "currency_symbol"=> "S/.", "currency_format" => 1234567.89],
		"PGK"=>["currency_name"=> "Papua New Guinean Kina", "currency_symbol"=> "PGK", "currency_format" => 1234567.89],
		"PHP"=>["currency_name"=> "Philippine Peso", "currency_symbol"=> "Php", "currency_format" => 1234567.89],
		"PKR"=>["currency_name"=> "Pakistani Rupee", "currency_symbol"=> "Rs", "currency_format" => 1234567.89],
		"PLN"=>["currency_name"=> "Polish Zloty", "currency_symbol"=> "PLN", "currency_format" => 1234567.89],
		"PYG"=>["currency_name"=> "Paraguayan Guarani", "currency_symbol"=> "Gs", "currency_format" => 1234567.89],
		"QAR"=>["currency_name"=> "Qatari Riyal", "currency_symbol"=> "QAR", "currency_format" => 1234567.89],
		"RON"=>["currency_name"=> "Romanian Leu", "currency_symbol"=> "lei", "currency_format" => 1234567.89],
		"RSD"=>["currency_name"=> "Serbian Dinar", "currency_symbol"=> "RSD", "currency_format" => 1234567.89],
		"RUB"=>["currency_name"=> "Russian Ruble", "currency_symbol"=> "RUB", "currency_format" => 1234567.89],
		"RWF"=>["currency_name"=> "Rwandan Franc", "currency_symbol"=> "RWF", "currency_format" => 1234567.89],
		"SAR"=>["currency_name"=> "Saudi Riyal", "currency_symbol"=> "SAR", "currency_format" => 1234567.89],
		"SBD"=>["currency_name"=> "Solomon Islands Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"SCR"=>["currency_name"=> "Seychellois Rupee", "currency_symbol"=> "Rp", "currency_format" => 1234567.89],
		"SDG"=>["currency_name"=> "Sudanese Pound", "currency_symbol"=> "SDG", "currency_format" => 1234567.89],
		"SEK"=>["currency_name"=> "Swedish Krona", "currency_symbol"=> "kr", "currency_format" => 1234567.89],
		"SGD"=>["currency_name"=> "Singapore Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"SHP"=>["currency_name"=> "Saint Helena Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"SLL"=>["currency_name"=> "Sierra Leonean Leone", "currency_symbol"=> "SLL", "currency_format" => 1234567.89],
		"SOS"=>["currency_name"=> "Somali Shilling", "currency_symbol"=> "S", "currency_format" => 1234567.89],
		"SRD"=>["currency_name"=> "Surinamese Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"SSP"=>["currency_name"=> "South Sudanese Pound", "currency_symbol"=> "SSP", "currency_format" => 1234567.89],
		"STD"=>["currency_name"=> " Sao Tomean Dobra", "currency_symbol"=> "STD", "currency_format" => 1234567.89],
		"STN"=>["currency_name"=> "Sao Tome and Principe Dobra", "currency_symbol"=> "STN", "currency_format" => 1234567.89],
		"SVC"=>["currency_name"=> "El Salvador Colon", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"SYP"=>["currency_name"=> "Syrian Pound", "currency_symbol"=> "£", "currency_format" => 1234567.89],
		"SZL"=>["currency_name"=> "Swazi Lilangeni", "currency_symbol"=> "SZL", "currency_format" => 1234567.89],
		"THB"=>["currency_name"=> "Thai Baht", "currency_symbol"=> "THB", "currency_format" => 1234567.89],
		"TJS"=>["currency_name"=> "Tajikistani Somoni", "currency_symbol"=> "TJS", "currency_format" => 1234567.89],
		"TMT"=>["currency_name"=> "Turkmenistan Manat", "currency_symbol"=> "TMT", "currency_format" => 1234567.89],
		"TND"=>["currency_name"=> "Tunisian Dinar", "currency_symbol"=> "TND", "currency_format" => 1234567.89],
		"TOP"=>["currency_name"=> "Tongan Paanga", "currency_symbol"=> "TOP", "currency_format" => 1234567.89],
		"TRY"=>["currency_name"=> "Turkish Lira", "currency_symbol"=> "YTL", "currency_format" => 1234567.89],
		"TTD"=>["currency_name"=> "Trinidad and Tobago Dollar", "currency_symbol"=> "TT$", "currency_format" => 1234567.89],
		"TVD"=>["currency_name"=> "Tuvaluan Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"TWD"=>["currency_name"=> "New Taiwan Dollar", "currency_symbol"=> "NT$", "currency_format" => 1234567.89],
		"TZS"=>["currency_name"=> "Tanzanian Shilling", "currency_symbol"=> "TZS", "currency_format" => 1234567.89],
		"UAH"=>["currency_name"=> "Ukrainian Hryvnia", "currency_symbol"=> "UAH", "currency_format" => 1234567.89],
		"UGX"=>["currency_name"=> "Ugandan Shilling", "currency_symbol"=> "UGX", "currency_format" => 1234567.89],
		"USD"=>["currency_name"=> "United States Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"UYI"=>["currency_name"=> "Uruguay Peso en Unidades Indexadas", "currency_symbol"=> "UYI", "currency_format" => 1234567.89],
		"UYU"=>["currency_name"=> "Uruguayan peso", "currency_symbol"=> "$"."U", "currency_format" => 1234567.89],
		"UZS"=>["currency_name"=> "Uzbekistani Sum", "currency_symbol"=> "UZS", "currency_format" => 1234567.89],
		"VED"=>["currency_name"=> "Venezuelan Bolivar Digital", "currency_symbol"=> "VED", "currency_format" => 1234567.89],
		"VEF"=>["currency_name"=> "Venezuelan Bolivar Fuerte", "currency_symbol"=> "VEF", "currency_format" => 1234567.89],
		"VES"=>["currency_name"=> "Venezuelan Bolivar Soberano", "currency_symbol"=> "VES", "currency_format" => 1234567.89],
		"VND"=>["currency_name"=> "Vietnamese Dong", "currency_symbol"=> "VND", "currency_format" => 1234567.89],
		"VUV"=>["currency_name"=> "Vanuatu Vatu", "currency_symbol"=> "VUV", "currency_format" => 1234567.89],
		"WST"=>["currency_name"=> "Samoan Tala", "currency_symbol"=> "WST", "currency_format" => 1234567.89],
		"XAF"=>["currency_name"=> "Central African CFA Franc", "currency_symbol"=> "XAF", "currency_format" => 1234567.89],
		"XCD"=>["currency_name"=> "Eastern Caribbean Dollar", "currency_symbol"=> "$", "currency_format" => 1234567.89],
		"XDR"=>["currency_name"=> "SDR", "currency_symbol"=> "XDR", "currency_format" => 1234567.89],
		"XOF"=>["currency_name"=> "CFA Franc BCEAO", "currency_symbol"=> "XOF", "currency_format" => 1234567.89],
		"XPF"=>["currency_name"=> "CFP Franc", "currency_symbol"=> "XPF", "currency_format" => 1234567.89],
		"YER"=>["currency_name"=> "Yemeni Rial", "currency_symbol"=> "YER", "currency_format" => 1234567.89],
		"ZAR"=>["currency_name"=> "South African Rand", "currency_symbol"=> "R", "currency_format" => 1234567.89],
		"ZMW"=>["currency_name"=> "Zambian Kwacha", "currency_symbol"=> "ZMW", "currency_format" => 1234567.89],
		"ZWL"=>["currency_name"=> "Zimbabwe Dollar", "currency_symbol"=> "Z$", "currency_format" => 1234567.89]
	);
	
	$json = json_encode($array);
	return $json;
}
?>