<?php
class Attachment extends AppModel {
    public $actsAs = array(
        'Upload.Upload' => array(
            'file' => array(
                'thumbnailSizes' => array(
                    'thumb150' => '225x150',
                    'thumb80' => '120x80',
                ),
                'thumbnailMethod' => 'php',//GDでサムネイル作成
                'mimetypes' => array('image/jpeg', 'image/gif', 'image/png'),//許可するmimetype
                'extensions' => array('jpg', 'jpeg', 'JPG', 'JPEG', 'gif', 'GIF', 'png', 'PNG'),//許可する画像の拡張子
                'maxSize' => 209715200, //許可する画像のサイズ 2MB
            )
        )
    );
}