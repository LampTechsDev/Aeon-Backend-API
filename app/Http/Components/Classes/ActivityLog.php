<?php

namespace App\Http\Components\Classes;

use App\Models\UserActivity;
use Exception;


Class ActivityLog{

    protected $user;
    protected $model;

    /**
     * Set Admin User
     */
    public function user($user){
        $this->user = $user;
        return $this;   
    }

    /**
     * Set Activity Model
     */
    public function model($model){
        $this->model = $model;
        return $this;
    }

    /**
     * Get Morph Class
     */
    protected function getMorphClass($class){
        try{
            return $class->getMorphClass();
        }catch(Exception $e){
            throw new Exception("Class Name Not found while get Classable type");
        }
    }

    /**
     * Get Morph Class
     */
    protected function getId($class){
        try{
            return $class->id;
        }catch(Exception $e){
            return null;
        }
    }

    /**
     * Add Admin Activity Log
     * @param $request
     * @param $message
     */
    public function save($request, $message, $model = null, $user = null){
        try{
            if( !empty($model)){
                $this->model($model);
            }
            if( !empty($user)){
                $this->user($user);
            }

            $activity = new UserActivity();
            $activity->ip               = $request->ip();
            $activity->tableable_type   = $this->getMorphClass($this->model);
            $activity->tableable_id     = $this->getId($this->model);
            $activity->userable_type    = $this->getMorphClass($this->user);
            $activity->userable_id      = $this->getId($this->user);
            $activity->activity         = $message;
            $activity->save();
            return $activity;
        }catch(Exception $e){
            throw new Exception($e->getMessage(), 500);
        }
    }
}
