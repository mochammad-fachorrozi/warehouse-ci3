<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Input_item_model extends CI_Model
{
    public function getData()
    {
        $this->db->order_by('id', 'DESC');
        return $query = $this->db->get('input_item');
    }

    public function getDataJoin()
    {
        $this->db->select('iim.*, i.name as name_item, i.stock, u.name');
        $this->db->from('input_item as iim');
        $this->db->join('item as i', 'i.code = iim.code_item');
        $this->db->join('user as u', 'u.id = iim.user_id');
        $this->db->order_by('iim.id', 'DESC');

        return $query = $this->db->get();
    }

    public function createCode()
    {
        $this->db->select('RIGHT(input_item.code,4) as kode', FALSE);
        $this->db->order_by('kode', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('input_item'); //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            //jika kode ternyata sudah ada.
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            //jika kode belum ada
            $kode = 1;
        }
        $kodeMax = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
        $kodeFix = "IIM-" . $kodeMax;
        return $kodeFix;
    }
}
