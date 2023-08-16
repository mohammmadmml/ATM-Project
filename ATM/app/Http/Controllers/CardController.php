<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Card;
use App\Models\Bank;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;



class CardController extends Controller
{
    public function show_cards(Request $request)
    {
        $info = Card::where('user_id', auth('api')->id())->get(['id','card_number', 'balance', 'bank_id']);

        return response()->json([
            'data' => $info
        ]);
    }

    public function create_card(Request $request, Card $card){


        $bank = Bank::where('id',$request->bank_id)->first()->toArray();
        $cardNumber = $bank['code'];
        for ($i = 0; $i < 12; $i++) {
            $cardNumber .= rand(0, 9);
        }

        $card = Card::where('password',$request->password)->first();

        $pass = $card;

        for($i = 0; $i<4; $i++) {
            $pass .= rand(0,4);
        }



        $create = Card::create([
            'card_number'=>$cardNumber,
            'password'=>$pass,
            'user_id'=> auth('api')->id(),
            'bank_id'=>$request->bank_id
        ]);
        return response()->json([
            'success'=>$create,
            'message'=>'card created successfully'
        ]);
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'card_id'=>'required',
            'old_password'=>'required',
            'new_password'=>'required|max:4|min:4',
            'confirm_password'=>'required|same:new_password'
        ]);
        if($validator->fails()) {
            return response()->json([
                'message'=>'validations fails',
                'errors'=>$validator->errors()
            ],422);
        }
        $card = Card::where('user_id',auth('api')->id())->where('id',$request->card_id)->first()->toArray();
        $cardPass = $card['password'];

        if($request->old_password == $cardPass) {
            Card::where('id',$request->card_id)->update(['password'=>bcrypt($request->new_password)]);

            return response()->json([
                'message'=> 'password successfully updated',
                'errors'=> $validator->errors()
            ],200);
        }else{
            return response()->json([
                'message'=>'old password doesnt match',
                'errors'=>$validator->errors()
            ],422);
        }
    }

    public function baaalance(Request $request) {
        $validator = Validator::make($request->all(), [
            'card_number'=>'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'validator faild',
                'errors'=>$validator->fails()
            ]);
        }
        $card = Card::where('user_id', auth('api')->id())->where('card_number', $request->card_number)->first();

        if(empty($card)) {
            return response()->json(['message'=>'Unauthorised access']);
        }
        $card = $card->toArray();

        $balance = $card['balance'];

        return response()->json(['balance'=>$balance]);
    }


}
