<?php

if (!defined('BASEPATH'))
        exit('No direct script access allowed');

require_once 'libphonenumber/PhoneNumberUtil.php';
require_once 'libphonenumber/ShortNumberUtil.php';
require_once 'libphonenumber/geocoding/PhoneNumberOfflineGeocoder.php';
require_once 'libphonenumber/CountryCodeToRegionCodeMap.php';
require_once 'libphonenumber/MetadataLoaderInterface.php';
require_once 'libphonenumber/DefaultMetadataLoader.php';
require_once 'libphonenumber/Matcher.php';
require_once 'libphonenumber/PhoneNumber.php';
require_once 'libphonenumber/PhoneMetadata.php';
require_once 'libphonenumber/PhoneNumberDesc.php';
require_once 'libphonenumber/NumberFormat.php';
require_once 'libphonenumber/CountryCodeSource.php';
require_once 'libphonenumber/ValidationResult.php';
require_once 'libphonenumber/PhoneNumberType.php';
require_once 'libphonenumber/PhoneNumberToCarrierMapper.php';
 

class Fone extends \libphonenumber\PhoneNumberUtil
{

        function __construct()
        {
                //parent::__construct();
        }
 
}

/* End of file Fone.php */
/* Location: ./application/libraries/Fval.php */