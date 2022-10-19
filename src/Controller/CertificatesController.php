<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\FactoryLocator;

class CertificatesController extends AppController {
    public function index() {

        $pesquisa = ($this->request->getQuery('s')) ? $this->request->getQuery('s'): '';
        $this->paginate = [
            'contain' => ['Clients']
        ];
        $certificates = $this->paginate($this->Certificates->find('all'));

        $this->set(compact('certificates'));
        $this->set(compact('pesquisa'));
    }
    public function view($id = null)
    {
        $certificate = $this->Certificates->get($id, [
            'contain' => ['Clients']
        ]);

        $this->set('certificate', $certificate);
    }
}
