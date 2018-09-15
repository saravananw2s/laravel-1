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

class DeleteController extends Controller
{
public function delstores(Request $request){
$Persons= ventor::where('id',$request->id)->first();
$Persons->active = 0;
$Persons->update();
$Persons= ventor::where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function delshowemployees(Request $request){
$Persons= Persons::where('ID',$request->id)->first();
$Persons->active = 0;
$Persons->update();
$Persons= Persons::where('role','emp')->where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function delpincodes(Request $request){
$Persons= stores::where('id',$request->id)->first();
$Persons->active = 0;
$Persons->update();
$Persons= stores::where('active','1')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}
public function waiting(){
$Persons= Persons::where('role','emp')->where('approve','0')->get();
$data = json_encode(array('Persons' => $Persons));
                                return $data;
}


}

