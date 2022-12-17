<?php

namespace App\Http\Components\Classes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Permission{
    /**
     * Define All Permission
     */
    private $all_access = [
        "admin" => [
            "menu"      => "Admin", 
            "access"    => [
                "admin_list"    => "Show Admin List", 
                "admin_create"  => "Create New Admin", 
                "admin_update"  => "Update Admin", 
                "admin_delete"  => "Delete Admin", 
                "admin_restore" => "Restore Admin",
            ],
        ],
        
        "screener" => [
            "menu"      => "Screener", 
            "access"    => [
                "screener_list"    => "Show Screener List", 
                "screener_update"  => "Update Screener", 
                "screener_delete"  => "Delete Screener", 
            ],
        ],
        
        "heralmelding" => [
            "menu"      => "Heralmelding", 
            "access"    => [
                "heralmelding_list"    => "Show Heralmelding List", 
                "heralmelding_update"  => "Update Heralmelding", 
                "heralmelding_delete"  => "Delete Heralmelding", 
            ],
        ],
        
        "pib" => [
            "menu"      => "PIB", 
            "access"    => [
                "pib_list"    => "Show PIB List", 
                "pib_update"  => "Update PIB", 
                "pib_delete"  => "Delete PIB", 
            ],
        ],
        
        "pit" => [
            "menu"      => "PIT", 
            "access"    => [
                "pit_list"    => "Show PIT List", 
                "pit_update"  => "Update PIT", 
                "pit_delete"  => "Delete PIT", 
            ],
        ],
        
        "yes" => [
            "menu"      => "YES Approval", 
            "access"    => [
                "yes_list"    => "Show YES Approval List", 
                "yes_update"  => "Update YES Approval", 
                "yes_delete"  => "Delete YES Approval", 
            ],
        ],
        
        "no" => [
            "menu"      => "NO Approval", 
            "access"    => [
                "no_list"    => "Show NO Approval List", 
                "no_update"  => "Update NO Approval", 
                "no_delete"  => "Delete NO Approval", 
            ],
        ],
        
        "appointmentgroup" => [
            "menu"      => "Appointment Group", 
            "access"    => [
                "appointmentgroup_list"    => "Show Appointment Group List", 
                "appointmentgroup_update"  => "Update Appointment Group", 
                "appointmentgroup_delete"  => "Delete Appointment Group", 
            ],
        ],
        
        "group" => [
            "menu"      => "Group", 
            "access"    => [
                "group_list"        => "Show Group List", 
                "group_show"        => "Show Group List", 
                "group_create"      => "Create New Group", 
                "group_update"      => "Update Group", 
                "group_delete"      => "Delete Group",
                "permission_list"    => "View Group Permission", 
                "permission_create"  => "Add / Update Group Permission"
            ],
        ],
        "therapist" => [
            "menu"      => "Therapist", 
            "access"    => [
                "therapist_list"        => "Show Therapist List", 
                "therapist_create"      => "Add New Therapist", 
                "therapist_update"      => "Update Therapist Info", 
                "therapist_delete"      => "Delete Therapist Info",
            ],
        ],
        
        "therapistschedule" => [
            "menu"      => "Therapist Schedule", 
            "access"    => [
                "therapistschedule_list"        => "Show Therapist Schedule List", 
                "therapistschedule_create"      => "Add New Therapist Schedule", 
                "therapistschedule_update"      => "Update Therapist Schedule", 
                "therapistschedule_delete"      => "Delete Therapist Schedule",
            ],
        ],
        
        "emailtemplate" => [
            "menu"      => "Email Template", 
            "access"    => [
                "emailtemplate_list"        => "Show Email Template List", 
                "emailtemplate_create"      => "Add New Email Template", 
                "emailtemplate_update"      => "Update Email Template", 
                "emailtemplate_delete"      => "Delete Email Template",
            ],
        ],
        
        "question" => [
            "menu"      => "Question", 
            "access"    => [
                "question_list"        => "Show Question List", 
                "question_create"      => "Add New Question", 
                "question_update"      => "Update Question", 
                "question_delete"      => "Delete Question",
            ],
        ],
        
        "missinginfo" => [
            "menu"      => "Missing Info", 
            "access"    => [
                "missinginfo_list"        => "Show Missing Info List", 
                "missinginfo_update"      => "Update Missing Info", 
                "missinginfo_delete"      => "Delete Missing Info",
            ],
        ],
        
        "patient" => [
            "menu"      => "Patient", 
            "access"    => [
                "patient_list"        => "Show Patient List", 
                "patient_create"      => "Add New Patient", 
                "patient_update"      => "Update Patient Info", 
                "patient_delete"      => "Delete Patient Info",
            ],
        ],
        
        
        "zdpatient" => [
            "menu"      => "ZD Patient", 
            "access"    => [
                "zdpatient_list"        => "Show All Ticket List", 
                "zdpatient_create"        => "Add New ZD Patient", 
                "zdpatient_update"      => "Update ZD Patient", 
                "zdpatient_delete"      => "Delete ZD Patient",
            ],
        ],
        
        "allticket" => [
            "menu"      => "All Ticket", 
            "access"    => [
                "allticket_list"        => "Show All Ticket List", 
                "allticket_create"      => "Add New Ticket", 
                "allticket_update"      => "Update Ticket", 
                "allticket_delete"      => "Delete Ticket",
            ],
        ],
        
        "schedules" => [
            "menu"      => "Schedule", 
            "access"    => [
                "schedules_list"        => "Show Schedule List", 
                "schedules_create"      => "Add New Schedule", 
                "schedules_update"      => "Update Schedule", 
                "schedules_delete"      => "Delete Schedule",
            ],
        ],
        
        "cancelticket" => [
            "menu"      => "Cancel Ticket", 
            "access"    => [
                "cancelticket_list"        => "Show Cancel Ticket List", 
                "cancelticket_update"      => "Update Cancel Ticket", 
                "cancelticket_delete"      => "Delete Cancel Ticket",
            ],
        ],
        
        "cancelappointment" => [
            "menu"      => "Cancel Appointment", 
            "access"    => [
                "cancelappointment_list"        => "Show Cancel Appointment List", 
                "cancelappointment_update"      => "Update Cancel Appointment", 
                "cancelappointment_delete"      => "Delete Cancel Appointment",
            ],
        ],
        
        "intakeappointment" => [
            "menu"      => "Intake Appointment", 
            "access"    => [
                "intakeappointment_list"        => "Show Intake Appointment List", 
                "intakeappointment_update"      => "Update Intake Appointment", 
                "intakeappointment_delete"      => "Delete Intake Appointment",
            ],
        ],
        
        "ticket" => [
            "menu"      => "Ticket", 
            "access"    => [
                "ticket_list"                         => "Show Ticket List", 
                "ticket_create"                       => "Add New Ticket", 
                "ticket_show"                         => "Ticket Show", 
                "ticket_update"                       => "Update Ticket Info", 
                "ticket_delete"                       => "Delete Ticket Info",
                "ticket_replyList"                    => "Ticket Replies Info",
                "ticket_addReply"                     => "Ticket Replies Info Added",
                "ticket_editReply"                    => "Ticket Show Replies Info",
                "ticket_updateReply"                  => "Ticket Reply Updated Info",
                "ticket_deleteReply"                  => "Ticket Reply Deleted Info",
                "ticket_ticketHistoryActivity"        => "Tickethistory activities List",
                "ticket_ticketHistoryActivityshow"    => "Tickethistory activities Show List",
                "assignedticket"                      => "Ticket Assigned Successfully",
                "cancelticket"                        => "Ticket Cancelled Successfully",
                "deleteFileTicket"                    => "Ticket File Deleted Successfully",
            ],
        ],
        
        "TicketDepartment" => [
            "menu"      => "Ticket Department", 
            "access"    => [
                "ticket_department_list"              => "Show Ticket Department List", 
                "ticket_department_create"            => "Add New Ticket Department", 
                "ticket_department_show"              => "Ticket Department Info Show", 
                "ticket_department_update"            => "Ticket Department Updated Info",
                "ticket_department_delete"            => "Ticket Department Info Delete",
            ],
        ],
        
        "appointment" => [
            "menu"      => "Appointment", 
            "access"    => [
                "appointment_list"                            => "Show Appointment List", 
                "appointment_create"                          => "Add New Appointment Create", 
                "appointment_show"                            => "Appointment Info Show", 
                "appointment_update"                          => "Appointment Update",
                "appointment_assignedappointmentticketstatus" => "Assigned Appointment Ticket Status",
                "appointment_delete"                          => "Appointment Delete",
                "delete_file_appointment"                     => "Delete File Appointment",
            ],
        ]    
    ];

