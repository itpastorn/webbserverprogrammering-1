<?php
/**
 * Visa ett slumpmässigt valt citat
 *
 * Detta är övningen som motsvarar avsnitt 2.3 i läroboken Webbserverprogrammering 1
 */


/**
 * En utf8-funktion som vänder på en textsträng
 *
 * Denna funktion liknar PHP:s inbyggda strrev(), men förutsätter
 * att teckenkodningen är UTF-8 och inte Win-1252/ISO-8859-1
 *
 * @param string $str En UTF-8 kodad sträng
 * @return string Strängen i omvänd ordning
 */
function utf8_strrev($str) {
        // Namnet baklänges – se detta som svart magi tills vidare!
        preg_match_all('/./us', $str, $temp_arr);
        return join('', array_reverse($temp_arr[0]));
}


header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8" />
  <title>Avsnitt 2.3: Namntest</title>
  <style>
    body {
        font-family: sans-serif;
        max-width: 500px;
        margin: auto;
    }
    dt {
        margin-top: 1em;
    }
  </style>
</head>
<body>
FIXTHIS
</body>
</html>

