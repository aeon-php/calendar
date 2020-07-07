<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\TimeUnit;

/**
 * @psalm-immutable
 */
final class TimeZone
{
    public const AFRICA_ABIDJAN = 'Africa/Abidjan';

    public const AFRICA_ACCRA = 'Africa/Accra';

    public const AFRICA_ADDIS_ABABA = 'Africa/Addis_Ababa';

    public const AFRICA_ALGIERS = 'Africa/Algiers';

    public const AFRICA_ASMARA = 'Africa/Asmara';

    public const AFRICA_BAMAKO = 'Africa/Bamako';

    public const AFRICA_BANGUI = 'Africa/Bangui';

    public const AFRICA_BANJUL = 'Africa/Banjul';

    public const AFRICA_BISSAU = 'Africa/Bissau';

    public const AFRICA_BLANTYRE = 'Africa/Blantyre';

    public const AFRICA_BRAZZAVILLE = 'Africa/Brazzaville';

    public const AFRICA_BUJUMBURA = 'Africa/Bujumbura';

    public const AFRICA_CAIRO = 'Africa/Cairo';

    public const AFRICA_CASABLANCA = 'Africa/Casablanca';

    public const AFRICA_CEUTA = 'Africa/Ceuta';

    public const AFRICA_CONAKRY = 'Africa/Conakry';

    public const AFRICA_DAKAR = 'Africa/Dakar';

    public const AFRICA_DAR_ES_SALAAM = 'Africa/Dar_es_Salaam';

    public const AFRICA_DJIBOUTI = 'Africa/Djibouti';

    public const AFRICA_DOUALA = 'Africa/Douala';

    public const AFRICA_EL_AAIUN = 'Africa/El_Aaiun';

    public const AFRICA_FREETOWN = 'Africa/Freetown';

    public const AFRICA_GABORONE = 'Africa/Gaborone';

    public const AFRICA_HARARE = 'Africa/Harare';

    public const AFRICA_JOHANNESBURG = 'Africa/Johannesburg';

    public const AFRICA_JUBA = 'Africa/Juba';

    public const AFRICA_KAMPALA = 'Africa/Kampala';

    public const AFRICA_KHARTOUM = 'Africa/Khartoum';

    public const AFRICA_KIGALI = 'Africa/Kigali';

    public const AFRICA_KINSHASA = 'Africa/Kinshasa';

    public const AFRICA_LAGOS = 'Africa/Lagos';

    public const AFRICA_LIBREVILLE = 'Africa/Libreville';

    public const AFRICA_LOME = 'Africa/Lome';

    public const AFRICA_LUANDA = 'Africa/Luanda';

    public const AFRICA_LUBUMBASHI = 'Africa/Lubumbashi';

    public const AFRICA_LUSAKA = 'Africa/Lusaka';

    public const AFRICA_MALABO = 'Africa/Malabo';

    public const AFRICA_MAPUTO = 'Africa/Maputo';

    public const AFRICA_MASERU = 'Africa/Maseru';

    public const AFRICA_MBABANE = 'Africa/Mbabane';

    public const AFRICA_MOGADISHU = 'Africa/Mogadishu';

    public const AFRICA_MONROVIA = 'Africa/Monrovia';

    public const AFRICA_NAIROBI = 'Africa/Nairobi';

    public const AFRICA_NDJAMENA = 'Africa/Ndjamena';

    public const AFRICA_NIAMEY = 'Africa/Niamey';

    public const AFRICA_NOUAKCHOTT = 'Africa/Nouakchott';

    public const AFRICA_OUAGADOUGOU = 'Africa/Ouagadougou';

    public const AFRICA_PORTO_NOVO = 'Africa/Porto-Novo';

    public const AFRICA_SAO_TOME = 'Africa/Sao_Tome';

    public const AFRICA_TRIPOLI = 'Africa/Tripoli';

    public const AFRICA_TUNIS = 'Africa/Tunis';

    public const AFRICA_WINDHOEK = 'Africa/Windhoek';

    public const AMERICA_ADAK = 'America/Adak';

    public const AMERICA_ANCHORAGE = 'America/Anchorage';

    public const AMERICA_ANGUILLA = 'America/Anguilla';

    public const AMERICA_ANTIGUA = 'America/Antigua';

    public const AMERICA_ARAGUAINA = 'America/Araguaina';

    public const AMERICA_ARGENTINA_BUENOS_AIRES = 'America/Argentina/Buenos_Aires';

    public const AMERICA_ARGENTINA_CATAMARCA = 'America/Argentina/Catamarca';

    public const AMERICA_ARGENTINA_CORDOBA = 'America/Argentina/Cordoba';

    public const AMERICA_ARGENTINA_JUJUY = 'America/Argentina/Jujuy';

    public const AMERICA_ARGENTINA_LA_RIOJA = 'America/Argentina/La_Rioja';

    public const AMERICA_ARGENTINA_MENDOZA = 'America/Argentina/Mendoza';

    public const AMERICA_ARGENTINA_RIO_GALLEGOS = 'America/Argentina/Rio_Gallegos';

    public const AMERICA_ARGENTINA_SALTA = 'America/Argentina/Salta';

    public const AMERICA_ARGENTINA_SAN_JUAN = 'America/Argentina/San_Juan';

    public const AMERICA_ARGENTINA_SAN_LUIS = 'America/Argentina/San_Luis';

    public const AMERICA_ARGENTINA_TUCUMAN = 'America/Argentina/Tucuman';

    public const AMERICA_ARGENTINA_USHUAIA = 'America/Argentina/Ushuaia';

    public const AMERICA_ARUBA = 'America/Aruba';

    public const AMERICA_ASUNCION = 'America/Asuncion';

    public const AMERICA_ATIKOKAN = 'America/Atikokan';

    public const AMERICA_BAHIA = 'America/Bahia';

    public const AMERICA_BAHIA_BANDERAS = 'America/Bahia_Banderas';

    public const AMERICA_BARBADOS = 'America/Barbados';

    public const AMERICA_BELEM = 'America/Belem';

    public const AMERICA_BELIZE = 'America/Belize';

    public const AMERICA_BLANC_SABLON = 'America/Blanc-Sablon';

    public const AMERICA_BOA_VISTA = 'America/Boa_Vista';

    public const AMERICA_BOGOTA = 'America/Bogota';

    public const AMERICA_BOISE = 'America/Boise';

    public const AMERICA_CAMBRIDGE_BAY = 'America/Cambridge_Bay';

    public const AMERICA_CAMPO_GRANDE = 'America/Campo_Grande';

    public const AMERICA_CANCUN = 'America/Cancun';

    public const AMERICA_CARACAS = 'America/Caracas';

    public const AMERICA_CAYENNE = 'America/Cayenne';

    public const AMERICA_CAYMAN = 'America/Cayman';

    public const AMERICA_CHICAGO = 'America/Chicago';

    public const AMERICA_CHIHUAHUA = 'America/Chihuahua';

    public const AMERICA_COSTA_RICA = 'America/Costa_Rica';

    public const AMERICA_CRESTON = 'America/Creston';

    public const AMERICA_CUIABA = 'America/Cuiaba';

    public const AMERICA_CURACAO = 'America/Curacao';

    public const AMERICA_DANMARKSHAVN = 'America/Danmarkshavn';

    public const AMERICA_DAWSON = 'America/Dawson';

    public const AMERICA_DAWSON_CREEK = 'America/Dawson_Creek';

    public const AMERICA_DENVER = 'America/Denver';

    public const AMERICA_DETROIT = 'America/Detroit';

    public const AMERICA_DOMINICA = 'America/Dominica';

    public const AMERICA_EDMONTON = 'America/Edmonton';

    public const AMERICA_EIRUNEPE = 'America/Eirunepe';

    public const AMERICA_EL_SALVADOR = 'America/El_Salvador';

    public const AMERICA_FORT_NELSON = 'America/Fort_Nelson';

    public const AMERICA_FORTALEZA = 'America/Fortaleza';

    public const AMERICA_GLACE_BAY = 'America/Glace_Bay';

    public const AMERICA_GOOSE_BAY = 'America/Goose_Bay';

    public const AMERICA_GODTHAB = 'America/Godthab';

    public const AMERICA_GRAND_TURK = 'America/Grand_Turk';

    public const AMERICA_GRENADA = 'America/Grenada';

    public const AMERICA_GUADELOUPE = 'America/Guadeloupe';

    public const AMERICA_GUATEMALA = 'America/Guatemala';

    public const AMERICA_GUAYAQUIL = 'America/Guayaquil';

    public const AMERICA_GUYANA = 'America/Guyana';

    public const AMERICA_HALIFAX = 'America/Halifax';

    public const AMERICA_HAVANA = 'America/Havana';

    public const AMERICA_HERMOSILLO = 'America/Hermosillo';

    public const AMERICA_INDIANA_INDIANAPOLIS = 'America/Indiana/Indianapolis';

    public const AMERICA_INDIANA_KNOX = 'America/Indiana/Knox';

    public const AMERICA_INDIANA_MARENGO = 'America/Indiana/Marengo';

    public const AMERICA_INDIANA_PETERSBURG = 'America/Indiana/Petersburg';

    public const AMERICA_INDIANA_TELL_CITY = 'America/Indiana/Tell_City';

    public const AMERICA_INDIANA_VEVAY = 'America/Indiana/Vevay';

    public const AMERICA_INDIANA_VINCENNES = 'America/Indiana/Vincennes';

    public const AMERICA_INDIANA_WINAMAC = 'America/Indiana/Winamac';

    public const AMERICA_INUVIK = 'America/Inuvik';

    public const AMERICA_IQALUIT = 'America/Iqaluit';

    public const AMERICA_JAMAICA = 'America/Jamaica';

    public const AMERICA_JUNEAU = 'America/Juneau';

    public const AMERICA_KENTUCKY_LOUISVILLE = 'America/Kentucky/Louisville';

    public const AMERICA_KENTUCKY_MONTICELLO = 'America/Kentucky/Monticello';

    public const AMERICA_KRALENDIJK = 'America/Kralendijk';

    public const AMERICA_LA_PAZ = 'America/La_Paz';

    public const AMERICA_LIMA = 'America/Lima';

    public const AMERICA_LOS_ANGELES = 'America/Los_Angeles';

    public const AMERICA_LOWER_PRINCES = 'America/Lower_Princes';

    public const AMERICA_MACEIO = 'America/Maceio';

    public const AMERICA_MANAGUA = 'America/Managua';

    public const AMERICA_MANAUS = 'America/Manaus';

    public const AMERICA_MARIGOT = 'America/Marigot';

    public const AMERICA_MARTINIQUE = 'America/Martinique';

    public const AMERICA_MATAMOROS = 'America/Matamoros';

    public const AMERICA_MAZATLAN = 'America/Mazatlan';

    public const AMERICA_MENOMINEE = 'America/Menominee';

    public const AMERICA_MERIDA = 'America/Merida';

    public const AMERICA_METLAKATLA = 'America/Metlakatla';

    public const AMERICA_MEXICO_CITY = 'America/Mexico_City';

    public const AMERICA_MIQUELON = 'America/Miquelon';

    public const AMERICA_MONCTON = 'America/Moncton';

    public const AMERICA_MONTERREY = 'America/Monterrey';

    public const AMERICA_MONTEVIDEO = 'America/Montevideo';

    public const AMERICA_MONTSERRAT = 'America/Montserrat';

    public const AMERICA_NASSAU = 'America/Nassau';

    public const AMERICA_NEW_YORK = 'America/New_York';

    public const AMERICA_NIPIGON = 'America/Nipigon';

    public const AMERICA_NOME = 'America/Nome';

    public const AMERICA_NORONHA = 'America/Noronha';

    public const AMERICA_NORTH_DAKOTA_BEULAH = 'America/North_Dakota/Beulah';

    public const AMERICA_NORTH_DAKOTA_CENTER = 'America/North_Dakota/Center';

    public const AMERICA_NORTH_DAKOTA_NEW_SALEM = 'America/North_Dakota/New_Salem';

    public const AMERICA_NUUK = 'America/Nuuk';

    public const AMERICA_OJINAGA = 'America/Ojinaga';

    public const AMERICA_PANAMA = 'America/Panama';

    public const AMERICA_PANGNIRTUNG = 'America/Pangnirtung';

    public const AMERICA_PARAMARIBO = 'America/Paramaribo';

    public const AMERICA_PHOENIX = 'America/Phoenix';

    public const AMERICA_PORT_AU_PRINCE = 'America/Port-au-Prince';

    public const AMERICA_PORT_OF_SPAIN = 'America/Port_of_Spain';

    public const AMERICA_PORTO_VELHO = 'America/Porto_Velho';

    public const AMERICA_PUERTO_RICO = 'America/Puerto_Rico';

    public const AMERICA_PUNTA_ARENAS = 'America/Punta_Arenas';

