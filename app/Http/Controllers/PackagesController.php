<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 14:11
 */

namespace App\Http\Controllers;


use App\Helpers\IMPackageHelper;
use App\Models\Download;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PackagesController extends Controller
{


    protected function sendResponse($message, $error_code)
    {
        return response()->json([
            'message' => $message,
            'status' => Response::$statusTexts[$error_code],
            'status_code' => $error_code
        ])->setStatusCode($error_code, Response::$statusTexts[$error_code]);
    }

    public function getPackages(Request $request) {
        $packagesFile = IMPackageHelper::generatePackagesFile();
        return response()->download($packagesFile, 'Packages',[
            'Content-Type' => 'application/octet-stream'
        ]);
    }
    public function generateBZipPackages(Request $request) {
        $bz2File = IMPackageHelper::generateBZipPackages();
        return response()->download($bz2File, 'Packages.bz2', [
            'Content-Type' => 'application/octet-stream'
        ]);
    }
    public function generateGzPackages(Request $request) {
        $gzFile = IMPackageHelper::generateGzPackages();
        return response()->download($gzFile, 'Packages.gz', [
            'Content-Type' => 'application/octet-stream'
        ]);

    }
    public function getPackageFile(Request $request, $packageHash) {
//        $currentUser = backpack_user()->hasRole('customer');
        $debsPath = storage_path('debs');
        $filePath = $debsPath."/".$packageHash;
//        $package = Package::wherePackageHash($packageHash)->first();
//        if ($package != null) {
//            // increase downloads for package
//            // check if user downloaded this package before of not
//            $userPackage = Download::wherePackageId($package->id)->whereUserId($currentUser)->first();
//            if ($userPackage != null) {
//                // user downloaded this package before
//                $userPackage->update([
//                    'downloads' => $userPackage->count+1,
//                ]);
//            } else {
//                // user download this package for the first time
//                Download::create([
//                    'user_id' => \Auth::user()->id,
//                    'package_id' => $package->id,
//                    'count' => 1,
//                ]);
//            }
//        }
        return response()->download($filePath, "$packageHash.deb", [
            'Content-Type' => 'application/octet-stream',
            'Content-Transfer-Encoding' => 'binary',
            'Cache-Control' => 'public, must-revalidate, max-age=0',
            'Content-Disposition' => 'attachment; filename="'.$packageHash.'.deb"',
            'Content-Length: '. filesize($filePath)
        ]);
    }
    public function test_info(Request $request) {
        $packagesFile = IMPackageHelper::GeneratePackages(storage_path('debs'));
        $path = Storage::disk('storage')->put('Packages', $packagesFile);
        if ($path) {
            return $this->sendResponse("Packages file updated", Response::HTTP_OK);
        } else {
            return $this->sendResponse("Failed to update Packages file", Response::HTTP_OK);
        }
    }

}