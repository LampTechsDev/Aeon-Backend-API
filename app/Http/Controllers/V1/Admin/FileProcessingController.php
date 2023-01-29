<?php

namespace App\Http\Controllers\V1\Admin;

use App\Facade\PDFParser;
use App\Http\Controllers\Controller;
use App\Models\UploadPo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Continue_;
use Smalot\PdfParser\Parser;

class FileProcessingController extends Controller
{
    protected $customer = "";
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
        dd($data_list);    
        foreach($data_list as $list){
            if($list->name == "companyName"){
                $this->customer  = $list->value;
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
        $iten_list = [];
        try{
            DB::beginTransaction();
            $upload_po = $this->createUploadPo();
            foreach($this->table_date_arr as $list){
                if(  isset($list->column14) && !isset($list->column15) ){
                    if( !empty($list->column14) ){
                        array_push($iten_list, [
                            "upload_po_id"  => $upload_po->id,
                            "order_ln"      => $list->column1, 
                            "ref_no"        => $list->column2, 
                            "level_item"    =>$list->column3, 
                            "diff_name"     => $list->column4, 
                            "diff_total"    =>$list->column5, 
                            "iten_no"       => $list->column6, 
                            "item_description" => $list->column7, 
                            "vendor_ref_no" => $list->column8,
                            "order_qty"     => $list->column9, 
                            "inner_qty"     => $list->column10, 
                            "outer_qty"     => $list->column11, 
                            "supplier_cost" => $list->column12, 
                            "local_guarented_cost"  => $list->column13, 
                            "selling_price" => $list->column14,
                            "created_at"    => now(),
                            "updated_at"    => now(),
                        ]);
                    }else{
                        continue;
                    }
                }
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        
    }

    /**
     * Create or Store Upload PO
     */
    public function createUploadPo(){
        $upload_po = new UploadPo();
        $upload_po->vendor_id = "";

        return $upload_po;
    }
    
}
