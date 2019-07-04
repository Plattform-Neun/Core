<?php

namespace Marktstand\Payment;

use Marktstand\Exceptions\InvalidArgumentException;

class BankAccountNumber
{
    const FORMATS = [
        'AD' => 'AD\d{2}\d{4}\d{4}[\dA-Z]{12}',
        'AE' => 'AE\d{2}\d{3}\d{16}',
        'AL' => 'AL\d{2}\d{8}[\dA-Z]{16}',
        'AO' => 'AO\d{2}\d{21}',
        'AT' => 'AT\d{2}\d{5}\d{11}',
        'AX' => 'FI\d{2}\d{6}\d{7}\d{1}',
        'AZ' => 'AZ\d{2}[A-Z]{4}[\dA-Z]{20}',
        'BA' => 'BA\d{2}\d{3}\d{3}\d{8}\d{2}',
        'BE' => 'BE\d{2}\d{3}\d{7}\d{2}',
        'BF' => 'BF\d{2}\d{23}',
        'BG' => 'BG\d{2}[A-Z]{4}\d{4}\d{2}[\dA-Z]{8}',
        'BH' => 'BH\d{2}[A-Z]{4}[\dA-Z]{14}',
        'BI' => 'BI\d{2}\d{12}',
        'BJ' => 'BJ\d{2}[A-Z]{1}\d{23}',
        'BY' => 'BY\d{2}[\dA-Z]{4}\d{4}[\dA-Z]{16}',
        'BL' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'BR' => 'BR\d{2}\d{8}\d{5}\d{10}[A-Z][\dA-Z]',
        'CG' => 'CG\d{2}\d{23}',
        'CH' => 'CH\d{2}\d{5}[\dA-Z]{12}',
        'CI' => 'CI\d{2}[A-Z]{1}\d{23}',
        'CM' => 'CM\d{2}\d{23}',
        'CR' => 'CR\d{2}0\d{3}\d{14}',
        'CV' => 'CV\d{2}\d{21}',
        'CY' => 'CY\d{2}\d{3}\d{5}[\dA-Z]{16}',
        'CZ' => 'CZ\d{2}\d{20}',
        'DE' => 'DE\d{2}\d{8}\d{10}',
        'DO' => 'DO\d{2}[\dA-Z]{4}\d{20}',
        'DK' => 'DK\d{2}\d{4}\d{10}',
        'DZ' => 'DZ\d{2}\d{20}',
        'EE' => 'EE\d{2}\d{2}\d{2}\d{11}\d{1}',
        'ES' => 'ES\d{2}\d{4}\d{4}\d{1}\d{1}\d{10}',
        'FI' => 'FI\d{2}\d{6}\d{7}\d{1}',
        'FO' => 'FO\d{2}\d{4}\d{9}\d{1}',
        'FR' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'GF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'GB' => 'GB\d{2}[A-Z]{4}\d{6}\d{8}',
        'GE' => 'GE\d{2}[A-Z]{2}\d{16}',
        'GI' => 'GI\d{2}[A-Z]{4}[\dA-Z]{15}',
        'GL' => 'GL\d{2}\d{4}\d{9}\d{1}',
        'GP' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'GR' => 'GR\d{2}\d{3}\d{4}[\dA-Z]{16}',
        'GT' => 'GT\d{2}[\dA-Z]{4}[\dA-Z]{20}',
        'HR' => 'HR\d{2}\d{7}\d{10}',
        'HU' => 'HU\d{2}\d{3}\d{4}\d{1}\d{15}\d{1}',
        'IE' => 'IE\d{2}[A-Z]{4}\d{6}\d{8}',
        'IL' => 'IL\d{2}\d{3}\d{3}\d{13}',
        'IR' => 'IR\d{2}\d{22}',
        'IS' => 'IS\d{2}\d{4}\d{2}\d{6}\d{10}',
        'IT' => 'IT\d{2}[A-Z]{1}\d{5}\d{5}[\dA-Z]{12}',
        'JO' => 'JO\d{2}[A-Z]{4}\d{4}[\dA-Z]{18}',
        'KW' => 'KW\d{2}[A-Z]{4}\d{22}',
        'KZ' => 'KZ\d{2}\d{3}[\dA-Z]{13}',
        'LB' => 'LB\d{2}\d{4}[\dA-Z]{20}',
        'LI' => 'LI\d{2}\d{5}[\dA-Z]{12}',
        'LT' => 'LT\d{2}\d{5}\d{11}',
        'LU' => 'LU\d{2}\d{3}[\dA-Z]{13}',
        'LV' => 'LV\d{2}[A-Z]{4}[\dA-Z]{13}',
        'MC' => 'MC\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'MD' => 'MD\d{2}[\dA-Z]{2}[\dA-Z]{18}',
        'ME' => 'ME\d{2}\d{3}\d{13}\d{2}',
        'MF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'MG' => 'MG\d{2}\d{23}',
        'MK' => 'MK\d{2}\d{3}[\dA-Z]{10}\d{2}',
        'ML' => 'ML\d{2}[A-Z]{1}\d{23}',
        'MQ' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'MR' => 'MR13\d{5}\d{5}\d{11}\d{2}',
        'MT' => 'MT\d{2}[A-Z]{4}\d{5}[\dA-Z]{18}',
        'MU' => 'MU\d{2}[A-Z]{4}\d{2}\d{2}\d{12}\d{3}[A-Z]{3}',
        'MZ' => 'MZ\d{2}\d{21}',
        'NC' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'NL' => 'NL\d{2}[A-Z]{4}\d{10}',
        'NO' => 'NO\d{2}\d{4}\d{6}\d{1}',
        'PF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'PK' => 'PK\d{2}[A-Z]{4}[\dA-Z]{16}',
        'PL' => 'PL\d{2}\d{8}\d{16}',
        'PM' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'PS' => 'PS\d{2}[A-Z]{4}[\dA-Z]{21}',
        'PT' => 'PT\d{2}\d{4}\d{4}\d{11}\d{2}',
        'QA' => 'QA\d{2}[A-Z]{4}[\dA-Z]{21}',
        'RE' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'RO' => 'RO\d{2}[A-Z]{4}[\dA-Z]{16}',
        'RS' => 'RS\d{2}\d{3}\d{13}\d{2}',
        'SA' => 'SA\d{2}\d{2}[\dA-Z]{18}',
        'SE' => 'SE\d{2}\d{3}\d{16}\d{1}',
        'SI' => 'SI\d{2}\d{5}\d{8}\d{2}',
        'SK' => 'SK\d{2}\d{4}\d{6}\d{10}',
        'SM' => 'SM\d{2}[A-Z]{1}\d{5}\d{5}[\dA-Z]{12}',
        'SN' => 'SN\d{2}[A-Z]{1}\d{23}',
        'TF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'TL' => 'TL\d{2}\d{3}\d{14}\d{2}',
        'TN' => 'TN59\d{2}\d{3}\d{13}\d{2}',
        'TR' => 'TR\d{2}\d{5}[\dA-Z]{1}[\dA-Z]{16}',
        'UA' => 'UA\d{2}\d{6}[\dA-Z]{19}',
        'VA' => 'VA\d{2}\d{3}\d{15}',
        'VG' => 'VG\d{2}[A-Z]{4}\d{16}',
        'WF' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
        'XK' => 'XK\d{2}\d{4}\d{10}\d{2}',
        'YT' => 'FR\d{2}\d{5}\d{5}[\dA-Z]{11}\d{2}',
    ];

