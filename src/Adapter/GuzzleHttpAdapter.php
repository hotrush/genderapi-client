<?php
namespace Hotrush\GenderApi\Adapter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Hotrush\GenderApi\GenderApiClient;

class GuzzleHttpAdapter extends AbstractAdapter
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Api key
     *
     * @var string
     */
    protected $apiKey;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * GuzzleHttpAdapter constructor.
     *
     * @param null $apiKey
     * @param int  $timeout
     */
    public function __construct($apiKey = null, $timeout = 30)
    {
        $this->apiKey = $apiKey;
        $this->timeout = (int) $timeout;
        $this->buildClient();
    }

    /**
     * Configure client
     *
     * @param null $endpoint
     */
    protected function buildClient($endpoint = null)
    {
        if ($endpoint === null) {
            $endpoint = GenderApiClient::ENDPOINT;
        }

        $this->client = new Client([
            'base_uri' => $endpoint,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => sprintf('%s v%s (%s)',
                    GenderApiClient::USER_AGENT,
                    GenderApiClient::VERSION,
                    GenderApiClient::WEBSITE
                ),
            ],
            'timeout' => $this->timeout,
        ]);
    }

    /**
     * Configure API endpoint.
     *
     * @param $endpoint
     */
    public function setEndpoint($endpoint)
    {
        $this->buildClient($endpoint);
    }

    /**
     * @param array $args
     * @return array
     */
    private function buildQueryArgs(array $args = [])
    {
        if ($this->apiKey) {
            $args['key'] = $this->apiKey;
        }

        return $args;
    }

    /**
     * Send GET request.
     *
     * @param $url
     * @param array $args
     * @return array
     */
    public function get($url, array $args = [])
    {
        $options = [
            'query' => $this->buildQueryArgs($args),
        ];

        try {
            return $this->handleResponse(
                $this->client->get($url, $options)
            );
        } catch (RequestException $e) {
            $this->handleError($e);
        }
    }
}