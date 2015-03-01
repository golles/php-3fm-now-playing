<?php

namespace golles\radio3fm;

/**
 * Class Helper3FM for retrieving external data from 3fm.
 */
class Helper3FM {
    public $url = 'http://www.3fm.nl/data/cache/jsonp/nowplaying-encoded.json?callback=driefmJsonNowplaying5&_=%s';

    /**
     * @var string.
     */
    private $response;

    /**
     * Initiate the helper.
     *
     * @param $url string to the now playing json.
     */
    function __construct($url = null) {
        if ($url != null) {
            $this->url = $url;
        }
    }

    /**
     * Retrieve data from 3FM web page.
     *
     * @param $url string http location.
     */
    public function get3FMNowPlaying() {
        $url = sprintf($this->url, time());
        $this->response = file_get_contents($url);
    }

    /**
     * Get a Response3FM object from the current response.
     *
     * @return Response3FM object.
     */
    public function getResponse3FM() {
        $string = $this->stripResponse($this->response);
        return new Response3FM($string);
    }

    /**
     * Strip unwanted data out of the string so only a json string remains.
     *
     * @param $responseString string to be be stripped.
     * @return string that can be parsed as json.
     */
    private function stripResponse($responseString) {
        $matches = array();
        preg_match('/\((.*)\)/', $responseString, $matches);
        return $matches[1];
    }
}