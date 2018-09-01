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
public function orderpage();
}
