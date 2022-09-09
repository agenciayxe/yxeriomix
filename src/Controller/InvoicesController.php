<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use \CakePdf\Pdf\CakePdf;

class InvoicesController extends AppController
{
    // In your Invoices controller you could set additional configs,
    // or override the global ones:
    public function view($id = null)
    {
        $listSales = TableRegistry::get('sales');
        $invoice = $listSales->get($id);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true,
                'filename' => 'invoice_' . $id
            ]
        );
        // Get the PDF string returned
        // Or write it to file directly
        $this->set('invoice', $invoice);

    }
}
?>
