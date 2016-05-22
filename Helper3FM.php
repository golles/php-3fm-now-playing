<?php

namespace golles\radio3fm;

/**
 * Class Helper3FM for retrieving external data from 3fm.
 */
class Helper3FM
{
    public $url = 'http://www.3fm.nl/data/cache/jsonp/nowplaying-encoded.json?callback=driefmJsonNowplaying5&_=%s';


    /**
     * Initiate the helper.
     *
     * @param $url string to the now playing json.
     */
    function __construct($url = null)
    {
        if ($url != null) {
            $this->url = $url;
        }
    }

    /**
     * Retrieve the now playing data from the 3FM web page.
     *
     * @return Response3FM
     */
    public function get3FMNowPlaying()
    {
        $url = sprintf($this->url, time());
        $response = file_get_contents($url);
        $string = $this->stripResponse($response);
        return new Response3FM($string);
    }

    /**
     * Strip unwanted data out of the string so only a json string remains.
     *
     * @param $responseString string to be be stripped.
     * @return string that can be parsed as json.
     */
    private function stripResponse($responseString)
    {
        $matches = array();
        preg_match('/\((.*)\)/', $responseString, $matches);
        return $matches[1];
    }
}