    /**
     * @var string
     */
    private $iban;

    /**
     * Create a new bank account instance.
     */
    public function __construct(string $iban)
    {
        $this->iban = $this->canonicalize($iban);

        $this->validate();
    }

    /**
     * Get the country code.
     *
     * @return string
     */
    public function countryCode()
    {
        return substr($this->iban, 0, 2);
    }

    /**
     * Get the iban.
     *
     * @return string
     */
    public function iban()
    {
        return $this->iban;
    }

    /**
     * Get the last four digits.
     *
     * @return string
     */
    public function lastFour()
    {
        return substr($this->iban, -4);
    }

    /**
     * Canonicalize the given value.
     *
     * @param string $iban
     *
     * @return string
     */
    protected function canonicalize($iban)
    {
        return str_replace(' ', '', strtoupper($iban));
    }

    /**
     * Get the matching regular expression format.
     *
     * @return string
     */
    protected function format()
    {
        return self::FORMATS[$this->countryCode()];
    }

    /**
     * Validate the given value.
     *
     * @return void
     */
    protected function validate()
    {
        if (!ctype_alnum($this->iban)) {
            throw new InvalidArgumentException('Invalid Characters');
        }

        if (!array_key_exists($this->countryCode(), self::FORMATS)) {
            throw new InvalidArgumentException('Invalid Country Code');
        }

        if (!preg_match('/^'.$this->format().'$/', $this->iban)) {
            throw new InvalidArgumentException('Invalid Format');
        }
    }

    /**
     * Cast the object to an reinitialisable string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->iban();
    }
}