    public const AMERICA_RAINY_RIVER = 'America/Rainy_River';

    public const AMERICA_RANKIN_INLET = 'America/Rankin_Inlet';

    public const AMERICA_RECIFE = 'America/Recife';

    public const AMERICA_REGINA = 'America/Regina';

    public const AMERICA_RESOLUTE = 'America/Resolute';

    public const AMERICA_RIO_BRANCO = 'America/Rio_Branco';

    public const AMERICA_SANTAREM = 'America/Santarem';

    public const AMERICA_SANTIAGO = 'America/Santiago';

    public const AMERICA_SANTO_DOMINGO = 'America/Santo_Domingo';

    public const AMERICA_SAO_PAULO = 'America/Sao_Paulo';

    public const AMERICA_SCORESBYSUND = 'America/Scoresbysund';

    public const AMERICA_SITKA = 'America/Sitka';

    public const AMERICA_ST_BARTHELEMY = 'America/St_Barthelemy';

    public const AMERICA_ST_JOHNS = 'America/St_Johns';

    public const AMERICA_ST_KITTS = 'America/St_Kitts';

    public const AMERICA_ST_LUCIA = 'America/St_Lucia';

    public const AMERICA_ST_THOMAS = 'America/St_Thomas';

    public const AMERICA_ST_VINCENT = 'America/St_Vincent';

    public const AMERICA_SWIFT_CURRENT = 'America/Swift_Current';

    public const AMERICA_TEGUCIGALPA = 'America/Tegucigalpa';

    public const AMERICA_THULE = 'America/Thule';

    public const AMERICA_THUNDER_BAY = 'America/Thunder_Bay';

    public const AMERICA_TIJUANA = 'America/Tijuana';

    public const AMERICA_TORONTO = 'America/Toronto';

    public const AMERICA_TORTOLA = 'America/Tortola';

    public const AMERICA_VANCOUVER = 'America/Vancouver';

    public const AMERICA_WHITEHORSE = 'America/Whitehorse';

    public const AMERICA_WINNIPEG = 'America/Winnipeg';

    public const AMERICA_YAKUTAT = 'America/Yakutat';

    public const AMERICA_YELLOWKNIFE = 'America/Yellowknife';

    public const ANTARCTICA_CASEY = 'Antarctica/Casey';

    public const ANTARCTICA_DAVIS = 'Antarctica/Davis';

    public const ANTARCTICA_DUMONTDURVILLE = 'Antarctica/DumontDUrville';

    public const ANTARCTICA_MACQUARIE = 'Antarctica/Macquarie';

    public const ANTARCTICA_MAWSON = 'Antarctica/Mawson';

    public const ANTARCTICA_MCMURDO = 'Antarctica/McMurdo';

    public const ANTARCTICA_PALMER = 'Antarctica/Palmer';

    public const ANTARCTICA_ROTHERA = 'Antarctica/Rothera';

    public const ANTARCTICA_SYOWA = 'Antarctica/Syowa';

    public const ANTARCTICA_TROLL = 'Antarctica/Troll';

    public const ANTARCTICA_VOSTOK = 'Antarctica/Vostok';

    public const ARCTIC_LONGYEARBYEN = 'Arctic/Longyearbyen';

    public const ASIA_ADEN = 'Asia/Aden';

    public const ASIA_ALMATY = 'Asia/Almaty';

    public const ASIA_AMMAN = 'Asia/Amman';

    public const ASIA_ANADYR = 'Asia/Anadyr';

    public const ASIA_AQTAU = 'Asia/Aqtau';

    public const ASIA_AQTOBE = 'Asia/Aqtobe';

    public const ASIA_ASHGABAT = 'Asia/Ashgabat';

    public const ASIA_ATYRAU = 'Asia/Atyrau';

    public const ASIA_BAGHDAD = 'Asia/Baghdad';

    public const ASIA_BAHRAIN = 'Asia/Bahrain';

    public const ASIA_BAKU = 'Asia/Baku';

    public const ASIA_BANGKOK = 'Asia/Bangkok';

    public const ASIA_BARNAUL = 'Asia/Barnaul';

    public const ASIA_BEIRUT = 'Asia/Beirut';

    public const ASIA_BISHKEK = 'Asia/Bishkek';

    public const ASIA_BRUNEI = 'Asia/Brunei';

    public const ASIA_CHITA = 'Asia/Chita';

    public const ASIA_CHOIBALSAN = 'Asia/Choibalsan';

    public const ASIA_COLOMBO = 'Asia/Colombo';

    public const ASIA_DAMASCUS = 'Asia/Damascus';

    public const ASIA_DHAKA = 'Asia/Dhaka';

    public const ASIA_DILI = 'Asia/Dili';

    public const ASIA_DUBAI = 'Asia/Dubai';

    public const ASIA_DUSHANBE = 'Asia/Dushanbe';

    public const ASIA_FAMAGUSTA = 'Asia/Famagusta';

    public const ASIA_GAZA = 'Asia/Gaza';

    public const ASIA_HEBRON = 'Asia/Hebron';

    public const ASIA_HO_CHI_MINH = 'Asia/Ho_Chi_Minh';

    public const ASIA_HONG_KONG = 'Asia/Hong_Kong';

    public const ASIA_HOVD = 'Asia/Hovd';

    public const ASIA_IRKUTSK = 'Asia/Irkutsk';

    public const ASIA_JAKARTA = 'Asia/Jakarta';

    public const ASIA_JAYAPURA = 'Asia/Jayapura';

    public const ASIA_JERUSALEM = 'Asia/Jerusalem';

    public const ASIA_KABUL = 'Asia/Kabul';

    public const ASIA_KAMCHATKA = 'Asia/Kamchatka';

    public const ASIA_KARACHI = 'Asia/Karachi';

    public const ASIA_KATHMANDU = 'Asia/Kathmandu';

    public const ASIA_KHANDYGA = 'Asia/Khandyga';

    public const ASIA_KOLKATA = 'Asia/Kolkata';

    public const ASIA_KRASNOYARSK = 'Asia/Krasnoyarsk';

    public const ASIA_KUALA_LUMPUR = 'Asia/Kuala_Lumpur';

    public const ASIA_KUCHING = 'Asia/Kuching';

    public const ASIA_KUWAIT = 'Asia/Kuwait';

    public const ASIA_MACAU = 'Asia/Macau';

    public const ASIA_MAGADAN = 'Asia/Magadan';

    public const ASIA_MAKASSAR = 'Asia/Makassar';

    public const ASIA_MANILA = 'Asia/Manila';

    public const ASIA_MUSCAT = 'Asia/Muscat';

    public const ASIA_NICOSIA = 'Asia/Nicosia';

    public const ASIA_NOVOKUZNETSK = 'Asia/Novokuznetsk';

    public const ASIA_NOVOSIBIRSK = 'Asia/Novosibirsk';

    public const ASIA_OMSK = 'Asia/Omsk';

    public const ASIA_ORAL = 'Asia/Oral';

    public const ASIA_PHNOM_PENH = 'Asia/Phnom_Penh';

    public const ASIA_PONTIANAK = 'Asia/Pontianak';

    public const ASIA_PYONGYANG = 'Asia/Pyongyang';

    public const ASIA_QATAR = 'Asia/Qatar';

    public const ASIA_QOSTANAY = 'Asia/Qostanay';

    public const ASIA_QYZYLORDA = 'Asia/Qyzylorda';

    public const ASIA_RIYADH = 'Asia/Riyadh';

    public const ASIA_SAKHALIN = 'Asia/Sakhalin';

    public const ASIA_SAMARKAND = 'Asia/Samarkand';

    public const ASIA_SEOUL = 'Asia/Seoul';

    public const ASIA_SHANGHAI = 'Asia/Shanghai';

    public const ASIA_SINGAPORE = 'Asia/Singapore';

    public const ASIA_SREDNEKOLYMSK = 'Asia/Srednekolymsk';

    public const ASIA_TAIPEI = 'Asia/Taipei';

    public const ASIA_TASHKENT = 'Asia/Tashkent';

    public const ASIA_TBILISI = 'Asia/Tbilisi';

    public const ASIA_TEHRAN = 'Asia/Tehran';

    public const ASIA_THIMPHU = 'Asia/Thimphu';

    public const ASIA_TOKYO = 'Asia/Tokyo';

    public const ASIA_TOMSK = 'Asia/Tomsk';

    public const ASIA_ULAANBAATAR = 'Asia/Ulaanbaatar';

    public const ASIA_URUMQI = 'Asia/Urumqi';

    public const ASIA_UST_NERA = 'Asia/Ust-Nera';

    public const ASIA_VIENTIANE = 'Asia/Vientiane';

    public const ASIA_VLADIVOSTOK = 'Asia/Vladivostok';

    public const ASIA_YAKUTSK = 'Asia/Yakutsk';

    public const ASIA_YANGON = 'Asia/Yangon';

    public const ASIA_YEKATERINBURG = 'Asia/Yekaterinburg';

    public const ASIA_YEREVAN = 'Asia/Yerevan';

    public const ATLANTIC_AZORES = 'Atlantic/Azores';

    public const ATLANTIC_BERMUDA = 'Atlantic/Bermuda';

    public const ATLANTIC_CANARY = 'Atlantic/Canary';

    public const ATLANTIC_CAPE_VERDE = 'Atlantic/Cape_Verde';

    public const ATLANTIC_FAROE = 'Atlantic/Faroe';

    public const ATLANTIC_MADEIRA = 'Atlantic/Madeira';

    public const ATLANTIC_REYKJAVIK = 'Atlantic/Reykjavik';

    public const ATLANTIC_SOUTH_GEORGIA = 'Atlantic/South_Georgia';

    public const ATLANTIC_ST_HELENA = 'Atlantic/St_Helena';

    public const ATLANTIC_STANLEY = 'Atlantic/Stanley';

    public const AUSTRALIA_ADELAIDE = 'Australia/Adelaide';

    public const AUSTRALIA_BRISBANE = 'Australia/Brisbane';

    public const AUSTRALIA_BROKEN_HILL = 'Australia/Broken_Hill';

    public const AUSTRALIA_CURRIE = 'Australia/Currie';

    public const AUSTRALIA_DARWIN = 'Australia/Darwin';

    public const AUSTRALIA_EUCLA = 'Australia/Eucla';

    public const AUSTRALIA_HOBART = 'Australia/Hobart';

    public const AUSTRALIA_LINDEMAN = 'Australia/Lindeman';

    public const AUSTRALIA_LORD_HOWE = 'Australia/Lord_Howe';

    public const AUSTRALIA_MELBOURNE = 'Australia/Melbourne';

    public const AUSTRALIA_PERTH = 'Australia/Perth';

    public const AUSTRALIA_SYDNEY = 'Australia/Sydney';

    public const EUROPE_AMSTERDAM = 'Europe/Amsterdam';

    public const EUROPE_ANDORRA = 'Europe/Andorra';

    public const EUROPE_ASTRAKHAN = 'Europe/Astrakhan';

    public const EUROPE_ATHENS = 'Europe/Athens';

    public const EUROPE_BELGRADE = 'Europe/Belgrade';

    public const EUROPE_BERLIN = 'Europe/Berlin';

    public const EUROPE_BRATISLAVA = 'Europe/Bratislava';

    public const EUROPE_BRUSSELS = 'Europe/Brussels';

    public const EUROPE_BUCHAREST = 'Europe/Bucharest';

    public const EUROPE_BUDAPEST = 'Europe/Budapest';

    public const EUROPE_BUSINGEN = 'Europe/Busingen';

    public const EUROPE_CHISINAU = 'Europe/Chisinau';

    public const EUROPE_COPENHAGEN = 'Europe/Copenhagen';

    public const EUROPE_DUBLIN = 'Europe/Dublin';

    public const EUROPE_GIBRALTAR = 'Europe/Gibraltar';

    public const EUROPE_GUERNSEY = 'Europe/Guernsey';

    public const EUROPE_HELSINKI = 'Europe/Helsinki';

    public const EUROPE_ISLE_OF_MAN = 'Europe/Isle_of_Man';

    public const EUROPE_ISTANBUL = 'Europe/Istanbul';

    public const EUROPE_JERSEY = 'Europe/Jersey';

    public const EUROPE_KALININGRAD = 'Europe/Kaliningrad';

    public const EUROPE_KIEV = 'Europe/Kiev';

    public const EUROPE_KIROV = 'Europe/Kirov';

    public const EUROPE_LISBON = 'Europe/Lisbon';

    public const EUROPE_LJUBLJANA = 'Europe/Ljubljana';

    public const EUROPE_LONDON = 'Europe/London';

    public const EUROPE_LUXEMBOURG = 'Europe/Luxembourg';

    public const EUROPE_MADRID = 'Europe/Madrid';

