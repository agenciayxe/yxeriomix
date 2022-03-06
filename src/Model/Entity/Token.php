<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Token extends Entity {
    protected $_accessible = [
        'id' => true,
        'token' => true,
        'customer_id' => true,
        'status' => true,
    ];
}
