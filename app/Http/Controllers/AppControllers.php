<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module\Persons;
use App\Module\Orders;
use App\Module\Items;
use Illuminate\Http\Response;


use Validator;

class AppControllers extends Controller
{
	public function signup(Request $request){
	$Persons = new Persons();
	$Persons->name = $request->get('name');
	$Persons->number = $request->get('number');	
	$Persons->password =  $request->get('password');
	$Persons->save();
	return "newuser";			
	}
	public function login(Request $request){
		print_r($request->name);
	$Persons = Persons::where('name',$request->get('name'))->where('password',$request->get('password'))->get();
	if(count($Persons)!=0){
		$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	}else{
		$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	}
	}
	public function postOrder(Request $request){
	$orders = new Orders();
	$orders->name = $request->get('name');
	$orders->number = $request->get('number');
	$orders->address = $request->get('address');		
	$orders->payment = $request->get('payment');		
	$orders->items = $request->get('items');		
	$orders->qtys = $request->get('qtys');				
	$orders->save();	
	return response("ordercreated");
	}

	public function items(){
		$ch = Items::where('cate','CK')->get();
		$mt = Items::where('cate','MT')->get();
		$fs = Items::where('cate','FS')->get();
		$ch = Items::where('cate','KD')->get();
		$bf = Items::where('cate','BF')->get();
		$fk = Items::where('cate','FK')->get();
		$ms = Items::where('cate','MS')->get();  
		$data = json_encode(array('ch' => $ch, 'mt' => $mt,'fs'=>$fs,'bf'=>$bf,'fk'=>$fk,'ms'=>$fs,'ms'=>$ms));
		return $data;
	}
	public function showOrders(){
		$orders = Orders::where('sts','NOT')->get();
		return $orders;		
	}
	public function stschage(Request $request){
		//return $request->id;
		$orders = Orders::where('ID',$request->id)->first();
		$orders->sts = "OK";
		Orders::where('ID',$request->id)->delete();
		$orders->save();

		return $orders;
		//return $orders->save();
	}
}