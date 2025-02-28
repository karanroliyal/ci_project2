<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class Table_data{


    public function table_controls($tableData){

        return json_encode(['sortOn'=>$tableData['sortOn'] , 'sortOrder'=>$tableData['sortOrder'] , 'pageLimit'=>$tableData['pageLimit'] , 'currentPage'=>$tableData['currentPage'] ]);

    }



}




?>