<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module\Persons;
use App\Module\Orders;
use App\Module\Items;
use App\Module\Slats;
use App\Module\offer;
use App\Module\myoffers;
use App\Module\pincode;
use App\Module\stores;
use App\Module\ventor;

use Illuminate\Http\Response;

use Tzsk\Sms\Facade\Sms;
use Session;
#use Twilio\Rest\Client;

use Validator;

class NewController extends Controller
{
public function showstores(){
$Persons= ventor::where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function paystore(Request $request){
$emp = Persons::where('ID',$request->id)->first();
$Persons= stores::where('active','1')->where('pincode',$emp->pincode)->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function transaction(Request $request){
$Persons = Persons::where('ID',$request->id)->first();
$Persons->Amount = $Persons->Amount - $request->amount;
$Persons->update();
$ventor = stores::where('id',$request->storeid)->first();
$ventor->amount=$ventor->amount + $request->amount;
$ventor->update();


}
public function emppay(Request $request){
           $Persons = Persons::where('ID',$request->id)->get();
        if(count($Persons)!=0){
                $data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
        }else{
                $data = json_encode(array('login' => "invaliduser", 'Persons' => $Persons));
        }
        return $data;
        }

public function showemployees(){
$Persons= Persons::where('role','emp')->where('approve','1')->where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function showmystoreorder(Request $request){
$orders = Orders::where('storeid',$request->id)->where('pick','NOT OK')->get();   
$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
return $data;
}
public function showpincodes(){
$Persons= stores::where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function waiting(){
$Persons= Persons::where('role','emp')->where('approve','0')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}

public function approve(Request $request){
$Persons = Persons::where('ID',$request->id)->first();
$Persons->approve = 1;
$Persons->update();
$Persons= Persons::where('role','emp')->where('approve','0')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function storelogin(Request $request){
           $Persons = stores::where('mobilenumber',$request->name)->where('password',$request->pwd)->where('active','1')->get();
        if(count($Persons)!=0){
                $data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
        }else{
                $data = json_encode(array('login' => "invaliduser", 'Persons' => $Persons));
        }
        return $data;
        }

public function showstoreorders(Request $request){
$orders = Orders::where('storeid',$request->id)->where('pick','NOT OK')->get();   
$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
return $data;
}
public function prodispatch(Request $request){
$orders = Orders::where('ID',$request->id)->first();
$orders->pick = date("Y-m-d H:i:s");
$orders->del = "Dispatched";
$orders->update();
}
}
