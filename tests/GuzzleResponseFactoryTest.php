<?php
namespace Duktig\Http\Factory\Adapter\Guzzle;

use PHPUnit\Framework\TestCase;

class GuzzleResponseFactoryTest extends TestCase
{
    public function testCreatesResponse()
    {
        $response = (new GuzzleResponseFactory())
            ->createResponse(404);
        
        $this->assertEquals(404, $response->getStatusCode(),
            "Created response does not have the expected status code");
        $this->assertEquals('HTTP/1.1', $response->getProtocolVersion(),
            "Created response does not have the expected protocol version");
        $this->assertEquals([], $response->getHeaders(),
            "Created response does not have the expected headers");
        $this->assertEquals('', $response->getBody()->__toString(),
            "Created response does not have the expected body content");
    }
}