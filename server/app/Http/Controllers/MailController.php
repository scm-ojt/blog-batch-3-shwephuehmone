<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\sendMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index()
    {
        $details = [
            'title' => 'Mail from scm',
            'body' => 'This is for testing email using smtp.'
        ];
        Mail::to('scm.shwephuehmone@gmail.com')->send(new sendMail($details));
        dd("Email is sent successfully.");
    }
}