<?php

declare(strict_types=1);

namespace App\Model\Entity;
use Cake\ORM\Entity;

class Location extends Entity {
    protected $_accessible = [
        'id' => true,
        'address' => true,
        'complement' => true,
        'client_id' => true,
    ];
}
