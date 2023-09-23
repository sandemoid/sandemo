<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model');
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->Menu_model->getMenu();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template_auth/header', $data);
            $this->load->view('template_auth/topbar', $data);
            $this->load->view('template_auth/sidebar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template_auth/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu'), 'sort' => $this->input->post('sort')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">New menu succes add!</div>');
            redirect('admin/menu');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $menu = $this->input->post('menu');

        $data = array(
            'id' => $id,
            'menu' => $menu
        );

        $this->db->where('id', $id);
        $this->db->update('user_menu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert text-center">Success edit menu!</div>');
        redirect('admin/menu');
    }

    public function delete($id)
    {
        $where = array('id' => $id);
        $this->Menu_model->delete($where, 'user_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert text-center">Success delete menu!</div>');
        redirect('admin/menu');
    }

    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['subMenu'] = $this->Menu_model->getSubmenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template_auth/header', $data);
            $this->load->view('template_auth/topbar', $data);
            $this->load->view('template_auth/sidebar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template_auth/footer');
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">New sub menu added!</div>');
            redirect('admin/menu/submenu');
        }
    }

    public function subedit()
    {
        $id = $this->input->post('id');
        $menu_id = $this->input->post('menu_id');
        $title = $this->input->post('title');
        $url = $this->input->post('url');
        $icon = $this->input->post('icon');
        $is_active = $this->input->post('is_active');

        $data = array(
            'id' => $id,
            'menu_id' => $menu_id,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $is_active,
        );

        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert text-center">Success edit submenu!</div>');
        redirect('admin/menu/submenu');
    }

    public function subdelete($id)
    {
        $where = array('id' => $id);
        $this->Menu_model->delete($where, 'user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert text-center">Success delete submenu!</div>');
        redirect('admin/menu/submenu');
    }
}
