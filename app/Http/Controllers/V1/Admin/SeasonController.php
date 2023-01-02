<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeasonResource;
use App\Models\Season;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;


class SeasonController extends Controller
{
    public function index()
    {
       try{
        
            $this->data = SeasonResource::collection(Season::all());
            $this->apiSuccess("Season Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
    
    public function store(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $season = new Season();
            $season->name = $request->name ;
            $season->year = $request->year;
            $season->status=$request->status;
            $season->save();
            $this->apiSuccess();
            $this->data = (new SeasonResource($season));
            return $this->apiOutput("Season Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function update(Request $request){
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $season = Season::find($request->id);
            $season->name = $request->name ;
            $season->year = $request->year;
            $season->status=$request->status;
            $season->save();
            $this->apiSuccess();
            $this->data = (new SeasonResource($season));
            return $this->apiOutput("Season Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    public function show(Request $request)
    {
        try{
            
            $season = Season::find($request->id);
            $this->data = (new SeasonResource($season));
            $this->apiSuccess("Season Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

     /*
       Delete
    */
    public function delete(Request $request)
    {
        Season::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Season Deleted Successfully", 200);
    }
}
