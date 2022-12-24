<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class SupplierController extends Controller
{

    public function store(Request $request)
    {
     
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $supplier = new Supplier();
            $supplier->name = $request->name ;
            $supplier->address = $request->address;
            $supplier->telephone = $request->telephone;
            $supplier->save();
            $this->apiSuccess();
            $this->data = (new SupplierResource($supplier));
            return $this->apiOutput("Supplier Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    public function update(Request $request)
    {
     
        try{

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $supplier = Supplier::find($request->id);
            $supplier->name = $request->name ;
            $supplier->address = $request->address;
            $supplier->telephone = $request->telephone;
            $supplier->save();
            $this->apiSuccess();
            $this->data = (new SupplierResource($supplier));
            return $this->apiOutput("Supplier Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
