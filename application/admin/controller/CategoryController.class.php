<?php
/**
 * Created by PhpStorm.
 * User: xiangshi
 * Date: 19-4-7
 * Time: 上午10:09
 */

namespace admin\controller;

use framework\core\Controller;
use framework\tools\Upload;
use framework\tools\Thumb;
use framework\core\Factory;

/*
 * question category model, create/read/update/delete categories
 */

class CategoryController extends Controller {
    // list categories
    public function indexAction() {
        $this->smarty->display('category/index.html');
    }

    // show the form to add categories
    public function addAction() {
        $this->smarty->display('category/add.html');
    }

    // submit form and receive the form data
    public function addHandleAction() {
        $upload = new Upload();
        $upload->upload_path = UPLOADS_PATH . 'category/';
        $upload_file = $upload->doUpload($_FILES['cat_logo']);
        $thumb = new Thumb(UPLOADS_PATH . 'category/' . $upload_file);
        $thumb->thumb_path = THUMB_PATH . 'category/';
        $thumb_path = $thumb->makeThumb(50, 50);

        // store categories info and file path together into database
        $data['cat_name'] = $_POST['cat_name'];
        $data['cat_desc'] = $_POST['cat_desc'];
        $data['cat_logo'] = 'category/' . $thumb_path;
        $data['parent_id'] = $_POST['parent_id'];

        // instantiate the category model
        $model = Factory::M('Category');
        $result = $model->insert($data);
        if ($result) {
            // add success
            $this->jump('?m=admin&c=category&a=indexAction', 'add success');
        } else {
            $this->jump('?m=admin&c=category&a=addAction', 'add failed');
        }
    }

    // show the edit form for category
    public function editAction() {
    }

    // update the category
    public function updateAction() {
    }

    // delete the category
    public function deleteAction() {
    }
}