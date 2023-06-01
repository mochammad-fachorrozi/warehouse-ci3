<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
    //fungsi ini dijalankan ketika controller" ini diakses
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('item_model');
        $this->load->model('input_item_model');
        $this->load->model('output_item_model');
    }

    public function index()
    {
        $data['title'] = 'Input Item';
        // $data['datas'] = $this->db->get('input_item')->result();
        $data['datas'] = $this->input_item_model->getDataJoin()->result();

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        // var_dump($data['user']);
        // die;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaction/index', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $data['title'] = 'Add Input Item';
        $data['datas'] = $this->db->get('input_item')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        // Item model
        $data['items'] = $this->item_model->getData()->result();
        $data['sumItem'] = $this->item_model->getData()->num_rows();


        $this->form_validation->set_rules('code_item', 'Code Item', 'required');
        $this->form_validation->set_rules('qty', 'Qty', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaction/create', $data);
            $this->load->view('templates/footer');
        } else {

            $code = $this->input_item_model->createCode();

            $data = [
                'code' => $code,
                'code_item' => $this->input->post('code_item'),
                'qty' => $this->input->post('qty'),
                'is_approved' => 0,
                'date' => $this->input->post('date'),
                'user_id' => $data['user']['id'],
            ];

            // var_dump($data);
            // die;
            $this->db->insert('input_item', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulation! Add Input Item successfully !</div>');
            redirect('transaction');
        }
    }

    public function edit($code)
    {
        $data['title'] = 'Edit Input Item';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['datas'] = $this->db->get_where('input_item', ['code' => $code])->result();

        // Item model
        $data['items'] = $this->item_model->getData()->result();
        $data['sumItem'] = $this->item_model->getData()->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaction/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $this->form_validation->set_rules('code_item', 'Code Item', 'required');
        $this->form_validation->set_rules('qty', 'Qty', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaction/edit', $data);
            $this->load->view('templates/footer');
        } else {

            $code = $this->input->post('code');
            $code_item = $this->input->post('code_item');
            $qty = $this->input->post('qty');
            $is_approved = $this->input->post('is_approved');
            $date = $this->input->post('date');
            $user_id = $this->input->post('user_id');

            $this->db->set('code_item', $code_item);
            $this->db->set('qty', $qty);
            $this->db->set('is_approved', $is_approved);
            $this->db->set('date', $date);
            $this->db->set('user_id', $user_id);
            $this->db->where('code', $code);
            $this->db->update('input_item');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Input Item has been updated!</div>');
            redirect('transaction');
        }
    }

    public function destroy()
    {
        $code = $this->input->post('code');

        $this->db->where('code', $code);
        $this->db->delete('input_item');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Input Item deleted successfully!!</div>');
        redirect('transaction');
    }

    public function approve()
    {
        $code = $this->input->post('code');
        $qty = $this->input->post('qty');
        $code_item = $this->input->post('code_item');
        $is_approved = 1;

        $name = $code_item;
        $data['item'] = $this->item_model->getDataByName($name);
        $stock = $data['item'][0]->stock;

        $result = $qty + $stock;
        // var_dump($result);
        // die;

        // table item
        $this->db->set('stock', $result);
        $this->db->where('name', $code_item);
        $this->db->update('item');


        // table input item
        $this->db->set('is_approved', $is_approved);
        $this->db->where('code', $code);
        $this->db->update('input_item');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully approved data!</div>');
        redirect('transaction');
    }

    public function reject()
    {
        $code = $this->input->post('code');
        $is_approved = 2;

        $this->db->set('is_approved', $is_approved);
        $this->db->where('code', $code);
        $this->db->update('input_item');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Successfully rejected data!</div>');
        redirect('transaction');
    }



    // Output Item
    public function indexOutput()
    {
        $data['title'] = 'Output Item';
        $data['datas'] = $this->output_item_model->getDataJoin()->result();

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaction/index_output', $data);
        $this->load->view('templates/footer');
    }

    public function createOutput()
    {
        $data['title'] = 'Add Output Item';
        $data['datas'] = $this->db->get('output_item')->result();
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        // Item model
        $data['items'] = $this->item_model->getData()->result();
        $data['sumItem'] = $this->item_model->getData()->num_rows();


        $this->form_validation->set_rules('code_item', 'Code Item', 'required');
        $this->form_validation->set_rules('qty', 'Qty', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaction/create_output', $data);
            $this->load->view('templates/footer');
        } else {

            $code = $this->output_item_model->createCode();

            $data = [
                'code' => $code,
                'code_item' => $this->input->post('code_item'),
                'qty' => $this->input->post('qty'),
                'is_approved' => 0,
                'date' => $this->input->post('date'),
                'user_id' => $data['user']['id'],
            ];

            // var_dump($data);
            // die;
            $this->db->insert('output_item', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> Congratulation! Add Output Item successfully !</div>');
            redirect('transaction/indexOutput');
        }
    }

    public function editOutput($code)
    {
        $data['title'] = 'Edit Output Item';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['datas'] = $this->db->get_where('output_item', ['code' => $code])->result();

        // Item model
        $data['items'] = $this->item_model->getData()->result();
        $data['sumItem'] = $this->item_model->getData()->num_rows();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('transaction/edit_output', $data);
        $this->load->view('templates/footer');
    }

    public function updateOutput()
    {
        $this->form_validation->set_rules('code_item', 'Code Item', 'required');
        $this->form_validation->set_rules('qty', 'Qty', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('transaction/edit_output', $data);
            $this->load->view('templates/footer');
        } else {

            $code = $this->input->post('code');
            $code_item = $this->input->post('code_item');
            $qty = $this->input->post('qty');
            $is_approved = $this->input->post('is_approved');
            $date = $this->input->post('date');
            $user_id = $this->input->post('user_id');

            $this->db->set('code_item', $code_item);
            $this->db->set('qty', $qty);
            $this->db->set('is_approved', $is_approved);
            $this->db->set('date', $date);
            $this->db->set('user_id', $user_id);
            $this->db->where('code', $code);
            $this->db->update('output_item');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Output Item has been updated!</div>');
            redirect('transaction/indexOutput');
        }
    }

    public function destroyOutput()
    {
        $code = $this->input->post('code');

        $this->db->where('code', $code);
        $this->db->delete('output_item');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Output Item deleted successfully!!</div>');
        redirect('transaction/indexOutput');
    }

    public function approveOutput()
    {
        $code = $this->input->post('code');
        $qty = $this->input->post('qty');
        $code_item = $this->input->post('code_item');
        $is_approved = 1;

        $name = $code_item;
        $data['item'] = $this->item_model->getDataByName($name);
        $stock = $data['item'][0]->stock;

        $result = $stock - $qty;
        // var_dump($result);
        // die;

        // table item
        $this->db->set('stock', $result);
        $this->db->where('name', $code_item);
        $this->db->update('item');


        // table input item
        $this->db->set('is_approved', $is_approved);
        $this->db->where('code', $code);
        $this->db->update('output_item');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully approved data!</div>');
        redirect('transaction/indexOutput');
    }

    public function rejectOutput()
    {
        $code = $this->input->post('code');
        $is_approved = 2;

        $this->db->set('is_approved', $is_approved);
        $this->db->where('code', $code);
        $this->db->update('output_item');
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Successfully rejected data!</div>');
        redirect('transaction/indexOutput');
    }
}
