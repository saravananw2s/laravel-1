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
	$Persons->name = $request->name;
	$Persons->number = $request->number;	
	$Persons->password =  $request->password;
	$Persons->username = $request->usname;
	$Persons->pincode = $request->pincode;	
	$Persons->street =  $request->street;
	$Persons->city =  $request->city;

	$Persons->save();
			$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	return $data;			
	}
	public function adminsignin(Request $request){
	if(count($request->name == 'goadmin' && $request->pwd == "gononveg@23456"){
		$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	}else{
		$data = json_encode(array('login' => "invaliduser", 'Persons' => $Persons));
	}
	return $data;
	}
	public function login(Request $request){
	$Persons = Persons::where('username',$request->name)->where('password',$request->pwd)->get();
	if(count($Persons)!=0){
		$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	}else{
		$data = json_encode(array('login' => "invaliduser", 'Persons' => $Persons));
	}
	return $data;
	}
	public function postOrder(Request $request){
	$orders = new Orders();
	$orders->name = $request->name;

	$orders->user_id = $request->user_id;
	$orders->number = $request->number;
	$orders->address = $request->address;		
	$orders->payment = $request->payment;		
	$orders->items = $request->items;	
	$orders->store = $request->store;			
	$orders->totalprice = $request->totalprice;
	$orders->sedate = $request->sedate;							
	$orders->setime = $request->setime;
			$orders->sts = "NOT";														
	$orders->save();	
	$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
	return $data;			
	}

	public function items(){
		$ch = Items::where('cate','CK')->get();
		$mt = Items::where('cate','MT')->get();
		$fs = Items::where('cate','FS')->get();
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
		$orders->save();

		return $orders;
		//return $orders->save();
	}
	public function updateprice(Request $request){
		//return $request->id;
		$orders = Items::where('id',$request->id)->first();
		$orders->price = $request->price;
		$orders->save();

		return $orders;
		//return $orders->save();
	}

	public function ordershistory(Request $request){
		$orders = Orders::all();	
	$data = json_encode(array('orders' => $orders));
	return $data;
	}
	public function history(Request $request){
		$orders = Orders::where('user_id',$request->id)->get();	
	$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
	return $data;
	}
	public function editprofile(Request $request){

		$Persons = Persons::where('ID',$request->id)->first();
	$Persons->name = $request->name;
	$Persons->number = $request->number;	
	$Persons->password =  $request->password;
	$Persons->username = $request->usname;
	$Persons->pincode = $request->pincode;	
	$Persons->street =  $request->street;
	$Persons->city =  $request->city;

	$Persons->save();
			$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	return $data;
	}
	public function showusers(Request $request)
	{
				$Persons = Persons::all();
				$data = json_encode(array('Persons' => $Persons));
				return $data;

		# code...
	}
}