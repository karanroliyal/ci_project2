<?php
defined('BASEPATH') or exit('No direct script access allowed');


function numberFunc($number)
{

    $number_string = strval($number);
    $number_before_point = strstr($number_string ,'.',1);
    $number = round($number,2);
    
    // echo $number ."<br>";

    // echo "I am number after round = ".$number."<br>";

    $number_after_point = substr($number , -2);

    // echo "i am after point = ".$number_after_point."<br>";

    // echo $number_string . "</br>";

    $length = strlen($number_before_point);

    // echo 'length of numbers = ' . $length . "</br>";

    $number_string_array = [];

    $objCate = ['1' => 1, '2' => 2, '3' => 1, '4' => 1, '5' => 2, '6' => 1, '7' => 2, '8' => 1, '9' => 2];

    $objVal = ['1' => '', '2' => '', '3' => 'Hundred', '4' => 'Thousand', '5' => 'Thousand', '6' => 'Lakh', '7' => 'Lakh', '8' => 'Crore', '9' => 'Crore'];

    $numVal = ['0'=>'Zero','000'=>'' ,'00'=>'' ,'1'=>'One' , '2'=>'Two' , '3'=>'Three' , '4'=>'Four' , '5'=>'Five' , '6'=>'Six' , '7'=>'Seven' , '8'=>'Eight' , '9'=>'Nine' , '10'=>'Ten' , '11'=>'Eleven' , '12'=>'Tweleve' , '13'=>'Thirteen' , '14'=>'Fourteen' , '15'=>'Fifteen' , '16'=>'Sixteen' , '18'=>'Eighteen' , '19'=>'Nineteen' , '20'=>'Twenty' ,'30'=>'Thirty' , '40'=>'Fourty','50'=>'Fifty', '60'=>'Sixty', '70'=>'Seventy', '80'=>'Eighty' , '90'=>'Ninty' , '100'=>'One Hundred' , '.'=>''];


    for ($i = 0; $i < $length; $i++) {


        $limit =  $objCate[$length - $i];
        $imaginary_length = $length - $i;
        $categorie = $objVal[$length - $i];

        // echo $imaginary_length . "=>" . $objCate[$length - $i] . "<br>";

        if($imaginary_length < $length && $limit == 1 && $objCate[$length - $i+1] == 2){
            $value = '';
        }else{
            $value = substr($number_string, $i, $limit);

            if(strlen($value) == 2){

                if(substr($value,1,1) == 0){
                    $value = $value;
                    $value =  $numVal[$value];
                }elseif(substr($value,0,1) == 0){
                    $value = substr($value,1,1);
                    $value = $numVal[$value];
                }else{
                    $value1 = substr($value,0,1).'0';
                    $value1 = $numVal[$value1];
                    $value2 = substr($value,1,1);
                    $value2 = $numVal[$value2];
                    $value = $value1.' '.$value2; 
                }
    
            }else{
                $value = $numVal[$value];
            }
                
        }

        if($imaginary_length < $length && $limit == 1 && $objCate[$length - $i+1] == 2){
            $value = '';
        }elseif($value == 'Zero'){
            $value = '';
        }else{
            $value .= " ".$categorie;
        }





        array_push($number_string_array, $value);

        
    }

    $point_arr=['Point'];

    for($i=0 ; $i<2 ; $i++){

       $point_value =  substr($number_after_point,$i,1);

       $point_value = $numVal[$point_value];

       array_push($point_arr,$point_value);

    }
    
    array_push($point_arr, 'Rupees Only/-');

    // print_r($point_arr);
    // print_r($number_string_array);
    // echo "<br>";
    $points_numbers = implode(" " ,$point_arr);
    $number_array_value = implode(" " ,$number_string_array);;
    echo $number_array_value . $points_numbers;
}