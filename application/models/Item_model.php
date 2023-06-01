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

        return $this->db->get()->result();
    }

    public function getDataJoinById($id)
    {
        $this->db->select('i.*, c.name as cate_name');
        $this->db->from('item as i');
        $this->db->join('category as c', 'i.category_id = c.id');
        $this->db->where('i.category_id', $id);
        $this->db->order_by('i.id', 'DESC');

        return $this->db->get()->result();
    }

    public function getDataByName($name)
    {
        $this->db->select('*');
        $this->db->from('item');
        $this->db->where('name', $name);

        return $this->db->get()->result();
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

    public function getImage($code)
    {
        $this->db->select("image");
        $this->db->from("item");
        $this->db->where("code", $code);
        return $this->db->get()->result();
    }
}
