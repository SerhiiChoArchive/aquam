<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function create(Request $request)
    {
        function sendmail($_sSubject, $_sMessage, $_sEmail, $_sFrom, $_sReply, $_bPriority=false){
            $subject = "=?utf-8?b?" . base64_encode($_sSubject) . "?=";
            $headers  = "From: $_sFrom\r\n";
            $headers .= "Reply-To: $_sReply\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            if($_bPriority){
                $headers .= "X-Priority: 1 (Highest)\n";
                $headers .= "X-MSMail-Priority: High\n";
                $headers .= "Importance: High\n";
            }
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            return mail($_sEmail, $subject, $_sMessage, $headers);
        }
        sendmail('Subject', 'some message', 'serhiicho@protonmail.com', 'office@aqua-m.com.ua', 'serhiicho@protonmail.com');
//        $res = Mail::to('')->send(new OrderMail);
//        var_dump($res);
//        exit;
    }
}
