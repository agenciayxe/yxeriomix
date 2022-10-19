<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\FactoryLocator;

class NewsController extends AppController
{
    public function index()
    {
        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $news = $this->paginate($this->News->find('all', [
            'conditions' => [
                'OR' => [
                    'News.title LIKE' => '%' . $pesquisa . '%',
                ]
            ]
        ]));

        $this->set(compact('news'));
        $this->set(compact('pesquisa'));
    }
    public function add() {

        $listNews = FactoryLocator::get('Table')->get('News');

        $new = $listNews->newEmptyEntity();
        if ($this->request->is('post')) {
            $getData = $this->request->getData();
            $new = $listNews->patchEntity($new, $this->request->getData());
            $dateSave = date('Y-m-d H:M:S');
            $new->date_created = $dateSave;
            if ($listNews->save($new)) {
                $this->Flash->success(__('New salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O new não foi salvo, tente novamente.'));
        }
        $this->set(compact('new'));
    }
    public function view($id = null)
    {
        $new = $this->News->get($id);

        $this->set('new', $new);
    }
    public function edit($id = null)
    {
        $listNews = FactoryLocator::get('Table')->get('News');

        $new = $this->News->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $new = $listNews->patchEntity($new, $this->request->getData());
            if ($listNews->save($new)) {
                $this->Flash->success(__('The new has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The new could not be saved. Please, try again.'));
        }
        $this->set(compact('new'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $new = $this->News->get($id);
        if ($this->News->delete($new)) {
            $this->Flash->success(__('The new has been deleted.'));
        } else {
            $this->Flash->error(__('The new could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
