<?php
namespace Duktig\Http\Factory\Adapter\Guzzle;

use Interop\Http\Factory\ServerRequestFactoryInterface;
use GuzzleHttp\Psr7\ServerRequest;

class GuzzleServerRequestFactory implements ServerRequestFactoryInterface
{

    /**
     * {@inheritdoc}
     * @see \Interop\Http\Factory\ServerRequestFactoryInterface::createServerRequest()
     */
    public function createServerRequest($method, $uri)
    {
        return new ServerRequest($method, $uri, [], null, 'HTTP/1.1', []);
    }

    /**
     * {@inheritdoc}
     * @see \Interop\Http\Factory\ServerRequestFactoryInterface::createServerRequestFromArray()
     */
    public function createServerRequestFromArray(array $server)
    {
        return new ServerRequest(
            $server['REQUEST_METHOD'] ?? 'GET', 
            $server['REQUEST_URI'], 
            $this->getHeadersFromServerArr($server),
            null,
            $server['SERVER_PROTOCOL'] ?? 'HTTP/1.1',
            $server
        );
    }

    /**
     * Extracts headers' records from $server array which is a copy of the $_SERVER.
     * 
     * @param array $server
     * @return array $headers
     */
    protected function getHeadersFromServerArr(array $server) : array
    {
        $headers = [];
        $specialKeys = [
            'CONTENT_TYPE'   => 'Content-Type',
            'CONTENT_LENGTH' => 'Content-Length',
        ];
        foreach ($server as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $header = str_replace(' ', '-',
                    ucwords(str_replace('_', ' ', strtolower(substr($key, 5))))
                );
                $headers[$header] = $value;
            } elseif (isset($specialKeys[$key])) {
                $headers[$specialKeys[$key]] = $value;
            }
        }
        
        if (!isset($headers['Authorization']) && isset($server['REDIRECT_HTTP_AUTHORIZATION'])) {
            $headers['Authorization'] = $server['REDIRECT_HTTP_AUTHORIZATION'];
        }
        
        if (isset($server['PHP_AUTH_USER'])) {
            $headers['PHP_AUTH_USER'] = $server['PHP_AUTH_USER'];
            $headers['PHP_AUTH_PW'] = $server['PHP_AUTH_PW'] ?? '';
        }
        
        return $headers;
    }
}