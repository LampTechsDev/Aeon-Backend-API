<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
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

            $parser = new Parser();
            $PDF = $parser->parseFile($request->file);
            dd(nl2br($PDFContent = $PDF->getText()));
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
}
