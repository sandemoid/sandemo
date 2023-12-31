<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model');
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'My Profile';
            $this->load->view('template_auth/header', $data);
            $this->load->view('template_auth/topbar', $data);
            $this->load->view('template_auth/sidebar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('template_auth/footer');
        } else {

            $id = $this->input->post('id');
            $data = [
                'name' => $this->input->post('name', true),
                'nohp' => $this->input->post('nohp', true),
                'maps' => $this->input->post('maps', true)
            ];

            //cek jika ada gambar di upload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $user = $this->db->get_where('user', ['id' => $id])->row_array();
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = '2048';
                $config['upload_path']   = './assets/img/profile/';
                $config['file_name']     = 'profile' . time();

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $user['image'];
                    if ($old_image != 'default.jpg') {
                        unlink('./assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $where = array(
                'id' => $id
            );

            // jika validasi lolos
            $this->User_model->update_user($where, $data, 'user');
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Success edit your profile!</div>');
            redirect('admin/user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[4]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[4]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template_auth/header', $data);
            $this->load->view('template_auth/topbar', $data);
            $this->load->view('template_auth/sidebar', $data);
            $this->load->view('user/index', $data);
            $this->load->view('template_auth/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('admin/user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">New password cannot be the same as current password!</div>');
                    redirect('admin/user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Success change password!</div>');
                    redirect('admin/user/changepassword');
                }
            }
        }
    }

    public function socialmedia()
    {
        $id = $this->input->post('id');
        $data = [
            'facebook' => $this->input->post('facebook', true),
            'youtube' => $this->input->post('youtube', true),
            'instagram' => $this->input->post('instagram', true)
        ];

        $where = array(
            'id' => $id
        );

        // jika validasi lolos
        $this->User_model->update_user($where, $data, 'user');
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Success edit your social media!</div>');
        redirect('admin/user');
    }
}
