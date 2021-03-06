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
use App\Module\history;
use App\Module\Refer;
use App\classes\Smsalert;
use Illuminate\Http\Response;

use Tzsk\Sms\Facade\Sms;
use Session;
#use Twilio\Rest\Client;

use Validator;

class AppControllers extends Controller
{
	public function emp(Request $request){
		if($request->pincode == '00000'){
		return Persons::where('role','emp')->get();
		}
		return Persons::where('role','emp')->where('pincode',$request->pincode)->get();	
    }
      public function showmyorderhistory(Request $request){
                $orders = history::where('employee',$request->id)->get(); 
        $data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
        return $data;
        }
        public function storehistory(Request $request){
                $orders = history::where('storeid',$request->id)->get(); 
        $data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
        return $data;
        }

	public function delivery(Request $request){
		$orders = Orders::where('ID',$request->id)->first();
		$Persons = Persons::where('ID',$orders->employee)->first();
		if($request->reason == 'Cash'){
		$Persons->Amount = $Persons->Amount + $request->amount;
                }
                $Persons->salerypending = $Persons->salerypending+25;
                $Persons->update();
                $orders->delreason=$request->reason;
                $orders->remarks=$request->remarks;
	        $orders->del="DELIVERD";
		$orders->update();
            //    $Orders->employee = $Orders->employee; 
             //   $Orders->empname = $Orders->empname; 
               // $Orders->storeinfo = $Orders->storeinfo;
                //$Orders->outlets = $Orders->outlets;
		$oldorders = Orders::where('ID',$request->id)->first();
        
			$orders = new History;
			$orders->ID=$request->id;
		        $orders->name = $oldorders->name;
                        $orders->storeid = $oldorders->storeid;
                        $orders->user_id = $oldorders->user_id;
                        $orders->number = $oldorders->number;
                        $orders->address = $oldorders->address;          
                        $orders->payment = $oldorders->payment;           
                        $orders->items = $oldorders->items;     
                        $orders->store = $oldorders->store;
                        $orders->totalprice = $oldorders->totalprice; 
                        $orders->sedate = $oldorders->sedate;
                        $orders->setime = $oldorders->setime;
                        $orders->sts = $oldorders->sts;
                        $orders->del = $oldorders->del;
                        $orders->pick = $oldorders->pick;
                        $orders->delivery = $oldorders->delivery;
                        $orders->delcharge = $oldorders->delcharge;
                        $orders->wallet = $oldorders->wallet;
                        $orders->empname = $oldorders->empname;
                        $orders-> empnum = $oldorders-> empnum;
                        $orders-> outlets = $oldorders-> outlets;
                        $orders-> storeid = $oldorders-> storeid;
                        $orders-> storeinfo = $oldorders-> storeinfo;
                        $orders-> pick = $oldorders-> pick;
                        $orders-> remarks = $oldorders-> remarks;
                        $orders->paid = 0;
			$orders->employee = $oldorders->employee; 
                	$orders->empname = $oldorders->empname; 
                	$orders->storeinfo = $oldorders->storeinfo;
             		$orders->outlets = $oldorders->outlets;
			$orders->save();
	return $Persons;	
       }
	public function undelivery(Request $request){
                $orders = Orders::where('ID',$request->id)->first();
                $orders->del="UNDELIVERD";
		$orders->delreason=$request->reason;
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
     public function referrer(Request $request){
     Sms::with('textlocal')->send("installed",function($sms) {
       $sms->to('+91'.'6382040636');
});
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
		//$countslat = Slats::where('stotname',$request->setime)->first();
		$day = date("l");
		if($day == 'Saturday'){
		$del = 30;
                }else if($day == 'Sunday'){
		$del = 30;
		}else{
		$del = 0;
		}
	return $del;
	}
	public function showmyorder(Request $request){
		$orders = Orders::where('employee',$request->id)->where('del','In-Progress')->orwhere('del','Dispatched')->get(); 
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
	   $Persons = Persons::where('ID',$request->employee)->first();
	   $ventors = ventor::where('id',$request->vent)->first();
	   $Orders = Orders::where('ID',$request->id)->first();
	  $stores = stores::where('id',$Orders->storeid)->first();
		$Orders->del = "In-Progress";
      		$Orders->employee = $request->employee;
		$Orders->empname = $Persons->name;
                $Orders->storeinfo = $stores->ownername .' - '.$stores->mobilenumber;
		$Orders->outlets = $ventors->name .' - '.$ventors->mobilenumber;
		$Orders->update();

    }   public function empsignup(Request $request){
	try{
	$Persons = Persons::where('number',$request->number)->first();
	if(count($Persons)!=0){
	 $data = json_encode(array('login' => "invaliduser", 'Persons' => "Mobile Number Alredy Exist"));
                return $data;
	}
		$Persons = new Persons();
		$Persons->name = $request->name;
		$Persons->number = $request->number;
		$Persons->password = $request->password;
		$Persons->username = $request->number;
		$Persons->pincode = $request->pincode;
		$Persons->street =  $request->add;
            $Persons->street1 =  $request->add1;
                $Persons->city =  $request->add2;
		$Persons->role = 'emp';
		$Persons->doc1 =  $request->doc1;
		$Persons->doc2 =  $request->doc2;
                $Persons->approve = 0;
		$Persons->active = 1;
		$Persons->save();
	}catch(Exception $e){
	return $e;
	}
	}
	
        public function shareid(Request $request){
        $ref = Refer::where('person_id',$request->id)->first();
        $data = json_encode(array('login' => "validuser", 'Persons' => $ref));
                return $data;

        } 

	public function signup(Request $request){
	    $Persons = Persons::where('number',$request->number)->first();
	    if(count($Persons)!=0){
		$data = json_encode(array('login' => "invaliduser", 'Persons' => "Mobile Number Alredy Exist"));
	    	return $data;			
	    }
	//public function shareid(Request $request){
       // } 
		$Persons = new Persons();
		$Persons->name = $request->name;
		$Persons->number = $request->number;	
		$Persons->password =  $request->password;
		$Persons->username = $request->number;
		$Persons->pincode = $request->pincode;	
		$Persons->street =  $request->street;
	    $Persons->street1 =  $request->street1;
		$Persons->city =  $request->city;
        $Persons->wallet = 50;
        $Persons->refby = 1;
		$Persons->save();
                $Refer = new Refer();
	        $Refer->refid = "gnv".$request->number."joe";
		$Refer->person_id = $Persons->ID;
                 $Refer->refby = $request->refby;
                 $Refer->save();
				$data = json_encode(array('login' => "validuser", 'Persons' => $Persons));
		return $data;			
	}
	public function adminsignin(Request $request){
		$Persons = ventor::where('usname',$request->name)->where('password',$request->pwd)->get();
        if(count($Persons)!=0){
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
		        if($request->dellat == null){
			$data = json_encode(array('status' => "noordercreated", 'orders' => "Please Pin the delivery Point"));
			return $data;
			}
			$orders = new Orders();
			$orders->name = $request->name;
			$orders->storeid = $request->storeid;
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
			$orders->pick = "NOT OK";										
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
					$persons->wallet = $persons->wallet - 20 + (floor($repoint) * 2);
					$persons->update();
					$orders->wallet = 20;
					if($persons->refby = 1){
				$refer = Refer::where('person_id',$request->userid)->first();
				$persons = Persons::where('ID',$request->userid)->first();				
				$persons->refby = 0;
				$persons->update();
				$ref = Refer::where('refby',$refer->refby)->first();
				$persons = Persons::where('ID',$ref->person_id)->first();                              
                                $persons->wallet = $persons->wallet + 20;
                                $persons->update();
				}
				}				
			}
			else{
			//	 $persons = Persons::where('ID',$request->userid)->first();
			//	 $repoint = $request->totalprice / 100;
			//	 $persons->wallet = $persons->wallet + (floor($repoint) * 2);
			//	 $persons->update();

			}
		    $orders->save();
                   $sms ="Dear $orders->name, Your Order is Placed Order Id# $orders->ID and your Order value is Rs.$orders->totalprice delivery schedule at $orders->sedate.$orders->setime";
               $smsalert= new Smsalert("apikey","senderid","transactional");//change all 3 parameter values here
               $result = $smsalert->send($request->number,$sms);
//return $sms;

//			Session::put('number',$request->number);
//			Session::put('name',$request->name); 	
			$data = json_encode(array('status' => "ordercreated", 'orders' => $orders));
//		    Sms::with('textlocal')->send('Dear '.$orders->name.', Your Order is Placed Order Id# '.$orders->ID .', and your Order value is Rs.'.$orders->totalprice.', delivery schedule at '.$orders->sedate.', '.$orders->setime, function($sms) {
//			 $sms->to('+91'.Session::get('number')); 
//			});			
		    return $data;			
	}
	public function items(Request $request){
//		$sms ="Hi {firstname},";
//               $smsalert= new Smsalert("apikey","senderid","transactional");//change all 3 parameter values here
//               $result = $smsalert->send("9944825723",$sms);
//if($result){
//return $sms;
//}
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
	public function showOrders(Request $request){
		//return "sts";
		//return $request->pincode;
		if($request->pincode == '00000'){
		$orders = Orders::where('sts','NOT')->get();
                return $orders;
		}
		$orders = Orders::where('sts','NOT')->where('store',$request->pincode)->get();
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
		//$orders = Orders::all();
	 if($request->pincode == '00000'){
                $orders = Orders::where('sts','OK')->get();
                }else{
	$orders = Orders::where('sts','OK')->where('store',$request->pincode)->get();	
	}
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
	return $request->all();
		$file = $request->file('data');
	  //$file = $data->image;
      $destinationPath = 'uploads';
      $file->move($destinationPath,$file->getClientOriginalName());
	}

}
