<?php

$remote_access = 1;

$localhost = true;

$localhost_ip = array (
  "127.0.0.1",
  "::1"
);

if(!in_array($_SERVER["REMOTE_ADDR"], $localhost_ip)){
  $localhost = false;
}

if($localhost) {
  $remote_access = 0;
}

/* ------------------------------------------------------------- */

$date = date("l, jS \of F Y - H:i:s");
$server = gethostname();
$domain = $_SERVER["HTTP_HOST"]." / ".$_SERVER["SERVER_NAME"];
$ip = $_SERVER["REMOTE_ADDR"];
$system = $_SERVER["HTTP_USER_AGENT"];
$lang_code = isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ? $_SERVER["HTTP_ACCEPT_LANGUAGE"] : "";


  if(strpos($lang_code,",") > 1) {
    $lang_code = substr($lang_code,0,strpos($lang_code,","));
  }

$provider = gethostbyaddr(getenv("REMOTE_ADDR"));

  if(empty($provider)) {
    $provider = "(unknown)";
  }

/* ------------------------------------------------------------- */

$languages = array("Afrikaans|af","Albanian|sq","Arabic (Algeria)|ar-dz","Arabic (Bahrain)|ar-bh","Arabic (Egypt)|ar-eg","Arabic (Iraq)|ar-iq","Arabic (Jordan)|ar-jo","Arabic (Kuwait)|ar-kw","Arabic (Lebanon)|ar-lb","Arabic (libya)|ar-ly","Arabic (Morocco)|ar-ma","Arabic (Oman)|ar-om","Arabic (Qatar)|ar-qa","Arabic (Saudi Arabia)|ar-sa","Arabic (Syria)|ar-sy","Arabic (Tunisia)|ar-tn","Arabic (U.A.E.)|ar-ae","Arabic (Yemen)|ar-ye","Arabic|ar","Armenian|hy","Assamese|as","Azeri (Cyrillic)|az","Azeri (Latin)|az","Basque|eu","Belarusian|be","Bengali|bn","Bulgarian|bg","Catalan|ca","Chinese (China)|zh-cn","Chinese (Hong Kong SAR)|zh-hk","Chinese (Macau SAR)|zh-mo","Chinese (Singapore)|zh-sg","Chinese (Taiwan)|zh-tw","Chinese|zh","Croatian|hr","Chech|cs","Danish|da","Divehi|div","Dutch (Belgium)|nl-be","Dutch (Netherlands)|nl","Dutch (Netherlands)|nl-nl","English (Australia)|en-au","English (Belize)|en-bz","English (Canada)|en-ca","English (Caribbean)|en","English (Ireland)|en-ie","English (Jamaica)|en-jm","English (New Zealand)|en-nz","English (Philippines)|en-ph","English (South Africa)|en-za","English (Trinidad)|en-tt","English (United Kingdom)|en-gb","English (United States)|en-us","English (Zimbabwe)|en-zw","English|en","Estonian|et","Faeroese|fo","Farsi|fa","Finnish|fi","French (Belgium)|fr-be","French (Canada)|fr-ca","French (France)|fr","French (Luxembourg)|fr-lu","French (Monaco)|fr-mc","French (Switzerland)|fr-ch","FYRO Macedonian|mk","Gaelic|gd","Georgian|ka","German (Austria)|de-at","German (Germany)|de","German (Liechtenstein)|de-li","German (lexumbourg)|de-lu","German (Switzerland)|de-ch","Greek|el","Gujarati|gu","Hebrew|he","Hindi|hi","Hungarian|hu","Icelandic|is","Indonesian|id","Italian (Italy)|it","Italian (Switzerland)|it-ch","Japanese|ja","Kannada|kn","Kazakh|kk","Konkani|kok","Korean|ko","Kyrgyz|kz","Latvian|lv","Lithuanian|lt","Malay (Brunei)|ms","Malay (Malaysia)|ms","Malayalam|ml","Maltese|mt","Marathi|mr","Mongolian (Cyrillic)|mn","Nepali (India)|ne","Norwegian (Bokmal)|nb-no","Norwegian (Bokmal)|no","Norwegian (Nynorsk)|nn-no","Oriya|or","Polish|pl","Portuguese (Brazil)|pt-br","Portuguese (Portugal)|pt","Punjabi|pa","Rhaeto-Romanic|rm","Romanian (Moldova)|ro-md","Romanian|ro","Russian (Moldova)|ru-md","Russian|ru","Sanskrit|sa","Serbian (Cyrillic)|sr","Serbian (Latin)|sr","Slovak|sk","Slovenian|ls","Sorbian|sb","Spanish (Argentina)|es-ar","Spanish (Bolivia)|es-bo","Spanish (Chile)|es-cl","Spanish (Colombia)|es-co","Spanish (Costa Rica)|es-cr","Spanish (Dominican Republic)|es-do","Spanish (Ecuador)|es-ec","Spanish (El Salvador)|es-sv","Spanish (Guatemala)|es-gt","Spanish (Honduras)|es-hn","Spanish (International Sort)|es","Spanish (Mexico)|es-mx","Spanish (Nicaragua)|es-ni","Spanish (Panama)|es-pa","Spanish (Paraguay)|es-py","Spanish (Peru)|es-pe","Spanish (Puerto Rico)|es-pr","Spanish (Traditional Sort)|es","Spanish (United States)|es-us","Spanish (Uruguay)|es-uy","Spanish (Venezuela)|es-ve","Sutu|sx","Swahili|sw","Swedish (Finland)|sv-fi","Swedish|sv","Syriac|syr","Tamil|ta","Tatar|tt","Telugu|te","Thai|th","Tsonga|ts","Tswana|tn","Turkish|tr","Ukrainian|uk","Urdu|ur","Uzbek (Cyrillic)|uz","Uzbek (Latin)|uz","Vietnamese|vi","Xhosa|xh","Yiddish|yi","Zulu|zu");

  for($i=0;$i<count($languages);$i++) {
    $language_tmp = substr($languages[$i],strpos($languages[$i],"|")+1);

    if(strtolower($lang_code) == $language_tmp) {
      $language = substr($languages[$i],0,strpos($languages[$i],"|"));
    }
  }

  if(empty($language)) {
    $language = "(unknown)";
  }

