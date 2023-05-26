<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Item extends CI_Controller
{
    //fungsi ini dijalankan ketika controller" ini diakses
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('category_model');
        $this->load->model('item_model');
    }

    public function index()
    {
        $data['title'] = 'Category';
        // $data['datas'] = $this->db->get('category')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['datas'] = $this->db->get('category')->result_array();
        // var_dump($data['datas']);


        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('item/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('category', ['name' => $this->input->post('name')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Category Added!</div>');
            redirect('item');
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('item/index', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id');
            $name = $this->input->post('name');

            $this->db->set('name', $name);
            $this->db->where('id', $id);
            $this->db->update('category');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category has been updated!!</div>');
            redirect('item');
        }
    }

    public function destroy()
    {
        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->delete('category');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category deleted successfully!!</div>');
        redirect('item');
    }


    // Item
    public function item()
    {
        $data['title'] = 'Item';
        // $data['datas'] = $this->db->get('item')->result();
        $data['datas'] = $this->item_model->getDataJoin()->result();
        // var_dump($data['datas'][0]->cate_name);
        // die;
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('item/item', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $data['title'] = 'Add Item';
        $data['datas'] = $this->db->get('item')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Item model
        $data['categories'] = $this->category_model->getData()->result();
        $data['sumCategory'] = $this->category_model->getData()->num_rows();


        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('stock', 'Stock', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('item/create', $data);
            $this->load->view('templates/footer');
        } else {

            // cek jika ada gambar yg akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/item/';

                // $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    // $old_image = $data['user']['image'];
                    // if ($old_image != 'default.png') {
                    //     unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    // }

                    $image = $this->upload->data('file_name');
                    // $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert slert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('item/create');
                }
            } else {
                $image = 'default.jpg';
            }

            $code = $this->item_model->createCode();

            $data = [
                'code' => $code,
                'name' => htmlspecialchars($this->input->post('name', true)),
                'stock' => $this->input->post('stock'),
                'image' => $image,
                'category_id' => $this->input->post('category_id'),
            ];

            // var_dump($data);
            // die;
            $this->db->insert('item', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulation! Add Item successfully !</div>');
            redirect('item/item');
        }
    }


    public function edit($code)
    {
        $data['title'] = 'Edit Item';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['datas'] = $this->db->get_where('item', ['code' => $code])->result();

        $data['categories'] = $this->category_model->getData()->result();
        $data['sumCategory'] = $this->category_model->getData()->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('item/edit', $data);
        $this->load->view('templates/footer');
    }

    public function updateItem()
    {
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('stock', 'Stock', 'required|trim');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('item/edit', $data);
            $this->load->view('templates/footer');
        } else {

            $code = $this->input->post('code');
            $name = $this->input->post('name');
            $stock = $this->input->post('stock');
            $category_id = $this->input->post('category_id');

            // cek jika ada gambar yg akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';
                $config['upload_path'] = './assets/img/item/';

                // $this->upload->initialize($config);
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/item/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert slert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('item/item');
                }
            }

            $this->db->set('name', $name);
            $this->db->set('stock', $stock);
            $this->db->set('category_id', $category_id);
            $this->db->where('code', $code);
            $this->db->update('item');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item has been updated!</div>');
            redirect('item/item');
        }
    }

    public function delete()
    {
        $code = $this->input->post('code');
        $image = $this->item_model->getImage($code);

        if ($image) {
            if ($image == 'default.jpg') {
            } else {
                unlink('./assets/item/' . $image . '');
            }
        }

        $this->db->where('code', $code);
        $this->db->delete('item');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Item deleted successfully!!</div>');
        redirect('item/item');
    }
}
