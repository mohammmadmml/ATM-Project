<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Card;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    public function deposit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number'=>'required',
            'amount'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'validator faild',
                'error'=>$validator->fails()
            ]);
        }
        $card = Card::where('user_id',auth('api')->id())->where('card_number', $request->card_number)->first();

        if(empty($card)){
            return response()->json(['message'=>'Unauthorised Access']);
        }
        $card = $card->toArray();

        $balance = $card['balance'];

        $balance = $balance + $request->amount;

        Card::where('card_number', $request->card_number)->update(['balance'=>$balance]);

        return response()->json([
            'message'=>'amount deposited successfully',
            'balance'=>$balance
        ]);
    }

    public function withdraw(Request $request){
        $validator = Validator::make($request->all(), [
            'card_number',
            'amount',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'validator faild',
                'error'=>$validator->fails()
            ]);
        }

        $card = Card::where('user_id', auth('api')->id())->where('card_number', $request->card_number)->first();

        if(empty($card)){
            return response()->json(['message'=>'Unauthorised access']);
        }
        $card = $card->toArray();

        $balance = $card['balance'];

        if($balance < $request->amount){
            return response()->json(['message'=>'you dont have enough money']);
        }
        $balance = $balance - $request->amount;

        Card::where('card_number', $request->card_number)->update(['balance'=>$balance, 'amount'=>$request->amount]);

        return response()->json([
            'balance'=>$balance,
            'message'=>'money withdrawed successfully'
        ]);
    }


    public function transfer(Request $request){

        $validator = Validator::make($request->all(), [
            'origin'=>'required',
            'amount'=>'required',
            'destination'
        ]);
        if($validator->fails()) {
            return response()->json([
                'message'=>'validator faild',
                'error'=>$validator->errors()
            ]);
        }
        $test = Card::where('card_number', $request->destination)->with(['users:id,name'])->first()->toArray();

        $card = Card::where('user_id', auth('api')->id())->where('card_number',$request->origin)->first();
        if(empty($card)){
            return response()->json(['message'=>'Unauthorised access']);
        }
        $card = $card->toArray();

        $balance = $card['balance'];

        if($balance < $request->amount){
            return response()->json(['message'=>'you dont have enough money']);
        }
        $balance = $balance - $request->amount;

        Card::where('card_number', $request->origin)->update(['balance'=>$balance, 'amount'=>$request->amount]);

        $transfer = $test['balance'];

        $transfer = $transfer + $request->amount;

        Card::where('card_number', $request->destination)->update(['balance'=>$transfer, 'amount'=>$request->amount]);

            return response()->json([
                'balance'=>$balance,
                'name'=> $test['users']['name'],
            'message'=>'amount transfered successfully',

            ]);
        }

}
