<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-7
 * Time: 下午2:26
 */

namespace framework\tools;

use \finfo;

class Upload {
    private $upload_path = 'uploads/';  // upload path
    private $maxsize = 200 * 1024;      // max file size
    private $prefix = 'tn_';            // file name prefix

    // upload types
    private $allow_type = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');

    // update
    public function __set($p, $v) {
        if (property_exists($this, $p)) {
            $this->$p = $v;
        }
    }

    // read
    public function __get($p) {
        return $this->$p;
    }

    public function doUpload($file) {
        $destination = $this->upload_path;

        // 1. limit file size
        $maxsize = $this->maxsize;      // 200KB
        if ($file['size'] > $maxsize) {
            echo 'too large file, server cannot hold';
            exit;
        }

        // 2. prevent file duplicate
        $filename = uniqid($this->prefix, true);
        $ext = strrchr($file['name'], '.');
        $new_filename = $filename . $ext;

        // 3. use date to store
        $sub_path = date('Ymd') . '/';
        // if not exist, then create the directory
        if (!is_dir($destination . $sub_path)) {
            mkdir($destination . $sub_path, 0777, true);
        }
        $destination .= $sub_path . $new_filename;

        // 4. type is support or not
        $allow_type = $this->allow_type;
        $true_type = $file['type'];
        if (!in_array($true_type, $allow_type)) {
            echo 'not supportive type';
            exit;
        }

        // use finfo to get the file's real type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type = $finfo->file($file['tmp_name']);
        if (!in_array($type, $allow_type)) {
            echo 'not supportive type';
            exit;
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // path need to be stored in database
            // return path from the date
            return $sub_path . $new_filename;
        } else {
            return false;
        }
    }
}