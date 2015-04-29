<?php

namespace App\Services;

class SC {
    protected $cache;
    protected $client;

    public function __construct(\Illuminate\Cache\Repository $cache, $client)
    {
        $this->cache = $cache;
        $this->client = $client;
    }

    public function search($song)
    {
        if ($this->cache->has($song)) {
            return json_decode($this->cache->get($song));
        }

        $json = $this->client->get('https://soundcloud.com/majorlazer/' . urlencode($song));
        $this->cache->put($song, $json, 60);
        return json_decode($json);
    }

}