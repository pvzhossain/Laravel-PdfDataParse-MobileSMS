<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ReportUpload;
use Smalot\PdfParser\Parser;
use ScraperAPI\Client;

class ReportController extends Controller
{
    public function fileUpload(){
        return view('reportUpload');
    }

    public function fileUploadProcess(Request $request){
        $this->validate($request, [
            'report_type' => 'required',
            'report_name' => 'required',
            'report_file' => 'required'
        ]);

        $report_data = new ReportUpload;
        $report_data->report_type = $request->report_type;
        $report_data->report_name = $request->report_name;
        $report_data->report_file = $request->report_file->store('public/ReportFile');
        $report_data->save();

        return redirect()->back();
    }

    public function getFiles(){
        $file_data = ReportUpload::all();
        return view('all_file', compact('file_data'));
    }

    public function fileProcess($id){
        $file_data = ReportUpload::find($id);
        $cbckey1 = "COMPLETE BLOOD COUNT";
        $cbckey2 = "COMPLETE BLOOD COUNT (CBC)";
        $cbckey3 = "CBC";
        $dlckey1 = "Differential Leucocyte Count (DLC)";
        $dlckey2 = "Differential Leucocyte Count";
        $dlckey3 = "DLC";
        $alckey1 = "Absolute Leucocyte Count";
        $platelete = "Platelet Count";
        $parser = new Parser();
        $pdf = $parser->parseFile('E:/card/abc.pdf');
        $text = $pdf->getText();
        $text_line = explode("\n", $text);

        $length = count($text_line);

        for ($x = 0; $x < $length; $x++) {
            if(preg_match("/^[a-zA-Z0-9\t(\n._-]/", $text_line[$x])){
               echo "word[".$x."]: ".$text_line[$x]."<br/>\n";
                $array_info[$x] = ($text_line[$x]);
            }
            else
                continue;
        }

        $array_length = count($array_info);

        if ($file_data->report_type=="CBC"){
            for($i = 0; $i<=$array_length; $i++){
                if(empty($array_info[$i]))
                    continue;
                if(str_contains($array_info[$i],$cbckey1) || str_contains($array_info[$i],$cbckey2) || str_contains($array_info[$i],$cbckey3)){
                    $count = $i;
                    echo "<b>$cbckey1:</b>"."<br>";
                    for ($j = $count; $j<=$array_length; $j++){
                        if(empty($array_info[$j]))
                            continue;
                        if(preg_match("/^[a-zA-Z]/", $array_info[$j])){
                            if(str_contains($array_info[$j],$dlckey1) || str_contains($array_info[$j],$dlckey2) || str_contains($array_info[$j],$dlckey3)){
                                break;
                            }
                            if (preg_match("/[0-9]/", $array_info[$j])){
                                echo $array_info[$j]."<br>";
                            }elseif (!empty($array_info[$j+1]) && preg_match("/[0-9]/", $array_info[$j+1])){
                                echo $array_info[$j]."\t".": ";
                                echo $array_info[$j+1]."<br>";
                            }elseif (empty($array_info[$j+1])){
                                continue;
                            }
                        }
                    }
                }
                if(str_contains($array_info[$i],$dlckey1) || str_contains($array_info[$i],$dlckey2) || str_contains($array_info[$i],$dlckey3)){
                    $count = $i;
                    $num = 0;
                    $val = 0;
                    $num2[]=0;
                    $num_length = 0;
                    echo "<b>$array_info[$i]:</b>"."<br>";
                    for ($k = $count; $k<=$array_length; $k++){
                        if(empty($array_info[$k]))
                            continue;
                        if(preg_match("/^[a-zA-Z0-9]/", $array_info[$k])){
                            if(str_contains($array_info[$k],$alckey1)){
                                break;
                            }
                            if (preg_match("/[0-9]/", $array_info[$k]) && $num==0){
                                echo $array_info[$k]."<br>";
                            }elseif (!empty($array_info[$k+1]) && preg_match("/[0-9]/", $array_info[$k+1]) && $num==0){
                                    echo $array_info[$k]."\t".": ";
                                    echo $array_info[$k+1]."<br>";
                            }elseif (!empty($array_info[$k+1]) && preg_match("/^[a-zA-Z]/", $array_info[$k+1])){
                                $num = $k+1;
                                $num2[] = $num;
                            }elseif (!empty($array_info[$k+1]) && preg_match("/[0-9]/", $array_info[$k+1]) && $num!=0){

                                $start = $num2[$val];

                                $num_length = count($num2);

                                echo $array_info[$start]."<br>";
                                echo $array_info[$k+1]."<br>";

                                if ($array_info[$start] == "Basophils"){ //Check condition here
                                    $asd = $start+1;
                                    echo "<b>$array_info[$asd]:</b>"."<br>";
                                    $val++;
                                }

                                $val++;
                            }elseif (empty($array_info[$k+1])){
                                continue;
                            }
                        }else{
                            echo "Condition Missmatch";
                        }

                        if ($val>$num_length){
                            $num = 0;
                            break;
                        }
                    }
                }
                if(str_contains($array_info[$i],$alckey1)){
                    $count = $i;
                    echo "<b>$alckey1:</b>"."<br>";
                    for ($l = $count; $l<=$array_length; $l++){
                        if(empty($array_info[$l]))
                            continue;

                        if(preg_match("/^[a-zA-Z]/", $array_info[$l])){
                            if(str_contains($array_info[$l],$platelete)){
                                break;
                            }
                            if (preg_match("/[0-9]/", $array_info[$l])){
                                echo $array_info[$l]."<br>";
                            }elseif (!empty($array_info[$l+1]) && preg_match("/[0-9]/", $array_info[$l+1])){
                                echo $array_info[$l]."\t".": ";
                                echo $array_info[$l+1]."<br>";
                            }elseif (empty($array_info[$l+1])){
                                continue;
                            }
                        }
                    }
                }
                if(str_contains($array_info[$i],"Platelet Count")){
                    echo $array_info[$i].": ";
                    echo $array_info[$i+1]."<br>";
                }

            }
        }else{
            echo "File not CBC";
        }
         return view('welcome');

    }


    public function scrapData(){
        $client = new Client("c0d05d1e1d004a39f170d3379bc35880");
        $result = $client->get("http://httpbin.org/ip")->raw_body;
        dd($result);
    }


}
