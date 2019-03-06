<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 2019-02-25
 * Time: 11:20
 */

namespace App\Helpers;


use App\Models\Package;

class IMPackageHelper
{

    /**
     * @param $bytes
     * @return string
     */
    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    /**
     * @param $filename
     * @return mixed
     */
    public static function GetPkgInfo($filename)
    {
        \Log::info("GetPkgInfo 1");
        // Open file
        if (($ar = fopen($filename, "rb")) === false)
            return false;
        $ar_stat = fstat($ar);
        \Log::info("GetPkgInfo 2");

        // Check for the magic ASCII string
        if (($magic = fread($ar, 8)) === false)
        {
            fclose($ar);
            return false;
        }
        \Log::info("GetPkgInfo 3");
        $magic = unpack("a8", $magic);
        if (strcmp("!<arch>\n", $magic[1]))
        {
            fclose($ar);
            return false;
        }
        \Log::info("GetPkgInfo 4");
        // Start reading file headers
        // Ar-File headers are 60 bytes in size
        while (($file_header_string = fread($ar, 60)) !== false)
        {
            \Log::info("GetPkgInfo 5");
            $file_header = unpack("A16name/A12timestamp/A6owner/A6group/A8mode/A10size/C2magic", $file_header_string);
            // Check for the file magic number
            if ($file_header['magic1'] != 0x60 || $file_header['magic2'] != 0x0A)
                // Assume the file is damaged
            {
                fclose($ar);
                return false;
            }
            \Log::info("GetPkgInfo 6");
            // Check if the file name is control.tar or control.tar.gz
            // control.tar.xz is not supported by this implementation
            if (str_contains($file_header['name'], 'control.tar') || str_contains($file_header['name'], 'control.tar.gz'))
            {
                // Found the control.tar/control.tar.gz file
                // Read its contents
                $control_size = intval($file_header['size']);
                if (($pos = ftell($ar)) === false || $pos + $control_size >= $ar_stat['size'])
                {
                    fclose($ar);
                    return false;
                }
                \Log::info("GetPkgInfo 7");
                $control_string = fread($ar, $control_size);
                fclose($ar);
                if ($control_string === false)
                    return false;
                if (str_contains($file_header['name'], 'control.tar.gz'))
                    // control.tar.gz needs to be decoded
                    if (($control_string = gzinflate(substr($control_string, 10, -8))) === false)
                        return false;
                // Extract file "./control" from tape archive
                \Log::info("GetPkgInfo 8");

                \Log::info("CONTROL: ".$control_string."\n Length: ".strlen($control_string));

                while (strlen($control_string) >= 512)
                {
                    // Read header
                    $tar_header = unpack("A100name/A8mode/A8owner/A8group/A12size/A12timestamp/A8checksum/A1type/A355padding", $control_string);
                    // Check checksum
                    $control_string = substr_replace($control_string, "\x20\x20\x20\x20\x20\x20\x20\x20", 148, 8);
                    $calculated_sum = 0;
                    for ($i = 0; $i < 512; $i++)
                    {
                        $calculated_sum += ord($control_string[$i]);
                    }
                    \Log::info("GetPkgInfo 9: ".$tar_header['type']." :: ".$tar_header['name']);
//                    if (intval($tar_header['checksum'], 8) != $calculated_sum)
//                        // Assume the file is damaged
//                        return false;
                    // Check if file is a normal file
                    if ($tar_header['type'] == 0x00 || intval($tar_header['type']) == 0)
                    {
                        \Log::info("GetPkgInfo 9+: ".$tar_header['type']." :: ".$tar_header['name']);

                        // Check if filename equals "./control"
                        if (str_contains($tar_header['name'],'control'))
                        {
                            \Log::info("GetPkgInfo 10");
                            // Read the control file
                            $size = intval($tar_header['size'], 8);
                            $reqfl = 512 + $size;
                            if ($reqfl >= strlen($control_string))
                                return false;
                            $control_string = substr($control_string, 512, $size);
//                            $control_fields = explode("\n", $control_string);
                            $plain_array = explode("\n",$control_string);
                            $control = array();
                            $t_key = "";
                            \Log::info("GetPkgInfo 11");
                            foreach ($plain_array as $line) {
                                if (strlen(trim(substr($line, 0, 1))) == 0) {
                                    $t_value = trim($line);
                                    $control[$t_key] .= "\n".$t_value;
                                } else {
                                    if(preg_match("#^Package|Source|Version|Priority|Section|Essential|Maintainer|Pre-Depends|Depends|Recommends|Suggests|Conflicts|Provides|Replaces|Enhances|Architecture|Filename|Size|Installed-Size|Description|Origin|Bugs|Name|Author|Homepage|Website|Depiction|Icon|Tag|Sponsor#",$line)) {
                                        preg_match("#^([^:]*?):(.*)#", $line, $t_matches);
                                        $t_key = trim($t_matches[1]);
                                        $t_value = trim($t_matches[2]);
                                        $control[$t_key] = $t_value;
                                    }
                                }
                            }
                            \Log::info("GetPkgInfo 12");
//                            $control = array();
//                            foreach ($control_fields as $field) {
//                                if (!strlen($field))
//                                    continue;
//
//                                $remove_character = array(“\n”, “\r\n”, “\r”);
//
//                                $str = str_replace($remove_character, ‘ ‘, $field);
//
//                                $str_trimed = str_replace(array("\n", "\r"), ' ', $field);
//
//                                $tmp = explode(":", $str_trimed, 2);
//
//                                \Log::info(implode("|",$tmp));
//
//                                if (is_array($tmp)) {
//                                    $control[$tmp[0]] = trim($tmp[1]);
//                                }
//
//                            }
                            // Check if basic package information (id and version) is available
                            if (!isset($control['Package']) || !isset($control['Version']))
                                return false;
                            // Add size of debian package
                            \Log::info("GetPkgInfo 13");
                            $control['Size'] = $ar_stat['size'];
                            $control['MD5sum'] = md5_file($filename);
                            if ($control['MD5sum'] === false)
                                return false;
                            $control["Filename"] = "debs/".basename($filename, '.deb');
                            return $control;
                        }
                    }
                    \Log::info("GetPkgInfo 14");
                    // Skip until next file
                    $bytes = 512 + intval($tar_header['size'], 8);
                    $padding = $bytes % 512;
                    $padding = !$padding ? $padding : 512 - $padding;
                    $bytes += $padding;
                    if ($bytes >= strlen($control_string))
                        return false;
                    $control_string = substr($control_string, $bytes);
                    \Log::info("GetPkgInfo 15");
                }
            }
            // Seek to the next file header
            $file_size = intval($file_header['size']);
            if ($file_size & 0x1)
                $file_size++;
            if (($pos = ftell($ar)) === false || $pos + $file_size >= $ar_stat['size'])
                return false;
            fseek($ar, $file_size, SEEK_CUR);
            \Log::info("GetPkgInfo 16");
        }
        fclose($ar);
        return false;
    }

