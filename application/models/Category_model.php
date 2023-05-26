<?php

defined('BASEPATH') or exit('No direct script access allowed'); //agar tidak bisa langsung diakses filenya oleh user

class Category_model extends CI_Model
{
    public function getData()
    {
        $this->db->order_by('id', 'DESC');
        return $query = $this->db->get('category');
    }
}
