<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function create(Request $request)
    {
        $res = Mail::to('serhiicho@protonmail.com')->send(new OrderMail);
        var_dump($res);
        exit;
    }
}
