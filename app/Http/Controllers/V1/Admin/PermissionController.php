<?php

namespace App\Http\Controllers\V1\Admin;


use App\Http\Components\Classes\Facade\Permission;
use App\Http\Controllers\Controller;
use App\Models\GroupAccess;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Get Permission List
     */
    public function permissionList(){
        try{
            $this->data = Permission::getAllPermission();
            $this->apiSuccess("Permission List Loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Store Permission Data
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "group_id"      => ["required", "exists:groups,id"],
                "permission"    => ["required", "array"],
            ]);

            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 500);
            }
            $_access_key = array_keys($request->permission);
            $_all_permissions = Permission::getAccessPermissionKeys();
            if( array_diff($_access_key, $_all_permissions) ){
                return $this->apiOutput("Invalid Permission Key Found", 500);
            }

            $group_access = GroupAccess::where("group_id", $request->group_id)->first();
            if( empty($group_access) ){
                $group_access = new GroupAccess();
            }
            $group_access->group_id     = $request->group_id;
            $group_access->group_access = $request->permission;
            $group_access->save();

            $permissions = Permission::getOrginalAccessWithMenu($group_access->group_access ?? []);
            $this->data = $permissions;

            $this->apiSuccess("Group Access Stored Successfully");
            return $this->apiOutput();

        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * View OR Load Specific Group Permission
     */
    public function viewGroupPermission(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "group_id"  => ["required", "exists:groups,id"]
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator), 400);
            }
            $group_access = GroupAccess::where("group_id", $request->group_id)->first();
            $permissions = Permission::getOrginalAccessWithMenu($group_access->group_access ?? []);
            $this->data = $permissions;
            $this->apiSuccess("Group Permission Loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    public function userAccess(Request $request){
        try{
            $admin_user = $request->user();
            $permissions = Permission::getOrginalAccessWithMenu($admin_user->group->groupAccess->group_access ?? []);
            $this->data = $permissions;
            $this->apiSuccess("User Access Loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Check Has Permission Or Not 
     * @return bool
     */
    public static function hasAccess($key){
        if(Permission::hasAccess($key)){
            return true;
        }
        return false;
    } 

}
