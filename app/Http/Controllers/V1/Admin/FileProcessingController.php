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
            
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
    
}
