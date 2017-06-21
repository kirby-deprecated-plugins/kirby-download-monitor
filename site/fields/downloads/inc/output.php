<?php

if ($user = $site->user() && filter_input(INPUT_GET, "stats", FILTER_SANITIZE_URL) === "true") {

/* ------------------------------------------------------------- */
/* User is logged in, show the stats */
/* ------------------------------------------------------------- */

  echo "<header class=\"topbar\">Dashboard | Download Monitor</header>";
  echo "<div id=\"downloads_wrapper\" class=\"text\">";

  $downloads = yaml($page->downloads());
  $i = 0;

    foreach($downloads as $download):

      $i++;
      $counter = "content/downloads/stats/" . $download["download_id"] . ".cnt.txt";

        if (!file_exists($counter)) {

          $count = "not available";

        } else {

          $count = file_get_contents($counter);

/* Correct the initial count */

          if($count < $download["download_cnt"]) {
            $count = $download["download_cnt"] . " <span class=\"corrected\">(corrected)</span>";
          }
        }

      echo "<ul><li><h3>" . $download["download_id"] . " <span title=\"number of downloads\">#" . $count . "</span></h3></li>";

      echo "<li><i class=\"fa fa-file\" title=\"file\"></i> <a href=\"" . $page->file($download["download_source"])->url() . "\" title=\"view this download\">" . $page->file($download["download_source"])->url() . "</a></li>";

      echo "<li><i class=\"fa fa-link\" title=\"link\"></i> <a href=\"" . $download["download_link"] . "\" title=\"trigger this download\">" . $download["download_link"] . "</a></li>";
      echo "<li><i class=\"fa fa-calendar\" title=\"date added\"></i> " . $download["download_date"] . "</li>";

      $download_force = $download["download_force"] == 1 ? "<b>forced</b>" : "default";
      echo "<li><i class=\"fa fa-download\" title=\"force download\"></i> " . $download_force . "</li>";

        if($download["download_log"] == 1) {

          $logfile = "content/downloads/stats/" . $download["download_id"] . ".log.txt";

            if (!file_exists($logfile)) {

              $logdata = "not available";

            } else {

              $logdata = file_get_contents($logfile);

            }

          $log = "<li><textarea class=\"input hidden\" id=\"logfile_" . $i . "\">" . $logdata . "</textarea></li>";

        } else {

          $log = null;

        }

      $download_log = $download["download_log"] == 1 ? "<a onclick=\"document.getElementById('logfile_" . $i . "').className =
    document.getElementById('logfile_" . $i . "').className.replace(/\bhidden\b/,'');\" title=\"show the detailed logfile\">show log</a>" : "<i>no log</i>";
      echo "<li><i class=\"fa fa-code\" title=\"date added\"></i> " . $download_log . $log . "</li>";

      $download_comment = $download["download_comment"] == "" ? "<p><i>no comment</i></p>" : kirbytext($download["download_comment"]);
      echo "<li>" . $download_comment . "</li>";

      echo "</ul><hr>";

    endforeach;

  if ($i < 1) {
    echo "No downloads available";
  }

  echo "</div>";

/* ------------------------------------------------------------- */
/* User is not logged in, show the error message */
/* ------------------------------------------------------------- */

} else {

  echo $err;
}

?>