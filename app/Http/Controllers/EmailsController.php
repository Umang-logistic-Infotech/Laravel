<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    //
    public function welcomeEmail()
    {
        Mail::to('jadavumang160@gmail.com')->send(new WelcomeMail());
        return "Email sent successfully";
    }
}
