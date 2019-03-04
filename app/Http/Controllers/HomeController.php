<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-28
 * Time: 22:12
 */

namespace App\Http\Controllers;


use App\Helpers\IMPackageHelper;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        $packagesResults = \App\Models\Package::whereIsActive(true)->get();
        $packages = array();
        foreach ($packagesResults as $package) {
            if ($package == null)
                continue;
            if (!isset($packages[$package->Package]))
                $packages[$package->Package] = $package;
            else
                // Compare version numbers
                if (IMPackageHelper::CompareVersions($package->Version, $packages[$package->Package]->Version) > 0)
                    $packages[$package->Package] = $package;
        }

        return view('welcome', ['packages' => $packages]);

    }
}