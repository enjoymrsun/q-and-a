<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-7
 * Time: 下午2:26
 */

namespace framework\tools;

/*
 * image compress
 */

class Thumb {
    private $file;          // origin file
    private $thumb_path;    // path for compressed file location

    private $create_func = array(
        'image/png' => 'imagecreatefrompng',
        'image/jpeg' => 'imagecreatefromjpeg',
        'image/gif' => 'imagecreatefromgif'
    );

    private $output_func = array(
        'image/png' => 'imagepng',
        'image/jpeg' => 'imagejpeg',
        'image/gif' => 'imagegif'
    );

    private $mime;

    public function __set($p, $v) {
        if (property_exists($this, $p)) {
            $this->$p = $v;
        }
    }

    public function __get($p) {
        if (property_exists($this, $p)) {
            return $this->$p;
        }
    }

    public function __construct($file) {
        if (!file_exists($file)) {
            echo 'invalid file, please try upload again';
            exit;
        }
        // file is valid
        $this->file = $file;
        $this->mime = getimagesize($file)['mime'];
    }

    function makeThumb($area_w, $area_h) {
        $create_func = $this->create_func;
        $src_image = $create_func[$this->mime]($this->file);
        $dst_x = 0;
        $dst_y = 0;
        $src_x = 0;
        $src_y = 0;
        $src_w = imagesx($src_image);
        $src_h = imagesy($src_image);

        if ($src_w / $area_w >= $src_h / $area_h) {
            $scale = $src_w / $area_w;
        } else {
            $scale = $src_h / $area_h;
        }

        $dst_w = (int)$src_w / $scale;
        $dst_h = (int)$src_h / $scale;

        $dst_image = imagecreatetruecolor($dst_w, $dst_h);
        $color = imagecolorallocate($dst_image, 255, 255, 255);
        $color = imagecolortransparent($dst_image, $color);

        imagefill($dst_image, 0, 0, $color);

        imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

        $sub_path = date('Ymd') . '/';
        $path = $this->thumb_path;
        if (!is_dir($path . $sub_path)) {
            mkdir($path . $sub_path, 0777, true);
        }

        // thumb/20190409/
        // thumb_bs.png
        $origin_filename = basename($this->file);
        $thumb_name = 'thumb_' . $origin_filename;

        // header("Content-Type:image/png");
        $output_func = $this->output_func;
        $output_func[$this->mime]($dst_image, $path . $sub_path . $thumb_name);

        // return thumb path
        return $sub_path . $thumb_name;
    }
}