<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductInformationResource;
use App\Models\ProductionInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class ProductionInformationController extends Controller
{
    public function store(Request $request)
    {
     
        try{

            // if(!PermissionController::hasAccess("group_create")){
            //     return $this->apiOutput("Permission Missing", 403);
            // }

            $validator = Validator::make( $request->all(),[
                // 'name'          => ["required", "min:4"],
                // 'description'   => ["nullable", "min:4"],
            ]);
                
            if ($validator->fails()) {    
                $this->apiOutput($this->getValidationError($validator), 400);
            }
   
            $production = new ProductionInformation();
            $production->cutting_date_plan = $request->cutting_date_plan;
            $production->cutting_date_actual = $request->cutting_date_actual;
            $production->embellishment_plan = $request->embellishment_plan;
            $production->embellishment_actual = $request->embellishment_actual;
            $production->sewing_start_date_plan = $request->sewing_start_date_plan;
            $production->sewing_start_date_actual = $request->sewing_start_date_actual;
            $production->sewing_complete_date_plan = $request->sewing_complete_date_plan;
            $production->sewing_complete_date_actual = $request->sewing_complete_date_actual;
            $production->washing_complete_date_plan = $request->washing_complete_date_plan;
            $production->washing_complete_date_actual = $request->washing_complete_date_actual;
            $production->finishing_complete_date_plan = $request->finishing_complete_date_plan;
            $production->finishing_complete_date_actual = $request->finishing_complete_date_actual;
            $production->save();
            $this->apiSuccess();
            $this->data = (new ProductInformationResource($production));
            return $this->apiOutput("Production Information Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }
}
