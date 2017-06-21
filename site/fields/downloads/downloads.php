<?php

class DownloadsField extends BaseField {

  static public $assets = array(
    "css" => array("downloads.css"),
    "js" => array("downloads.js")
  );

  public function content() {
    $kirby = kirby();
    $site  = $kirby->site();
    return "<script data-field=\"downloadsfield\">var download_base = \"" . $site->url() . "/downloads/?id=\";</script>";
  }

  public function element() {
    $element = parent::element();
    $element->addClass("field-downloads");
    return $element;
  }
}

?>