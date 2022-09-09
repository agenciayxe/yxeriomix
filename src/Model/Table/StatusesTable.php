<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Situations Model
 *
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\HasMany $Services
 *
 * @method \App\Model\Entity\Situation newEmptyEntity()
 * @method \App\Model\Entity\Situation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Situation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Situation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Situation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Situation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Situation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Situation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Situation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Situation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Situation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Situation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Situation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StatusesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('statuses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Clients', [
            'foreignKey' => 'client_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        return $validator;
    }
}
