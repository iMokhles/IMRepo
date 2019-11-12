<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 14:08
 */

namespace App\Http\Controllers;


use App\Helpers\IMPackageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Prologue\Alerts\Facades\Alert;

class RepoController extends Controller
{

    public function getRelease(Request $request) {


        // Check if Packages files exists
        $packagesFile = storage_path('Packages');
        if (!file_exists($packagesFile)) {
            $packagesFile = IMPackageHelper::generatePackagesFile();
        }
        $bz2File = storage_path('Packages.bz2');
        if (!file_exists($bz2File)) {
            $bz2File = IMPackageHelper::generateBZipPackages();
        }
        $gzFile = storage_path('Packages.gz');
        if (!file_exists($bz2File)) {
            $gzFile = IMPackageHelper::generateGzPackages();
        }

        $origin = Config::get('settings.release_origin');
        $label = Config::get('settings.release_label');
        $version = Config::get('settings.release_version');
        $description = Config::get('settings.release_description');
        $md5_packages = md5_file($packagesFile);
        $md5_packagesBz = md5_file($bz2File);
        $md5_packagesGz = md5_file($gzFile);
        $size_packages = filesize($packagesFile);
        $size_packagesBz = filesize($bz2File);
        $size_packagesGz = filesize($gzFile);
        $release_file_content = "Origin: $origin
Label: $label
Suite: stable
Version: $version
Codename: $origin
Architectures: iphoneos-arm
Components: main
Description: $description
MD5Sum:
$md5_packages $size_packages Packages
$md5_packagesGz $size_packagesGz Packages.gz
$md5_packagesBz $size_packagesBz Packages.bz2";

        $releaseFile = storage_path("Release");
        if (file_exists($releaseFile)) {
            unlink($releaseFile);
            $handle = fopen($releaseFile, "w");
            $size = fwrite($handle, $release_file_content) ;//str_replace(" ", "", $release_file_content));
            fclose($handle);
            return response()->download($releaseFile, 'Release', [
                'Content-Type' => 'application/octet-stream'
            ]);
        } else {
            $handle = fopen($releaseFile, "w");
            $size = fwrite($handle, $release_file_content) ;//str_replace(" ", "", $release_file_content));
            fclose($handle);
            return response()->download($releaseFile, 'Release', [
                'Content-Type' => 'application/octet-stream'
            ]);
        }
    }
    public function getSignedRelease(Request $request) {
    }
    public function getCydiaIcon(Request $request) {
        $releaseFile = storage_path("icon/CydiaIcon.png");
        return response()->download($releaseFile, 'CydiaIcon', [
            'Content-Type' => 'application/octet-stream'
        ]);
    }
    public function getCydiaIconPng(Request $request) {
        $releaseFile = storage_path("icon/CydiaIcon.png");
        return response()->download($releaseFile, 'CydiaIcon.png', [
            'Content-Type' => 'application/octet-stream'
        ]);
    }
    public function buildPackages(Request $request) {
        $packagesFile = IMPackageHelper::generatePackagesFile();
        $bz2File = IMPackageHelper::generateBZipPackages();
        $gzFile = IMPackageHelper::generateGzPackages();

        if (filesize($packagesFile) > 0 && filesize($bz2File) > 0 && filesize($gzFile) > 0) {
            \Alert::success('SUCCESS: built packages successfully')->flash();
            return redirect(backpack_url('dashboard'));
        }
        \Alert::error('FAILED: faced error while building packages')->flash();
        return redirect(backpack_url('dashboard'));
    }
}
