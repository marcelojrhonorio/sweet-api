<?php

namespace App\Events;

use App\Models\Customers;

class CustomerCreatedEvent extends Event
{
    /**
     * @var  App\Models\Customers  $customer
     */
    public $customer;

    /**
     * @var  string  $password  Plain password
     */
    public $password;

    /**
     * Create a new event instance.
     */
    public function __construct(Customers $customer, string $password)
    {
        $this->customer = $customer;
        $this->password = $password;
    }
}
