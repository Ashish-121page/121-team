<?php 
/**
 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content; 
        $this->attachment_path = array_key_exists('attachment_path', $this->content) ? $this->content['attachment_path'] : null; 
        $this->attachment_name = array_key_exists('attachment_name', $this->content) ? $this->content['attachment_name'] : null; 
        // $this->cc = array_key_exists('cc', $this->content) ? $this->content['cc'] : null; 
        // $this->cc = ["luck.nema@gmail.com"]; 
        // $this->bcc = array_key_exists('bcc', $this->content) ? $this->content['bcc'] : null; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(array_key_exists('subject', $this->content)){
            $subject = $this->content['subject'];
        }else{
            $subject = 'New information from '.config('app.name');
        }
        $template =  $this->markdown('emails.custom_mail')->subject($subject)->with('content',$this->content)
                    ->from(getSetting('mail_from_address'), getSetting('mail_from_name'));

        // if(!empty($this->cc)){
        //     $template->cc($this->cc);
        // }
        // if(!empty($this->bcc)){
        //     $template->bcc($this->bcc);
        // }
        if($this->attachment_path != null)
        {
            $template->attach($this->attachment_path, [
                    'as'    => $this->attachment_name,
            ]);
        }

        return $template;
    }
}
