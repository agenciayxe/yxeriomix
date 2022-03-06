<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;


class Client extends Entity {
    protected $_accessible = [
        'name' => true,
        'cpf_cnpj' => true,
        'phone' => true,
        'email' => true,
        'status_id' => true,
        'status' => true,
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
