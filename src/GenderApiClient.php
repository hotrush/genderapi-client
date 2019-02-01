<?php

namespace Hotrush\GenderApi;

use Hotrush\GenderApi\Adapter\AdapterInterface;

class GenderApiClient
{
    const ENDPOINT = 'https://genderapi.io/api/';
    const USER_AGENT = 'GenderApi PHP Client';
    const VERSION = '0.1.1';
    const WEBSITE = 'https://github.com/hotrush/genderapi-client';

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * GenderApiClient constructor.
     *
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get gender for name.
     *
     * @param $name
     * @param null $country
     * @return NameItem
     */
    public function getGender($name, $country = null): NameItem
    {
        $args = ['name' => $name];

        if ($country) {
            $args['country'] = $country;
        }

        return new NameItem(
            $this->adapter->get('', $args)
        );
    }

    /**
     * @param array $names
     * @param null $country
     * @return NameItem[]
     */
    public function getGendersBatch(array $names, $country = null): array
    {
        $args = ['name' => implode(';', $names)];

        if ($country) {
            $args['country'] = $country;
        }

        $response = $this->adapter->get('', $args);
        $names = [];

        if (isset($response['names'])) {
            foreach ($response['names'] as $name) {
                $names[] = new NameItem($name);
            }
        } else {
            $names[] = new NameItem($response);
        }

        return $names;
    }

    public function getGenderByEmail($email, $country = null): NameItem
    {
        $args = ['email' => $email];

        if ($country) {
            $args['country'] = $country;
        }

        return new NameItem(
            $this->adapter->get('email', $args)
        );
    }
}