    /**
     * @param $ver1
     * @param $ver2
     * @return int
     */
    public static function CompareVersionNumber($ver1, $ver2)
    {
        for ($i = 0, $vl1 = strlen($ver1), $vl2 = strlen($ver2); $i < $vl1 && $i < $vl2; $i++)
        {
            $val1 = ord($ver1[$i]);
            $val2 = ord($ver2[$i]);
            if ($ver1[$i] == '~')
                $val1 = 0;
            if ($ver2[$i] == '~')
                $val2 = 0;
            if (!ctype_alnum($ver1[$i]))
                $val1 += 0xFF;
            if (!ctype_alnum($ver2[$i]))
                $val2 += 0xFF;
            if ($val1 > $val2)
                return 1;
            else if ($val1 < $val2)
                return -1;
        }
        return 0;
    }

    /**
     * @param $ver1: First version number
     * @param $ver2: Second version number
     * @return int
     */
    public static function CompareVersions($ver1, $ver2)
    {
        // Prepare associative arrays for version numbers
        $version1 = array("epoch" => 0, "debian_revision" => "", "upstream_version" => $ver1);
        $version2 = array("epoch" => 0, "debian_revision" => "", "upstream_version" => $ver2);
        // split version into epoch, upstream_version and debian_revision
        // Retrieve epoch
        $epoch = explode(":", $ver1, 2);
        if (count($epoch) == 2)
        {
            $version1['epoch'] = intval($epoch[0]);
            $version1['upstream_version'] = $epoch[1];
        }
        $epoch = explode(":", $ver2, 2);
        if (count($epoch) == 2)
        {
            $version2['epoch'] = intval($epoch[0]);
            $version2['upstream_version'] = $epoch[1];
        }
        // Compare epoch
        if ($version1['epoch'] > $version2['epoch'])
            return 1;
        else if ($version1['epoch'] < $version2['epoch'])
            return -1;
        // Retrieve debian_revision
        $version1['debian_revision'] = strrchr($ver1, "-");
        if ($version1['debian_revision'] === false)
            $version1['debian_revision'] = "";
        $version2['debian_revision'] = strrchr($ver2, "-");
        if ($version2['debian_revision'] === false)
            $version2['debian_revision'] = "";
        // Retrieve upstream version
        $rev_pos = strrpos($version1['upstream_version'], "-");
        if ($rev_pos !== false)
            $version1['upstream_version'] = substr($version1['upstream_version'], 0, $rev_pos);
        $rev_pos = strrpos($version2['upstream_version'], "-");
        if ($rev_pos !== false)
            $version2['upstream_version'] = substr($version2['upstream_version'], 0, $rev_pos);
        // Compare upstream version
        $cmpres = self::CompareVersionNumber($version1['upstream_version'], $version2['upstream_version']);
        if ($cmpres)
            return $cmpres;
        // Compare debian revision
        $cmpres = self::CompareVersionNumber($version1['debian_revision'], $version2['debian_revision']);
        return $cmpres;
    }

