<?php
defined('BASEPATH') or exit('No direct script access allowed');

function pageination_builder($liveFormData , $table_name , $current_page_opened , $limit , $join_column , $join_on){

    $CI =& get_instance();

    // This code is creating dynamic pagination 
    foreach($liveFormData as $key=>$value){
        $CI->db->like($key , $value );
    }

    $total_records = $CI->db->from($table_name);

    // if any join available
    if (isset($join_column)) {

        for ($i = 0; $i < count($join_column); $i++) {

            $total_records = $CI->db->join($join_column[$i], $join_on[$i]);

        }
    }

    $total_records = $CI->db->count_all_results();

    // Number of pages 
    $pages = ceil($total_records / $limit);


    $ulData = " <nav aria-label='Page navigation example'  >
                    <ul class='pagination my-pagination mb-0 {$pages}'  >
                        <li class='page-item'  >
                            <a class='page-link prev'  aria-label='Previous' (click)='totalPages(totalPages.value)' #totalPages [value]={$pages} >
                                <span aria-hidden='true'>&laquo;</span>
                            </a>
                        </li>";

    
        $ulData .= "    <li id='{$current_page_opened}' class='page-item li active'>
                            <a class='page-link'>$current_page_opened</a>
                        </li>";

    $ulData .= "        <li class='page-item'>
                            <a class='page-link next' aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>";

                return json_encode(['totalPages'=>$pages , 'current_page_opened'=>$current_page_opened ]);
                // return $ulData;
}