    public const EUROPE_MALTA = 'Europe/Malta';

    public const EUROPE_MARIEHAMN = 'Europe/Mariehamn';

    public const EUROPE_MINSK = 'Europe/Minsk';

    public const EUROPE_MONACO = 'Europe/Monaco';

    public const EUROPE_MOSCOW = 'Europe/Moscow';

    public const EUROPE_OSLO = 'Europe/Oslo';

    public const EUROPE_PARIS = 'Europe/Paris';

    public const EUROPE_PODGORICA = 'Europe/Podgorica';

    public const EUROPE_PRAGUE = 'Europe/Prague';

    public const EUROPE_RIGA = 'Europe/Riga';

    public const EUROPE_ROME = 'Europe/Rome';

    public const EUROPE_SAMARA = 'Europe/Samara';

    public const EUROPE_SAN_MARINO = 'Europe/San_Marino';

    public const EUROPE_SARAJEVO = 'Europe/Sarajevo';

    public const EUROPE_SARATOV = 'Europe/Saratov';

    public const EUROPE_SIMFEROPOL = 'Europe/Simferopol';

    public const EUROPE_SKOPJE = 'Europe/Skopje';

    public const EUROPE_SOFIA = 'Europe/Sofia';

    public const EUROPE_STOCKHOLM = 'Europe/Stockholm';

    public const EUROPE_TALLINN = 'Europe/Tallinn';

    public const EUROPE_TIRANE = 'Europe/Tirane';

    public const EUROPE_ULYANOVSK = 'Europe/Ulyanovsk';

    public const EUROPE_UZHGOROD = 'Europe/Uzhgorod';

    public const EUROPE_VADUZ = 'Europe/Vaduz';

    public const EUROPE_VATICAN = 'Europe/Vatican';

    public const EUROPE_VIENNA = 'Europe/Vienna';

    public const EUROPE_VILNIUS = 'Europe/Vilnius';

    public const EUROPE_VOLGOGRAD = 'Europe/Volgograd';

    public const EUROPE_WARSAW = 'Europe/Warsaw';

    public const EUROPE_ZAGREB = 'Europe/Zagreb';

    public const EUROPE_ZAPOROZHYE = 'Europe/Zaporozhye';

    public const EUROPE_ZURICH = 'Europe/Zurich';

    public const INDIAN_ANTANANARIVO = 'Indian/Antananarivo';

    public const INDIAN_CHAGOS = 'Indian/Chagos';

    public const INDIAN_CHRISTMAS = 'Indian/Christmas';

    public const INDIAN_COCOS = 'Indian/Cocos';

    public const INDIAN_COMORO = 'Indian/Comoro';

    public const INDIAN_KERGUELEN = 'Indian/Kerguelen';

    public const INDIAN_MAHE = 'Indian/Mahe';

    public const INDIAN_MALDIVES = 'Indian/Maldives';

    public const INDIAN_MAURITIUS = 'Indian/Mauritius';

    public const INDIAN_MAYOTTE = 'Indian/Mayotte';

    public const INDIAN_REUNION = 'Indian/Reunion';

    public const PACIFIC_APIA = 'Pacific/Apia';

    public const PACIFIC_AUCKLAND = 'Pacific/Auckland';

    public const PACIFIC_BOUGAINVILLE = 'Pacific/Bougainville';

    public const PACIFIC_CHATHAM = 'Pacific/Chatham';

    public const PACIFIC_CHUUK = 'Pacific/Chuuk';

    public const PACIFIC_EASTER = 'Pacific/Easter';

    public const PACIFIC_EFATE = 'Pacific/Efate';

    public const PACIFIC_ENDERBURY = 'Pacific/Enderbury';

    public const PACIFIC_FAKAOFO = 'Pacific/Fakaofo';

    public const PACIFIC_FIJI = 'Pacific/Fiji';

    public const PACIFIC_FUNAFUTI = 'Pacific/Funafuti';

    public const PACIFIC_GALAPAGOS = 'Pacific/Galapagos';

    public const PACIFIC_GAMBIER = 'Pacific/Gambier';

    public const PACIFIC_GUADALCANAL = 'Pacific/Guadalcanal';

    public const PACIFIC_GUAM = 'Pacific/Guam';

    public const PACIFIC_HONOLULU = 'Pacific/Honolulu';

    public const PACIFIC_JOHNSTON = 'Pacific/Johnston';

    public const PACIFIC_KIRITIMATI = 'Pacific/Kiritimati';

    public const PACIFIC_KOSRAE = 'Pacific/Kosrae';

    public const PACIFIC_KWAJALEIN = 'Pacific/Kwajalein';

    public const PACIFIC_MAJURO = 'Pacific/Majuro';

    public const PACIFIC_MARQUESAS = 'Pacific/Marquesas';

    public const PACIFIC_MIDWAY = 'Pacific/Midway';

    public const PACIFIC_NAURU = 'Pacific/Nauru';

    public const PACIFIC_NIUE = 'Pacific/Niue';

    public const PACIFIC_NORFOLK = 'Pacific/Norfolk';

    public const PACIFIC_NOUMEA = 'Pacific/Noumea';

    public const PACIFIC_PAGO_PAGO = 'Pacific/Pago_Pago';

    public const PACIFIC_PALAU = 'Pacific/Palau';

    public const PACIFIC_PITCAIRN = 'Pacific/Pitcairn';

    public const PACIFIC_POHNPEI = 'Pacific/Pohnpei';

    public const PACIFIC_PORT_MORESBY = 'Pacific/Port_Moresby';

    public const PACIFIC_RAROTONGA = 'Pacific/Rarotonga';

    public const PACIFIC_SAIPAN = 'Pacific/Saipan';

    public const PACIFIC_TAHITI = 'Pacific/Tahiti';

    public const PACIFIC_TARAWA = 'Pacific/Tarawa';

    public const PACIFIC_TONGATAPU = 'Pacific/Tongatapu';

    public const PACIFIC_WAKE = 'Pacific/Wake';

    public const PACIFIC_WALLIS = 'Pacific/Wallis';

    public const UTC = 'UTC';

    private string $name;

    public function __construct(string $name)
    {
        if (!\in_array(
            $name,
            \array_merge(
                (array) \DateTimeZone::listIdentifiers(),
                [self::AMERICA_GODTHAB, self::PACIFIC_JOHNSTON]
            ),
            true,
        )) {
            throw new InvalidArgumentException("\"{$name}\" is not a valid timezone.");
        }

        $this->name = $name;
    }

