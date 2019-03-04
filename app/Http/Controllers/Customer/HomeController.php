<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-28
 * Time: 22:12
 */

namespace App\Http\Controllers\Customer;


use App\Helpers\IMPackageHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view('customer.welcome');
    }
}