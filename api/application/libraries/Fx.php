<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fx{


    public function api_response($statusCode , $status , $data , $message){


        if($statusCode == 200){

            return json_encode(['statusCode'=>$statusCode , 'status'=>$status , 'data'=>$data , 'message'=>$message ]);
        }else{

            return json_encode(['statusCode'=>$statusCode , 'status'=>$status , 'message'=>$message ]);

        }

    }


}