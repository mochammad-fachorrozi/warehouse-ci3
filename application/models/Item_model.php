<?php

defined('BASEPATH') or exit('No direct script access allowed'); //agar tidak bisa langsung diakses filenya oleh user

class Item_model extends CI_Model
{
    public function getData()
    {
        $this->db->order_by('id', 'DESC');
        return $query = $this->db->get('item');
    }

    public function getDataJoin()
    {
        $this->db->select('i.*, c.name as cate_name');
        $this->db->from('item as i');
        $this->db->join('category as c', 'i.category_id = c.id');
        $this->db->order_by('i.id', 'DESC');

        return $query = $this->db->get();
    }

    public function createCode()
    {
        $this->db->select('RIGHT(item.code,4) as kode', FALSE);
        $this->db->order_by('kode', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('item');      //cek dulu apakah ada sudah ada kode di tabel.
        if ($query->num_rows() <> 0) {
            //jika kode ternyata sudah ada.
            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            //jika kode belum ada
            $kode = 1;
        }
        $kodeMax = str_pad($kode, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
        $kodeFix = "ITM-" . $kodeMax;
        return $kodeFix;
    }

    public function getImage($id)
    {
        $this->db->select("image");
        $this->db->from("item");
        $this->db->where("id", $id);
        return $this->db->get()->result();
    }
}
