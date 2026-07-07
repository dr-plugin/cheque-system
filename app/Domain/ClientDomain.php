<?php

namespace App\Domain;

class ClientDomain
{

    private int $_id;
    private string $_name;
    private string $_phone;
    private string $_type; //sender, getter

    public function __construct(
        string $name,
        string $phone,
        string $type,
    ) {
        $this->_name = $name;
        $this->_phone = $phone;
        $this->_type = $type;
    }

    public function __get(string $name)
    {
        if (property_exists($this, '_' . $name)) {
            return $this->{'_' . $name};
        }

        throw new \InvalidArgumentException("Undefined property: {$name}");
    }
}
