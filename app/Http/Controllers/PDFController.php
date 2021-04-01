<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\PDF;

use thiagoalessio\TesseractOCR\TesseractOCR;

class PDFController extends Controller
{
    public function makePDF()
    {
        $data = ['title' => 'MyNotePaper.com'];

        $pdf = PDF::loadView('img_pdf', $data);

        return $pdf->download('mnp.pdf');
    }

    public function ImgPdf(){
        $data = (new TesseractOCR('D:/onion.PNG'))
            ->run();


        $tst = explode("\n", $data);

        $length = count($tst);

        for ($x = 0; $x < $length; $x++) {
            if(preg_match("/^[a-zA-Z0-9\t(\n._-]/i", $tst[$x])){
                echo "data[".$x."]: ".$tst[$x]."<br/>\n";
                $array_info[$x] = ($tst[$x]);
            }
            else
                continue;
        }

        dd($tst);

    }
}
