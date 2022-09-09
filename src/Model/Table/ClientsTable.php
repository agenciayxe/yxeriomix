<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ClientsTable extends Table {
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('clients');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Sales', [
            'foreignKey' => 'client_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        return $rules;
    }
}
