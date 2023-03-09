<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmailTemplateResource;
use App\Models\EmailTemplate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmailController extends Controller
{
    protected $template_type = [
        "vendor_po_create_mail"                             =>"Vendor PO Create Email",
        "manufacturer_po_create_mail"                       =>"Sub Vendor PO Create Email",
        "buyer_po_create_mail"                              =>"Buyer PO Create Email",
        "aeon_po_create_mail"                               =>"AEON PO Create Email",
        "vendor_shipping_booking_done_mail"                 =>"Vendor Shipping Booking Done Email",
        "buyer_shipping_booking_done_mail"                  =>"Buyer Shipping Booking Done Email",
        "aeon_shipping_booking_done_mail"                   =>"Aeon Shipping Booking Done Email",
        "vendor_invoice_submit_mail"                        =>"Vendor Invoice Submitting Email",
        "buyer_invoice_submit_mail"                         =>"Buyer Invoice Submitting Email",
        "aeon_invoice_submit_mail"                          =>"Aeon Invoice Submitting Email",
        "vendor_create_schedule_mail"                       =>"Vendor Invoice Submitting Email",
        "manufacturer_create_schedule_mail"                 =>"Sub Vendor Invoice Submitting Email",
        "aeon_create_schedule_mail"                         =>"Sub Vendor Invoice Submitting Email",
        "vendor_exception_mail"                             =>"Vendor Exception Email",
        "manufacturer_exception_mail"                       =>"Sub Vendor Exception Email",
        "aeon_exception_mail"                               =>"Aeon Exception Email",
        "Vendor_critical_mail"                              =>"Vendor Critical Email",
        "manufacturer_critical_mail"                        =>"Sub Vendor Critical Email",
        "aeon_critical_mail"                                =>"Aeon Critical Email",
        "contact_mail"                                      => "Contact Email",
        "signup_mail"                                       => "Signup Email",
        "vendor_registration_confirmation"                  => "Vendor Registration Confirmation",
        "buyer_registration_confirmation"                   => "Buyer Registration Confirmation",
        "manufacturer_registration_confirmation"            => "Sub Vendor Registration Confirmation",
        "aeon_registration_confirmation"                    => "Aeon Registration Confirmation",
        "vendor_password_change"                            => "Vendor Password Change",
        "manufacturer_password_change"                      => "Manufacturer Password Change",
        "buyer_password_change"                             => "Buyer Password Change",
        "aeon_password_change"                              => "Aeon Password Change",
        "vendor_email_verification"                         => "Vendor Email Verification",
        "manufacturer_email_verification"                   => "Sub Vendor Email Verification",
        "buyer_email_verification"                          => "Buyer Email Verification",
        "aeon_email_verification"                           => "Aeon Email Verification",
        "password_reset"                                    => "Password Reset",
    ];
    /**
     * Email Template List
     */
    public function index(){
        try{
            $templates = EmailTemplate::get();
            $this->data["template"] = EmailTemplateResource::collection($templates);
            $this->apiSuccess("Email Template loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Email Template Create
     * @return Available Template
     */
    public function create(){
        try{
            $template_type = EmailTemplate::select("email_type")->pluck("email_type")->toArray();
            $template_type = array_diff($this->template_type, $template_type);
            $this->data["types"] = $template_type;
            $this->apiSuccess("Template Type loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Store Template Design
     */
    public function store(Request $request){
        try{
            $template_type = $this->template_type;
            $validator = Validator::make($request->all(), [
                "email_type"    => ["required", "string", Rule::in(array_keys($template_type))],
                "subject"       => ["required", "string"],
                "mail_send"     => ["required", "boolean"],
                "cc"            => ["nullable", "string"],
                "template"      => ["nullable", "string"]
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator));
            }

            $template = new EmailTemplate();
            $template->email_type   = $request->email_type;
            $template->subject      = $request->subject;
            $template->mail_send    = $request->mail_send;
            $template->cc           = $request->cc;
            $template->template     = $request->template;
            $template->created_by   = $request->user()->id;
            $template->save();

            $this->data["email_templates"] = new EmailTemplateResource($template);
            $this->apiSuccess("Template Configuration Added Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Update Template
     */
    public function update(Request $request){
        try{
            $template_type = $this->template_type;
            $validator = Validator::make($request->all(), [
                "id"            => ["required", "exists:email_templates,id"],
                "subject"       => ["required", "string"],
                "email_type"    => ["required", "string", Rule::in(array_keys($template_type))],
                "mail_send"     => ["required", "boolean"],
                "cc"            => ["nullable", "string"],
                "template"      => ["nullable", "string"]
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator));
            }

            $template = EmailTemplate::find($request->id);
            $template->email_type   = $request->email_type;
            $template->subject      = $request->subject;
            $template->mail_send    = $request->mail_send;
            $template->cc           = $request->cc;
            $template->template     = $request->template;
            $template->updated_by   = $request->user()->id;
            $template->save();

            $this->data["email_templates"] = new EmailTemplateResource($template);
            $this->apiSuccess("Template Configuration Updated Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * View Configuration
     */
    public function view(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "id"            => ["required", "exists:email_templates,id"],
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator));
            }

            $template = EmailTemplate::withTrashed()->find($request->id);
            //$template = EmailTemplate::find($request->id);
            $template_type_use = EmailTemplate::select("email_type")
                ->where("email_type", "!=", $template->email_type)->pluck("email_type")->toArray();
            $template_type = array_diff($this->template_type, $template_type_use);

            $this->data["types"] = $template_type;
            $this->data["email_templates"] = new EmailTemplateResource($template);
            $this->apiSuccess("Template Configuration loaded Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }

    /**
     * Delete  Configuration
     */
    public function delete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                "id"            => ["required", "exists:email_templates,id"],
            ]);
            if($validator->fails()){
                return $this->apiOutput($this->getValidationError($validator));
            }
            EmailTemplate::where("id", $request->id)->delete();
            $this->apiSuccess("Template Configuration Deleted Successfully");
            return $this->apiOutput();
        }catch(Exception $e){
            return $this->apiOutput($this->getError($e), 500);
        }
    }
}
