<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
// use App\Merchandise;

use App\Jobs\MerchandiseIndexData;


class MerchandiseController extends Controller
{
  //
  public function index(Request $request)
  {
    $data = $this->dispatch(new MerchandiseIndexData());
    return view('merchandise.index', $data);
    // return ['a', 'b', 'c'];
  }

  public function wxcode(Request $request){
    $data = config('merchandise.introduction');
    // return $data;
    return view('merchandise.introduction', $data);
    /*     return redirect('http://127.0.0.1/uploads/xiaomei.jpg');*/
  }
}
