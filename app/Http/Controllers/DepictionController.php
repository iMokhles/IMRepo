<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 14:08
 */

namespace App\Http\Controllers;


use App\Models\ChangeLog;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DepictionController extends Controller
{

    public function getDepiction($package_hash) {

        return view('depiction.index', [
            'package' => Package::wherePackageHash($package_hash)->orderBy('Version', 'desc')->get()[0],
            'first_package' => Package::wherePackageHash($package_hash)->first()

        ]);
    }

    public function getChanges($package_hash) {
        return view('depiction.changelogs', [
            'changes' => ChangeLog::wherePackageHash($package_hash)->orderBy('package_version', 'desc')->get(),
            'package' => Package::wherePackageHash($package_hash)->orderBy('Version', 'desc')->get()[0]
        ]);
    }
    public function getScreenshot($id, $name) {

        $screenshotsPath = storage_path('screenshots');
        $filePath = '';
        if (str_contains($name, 'thumb')) {
            $filePath = $screenshotsPath.'/'.$id."/conversions/".$name;
        } else {
            $filePath = $screenshotsPath.'/'.$id."/".$name;
        }
        return response()->file($filePath);
    }
}
