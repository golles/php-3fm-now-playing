<?php

namespace golles\radio3fm;

/**
 * Helper class to get the now playing information from the 3FM website.
 */
class Radio3FmHelper
{
    /**
     * @var string 3fm website to prefix some data fields.
     */
    private static $WEBSITE = 'http://www.npo3fm.nl';
    /**
     * @var string url where to find the 3fm now playing json.
     */
    private static $URL = 'http://www.npo3fm.nl/data/cache/jsonp/nowplaying-encoded.json?callback=driefmJsonNowplaying5&_=%s';

    /**
     * Retrieve the now playing data from the 3FM web page.
     *
     * @param string $url where to find the json data.
     * @return Radio3FmResponse object containing the information
     */
    public static function get3FMNowPlaying($url = null)
    {
        if ($url == null) {
            $url = sprintf(Radio3FmHelper::$URL, time());
        }

        $response = file_get_contents($url);
        $stripped = Radio3FmHelper::stripResponse($response);

        return Radio3FmHelper::makeRadio3FmResponse($stripped);
    }

    /**
     * Strip unwanted data out of the string so only a json string remains.
     *
     * @param $responseString string to be be stripped.
     * @return string that can be parsed as json.
     */
    private static function stripResponse($responseString)
    {
        $matches = array();
        preg_match('/\((.*)\)/', $responseString, $matches);
        return $matches[1];
    }

    /**
     * Create a new object based on a json string.
     *
     * @param string|null $jsonString coming from the 3FM website.
     * @return Radio3FmResponse data container.
     */
    private static function makeRadio3FmResponse($jsonString = null)
    {
        $radio3FmResponse = new Radio3FmResponse();

        if ($jsonString != null) {
            $json = json_decode($jsonString);

            foreach ($json as $key => $value) {
                if (property_exists($radio3FmResponse, $key)) {
                    switch ($key) {
                        case 'artist_url':
                        case 'song_url':
                            if ($value != null) {
                                $value = Radio3FmHelper::$WEBSITE . Radio3FmHelper::decodeString($value);
                            }
                            break;
                        case 'artist':
                        case 'title':
                            $value = mb_convert_case(Radio3FmHelper::decodeString($value), MB_CASE_TITLE, 'UTF-8');
                            break;
                    }
                    $radio3FmResponse->$key = $value;
                }
            }
        }

        return $radio3FmResponse;
    }

    /**
     * Decode a string from the 3FM response json.
     *
     * @param $encoded string with encoded text.
     * @return string decoded, readable text.
     */
    private static function decodeString($encoded)
    {
        $decoded = '';

        foreach (array_reverse(str_split($encoded)) as $s) {
            $decoded .= Radio3FmHelper::decodeCharacter($s);
        }

        return $decoded;
    }

    /**
     * Decode a single character.
     *
     * @param $char string single character.
     * @return string encoded character.
     */
    private static function decodeCharacter($char)
    {
        if (preg_match('/^[a-zA-Z]$/', $char) == 1) {
            $c = floor(ord($char) / 97);
            $k = (ord(strtolower($char)) - 83) % 26;

            return chr((($k === 0) ? 26 : $k) + (($c === 0) ? 64 : 96));
        } else {
            return $char;
        }
    }
}