    /**
     * @psalm-pure
     */
    public static function isValid(string $name) : bool
    {
        return \in_array($name, (array) \DateTimeZone::listIdentifiers(), true);
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTimeZone(\DateTimeZone $dateTimeZone) : self
    {
        return new self($dateTimeZone->getName());
    }

    // @codeCoverageIgnoreStart
    public static function africaAbidjan() : self
    {
        return new self(self::AFRICA_ABIDJAN);
    }

    public static function africaAccra() : self
    {
        return new self(self::AFRICA_ACCRA);
    }

    public static function africaAddisAbaba() : self
    {
        return new self(self::AFRICA_ADDIS_ABABA);
    }

    public static function africaAlgiers() : self
    {
        return new self(self::AFRICA_ALGIERS);
    }

    public static function africaAsmara() : self
    {
        return new self(self::AFRICA_ASMARA);
    }

    public static function africaBamako() : self
    {
        return new self(self::AFRICA_BAMAKO);
    }

    public static function africaBangui() : self
    {
        return new self(self::AFRICA_BANGUI);
    }

    public static function africaBanjul() : self
    {
        return new self(self::AFRICA_BANJUL);
    }

    public static function africaBissau() : self
    {
        return new self(self::AFRICA_BISSAU);
    }

    public static function africaBlantyre() : self
    {
        return new self(self::AFRICA_BLANTYRE);
    }

    public static function africaBrazzaville() : self
    {
        return new self(self::AFRICA_BRAZZAVILLE);
    }

    public static function africaBujumbura() : self
    {
        return new self(self::AFRICA_BUJUMBURA);
    }

    public static function africaCairo() : self
    {
        return new self(self::AFRICA_CAIRO);
    }

    public static function africaCasablanca() : self
    {
        return new self(self::AFRICA_CASABLANCA);
    }

    public static function africaCeuta() : self
    {
        return new self(self::AFRICA_CEUTA);
    }

    public static function africaConakry() : self
    {
        return new self(self::AFRICA_CONAKRY);
    }

    public static function africaDakar() : self
    {
        return new self(self::AFRICA_DAKAR);
    }

    public static function africaDarEsSalaam() : self
    {
        return new self(self::AFRICA_DAR_ES_SALAAM);
    }

    public static function africaDjibouti() : self
    {
        return new self(self::AFRICA_DJIBOUTI);
    }

    public static function africaDouala() : self
    {
        return new self(self::AFRICA_DOUALA);
    }

    public static function africaElAaiun() : self
    {
        return new self(self::AFRICA_EL_AAIUN);
    }

    public static function africaFreetown() : self
    {
        return new self(self::AFRICA_FREETOWN);
    }

    public static function africaGaborone() : self
    {
        return new self(self::AFRICA_GABORONE);
    }

    public static function africaHarare() : self
    {
        return new self(self::AFRICA_HARARE);
    }

    public static function africaJohannesburg() : self
    {
        return new self(self::AFRICA_JOHANNESBURG);
    }

    public static function africaJuba() : self
    {
        return new self(self::AFRICA_JUBA);
    }

    public static function africaKampala() : self
    {
        return new self(self::AFRICA_KAMPALA);
    }

    public static function africaKhartoum() : self
    {
        return new self(self::AFRICA_KHARTOUM);
    }

    public static function africaKigali() : self
    {
        return new self(self::AFRICA_KIGALI);
    }

    public static function africaKinshasa() : self
    {
        return new self(self::AFRICA_KINSHASA);
    }

    public static function africaLagos() : self
    {
        return new self(self::AFRICA_LAGOS);
    }

    public static function africaLibreville() : self
    {
        return new self(self::AFRICA_LIBREVILLE);
    }

    public static function africaLome() : self
    {
        return new self(self::AFRICA_LOME);
    }

    public static function africaLuanda() : self
    {
        return new self(self::AFRICA_LUANDA);
    }

    public static function africaLubumbashi() : self
    {
        return new self(self::AFRICA_LUBUMBASHI);
    }

    public static function africaLusaka() : self
    {
        return new self(self::AFRICA_LUSAKA);
    }

    public static function africaMalabo() : self
    {
        return new self(self::AFRICA_MALABO);
    }

    public static function africaMaputo() : self
    {
        return new self(self::AFRICA_MAPUTO);
    }

    public static function africaMaseru() : self
    {
        return new self(self::AFRICA_MASERU);
    }

    public static function africaMbabane() : self
    {
        return new self(self::AFRICA_MBABANE);
    }

    public static function africaMogadishu() : self
    {
        return new self(self::AFRICA_MOGADISHU);
    }

    public static function africaMonrovia() : self
    {
        return new self(self::AFRICA_MONROVIA);
    }

    public static function africaNairobi() : self
    {
        return new self(self::AFRICA_NAIROBI);
    }

    public static function africaNdjamena() : self
    {
        return new self(self::AFRICA_NDJAMENA);
    }

    public static function africaNiamey() : self
    {
        return new self(self::AFRICA_NIAMEY);
    }

    public static function africaNouakchott() : self
    {
        return new self(self::AFRICA_NOUAKCHOTT);
    }

    public static function africaOuagadougou() : self
    {
        return new self(self::AFRICA_OUAGADOUGOU);
    }

    public static function africaPortoNovo() : self
    {
        return new self(self::AFRICA_PORTO_NOVO);
    }

    public static function africaSaoTome() : self
    {
        return new self(self::AFRICA_SAO_TOME);
    }

    public static function africaTripoli() : self
    {
        return new self(self::AFRICA_TRIPOLI);
    }

    public static function africaTunis() : self
    {
        return new self(self::AFRICA_TUNIS);
    }

    public static function africaWindhoek() : self
    {
        return new self(self::AFRICA_WINDHOEK);
    }

    public static function americaAdak() : self
    {
        return new self(self::AMERICA_ADAK);
    }

    public static function americaAnchorage() : self
    {
        return new self(self::AMERICA_ANCHORAGE);
    }

    public static function americaAnguilla() : self
    {
        return new self(self::AMERICA_ANGUILLA);
    }

    public static function americaAntigua() : self
    {
        return new self(self::AMERICA_ANTIGUA);
    }

    public static function americaAraguaina() : self
    {
        return new self(self::AMERICA_ARAGUAINA);
    }

    public static function americaArgentinaBuenosAires() : self
    {
        return new self(self::AMERICA_ARGENTINA_BUENOS_AIRES);
    }

    public static function americaArgentinaCatamarca() : self
    {
        return new self(self::AMERICA_ARGENTINA_CATAMARCA);
    }

    public static function americaArgentinaCordoba() : self
    {
        return new self(self::AMERICA_ARGENTINA_CORDOBA);
    }

    public static function americaArgentinaJujuy() : self
    {
        return new self(self::AMERICA_ARGENTINA_JUJUY);
    }

    public static function americaArgentinaLaRioja() : self
    {
        return new self(self::AMERICA_ARGENTINA_LA_RIOJA);
    }

    public static function americaArgentinaMendoza() : self
    {
        return new self(self::AMERICA_ARGENTINA_MENDOZA);
    }

    public static function americaArgentinaRioGallegos() : self
    {
        return new self(self::AMERICA_ARGENTINA_RIO_GALLEGOS);
    }

    public static function americaArgentinaSalta() : self
    {
        return new self(self::AMERICA_ARGENTINA_SALTA);
    }

    public static function americaArgentinaSanJuan() : self
    {
        return new self(self::AMERICA_ARGENTINA_SAN_JUAN);
    }

    public static function americaArgentinaSanLuis() : self
    {
        return new self(self::AMERICA_ARGENTINA_SAN_LUIS);
    }

    public static function americaArgentinaTucuman() : self
    {
        return new self(self::AMERICA_ARGENTINA_TUCUMAN);
    }

    public static function americaArgentinaUshuaia() : self
    {
        return new self(self::AMERICA_ARGENTINA_USHUAIA);
    }

    public static function americaAruba() : self
    {
        return new self(self::AMERICA_ARUBA);
    }

    public static function americaAsuncion() : self
    {
        return new self(self::AMERICA_ASUNCION);
    }

    public static function americaAtikokan() : self
    {
        return new self(self::AMERICA_ATIKOKAN);
    }

    public static function americaBahia() : self
    {
        return new self(self::AMERICA_BAHIA);
    }

    public static function americaBahiaBanderas() : self
    {
        return new self(self::AMERICA_BAHIA_BANDERAS);
    }

    public static function americaBarbados() : self
    {
        return new self(self::AMERICA_BARBADOS);
    }

    public static function americaBelem() : self
    {
        return new self(self::AMERICA_BELEM);
    }

    public static function americaBelize() : self
    {
        return new self(self::AMERICA_BELIZE);
    }

    public static function americaBlancSablon() : self
    {
        return new self(self::AMERICA_BLANC_SABLON);
    }

    public static function americaBoaVista() : self
    {
        return new self(self::AMERICA_BOA_VISTA);
    }

    public static function americaBogota() : self
    {
        return new self(self::AMERICA_BOGOTA);
    }

    public static function americaBoise() : self
    {
        return new self(self::AMERICA_BOISE);
    }

    public static function americaCambridgeBay() : self
    {
        return new self(self::AMERICA_CAMBRIDGE_BAY);
    }

    public static function americaCampoGrande() : self
    {
        return new self(self::AMERICA_CAMPO_GRANDE);
    }

    public static function americaCancun() : self
    {
        return new self(self::AMERICA_CANCUN);
    }

    public static function americaCaracas() : self
    {
        return new self(self::AMERICA_CARACAS);
    }

    public static function americaCayenne() : self
    {
        return new self(self::AMERICA_CAYENNE);
    }

    public static function americaCayman() : self
    {
        return new self(self::AMERICA_CAYMAN);
    }

    public static function americaChicago() : self
    {
        return new self(self::AMERICA_CHICAGO);
    }

    public static function americaChihuahua() : self
    {
        return new self(self::AMERICA_CHIHUAHUA);
    }

    public static function americaCostaRica() : self
    {
        return new self(self::AMERICA_COSTA_RICA);
    }

    public static function americaCreston() : self
    {
        return new self(self::AMERICA_CRESTON);
    }

    public static function americaCuiaba() : self
    {
        return new self(self::AMERICA_CUIABA);
    }

    public static function americaCuracao() : self
    {
        return new self(self::AMERICA_CURACAO);
    }

    public static function americaDanmarkshavn() : self
    {
        return new self(self::AMERICA_DANMARKSHAVN);
    }

    public static function americaDawson() : self
    {
        return new self(self::AMERICA_DAWSON);
    }

    public static function americaDawsonCreek() : self
    {
        return new self(self::AMERICA_DAWSON_CREEK);
    }

    public static function americaDenver() : self
    {
        return new self(self::AMERICA_DENVER);
    }

    public static function americaDetroit() : self
    {
        return new self(self::AMERICA_DETROIT);
    }

    public static function americaDominica() : self
    {
        return new self(self::AMERICA_DOMINICA);
    }

    public static function americaEdmonton() : self
    {
        return new self(self::AMERICA_EDMONTON);
    }

    public static function americaEirunepe() : self
    {
        return new self(self::AMERICA_EIRUNEPE);
    }

    public static function americaElSalvador() : self
    {
        return new self(self::AMERICA_EL_SALVADOR);
    }

    public static function americaFortNelson() : self
    {
        return new self(self::AMERICA_FORT_NELSON);
    }

    public static function americaFortaleza() : self
    {
        return new self(self::AMERICA_FORTALEZA);
    }

    public static function americaGlaceBay() : self
    {
        return new self(self::AMERICA_GLACE_BAY);
    }

    public static function americaGooseBay() : self
    {
        return new self(self::AMERICA_GOOSE_BAY);
    }

    public static function americaGodthab() : self
    {
        return new self(self::AMERICA_GODTHAB);
    }

    public static function americaGrandTurk() : self
    {
        return new self(self::AMERICA_GRAND_TURK);
    }

    public static function americaGrenada() : self
    {
        return new self(self::AMERICA_GRENADA);
    }

    public static function americaGuadeloupe() : self
    {
        return new self(self::AMERICA_GUADELOUPE);
    }

    public static function americaGuatemala() : self
    {
        return new self(self::AMERICA_GUATEMALA);
    }

    public static function americaGuayaquil() : self
    {
        return new self(self::AMERICA_GUAYAQUIL);
    }

    public static function americaGuyana() : self
    {
        return new self(self::AMERICA_GUYANA);
    }

    public static function americaHalifax() : self
    {
        return new self(self::AMERICA_HALIFAX);
    }

    public static function americaHavana() : self
    {
        return new self(self::AMERICA_HAVANA);
    }

    public static function americaHermosillo() : self
    {
        return new self(self::AMERICA_HERMOSILLO);
    }

    public static function americaIndianaIndianapolis() : self
    {
        return new self(self::AMERICA_INDIANA_INDIANAPOLIS);
    }

    public static function americaIndianaKnox() : self
    {
        return new self(self::AMERICA_INDIANA_KNOX);
    }

    public static function americaIndianaMarengo() : self
    {
        return new self(self::AMERICA_INDIANA_MARENGO);
    }

    public static function americaIndianaPetersburg() : self
    {
        return new self(self::AMERICA_INDIANA_PETERSBURG);
    }

    public static function americaIndianaTellCity() : self
    {
        return new self(self::AMERICA_INDIANA_TELL_CITY);
    }

    public static function americaIndianaVevay() : self
    {
        return new self(self::AMERICA_INDIANA_VEVAY);
    }

    public static function americaIndianaVincennes() : self
    {
        return new self(self::AMERICA_INDIANA_VINCENNES);
    }

    public static function americaIndianaWinamac() : self
    {
        return new self(self::AMERICA_INDIANA_WINAMAC);
    }

    public static function americaInuvik() : self
    {
        return new self(self::AMERICA_INUVIK);
    }

    public static function americaIqaluit() : self
    {
        return new self(self::AMERICA_IQALUIT);
    }

    public static function americaJamaica() : self
    {
        return new self(self::AMERICA_JAMAICA);
    }

    public static function americaJuneau() : self
    {
        return new self(self::AMERICA_JUNEAU);
    }

    public static function americaKentuckyLouisville() : self
    {
        return new self(self::AMERICA_KENTUCKY_LOUISVILLE);
    }

    public static function americaKentuckyMonticello() : self
    {
        return new self(self::AMERICA_KENTUCKY_MONTICELLO);
    }

    public static function americaKralendijk() : self
    {
        return new self(self::AMERICA_KRALENDIJK);
    }

    public static function americaLaPaz() : self
    {
        return new self(self::AMERICA_LA_PAZ);
    }

    public static function americaLima() : self
    {
        return new self(self::AMERICA_LIMA);
    }

    public static function americaLosAngeles() : self
    {
        return new self(self::AMERICA_LOS_ANGELES);
    }

    public static function americaLowerPrinces() : self
    {
        return new self(self::AMERICA_LOWER_PRINCES);
    }

    public static function americaMaceio() : self
    {
        return new self(self::AMERICA_MACEIO);
    }

    public static function americaManagua() : self
    {
        return new self(self::AMERICA_MANAGUA);
    }

    public static function americaManaus() : self
    {
        return new self(self::AMERICA_MANAUS);
    }

    public static function americaMarigot() : self
    {
        return new self(self::AMERICA_MARIGOT);
    }

    public static function americaMartinique() : self
    {
        return new self(self::AMERICA_MARTINIQUE);
    }

    public static function americaMatamoros() : self
    {
        return new self(self::AMERICA_MATAMOROS);
    }

    public static function americaMazatlan() : self
    {
        return new self(self::AMERICA_MAZATLAN);
    }

    public static function americaMenominee() : self
    {
        return new self(self::AMERICA_MENOMINEE);
    }

    public static function americaMerida() : self
    {
        return new self(self::AMERICA_MERIDA);
    }

    public static function americaMetlakatla() : self
    {
        return new self(self::AMERICA_METLAKATLA);
    }

    public static function americaMexicoCity() : self
    {
        return new self(self::AMERICA_MEXICO_CITY);
    }

    public static function americaMiquelon() : self
    {
        return new self(self::AMERICA_MIQUELON);
    }

    public static function americaMoncton() : self
    {
        return new self(self::AMERICA_MONCTON);
    }

    public static function americaMonterrey() : self
    {
        return new self(self::AMERICA_MONTERREY);
    }

    public static function americaMontevideo() : self
    {
        return new self(self::AMERICA_MONTEVIDEO);
    }

    public static function americaMontserrat() : self
    {
        return new self(self::AMERICA_MONTSERRAT);
    }

    public static function americaNassau() : self
    {
        return new self(self::AMERICA_NASSAU);
    }

    public static function americaNewYork() : self
    {
        return new self(self::AMERICA_NEW_YORK);
    }

    public static function americaNipigon() : self
    {
        return new self(self::AMERICA_NIPIGON);
    }

    public static function americaNome() : self
    {
        return new self(self::AMERICA_NOME);
    }

    public static function americaNoronha() : self
    {
        return new self(self::AMERICA_NORONHA);
    }

    public static function americaNorthDakotaBeulah() : self
    {
        return new self(self::AMERICA_NORTH_DAKOTA_BEULAH);
    }

    public static function americaNorthDakotaCenter() : self
    {
        return new self(self::AMERICA_NORTH_DAKOTA_CENTER);
    }

    public static function americaNorthDakotaNewSalem() : self
    {
        return new self(self::AMERICA_NORTH_DAKOTA_NEW_SALEM);
    }

    public static function americaNuuk() : self
    {
        return new self(self::AMERICA_NUUK);
    }

    public static function americaOjinaga() : self
    {
        return new self(self::AMERICA_OJINAGA);
    }

    public static function americaPanama() : self
    {
        return new self(self::AMERICA_PANAMA);
    }

    public static function americaPangnirtung() : self
    {
        return new self(self::AMERICA_PANGNIRTUNG);
    }

    public static function americaParamaribo() : self
    {
        return new self(self::AMERICA_PARAMARIBO);
    }

    public static function americaPhoenix() : self
    {
        return new self(self::AMERICA_PHOENIX);
    }

    public static function americaPortAuPrince() : self
    {
        return new self(self::AMERICA_PORT_AU_PRINCE);
    }

    public static function americaPortOfSpain() : self
    {
        return new self(self::AMERICA_PORT_OF_SPAIN);
    }

    public static function americaPortoVelho() : self
    {
        return new self(self::AMERICA_PORTO_VELHO);
    }

    public static function americaPuertoRico() : self
    {
        return new self(self::AMERICA_PUERTO_RICO);
    }

    public static function americaPuntaArenas() : self
    {
        return new self(self::AMERICA_PUNTA_ARENAS);
    }

    public static function americaRainyRiver() : self
    {
        return new self(self::AMERICA_RAINY_RIVER);
    }

    public static function americaRankinInlet() : self
    {
        return new self(self::AMERICA_RANKIN_INLET);
    }

    public static function americaRecife() : self
    {
        return new self(self::AMERICA_RECIFE);
    }

    public static function americaRegina() : self
    {
        return new self(self::AMERICA_REGINA);
    }

    public static function americaResolute() : self
    {
        return new self(self::AMERICA_RESOLUTE);
    }

    public static function americaRioBranco() : self
    {
        return new self(self::AMERICA_RIO_BRANCO);
    }

    public static function americaSantarem() : self
    {
        return new self(self::AMERICA_SANTAREM);
    }

    public static function americaSantiago() : self
    {
        return new self(self::AMERICA_SANTIAGO);
    }

    public static function americaSantoDomingo() : self
    {
        return new self(self::AMERICA_SANTO_DOMINGO);
    }

    public static function americaSaoPaulo() : self
    {
        return new self(self::AMERICA_SAO_PAULO);
    }

    public static function americaScoresbysund() : self
    {
        return new self(self::AMERICA_SCORESBYSUND);
    }

    public static function americaSitka() : self
    {
        return new self(self::AMERICA_SITKA);
    }

    public static function americaStBarthelemy() : self
    {
        return new self(self::AMERICA_ST_BARTHELEMY);
    }

    public static function americaStJohns() : self
    {
        return new self(self::AMERICA_ST_JOHNS);
    }

    public static function americaStKitts() : self
    {
        return new self(self::AMERICA_ST_KITTS);
    }

    public static function americaStLucia() : self
    {
        return new self(self::AMERICA_ST_LUCIA);
    }

    public static function americaStThomas() : self
    {
        return new self(self::AMERICA_ST_THOMAS);
    }

    public static function americaStVincent() : self
    {
        return new self(self::AMERICA_ST_VINCENT);
    }

    public static function americaSwiftCurrent() : self
    {
        return new self(self::AMERICA_SWIFT_CURRENT);
    }

    public static function americaTegucigalpa() : self
    {
        return new self(self::AMERICA_TEGUCIGALPA);
    }

    public static function americaThule() : self
    {
        return new self(self::AMERICA_THULE);
    }

    public static function americaThunderBay() : self
    {
        return new self(self::AMERICA_THUNDER_BAY);
    }

    public static function americaTijuana() : self
    {
        return new self(self::AMERICA_TIJUANA);
    }

    public static function americaToronto() : self
    {
        return new self(self::AMERICA_TORONTO);
    }

    public static function americaTortola() : self
    {
        return new self(self::AMERICA_TORTOLA);
    }

    public static function americaVancouver() : self
    {
        return new self(self::AMERICA_VANCOUVER);
    }

    public static function americaWhitehorse() : self
    {
        return new self(self::AMERICA_WHITEHORSE);
    }

    public static function americaWinnipeg() : self
    {
        return new self(self::AMERICA_WINNIPEG);
    }

    public static function americaYakutat() : self
    {
        return new self(self::AMERICA_YAKUTAT);
    }

    public static function americaYellowknife() : self
    {
        return new self(self::AMERICA_YELLOWKNIFE);
    }

    public static function antarcticaCasey() : self
    {
        return new self(self::ANTARCTICA_CASEY);
    }

    public static function antarcticaDavis() : self
    {
        return new self(self::ANTARCTICA_DAVIS);
    }

    public static function antarcticaDumontDUrville() : self
    {
        return new self(self::ANTARCTICA_DUMONTDURVILLE);
    }

    public static function antarcticaMacquarie() : self
    {
        return new self(self::ANTARCTICA_MACQUARIE);
    }

    public static function antarcticaMawson() : self
    {
        return new self(self::ANTARCTICA_MAWSON);
    }

    public static function antarcticaMcMurdo() : self
    {
        return new self(self::ANTARCTICA_MCMURDO);
    }

    public static function antarcticaPalmer() : self
    {
        return new self(self::ANTARCTICA_PALMER);
    }

    public static function antarcticaRothera() : self
    {
        return new self(self::ANTARCTICA_ROTHERA);
    }

    public static function antarcticaSyowa() : self
    {
        return new self(self::ANTARCTICA_SYOWA);
    }

    public static function antarcticaTroll() : self
    {
        return new self(self::ANTARCTICA_TROLL);
    }

    public static function antarcticaVostok() : self
    {
        return new self(self::ANTARCTICA_VOSTOK);
    }

    public static function arcticLongyearbyen() : self
    {
        return new self(self::ARCTIC_LONGYEARBYEN);
    }

    public static function asiaAden() : self
    {
        return new self(self::ASIA_ADEN);
    }

    public static function asiaAlmaty() : self
    {
        return new self(self::ASIA_ALMATY);
    }

    public static function asiaAmman() : self
    {
        return new self(self::ASIA_AMMAN);
    }

    public static function asiaAnadyr() : self
    {
        return new self(self::ASIA_ANADYR);
    }

    public static function asiaAqtau() : self
    {
        return new self(self::ASIA_AQTAU);
    }

    public static function asiaAqtobe() : self
    {
        return new self(self::ASIA_AQTOBE);
    }

    public static function asiaAshgabat() : self
    {
        return new self(self::ASIA_ASHGABAT);
    }

    public static function asiaAtyrau() : self
    {
        return new self(self::ASIA_ATYRAU);
    }

    public static function asiaBaghdad() : self
    {
        return new self(self::ASIA_BAGHDAD);
    }

    public static function asiaBahrain() : self
    {
        return new self(self::ASIA_BAHRAIN);
    }

    public static function asiaBaku() : self
    {
        return new self(self::ASIA_BAKU);
    }

    public static function asiaBangkok() : self
    {
        return new self(self::ASIA_BANGKOK);
    }

    public static function asiaBarnaul() : self
    {
        return new self(self::ASIA_BARNAUL);
    }

    public static function asiaBeirut() : self
    {
        return new self(self::ASIA_BEIRUT);
    }

    public static function asiaBishkek() : self
    {
        return new self(self::ASIA_BISHKEK);
    }

    public static function asiaBrunei() : self
    {
        return new self(self::ASIA_BRUNEI);
    }

    public static function asiaChita() : self
    {
        return new self(self::ASIA_CHITA);
    }

    public static function asiaChoibalsan() : self
    {
        return new self(self::ASIA_CHOIBALSAN);
    }

    public static function asiaColombo() : self
    {
        return new self(self::ASIA_COLOMBO);
    }

    public static function asiaDamascus() : self
    {
        return new self(self::ASIA_DAMASCUS);
    }

    public static function asiaDhaka() : self
    {
        return new self(self::ASIA_DHAKA);
    }

    public static function asiaDili() : self
    {
        return new self(self::ASIA_DILI);
    }

    public static function asiaDubai() : self
    {
        return new self(self::ASIA_DUBAI);
    }

    public static function asiaDushanbe() : self
    {
        return new self(self::ASIA_DUSHANBE);
    }

    public static function asiaFamagusta() : self
    {
        return new self(self::ASIA_FAMAGUSTA);
    }

    public static function asiaGaza() : self
    {
        return new self(self::ASIA_GAZA);
    }

    public static function asiaHebron() : self
    {
        return new self(self::ASIA_HEBRON);
    }

    public static function asiaHoChiMinh() : self
    {
        return new self(self::ASIA_HO_CHI_MINH);
    }

    public static function asiaHongKong() : self
    {
        return new self(self::ASIA_HONG_KONG);
    }

    public static function asiaHovd() : self
    {
        return new self(self::ASIA_HOVD);
    }

    public static function asiaIrkutsk() : self
    {
        return new self(self::ASIA_IRKUTSK);
    }

    public static function asiaJakarta() : self
    {
        return new self(self::ASIA_JAKARTA);
    }

    public static function asiaJayapura() : self
    {
        return new self(self::ASIA_JAYAPURA);
    }

    public static function asiaJerusalem() : self
    {
        return new self(self::ASIA_JERUSALEM);
    }

    public static function asiaKabul() : self
    {
        return new self(self::ASIA_KABUL);
    }

    public static function asiaKamchatka() : self
    {
        return new self(self::ASIA_KAMCHATKA);
    }

    public static function asiaKarachi() : self
    {
        return new self(self::ASIA_KARACHI);
    }

    public static function asiaKathmandu() : self
    {
        return new self(self::ASIA_KATHMANDU);
    }

    public static function asiaKhandyga() : self
    {
        return new self(self::ASIA_KHANDYGA);
    }

    public static function asiaKolkata() : self
    {
        return new self(self::ASIA_KOLKATA);
    }

    public static function asiaKrasnoyarsk() : self
    {
        return new self(self::ASIA_KRASNOYARSK);
    }

    public static function asiaKualaLumpur() : self
    {
        return new self(self::ASIA_KUALA_LUMPUR);
    }

    public static function asiaKuching() : self
    {
        return new self(self::ASIA_KUCHING);
    }

    public static function asiaKuwait() : self
    {
        return new self(self::ASIA_KUWAIT);
    }

    public static function asiaMacau() : self
    {
        return new self(self::ASIA_MACAU);
    }

    public static function asiaMagadan() : self
    {
        return new self(self::ASIA_MAGADAN);
    }

    public static function asiaMakassar() : self
    {
        return new self(self::ASIA_MAKASSAR);
    }

    public static function asiaManila() : self
    {
        return new self(self::ASIA_MANILA);
    }

    public static function asiaMuscat() : self
    {
        return new self(self::ASIA_MUSCAT);
    }

    public static function asiaNicosia() : self
    {
        return new self(self::ASIA_NICOSIA);
    }

    public static function asiaNovokuznetsk() : self
    {
        return new self(self::ASIA_NOVOKUZNETSK);
    }

    public static function asiaNovosibirsk() : self
    {
        return new self(self::ASIA_NOVOSIBIRSK);
    }

    public static function asiaOmsk() : self
    {
        return new self(self::ASIA_OMSK);
    }

    public static function asiaOral() : self
    {
        return new self(self::ASIA_ORAL);
    }

    public static function asiaPhnomPenh() : self
    {
        return new self(self::ASIA_PHNOM_PENH);
    }

    public static function asiaPontianak() : self
    {
        return new self(self::ASIA_PONTIANAK);
    }

    public static function asiaPyongyang() : self
    {
        return new self(self::ASIA_PYONGYANG);
    }

    public static function asiaQatar() : self
    {
        return new self(self::ASIA_QATAR);
    }

    public static function asiaQostanay() : self
    {
        return new self(self::ASIA_QOSTANAY);
    }

    public static function asiaQyzylorda() : self
    {
        return new self(self::ASIA_QYZYLORDA);
    }

    public static function asiaRiyadh() : self
    {
        return new self(self::ASIA_RIYADH);
    }

    public static function asiaSakhalin() : self
    {
        return new self(self::ASIA_SAKHALIN);
    }

    public static function asiaSamarkand() : self
    {
        return new self(self::ASIA_SAMARKAND);
    }

    public static function asiaSeoul() : self
    {
        return new self(self::ASIA_SEOUL);
    }

    public static function asiaShanghai() : self
    {
        return new self(self::ASIA_SHANGHAI);
    }

    public static function asiaSingapore() : self
    {
        return new self(self::ASIA_SINGAPORE);
    }

    public static function asiaSrednekolymsk() : self
    {
        return new self(self::ASIA_SREDNEKOLYMSK);
    }

    public static function asiaTaipei() : self
    {
        return new self(self::ASIA_TAIPEI);
    }

    public static function asiaTashkent() : self
    {
        return new self(self::ASIA_TASHKENT);
    }

    public static function asiaTbilisi() : self
    {
        return new self(self::ASIA_TBILISI);
    }

    public static function asiaTehran() : self
    {
        return new self(self::ASIA_TEHRAN);
    }

    public static function asiaThimphu() : self
    {
        return new self(self::ASIA_THIMPHU);
    }

    public static function asiaTokyo() : self
    {
        return new self(self::ASIA_TOKYO);
    }

    public static function asiaTomsk() : self
    {
        return new self(self::ASIA_TOMSK);
    }

    public static function asiaUlaanbaatar() : self
    {
        return new self(self::ASIA_ULAANBAATAR);
    }

    public static function asiaUrumqi() : self
    {
        return new self(self::ASIA_URUMQI);
    }

    public static function asiaUstNera() : self
    {
        return new self(self::ASIA_UST_NERA);
    }

    public static function asiaVientiane() : self
    {
        return new self(self::ASIA_VIENTIANE);
    }

    public static function asiaVladivostok() : self
    {
        return new self(self::ASIA_VLADIVOSTOK);
    }

    public static function asiaYakutsk() : self
    {
        return new self(self::ASIA_YAKUTSK);
    }

    public static function asiaYangon() : self
    {
        return new self(self::ASIA_YANGON);
    }

    public static function asiaYekaterinburg() : self
    {
        return new self(self::ASIA_YEKATERINBURG);
    }

    public static function asiaYerevan() : self
    {
        return new self(self::ASIA_YEREVAN);
    }

    public static function atlanticAzores() : self
    {
        return new self(self::ATLANTIC_AZORES);
    }

    public static function atlanticBermuda() : self
    {
        return new self(self::ATLANTIC_BERMUDA);
    }

    public static function atlanticCanary() : self
    {
        return new self(self::ATLANTIC_CANARY);
    }

    public static function atlanticCapeVerde() : self
    {
        return new self(self::ATLANTIC_CAPE_VERDE);
    }

    public static function atlanticFaroe() : self
    {
        return new self(self::ATLANTIC_FAROE);
    }

    public static function atlanticMadeira() : self
    {
        return new self(self::ATLANTIC_MADEIRA);
    }

    public static function atlanticReykjavik() : self
    {
        return new self(self::ATLANTIC_REYKJAVIK);
    }

    public static function atlanticSouthGeorgia() : self
    {
        return new self(self::ATLANTIC_SOUTH_GEORGIA);
    }

    public static function atlanticStHelena() : self
    {
        return new self(self::ATLANTIC_ST_HELENA);
    }

    public static function atlanticStanley() : self
    {
        return new self(self::ATLANTIC_STANLEY);
    }

    public static function australiaAdelaide() : self
    {
        return new self(self::AUSTRALIA_ADELAIDE);
    }

    public static function australiaBrisbane() : self
    {
        return new self(self::AUSTRALIA_BRISBANE);
    }

    public static function australiaBrokenHill() : self
    {
        return new self(self::AUSTRALIA_BROKEN_HILL);
    }

    public static function australiaCurrie() : self
    {
        return new self(self::AUSTRALIA_CURRIE);
    }

    public static function australiaDarwin() : self
    {
        return new self(self::AUSTRALIA_DARWIN);
    }

    public static function australiaEucla() : self
    {
        return new self(self::AUSTRALIA_EUCLA);
    }

    public static function australiaHobart() : self
    {
        return new self(self::AUSTRALIA_HOBART);
    }

    public static function australiaLindeman() : self
    {
        return new self(self::AUSTRALIA_LINDEMAN);
    }

    public static function australiaLordHowe() : self
    {
        return new self(self::AUSTRALIA_LORD_HOWE);
    }

    public static function australiaMelbourne() : self
    {
        return new self(self::AUSTRALIA_MELBOURNE);
    }

    public static function australiaPerth() : self
    {
        return new self(self::AUSTRALIA_PERTH);
    }

    public static function australiaSydney() : self
    {
        return new self(self::AUSTRALIA_SYDNEY);
    }

    public static function europeAmsterdam() : self
    {
        return new self(self::EUROPE_AMSTERDAM);
    }

    public static function europeAndorra() : self
    {
        return new self(self::EUROPE_ANDORRA);
    }

    public static function europeAstrakhan() : self
    {
        return new self(self::EUROPE_ASTRAKHAN);
    }

    public static function europeAthens() : self
    {
        return new self(self::EUROPE_ATHENS);
    }

    public static function europeBelgrade() : self
    {
        return new self(self::EUROPE_BELGRADE);
    }

    public static function europeBerlin() : self
    {
        return new self(self::EUROPE_BERLIN);
    }

    public static function europeBratislava() : self
    {
        return new self(self::EUROPE_BRATISLAVA);
    }

    public static function europeBrussels() : self
    {
        return new self(self::EUROPE_BRUSSELS);
    }

    public static function europeBucharest() : self
    {
        return new self(self::EUROPE_BUCHAREST);
    }

    public static function europeBudapest() : self
    {
        return new self(self::EUROPE_BUDAPEST);
    }

    public static function europeBusingen() : self
    {
        return new self(self::EUROPE_BUSINGEN);
    }

    public static function europeChisinau() : self
    {
        return new self(self::EUROPE_CHISINAU);
    }

    public static function europeCopenhagen() : self
    {
        return new self(self::EUROPE_COPENHAGEN);
    }

    public static function europeDublin() : self
    {
        return new self(self::EUROPE_DUBLIN);
    }

    public static function europeGibraltar() : self
    {
        return new self(self::EUROPE_GIBRALTAR);
    }

    public static function europeGuernsey() : self
    {
        return new self(self::EUROPE_GUERNSEY);
    }

    public static function europeHelsinki() : self
    {
        return new self(self::EUROPE_HELSINKI);
    }

    public static function europeIsleOfMan() : self
    {
        return new self(self::EUROPE_ISLE_OF_MAN);
    }

    public static function europeIstanbul() : self
    {
        return new self(self::EUROPE_ISTANBUL);
    }

    public static function europeJersey() : self
    {
        return new self(self::EUROPE_JERSEY);
    }

    public static function europeKaliningrad() : self
    {
        return new self(self::EUROPE_KALININGRAD);
    }

    public static function europeKiev() : self
    {
        return new self(self::EUROPE_KIEV);
    }

    public static function europeKirov() : self
    {
        return new self(self::EUROPE_KIROV);
    }

    public static function europeLisbon() : self
    {
        return new self(self::EUROPE_LISBON);
    }

    public static function europeLjubljana() : self
    {
        return new self(self::EUROPE_LJUBLJANA);
    }

    public static function europeLondon() : self
    {
        return new self(self::EUROPE_LONDON);
    }

    public static function europeLuxembourg() : self
    {
        return new self(self::EUROPE_LUXEMBOURG);
    }

    public static function europeMadrid() : self
    {
        return new self(self::EUROPE_MADRID);
    }

    public static function europeMalta() : self
    {
        return new self(self::EUROPE_MALTA);
    }

    public static function europeMariehamn() : self
    {
        return new self(self::EUROPE_MARIEHAMN);
    }

    public static function europeMinsk() : self
    {
        return new self(self::EUROPE_MINSK);
    }

    public static function europeMonaco() : self
    {
        return new self(self::EUROPE_MONACO);
    }

    public static function europeMoscow() : self
    {
        return new self(self::EUROPE_MOSCOW);
    }

    public static function europeOslo() : self
    {
        return new self(self::EUROPE_OSLO);
    }

    public static function europeParis() : self
    {
        return new self(self::EUROPE_PARIS);
    }

    public static function europePodgorica() : self
    {
        return new self(self::EUROPE_PODGORICA);
    }

    public static function europePrague() : self
    {
        return new self(self::EUROPE_PRAGUE);
    }

    public static function europeRiga() : self
    {
        return new self(self::EUROPE_RIGA);
    }

    public static function europeRome() : self
    {
        return new self(self::EUROPE_ROME);
    }

    public static function europeSamara() : self
    {
        return new self(self::EUROPE_SAMARA);
    }

    public static function europeSanMarino() : self
    {
        return new self(self::EUROPE_SAN_MARINO);
    }

    public static function europeSarajevo() : self
    {
        return new self(self::EUROPE_SARAJEVO);
    }

    public static function europeSaratov() : self
    {
        return new self(self::EUROPE_SARATOV);
    }

    public static function europeSimferopol() : self
    {
        return new self(self::EUROPE_SIMFEROPOL);
    }

    public static function europeSkopje() : self
    {
        return new self(self::EUROPE_SKOPJE);
    }

    public static function europeSofia() : self
    {
        return new self(self::EUROPE_SOFIA);
    }

    public static function europeStockholm() : self
    {
        return new self(self::EUROPE_STOCKHOLM);
    }

    public static function europeTallinn() : self
    {
        return new self(self::EUROPE_TALLINN);
    }

    public static function europeTirane() : self
    {
        return new self(self::EUROPE_TIRANE);
    }

    public static function europeUlyanovsk() : self
    {
        return new self(self::EUROPE_ULYANOVSK);
    }

    public static function europeUzhgorod() : self
    {
        return new self(self::EUROPE_UZHGOROD);
    }

    public static function europeVaduz() : self
    {
        return new self(self::EUROPE_VADUZ);
    }

    public static function europeVatican() : self
    {
        return new self(self::EUROPE_VATICAN);
    }

    public static function europeVienna() : self
    {
        return new self(self::EUROPE_VIENNA);
    }

    public static function europeVilnius() : self
    {
        return new self(self::EUROPE_VILNIUS);
    }

    public static function europeVolgograd() : self
    {
        return new self(self::EUROPE_VOLGOGRAD);
    }

    public static function europeWarsaw() : self
    {
        return new self(self::EUROPE_WARSAW);
    }

    public static function europeZagreb() : self
    {
        return new self(self::EUROPE_ZAGREB);
    }

    public static function europeZaporozhye() : self
    {
        return new self(self::EUROPE_ZAPOROZHYE);
    }

    public static function europeZurich() : self
    {
        return new self(self::EUROPE_ZURICH);
    }

    public static function indianAntananarivo() : self
    {
        return new self(self::INDIAN_ANTANANARIVO);
    }

    public static function indianChagos() : self
    {
        return new self(self::INDIAN_CHAGOS);
    }

    public static function indianChristmas() : self
    {
        return new self(self::INDIAN_CHRISTMAS);
    }

    public static function indianCocos() : self
    {
        return new self(self::INDIAN_COCOS);
    }

    public static function indianComoro() : self
    {
        return new self(self::INDIAN_COMORO);
    }

    public static function indianKerguelen() : self
    {
        return new self(self::INDIAN_KERGUELEN);
    }

    public static function indianMahe() : self
    {
        return new self(self::INDIAN_MAHE);
    }

    public static function indianMaldives() : self
    {
        return new self(self::INDIAN_MALDIVES);
    }

    public static function indianMauritius() : self
    {
        return new self(self::INDIAN_MAURITIUS);
    }

    public static function indianMayotte() : self
    {
        return new self(self::INDIAN_MAYOTTE);
    }

    public static function indianReunion() : self
    {
        return new self(self::INDIAN_REUNION);
    }

    public static function pacificApia() : self
    {
        return new self(self::PACIFIC_APIA);
    }

    public static function pacificAuckland() : self
    {
        return new self(self::PACIFIC_AUCKLAND);
    }

    public static function pacificBougainville() : self
    {
        return new self(self::PACIFIC_BOUGAINVILLE);
    }

    public static function pacificChatham() : self
    {
        return new self(self::PACIFIC_CHATHAM);
    }

    public static function pacificChuuk() : self
    {
        return new self(self::PACIFIC_CHUUK);
    }

    public static function pacificEaster() : self
    {
        return new self(self::PACIFIC_EASTER);
    }

    public static function pacificEfate() : self
    {
        return new self(self::PACIFIC_EFATE);
    }

    public static function pacificEnderbury() : self
    {
        return new self(self::PACIFIC_ENDERBURY);
    }

    public static function pacificFakaofo() : self
    {
        return new self(self::PACIFIC_FAKAOFO);
    }

    public static function pacificFiji() : self
    {
        return new self(self::PACIFIC_FIJI);
    }

    public static function pacificFunafuti() : self
    {
        return new self(self::PACIFIC_FUNAFUTI);
    }

    public static function pacificGalapagos() : self
    {
        return new self(self::PACIFIC_GALAPAGOS);
    }

    public static function pacificGambier() : self
    {
        return new self(self::PACIFIC_GAMBIER);
    }

    public static function pacificGuadalcanal() : self
    {
        return new self(self::PACIFIC_GUADALCANAL);
    }

    public static function pacificGuam() : self
    {
        return new self(self::PACIFIC_GUAM);
    }

    public static function pacificHonolulu() : self
    {
        return new self(self::PACIFIC_HONOLULU);
    }

    public static function pacificKiritimati() : self
    {
        return new self(self::PACIFIC_KIRITIMATI);
    }

    public static function pacificJohnston() : self
    {
        return new self(self::PACIFIC_JOHNSTON);
    }

    public static function pacificKosrae() : self
    {
        return new self(self::PACIFIC_KOSRAE);
    }

    public static function pacificKwajalein() : self
    {
        return new self(self::PACIFIC_KWAJALEIN);
    }

    public static function pacificMajuro() : self
    {
        return new self(self::PACIFIC_MAJURO);
    }

    public static function pacificMarquesas() : self
    {
        return new self(self::PACIFIC_MARQUESAS);
    }

    public static function pacificMidway() : self
    {
        return new self(self::PACIFIC_MIDWAY);
    }

    public static function pacificNauru() : self
    {
        return new self(self::PACIFIC_NAURU);
    }

    public static function pacificNiue() : self
    {
        return new self(self::PACIFIC_NIUE);
    }

    public static function pacificNorfolk() : self
    {
        return new self(self::PACIFIC_NORFOLK);
    }

    public static function pacificNoumea() : self
    {
        return new self(self::PACIFIC_NOUMEA);
    }

    public static function pacificPagoPago() : self
    {
        return new self(self::PACIFIC_PAGO_PAGO);
    }

    public static function pacificPalau() : self
    {
        return new self(self::PACIFIC_PALAU);
    }

    public static function pacificPitcairn() : self
    {
        return new self(self::PACIFIC_PITCAIRN);
    }

    public static function pacificPohnpei() : self
    {
        return new self(self::PACIFIC_POHNPEI);
    }

    public static function pacificPortMoresby() : self
    {
        return new self(self::PACIFIC_PORT_MORESBY);
    }

    public static function pacificRarotonga() : self
    {
        return new self(self::PACIFIC_RAROTONGA);
    }

    public static function pacificSaipan() : self
    {
        return new self(self::PACIFIC_SAIPAN);
    }

    public static function pacificTahiti() : self
    {
        return new self(self::PACIFIC_TAHITI);
    }

    public static function pacificTarawa() : self
    {
        return new self(self::PACIFIC_TARAWA);
    }

    public static function pacificTongatapu() : self
    {
        return new self(self::PACIFIC_TONGATAPU);
    }

    public static function pacificWake() : self
    {
        return new self(self::PACIFIC_WAKE);
    }

    public static function pacificWallis() : self
    {
        return new self(self::PACIFIC_WALLIS);
    }

    /**
     * @psalm-pure
     */
    public static function UTC() : self
    {
        return new self(self::UTC);
    }

    public function toDateTimeZone() : \DateTimeZone
    {
        return new \DateTimeZone($this->name);
    }

    public function name() : string
    {
        return $this->toDateTimeZone()->getName();
    }

    /**
     * Offset depends on date because daylight & saving time will have it different and
     * the only way to get it is to take it from date time.
     */
    public function timeOffset(DateTime $dateTime) : TimeOffset
    {
        return TimeOffset::fromTimeUnit(TimeUnit::seconds($this->toDateTimeZone()->getOffset($dateTime->toDateTimeImmutable())));
    }

    // @codeCoverageIgnoreEnd
    public function toCountryCode() : ?string
    {
        $mapping = [
            self::AMERICA_ARUBA => 'AW',
            self::ASIA_KABUL => 'AF',
            self::AFRICA_LUANDA => 'AO',
            self::AMERICA_ANGUILLA => 'AI',
            self::EUROPE_MARIEHAMN => 'AX',
            self::EUROPE_TIRANE => 'AL',
            self::EUROPE_ANDORRA => 'AD',
            self::ASIA_DUBAI => 'AE',
            self::AMERICA_ARGENTINA_BUENOS_AIRES => 'AR',
            self::AMERICA_ARGENTINA_CORDOBA => 'AR',
            self::AMERICA_ARGENTINA_SALTA => 'AR',
            self::AMERICA_ARGENTINA_JUJUY => 'AR',
            self::AMERICA_ARGENTINA_TUCUMAN => 'AR',
            self::AMERICA_ARGENTINA_CATAMARCA => 'AR',
            self::AMERICA_ARGENTINA_LA_RIOJA => 'AR',
            self::AMERICA_ARGENTINA_SAN_JUAN => 'AR',
            self::AMERICA_ARGENTINA_MENDOZA => 'AR',
            self::AMERICA_ARGENTINA_SAN_LUIS => 'AR',
            self::AMERICA_ARGENTINA_RIO_GALLEGOS => 'AR',
            self::AMERICA_ARGENTINA_USHUAIA => 'AR',
            self::ASIA_YEREVAN => 'AM',
            self::PACIFIC_PAGO_PAGO => 'AS',
            self::ANTARCTICA_MCMURDO => 'AQ',
            self::ANTARCTICA_CASEY => 'AQ',
            self::ANTARCTICA_DAVIS => 'AQ',
            self::ANTARCTICA_DUMONTDURVILLE => 'AQ',
            self::ANTARCTICA_MAWSON => 'AQ',
            self::ANTARCTICA_PALMER => 'AQ',
            self::ANTARCTICA_ROTHERA => 'AQ',
            self::ANTARCTICA_SYOWA => 'AQ',
            self::ANTARCTICA_TROLL => 'AQ',
            self::ANTARCTICA_VOSTOK => 'AQ',
            self::INDIAN_KERGUELEN => 'TF',
            self::AMERICA_ANTIGUA => 'AG',
            self::AUSTRALIA_LORD_HOWE => 'AU',
            self::ANTARCTICA_MACQUARIE => 'AU',
            self::AUSTRALIA_HOBART => 'AU',
            self::AUSTRALIA_CURRIE => 'AU',
            self::AUSTRALIA_MELBOURNE => 'AU',
            self::AUSTRALIA_SYDNEY => 'AU',
            self::AUSTRALIA_BROKEN_HILL => 'AU',
            self::AUSTRALIA_BRISBANE => 'AU',
            self::AUSTRALIA_LINDEMAN => 'AU',
            self::AUSTRALIA_ADELAIDE => 'AU',
            self::AUSTRALIA_DARWIN => 'AU',
            self::AUSTRALIA_PERTH => 'AU',
            self::AUSTRALIA_EUCLA => 'AU',
            self::EUROPE_VIENNA => 'AT',
            self::ASIA_BAKU => 'AZ',
            self::AFRICA_BUJUMBURA => 'BI',
            self::EUROPE_BRUSSELS => 'BE',
            self::AFRICA_PORTO_NOVO => 'BJ',
            self::AFRICA_OUAGADOUGOU => 'BF',
            self::ASIA_DHAKA => 'BD',
            self::EUROPE_SOFIA => 'BG',
            self::ASIA_BAHRAIN => 'BH',
            self::AMERICA_NASSAU => 'BS',
            self::EUROPE_SARAJEVO => 'BA',
            self::AMERICA_ST_BARTHELEMY => 'BL',
            self::EUROPE_MINSK => 'BY',
            self::AMERICA_BELIZE => 'BZ',
            self::ATLANTIC_BERMUDA => 'BM',
            self::AMERICA_LA_PAZ => 'BO',
            self::AMERICA_NORONHA => 'BR',
            self::AMERICA_BELEM => 'BR',
            self::AMERICA_FORTALEZA => 'BR',
            self::AMERICA_RECIFE => 'BR',
            self::AMERICA_ARAGUAINA => 'BR',
            self::AMERICA_MACEIO => 'BR',
            self::AMERICA_BAHIA => 'BR',
            self::AMERICA_SAO_PAULO => 'BR',
            self::AMERICA_CAMPO_GRANDE => 'BR',
            self::AMERICA_CUIABA => 'BR',
            self::AMERICA_SANTAREM => 'BR',
            self::AMERICA_PORTO_VELHO => 'BR',
            self::AMERICA_BOA_VISTA => 'BR',
            self::AMERICA_MANAUS => 'BR',
            self::AMERICA_EIRUNEPE => 'BR',
            self::AMERICA_RIO_BRANCO => 'BR',
            self::AMERICA_BARBADOS => 'BB',
            self::ASIA_BRUNEI => 'BN',
            self::ASIA_THIMPHU => 'BT',
            self::AFRICA_GABORONE => 'BW',
            self::AFRICA_BANGUI => 'CF',
            self::AMERICA_ST_JOHNS => 'CA',
            self::AMERICA_HALIFAX => 'CA',
            self::AMERICA_GLACE_BAY => 'CA',
            self::AMERICA_MONCTON => 'CA',
            self::AMERICA_GOOSE_BAY => 'CA',
            self::AMERICA_BLANC_SABLON => 'CA',
            self::AMERICA_TORONTO => 'CA',
            self::AMERICA_NIPIGON => 'CA',
            self::AMERICA_THUNDER_BAY => 'CA',
            self::AMERICA_IQALUIT => 'CA',
            self::AMERICA_PANGNIRTUNG => 'CA',
            self::AMERICA_ATIKOKAN => 'CA',
            self::AMERICA_WINNIPEG => 'CA',
            self::AMERICA_RAINY_RIVER => 'CA',
            self::AMERICA_RESOLUTE => 'CA',
            self::AMERICA_RANKIN_INLET => 'CA',
            self::AMERICA_REGINA => 'CA',
            self::AMERICA_SWIFT_CURRENT => 'CA',
            self::AMERICA_EDMONTON => 'CA',
            self::AMERICA_CAMBRIDGE_BAY => 'CA',
            self::AMERICA_YELLOWKNIFE => 'CA',
            self::AMERICA_INUVIK => 'CA',
            self::AMERICA_CRESTON => 'CA',
            self::AMERICA_DAWSON_CREEK => 'CA',
            self::AMERICA_FORT_NELSON => 'CA',
            self::AMERICA_VANCOUVER => 'CA',
            self::AMERICA_WHITEHORSE => 'CA',
            self::AMERICA_DAWSON => 'CA',
            self::INDIAN_COCOS => 'CC',
            self::EUROPE_ZURICH => 'CH',
            self::AMERICA_SANTIAGO => 'CL',
            self::PACIFIC_EASTER => 'CL',
            self::ASIA_SHANGHAI => 'CN',
            self::ASIA_URUMQI => 'CN',
            self::AFRICA_ABIDJAN => 'CI',
            self::AFRICA_DOUALA => 'CM',
            self::AFRICA_KINSHASA => 'CD',
            self::AFRICA_LUBUMBASHI => 'CD',
            self::AFRICA_BRAZZAVILLE => 'CG',
            self::PACIFIC_RAROTONGA => 'CK',
            self::AMERICA_BOGOTA => 'CO',
            self::INDIAN_COMORO => 'KM',
            self::ATLANTIC_CAPE_VERDE => 'CV',
            self::AMERICA_COSTA_RICA => 'CR',
            self::AMERICA_HAVANA => 'CU',
            self::AMERICA_CURACAO => 'CW',
            self::INDIAN_CHRISTMAS => 'CX',
            self::AMERICA_CAYMAN => 'KY',
            self::ASIA_NICOSIA => 'CY',
            self::EUROPE_PRAGUE => 'CZ',
            self::EUROPE_BERLIN => 'DE',
            self::EUROPE_BUSINGEN => 'DE',
            self::AFRICA_DJIBOUTI => 'DJ',
            self::AMERICA_DOMINICA => 'DM',
            self::EUROPE_COPENHAGEN => 'DK',
            self::AMERICA_SANTO_DOMINGO => 'DO',
            self::AFRICA_ALGIERS => 'DZ',
            self::AMERICA_GUAYAQUIL => 'EC',
            self::PACIFIC_GALAPAGOS => 'EC',
            self::AFRICA_CAIRO => 'EG',
            self::AFRICA_ASMARA => 'ER',
            self::AFRICA_EL_AAIUN => 'EH',
            self::EUROPE_MADRID => 'ES',
            self::AFRICA_CEUTA => 'ES',
            self::ATLANTIC_CANARY => 'ES',
            self::EUROPE_TALLINN => 'EE',
            self::AFRICA_ADDIS_ABABA => 'ET',
            self::EUROPE_HELSINKI => 'FI',
            self::PACIFIC_FIJI => 'FJ',
            self::ATLANTIC_STANLEY => 'FK',
            self::EUROPE_PARIS => 'FR',
            self::ATLANTIC_FAROE => 'FO',
            self::PACIFIC_CHUUK => 'FM',
            self::PACIFIC_POHNPEI => 'FM',
            self::PACIFIC_KOSRAE => 'FM',
            self::AFRICA_LIBREVILLE => 'GA',
            self::EUROPE_LONDON => 'GB',
            self::ASIA_TBILISI => 'GE',
            self::EUROPE_GUERNSEY => 'GG',
            self::AFRICA_ACCRA => 'GH',
            self::EUROPE_GIBRALTAR => 'GI',
            self::AFRICA_CONAKRY => 'GN',
            self::AMERICA_GUADELOUPE => 'GP',
            self::AFRICA_BANJUL => 'GM',
            self::AFRICA_BISSAU => 'GW',
            self::AFRICA_MALABO => 'GQ',
            self::EUROPE_ATHENS => 'GR',
            self::AMERICA_GRENADA => 'GD',
            self::AMERICA_GODTHAB => 'GL',
            self::AMERICA_DANMARKSHAVN => 'GL',
            self::AMERICA_SCORESBYSUND => 'GL',
            self::AMERICA_THULE => 'GL',
            self::AMERICA_GUATEMALA => 'GT',
            self::AMERICA_CAYENNE => 'GF',
            self::PACIFIC_GUAM => 'GU',
            self::AMERICA_GUYANA => 'GY',
            self::ASIA_HONG_KONG => 'HK',
            self::AMERICA_TEGUCIGALPA => 'HN',
            self::EUROPE_ZAGREB => 'HR',
            self::AMERICA_PORT_AU_PRINCE => 'HT',
            self::EUROPE_BUDAPEST => 'HU',
            self::ASIA_JAKARTA => 'ID',
            self::ASIA_PONTIANAK => 'ID',
            self::ASIA_MAKASSAR => 'ID',
            self::ASIA_JAYAPURA => 'ID',
            self::EUROPE_ISLE_OF_MAN => 'IM',
            self::ASIA_KOLKATA => 'IN',
            self::INDIAN_CHAGOS => 'IO',
            self::EUROPE_DUBLIN => 'IE',
            self::ASIA_TEHRAN => 'IR',
            self::ASIA_BAGHDAD => 'IQ',
            self::ATLANTIC_REYKJAVIK => 'IS',
            self::ASIA_JERUSALEM => 'IL',
            self::EUROPE_ROME => 'IT',
            self::AMERICA_JAMAICA => 'JM',
            self::EUROPE_JERSEY => 'JE',
            self::ASIA_AMMAN => 'JO',
            self::ASIA_TOKYO => 'JP',
            self::ASIA_ALMATY => 'KZ',
            self::ASIA_QYZYLORDA => 'KZ',
            self::ASIA_AQTOBE => 'KZ',
            self::ASIA_AQTAU => 'KZ',
            self::ASIA_ORAL => 'KZ',
            self::AFRICA_NAIROBI => 'KE',
            self::ASIA_BISHKEK => 'KG',
            self::ASIA_PHNOM_PENH => 'KH',
            self::PACIFIC_TARAWA => 'KI',
            self::PACIFIC_ENDERBURY => 'KI',
            self::PACIFIC_KIRITIMATI => 'KI',
            self::AMERICA_ST_KITTS => 'KN',
            self::ASIA_SEOUL => 'KR',
            self::ASIA_KUWAIT => 'KW',
            self::ASIA_VIENTIANE => 'LA',
            self::ASIA_BEIRUT => 'LB',
            self::AFRICA_MONROVIA => 'LR',
            self::AFRICA_TRIPOLI => 'LY',
            self::AMERICA_ST_LUCIA => 'LC',
            self::EUROPE_VADUZ => 'LI',
            self::ASIA_COLOMBO => 'LK',
            self::AFRICA_MASERU => 'LS',
            self::EUROPE_VILNIUS => 'LT',
            self::EUROPE_LUXEMBOURG => 'LU',
            self::EUROPE_RIGA => 'LV',
            self::ASIA_MACAU => 'MO',
            self::AMERICA_MARIGOT => 'MF',
            self::AFRICA_CASABLANCA => 'MA',
            self::EUROPE_MONACO => 'MC',
            self::EUROPE_CHISINAU => 'MD',
            self::INDIAN_ANTANANARIVO => 'MG',
            self::INDIAN_MALDIVES => 'MV',
            self::AMERICA_MEXICO_CITY => 'MX',
            self::AMERICA_CANCUN => 'MX',
            self::AMERICA_MERIDA => 'MX',
            self::AMERICA_MONTERREY => 'MX',
            self::AMERICA_MATAMOROS => 'MX',
            self::AMERICA_MAZATLAN => 'MX',
            self::AMERICA_CHIHUAHUA => 'MX',
            self::AMERICA_OJINAGA => 'MX',
            self::AMERICA_HERMOSILLO => 'MX',
            self::AMERICA_TIJUANA => 'MX',
            self::AMERICA_BAHIA_BANDERAS => 'MX',
            self::PACIFIC_MAJURO => 'MH',
            self::PACIFIC_KWAJALEIN => 'MH',
            self::EUROPE_SKOPJE => 'MK',
            self::AFRICA_BAMAKO => 'ML',
            self::EUROPE_MALTA => 'MT',
            self::EUROPE_PODGORICA => 'ME',
            self::ASIA_ULAANBAATAR => 'MN',
            self::ASIA_HOVD => 'MN',
            self::ASIA_CHOIBALSAN => 'MN',
            self::PACIFIC_SAIPAN => 'MP',
            self::AFRICA_MAPUTO => 'MZ',
            self::AFRICA_NOUAKCHOTT => 'MR',
            self::AMERICA_MONTSERRAT => 'MS',
            self::AMERICA_MARTINIQUE => 'MQ',
            self::INDIAN_MAURITIUS => 'MU',
            self::AFRICA_BLANTYRE => 'MW',
            self::ASIA_KUALA_LUMPUR => 'MY',
            self::ASIA_KUCHING => 'MY',
            self::INDIAN_MAYOTTE => 'YT',
            self::AFRICA_WINDHOEK => 'NA',
            self::PACIFIC_NOUMEA => 'NC',
            self::AFRICA_NIAMEY => 'NE',
            self::PACIFIC_NORFOLK => 'NF',
            self::AFRICA_LAGOS => 'NG',
            self::AMERICA_MANAGUA => 'NI',
            self::PACIFIC_NIUE => 'NU',
            self::EUROPE_AMSTERDAM => 'NL',
            self::EUROPE_OSLO => 'NO',
            self::ASIA_KATHMANDU => 'NP',
            self::PACIFIC_NAURU => 'NR',
            self::PACIFIC_AUCKLAND => 'NZ',
            self::PACIFIC_CHATHAM => 'NZ',
            self::ASIA_MUSCAT => 'OM',
            self::ASIA_KARACHI => 'PK',
            self::AMERICA_PANAMA => 'PA',
            self::PACIFIC_PITCAIRN => 'PN',
            self::AMERICA_LIMA => 'PE',
            self::ASIA_MANILA => 'PH',
            self::PACIFIC_PALAU => 'PW',
            self::PACIFIC_PORT_MORESBY => 'PG',
            self::PACIFIC_BOUGAINVILLE => 'PG',
            self::EUROPE_WARSAW => 'PL',
            self::AMERICA_PUERTO_RICO => 'PR',
            self::ASIA_PYONGYANG => 'KP',
            self::EUROPE_LISBON => 'PT',
            self::ATLANTIC_MADEIRA => 'PT',
            self::ATLANTIC_AZORES => 'PT',
            self::AMERICA_ASUNCION => 'PY',
            self::ASIA_GAZA => 'PS',
            self::ASIA_HEBRON => 'PS',
            self::PACIFIC_TAHITI => 'PF',
            self::PACIFIC_MARQUESAS => 'PF',
            self::PACIFIC_GAMBIER => 'PF',
            self::ASIA_QATAR => 'QA',
            self::INDIAN_REUNION => 'RE',
            self::EUROPE_BUCHAREST => 'RO',
            self::EUROPE_KALININGRAD => 'RU',
            self::EUROPE_MOSCOW => 'RU',
            self::EUROPE_SIMFEROPOL => 'RU',
            self::EUROPE_VOLGOGRAD => 'RU',
            self::EUROPE_KIROV => 'RU',
            self::EUROPE_ASTRAKHAN => 'RU',
            self::EUROPE_SAMARA => 'RU',
            self::EUROPE_ULYANOVSK => 'RU',
            self::ASIA_YEKATERINBURG => 'RU',
            self::ASIA_OMSK => 'RU',
            self::ASIA_NOVOSIBIRSK => 'RU',
            self::ASIA_BARNAUL => 'RU',
            self::ASIA_TOMSK => 'RU',
            self::ASIA_NOVOKUZNETSK => 'RU',
            self::ASIA_KRASNOYARSK => 'RU',
            self::ASIA_IRKUTSK => 'RU',
            self::ASIA_CHITA => 'RU',
            self::ASIA_YAKUTSK => 'RU',
            self::ASIA_KHANDYGA => 'RU',
            self::ASIA_VLADIVOSTOK => 'RU',
            self::ASIA_UST_NERA => 'RU',
            self::ASIA_MAGADAN => 'RU',
            self::ASIA_SAKHALIN => 'RU',
            self::ASIA_SREDNEKOLYMSK => 'RU',
            self::ASIA_KAMCHATKA => 'RU',
            self::ASIA_ANADYR => 'RU',
            self::AFRICA_KIGALI => 'RW',
            self::ASIA_RIYADH => 'SA',
            self::AFRICA_KHARTOUM => 'SD',
            self::AFRICA_DAKAR => 'SN',
            self::ASIA_SINGAPORE => 'SG',
            self::ATLANTIC_SOUTH_GEORGIA => 'GS',
            self::ARCTIC_LONGYEARBYEN => 'SJ',
            self::PACIFIC_GUADALCANAL => 'SB',
            self::AFRICA_FREETOWN => 'SL',
            self::AMERICA_EL_SALVADOR => 'SV',
            self::EUROPE_SAN_MARINO => 'SM',
            self::AFRICA_MOGADISHU => 'SO',
            self::AMERICA_MIQUELON => 'PM',
            self::EUROPE_BELGRADE => 'RS',
            self::AFRICA_JUBA => 'SS',
            self::AFRICA_SAO_TOME => 'ST',
            self::AMERICA_PARAMARIBO => 'SR',
            self::EUROPE_BRATISLAVA => 'SK',
            self::EUROPE_LJUBLJANA => 'SI',
            self::EUROPE_STOCKHOLM => 'SE',
            self::AFRICA_MBABANE => 'SZ',
            self::AMERICA_LOWER_PRINCES => 'SX',
            self::INDIAN_MAHE => 'SC',
            self::ASIA_DAMASCUS => 'SY',
            self::AMERICA_GRAND_TURK => 'TC',
            self::AFRICA_NDJAMENA => 'TD',
            self::AFRICA_LOME => 'TG',
            self::ASIA_BANGKOK => 'TH',
            self::ASIA_DUSHANBE => 'TJ',
            self::PACIFIC_FAKAOFO => 'TK',
            self::ASIA_ASHGABAT => 'TM',
            self::ASIA_DILI => 'TL',
            self::PACIFIC_TONGATAPU => 'TO',
            self::AMERICA_PORT_OF_SPAIN => 'TT',
            self::AFRICA_TUNIS => 'TN',
            self::EUROPE_ISTANBUL => 'TR',
            self::PACIFIC_FUNAFUTI => 'TV',
            self::ASIA_TAIPEI => 'TW',
            self::AFRICA_DAR_ES_SALAAM => 'TZ',
            self::AFRICA_KAMPALA => 'UG',
            self::EUROPE_KIEV => 'UA',
            self::EUROPE_UZHGOROD => 'UA',
            self::EUROPE_ZAPOROZHYE => 'UA',
            self::PACIFIC_JOHNSTON => 'UM',
            self::PACIFIC_MIDWAY => 'UM',
            self::PACIFIC_WAKE => 'UM',
            self::AMERICA_MONTEVIDEO => 'UY',
            self::AMERICA_NEW_YORK => 'US',
            self::AMERICA_DETROIT => 'US',
            self::AMERICA_KENTUCKY_LOUISVILLE => 'US',
            self::AMERICA_KENTUCKY_MONTICELLO => 'US',
            self::AMERICA_INDIANA_INDIANAPOLIS => 'US',
            self::AMERICA_INDIANA_VINCENNES => 'US',
            self::AMERICA_INDIANA_WINAMAC => 'US',
            self::AMERICA_INDIANA_MARENGO => 'US',
            self::AMERICA_INDIANA_PETERSBURG => 'US',
            self::AMERICA_INDIANA_VEVAY => 'US',
            self::AMERICA_CHICAGO => 'US',
            self::AMERICA_INDIANA_TELL_CITY => 'US',
            self::AMERICA_INDIANA_KNOX => 'US',
            self::AMERICA_MENOMINEE => 'US',
            self::AMERICA_NORTH_DAKOTA_CENTER => 'US',
            self::AMERICA_NORTH_DAKOTA_NEW_SALEM => 'US',
            self::AMERICA_NORTH_DAKOTA_BEULAH => 'US',
            self::AMERICA_DENVER => 'US',
            self::AMERICA_BOISE => 'US',
            self::AMERICA_PHOENIX => 'US',
            self::AMERICA_LOS_ANGELES => 'US',
            self::AMERICA_ANCHORAGE => 'US',
            self::AMERICA_JUNEAU => 'US',
            self::AMERICA_SITKA => 'US',
            self::AMERICA_METLAKATLA => 'US',
            self::AMERICA_YAKUTAT => 'US',
            self::AMERICA_NOME => 'US',
            self::AMERICA_ADAK => 'US',
            self::PACIFIC_HONOLULU => 'US',
            self::ASIA_SAMARKAND => 'UZ',
            self::ASIA_TASHKENT => 'UZ',
            self::EUROPE_VATICAN => 'VA',
            self::AMERICA_ST_VINCENT => 'VC',
            self::AMERICA_CARACAS => 'VE',
            self::AMERICA_TORTOLA => 'VG',
            self::AMERICA_ST_THOMAS => 'VI',
            self::ASIA_HO_CHI_MINH => 'VN',
            self::PACIFIC_EFATE => 'VU',
            self::PACIFIC_WALLIS => 'WF',
            self::PACIFIC_APIA => 'WS',
            self::ASIA_ADEN => 'YE',
            self::AFRICA_JOHANNESBURG => 'ZA',
            self::AFRICA_LUSAKA => 'ZM',
            self::AFRICA_HARARE => 'ZW',
        ];

        return \array_key_exists($this->name(), $mapping)
            ? $mapping[$this->name()]
            : null;
    }
}
