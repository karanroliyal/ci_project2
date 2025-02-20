<?php

use PhpParser\Node\Expr\Instanceof_;

$title = "Invoice pdf";
include "templates/header.php";
?>
<table class="table">

    <tr>
        <td><img src="<?= base_url() . "assets/images/logo.png" ?>" width="300px" alt=""></td>
        <td>
            <h1 style="font-size: 30px; font-weight:800; font-family: Arial;">
                Invoice
            </h1>
        </td>
    </tr>

</table>
<?php

$CI =& get_instance();

$CI->db->select('name , address , invoice_date , phone , total_amount');
$CI->db->from('invoice_master');
$CI->db->where('invoice_id',$id);

$CI->db->join('client_master cm','cm.id=invoice_master.client_id');

$client_data = $CI->db->get()->result();

?>

<table style="font-family: Arial" class="mb-4">
    <tr>
        <td style="font-size: 15px;">Name : <i> <?=$client_data[0]->name?> </i></td>
    </tr>
    <tr>
        <td style="font-size: 15px;">Address : <i> <?=$client_data[0]->address?> </i></td>
    </tr>
    <tr>
        <td style="font-size: 15px;">Date : <i> <?=$client_data[0]->invoice_date?> </i> </td>
    </tr>
    <tr>
        <td style="font-size: 15px;">Phone : <i> <?=$client_data[0]->phone?> </i> </td>
    </tr>
</table>


<?php

$CI =& get_instance();

$CI->db->select('item_name , quantity , item_price , amount');
$CI->db->from('invoice');
$CI->db->where('invoice_id',$id);

$CI->db->join('item_master im','im.id=invoice.item_id');

$itemData = $CI->db->get()->result();
// print_r($CI->db->get('')->result());

?>

<table class="table" style="font-family: Arial;padding:5px;">

    <tr style="background: black;">

        <th style="color:aliceblue;padding:5px;">Sno.</th>
        <th style="color:aliceblue;padding:5px;">Item name</th>
        <th style="color:aliceblue;padding:5px;">Quantity</th>
        <th style="color:aliceblue;padding:5px;">Price</th>
        <th style="color:aliceblue;padding:5px;">Total</th>

    </tr>

<?php  

$data = "";

foreach($itemData as $row){


    // Output each row dynamically
    $data .= "<tr>
        <td style='padding: 10px;'>$row->item_name</td>
        <td style='padding: 10px;'>$row->item_name</td>
        <td style='padding: 10px;'>$row->quantity</td>
        <td style='padding: 10px;'>₹$row->item_price</td>
        <td style='padding: 10px;'>₹$row->amount</td>
    </tr>";

}

echo $data;


?>



</table>



<hr>

<div style='margin-left: 500px;font-family: Arial;'>

    <h4 style="white-space: nowrap;">Subtotal: <span>₹<?=$client_data[0]->total_amount?></span></h4>
    <h4><span style="font-weight:bold" >Total:</span> <span>₹<?=$client_data[0]->total_amount?>/-</span></h4>
    <h4><?php 
    
    $CI->load->helper('number');
    numberFunc($client_data[0]->total_amount);

    
    ?></h4>


</div>

<hr>

<p style="text-align: center;font-family: Arial;">Thank you for shopping</p>

<?php

include "templates/footer.php";

?>