<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Carbon\Carbon;

// added part
use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Models\Backend\Group;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Components\Classes\Facade\Permission;
use App\Http\Controllers\V1\Admin\PermissionController;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try{
            if(!PermissionController::hasAccess("group_list")){
                return $this->apiOutput("Permission Missing", 403);
            }
            $this->data = GroupResource::collection(Group::all());
            $this->apiSuccess("Grouop Loaded Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{

            if(!PermissionController::hasAccess("group_create")){
                return $this->apiOutput("Permission Missing", 403);
            }

            $validator = Validator::make( $request->all(),[
                'name' => 'required|min:4',
                'description' => 'nullable|min:4',
            ]);

            if ($validator->fails()) {
                $this->apiOutput($this->getValidationError($validator), 400);
            }

            $group = new Group();
            $group->name = $request->name ;
            $group->description = $request->description;
            $group->created_by = $request->user()->id;
            $group->created_at = Carbon::Now();
            $group->save();
            $this->apiSuccess();
            $this->data = (new GroupResource($group));
            return $this->apiOutput("Group Added Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try{
            if(!PermissionController::hasAccess("group_show")){
                return $this->apiOutput("Permission Missing", 403);
            }
            $group = Group::find($request->id);
            if( empty($group) ){
                return $this->apiOutput("Patient Data Not Found", 400);
            }
            $this->data = (new GroupResource($group));
            $this->apiSuccess("Group Showed Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         try{
            $validator = Validator::make($request->all(),[
                'name'          => ["required", "min:4"],
                'description'   => ["nullable", "min:4"],
            ]);

            if ($validator->fails()) {
                return $this->apiOutput($this->getValidationError($validator), 400);
            }

            $group = Group::find($id);
            if(empty($group)){
                return $this->apiOutput("No Data Found", $group);
            }
            $group->name = $request->name ;
            $group->description = $request->description;
            $group->created_by = $request->user()->id ;
            $group->created_at = Carbon::Now();
            $group->save();
            $this->apiSuccess();
            $this->data = (new GroupResource($group));
            return $this->apiOutput("Group Updated Successfully");
        }catch(Exception $e){
            return $this->apiOutput($this->getError( $e), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::where("id", $id)->delete();
        $this->apiSuccess();
        return $this->apiOutput("Group Deleted Successfully", 200);
    }

}
