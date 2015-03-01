<?php

namespace golles\radio3fm;

/**
 * Class Response3FM Simple object that represents the response from 3FM. It also handles decoding of encoded strings.
 */
class Response3FM {
    public $artist_id;
    public $artist_url;
    public $song_id;
    public $song_url;
    public $artist;
    public $title;
    public $startdatetime;
    public $stopdatetime;
    public $more_info;

    /**
     * Create a new object based on a json string.
     *
     * @param string|null $jsonString
     */
    public function __construct($jsonString = null) {
        if ($jsonString != null) {
            $json = json_decode($jsonString);

            foreach ($json as $key => $value) {
                if (property_exists(get_called_class(), $key)) {
                    switch ($key) {
                        case "artist_url":
                        case "song_url":
                        case "artist":
                        case "title":
                            $value = $this->decodeString($value);
                            break;
                    }
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * Decode a string from the 3FM response.
     *
     * @param $string string encoded text.
     *
     * @return string decoded.
     */
    private function decodeString($string) {
        $decoded = '';

        foreach (array_reverse(str_split($string)) as $s) {
            $decoded .= $this->decodeCharacter($s);
        }

        return $decoded;
    }

    /**
     * Decode a single character.
     *
     * @param $char string single character.
     *
     * @return string encoded character.
     */
    private function decodeCharacter($char) {
        if (preg_match('/^[a-zA-Z]$/', $char) == 1) {
            $c = floor(ord($char) / 97);
            $k = (ord(strtolower($char)) - 83) % 26;

            return chr((($k === 0) ? 26 : $k) + (($c === 0) ? 64 : 96));
        }
        else {
            return $char;
        }
    }
}
