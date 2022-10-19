<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\FactoryLocator;

class ContactsController extends AppController
{
    public function index()
    {
        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $contacts = $this->paginate($this->Contacts->find('all', [
            'conditions' => [
                'OR' => [
                    'Contacts.name LIKE' => '%' . $pesquisa . '%',
                ]
            ]
        ]));

        $this->set(compact('contacts'));
        $this->set(compact('pesquisa'));
    }
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id);

        $this->set('contact', $contact);
    }
    public function edit($id = null)
    {
        $listContacts = FactoryLocator::get('Table')->get('contacts');

        $contact = $this->Contacts->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contact = $listContacts->patchEntity($contact, $this->request->getData());
            if ($listContacts->save($contact)) {
                $this->Flash->success(__('The contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contact could not be saved. Please, try again.'));
        }
        $this->set(compact('contact'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contact = $this->Contacts->get($id);
        if ($this->Contacts->delete($contact)) {
            $this->Flash->success(__('The contact has been deleted.'));
        } else {
            $this->Flash->error(__('The contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
