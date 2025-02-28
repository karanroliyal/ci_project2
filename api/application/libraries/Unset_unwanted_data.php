<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Unset_unwanted_data{


    public function unset_data($postData){

        $unsetKeys = ['table', 'id', 'action', 'image', 'uploadImage'];
        
        foreach ($unsetKeys as $key) {
            if (isset($postData[$key])) {
                unset($postData[$key]);
            }
        }

        return $postData;

    }


}


?>