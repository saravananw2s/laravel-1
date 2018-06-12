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
use Illuminate\Http\Response;

use Tzsk\Sms\Facade\Sms;
use Session;
#use Twilio\Rest\Client;

use Validator;

class AppControllers extends Controller
{
	public function emp(Request $request){
		return Persons::where('role','emp')->get();	
    }
	public function delivery(Request $request){
		$orders = Orders::where('ID',$request->id)->first();
	        $orders->del="OK";
		$orders->update();
	}
	public function reset(Request $request){
		for($i=1;$i<=6;$i++){
		$countslat = Slats::where('ID',$i)->first();	
		$countslat->pendingcount = 50;
		$countslat->save();
		}
	}
	 public function close(Request $request){
        for($i=1;$i<=1;$i++){
        $countslat = Slats::where('ID',$i)->first();    
        $countslat->pendingcount = 50;
        $countslat->save();
        }
    }
     public function offers(Request $request){
		$offer = Offer::where('id',1)->first();
		$offer->sdate=$request->sdate;
		$offer->edate=$request->edate;
		$offer->offer=$request->offer;
		$offer->update();
		return $offer;
	}
	public function showoffers(){
		return Offer::where('id',1)->first();
	} 
	public function showmyoffers(Request $request){
		return myoffers::where('id',$request->myoffer)->first();
	} 
	public function showslat(Request $request){
		$countslat = Slats::where('stotname',$request->setime)->first();
		return $countslat;
	}
	public function showmyorder(Request $request){
		$orders = Orders::where('employee',$request->id)->where('del','NOT OK')->get(); 
        $data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
        return $data;
	}
	public function emplogin(Request $request){
	   $Persons = Persons::where('number',$request->name)->where('password',$request->pwd)->where('role','emp')->get();
        if(count($Persons)!=0){
                $data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
        }else{
                $data = json_encode(array('login' => "invaliduser", 'Persons' => $Persons));
        }
        return $data;
	}
	public function assign(Request $request){
	   $Orders = Orders::where('ID',$request->id)->first();
      		$Orders->employee = $request->employee;
		$Orders->update();

    }
	public function signup(Request $request){
	    $Persons = Persons::where('number',$request->number)->first();
	    if(count($Persons)!=0){
		$data = json_encode(array('login' => "invaliduser", 'Persons' => "Mobile Number Alredy Exist"));
	    	return $data;			
	    }
		$Persons = new Persons();
		$Persons->name = $request->name;
		$Persons->number = $request->number;	
		$Persons->password =  $request->password;
		$Persons->username = $request->number;
		$Persons->pincode = $request->pincode;	
		$Persons->street =  $request->street;
	    $Persons->street1 =  $request->street1;
		$Persons->city =  $request->city;
        $Persons->wallet = 200;
		$Persons->save();
				$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
		return $data;			
	}
	public function adminsignin(Request $request){
		if($request->name == 'goadmin' && $request->pwd == "gononveg@23456"){
			$data = json_encode(array('login' => "validuser"));
		}else{
			$data = json_encode(array('login' => "invaliduser"));
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
		        if($request->dellat == null){
			$data = json_encode(array('status' => "noordercreated", 'orders' => "Please Pin the delivery Point"));
			return $data;
			}
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
			$orders->del = "NOT OK";										
			//	$orders->save();
			//return $orders->setime;
			$countslat = Slats::where('stotname',$orders->setime)->first();
			//return $countslat;
			$count = $countslat->pendingcount;
			if($count == 0){
			$countslat->express = $countslat->express + 1;
			$countslat->save();
			if($orders->setime == '11AM - 1PM' || $orders->setime == '2PM - 4PM'){
							$orders->delivery = "Free Delivery";
						    $orders->delcharge = 0;

			}else{
							$orders->delivery = "Paid Delivery";
							$orders->delcharge = 30;
			}
			}else{
			$countslat->pendingcount = $count-1;
			$countslat->save();
			$orders->delivery = "Free Delivery";
			$orders->delcharge = 0;
			}
			   $orders->cust_lat = $request->dellat;
			   $orders->cust_lng = $request->dellng;

			if($request->account == 'login'){
					$persons = Persons::where('ID',$request->userid)->first();
					if($persons->wallet > 20){
					$repoint = $request->totalprice / 100;
					$persons->wallet = $persons->wallet - 20 + floor($repoint);
					$persons->update();
					$orders->wallet = 20;
				}				
			};
		    $orders->save();
			Session::put('number',$request->number);
			Session::put('name',$request->name); 	
			$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
		    Sms::with('textlocal')->send('Dear '.$orders->name.', Your Order is Placed OrderId#'.$orders->ID .', and your Order value is'.$orders->totalprice.', delivery schedule at'.$orders->sedate.', '.$orders->setime, function($sms) {
			 $sms->to('+91'.Session::get('number')); 
			});			
		    return $data;			
	}
	public function items(Request $request){
		if($request->place){
			                $pincode = 'pin'.$request->place;
		}else{
		                $pincode = 'pin600100';
		}
		$ch = Items::where('cate','CK')->get(['id','name','image','cate',$pincode.' AS price']);
		$mt = Items::where('cate','MT')->get(['id','name','image','cate',$pincode.' AS price']);
		$fs = Items::where('cate','FS')->get(['id','name','image','cate',$pincode.' AS price']);
		$bf = Items::where('cate','BF')->get(['id','name','image','cate',$pincode.' AS price']);
		$fk = Items::where('cate','FK')->get(['id','name','image','cate',$pincode.' AS price']);
		$ms = Items::where('cate','MS')->get(['id','name','image','cate',$pincode.' AS price']);  
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
		$code ='pin'.$request->place;
		$orders = Items::where('id',$request->id)->first();
		$orders->$code = $request->price;
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
	$Persons->pincode = $request->pincode;	
	$Persons->street =  $request->street;
	$Persons->city =  $request->city;
	        $Persons->street1 =  $request->street1;
	$Persons->save();
			$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
	return $data;
	}
	public function showusers(Request $request)
	{
				$Persons = Persons::all();
				$data = json_encode(array('Persons' => $Persons));
				return $data;

	}
	public function resetpass(Request $request){
    Session::put('number',$request->number);
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $pass = substr( str_shuffle( $chars ), 0, 8 );
	Sms::with('textlocal')->send('your new password is'.$pass,function($sms) {
	 $sms->to('+91'.Session::get('number')); 
	});
	$persons = Persons::where('number',$request->number)->first();
	$persons->password =  $pass;
	$persons->save();
	return $persons;
	}
	public function pincode(Request $request){
		$pincode = pincode::where('pincode',$request->pincode)->get();
		if(count($pincode) != 0){
			$data = json_encode(array('sts' => 'ok'));
			return $data;
		}else{
			$data = json_encode(array('sts' => 'not','msg'=>"Service Not Available at Your Location"));
			return $data;
		}
	}
	public function stores(Request $request){
		$stores = stores::where('pincode',$request->place)->get();
		return json_encode(array('stores' => $stores));
	}
	public function userinfo(Request $request){
		$userinfo = Persons::where('ID',$request->user_id)->get();
		return $userinfo;
	}
	public function uploadfile(Request $request){
	  $file = $request->image;
      $destinationPath = 'uploads';
      $file->move($destinationPath,$file->getClientOriginalName());
	}

}
