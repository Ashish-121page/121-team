<?php

use App\Models\Inventory;
use App\Models\LockEnquiry;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Models\ProductExtraInfo;
use App\Models\TimeandActionModal;
use Carbon\Carbon;
use Twilio\Rest\Client;
// from shn

// for dynamic mail

if (!function_exists('DynamicMailTemplateFormatter')) {
    function DynamicMailTemplateFormatter($body, $variable_names, $var_list)
    {
        // Make it Foreachable
        // return $variable_names;
        $variable_names = explode(', ', $variable_names);
        $i = 1;
        $data = "";
        foreach ($variable_names as $item) {
            if ($i == 1) {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $body);
                    $i += 1;
                }
            } else {
                if(array_key_exists($item,$var_list)){
                    $data =  str_replace($item, $var_list[$item], $data);
                }
            }
        }
        return $data;
    }
}

// custommail template with template table
if (!function_exists('asset')) {
    function asset($path,$secure=null){
        $timestamp = @filemtime(public_path($path)) ?: 0;
        return asset($path, $secure) . '?' . $timestamp;
    }
}

if(!function_exists('productExistInUserShop')){
    function productExistInUserShop($product_id,$user_id,$user_shop){
        return  App\Models\UserShopItem::whereProductId($product_id)->whereUserId($user_id)
                    ->whereUserShopId($user_shop)->first();
    }
}

