<?php

/******************************************************************************/
/******************************************************************************/

class CBSCurrency
{
	/**************************************************************************/
	
	function __construct()
	{
		$this->currency=array
		(
			'AFN'=>array
			(
				'name'=>__('Afghan afghani','car-wash-booking-system'),
				'symbol'=>'AFN'
			),
			'ALL'=>array
			(
				'name'=>__('Albanian lek','car-wash-booking-system'),
				'symbol'=>'ALL'
			),
			'DZD'=>array
			(
				'name'=>__('Algerian dinar','car-wash-booking-system'),
				'symbol'=>'DZD'
			),
			'AOA'=>array
			(
				'name'=>__('Angolan kwanza','car-wash-booking-system'),
				'symbol'=>'AOA'
			),
			'ARS'=>array
			(
				'name'=>__('Argentine peso','car-wash-booking-system'),
				'symbol'=>'ARS'
			),
			'AMD'=>array
			(
				'name'=>__('Armenian dram','car-wash-booking-system'),
				'symbol'=>'AMD'
			),
			'AWG'=>array
			(
				'name'=>__('Aruban florin','car-wash-booking-system'),
				'symbol'=>'AWG'
			),
			'AUD'=>array
			(
				'name'=>__('Australian dollar','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'AZN'=>array
			(
				'name'=>__('Azerbaijani manat','car-wash-booking-system'),
				'symbol'=>'AZN'
			),
			'BSD'=>array
			(
				'name'=>__('Bahamian dollar','car-wash-booking-system'),
				'symbol'=>'BSD'
			),
			'BHD'=>array
			(
				'name'=>__('Bahraini dinar','car-wash-booking-system'),
				'symbol'=>'BHD',
				'separator'=>'&#1643;'
			),
			'BDT'=>array
			(
				'name'=>__('Bangladeshi taka','car-wash-booking-system'),
				'symbol'=>'BDT'
			),
			'BBD'=>array
			(
				'name'=>__('Barbadian dollar','car-wash-booking-system'),
				'symbol'=>'BBD'
			),
			'BYR'=>array
			(
				'name'=>__('Belarusian ruble','car-wash-booking-system'),
				'symbol'=>'BYR'
			),
			'BZD'=>array
			(
				'name'=>__('Belize dollar','car-wash-booking-system'),
				'symbol'=>'BZD'
			),
			'BTN'=>array
			(
				'name'=>__('Bhutanese ngultrum','car-wash-booking-system'),
				'symbol'=>'BTN'
			),
			'BOB'=>array
			(
				'name'=>__('Bolivian boliviano','car-wash-booking-system'),
				'symbol'=>'BOB'
			),
			'BAM'=>array
			(
				'name'=>__('Bosnia and Herzegovina konvertibilna marka','car-wash-booking-system'),
				'symbol'=>'BAM'
			),
			'BWP'=>array
			(
				'name'=>__('Botswana pula','car-wash-booking-system'),
				'symbol'=>'BWP',
				'separator'=>'.'
			),
			'BRL'=>array
			(
				'name'=>__('Brazilian real','car-wash-booking-system'),
				'symbol'=>'&#82;&#36;'
			),
			'GBP'=>array
			(
				'name'=>__('British pound','car-wash-booking-system'),
				'symbol'=>'&pound;',
				'position'=>'left',
				'separator'=>'.',
			),
			'BND'=>array
			(
				'name'=>__('Brunei dollar','car-wash-booking-system'),
				'symbol'=>'BND',
				'separator'=>'.'
			),
			'BGN'=>array
			(
				'name'=>__('Bulgarian lev','car-wash-booking-system'),
				'symbol'=>'BGN'
			),
			'BIF'=>array
			(
				'name'=>__('Burundi franc','car-wash-booking-system'),
				'symbol'=>'BIF'
			),
			'KYD'=>array
			(
				'name'=>__('Cayman Islands dollar','car-wash-booking-system'),
				'symbol'=>'KYD'
			),
			'KHR'=>array
			(
				'name'=>__('Cambodian riel','car-wash-booking-system'),
				'symbol'=>'KHR'
			),
			'CAD'=>array
			(
				'name'=>__('Canadian dollar','car-wash-booking-system'),
				'symbol'=>'CAD',
				'separator'=>'.'
			),
			'CVE'=>array
			(
				'name'=>__('Cape Verdean escudo','car-wash-booking-system'),
				'symbol'=>'CVE'
			),
			'XAF'=>array
			(
				'name'=>__('Central African CFA franc','car-wash-booking-system'),
				'symbol'=>'XAF'
			),
			'GQE'=>array
			(
				'name'=>__('Central African CFA franc','car-wash-booking-system'),
				'symbol'=>'GQE'
			),
			'XPF'=>array
			(
				'name'=>__('CFP franc','car-wash-booking-system'),
				'symbol'=>'XPF'
			),
			'CLP'=>array
			(
				'name'=>__('Chilean peso','car-wash-booking-system'),
				'symbol'=>'CLP'
			),
			'CNY'=>array
			(
				'name'=>__('Chinese renminbi','car-wash-booking-system'),
				'symbol'=>'&yen;'
			),
			'COP'=>array
			(
				'name'=>__('Colombian peso','car-wash-booking-system'),
				'symbol'=>'COP'
			),
			'KMF'=>array
			(
				'name'=>__('Comorian franc','car-wash-booking-system'),
				'symbol'=>'KMF'
			),
			'CDF'=>array
			(
				'name'=>__('Congolese franc','car-wash-booking-system'),
				'symbol'=>'CDF'
			),
			'CRC'=>array
			(
				'name'=>__('Costa Rican colon','car-wash-booking-system'),
				'symbol'=>'CRC'
			),
			'HRK'=>array
			(
				'name'=>__('Croatian kuna','car-wash-booking-system'),
				'symbol'=>'HRK'
			),
			'CUC'=>array
			(
				'name'=>__('Cuban peso','car-wash-booking-system'),
				'symbol'=>'CUC'
			),
			'CZK'=>array
			(
				'name'=>__('Czech koruna','car-wash-booking-system'),
				'symbol'=>'&#75;&#269;'
			),
			'DKK'=>array
			(
				'name'=>__('Danish krone','car-wash-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'DJF'=>array
			(
				'name'=>__('Djiboutian franc','car-wash-booking-system'),
				'symbol'=>'DJF'
			),
			'DOP'=>array
			(
				'name'=>__('Dominican peso','car-wash-booking-system'),
				'symbol'=>'DOP',
				'separator'=>'.'
			),
			'XCD'=>array
			(
				'name'=>__('East Caribbean dollar','car-wash-booking-system'),
				'symbol'=>'XCD'
			),
			'EGP'=>array
			(
				'name'=>__('Egyptian pound','car-wash-booking-system'),
				'symbol'=>'EGP'
			),
			'ERN'=>array
			(
				'name'=>__('Eritrean nakfa','car-wash-booking-system'),
				'symbol'=>'ERN'
			),
			'EEK'=>array
			(
				'name'=>__('Estonian kroon','car-wash-booking-system'),
				'symbol'=>'EEK'
			),
			'ETB'=>array
			(
				'name'=>__('Ethiopian birr','car-wash-booking-system'),
				'symbol'=>'ETB'
			),
			'EUR'=>array
			(
				'name'=>__('European euro','car-wash-booking-system'),
				'symbol'=>'&euro;'
			),
			'FKP'=>array
			(
				'name'=>__('Falkland Islands pound','car-wash-booking-system'),
				'symbol'=>'FKP'
			),
			'FJD'=>array
			(
				'name'=>__('Fijian dollar','car-wash-booking-system'),
				'symbol'=>'FJD',
				'separator'=>'.'
			),
			'GMD'=>array
			(
				'name'=>__('Gambian dalasi','car-wash-booking-system'),
				'symbol'=>'GMD'
			),
			'GEL'=>array
			(
				'name'=>__('Georgian lari','car-wash-booking-system'),
				'symbol'=>'GEL'
			),
			'GHS'=>array
			(
				'name'=>__('Ghanaian cedi','car-wash-booking-system'),
				'symbol'=>'GHS'
			),
			'GIP'=>array
			(
				'name'=>__('Gibraltar pound','car-wash-booking-system'),
				'symbol'=>'GIP'
			),
			'GTQ'=>array
			(
				'name'=>__('Guatemalan quetzal','car-wash-booking-system'),
				'symbol'=>'GTQ',
				'separator'=>'.'
			),
			'GNF'=>array
			(
				'name'=>__('Guinean franc','car-wash-booking-system'),
				'symbol'=>'GNF'
			),
			'GYD'=>array
			(
				'name'=>__('Guyanese dollar','car-wash-booking-system'),
				'symbol'=>'GYD'
			),
			'HTG'=>array
			(
				'name'=>__('Haitian gourde','car-wash-booking-system'),
				'symbol'=>'HTG'
			),
			'HNL'=>array
			(
				'name'=>__('Honduran lempira','car-wash-booking-system'),
				'symbol'=>'HNL',
				'separator'=>'.'
			),
			'HKD'=>array
			(
				'name'=>__('Hong Kong dollar','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'HUF'=>array
			(
				'name'=>__('Hungarian forint','car-wash-booking-system'),
				'symbol'=>'&#70;&#116;'
			),
			'ISK'=>array
			(
				'name'=>__('Icelandic krona','car-wash-booking-system'),
				'symbol'=>'ISK'
			),
			'INR'=>array
			(
				'name'=>__('Indian rupee','car-wash-booking-system'),
				'symbol'=>'&#8377;',
				'separator'=>'.'
			),
			'IDR'=>array
			(
				'name'=>__('Indonesian rupiah','car-wash-booking-system'),
				'symbol'=>'Rp',
				'position'=>'left'
			),
			'IRR'=>array
			(
				'name'=>__('Iranian rial','car-wash-booking-system'),
				'symbol'=>'IRR',
				'separator'=>'&#1643;'
			),
			'IQD'=>array
			(
				'name'=>__('Iraqi dinar','car-wash-booking-system'),
				'symbol'=>'IQD',
				'separator'=>'&#1643;'
			),
			'ILS'=>array
			(
				'name'=>__('Israeli new sheqel','car-wash-booking-system'),
				'symbol'=>'&#8362;',
				'separator'=>'.'
			),
			'YER'=>array
			(
				'name'=>__('Yemeni rial','car-wash-booking-system'),
				'symbol'=>'YER'
			),
			'JMD'=>array
			(
				'name'=>__('Jamaican dollar','car-wash-booking-system'),
				'symbol'=>'JMD'
			),
			'JPY'=>array
			(
				'name'=>__('Japanese yen','car-wash-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			),
			'JOD'=>array
			(
				'name'=>__('Jordanian dinar','car-wash-booking-system'),
				'symbol'=>'JOD'
			),
			'KZT'=>array
			(
				'name'=>__('Kazakhstani tenge','car-wash-booking-system'),
				'symbol'=>'KZT'
			),
			'KES'=>array
			(
				'name'=>__('Kenyan shilling','car-wash-booking-system'),
				'symbol'=>'KES'
			),
			'KGS'=>array
			(
				'name'=>__('Kyrgyzstani som','car-wash-booking-system'),
				'symbol'=>'KGS'
			),
			'KWD'=>array
			(
				'name'=>__('Kuwaiti dinar','car-wash-booking-system'),
				'symbol'=>'KWD',
				'separator'=>'&#1643;'
			),
			'LAK'=>array
			(
				'name'=>__('Lao kip','car-wash-booking-system'),
				'symbol'=>'LAK'
			),
			'LVL'=>array
			(
				'name'=>__('Latvian lats','car-wash-booking-system'),
				'symbol'=>'LVL'
			),
			'LBP'=>array
			(
				'name'=>__('Lebanese lira','car-wash-booking-system'),
				'symbol'=>'LBP'
			),
			'LSL'=>array
			(
				'name'=>__('Lesotho loti','car-wash-booking-system'),
				'symbol'=>'LSL'
			),
			'LRD'=>array
			(
				'name'=>__('Liberian dollar','car-wash-booking-system'),
				'symbol'=>'LRD'
			),
			'LYD'=>array
			(
				'name'=>__('Libyan dinar','car-wash-booking-system'),
				'symbol'=>'LYD'
			),
			'LTL'=>array
			(
				'name'=>__('Lithuanian litas','car-wash-booking-system'),
				'symbol'=>'LTL'
			),
			'MOP'=>array
			(
				'name'=>__('Macanese pataca','car-wash-booking-system'),
				'symbol'=>'MOP'
			),
			'MKD'=>array
			(
				'name'=>__('Macedonian denar','car-wash-booking-system'),
				'symbol'=>'MKD'
			),
			'MGA'=>array
			(
				'name'=>__('Malagasy ariary','car-wash-booking-system'),
				'symbol'=>'MGA'
			),
			'MYR'=>array
			(
				'name'=>__('Malaysian ringgit','car-wash-booking-system'),
				'symbol'=>'&#82;&#77;',
				'separator'=>'.'
			),
			'MWK'=>array
			(
				'name'=>__('Malawian kwacha','car-wash-booking-system'),
				'symbol'=>'MWK'
			),
			'MVR'=>array
			(
				'name'=>__('Maldivian rufiyaa','car-wash-booking-system'),
				'symbol'=>'MVR'
			),
			'MRO'=>array
			(
				'name'=>__('Mauritanian ouguiya','car-wash-booking-system'),
				'symbol'=>'MRO'
			),
			'MUR'=>array
			(
				'name'=>__('Mauritian rupee','car-wash-booking-system'),
				'symbol'=>'MUR'
			),
			'MXN'=>array
			(
				'name'=>__('Mexican peso','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'MMK'=>array
			(
				'name'=>__('Myanma kyat','car-wash-booking-system'),
				'symbol'=>'MMK'
			),
			'MDL'=>array
			(
				'name'=>__('Moldovan leu','car-wash-booking-system'),
				'symbol'=>'MDL'
			),
			'MNT'=>array
			(
				'name'=>__('Mongolian tugrik','car-wash-booking-system'),
				'symbol'=>'MNT'
			),
			'MAD'=>array
			(
				'name'=>__('Moroccan dirham','car-wash-booking-system'),
				'symbol'=>'MAD'
			),
			'MZM'=>array
			(
				'name'=>__('Mozambican metical','car-wash-booking-system'),
				'symbol'=>'MZM'
			),
			'NAD'=>array
			(
				'name'=>__('Namibian dollar','car-wash-booking-system'),
				'symbol'=>'NAD'
			),
			'NPR'=>array
			(
				'name'=>__('Nepalese rupee','car-wash-booking-system'),
				'symbol'=>'NPR'
			),
			'ANG'=>array
			(
				'name'=>__('Netherlands Antillean gulden','car-wash-booking-system'),
				'symbol'=>'ANG'
			),
			'TWD'=>array
			(
				'name'=>__('New Taiwan dollar','car-wash-booking-system'),
				'symbol'=>'&#78;&#84;&#36;',
				'separator'=>'.'
			),
			'NZD'=>array
			(
				'name'=>__('New Zealand dollar','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'NIO'=>array
			(
				'name'=>__('Nicaraguan cordoba','car-wash-booking-system'),
				'symbol'=>'NIO',
				'separator'=>'.'
			),
			'NGN'=>array
			(
				'name'=>__('Nigerian naira','car-wash-booking-system'),
				'symbol'=>'NGN',
				'separator'=>'.'
			),
			'KPW'=>array
			(
				'name'=>__('North Korean won','car-wash-booking-system'),
				'symbol'=>'KPW',
				'separator'=>'.'
			),
			'NOK'=>array
			(
				'name'=>__('Norwegian krone','car-wash-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'OMR'=>array
			(
				'name'=>__('Omani rial','car-wash-booking-system'),
				'symbol'=>'OMR',
				'separator'=>'&#1643;'
			),
			'TOP'=>array
			(
				'name'=>__('Paanga','car-wash-booking-system'),
				'symbol'=>'TOP'
			),
			'PKR'=>array
			(
				'name'=>__('Pakistani rupee','car-wash-booking-system'),
				'symbol'=>'PKR',
				'separator'=>'.'
			),
			'PAB'=>array
			(
				'name'=>__('Panamanian balboa','car-wash-booking-system'),
				'symbol'=>'PAB',
				'separator'=>'.'
			),
			'PGK'=>array
			(
				'name'=>__('Papua New Guinean kina','car-wash-booking-system'),
				'symbol'=>'PGK'
			),
			'PYG'=>array
			(
				'name'=>__('Paraguayan guarani','car-wash-booking-system'),
				'symbol'=>'PYG'
			),
			'PEN'=>array
			(
				'name'=>__('Peruvian nuevo sol','car-wash-booking-system'),
				'symbol'=>'PEN'
			),
			'PHP'=>array
			(
				'name'=>__('Philippine peso','car-wash-booking-system'),
				'symbol'=>'&#8369;'
			),
			'PLN'=>array
			(
				'name'=>__('Polish zloty','car-wash-booking-system'),
				'symbol'=>'&#122;&#322;'
			),
			'QAR'=>array
			(
				'name'=>__('Qatari riyal','car-wash-booking-system'),
				'symbol'=>'QAR',
				'separator'=>'&#1643;'
			),
			'RON'=>array
			(
				'name'=>__('Romanian leu','car-wash-booking-system'),
				'symbol'=>'lei'
			),
			'RUB'=>array
			(
				'name'=>__('Russian ruble','car-wash-booking-system'),
				'symbol'=>'RUB'
			),
			'RWF'=>array
			(
				'name'=>__('Rwandan franc','car-wash-booking-system'),
				'symbol'=>'RWF'
			),
			'SHP'=>array
			(
				'name'=>__('Saint Helena pound','car-wash-booking-system'),
				'symbol'=>'SHP'
			),
			'WST'=>array
			(
				'name'=>__('Samoan tala','car-wash-booking-system'),
				'symbol'=>'WST'
			),
			'STD'=>array
			(
				'name'=>__('Sao Tome and Principe dobra','car-wash-booking-system'),
				'symbol'=>'STD'
			),
			'SAR'=>array
			(
				'name'=>__('Saudi riyal','car-wash-booking-system'),
				'symbol'=>'SAR',
				'separator'=>'&#1643;'
			),
			'SCR'=>array
			(
				'name'=>__('Seychellois rupee','car-wash-booking-system'),
				'symbol'=>'SCR'
			),
			'RSD'=>array
			(
				'name'=>__('Serbian dinar','car-wash-booking-system'),
				'symbol'=>'RSD'
			),
			'SLL'=>array
			(
				'name'=>__('Sierra Leonean leone','car-wash-booking-system'),
				'symbol'=>'SLL'
			),
			'SGD'=>array
			(
				'name'=>__('Singapore dollar','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'separator'=>'.'
			),
			'SYP'=>array
			(
				'name'=>__('Syrian pound','car-wash-booking-system'),
				'symbol'=>'SYP',
				'separator'=>'&#1643;'
			),
			'SKK'=>array
			(
				'name'=>__('Slovak koruna','car-wash-booking-system'),
				'symbol'=>'SKK'
			),
			'SBD'=>array
			(
				'name'=>__('Solomon Islands dollar','car-wash-booking-system'),
				'symbol'=>'SBD'
			),
			'SOS'=>array
			(
				'name'=>__('Somali shilling','car-wash-booking-system'),
				'symbol'=>'SOS'
			),
			'ZAR'=>array
			(
				'name'=>__('South African rand','car-wash-booking-system'),
				'symbol'=>'&#82;'
			),
			'KRW'=>array
			(
				'name'=>__('South Korean won','car-wash-booking-system'),
				'symbol'=>'&#8361;',
				'separator'=>'.'
			),
			'XDR'=>array
			(
				'name'=>__('Special Drawing Rights','car-wash-booking-system'),
				'symbol'=>'XDR'
			),
			'LKR'=>array
			(
				'name'=>__('Sri Lankan rupee','car-wash-booking-system'),
				'symbol'=>'LKR',
				'separator'=>'.'
			),
			'SDG'=>array
			(
				'name'=>__('Sudanese pound','car-wash-booking-system'),
				'symbol'=>'SDG'
			),
			'SRD'=>array
			(
				'name'=>__('Surinamese dollar','car-wash-booking-system'),
				'symbol'=>'SRD'
			),
			'SZL'=>array
			(
				'name'=>__('Swazi lilangeni','car-wash-booking-system'),
				'symbol'=>'SZL'
			),
			'SEK'=>array
			(
				'name'=>__('Swedish krona','car-wash-booking-system'),
				'symbol'=>'&#107;&#114;'
			),
			'CHF'=>array
			(
				'name'=>__('Swiss franc','car-wash-booking-system'),
				'symbol'=>'&#67;&#72;&#70;',
				'separator'=>'.'
			),
			'TJS'=>array
			(
				'name'=>__('Tajikistani somoni','car-wash-booking-system'),
				'symbol'=>'TJS'
			),
			'TZS'=>array
			(
				'name'=>__('Tanzanian shilling','car-wash-booking-system'),
				'symbol'=>'TZS'
			),
			'THB'=>array
			(
				'name'=>__('Thai baht','car-wash-booking-system'),
				'symbol'=>'&#3647;'
			),
			'TTD'=>array
			(
				'name'=>__('Trinidad and Tobago dollar','car-wash-booking-system'),
				'symbol'=>'TTD'
			),
			'TND'=>array
			(
				'name'=>__('Tunisian dinar','car-wash-booking-system'),
				'symbol'=>'TND'
			),
			'TRY'=>array
			(
				'name'=>__('Turkish new lira','car-wash-booking-system'),
				'symbol'=>'&#84;&#76;'
			),
			'TMM'=>array
			(
				'name'=>__('Turkmen manat','car-wash-booking-system'),
				'symbol'=>'TMM'
			),
			'AED'=>array
			(
				'name'=>__('UAE dirham','car-wash-booking-system'),
				'symbol'=>'AED'
			),
			'UGX'=>array
			(
				'name'=>__('Ugandan shilling','car-wash-booking-system'),
				'symbol'=>'UGX'
			),
			'UAH'=>array
			(
				'name'=>__('Ukrainian hryvnia','car-wash-booking-system'),
				'symbol'=>'UAH'
			),
			'USD'=>array
			(
				'name'=>__('United States dollar','car-wash-booking-system'),
				'symbol'=>'&#36;',
				'position'=>'left',
				'separator'=>'.'
			),
			'UYU'=>array
			(
				'name'=>__('Uruguayan peso','car-wash-booking-system'),
				'symbol'=>'UYU'
			),
			'UZS'=>array
			(
				'name'=>__('Uzbekistani som','car-wash-booking-system'),
				'symbol'=>'UZS'
			),
			'VUV'=>array
			(
				'name'=>__('Vanuatu vatu','car-wash-booking-system'),
				'symbol'=>'VUV'
			),
			'VEF'=>array
			(
				'name'=>__('Venezuelan bolivar','car-wash-booking-system'),
				'symbol'=>'VEF'
			),
			'VND'=>array
			(
				'name'=>__('Vietnamese dong','car-wash-booking-system'),
				'symbol'=>'VND'
			),
			'XOF'=>array
			(
				'name'=>__('West African CFA franc','car-wash-booking-system'),
				'symbol'=>'XOF'
			),
			'ZMK'=>array
			(
				'name'=>__('Zambian kwacha','car-wash-booking-system'),
				'symbol'=>'ZMK'
			),
			'ZWD'=>array
			(
				'name'=>__('Zimbabwean dollar','car-wash-booking-system'),
				'symbol'=>'ZWD'
			),
			'RMB'=>array
			(
				'name'=>__('Chinese Yuan','car-wash-booking-system'),
				'symbol'=>'&yen;',
				'separator'=>'.'
			)
		);
	}
	
	/**************************************************************************/
	
	function getCurrency()
	{
		return($this->currency);
	}
	
	/**************************************************************************/
	
	function getSymbol($currency)
	{
		return($this->currency[$currency]['symbol']);
	}
	
	/**************************************************************************/
	
	function getSymbolPosition($currency)
	{
		return(isset($this->currency[$currency]['position']) ? $this->currency[$currency]['position'] : 'right');
	}
	
	/**************************************************************************/
	
	function getSeparator($currency)
	{
		return(isset($this->currency[$currency]['separator']) ? $this->currency[$currency]['separator'] : ',');
	}
	
	/**************************************************************************/
}

/******************************************************************************/
/******************************************************************************/