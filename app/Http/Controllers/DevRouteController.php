<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app;
use App\Models\Product;
use App\Models\Proposal;
use App\Models\Proposalenquiry;
use App\Models\Team;
use App\User;
use Illuminate\Support\Facades\Http;
use App\Models\UserShop;
use App\Models\Quotation;
use App\Models\Consignee;
use App\Models\survey;
use App\Models\GroupProduct;
use App\Models\MailSmsTemplate;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Illuminate\Support\Facades\DB;

// Using In Thumbnail Creation
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File as FacadesFile;

class DevRouteController extends Controller
{

    private function state() {
                $user_id = auth()->id();
                $user = App\User::whereId($user_id)->first();
                $survey_form = survey::whereUserId($user_id)->first();


                $survey_progress = 0;
                if ($survey_form != null && $survey_form->response != null) {
                    $survey_progress = 30;
                }


                $ekyc_progress = 0;
                if($user->ekyc_status == 1){
                    $ekyc_progress = 60;
                }

                $sum = $survey_progress + $ekyc_progress ;

                return  $sum;

            }




    public function jaya() {

        magicstring($this->state());


        return;
    }



    public function jayaform(){
        return view('devloper.jaya.form-check');
    }


    public function ashish(Request $request) {



        // Seller En-role Onsite
        $onsite_notification['user_id'] = auth()->id();
        $onsite_notification['title'] = "Suppport Ticket Resolved";
        $onsite_notification['link'] = route('customer.ticket.show',18);
        $onsite_notification['notification'] = "Your Suppport Ticket has been Resolved";


        pushOnSiteNotification($onsite_notification);
        

        if ($request->has('sendmail') ) {

            $user = User::where('id', auth()->id())->first();
            $email = $request->get('email','121pagedesign3@gmail.com');

            $mailcontent_data = MailSmsTemplate::where('code','=',"Welcome")->first();
            if($mailcontent_data){
                $arr=[
                    '{id}'=>auth()->id(),
                    '{app_name}'=>'121.page',
                    '{name}'=>NameById(auth()->id()),
                    ];
                $action_button = null;

                $sent = TemplateMail($user->name,$mailcontent_data,"121pagedesign3@gmail.com",$mailcontent_data->type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button);

                // $sent = TemplateMail("Ashish", $mailcontent_data->body, $email, 1, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button = null);

            }

            magicstring($sent);

            return;
        }




        //` Uncomment Below Line to Check Available Sessions..
        if ($request->has('devwork') || $request->has('ashish') || $request->has('jaya')) {
            echo "<h1 style='color:red'>Do Not Share This Link WIth Anyone...</h1>";
            magicstring(session()->all());

        }else{
            return abort(404);
        }
    }


    private function checkPerformaInvoiceSlug($mark, $num, $userid) {
        $slug = $mark . "/" . $num;
        $chk = Quotation::where('user_id', $userid)->where('user_slug', $slug)->first();

        if ($chk == null) {
            $checkConsignee = Consignee::where('user_id', $userid)->get();

            foreach ($checkConsignee as $key => $value) {
                $jsoncheck = json_decode($value->consignee_details);

                if (isset($jsoncheck->p_id) && $jsoncheck->p_id == $slug) {
                    $num = $num + 1;
                    return  $this->checkPerformaInvoiceSlug($mark, $num, $userid); // Recursively call the function
                }
            }

            return $slug; // Return the slug if it doesn't exist
        }

        $num = $num + 1;
        return $this->checkPerformaInvoiceSlug($mark, $num, $userid); // Recursively call the function
    }



    public function imagestudio(Request $request){
        return view('devloper.underDev.PhotoStudio');
    }








}
