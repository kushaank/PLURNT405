<?php



class SoundcloudTest extends TestCase {
    public function tearDown()
    {
        Mockery::close();
    }

    public function testSearchPullsFromCache()
    {


        // create a client object with your app credentials

        $json = '{"total": 0, "links": []}';
        $client = Mockery::mock('App\Services\Client');

        $cache = Mockery::mock('Illuminate\Cache\Repository');
        $cache->shouldReceive('has')->with('Lean On')->andReturn(true);
        $cache->shouldReceive('get')->with('Lean On')->andReturn($json);

        $sc = new App\Services\SC($cache, $client);
        $results = $sc->search('Lean On');
        $this->assertEquals($results, json_decode($json));
    }

    public function testSearchPullsFromApiAndStoresInCache()
    {
        $client = Mockery::mock('App\Services\Client');
        $client->shouldReceive('get')
            ->with('https://soundcloud.com/majorlazer/LeanOn')
            ->andReturn('{"total": 2, "links": []}');

        $cache = Mockery::mock('Illuminate\Cache\Repository');
        $cache->shouldReceive('has')->with('LeanOn')->andReturn(false);
        $cache->shouldReceive('put')
            ->once()
            ->with('LeanOn', '{"total": 2, "links": []}', 60);

        $sc = new App\Services\SC($cache, $client);
        $results = $sc->search('LeanOn');
        $this->assertEquals($results, json_decode('{"total": 2, "links": []}'));
    }

}