<?php

namespace Clue\React\Docker\Io;

use Psr\Http\Message\ResponseInterface;

/**
 * ResponseParser is a simple helper to return the buffered body of HTTP response objects
 *
 * @internal
 * @see StreamingParser for working with streaming bodies
 */
class ResponseParser
{
    /**
     * Returns the plain text body of the given $response
     *
     * @param ResponseInterface $response
     * @return string
     */
    public function expectPlain(ResponseInterface $response)
    {
        // text/plain

        return (string)$response->getBody();
    }

    /**
     * Returns the parsed JSON body of the given $response
     *
     * @param ResponseInterface $response
     * @return array
     */
    public function expectJson(ResponseInterface $response)
    {
        // application/json

        return json_decode((string)$response->getBody(), true);
    }

    public function expectJsonNotAssociative(ResponseInterface $response)
    {
        // application/json

        $data = json_decode((string)$response->getBody(), false);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Failed to decode JSON: ' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Returns the empty plain text body of the given $response
     *
     * @param ResponseInterface $response
     * @return string
     */
    public function expectEmpty(ResponseInterface $response)
    {
        // 204 No Content
        // no content-type

        return $this->expectPlain($response);
    }
}
