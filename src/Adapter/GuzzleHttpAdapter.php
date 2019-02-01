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
     * GuzzleHttpAdapter constructor.
     *
     * @param null $apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
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

        $config = [
            'base_uri' => $endpoint,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => sprintf('%s v%s (%s)',
                    GenderApiClient::USER_AGENT,
                    GenderApiClient::VERSION,
                    GenderApiClient::WEBSITE
                ),
            ],
        ];

        if ($this->apiKey) {
            $config['query'] = [
                'key' => $this->apiKey,
            ];
        }

        $this->client = new Client($config);
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
     * Send GET request.
     *
     * @param $url
     * @param array $args
     */
    public function get($url, array $args = [])
    {
        $options = [];
        if (!empty($args)) {
            $options['query'] = $args;
        }
        try {
            $this->handleResponse(
                $this->client->get($url, $options)
            );
        } catch (RequestException $e) {
            return $this->handleError($e);
        }
    }
}