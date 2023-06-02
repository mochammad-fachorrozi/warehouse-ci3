<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function getDataJoin()
    {
        $this->db->select('u.*, ur.role');
        $this->db->from('user as u');
        $this->db->join('user_role as ur', 'u.role_id = ur.id');
        $this->db->order_by('u.id', 'DESC');

        return $this->db->get()->result();
    }
}
