<?php
declare(strict_types=1);
namespace App\Model\Entity;
use Cake\ORM\Entity;

class Contact extends Entity {
    protected $_accessible = [
        'name' => true,
        'email' => true,
        'phone' => true,
        'message' => true,
        'date_created' => true,
        'status_id' => true,
        'status' => true,
    ];
}
