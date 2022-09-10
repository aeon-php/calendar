<?php

declare(strict_types=1);

namespace Aeon\Calendar\Gregorian;

use Aeon\Calendar\Exception\InvalidArgumentException;
use Aeon\Calendar\Gregorian\TimeZone\TimeOffset;
use Aeon\Calendar\TimeUnit;

/**
 * @method static self africaAbidjan()
 * @method static self africaAccra()
 * @method static self africaAddisAbaba()
 * @method static self africaAlgiers()
 * @method static self africaAsmara()
 * @method static self africaBamako()
 * @method static self africaBangui()
 * @method static self africaBanjul()
 * @method static self africaBissau()
 * @method static self africaBlantyre()
 * @method static self africaBrazzaville()
 * @method static self africaBujumbura()
 * @method static self africaCairo()
 * @method static self africaCasablanca()
 * @method static self africaCeuta()
 * @method static self africaConakry()
 * @method static self africaDakar()
 * @method static self africaDarEsSalaam()
 * @method static self africaDjibouti()
 * @method static self africaDouala()
 * @method static self africaElAaiun()
 * @method static self africaFreetown()
 * @method static self africaGaborone()
 * @method static self africaHarare()
 * @method static self africaJohannesburg()
 * @method static self africaJuba()
 * @method static self africaKampala()
 * @method static self africaKhartoum()
 * @method static self africaKigali()
 * @method static self africaKinshasa()
 * @method static self africaLagos()
 * @method static self africaLibreville()
 * @method static self africaLome()
 * @method static self africaLuanda()
 * @method static self africaLubumbashi()
 * @method static self africaLusaka()
 * @method static self africaMalabo()
 * @method static self africaMaputo()
 * @method static self africaMaseru()
 * @method static self africaMbabane()
 * @method static self africaMogadishu()
 * @method static self africaMonrovia()
 * @method static self africaNairobi()
 * @method static self africaNdjamena()
 * @method static self africaNiamey()
 * @method static self africaNouakchott()
 * @method static self africaOuagadougou()
 * @method static self africaPortoNovo()
 * @method static self africaSaoTome()
 * @method static self africaTripoli()
 * @method static self africaTunis()
 * @method static self africaWindhoek()
 * @method static self americaAdak()
 * @method static self americaAnchorage()
 * @method static self americaAnguilla()
 * @method static self americaAntigua()
 * @method static self americaAraguaina()
 * @method static self americaArgentinaBuenosAires()
 * @method static self americaArgentinaCatamarca()
 * @method static self americaArgentinaCordoba()
 * @method static self americaArgentinaJujuy()
 * @method static self americaArgentinaLaRioja()
 * @method static self americaArgentinaMendoza()
 * @method static self americaArgentinaRioGallegos()
 * @method static self americaArgentinaSalta()
 * @method static self americaArgentinaSanJuan()
 * @method static self americaArgentinaSanLuis()
 * @method static self americaArgentinaTucuman()
 * @method static self americaArgentinaUshuaia()
 * @method static self americaAruba()
 * @method static self americaAsuncion()
 * @method static self americaAtikokan()
 * @method static self americaBahia()
 * @method static self americaBahiaBanderas()
 * @method static self americaBarbados()
 * @method static self americaBelem()
 * @method static self americaBelize()
 * @method static self americaBlancSablon()
 * @method static self americaBoaVista()
 * @method static self americaBogota()
 * @method static self americaBoise()
 * @method static self americaCambridgeBay()
 * @method static self americaCampoGrande()
 * @method static self americaCancun()
 * @method static self americaCaracas()
 * @method static self americaCayenne()
 * @method static self americaCayman()
 * @method static self americaChicago()
 * @method static self americaChihuahua()
 * @method static self americaCostaRica()
 * @method static self americaCreston()
 * @method static self americaCuiaba()
 * @method static self americaCuracao()
 * @method static self americaDanmarkshavn()
 * @method static self americaDawson()
 * @method static self americaDawsonCreek()
 * @method static self americaDenver()
 * @method static self americaDetroit()
 * @method static self americaDominica()
 * @method static self americaEdmonton()
 * @method static self americaEirunepe()
 * @method static self americaElSalvador()
 * @method static self americaFortNelson()
 * @method static self americaFortaleza()
 * @method static self americaGlaceBay()
 * @method static self americaGooseBay()
 * @method static self americaGrandTurk()
 * @method static self americaGrenada()
 * @method static self americaGuadeloupe()
 * @method static self americaGuatemala()
 * @method static self americaGuayaquil()
 * @method static self americaGuyana()
 * @method static self americaHalifax()
 * @method static self americaHavana()
 * @method static self americaHermosillo()
 * @method static self americaIndianaIndianapolis()
 * @method static self americaIndianaKnox()
 * @method static self americaIndianaMarengo()
 * @method static self americaIndianaPetersburg()
 * @method static self americaIndianaTellCity()
 * @method static self americaIndianaVevay()
 * @method static self americaIndianaVincennes()
 * @method static self americaIndianaWinamac()
 * @method static self americaInuvik()
 * @method static self americaIqaluit()
 * @method static self americaJamaica()
 * @method static self americaJuneau()
 * @method static self americaKentuckyLouisville()
 * @method static self americaKentuckyMonticello()
 * @method static self americaKralendijk()
 * @method static self americaLaPaz()
 * @method static self americaLima()
 * @method static self americaLosAngeles()
 * @method static self americaLowerPrinces()
 * @method static self americaMaceio()
 * @method static self americaManagua()
 * @method static self americaManaus()
 * @method static self americaMarigot()
 * @method static self americaMartinique()
 * @method static self americaMatamoros()
 * @method static self americaMazatlan()
 * @method static self americaMenominee()
 * @method static self americaMerida()
 * @method static self americaMetlakatla()
 * @method static self americaMexicoCity()
 * @method static self americaMiquelon()
 * @method static self americaMoncton()
 * @method static self americaMonterrey()
 * @method static self americaMontevideo()
 * @method static self americaMontserrat()
 * @method static self americaNassau()
 * @method static self americaNewYork()
 * @method static self americaNipigon()
 * @method static self americaNome()
 * @method static self americaNoronha()
 * @method static self americaNorthDakotaBeulah()
 * @method static self americaNorthDakotaCenter()
 * @method static self americaNorthDakotaNewSalem()
 * @method static self americaNuuk()
 * @method static self americaOjinaga()
 * @method static self americaPanama()
 * @method static self americaPangnirtung()
 * @method static self americaParamaribo()
 * @method static self americaPhoenix()
 * @method static self americaPortAuPrince()
 * @method static self americaPortOfSpain()
 * @method static self americaPortoVelho()
 * @method static self americaPuertoRico()
 * @method static self americaPuntaArenas()
 * @method static self americaRainyRiver()
 * @method static self americaRankinInlet()
 * @method static self americaRecife()
 * @method static self americaRegina()
 * @method static self americaResolute()
 * @method static self americaRioBranco()
 * @method static self americaSantarem()
 * @method static self americaSantiago()
 * @method static self americaSantoDomingo()
 * @method static self americaSaoPaulo()
 * @method static self americaScoresbysund()
 * @method static self americaSitka()
 * @method static self americaStBarthelemy()
 * @method static self americaStJohns()
 * @method static self americaStKitts()
 * @method static self americaStLucia()
 * @method static self americaStThomas()
 * @method static self americaStVincent()
 * @method static self americaSwiftCurrent()
 * @method static self americaTegucigalpa()
 * @method static self americaThule()
 * @method static self americaThunderBay()
 * @method static self americaTijuana()
 * @method static self americaToronto()
 * @method static self americaTortola()
 * @method static self americaVancouver()
 * @method static self americaWhitehorse()
 * @method static self americaWinnipeg()
 * @method static self americaYakutat()
 * @method static self americaYellowknife()
 * @method static self antarcticaCasey()
 * @method static self antarcticaDavis()
 * @method static self antarcticaDumontDUrville()
 * @method static self antarcticaMacquarie()
 * @method static self antarcticaMawson()
 * @method static self antarcticaMcMurdo()
 * @method static self antarcticaPalmer()
 * @method static self antarcticaRothera()
 * @method static self antarcticaSyowa()
 * @method static self antarcticaTroll()
 * @method static self antarcticaVostok()
 * @method static self arcticLongyearbyen()
 * @method static self asiaAden()
 * @method static self asiaAlmaty()
 * @method static self asiaAmman()
 * @method static self asiaAnadyr()
 * @method static self asiaAqtau()
 * @method static self asiaAqtobe()
 * @method static self asiaAshgabat()
 * @method static self asiaAtyrau()
 * @method static self asiaBaghdad()
 * @method static self asiaBahrain()
 * @method static self asiaBaku()
 * @method static self asiaBangkok()
 * @method static self asiaBarnaul()
 * @method static self asiaBeirut()
 * @method static self asiaBishkek()
 * @method static self asiaBrunei()
 * @method static self asiaChita()
 * @method static self asiaChoibalsan()
 * @method static self asiaColombo()
 * @method static self asiaDamascus()
 * @method static self asiaDhaka()
 * @method static self asiaDili()
 * @method static self asiaDubai()
 * @method static self asiaDushanbe()
 * @method static self asiaFamagusta()
 * @method static self asiaGaza()
 * @method static self asiaHebron()
 * @method static self asiaHoChiMinh()
 * @method static self asiaHongKong()
 * @method static self asiaHovd()
 * @method static self asiaIrkutsk()
 * @method static self asiaJakarta()
 * @method static self asiaJayapura()
 * @method static self asiaJerusalem()
 * @method static self asiaKabul()
 * @method static self asiaKamchatka()
 * @method static self asiaKarachi()
 * @method static self asiaKathmandu()
 * @method static self asiaKhandyga()
 * @method static self asiaKolkata()
 * @method static self asiaKrasnoyarsk()
 * @method static self asiaKualaLumpur()
 * @method static self asiaKuching()
 * @method static self asiaKuwait()
 * @method static self asiaMacau()
 * @method static self asiaMagadan()
 * @method static self asiaMakassar()
 * @method static self asiaManila()
 * @method static self asiaMuscat()
 * @method static self asiaNicosia()
 * @method static self asiaNovokuznetsk()
 * @method static self asiaNovosibirsk()
 * @method static self asiaOmsk()
 * @method static self asiaOral()
 * @method static self asiaPhnomPenh()
 * @method static self asiaPontianak()
 * @method static self asiaPyongyang()
 * @method static self asiaQatar()
 * @method static self asiaQostanay()
 * @method static self asiaQyzylorda()
 * @method static self asiaRiyadh()
 * @method static self asiaSakhalin()
 * @method static self asiaSamarkand()
 * @method static self asiaSeoul()
 * @method static self asiaShanghai()
 * @method static self asiaSingapore()
 * @method static self asiaSrednekolymsk()
 * @method static self asiaTaipei()
 * @method static self asiaTashkent()
 * @method static self asiaTbilisi()
 * @method static self asiaTehran()
 * @method static self asiaThimphu()
 * @method static self asiaTokyo()
 * @method static self asiaTomsk()
 * @method static self asiaUlaanbaatar()
 * @method static self asiaUrumqi()
 * @method static self asiaUstNera()
 * @method static self asiaVientiane()
 * @method static self asiaVladivostok()
 * @method static self asiaYakutsk()
 * @method static self asiaYangon()
 * @method static self asiaYekaterinburg()
 * @method static self asiaYerevan()
 * @method static self atlanticAzores()
 * @method static self atlanticBermuda()
 * @method static self atlanticCanary()
 * @method static self atlanticCapeVerde()
 * @method static self atlanticFaroe()
 * @method static self atlanticMadeira()
 * @method static self atlanticReykjavik()
 * @method static self atlanticSouthGeorgia()
 * @method static self atlanticStHelena()
 * @method static self atlanticStanley()
 * @method static self australiaAdelaide()
 * @method static self australiaBrisbane()
 * @method static self australiaBrokenHill()
 * @method static self australiaCurrie()
 * @method static self australiaDarwin()
 * @method static self australiaEucla()
 * @method static self australiaHobart()
 * @method static self australiaLindeman()
 * @method static self australiaLordHowe()
 * @method static self australiaMelbourne()
 * @method static self australiaPerth()
 * @method static self australiaSydney()
 * @method static self europeAmsterdam()
 * @method static self europeAndorra()
 * @method static self europeAstrakhan()
 * @method static self europeAthens()
 * @method static self europeBelgrade()
 * @method static self europeBerlin()
 * @method static self europeBratislava()
 * @method static self europeBrussels()
 * @method static self europeBucharest()
 * @method static self europeBudapest()
 * @method static self europeBusingen()
 * @method static self europeChisinau()
 * @method static self europeCopenhagen()
 * @method static self europeDublin()
 * @method static self europeGibraltar()
 * @method static self europeGuernsey()
 * @method static self europeHelsinki()
 * @method static self europeIsleOfMan()
 * @method static self europeIstanbul()
 * @method static self europeJersey()
 * @method static self europeKaliningrad()
 * @method static self europeKiev()
 * @method static self europeKirov()
 * @method static self europeLisbon()
 * @method static self europeLjubljana()
 * @method static self europeLondon()
 * @method static self europeLuxembourg()
 * @method static self europeMadrid()
 * @method static self europeMalta()
 * @method static self europeMariehamn()
 * @method static self europeMinsk()
 * @method static self europeMonaco()
 * @method static self europeMoscow()
 * @method static self europeOslo()
 * @method static self europeParis()
 * @method static self europePodgorica()
 * @method static self europePrague()
 * @method static self europeRiga()
 * @method static self europeRome()
 * @method static self europeSamara()
 * @method static self europeSanMarino()
 * @method static self europeSarajevo()
 * @method static self europeSaratov()
 * @method static self europeSimferopol()
 * @method static self europeSkopje()
 * @method static self europeSofia()
 * @method static self europeStockholm()
 * @method static self europeTallinn()
 * @method static self europeTirane()
 * @method static self europeUlyanovsk()
 * @method static self europeUzhgorod()
 * @method static self europeVaduz()
 * @method static self europeVatican()
 * @method static self europeVienna()
 * @method static self europeVilnius()
 * @method static self europeVolgograd()
 * @method static self europeWarsaw()
 * @method static self europeZagreb()
 * @method static self europeZaporozhye()
 * @method static self europeZurich()
 * @method static self indianAntananarivo()
 * @method static self indianChagos()
 * @method static self indianChristmas()
 * @method static self indianCocos()
 * @method static self indianComoro()
 * @method static self indianKerguelen()
 * @method static self indianMahe()
 * @method static self indianMaldives()
 * @method static self indianMauritius()
 * @method static self indianMayotte()
 * @method static self indianReunion()
 * @method static self pacificApia()
 * @method static self pacificAuckland()
 * @method static self pacificBougainville()
 * @method static self pacificChatham()
 * @method static self pacificChuuk()
 * @method static self pacificEaster()
 * @method static self pacificEfate()
 * @method static self pacificEnderbury()
 * @method static self pacificFakaofo()
 * @method static self pacificFiji()
 * @method static self pacificFunafuti()
 * @method static self pacificGalapagos()
 * @method static self pacificGambier()
 * @method static self pacificGuadalcanal()
 * @method static self pacificGuam()
 * @method static self pacificHonolulu()
 * @method static self pacificKiritimati()
 * @method static self pacificKosrae()
 * @method static self pacificKwajalein()
 * @method static self pacificMajuro()
 * @method static self pacificMarquesas()
 * @method static self pacificMidway()
 * @method static self pacificNauru()
 * @method static self pacificNiue()
 * @method static self pacificNorfolk()
 * @method static self pacificNoumea()
 * @method static self pacificPagoPago()
 * @method static self pacificPalau()
 * @method static self pacificPitcairn()
 * @method static self pacificPohnpei()
 * @method static self pacificPortMoresby()
 * @method static self pacificRarotonga()
 * @method static self pacificSaipan()
 * @method static self pacificTahiti()
 * @method static self pacificTarawa()
 * @method static self pacificTongatapu()
 * @method static self pacificWake()
 * @method static self pacificWallis()
 * @method static self ACDT()
 * @method static self ACST()
 * @method static self ADDT()
 * @method static self ADT()
 * @method static self AEDT()
 * @method static self AEST()
 * @method static self AHDT()
 * @method static self AHST()
 * @method static self AKDT()
 * @method static self AKST()
 * @method static self AMT()
 * @method static self APT()
 * @method static self AST()
 * @method static self AWDT()
 * @method static self AWST()
 * @method static self AWT()
 * @method static self BDST()
 * @method static self BDT()
 * @method static self BMT()
 * @method static self BST()
 * @method static self CAST()
 * @method static self CAT()
 * @method static self CDDT()
 * @method static self CDT()
 * @method static self CEMT()
 * @method static self CEST()
 * @method static self CET()
 * @method static self CMT()
 * @method static self CPT()
 * @method static self CST()
 * @method static self CWT()
 * @method static self CHST()
 * @method static self DMT()
 * @method static self EAT()
 * @method static self EDDT()
 * @method static self EDT()
 * @method static self EEST()
 * @method static self EET()
 * @method static self EMT()
 * @method static self EPT()
 * @method static self EST()
 * @method static self EWT()
 * @method static self FFMT()
 * @method static self FMT()
 * @method static self GDT()
 * @method static self GMT()
 * @method static self GST()
 * @method static self HDT()
 * @method static self HKST()
 * @method static self HKT()
 * @method static self HMT()
 * @method static self HPT()
 * @method static self HST()
 * @method static self HWT()
 * @method static self IDDT()
 * @method static self IDT()
 * @method static self IMT()
 * @method static self IST()
 * @method static self JDT()
 * @method static self JMT()
 * @method static self JST()
 * @method static self KDT()
 * @method static self KMT()
 * @method static self KST()
 * @method static self LST()
 * @method static self MDDT()
 * @method static self MDST()
 * @method static self MDT()
 * @method static self MEST()
 * @method static self MET()
 * @method static self MMT()
 * @method static self MPT()
 * @method static self MSD()
 * @method static self MSK()
 * @method static self MST()
 * @method static self MWT()
 * @method static self NDDT()
 * @method static self NDT()
 * @method static self NPT()
 * @method static self NST()
 * @method static self NWT()
 * @method static self NZDT()
 * @method static self NZMT()
 * @method static self NZST()
 * @method static self PDDT()
 * @method static self PDT()
 * @method static self PKST()
 * @method static self PKT()
 * @method static self PLMT()
 * @method static self PMT()
 * @method static self PPMT()
 * @method static self PPT()
 * @method static self PST()
 * @method static self PWT()
 * @method static self QMT()
 * @method static self RMT()
 * @method static self SAST()
 * @method static self SDMT()
 * @method static self SJMT()
 * @method static self SMT()
 * @method static self SST()
 * @method static self TBMT()
 * @method static self TMT()
 * @method static self UCT()
 * @method static self WAST()
 * @method static self WAT()
 * @method static self WEMT()
 * @method static self WEST()
 * @method static self WET()
 * @method static self WIB()
 * @method static self WITA()
 * @method static self WIT()
 * @method static self WMT()
 * @method static self YDDT()
 * @method static self YDT()
 * @method static self YPT()
 * @method static self YST()
 * @method static self YWT()
 *
 * @psalm-immutable
 */