/* ------------------------------------------------------------- */

if($remote_access) {

$geoplugin = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=" . $ip));

  if (is_numeric($geoplugin["geoplugin_latitude"]) && is_numeric($geoplugin["geoplugin_longitude"])) {
    $lat = $geoplugin["geoplugin_latitude"];
    $long = $geoplugin["geoplugin_longitude"];
    $country = $geoplugin["geoplugin_countryName"];
    $region = $geoplugin["geoplugin_region"];
    $city = $geoplugin["geoplugin_city"];
  }

}

/* ------------------------------------------------------------- */

$blueprint  = "" ;
$blueprint .= "Date       : " . $date . chr(10);
$blueprint .= "IP-address : " . $ip . chr(10);

  if($remote_access) {
    $blueprint .= "Map        : https://www.google.nl/maps/place//@" . $lat . "," . $long . ",14z/" . chr(10);
    $blueprint .= "Country    : " . $country . chr(10);
    $blueprint .= "Region     : " . $region . chr(10);
    $blueprint .= "City       : " . $city . chr(10);
  } else {
    $blueprint .= "Map        : (not available)" . chr(10);
     $blueprint .= "Country    : (not available)" . chr(10);
    $blueprint .= "Region     : (not available)" . chr(10);
    $blueprint .= "City       : (not available)" . chr(10);
  }

$blueprint .= "System     : " . $system . chr(10);
$blueprint .= "Language   : " . strtoupper($lang_code) . " / " . $language . chr(10);
$blueprint .= "Provider   : " . $provider . chr(10);
$blueprint .= "Server     : " . $server . chr(10);
$blueprint .= "Domain     : ".$domain . chr(10);
$blueprint .= "------------------------------------------------------------------" . chr(10);

?>