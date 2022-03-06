<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity {
    protected $_accessible = [
        'name' => true,
        'username' => true,
        'password' => true,
        'role_id' => true,
        'img' => true,
        'menu_show' => true,
        'menu_minimized' => true,
        'role' => true,
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
