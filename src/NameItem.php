<?php

namespace Hotrush\GenderApi;

class NameItem
{
    /**
     * Item data
     *
     * @var array
     */
    private $data = [
        'name' => null,
        'q' => null,
        'gender' => null,
        'total_names' => 0,
        'country' => null,
        'probability' => 0,
    ];

    /**
     * NameItem constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = array_merge($this->data, array_intersect_key($data, $this->data));
    }

    public function getName()
    {
        return $this->data['name'];
    }

    public function getQuery()
    {
        return $this->data['q'];
    }

    public function getGender()
    {
        return $this->data['gender'];
    }

    public function getTotalNames(): int
    {
        return (int) $this->data['total_names'];
    }

    public function getCountry()
    {
        return $this->data['country'];
    }

    public function getProbability(): int
    {
        return (int) $this->data['probability'];
    }
}