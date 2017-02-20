<?php

namespace golles\radio3fm;

/**
 * Data container class that represents the response from 3FM.
 */
class Radio3FmResponse
{
    public $artist_id;
    public $artist_url;
    public $song_id;
    public $song_url;
    public $artist;
    public $title;
    public $startdatetime;
    public $stopdatetime;
    public $more_info;

    public function __toString()
    {
        return $this->artist . ' - ' . $this->title;
    }
}
