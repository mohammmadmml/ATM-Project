<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Mail;
use App\Models\Card;
use App\Models\Bank;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(Request $request){

        $mailData = [
            'title'=>'Congratulation',
            'body'=>'you are welcomed to come to harvard university we know that you can make things change in world'
        ];

        Mail::to('malakouti1383@gmail.com')->send(new DemoMail($mailData));

        dd("Email is sent successfully");
    }
}