    /**
     * Get All Available Permission List
     * @return Array
     */
    public function getAllPermission(){
        return $this->all_access;
    }

    /**
     * Get Orginal Access Array
     */
    public function getOrginalAccessWithMenu(array $_group_access = []){
        $_access = [];
        foreach($_group_access as $key => $_permission){
            $have_access_key = array_intersect($this->getAccessPermissionKeys($this->all_access[$key]["access"]), $_permission);
            $access = $this->all_access[$key];
            foreach($access["access"] as $_key => $value){
                if( !in_array($_key,  $have_access_key) ){
                    unset($access["access"][$_key]);
                }
            }
            $_access[$key] = $access;
        }
        return $_access;
    }

    /**
     * Check Access
     * @param $access_key
     * @return bool
     */
    public function hasAccess($access_key){
        $has_permission = false;
        if( !is_array($access_key) ){
            $access_key = (array) $access_key;
        }
        $user_access = $this->getAuthUserAccess();
        $user_access = $this->getAccessPermissions($user_access);
        
        foreach($access_key as $access){
            if( in_array($access, $user_access) ){
                $has_permission = true;
                break;
            }
        }
        return $has_permission;
    }

    /**
     * Set Authentic User Access
     * 
     */
    protected function setAuthUserAccess(){
        $admin = Auth::user("admin");
        Session::put("group_access", $admin->group->groupAccess->group_access ?? []);
    }

    /**
     * Get Authentic User Access
     * @return Array
     */
    protected function getAuthUserAccess(){
        if( !Session::has("group_access") ){
            $this->setAuthUserAccess();
        }
        return Session::get("group_access");
    }


    /**
     * Get Access Permission Key Array List
     * @return Array
     */
    protected function getAccessPermissions(array $_access_list){
        $_access_arr = [];
        foreach($_access_list as $key => $data){
            if(is_array($data)){
                $_access_arr  = array_merge($_access_arr, array_values($data));
            }
        }
        return  $_access_arr;
    }

    /**
     * Get Access Key Name 
     * @return Array
     */
    public function getAccessPermissionKeys(array $_access_arr = []){
        if( count($_access_arr) == 0 ){
            $_access_arr = $this->getAllPermission();
        }
        return array_keys($_access_arr);
    }
}