final class TimeZone
{
    private const TYPE_OFFSET = 1;

    private const TYPE_ABBREVIATION = 2;

    private const TYPE_IDENTIFIER = 3;

    private string $name;

    private int $type;

    private function __construct(string $name, int $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @throws InvalidArgumentException
     *
     * @psalm-pure
     */
    public static function UTC() : self
    {
        return self::abbreviation('UTC');
    }

    /**
     * @psalm-suppress PossiblyFalseIterator
     *
     * @psalm-pure
     */
    public static function id(string $identifier) : self
    {
        $normalized = \strtolower($identifier);

        if ($normalized === 'utc') {
            throw new InvalidArgumentException('"UTC" is timezone abbreviation, not identifier.');
        }

        /** @var string $dateTimeZoneIdentifier */
        foreach (\DateTimeZone::listIdentifiers() as $dateTimeZoneIdentifier) {
            $normalizedDateTimeZoneIdentifier = \strtolower($dateTimeZoneIdentifier);

            if (\strtolower($dateTimeZoneIdentifier) === $normalized) {
                return new self($dateTimeZoneIdentifier, self::TYPE_IDENTIFIER);
            }

            if (\str_replace(['/', '_'], '', $normalizedDateTimeZoneIdentifier) === $normalized) {
                return new self($dateTimeZoneIdentifier, self::TYPE_IDENTIFIER);
            }
        }

        throw new InvalidArgumentException("\"{$identifier}\" is not a valid timezone identifier.");
    }

    /**
     * @psalm-suppress PossiblyFalseArgument
     *
     * @psalm-pure
     */
    public static function abbreviation(string $abbreviation) : self
    {
        $normalized = \strtoupper($abbreviation);

        /**
         * @var string $dateTimeZoneAbbreviation
         */
        foreach (\array_keys(\DateTimeZone::listAbbreviations()) as $dateTimeZoneAbbreviation) {
            if (\strtoupper($dateTimeZoneAbbreviation) === $normalized) {
                return new self(\strtoupper($dateTimeZoneAbbreviation), self::TYPE_ABBREVIATION);
            }
        }

        throw new InvalidArgumentException("\"{$abbreviation}\" is not a valid timezone abbreviation.");
    }

    /**
     * @psalm-pure
     */
    public static function offset(string $offset) : self
    {
        if (!TimeOffset::isValid($offset)) {
            throw new InvalidArgumentException("\"{$offset}\" is not a valid time offset.");
        }

        return new self(TimeOffset::fromString($offset)->toString(), self::TYPE_OFFSET);
    }

    /**
     * @psalm-pure
     */
    public static function fromString(string $name) : self
    {
        try {
            return self::id($name);
        } catch (InvalidArgumentException $identifierException) {
            try {
                return self::abbreviation($name);
            } catch (InvalidArgumentException $abbreviationException) {
                try {
                    return self::offset($name);
                } catch (InvalidArgumentException $offsetException) {
                    throw new InvalidArgumentException("\"{$name}\" is not a valid time zone.");
                }
            }
        }
    }

    /**
     * @psalm-pure
     */
    public static function isValid(string $name) : bool
    {
        try {
            new \DateTimeZone($name);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @psalm-pure
     */
    public static function fromDateTimeZone(\DateTimeZone $dateTimeZone) : self
    {
        $name = $dateTimeZone->getName();
        $type = self::TYPE_IDENTIFIER;

        if ($name === 'UTC') {
            $type = self::TYPE_ABBREVIATION;
        }

        if (TimeOffset::isValid($name)) {
            $type = self::TYPE_OFFSET;
        }

        if (\timezone_name_from_abbr($name) !== false) {
            $type = self::TYPE_ABBREVIATION;
        }

        return new self($name, $type);
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress PossiblyFalseArgument
     *
     * @return array<TimeZone>
     */
    public static function allIdentifiers() : array
    {
        return \array_map(
            fn (string $identifier) : self => self::id($identifier),
            \array_filter(\DateTimeZone::listIdentifiers(), fn (string $identifier) : bool => $identifier !== 'UTC')
        );
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress PossiblyFalseArgument
     *
     * @return array<TimeZone>
     */
    public static function allAbbreviations() : array
    {
        /** @var array<string> $abbreviations */
        $abbreviations = \array_keys(\DateTimeZone::listAbbreviations());

        return \array_map(
            fn (string $abbreviation) : self => self::abbreviation($abbreviation),
            \array_filter($abbreviations, fn (string $abbreviation) : bool => \strlen($abbreviation) > 1)
        );
    }

    /**
     * @param string $name
     * @param array<mixed> $arguments
     *
     * @psalm-pure
     */
    public static function __callStatic(string $name, array $arguments) : self
    {
        try {
            return self::id($name);
        } catch (InvalidArgumentException $identifierException) {
            try {
                return self::abbreviation($name);
            } catch (InvalidArgumentException $abbreviationException) {
                throw new InvalidArgumentException("\"{$name}\" is not a valid time zone identifier or abbreviation.");
            }
        }
    }

    /**
     * @return array{name: string, type: int}
     */
    public function __serialize() : array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
        ];
    }

    /**
     * @param array{name: string, type: int} $data
     */
    public function __unserialize(array $data) : void
    {
        $this->name = $data['name'];
        $this->type = $data['type'];
    }

    public function isOffset() : bool
    {
        return $this->type === self::TYPE_OFFSET;
    }

    public function isAbbreviation() : bool
    {
        return $this->type === self::TYPE_ABBREVIATION;
    }

    public function isIdentifier() : bool
    {
        return $this->type === self::TYPE_IDENTIFIER;
    }

    public function toDateTimeZone() : \DateTimeZone
    {
        return new \DateTimeZone($this->name);
    }

    public function name() : string
    {
        return $this->name;
    }

    /**
     * Offset depends on date because daylight & saving time will have it different and
     * the only way to get it is to take it from date time.
     */
    public function timeOffset(DateTime $dateTime) : TimeOffset
    {
        return TimeOffset::fromTimeUnit(TimeUnit::seconds($this->toDateTimeZone()->getOffset($dateTime->toDateTimeImmutable())));
    }
}
