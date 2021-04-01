<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\smsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pdf', function () {

    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile('D:/DataScraping/shwapno_1.pdf');

    $text = $pdf->getText();

    $tst = explode("\n", $text);

    $length = count($tst);

    // preg_match("/^[a-zA-Z0-9._-]/", $my_email)

    for ($x = 0; $x < $length; $x++) {
        $tst2[] = explode("\t", $tst[$x]);
        if(preg_match("/^[a-zA-Z0-9._-]/i", $tst[$x])){
            echo "data[".$x."]: ".$tst[$x]."<br/>\n";
            $array_info[$x] = ($tst[$x]);
        }
        else
            continue;
    }
    dd($tst2);

});

Route::get('upload-report', 'ReportController@fileUpload')->name('createreport');

Route::post('upload-report', 'ReportController@fileUploadProcess')->name('createreportprocess');

Route::get('view-report', 'ReportController@getFiles')->name('getallfiles');

Route::get('process-file/{id}', 'ReportController@fileProcess')->name('processfile');

Route::get('image-pdf', 'ReportController@pdfProcess')->name('imagepdf');

Route::get('pdf-convert','PDFController@makePDF');

Route::get('img-convert','PDFController@ImgPdf');

Route::get('/send/message','smsController@sendMessage');

Route::get('/scrap','ReportController@scrapData');
