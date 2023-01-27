<?php

namespace App\Http\Components\Classes;

use Illuminate\Support\Facades\Http;
use PhpParser\JsonDecoder;

class PDFParser{

    /**
     * Define Variables
     */
    protected $pdf_parser_api_url = "https://api.pdf.co/v1/pdf/documentparser";
    protected $pdf_parser_api_key = "nirjhor.aiub@gmail.com_ce7361280fdf5bc59c1609fc0872675e8e6da68e69dfef5de25d27341114f09a0165d540";
    protected $file_url;
    protected $response_status = true;
    protected $response_smg;
    protected $response_data;

    /**
     * get PDF Data
     */
    public function getData($file_url = null){
        if( !empty($file_url) ){
            $this->setPDF($file_url);
        }

        if( !$this->hasPDF() ){
            $this->error("PDF File Not Found");
            return $this->response();
        }

        $this->execute();
        return $this->response();

    }

    /**
     * Set PDF File
     */
    public function setPDF($file_url){
        $this->file_url = $file_url;
        return $this;
    }

    /**
     * Check PDF File is Exists or Not
     */
    protected function hasPDF(){
        $extension = pathinfo($this->file_url, PATHINFO_EXTENSION);
        $imgExtArr = ['pdf'];
        if(in_array($extension, $imgExtArr)){
            return true;
        }
        return false;
    }

    /**
     * Output Response
     * @return Class Response
     */
    protected function response() {
        $response = [
            "status"    => $this->response_status,
            "message"   => $this->response_smg,
            "data"      => $this->response_data,
        ];
        return json_decode(json_encode($response));
    }

    /**
     * Set Failed Or Error Response
     */
    protected function error($smg){
        $this->response_status  = false;
        $this->response_smg     = $smg;
        return $this;
    }

    /**
     * Set Success Response
     */
    protected function success($smg, $data){
        $this->response_status  = true;
        $this->response_smg     = $smg;
        $this->response_data    = $data;
        return $this;
    }

    /**
     * Get Response From PDF
     */
    protected function execute(){
        $headders = [
            "Content-Type"  => "application/json",
            "x-api-key"     => $this->pdf_parser_api_key
        ];
        $rqst_body = [
            "url"           => $this->file_url,
            "outputFormat"  => "JSON",
            // "templateId"    => "1",
            "async"         => false,
            "encrypt"       => false,
            "inline"        => "true",
            "password"      => "",
            "profiles"      => ""
        ];
        $response = Http::withHeaders($headders)->post($this->pdf_parser_api_url, $rqst_body);
        $response = json_decode($response->body());
        if($response->status == 200 && !$response->error){
            $this->success("PDF Data Loaded Successfully", $response->body->objects);
        }else{
            $this->error($response->message ?? "Failed to retrive Data From API");
        }
    }
}