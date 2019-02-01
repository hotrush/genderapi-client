<?php

namespace Hotrush\GenderApi\Adapter;

interface AdapterInterface
{
    public function get($url, array $args = []);

    public function setEndpoint($endpoint);
}