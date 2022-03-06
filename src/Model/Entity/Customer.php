<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class Customer extends Entity {
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'phone' => true,
        'username' => true,
        'password' => true,
        'client_id' => true,
        'date_created' => true,
        'status' => true
    ];
    protected $_hidden = [
        'password',
    ];
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
          return (new DefaultPasswordHasher)->hash($password);
        }
    }
}
