<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class BankController extends Controller
{

    public function index(){
        try{

            $this->data = BankResource::collection(Bank::all());
            $this->apiSuccess("Bank Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function store(Request $request){
        $validator = Validator::make( $request->all(),[
            // 'name'          => ["required", "min:4"],
            // 'description'   => ["nullable", "min:4"],
        ]);

        if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
        }

        $bank=new Bank();
        $bank->name=$request->name;
        $bank->status=$request->status;
        $bank->details=$request->details;
        $bank->save();
        $this->apiSuccess();
        $this->data = (new BankResource($bank));
        return $this->apiOutput("Bank Added Successfully");
    }

    public function update(Request $request){
        $validator = Validator::make( $request->all(),[
            // 'name'          => ["required", "min:4"],
            // 'description'   => ["nullable", "min:4"],
        ]);

        if ($validator->fails()) {
            $this->apiOutput($this->getValidationError($validator), 400);
        }

        $bank=Bank::find($request->id);
        $bank->name=$request->name;
        $bank->status=$request->status;
        $bank->details=$request->details;
        $bank->save();
        $this->apiSuccess();
        $this->data = (new BankResource($bank));
        return $this->apiOutput("Bank Added Successfully");
    }

    public function show(Request $request)
    {
        try{

            $bank = Bank::find($request->id);
            $this->data = (new BankResource($bank));
            $this->apiSuccess("Bank Showed Successfully");
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
        Bank::where("id", $request->id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Bank Deleted Successfully", 200);
    }


}
