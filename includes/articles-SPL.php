<?php
/**
 * Blogginlägg = Artiklar på webbplatsen Läxhjälpen
 *
 * @todo Ett sätt att byta författare (username)
 */
class Articles implements ArrayAccess
{
    protected $slug, $title, $text, $username, $pubdate;

    /**
     * Primärnyckel i databasen, null = ännu inte sparad
     *
     * Kan läsas med __get()
     * @var int
     */
    protected $articlesID = null; 
    
    /**
     * Dessa variabler kan läsas med __get() eller kommas åt som array
     */ 
    protected $accessibles = array('articlesID', 'slug', 'title', 'text', 'username', 'pubdate');


    // Flera rader överhoppade - se articles.php


    // SPL ArrayAccess metoder i stället för metoden asArray()
    // Dessa 4 metoder måste finnas när man följer detta interface
    public function offsetExists($offset)
    {
        if ( in_array($offset, $this->accessibles) ) {
            return true;
        }
    }
    public function offsetGet($offset)
    {
        if ( in_array($offset, $this->accessibles) ) {
            return $this->$offset;
        }
    }
    public function offsetSet($offset, $value)
    {
        if ( in_array($offset, $this->accessibles) ) {
            $this->$offset = $value;
        }
    }
    public function offsetUnset($offset)
    {
        throw new Exception("Deleting properties through array access not allowed in " . __CLASS__);
    }

}

