<?php

namespace App\Http\Controllers\V1\Admin;

use App\Facade\PDFParser;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;

class FileProcessingController extends Controller
{
    protected $buyer = "";
    protected $supplier = "";
    protected $item_list = [];
    protected $issue_date;
    protected $due_date = "";
    protected $total = 0;
    protected $table_date_arr = [];
    /**
     * Process the PDF File
     */
    public function process(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "file"      => ["required", "file", "mimes:pdf"]
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 400);
            }

            $file_path = asset($this->uploadFile($request, "file", $this->temp_uploads));

            $pdf_response = PDFParser::setPDF($file_path)->getData();

            if(!$pdf_response->status){
                return $this->apiOutput($pdf_response->message, 402);
            }

            $this->preparePDFData($pdf_response->data)->store();
            
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

     /**
     * Prepare PDF Data
     */
    public function preparePDFData($data_list){        
        foreach($data_list as $list){
            if($list->name == "companyName"){
                $this->buyer  = $list->value;
            }
            if($list->name == "companyName2"){
                $this->supplier   = $list->value;
            }

            if( $list->name == "dateIssued") {
                $this->issue_date = $list->value;
            }

            if( $list->name == "dateDue"){
                $this->due_date = $list->value;
            }

            if( $list->name == "total"  ){
                $this->total = $list->value;
            }

            if($list->objectType == "table"){
                $this->table_date_arr = $list->rows;
            }
        }
        return $this;
    }

    /**
     * Save Data info DB
     */
    protected function store(){
       
        foreach($this->table_date_arr as $list){
            dd( count($list), $this->buyer, $this->supplier, $this->issue_date , $this->due_date, $this->total, $this->table_date_arr);
            // if(  isset($list->column14) ){

            // }
        }
    }
    
}
