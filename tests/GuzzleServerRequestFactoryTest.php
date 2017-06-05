<?php
namespace Duktig\Http\Factory\Adapter\Guzzle;

use PHPUnit\Framework\TestCase;

class GuzzleServerRequestFactoryTest extends TestCase
{
    public function testCreatesServerRequest()
    {
        $request = (new GuzzleServerRequestFactory())
            ->createServerRequest('GET', 'page/param?q1=val1');
        
        $this->assertEquals('GET', $request->getMethod(),
            "Created request does not have the expected method");
        $this->assertEquals('page/param?q1=val1', $request->getUri(),
            "Created request does not have the expected URI");
        $this->assertEquals('HTTP/1.1', $request->getProtocolVersion(),
            "Created request does not have the expected protocol version");
        
        $this->assertEquals('', $request->getBody()->__toString(),
            "Created request does not have the expected body content");
        $this->assertEquals([], $request->getHeaders(),
            "Created request does not have the expected headers");
        $this->assertEquals([], $request->getServerParams(),
            "Created request does not have the expected server params");
    }
    
    public function testCreateServerRequestFromArray()
    {
        $server = [
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => 'page/param?q1=val1',
            'SERVER_PROTOCOL' => 'HTTP/1.0',
            'CONTENT_TYPE' => 'text/html; charset=utf-8',
            'HTTP_ACCEPT_CHARSET' => 'Accept-Charset: utf-8',
            'HTTP_AUTHORIZATION' => 'Basic UHlnslNGPN24Nlgn2NFapGsp',
            'PHP_AUTH_USER'=> 'user',
            'PHP_AUTH_PW'=> 'secret',
        ];
        $request = (new GuzzleServerRequestFactory())
            ->createServerRequestFromArray($server);
        
        $this->assertEquals('POST', $request->getMethod(),
            "Created response does not have the expected method");
        $this->assertEquals('HTTP/1.0', $request->getProtocolVersion(),
            "Created response does not have the expected protocol version");
        $this->assertEquals('page/param?q1=val1', $request->getUri(),
            "Created response does not have the expected URI");
        $this->assertEquals('Accept-Charset: utf-8', $request->getHeaderLine('Accept-Charset'),
            "Created response does not have the expected header line Accept-Charset");
        $this->assertEquals('text/html; charset=utf-8', $request->getHeaderLine('Content-Type'),
            "Created response does not have the expected header line Content-Type");
        $this->assertEquals('Basic UHlnslNGPN24Nlgn2NFapGsp', $request->getHeaderLine('Authorization'),
            "Created response does not have the expected header line Authorization");
        $this->assertEquals('user', $request->getHeaderLine('PHP_AUTH_USER'),
            "Created response does not have the expected header line PHP_AUTH_USER");
        $this->assertEquals('secret', $request->getHeaderLine('PHP_AUTH_PW'),
            "Created response does not have the expected header line PHP_AUTH_PW");
        $this->assertEquals($server, $request->getServerParams(),
            "Created response does not have the expected server params");
        $this->assertEquals('q1=val1', $request->getUri()->getQuery(),
            "Created response does not have the expected query");
        
        $this->assertEquals('', $request->getBody()->__toString(),
            "Created response does not have the expected body content");
        $this->assertEquals([], $request->getUploadedFiles(),
            "Created response does not have the expected uploaded files");
        $this->assertEquals([], $request->getCookieParams(),
            "Created response does not have the expected cookie params");
    }
}