    /**
     * @param $dir : Directory to search for debian packages
     * @return bool|string
     */
    public static function GeneratePackages($dir)
    {
        if (($debs = glob($dir . "/*.deb")) === false)
            return false;
        $packages = array();
        foreach ($debs as $deb) {
            if (($control = self::GetPkgInfo($deb)) === false)
                continue;
            if (!isset($packages[$control['Package']]))
                $packages[$control['Package']] = $control;
            else
                // Compare version numbers
                if (self::CompareVersions($control['Version'], $packages[$control['Package']]['Version']) > 0)
                    $packages[$control['Package']] = $control;
        }
        $packages_string = "";
        foreach ($packages as $info)
        {
            foreach ($info as $fieldname => $value)
                $packages_string .= $fieldname . ": " . $value . "\n";
            $packages_string .= "\n";
        }
        return $packages_string;
    }

    /**
     * @param $dir
     * @return array|bool
     */
    public static function  GeneratePackagesArrayInfo($dir)
    {
        if (($debs = glob($dir . "/*.deb")) === false)
            return false;
        $packages = array();
        foreach ($debs as $deb) {
            if (($control = self::GetPkgInfo($deb)) === false)
                continue;
            if (!isset($packages[$control['Package']]))
                $packages[$control['Package']] = $control;
            else
                // Compare version numbers
                if (self::CompareVersions($control['Version'], $packages[$control['Package']]['Version']) > 0)
                    $packages[$control['Package']] = $control;
        }
        $packages_array = [];
        foreach ($packages as $info)
        {
            array_push($packages_array, $info);
        }
        return $packages_array;
    }

    /**
     * @param $package_bundle
     * @return mixed
     */
    public static function getLastVersionAvailabe($package_bundle) {
        $queryPackages = Package::select(config('repo_config.packages_select'));
        $queryPackages = $queryPackages->where([
            "is_active" => true,
            "Package" => $package_bundle
        ]);
        $packagesResults = $queryPackages->get();
        $packages = array();
        foreach ($packagesResults as $package) {
            if ($package == null)
                continue;
            if (!isset($packages[$package->Package]))
                $packages[$package->Package] = $package;
            else
                // Compare version numbers
                if (self::CompareVersions($package->Version, $packages[$package->Package]->Version) > 0)
                    $packages[$package->Package] = $package;
        }
        return $packages[$package_bundle]->Version;
    }

