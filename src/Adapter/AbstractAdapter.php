<?php
namespace Hotrush\GenderApi\Adapter;

use GuzzleHttp\Exception\RequestException;
use Hotrush\GenderApi\Exception\ApiErrorException;
use Hotrush\GenderApi\Exception\InternalApiErrorException;
use Hotrush\GenderApi\Exception\InvalidResponseException;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * Handle Gender API response.
     *
     * @param ResponseInterface $response
     * @return array
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        $responseData = json_decode($response->getBody()->getContents(), true);

        if (!$responseData || !array_key_exists('status', $responseData)) {
            throw new InvalidResponseException();
        }
        if (!$responseData['status']) {
            throw new ApiErrorException(
                $responseData['errmsg'],
                $responseData['errno']
            );
        }

        return $responseData;
    }

    /**
     * Handle client request exception.
     *
     * @param RequestException $exception
     */
    protected function handleError(RequestException $exception)
    {
        throw new InternalApiErrorException('[GenderApi] Unknown error received: '.$exception->getMessage());
    }
}
