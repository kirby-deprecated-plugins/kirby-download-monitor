<?php

  global $site;
  $site = site();

return array(
  "title" => "Download Monitor",
  "options" => array(
      array(
        "text" => "Edit",
        "icon" => "pencil",
        "link" => "pages/downloads/edit"
      ),
      array(
        "text" => "Details",
        "icon" => "search",
        "link" => $site->url() . "/downloads/?stats=true"
      )
    ),
  "html" => function() {

  $downloads = yaml(page("downloads")->downloads());
  $i = 0;
  $output = "";

    foreach($downloads as $download):

      $i++;
      $counter = "../content/downloads/stats/" . $download["download_id"] . ".cnt.txt";

        if (!file_exists($counter)) {

          $count = "not available";

        } else {

          $count = file_get_contents($counter);

/* Correct the initial count */

            if($count < $download["download_cnt"]) {
              $count = $download["download_cnt"] . " <span class=\"corrected\">(corrected)</span>";
            }

        }

    $output .= "<tr><td>" . $download["download_id"] . "</td>";
    $output .= "<td><em>#</em><b>" . $count . "</b></td></tr>";
    endforeach;

    if($i < 1) {
      $output = "<tr><td><span>No downloads available</span></td>";
    }

  	return  "<style>
              #downloads-widget td {
                padding: 0 .75em .25em 0;
              }

              #downloads-widget td:first-of-type {
                min-width: 6em;
              }

              #downloads-widget table span {
                color: #999;
              }

              #downloads-widget table em {
                color: #bbb;
                font-style: normal;
              }

              #downloads-widget .corrected {
                font-size: .75em;
                font-weight: normal;
                text-transform: uppercase;
              }
            </style>".
            "<table class=\"downloads\">" .
             $output .
            "</table>";
    }
);

?>