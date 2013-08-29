<?php
// $CURLOCALE = setlocale( FIXME );
if ( ! strlen($CURLOCALE) ) {
    user_error('Locale inte inställd!', E_USER_WARNING);
}


/**
 * Funktion för att ansluta till en databas
 *
 * Funktionen förutsätter att några konstanter redan har satts:
 * LAXHJ_DB_DBNAME som är namnet på databasen att ansluta till.
 * LAXHJ_DB_USERNAME som är det användarnamn PHP använder för att ansluta.
 * LAXHJ_DB_PASSWORD som är lösenordet.
 * LAXHJ_TZ som är den tidszon som applikationen ska fungera inom.
 * Funktionen kan anropas flera gånger, utan att någon ny uppkoppling sker.
 * Funktionen gör grundläggande inställningar kring UTF-8 och svensk tidszon
 * för databasförbindelsen.
 *
 * OBS! Funktionen saknar ännu vettig felhantering!
 *
 * @return PDO Databaskopplingen som ett PDO-objekt
 */
function get_dbh()
{
    // Uppkopplingen återanvänds
    static $dbh;
    if ( is_null($dbh) ) {
        // Kontroll av "parametrar"
        $dsn    = "mysql:host=localhost;dbname=" . LAXHJ_DB_DBNAME . ";charset=utf8";

        // Lite grundläggande inställningar
        $attributes = array(
            PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC
        );
        try {
            // FIXME

            // Lite inställningar för MySQL,
            // se https://kb.askmonty.org/en/sql_mode/
            // Tolerera INGA fel under utveckling, bli generösare under drift.
            // OBS! Inget mellanrum mellan kommatecknen på raden nedan!
            $mode_sql = "SET SESSION sql_mode = 'STRICT_ALL_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE'";
            $svar     = $dbh->query($mode_sql);

            // Idiotsäkra förbindelsen så att vi inte råkar
            // radera eller uppdatera alla poster av misstag
            // eller hämts på tok för mycket data
            // FIXME
            
        }
        catch(Exception $e) {
            // FIXME
        }
    }
    return $dbh;
}

/**
 * Funktion som hämtar alla kommentarer som hör ihop med ett enskilt blogginlägg
 * 
 * @param int $articlesID Blogginläggets ID i databasen
 * @param PDO $dbh        Databasanslutningen att använda
 * @return Array          Kommentarerna
 */
function fetch_blog_comments($articlesID, $dbh)
{
    // FIXME
}

