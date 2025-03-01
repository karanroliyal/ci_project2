<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_db extends CI_Model{

    public function get_menu_db(){

      return  $this->db->get('menu');

    }

}