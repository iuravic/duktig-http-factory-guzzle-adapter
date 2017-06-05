<?php
namespace Duktig\Http\Factory\Adapter\Guzzle;

use Interop\Http\Factory\ResponseFactoryInterface;
use GuzzleHttp\Psr7\Response;

class GuzzleResponseFactory implements ResponseFactoryInterface
{
    /**
     * {@inheritdoc}
     * @see \Interop\Http\Factory\ResponseFactoryInterface::createResponse()
     */
    public function createResponse($code = 200)
    {
        return new Response($code, [], null, 'HTTP/1.1', null);
    }
}