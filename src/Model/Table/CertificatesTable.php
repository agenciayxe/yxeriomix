<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CertificatesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);
        $this->setTable('certificates');
        $this->setDisplayField('vendas');
        $this->setPrimaryKey('id');
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER',
        ]);
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');
        $validator
            ->dateTime('date_initial')
            ->requirePresence('date_initial', 'create')
            ->notEmptyDateTime('date_initial');
        $validator
            ->dateTime('date_end')
            ->requirePresence('date_end', 'create')
            ->notEmptyDateTime('date_end');
        return $validator;
    }
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['client_id'], 'Clients'));
        return $rules;
    }
}
