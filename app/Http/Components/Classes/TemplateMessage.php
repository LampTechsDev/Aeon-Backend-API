<?php

namespace App\Http\Components\Classes;

use Exception;

class TemplateMessage{
    /**
     * @var $model Model Instance
     * @var $message
     */
    protected $model;
    protected $message;

    public function model($model){
        $this->model = $model;
        return $this;
    }

    /**
     * Converting The message
     * @param String $message
     * @return String
     */
    public function parse(String $message, $model = null) : String
    {
        if(!empty($model)){
            $this->model($model);
        }
        $this->message = $message;
        $this->prepareMessage();

        return $this->message;
    }

    /**
     * Prepare the Message with Message Template
     */
    protected function prepareMessage()
    {
        try{
            if( isset($this->model->name) ){
                $this->message = str_replace("{name}", $this->model->name, $this->message);
            }
            if( isset($this->model->email) ){
                $this->message = str_replace("{email}", $this->model->email, $this->message);
            }
            if( isset($this->model->contact_number) ){
                $this->message = str_replace("{contact_number}", $this->model->contact_number, $this->message);
            }
            if( isset($this->model->address) ){
                $this->message = str_replace("{address}", $this->model->address, $this->message);
            }

            if( isset($this->model->email) ){
                $this->message = str_replace("{default_password}", $this->model->email, $this->message);
            }
            if( isset($this->model->vendor->name) ){
                $this->message = str_replace("{vendore_name}", $this->model->vendor->name, $this->message);
            }
            if( isset($this->model->buyer->name) ){
                $this->message = str_replace("{buyer_name}", $this->model->buyer->name, $this->message);
            }
            if( isset($this->model->buyer->name) ){
                $this->message = str_replace("{customer_name}", $this->model->buyer->name, $this->message);
            }
            if( isset($this->model->manufacturer->name) ){
                $this->message = str_replace("{customer_name}", $this->model->manufacturer->name, $this->message);
            }
           
        }catch(Exception $e){
            throw new Exception($e->getMessage(). ' On File'.$e->getFile().":". $e->getLine(), 500);
        }
    }
}