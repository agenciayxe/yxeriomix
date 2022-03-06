<?php
    $CakePdf = new \CakePdf\Pdf\CakePdf();
    $CakePdf->template('newsletter', 'default');
    $CakePdf->viewVars($this->viewVars);
    // Get the PDF string returned
    $pdf = $CakePdf->output();
    // Or write it to file directly
    $pdf = $CakePdf->write(APP . 'files' . DS . 'newsletter.pdf');