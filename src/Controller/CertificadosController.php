<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Utility\PdfWriter;

class CertificadosController extends AppController {
    public function index()
    {
        $pdfWriter = new PdfWriter();
        $pdf = $pdfWriter->write('Pdfs/generate', ['name' => 'xu']);

        $this->response->body($pdf);
        $this->response->type('pdf');
        $this->response->download(sprintf('export-%s.pdf', time()));

        return $this->response;
    }

}
