<?php
/**
 * Blogginlägg = Artiklar på webbplatsen Läxhjälpen
 *
 * @todo Ett sätt att byta författare (username)
 */
class Articles
{
    protected $slug, $title, $text, $username, $pubdate;

    // Dessa variabler kan läsas med __get() eller konverteras till array
    protected $accessibles = array('articlesID', 'slug', 'title', 'text', 'username', 'pubdate');

    /**
     * Primärnyckel i databasen, null = ännu inte sparad
     *
     * Kan läsas med __get()
     * @var int
     */
    protected $articlesID = null; 
    
    /**
     * Håller reda på om all data är kontrollerad
     */
    protected $hasBeenValidated = false;

    /**
     * Håller reda på om all data är kontrollerad och godkänd
     */
    protected $isValid = false;

    /**
     * Felmeddelanden som kan uppstå vid validering av artikeldata
     * @var array
     */
    protected $errorMessages = array('title' => "", 'text' => "");

    /**
     * En ny slugg har skapats till befintligt inlägg
     * @var string
     */
    protected $newSlug = false;

    /**
     * Anslutning till databasen
     * @var PDO
     */
    protected $dbh;

    /**
     * Listar tillåten HTML-kod i brödtext
     */
    const TEXTHTML = <<<TAGSANDATTRIBUTES
        *[lang|dir]
        FIXME
TAGSANDATTRIBUTES;
     /* Stöds ej av HTMLPurifier normalt
        a[type], mark, time,
        figure, figcaption,
        audio[controls|loop|preload|src],
        video[controls|loop|preload|src],
        source[src|type], track[default|label|kind|src|srclang]

     */

