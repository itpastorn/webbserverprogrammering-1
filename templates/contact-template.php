<?php
/**
 * Mall för att visa ett kontaktformulär
 * 
 * Se kapitel 17 i Läroboken Webbserverprogrammering 1
 */

trigger_error(
    "<pre>Ta bort detta fel när du läst kapitel 17 och studerat koden.<br />Det finns på rad " 
    . (__LINE__ - 2) . " i filen " . __FILE__, E_USER_ERROR
);

$h1span = "Kontakta oss";

?>
<!DOCTYPE html>
<html lang="sv">
<head>
  <meta charset="utf-8" />
  <title>Kontakt - Läxhjälpen</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <base href="/" />
  <link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' />
  <link href="css/laxhjalpen.css" rel="stylesheet" />
</head>
<body class="subpage">
<?php
require("masthead.php");
require("menu.php");
echo <<<MAIN
  <div role="main">
  <h2>Kontaktformulär</h2>
  <!-- Telefon bör också finnas -->
  <form action="contact.php" method="post">
    <fieldset id="userdata">
      <legend>Vem är du?</legend>
      <p>
        <label for="uname">Namn:{$uname_extra}</label>
        <input type="text" name="uname" id="uname" value="{$uname}" placeholder="Förnamn Efternamn" required />
      </p>
      <p>
        <label for="umail">Mejladress:{$umail_extra}</label>
        <input type="email" name="umail" id="umail" value="{$umail}" placeholder="foo@bar.com" required />
      </p>
    </fieldset>
    <fieldset id="messagedata">
      <legend>Meddelande</legend>
      <p>
        <label for="msubject">Ärende:{$msubject_extra}</label>
        <input type="text" id="msubject" name="msubject" value="{$msubject}"  placeholder="Minst 5 tecken" required />
      </p>
      <p>
        <label for="mmessage">Text:{$mmessage_extra}</label>
        <textarea id="mmessage" name="mmessage" placeholder="Skriv ditt meddelande. Minst 25 tecken." required>{$mmessage}</textarea>
      </p>
    </fieldset>
    <fieldset id="submitbutton">
      <input type="submit" value="Skicka" />
      <!--
        The following field is used to prevent multiple submits. If removed it will be considered a configuration error.  
       -->
       <input type="hidden" name="prevent_multiple_submits" value="{$random_string}" />
    </fieldset>
  </form>
  </div>
MAIN;
?>

  <footer>
    <small>&copy; Lars Gunther och Thelin AB</small>
  </footer>
</body>
</html>
