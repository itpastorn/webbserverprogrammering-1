<?php
/**
 * Mall som visas när ett kontaktformulär fyllts i korrekt
 * 
 * Se kapitel 17 i Läroboken Webbserverprogrammering 1
 */

trigger_error(
    "<pre>Ta bort detta fel när du läst kapitel 17 och studerat koden.<br />Det finns på rad " 
    . (__LINE__ - 2) . " i filen " . __FILE__, E_USER_ERROR
);

$h1span = "Tack för ditt meddelande";

?>
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8" />
  <title>Ditt meddelande har skickats - Läxhjälpen</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <base href="/" />
  <link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' />
  <link href="css/laxhjalpen.css" rel="stylesheet" />
</head>
<body class="subpage">
<?php
require("masthead.php");
require("menu.php");
echo <<<REPLY
  <div role="main">
  <h2>Ditt meddelande har skickats</h2>
  <!-- Telefon bör också finnas -->
  <p>Tack för att du kontaktade oss. Vi hör av oss så fort vi hinner.</p>
  <p>Skickad data:</p>
  <dl class="mailfeedback">
    <dt>Från:</dt>
    <dd>{$uname}</dd>
    <dt>Svarsmejl:</dt>
    <dd>{$umail}</dd>
    <dt>Ärende:</dt>
    <dd>{$msubject}</dd>
    <dt>Text:</dt>
    <dd class="message">{$mmessage}</dd>
  </dl>
REPLY;
?>
  </div>
  <footer>
    <small>&copy; Lars Gunther och Thelin AB</small>
  </footer>
</body>
</html>
