<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Page_model');
        $this->load->model('Setting_model');
    }

    public function index()
    {
        $data['blog'] = $this->Page_model->get_blog(5, 0)->result_array();
        $data['home'] = $this->Setting_model->get_setting();
        $data['setting'] = $this->Setting_model->get_setting();

        $data['title'] = 'Blog';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/page_header');
        $this->load->view('frontend/blog', $data);
        $this->load->view('template/footer');
    }

    public function read($category, $slug)
    {
        $category_id = $this->db->where('kategori', $category)->get('kategori_blog')->row_array()['id'];
        $data['home'] = $this->Setting_model->get_setting();
        $data['setting'] = $this->Setting_model->get_setting();
        $data['seo'] = $this->db
            ->where('id_kategori', $category_id)
            ->where('slug', $slug)
            ->get('blog')->row_array();

        $data['title'] = $data['seo']['title'];
        $data['category'] = $this->db->get('kategori_blog')->result_array();
        $data['recent'] =  $this->Page_model->get_blog_recent(6, 0)->result_array();

        $data['next_post'] = $this->db
            ->where('blog.id<', $data['seo']['id'])
            ->join('kategori_blog', 'kategori_blog.id=blog.id_kategori', 'left')
            ->order_by('blog.id', 'desc')
            ->get('blog')->row_array();

        $data['previus_post'] = $this->db
            ->join('kategori_blog', 'kategori_blog.id=blog.id_kategori', 'left')
            ->where('blog.id>', $data['seo']['id'])
            ->get('blog')->row_array();

        $this->load->view('template/header_blog', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/page_header');
        $this->load->view('frontend/blog-detail', $data);
        $this->load->view('template/footer');
    }

    public function sharePost($category, $slug)
    {
        $socialMedia = $this->input->get('social_media');

        $validSocialMedia = ['facebook', 'twitter', 'whatsapp'];
        if (!in_array($socialMedia, $validSocialMedia)) {
            redirect('blog/read' . $category, $slug);
            return;
        }

        switch ($socialMedia) {
            case 'facebook':
                $facebookAppId = '769512741585393'; // Replace with your Facebook App ID
                $shareUrl = 'https://www.facebook.com/dialog/share?app_id=' . $facebookAppId . '&display=popup&href=' . urlencode(base_url(uri_string()));
                break;
            case 'twitter':
                $shareUrl = 'https://twitter.com/intent/tweet?url=' . urlencode(base_url(uri_string()));
                break;
            case 'whatsapp':
                $shareUrl = 'whatsapp://send?text=' . urlencode(base_url(uri_string()));
                break;
        }

        redirect($shareUrl);
    }
}