    /**
     * @param $hash
     * @return mixed|null
     */
    public static function isPaidPackage($hash) {
        $package = Package::wherePackageHash($hash)->whereIsPaid(true)->first();
        if ($package != null) {
            return $package;
        }
        return null;
    }

    public static function generatePackagesFile() {
        $queryPackages = Package::select(config('repo_config.packages_select'));
        $queryPackages = $queryPackages->where([
            "is_active" => true
        ]);
        $packagesResults = $queryPackages->get();

        $packagesText = "";
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

        foreach ($packages as $package2) {
            $packageText = "";
            foreach($package2->getAttributes() as $key => $value) {

                if (!empty($key) && !empty($value)) {
                    $packageText .= $key . ": " . trim(str_replace("\n", "\n ", $value)) . "\n";
                }
            }
            $packagesText .= $packageText . "\n";
        }
        $packagesFile = storage_path("Packages");
        if (file_exists($packagesFile)) {
            unlink($packagesFile);
            $handle = fopen($packagesFile, "w");
            $size = fwrite($handle, $packagesText);
            fclose($handle);
            return $packagesFile;
        } else {
            $handle = fopen($packagesFile, "w");
            $size = fwrite($handle, $packagesText);
            fclose($handle);
            return $packagesFile;
        }
    }
    public static function generateBZipPackages() {
        $queryPackages = Package::select(config('repo_config.packages_select'));
        $queryPackages = $queryPackages->where([
            "is_active" => true
        ]);
        $packagesResults = $queryPackages->get();
        $packagesText = "";
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
        foreach ($packages as $package2) {
            $packageText = "";
            foreach($package2->getAttributes() as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $packageText .= $key . ": " . trim(str_replace("\n", "\n ", $value)) . "\n";
                }
            }
            $packagesText .= $packageText . "\n";
        }
        $packagesFile = storage_path("Packages");
        $handle = fopen($packagesFile, "w");
        $size = fwrite($handle, $packagesText);
        fclose($handle);
        $bz2File = storage_path("Packages.bz2");
        if (file_exists($bz2File)) {
            unlink($bz2File);
            $b_handle = bzopen($bz2File, "w");
            $size = bzwrite($b_handle, file_get_contents($packagesFile));
            bzclose($b_handle);
            return $bz2File;
        } else {
            $b_handle = bzopen($bz2File, "w");
            $size = bzwrite($b_handle, file_get_contents($packagesFile));
            bzclose($b_handle);
            return $bz2File;
        }
    }

    public static function generateGzPackages() {
        $queryPackages = Package::select(config('repo_config.packages_select'));
        $queryPackages = $queryPackages->where([
            "is_active" => true
        ]);
        $packagesResults = $queryPackages->get();
        $packagesText = "";
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
        foreach ($packages as $package2) {
            $packageText = "";
            foreach($package2->getAttributes() as $key => $value) {
                if (!empty($key) && !empty($value)) {
                    $packageText .= $key . ": " . trim(str_replace("\n", "\n ", $value)) . "\n";
                }
            }
            $packagesText .= $packageText . "\n";
        }
        $packagesFile = storage_path("Packages");
        $handle = fopen($packagesFile, "w");
        $size = fwrite($handle, $packagesText);
        fclose($handle);
        $gzFile = storage_path("Packages.gz");
        if (file_exists($gzFile)) {
            unlink($gzFile);
            $b_handle = gzopen($gzFile, "w");
            $size = gzwrite($b_handle, file_get_contents($packagesFile));
            gzclose($b_handle);
            return $gzFile;
        } else {
            $b_handle = gzopen($gzFile, "w");
            $size = gzwrite($b_handle, file_get_contents($packagesFile));
            gzclose($b_handle);
            return $gzFile;
        }
    }
}