    /**
     * Konstruktorn som skapar en ny osparad artikel
     *
     * Instansens övriga funktioner måste validera data innan den sparas
     * @param string $title    Artikelns rubrik
     * @param string $text     Artikelns brödtext
     * @param string $username Artikelns författare
     * @param PDO    $PDO      Databasanslutning
     * @param int    $id       ID i databasen för existerande artikel
     *                         Används vid uppdatering
     */
    public function __construct($title, $text, $username, PDO $dbh, $id = null)
    {
    	// FIXME
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

    /**
     * Getter för artikelns innehållsvariabler
     */
    public function __get($varname)
    {
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    	// FIXME
        throw new Exception("Trying to access undefined or protected property ($var) of " . __CLASS__);
    }

    /**
     * Validerar indata
     * 
     * Rubrik och brödtext kollas mot reguljära uttryck
     * articlesID och username kollas aldrig, vi litar på databasens referensintegritet
     * @uses HTMLPurifier
     */
    public function validate() {

        // FIXME (hasBeenValidated)

        // Preliminär sanering
        // FIXME

        // Flagga för korrekt data
        $this->isValid = true;

        // Valideringen sker med unicode-teckenklasser
        // Se: http://www.fileformat.info/info/unicode/category/index.htm
        // Tillåtna tecken
        // L  = bokstäver
        // N  = siffror
        // Zs = mellanslag
        // P  = Punktuering
        // S  = Symboler (valuta, matematik, etc)
        // M  = Mark - inkluderad accenter och liknande
        // \n är som vanligt nyrad
        // OBS! Manualens varning: Matching characters by Unicode property is not fast...
        $title_regexp = '/^[\p{L}\p{N}\p{Zs}\p{P}\p{S}\p{M}]+$/u';
        $text_regexp  = '/^[\p{L}\p{N}\p{Zs}\p{P}\p{S}\p{M}\n]+$/u';
        if ( "FIXTHIS" ) {
            // FIXME - Position 1
        } else {
            // FIXME - Position 2
            // FIXME - Position 3
        }
        
        // FIXME - Position 4
        
        // FIXME avslutning
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

    /**
     * Vilka fel rent specifikt fälten har
     * 
     * @return array Felmeddelanden per variabel
     */
    public function getErrorMessages()
    {
        return $this->errorMessages;
    }

    /**
     * Artikelns slugg
     * 
     * Om ingen finns, så skapas den ifrån artikelns rubrik
     * @param bool $force_new Anger att en ny slugg ska skapas även om en gammal finns
     * @return string
     */
    public function getSlug($force_new = false)
    {
       if ( !$this->isValid ) {
           throw new Exception("Attempting to generate slug from invalid data");
       }
       // Skapa inte ny slugg till befintlig artikel
       if ( $this->articlesID && !$force_new ) {
           $sql  = "SELECT slug FROM articles WHERE articlesID = :id";
           $stmt = $this->dbh->prepare($sql);
           $stmt->bindParam(":id", $this->articlesID);
           $stmt->execute();
           $this->slug = $stmt->fetchColumn();
           return $this->slug;
       }
       // Utgå från rubriken
       $slug = mb_strtolower($this->title, "utf-8");
       // Ta bort alla diakritiska tecken å -> a, û -> u, etc.
       // Men var snäll mot tyskar (ß -> ss) och danskar (æ -> ae och h -> oe)
        $slug = preg_replace('/\x{00df}/u', "ss", $slug);
        $slug = preg_replace('/\x{00e6}/u', "ae", $slug);
        $slug = preg_replace('/\x{0153}/u', "oe", $slug);
        $slug = Normalizer::normalize($slug, Normalizer::FORM_D);
        $slug = preg_replace( '/\p{M}/u', "",$slug);
        // Ersätt mellanslag och underscore med bindestreck
        // Aldrig mer än ett åt gången
        $slug = preg_replace( '/[_\p{Zs}]+/u', "-", $slug);
        // Ta bort allt utom bokstäver, bindestreck och siffror
        $slug = preg_replace( '/[^\p{L}\p{N}-]+/u', "", $slug);
        // Ta bort inledande och avslutande bindestreck
        // Notera att strim här används med parameter
        $slug = trim($slug, "-");
        // Ta bort om det blir mer än ett bindestreck i följd
        $slug = preg_replace( '/-{2,}/u', "-", $slug);

        // Har den skapade sluggen blivit för kort?
        if ( mb_strlen($slug, "utf-8") <5 ) {
            $this->isValid = false;
            $this->errorMessages['title'] = "Rubriken kan inte bli en slugg";
            return false;
        }

        // Kortar ner om längre än databasens maxlängd minus 5
        // = plats för att numrera 9999 dubletter
        // Detta händer bara om rubriken är lång
        if ( mb_strlen($slug, "utf-8") > 45 ) {
            // Tar bort de övereskjutande bokstäverna och siffrorna
            // Men klipper aldrig mitt i ett ord
            $slug = preg_replace('/-+?([^-]+)?$/', '', substr($slug, 0, 46));
        }
        // Kolla om sluggen är unik
        $sql    = "SELECT slug FROM articles WHERE slug REGEXP :slug";
        $p_slug = "^{$slug}(-[0-9]*)?$";
        $stmt   = $this->dbh->prepare($sql);
        $stmt->bindParam(":slug", $p_slug);
        $stmt->execute();
        $doubles = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        if ( $doubles ) {
            if ( count($doubles) == 1 ) {
                // Det finns bara en dublett
                $slug .= "-1";
            } else {
                // Hitta högsta räknetalet som tillfogas på slutet
                // Vi kan inte sortera efter hela texten
                $highest = 0;
                foreach ( $doubles as $dbl ) {
                    if ( (int)substr(strrchr($dbl, "-"), 1) > $highest ) {
                        $highest = $dbl;
                    }
                }
                if ( $highest = 9999 ) {
                    $this->isValid = false;
                    $this->errorMessages['title'] = "Rubriken ej originell nog";
                    return false;
                }
                // Addera 1 och lägg på slutet av vår slug
                $slug .= "-" . ++$highest;
            }
        }
        $this->slug    = $slug;
        $this->newSlug = $force_new;
        return $slug;
    }

    /**
     * Spara i databasen
     *
     * @return mixed Primärnyckeln i databasen
     */
    public function save()
    {
    	// FIXME
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

    /**
     * Factory-metod som skapar ett artikelobjekt
     *
     * @param int $id  Primärnyckeln i databasen
     * @param PDO $dbh Databasanslutning
     * @param PDO $id_is_slug Sätts till true om vi letar efter en ertikel efter dess slugg
     * @return Instans av denna klass (articles)
     */
    public static function fetch($id, PDO $dbh, $id_is_slug = false)
    {
    	// FIXME
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

    /**
     *
     */
    public static function fetchList()
    {
    	// FIXME
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

    /**
     * Skicka artikeldata som en enkel array
     */
    public function asArray()
    {
    	// FIXME (avsnitt 16.2.1)
        throw new Exception(__METHOD__ . " not implemented yet in ". __CLASS__);
    }

}