// custommail template with template table
if (!function_exists('customMail')) {
    function customMail($name,$to,$mailcontent_data,$arr,$cc = null ,$bcc = null ,$action_btn = null ,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null){
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $mailcontent_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mailcontent_data->footer;
        $t_data = DynamicMailTemplateFormatter($mailcontent_data->body ,$mailcontent_data->variables ,$arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_btn;
        $data['attachment_path'] = $attachment_path;
        $data['attachment_name'] = $attachment_name;
        $data['cc'] = $cc == null ? [] : $cc;
        $data['bcc'] = $bcc == null ? [] : $cc;
        if($mailcontent_data->type == 1){
           $mail = \Mail::to($to);
           if($cc != null){
                $mail->cc($cc, getSetting('mail_from_name'));
            }
            if($bcc != null){
                $mail->bcc($bcc, getSetting('mail_from_name'));
            }

            $mail->send(new App\Mail\CustomMail($data));
        }
        if($mailcontent_data->type == 2){
            // sms
            manualSms($to,$t_data);
        }
        if($mailcontent_data->type == 3){
            // whatsapp
        }
    }
}
// custommail template with template table
if (!function_exists('TemplateMail')) {
    function TemplateMail($name, $code, $to, $mail_type, $arr, $mailcontent_data, $chk_data = null ,$mail_footer = null, $action_button = null)
    {
        $to = $to;
        $data['name'] = $name;
        $name = $name;
        $data['subject'] = DynamicMailTemplateFormatter($mailcontent_data->title, $mailcontent_data->variables, $arr);
        $subject = $mailcontent_data->title;
        $data['type_id'] = $mail_type;
        $type_id = $mail_type;
        $chk_data = $mailcontent_data;
        $data['t_footer'] = $mail_footer;

        $t_data =  DynamicMailTemplateFormatter($mailcontent_data->body, $mailcontent_data->variables, $arr);
        $data['t_data'] = $t_data;
        $data['action_button'] = $action_button;

        // Mail Sender
        try{
            \Mail::send('emails.dynamic-custom', $data, function ($message) use ($to, $name, $subject) {
                $message->to($to, $name)->subject($subject);
                $message->from(getSetting('mail_from_address'), getSetting('app_name'));
            });
        }catch(Exception $e){
            return $e->getMessage();
        }
        return true;
    }
}

// manual Email without template table
if (!function_exists('StaticMail')) {
    function StaticMail($name, $to, $subject, $body, $mail_footer = null, $action_button = null, $cc = null, $bcc = null,$attachment_path = null ,$attachment_name = null ,$attachment_mime = null)
    {
        if($cc == null){
            $cc = '';
        }
        if($bcc == null){
            $bcc = '';
        }
        $data['name'] = $name;
        $data['subject'] = $subject;
        $data['t_footer'] = $mail_footer;
        $data['t_data'] = $body;
        $data['action_button'] = $action_button;

        // Mail Sender
        try{
            \Mail::send('emails.dynamic-custom', $data, function ($body) use ($to, $name,$cc, $bcc, $subject,$attachment_path,$attachment_name,$attachment_mime) {
                $body->to($to, $name)->subject($subject);
                if($cc != null){
                    $body->cc($cc,getSetting('mail_from_name'));
                }
                if($bcc != null){
                    $body->bcc($bcc, getSetting('mail_from_name'));
                }
                if($attachment_path != null)
                {
                    $body->attach($attachment_path, [
                            'as'    => $attachment_name,
                            'mime'  => $attachment_mime,
                        ]);
                }
                $body->from(getSetting('mail_from_address'), getSetting('mail_from_name'));
            });
            return "done";
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
// Send Sms By Api
if (!function_exists('sendSms')) {
    function sendSms($number,$msg,$template_id,$send_id = "onpage"){
        // $number must be comma separated values
        // $msg must be normal text
        $response = Http::get('https://sms.adservs.co.in/vb/apikey.php', [
            'apikey' => 'aLYPnJtV9o16Ouoj',
            'number' => "91".$number,
            'message' => $msg,
            'senderid' => $send_id ?? "onpage",
            'route' => 1,
            'templateid' => $template_id,
        ]);
        if($response){
            return $response;
        }else{
            return false;
        }
    }
}

// manual SMS By Twilio Account
if (!function_exists('manualSms')) {
    function manualSms($number,$msg)
    {
        $accountSid = getSetting('twilio_account_sid');
        $authToken  = getSetting('twilio_auth_token');
        $accountnumber  = getSetting('twilio_account_number');
        $client = new Client($accountSid, $authToken);
        $client->messages->create('+91'.$number,
            array(
                'from' => $accountnumber,
                'body' => $msg
            )
        );
    }
}


// old data recover
if (!function_exists('selectSelecter')) {
    function selectSelecter($old_val, $updated_val, $compare_val)
    {
        if ($old_val != null) {
            $result = $old_val == $compare_val ? "selected" : '';
        } elseif ($updated_val != null) {
            $result = $updated_val == $compare_val ? "selected" : '';
        } else {
            $result = '';
        }
        return $result;
    }
}

// from DFV

// currency amount cleaner
if (!function_exists('currencyAmountCleaner')) {
    function currencyAmountCleaner($val)
    {
        $x = substr($val, 1);
        return str_replace(',', '', $x);
    }
}


// from albuhaira
// Age Calculator
function ageCalculator($dob)
{
    if (!empty($dob)) {
        $birthdate = new DateTime($dob);
        $today   = new DateTime('today');
        $age = $birthdate->diff($today)->y;
        return $age;
    } else {
        return 0;
    }
}
// get Browser
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version= $matches['version'][0];
        } else {
            $version= $matches['version'][1];
        }
    } else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {
        $version="?";
    }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

// get Image
if(!function_exists('getImage')){
    function getImage($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}
if(!function_exists('uploaded_asset')){
    function uploaded_asset($path = null,$name = null, $type = 'placeholder'){
        if($name != null){
          return  '<img src="'.$path.'">';
        }else{
            if($type == 'placeholder'){
              return  '<img src={{'.asset("frontend/images/placeholder.png").'}}>';
            }
        }
    }
}

// check and create dir
if(!function_exists('checkAndCreateDir')){
    function checkAndCreateDir($path){
        // Create directory if not exist
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
    }
}
if(!function_exists('getBrandStatus')){
    function getBrandStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Inactive",'color'=>'danger'],
            ['id'=>1,'name'=>"Active",'color'=>'success'],
        ];
        }else{
            foreach(getBrandStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}

if(!function_exists('getBrandRequestStatus')){
    function getBrandRequestStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Pending",'color'=>'secondary'],
            ['id'=>1,'name'=>"Accepted",'color'=>'success'],
            ['id'=>2,'name'=>"Rejected",'color'=>'danger'],
        ];
        }else{
            foreach(getBrandRequestStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getVerifiedStatus')){
    function getVerifiedStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Non Verified",'color'=>'danger'],
            ['id'=>1,'name'=>"Verified",'color'=>'success'],
        ];
        }else{
            foreach(getVerifiedStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getProposalStatus')){
    function getProposalStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Draft",'color'=>'warning'],
            ['id'=>1,'name'=>"Saved",'color'=>'success'],
        ];
        }else{
            foreach(getProposalStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}

if(!function_exists('getBrandRecordByProductId')){
    function getBrandRecordByProductId($product_id){
        $product_record = App\Models\Product::whereId($product_id)->first();
        if($product_record ){
            $brand_record = App\Models\Brand::whereId($product_record->brand_id)->first();
            return $brand_record;
        }else{
            return null;
        }
    }
}
if(!function_exists('getBrands')){
    function getBrands(){
       return App\Models\Brand::whereStatus(1)->get();
    }
}
if(!function_exists('getVerifiedBrands')){
    function getVerifiedBrands(){
       return App\Models\Brand::whereStatus(1)->where('is_verified',1)->get();
    }
}
if(!function_exists('getBrandById')){
    function getBrandById($id){
       return App\Models\Brand::whereId($id)->first();
    }
}
if(!function_exists('getShopDataByUserId')){
    function getShopDataByUserId($user_id){
       return App\Models\UserShop::whereUserId($user_id)->first();
    }
}
if(!function_exists('getSellerLinkedCount')){
    function getSellerLinkedCount($user_id){
       $count =  App\Models\UserShopItem::whereUserId($user_id)
                    ->where('parent_shop_id' ,'!=',0)
                    ->count();
        return $count;
    }
}
if(!function_exists('getShopDataByShopId')){
    function getShopDataByShopId($shop_id){
       return App\Models\UserShop::whereId($shop_id)->first();
    }
}
if(!function_exists('getBrandProducts')){
    function getBrandProducts($brand_id){
          return App\Models\Product::whereBrandId($brand_id)->get();
    }
}
if(!function_exists('getBrandProductsBySku')){
    function getBrandProductsBySku($brand_id){
        return App\Models\Product::whereBrandId($brand_id)->groupBy('sku')->get();
    }
}
if(!function_exists('getGroupNameById')){
    function getGroupNameById($g_id){
        return App\Models\Group::whereId($g_id)->first() ?? '';
    }
}
if(!function_exists('getProductColorBySku')){
    function getProductColorBySku($sku){
        return  $product = App\Models\Product::whereSku($sku)->groupBy('color')->get();
    }
}
if(!function_exists('getProductColorBySkuColor')){
    function getProductColorBySkuColor($sku,$color){
        return  $product = App\Models\Product::whereSku($sku)->where('color',$color)->get();
    }
}
if(!function_exists('getProductsCountByUserShopId')){
    function getProductsCountByUserShopId($user_shop){
          return App\Models\UserShopItem::whereUserShopId($user_shop)->whereIsPublished(1)->count();
    }
}
if(!function_exists('getProductRecordById')){
    function getProductRecordById($product_id){
        return App\Models\UserShopItem::whereProductId($product_id)->first();
    }
}
if(!function_exists('getProductProposalPriceByProposalId')){
    function getProductProposalPriceByProposalId($proposal_id,$product_id){
        return App\Models\ProposalItem::whereProposalId($proposal_id)->where('product_id',$product_id)->first()->price??0;
    }
}
if(!function_exists('getShopProductImage')){
    function getShopProductImage($product_id, $mode = 'single'){
        if($mode == "single"){
            return App\Models\Media::whereType('Product')->whereTypeId($product_id)->whereTag('Product_Image')->first();
        }else{
            return App\Models\Media::whereType('Product')->whereTypeId($product_id)->whereTag('Product_Image')->get();
        }
    }
}
if(!function_exists('getMediaByIds')){
    function getMediaByIds($image_ids = [], $mode = 'single'){
        if($mode == "single"){
            return App\Models\Media::whereIn('id',$image_ids)->first();
        }else{
            return App\Models\Media::whereIn('id',$image_ids)->get();
        }
    }
}
if(!function_exists('getUserVcardImage')){
    function getUserVcardImage($user_id){
        return App\Models\Media::whereType('UserVcard')->whereTypeId($user_id)->whereTag('vcard')->first();
    }
}
if(!function_exists('getUserActivePackage')){
    function getUserActivePackage($user_id){
        $user_pack = App\Models\UserPackage::whereUserId($user_id)->whereDate('to','>=',\Carbon\Carbon::now())->latest()->first();
        if($user_pack){
            return App\Models\Package::whereId($user_pack->package_id)->first();
        }else{
            return null;
        }
    }
}
if(!function_exists('getUserPackageInfo')){
    function getUserPackageInfo($user_id){
        $user_pack = App\Models\UserPackage::whereUserId($user_id)->whereDate('to','>=',\Carbon\Carbon::now())->latest()->first();
        if($user_pack){
            return $user_pack;
        }else{
            return null;
        }
    }
}
if(!function_exists('haveActivePackageByUserId')){
    function haveActivePackageByUserId($user_id){
        $have_package = App\Models\UserPackage::whereUserId($user_id)->whereDate('to','>=',\Carbon\Carbon::now())->latest()->first();
        return $have_package;
        if($have_package){
            return true;
        }else{
            return false;
        }
    }
}
if(!function_exists('getShopLogo')){
    function getShopLogo($slug){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        return $user_shop->logo ?? 'frontend/assets/img/placeholder.png';
    }
}
if(!function_exists('getSellerPhoneBySlug')){
    function getSellerPhoneBySlug($slug){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        return $user_shop->user->phone ?? null;
    }
}
if(!function_exists('checkShopView')){
    function checkShopView($slug){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        return $user_shop->shop_view == 1 ? true : false;
    }
}
if(!function_exists('haveInstagramLink')){
    function haveInstagramLink($slug){
        $user_id = App\Models\UserShop::whereSlug($slug)->first()->user_id;
        if($user_id){
            $user = App\User::whereId($user_id)->first();
            if($user){
             return  $instagram_link = $user->instagram_link ?? null;
            }
        }
    }
}
if(!function_exists('getProductType')){
    function getProductType($id = -1){
        if($id == -1){
        return [
            ['id'=>1,'name'=>"Single",'color'=>'warning','active'=>1],
            ['id'=>2,'name'=>"Bundle ",'color'=>'info','active'=>0],

        ];
        }else{
            foreach(getProductType() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getProductStatus')){
    function getProductStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Available",'color'=>'success'],
            ['id'=>1,'name'=>"Unavailable",'color'=>'danger'],
        ];
        }else{
            foreach(getProductStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getUserShopStatus')){
    function getUserShopStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Active",'color'=>'success'],
            ['id'=>1,'name'=>"Inactive",'color'=>'danger'],

        ];
        }else{
            foreach(getUserShopStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getGroupType')){
    function getGroupType($id = -1){
        if($id == -1){
        return [
            ['id'=>1,'name'=>"System Define",'color'=>'primary'],
            ['id'=>0,'name'=>"User Define",'color'=>'danger'],

        ];
        }else{
            foreach(getGroupType() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}
if(!function_exists('getCatalogueRequestStatus')){
    function getCatalogueRequestStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"Pending",'color'=>'secondary'],
            ['id'=>1,'name'=>"Accepted",'color'=>'success'],
            ['id'=>2,'name'=>"Rejected",'color'=>'danger'],
            ['id'=>3,'name'=>"Ignored",'color'=>'primary'],
            ['id'=>4,'name'=>"Connect",'color'=>'primary'],

        ];
        }else{
            foreach(getCatalogueRequestStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}

if(!function_exists('getEnquiryStatus')){
    function getEnquiryStatus($id = -1){
        if($id == -1){
        return [
            ['id'=>0,'name'=>"New" ,'color' =>"primary"],
            ['id'=>1,'name'=>"Completed",'color' =>"success"],
            ['id'=>2,'name'=>"Cancelled",'color' =>"danger"],
            ['id'=>3,'name'=>"Hold",'color' =>"warning"],
            ['id'=>4,'name'=>"Open",'color' =>"warning"],

        ];
        }else{
            foreach(getEnquiryStatus() as $row){
                if($id == $row['id']){
                return $row;
            }
        }
        return ['id'=>0,'name'=>'','color'=>''];
        }
    }
}

if(!function_exists('getSystemPriceGroups')){
    function getSystemPriceGroups(){
        return App\Models\Group::whereType(1)->get();
    }
}

if(!function_exists('syncSystemPriceGroups')){
    function syncSystemPriceGroups($user_id){
        $data = getSystemPriceGroups();
        foreach($data as $item){
             App\Models\Group::create([
                 'user_id' => $user_id,
                 'type' => 0,
                 'name' => $item->name,
             ]);
        }
    }
}
if(!function_exists('getAdminId')){
    function getAdminId(){
        return App\User::role('Admin')->first();
    }
}
if(!function_exists('marketerList')){
    function marketerList(){
        return App\User::role('Marketer')->get();
    }
}
if(!function_exists('getBrandByOwner')){
    function getBrandByOwner($user_id){
        return App\Models\Brand::whereUserId($user_id)->first();
    }
}
if(!function_exists('getBrandRecordByBrandId')){
    function getBrandRecordByBrandId($brand_id){
        return App\Models\Brand::whereId($brand_id)->first();
    }
}
if(!function_exists('checkBrandProductCreate')){
    function checkBrandProductCreate($brand_id){
        $brand_user = App\Models\BrandUser::whereBrandId($brand_id)->where('type',0)->where('status',1)->first();
        if($brand_user){
            if($brand_user->user_id == auth()->id()){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}

if(!function_exists('getProductCategoryByUserIndrustry')){
    function getProductCategoryByUserIndrustry($indrustries){
          $indrustries = json_decode($indrustries);
         if (AuthRole() != 'Admin') {
                $self_data = @App\Models\Category::whereType(0)->whereUserId(auth()->id())->whereIn('parent_id',$indrustries)->get();
                $data = @App\Models\Category::whereType(1)->whereIn('parent_id',$indrustries)->get();
                return @$self_data->merge($data);

            } else {
                return App\Models\Category::where('level',2)->where('category_type_id',13)->get();
            }
    }
}
if(!function_exists('getProductCategory')){
    function getProductCategory(){
        return App\Models\Category::where('level',2)->where('category_type_id',13)->get();
    }
}

if (!function_exists('getPriceAskRequestStatus')) {
function getPriceAskRequestStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>0,'name'=>'Pending','color'=>'primary'],
                ['id'=>1,'name'=>'Accepted','color'=>'success'],
                ['id'=>2,'name'=>'Rejected','color'=>'danger'],
                ];
            }else{
                foreach(getPriceAskRequestStatus() as $row){
                if($row['id'] == $id){
                return $row;
                }
            }
        }
    }
}
if (!function_exists('getSupportTicketStatus')) {
function getSupportTicketStatus($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>0,'name'=>'Under Working','color'=>'secondary'],
                ['id'=>1,'name'=>'Reply Received','color'=>'warning'],
                ['id'=>2,'name'=>'Resolved','color'=>'success'],
                ['id'=>3,'name'=>'Rejected','color'=>'danger'],
                ['id'=>4,'name'=>'Close','color'=>'danger'],
                ];
            }else{
                foreach(getSupportTicketStatus() as $row){
                if($row['id'] == $id){
                return $row;
                }
            }
        }
    }
}
if(!function_exists('getProductCategoryByShop')){
    function getProductCategoryByShop($slug, $type = 1){

        // if type 1 = industry wise, 0 = product wise

        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        if(!$user_shop){
            return null;
        }

        $user = App\User::whereId($user_shop->user_id)->first();
        if(!$user){
            return null;
        }


        if($type == 1){
            if($user->industry_id == null){
                return null;
            }


            if($user->industry_id == null){
                $my_indrustry == [];
            }else{
                $my_indrustry = json_decode($user->industry_id, true);
            }
            $self_category = App\Models\Category::whereUserId($user->id)->where('level',2)->where('category_type_id',13)->whereType(0)->get();
            $category = App\Models\Category::whereType(1)->where('level',2)->where('category_type_id',13)->whereIn('parent_id',$my_indrustry)->get();

            // $category = $self_category->merge($category);

            if(count($self_category)>0 && count($category)>0){
                $category = $self_category->merge($category);
            }elseif(count($self_category)>0){
                return $self_category;
            }elseif(count($category)>0){
                return $category;
            }else{
                return null;
            }

        }else{
            $my_product_category_ids = App\Models\UserShopItem::whereUserId($user->id)->whereIsPublished(1)->whereUserShopId($user_shop->id)->pluck('category_id');

            $category = App\Models\Category::whereIn('id',$my_product_category_ids)->get();

            if($category->count()>0){
               return $category;
            }else{
                return null;
            }
        }


        return $category;
    }
}

if(!function_exists('getProductSubCategoryByShop')){
    function getProductSubCategoryByShop($slug, $parent_id, $type = 1){

         // if type 1 = indrustry wise, 0 = product wise

        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        if(!$user_shop){
            return null;
        }

        $user = App\User::whereId($user_shop->user_id)->first();
        if(!$user){
            return null;
        }

        if($type == 1){
            if($user->industry_id == null){
                return null;
            }
            $my_indrustry = json_decode($user->industry_id, true);

            $self_category = App\Models\Category::whereParentId($parent_id)->whereUserId($user->id)->where('level',3)->where('category_type_id',13)->whereType(0)->get();

            $category = App\Models\Category::whereParentId($parent_id)->whereType(1)->where('level',3)->where('category_type_id',13)->get();

            $category = $self_category->merge($category);
        }else{
            $my_product_category_ids = App\Models\UserShopItem::whereUserId($user->id)->whereUserShopId($user_shop->id)->whereCategoryId($parent_id)->pluck('sub_category_id');

            $category = App\Models\Category::whereIn('id',$my_product_category_ids)->get();
        }

        return $category;
    }
}
if(!function_exists('getProductByUserShopItem')){
    function getProductByUserShopItem($slug,$request = null ){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();

        $products =  App\Models\Product::query();
        if($request != null && $request->has('title')){
            $products->where('title','like','%'.$request->get('title').'%');
        }
        if($request != null && $request->has('stock') && $request->get('stock') != 'null' && $request->get('stock') != null){
            if($request->get('stock') == 1){
                $products->where('stock_qty','>=','1');
            }else{
                $products->where('stock_qty','<','1');
            }
        }
        if($request != null && $request->has('color') && $request->get('color') != 'null' && $request->get('color') != null){
            $products->whereIn('color',$request->get('color'));
        }
        if($request != null && $request->has('size') && $request->get('size') != 'null' && $request->get('size') != null){
            $products->whereIn('size',$request->get('size'));
        }
        if($request != null && $request->has('brand')  && $request->get('brand') != null){
            $products->where('brand_id',$request->get('brand'));
        }

        if($request != null && $request->has('size')  && $request->get('size') != null){
            $products->where('size',$request->get('size'));
        }

        $product_ids = $products->groupBy('sku')->pluck('id');

        $user_shop_items =  App\Models\UserShopItem::query();

        if($request != null && $request->has('from')  && $request->get('from') != null &&  $request->has('to')  && $request->get('to') != null){
            if($request->to == 10){
                $user_shop_items->where('price','>=',$request->from);
            }else{
                $user_shop_items->whereBetween('price', [$request->from, $request->to]);
            }
        }
        if($request != null && $request->has('category_id') && $request->get('category_id') != null){
            $user_shop_items->where('category_id',$request->get('category_id'));
        }
        if($request != null && $request->has('sub_category_id')  && $request->get('sub_category_id') != null){
            $user_shop_items->where('sub_category_id',$request->get('sub_category_id'));
        }
        if($request != null && $request->has('sort')){
            if($request->sort == 1){
                $user_shop_items->orderBy('id','DESC');
            }elseif($request->sort == 2){
                $user_shop_items->orderBy('price','ASC');
            }elseif($request->sort == 3){
                $user_shop_items->orderBy('price','DESC');
            }
        }
        $result = $user_shop_items->where('user_shop_id',$user_shop->id)
                        ->whereIn('product_id',$product_ids)
                        // ->with('products',function($q){
                        //     $q->pluck('id');
                        // })
                        // ->with('products',function($q) use($product_ids){
                        //     $q->whereIn('id',$product_ids)->pluck('id');
                        // })
                        ->whereIsPublished(1)
                        ->groupBy('product_id')
                        ->paginate(50);
        return $result;
    }
}
if(!function_exists('getWorkStreamAttachment')){
    function getWorkStreamAttachment($name){
     return asset('storage/backend/workstream-attachment/'.$name);
    }
}

if(!function_exists('getUserProgressStatistics')){
    function getUserProgressStatistics($user_id){
        $user = App\User::whereId($user_id)->first();
        $user_vcard = App\Models\Media::whereType('UserVcard')->whereTypeId($user->id)->exists();
        $user_shop = App\Models\UserShop::whereUserId($user_id)->first();
        $story = json_decode($user_shop->story);
        $description = $story->description ?? null;

        if($user->email_verified_at != null){
            $email_verified = 10;
        }else{
            $email_verified = 0;
        }

        if($user_shop->logo != null){
            $logo = 10;
        }else{
            $logo = 0;
        }

        if($user_vcard){
            $vcard = 25;
        }else{
            $vcard = 0;
        }

        // TODO: if story of description is not empty then calculate
        if($description != null){
            $about = 15;
        }else{
            $about = 0;
        }

        if(!str_contains($user->avatar, 'ui-avatars.com')){
            $avatar = 25;
        }else{
            $avatar = 0;
        }

        if($user_shop->social_links != null){
            $social_links = 15;
        }else{
            $social_links = 0;
        }

        return   $sum =  $email_verified + $logo + $vcard + $about + $avatar + $social_links;
    }
}
if(!function_exists('getSellerProgressStatistics')){
    function getSellerProgressStatistics($user_id){
        // return 29;
        $user = App\User::whereId($user_id)->first();
        $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
        $team_rec = App\Models\Team::whereUserShopId($user_shop->id)->exists();
        $testimonial_rec = App\Models\UserShopTestimonal::whereUserShopId($user_shop->id)->exists();
        $access_cat_req = App\Models\AccessCatalogueRequest::whereUserId($user->id)->whereStatus(1)->exists();

        if(isset($user_shop) &&  $user_shop->slug != null){
            $user_shop = 50;
        }else{
            $user_shop = 0;
        }
        if($user->ekyc_status == 1){
            $kyc = 50;
        }else{
            $kyc = 0;
        }

        // if($team_rec){
        //     $team    = 25;
        // }else{
        //     $team    = 0;
        // }

        // if($testimonial_rec){
        //     $testimonial    = 10;
        // }else{
        //     $testimonial    = 0;
        // }

        // if($user_shop->payment_details != null){
        //     $pay_qr    = 20;
        // }else{
        //     $pay_qr    = 0;
        // }

        // if($access_cat_req){
        //     $link_supplier    = 50;
        // }else{
        //     $link_supplier    = 0;
        // }



        return $sum = $kyc + $user_shop ;
    }
}
function makeLinks($str) {
  $reg_exUrl = "/(http|https|ftp|ftps)\\:\\/\\/[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}(\\/\\S*)?/";
  $urls = array();
  $urlsToReplace = array();
  if (preg_match_all($reg_exUrl, $str, $urls)) {
      $numOfMatches = count($urls[0]);
      $numOfUrlsToReplace = 0;
      for ($i = 0;$i < $numOfMatches;$i++) {
          $alreadyAdded = false;
          $numOfUrlsToReplace = count($urlsToReplace);
          for ($j = 0;$j < $numOfUrlsToReplace;$j++) {
              if ($urlsToReplace[$j] == $urls[0][$i]) {
                  $alreadyAdded = true;
              }
          }
          if (!$alreadyAdded) {
              array_push($urlsToReplace, $urls[0][$i]);
          }
      }
      $numOfUrlsToReplace = count($urlsToReplace);
      for ($i = 0;$i < $numOfUrlsToReplace;$i++) {
          $url = '<a rel="noopener noreferrer" target="_blank" class="btn btn-link px-0 py-1" href='.'"'.$urlsToReplace[$i].'">'.$urlsToReplace[$i].'</a>';
          $str = str_replace($urlsToReplace[$i], $url , $str);

      }
      return $str;
  } else {
      return $str;
  }
}
if(!function_exists('getProductByUserShopItemInRandomOrder')){
    function getProductByUserShopItemInRandomOrder($slug){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
        $user_shop_items =  App\Models\UserShopItem::whereIsPublished(1)->where('user_shop_id',$user_shop->id)->groupBy('product_id')->get();
        $product_ids = $user_shop_items->pluck('product_id');
        return $products =  App\Models\Product::whereIn('id',$product_ids)->groupBy('sku')->inRandomOrder()->get();
    }
}

if(!function_exists('getMyProductOfBrand')){
    function getMyProductOfBrand($slug,$brand_id){
        $user_shop = App\Models\UserShop::whereSlug($slug)->first();
         $product_ids =  App\Models\UserShopItem::whereIsPublished(1)->where('user_shop_id',$user_shop->id)->pluck('product_id');
         return App\Models\Product::where('brand_id',$brand_id)->whereIn('id',$product_ids)->groupBy('sku')->get();
    }
}
if(!function_exists('getUserShopItemByProductId')){
    function getUserShopItemByProductId($slug, $product_id){
        $user_shop_id = UserShopIdBySlug($slug);

       return $user_shop_item =  App\Models\UserShopItem::whereUserShopId($user_shop_id)->where('product_id',$product_id)->first();
    }
}
if(!function_exists('isSeller')){
    function isSeller($user_id){
         $user =  App\User::where('id',$user_id)->first();
         if($user && $user->is_supplier == 1){
            return true;
         }
         return false;
    }
}
if(!function_exists('getGSTNumberAndEntityByUserShopId')){
    function getGSTNumberAndEntityByUserShopId($user_shop_id){
        $user_shop = App\Models\UserShop::whereId($user_shop_id)->first();
        return $address = json_decode($user_shop->address,true) ?? null;
    }
}
if(!function_exists('isBrandBO')){
    function isBrandBO($brand_id, $user_id){
         $user =  App\Models\BrandUser::where('brand_id',$brand_id)->whereUserId($user_id)->whereType(0)->whereStatus(1)->first();
         if($user){
            return $user;
         }
         return false;
    }
}
if(!function_exists('isBrandAS')){
    function isBrandAS($brand_id, $user_id){
         $user =  App\Models\BrandUser::where('brand_id',$brand_id)->whereUserId($user_id)->whereType(1)->whereStatus(1)->first();
         if($user){
            return $user;
         }
         return false;
    }
}
if(!function_exists('getBrandUserByUserId')){
    function getBrandUserByUserId($brand_id, $user_id, $type){
         $user =  App\Models\BrandUser::where('brand_id',$brand_id)
         ->whereUserId($user_id)
         ->whereType($type)
         ->first();

         return $user;
    }
}
if(!function_exists('getCartData')){
    function getCartData($user_shop_id, $user_id){
        return App\Models\Cart::whereUserId($user_id)->whereUserShopId($user_shop_id)->get();
    }
}
if(!function_exists('getShopSlugByUserId')){
    function getShopSlugByUserId($user_id){
        return App\Models\UserShop::whereUserId($user_id)->first()->slug;
    }
}
if(!function_exists('getSupportTicketPrefix')){
    function getSupportTicketPrefix($id){
        return '#SUPTICK'.$id;
    }
}
if(!function_exists('getNewProductCount')){
    function getNewProductCount($id){
        $my_suppliers = App\Models\AccessCatalogueRequest::whereUserId($id)->whereStatus(1)->pluck('number');
        if($my_suppliers->count() > 0){
            $user_ids = App\User::whereIn('phone', $my_suppliers)->pluck('id');

            if($user_ids->count() > 0){
                return $new_products = App\Models\Product::whereIn('user_id', $user_ids)->whereYear('created_at',now())->whereMonth('created_at',now())->count();
            }
        }

        return 0;
    }
}
if(!function_exists('getProductCountViaCategoryId')){
    function getProductCountViaCategoryId($categoryId,$userId){
        if($userId == auth()->id()){
            $shop_items_ids = App\Models\UserShopItem::where('category_id',$categoryId)->where('user_id',$userId)->pluck('product_id');
        }else{
            $shop_items_ids = App\Models\UserShopItem::where('category_id',$categoryId)->whereIsPublished(1)->where('user_id',$userId)->pluck('product_id');
        }

        return App\Models\Product::whereIn('id', $shop_items_ids)->get()->count();
    }
}
if(!function_exists('getProposalProductCountViaCategoryId')){
    function getProposalProductCountViaCategoryId($categoryId,$userId){
        $supplier_phones = App\Models\AccessCatalogueRequest::whereUserId($userId)->pluck('number');
        $suppliers = App\User::whereIn('phone',$supplier_phones)->where('status',1)->get();
        $supplier_shop_products = App\Models\UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->pluck('product_id');
        $supplier_shop_products_list = App\Models\UserShopItem::whereIn('user_id',$suppliers->pluck('id'))->where('is_published',1)->get();

        $master_products = App\Models\Product::query();

        $master_products->where(function($query) use($supplier_shop_products){
            $query->orWhereIn('id',$supplier_shop_products);
        });

       return $master_products_categories = $master_products->whereCategoryId($categoryId)->where('is_publish',1)->count();
    }
}
if(!function_exists('UserShopUserIdBySlug')){
    function UserShopUserIdBySlug($slug){
        return App\Models\UserShop::whereSlug($slug)->first()->user_id ?? null;
    }
}
if(!function_exists('UserShopIdBySlug')){
    function UserShopIdBySlug($slug){
        return App\Models\UserShop::whereSlug($slug)->first()->id ?? null;
    }
}
if(!function_exists('UserByNumber')){
    function UserByNumber($number){
        return App\User::wherePhone($number)->first();
    }
}
if(!function_exists('UserShopIdByUserId')){
    function UserShopIdByUserId($id){
        return App\Models\UserShop::whereUserId($id)->first()->id ?? null;
    }
}
if(!function_exists('UserShopNameByUserId')){
    function UserShopNameByUserId($id){
        return App\Models\UserShop::whereUserId($id)->first()->name ?? null;
    }
}
if(!function_exists('UserShopRecordByUserId')){
    function UserShopRecordByUserId($id){
        return App\Models\UserShop::whereUserId($id)->first() ?? null;
    }
}
if(!function_exists('getUniqueProductSlug')){
    function getUniqueProductSlug($title){
        $slug = slugify($title).'-'.\Str::random(6);
        $chk = \App\Models\Product::whereSlug($slug)->first();
        if($chk){getUniqueProductSlug();}
        return $slug;
    }
}

function slugify($text, $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
    return 'n-a';
    }

    return $text;
}
function getUniqueProposalSlug($title){
    $slug = slugify($title).'-'.\Str::random(5);
    $chk = \App\Models\Proposal::whereSlug($slug)->first();
    if($chk){
        return getUniqueProposalSlug($title);
    }
    return $slug;
}
if(!function_exists('getProductPriceGroupById')){
    function getProductPriceGroupById($product_id){
        $product =  App\Models\Product::where('product_id',$product_id)->first();
        if(!$product){
            return false;
        }
        return $groups = App\Models\GroupProduct::whereProductId($product_id)->get();
    }
}

if(!function_exists('getJoiningQuestions')){
    function getJoiningQuestions(){
        return [
            ['id'=>1,'question'=>"Buy in bulk for own department/company ?"],
            ['id'=>2,'question'=>"Are you a Manufacturer or reseller for bulk quantities ?"],
            ['id'=>3,'question'=>"Hold inventory of over Rs. 10 lakhs ?"],
            ['id'=>4,'question'=>"Take stock info from multiple Suppliers on real time basis ?"],
           ['id'=>5,'question'=>"Service to over 15 distributors/ resellers ?"],
        ];
    }
}
if(!function_exists('getAccessCatelogueRequestByNumber')){
    function getAccessCatelogueRequestByNumber($mobile, $status = null, $limit){
        if($status == null){
            return App\Models\AccessCatalogueRequest::whereNumber($mobile)->get()->take($limit);
        }else{
            return App\Models\AccessCatalogueRequest::whereNumber($mobile)->whereStatus($status)->get()->take($limit);
        }
    }
}
if(!function_exists('checkAccessCodeRedeemed')){
    function checkAccessCodeRedeemed($user_id){
        return  App\Models\App\Models\AccessCode::where('redeemed_user_id',$user_id)->first();
    }
}
if(!function_exists('getEnqCountFromWeb')){
    function getEnqCountFromWeb($user_id){
        $user_shop = App\Models\UserShop::where('user_id',$user_id)->firstOrFail();
       return $seller_enquiries = App\Models\UserEnquiry::where('type_id',$user_shop->id)->count() ?? '';
    }
}
if(!function_exists('getCatalogueThisMonth')){
    function getCatalogueThisMonth($user_id){
        if($user_id){
          return App\Models\Product::where('user_id',$user_id)->whereMonth('created_at', date('m'))
          ->whereYear('created_at', date('Y'))->count();
        }
    }
}
if(!function_exists('getProposalSentThisMonth')){
    function getProposalSentThisMonth($user_id,$status){
        if($user_id){
          return App\Models\Proposal::where('user_id',$user_id)
        //   ->where('created_at', '>',\Carbon\Carbon::now()->startOfWeek())
            ->whereMonth('created_at', date('m'))
            ->where('status',$status)
            ->where('created_at', '<', \Carbon\Carbon::now()->endOfWeek())
            ->count();
        }
    }
}
if(!function_exists('getTotalProducts')){
    function getTotalProducts($user_id,$type){
        if($type == 1){
            return App\Models\Product::where('user_id',$user_id)->get()->count();
        }else{
            $user_shop_id = App\Models\UserShop::where('user_id',$user_id)->first()->id;
            return App\Models\UserShopItem::where('user_id',$user_id)->where('user_shop_id',$user_shop_id)->where('parent_shop_id',0)->get()->count();
        }
    }
}
if(!function_exists('proposalCustomerDetailsExists')){
    function proposalCustomerDetailsExists($proposal_id){
        $proposal = App\Models\Proposal::where('id',$proposal_id)->first();
          if($proposal){
            $customer_details = json_decode($proposal->customer_details);
                if($customer_details->customer_name != null){
                    return true;
                }else{
                    return false;
                }
          }


    }
}
if(!function_exists('getSkuCount')){
    function getSkuCount($user_id){
        if($user_id){
         return  $user_shop = App\Models\Product::where('user_id',$user_id)->count() ?? '';
        }

    }
}
if(!function_exists('getAccessCataloguePendingCount')){
    function getAccessCataloguePendingCount($uid,$status){
        $user_data = \App\User::whereId($uid)->first();
        if($user_data){
            return App\Models\AccessCatalogueRequest::whereNumber($user_data->phone)
                                                    ->whereStatus($status)
                                                    ->count();
        }else{
            return null;
        }
    }
}
if(!function_exists('getMyTotalSuppliers')){
    function getMyTotalSuppliers($uid,$status){
        if($uid){
            return App\Models\AccessCatalogueRequest::whereUserId($uid)
                                                    ->whereStatus($status)
                                                    ->count();
        }else{
            return null;
        }
    }
}
if(!function_exists('getPendingCustomersRequest')){
    function getPendingCustomersRequest($uid,$status){
        $user_data = \App\User::whereId($uid)->first();
        if($user_data){
            return App\Models\AccessCatalogueRequest::whereNumber($user_data->phone)->whereStatus($status)->count();
        }else{
            return null;
        }
    }
}
if(!function_exists('getProductEnqCount')){
    function getProductEnqCount($uid){
        $user_shop = App\Models\UserShop::whereUserId($uid)->first();
        if($user_shop){
            return App\Models\Enquiry::where('micro_site_id',$user_shop->id)->count();
        }else{
            return null;
        }
    }
}
if(!function_exists('getBrandUserRequestType')){
    function getBrandUserRequestType($brand_id){
        $type = App\Models\BrandUser::whereBrandId($brand_id)->first()->type ?? '';
        if($type && $type == 1){
            return 'Authorized Seller';
        }elseif($type && $type == 0){
            return 'Brand Owner';
        }else{
            return 'No Request!';
        }
    }
}

if(!function_exists('getProductNameByOrderId')){
    function getProductNameByOrderId($order_id){
        $product_names = '';
        $order_items = App\Models\OrderItem::whereItemType('Product')->whereOrderId($order_id)->get();
        foreach($order_items as $item){
           $product = App\Models\Product::whereId($item->item_id)->first();
           if($product){
            $product_names = $product->title.", ";
           }
        }
        return $product_names;
    }
}

if(!function_exists('getProductDataById')){
    function getProductDataById($p_id){

        return $product = App\Models\Product::whereId($p_id)->first();
    }
}
if(!function_exists('getTotProAddInShopOfSupplier')){
    function getTotProAddInShopOfSupplier($supplier_id,$user_id,$user_shop_id,$parent_shop_id){
        $productIds = App\Models\Product::where('user_id',$supplier_id)->groupBy('sku')->get()->pluck('id');
        return App\Models\UserShopItem::whereUserId($user_id)->whereUserShopId($user_shop_id)->whereParentShopId($parent_shop_id)->whereIn('product_id',$productIds)->groupBy('product_id')->count();
    }
}
if(!function_exists('getProductNameById')){
    function getProductNameById($p_id){

        return $product = App\Models\Product::whereId($p_id)->first()->title;
    }
}
if(!function_exists('getProductByBrandId')){
    function getProductByBrandId($b_id, $type = "data"){
        if($type == "data"){
            return $product = App\Models\Product::whereBrandId($b_id)->get();
        }else{
            return $product = App\Models\Product::whereBrandId($b_id)->count();
        }
    }
}
if(!function_exists('getEnquiryDataById')){
    function getEnquiryDataById($e_id){

        return $enquiry = App\Models\Enquiry::whereId($e_id)->first();
    }
}
if(!function_exists('getBrandAS')){
    function getBrandAS($b_id){

        return  App\Models\BrandUser::whereType(1)->whereBrandId($b_id)->whereStatus(1)->get();
    }
}
if(!function_exists('getPriceRange')){
    function getPriceRange($id=null){
        if(is_numeric($id)){
            foreach(getPriceRange() as $row){
                if($row['id'] == $id){
                    return $row;
                }
            }
            return ['color'=>'','name'=>'--'];
        }else{
            return [
                ['id'=>2,'value'=>'100-10000','name'=>'100-10000','color'=>''],
                ['id'=>3,'value'=>'10000-30000','name'=>'10000-30000','color'=>''],
                ['id'=>4,'value'=>'30000-50000','name'=>'30000-50000','color'=>''],
                ['id'=>5,'value'=>'50000-70000','name'=>'50000-70000','color'=>''],
                ['id'=>6,'value'=>'100000-10','name'=>'Above 1 lakh','color'=>''],
            ];
        }
    }
}
if(!function_exists('invoiceFrom')){
    function invoiceFrom(){
        $data = [
            "address_1" => "",
            "address_2" => "",
            "country" => "101",
            "state" => "4021",
            "city" => "131679",
            "type" => "0",
        ];
        return json_encode($data);
    }
}
if(!function_exists('getItemIntroducer')){
    function getItemIntroducer($p_id, $user_shop_id){

        return  App\Models\UserShopItem::whereProductId($p_id)->whereUserShopId($user_shop_id)->first()->parent_shop_id ?? null;
    }
}
if(!function_exists('getLastEnquiryConversation')){
    function getLastEnquiryConversation($e_id){

        return  App\Models\TicketConversation::whereUserId($e_id)->latest()->first();
    }
}
if(!function_exists('getEnquiryPARUsers')){
    function getEnquiryPARUsers($e_id){
        $scoped = [];
        $enquiry = getEnquiryDataById($e_id);
        if(!$enquiry){
            return null;
        }
        if($enquiry && $enquiry->description != null){
            $details = json_decode($enquiry->description);
            $product = getProductDataById($details->product_id);
            if(!$product){
                return null;
            }else{
                // return $product->brand_id;
                // Branded
                if($product->brand_id != 0 && $product->brand_id != null){
                    // Get all AS
                    // check verified brand
                   $chk = App\Models\Brand::whereId($product->brand_id)->where('is_verified',1)->first();
                    if($chk){
                        $data = getBrandAS($product->brand_id);
                        foreach($data as $item){
                            if($item->user_id != auth()->id()){
                                if($item->user_id != $enquiry->user_id){
                                    $scoped[] = $item->user_id;
                                }
                            }
                        }
                    }else{
                        //Work as Non Branded if unverified brand
                        $parent_shop_id = getItemIntroducer($product->id, $enquiry->micro_site_id);
                        if($parent_shop_id == 0){
                            // $brand = App\Models\Brand::whereId($product->brand_id)->first();
                            // if($brand->user_id){
                                $scoped[] = $product->user_id;
                            // }
                        }else{
                            $data = getShopDataByShopId($parent_shop_id)->user_id ?? null;
                            $scoped[] = $data;
                        }

                        // $data = $product->user_id;
                        // $scoped[] = $data;
                        return $scoped;
                    }
                    return $scoped;
                }
                // Non Branded
                else{
                    // Get Introducer
                      $parent_shop_id = getItemIntroducer($product->id, $enquiry->micro_site_id);
                      $data = getShopDataByShopId($parent_shop_id)->user_id ?? null;
                     $scoped[] = $data;
                    return $scoped;
                }
            }
        }
        return null;
    }
}
if(!function_exists('getProductPARUsers')){
    function getProductPARUsers($product_id, $parent_shop_id){
        $scoped = [];
        $product = getProductDataById($product_id);
        if(!$product){
            return null;
        }else{
            // return $product->brand_id;
            // Branded
            if($product->brand_id != 0 && $product->brand_id != null){
                // Get all AS
                $data = getBrandAS($product->brand_id);
                foreach($data as $item){
                    $parent_shop_user_id = getShopDataByShopId($parent_shop_id)->user_id ?? null;
                    if($item->user_id != auth()->id()){
                            $scoped[] = $item->user_id;
                    }
                }
                return $scoped;
            }
            // Non Branded
            else{
                // Get Introducer
                    $data = getShopDataByShopId($parent_shop_id)->user_id ?? null;
                    $scoped[] = $data;
                return $scoped;
            }
        }
        return null;
    }
}


if(!function_exists('shrinkurl')){
    function shrinkurl($destination_url,$url_key = null,$single_use = 0,$expire_at = null){

        if ($destination_url == "" || $destination_url == null) {
            return "Invailed Request";
        }
        if ($url_key == null) {
            $url_key = generateRandomStringNative(10);
        }

        $domain = env('APP_DOMAIN');
        $channel = env('APP_CHANNEL');

        $finelurl = $channel.$domain."/short"."/".$url_key;

        App\Models\shorturl::create([
            'destination_url' => $destination_url,
            'url_key' => $url_key,
            'default_short_url' => $finelurl,
            'deactivated_at' => $expire_at,
            'single_use' => $single_use,
        ]);

        return $finelurl;

    }
}

if(!function_exists('updateshortvisit')){
    function updateshortvisit($url_key){

        App\Models\shorturl::create([
            'url_key' => $url_key,
        ]);
        return true;

    }
}





if (!function_exists('magicstring')) {
    function magicstring($string){
        echo "<pre>";
        print_r($string);
        echo "<pre>";
        echo "<br>";
    }
}

if (!function_exists('getinventoryByproductId')) {
    function getinventoryByproductId($id) {
        $data =  Inventory::where('product_id',$id)->get();
        if (count($data) != 0) {
            return $data[0];
        }else{
           return $data = null;
        }
    }

}



if (!function_exists('getdeliveryAltributesbyProductSKU')) {
    function getdeliveryAltributesbyProductSKU($id) {
        return TimeandActionModal::whereIn('product_sku',$id)->pluck('delivery_period');
    }
}

if (!function_exists('getDeliveyStockbyProductSKU')) {
    function getDeliveyStockbyProductSKU($id) {
        return TimeandActionModal::whereIn('product_sku',$id)->pluck('delivery_stock');
    }
}

if (!function_exists('getDeliveyStockbyProductSKU')) {
    function getDeliveyStockbyProductSKU($id) {
        return TimeandActionModal::whereIn('product_sku',$id)->pluck('delivery_stock');
    }
}



// Search Neaest Day Value of T&A in Array
if (!function_exists('getClosestTandADay')) {
    function getClosestTandADay($search, $arr) {
        $closest = null;
        $closestKey = null;
        foreach ($arr as $key => $item) {
           if ($closest === null || abs($search - $closest) > abs($item - $search)) {
              $closest = $item;
              $closestKey = $key;
           }
        }
        return ['Key'=>$closestKey,'Value' => $closest];
    }
}

if (!function_exists('getTandA')) {
    function getTandA($sku = [],$avalable_stock, $search_quantity){
        $result = [];
        $get_db = TimeandActionModal::whereIn('product_sku',$sku)->pluck('delivery_stock','delivery_period');
        if ($search_quantity > $avalable_stock) {
            $rest_stock = abs($search_quantity - $avalable_stock);
            if (!empty($get_db) && count($get_db) != 0) {
                $max_rec = max($get_db->toArray());
                if ($search_quantity > $max_rec) {
                    // If Tand A Is Not Exist in Existing Condition
                    if ($avalable_stock > 0) {
                        $result = ["Key" => "$avalable_stock Now, & $rest_stock On Request","Value" => "On Request."];
                    }else{
                        $result = ["Key" => "On Request","Value" => "On Request."];
                    }
                }else{
                    $close_rec = getClosestTandADay($search_quantity,$get_db);
                    $result = $close_rec;
                }
            }else{
                // If Tand A Is Not Created Ever
                // $result = ["Key" => "On Request","Value" => "On Request."];
                if ($avalable_stock > 0) {
                    $result = ["Key" => "$avalable_stock Now, & $rest_stock On Request","Value" => "On Request."];
                }else{
                    $result = ["Key" => "On Request","Value" => "On Request."];
                }
            }
        }else{
            // Stock in Hand, Delivery Immediatly!!
            $result = ['Key' => 'Immediately', 'Value' => 'immediately'];
        }
        return $result;
    }
}



if(!function_exists('getShopProductImageByIndex')){
    function getShopProductImageByIndex($product_id, $index = 2){
        return App\Models\Media::whereType('Product')->whereTypeId($product_id)->whereTag('Product_Image')->pluck('path')[$index] ?? "";
    }
}


if (!function_exists('newline')) {
    function newline($n = 1){
        return str_repeat("<br>", $n);
    }
}


if (!function_exists('isValidURL')) {
    function isValidURL($url){
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*
        (:[0-9]+)?(/.*)?$|i', $url);
    }
}


if (!function_exists('getPriceGroupByGroupName')) {
    function getPriceGroupByGroupName($user_id,$group_name) {
        $rec = App\Models\Group::where('user_id',$user_id)->where('name',$group_name)->first();
        if ($rec != null) {
            return $rec;
        }else{
            return null;
        }

    }
}






function inject_subdomain($path,$subdomain,$is_login = false, $is_scanned = false){

    if($is_scanned == true){
        $isScan = 1;
    }else{
        $isScan = 0;
    }

    if($is_login == true){
        if (strpos($path, '?') !== false) {
            $accessToken = "&at=".encrypt(auth()->id())."&scan=$isScan";
        }else{
            $accessToken = "?at=".encrypt(auth()->id())."&scan=$isScan";
        }
    }else{
        $accessToken = "";
    }

    $domain = env('APP_DOMAIN');
    $channel = env('APP_CHANNEL');

    return $channel.$subdomain.'.'.$domain.'/'.$path."$accessToken";
}






function remove_subdomain($path,$subdomain,$is_login = false, $is_scanned = false){

    if($is_scanned == true){
        $isScan = 1;
    }else{
        $isScan = 0;
    }

    if($is_login == true){
        if (strpos($path, '?') !== false) {
            $accessToken = "&at=".encrypt(auth()->id())."&scan=$isScan";
        }else{
            $accessToken = "?at=".encrypt(auth()->id())."&scan=$isScan";
        }
    }else{
        $accessToken = "";
    }

    $domain = env('APP_DOMAIN');
    $channel = env('APP_CHANNEL');
    return $channel.$domain.'/'.$path."$accessToken";
}
function getPriceGroupId($slug){
    if(auth()->check()){
        $user_id = UserShopUserIdBySlug($slug);
        $shop_owner_data = App\User::whereId($user_id)->first();
        $access_data = App\Models\AccessCatalogueRequest::whereUserId(auth()->id())->where('number',$shop_owner_data->phone)->where('status',1)->first();
        if($access_data){
            return $access_data->price_group_id;
        }else{
            return 0;
        }
    }else{
        return 0;
    }
}
function getPriceByGroupIdProductId($group_id,$product_id,$default){
    $price_group_data = \App\Models\GroupProduct::whereGroupId($group_id)->whereProductId($product_id)->first();
    if($price_group_data && $price_group_data->price != 0 && $price_group_data->price != null){
            return $price_group_data->price;
    }else{
        return $default ?? 0;
    }
}
function getProductRefIdByRole($product,$user_shop_item, $case){
    // Case 1 For showing ref to all
    // Case 2 For showing ref to resellers and model to supplier

    if($case == 1){
        return $product->model_code;
    }else{
        if($product->user_id == $user_shop_item->user_id){
            return $product->model_code;
        }else{
            return getMicrositeItemSKU($user_shop_item->id);
        }
    }
}
if (!function_exists('checkLockedEnquiry')) {
    function checkLockedEnquiry($product_id,$user_id){
        $now = Carbon::now();
        return LockEnquiry::where('product_id','LIKE','%'.$product_id.'%')->where('user_id',$user_id)->where('expiry_date','<=',$now)->first();
    }
}



// Gettign Product Attribute value Name
if (!function_exists('getAttruibuteValueById')) {
    function getAttruibuteValueById($id) {
        return ProductAttributeValue::whereId($id)->first();
    }
}

// Gettign Product Attribute value Name
if (!function_exists('getParentAttruibuteValuesByIds')) {
    function getParentAttruibuteValuesByIds($attri_id,$product_ids) {
        // magicstring(ProductExtraInfo::where('attribute_id',$attri_id)->whereIn('product_id',$product_ids)->groupBy('attribute_value_id')->pluck('attribute_value_id'));
        return ProductExtraInfo::where('attribute_id',$attri_id)->whereIn('product_id',$product_ids)->groupBy('attribute_value_id')->pluck('attribute_value_id');
    }
}


// Gettign Product Attribute Name
if (!function_exists('getAttruibuteById')) {
    function getAttruibuteById($id) {
        return ProductAttribute::whereId($id)->first();
    }
}

// ! Function to Search Array Inside ARRAY
if (!function_exists('searchArray')) {
    function searchArray($a = [],$b =[]){
        foreach ($a as $key => $value) {
            if(!in_array($value,$b)){
                return false;
            }
        }
        return true;
    }
}



if (!function_exists('getAttributeIdByName')) {
    function getAttributeIdByName($name,$user_id = null){
        return ProductAttribute::where('name',$name)->where('user_id',$user_id)->first()->id ?? 0;
    }
}


if (!function_exists('debugtext')) {
    function debugtext($debuging_mode = 1,$str,$color = 'red',$background = 'pink'){
        if ($debuging_mode){
            echo "<code style='color: $color; font-weight:800;padding: 8px; background-color: $background; margin:8px;display:block'>$str</code>".newline(); 
        }
    }
}




function getMicrositeItemSKU($id){
    return "Ref ID: ".$id;
}
function getReferenceCodeByUser($user_id,$product_id){
    $ownProduct = App\Models\Product::whereId($product_id)->whereUserId($user_id)->first();
    if($ownProduct){
        return 'Ref ID: '.$ownProduct->model_code;
    }else{
        $usi = App\Models\UserShopItem::whereProductId($product_id)->whereUserId($user_id)->first();
        if($usi){
            return 'Ref ID: '.$usi->id;
        }
    }
}

function sessionManager($request, $subdomain){
    config([
        'session.domain' => $subdomain.''.env('SESSION_DOMAIN')
    ]);

    if($request->has('at')){
        \Session::put('at', $request->get('at'));
        \Session::save();
    }

    if($request->has('at') || \Session::has('at')){
        // return dd(\Session::has('at'));
        $at = $request->get('at') ?? \Session::get('at');
        $auth_user_chk = \App\User::whereId(decrypt($at))->first();


        if(\Auth::check()){
            if($auth_user_chk->id != auth()->id()){
               auth()->logout();
            }
        }

        if($auth_user_chk){
            config([
            'session.domain' => $subdomain.'.'.env('SESSION_DOMAIN')
            ]);
            auth()->loginUsingId($auth_user_chk->id);
        }
    }
    return "DONE";
}
