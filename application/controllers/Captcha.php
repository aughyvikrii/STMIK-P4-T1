<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

    public function __construct() {
        // load parent construct
        parent::__construct();
        
        //load file helper
        $this->load->helper('captcha');

        //helper form dan url di load di autoload
    }

	public function index() {
        // data yang akan dibawa ke views
        $data = array();

        $captcha = $this->get_captcha();

        if( $this->input->post("submit") ) {
            $this->form_validation->set_rules("captcha","Captcha","required");

            if( $this->form_validation->run() == true ) {

                $post_captcha = $this->input->post("captcha");

                $session_captcha = $this->session->captcha;

                if( $post_captcha == $session_captcha['word'] ) {
                    $data['success_msg'] = 'Captcha solved! text: '.$post_captcha;

                    set_value("captcha","");

                    // Hapus gambar yang sudah valid
                    @unlink(FCPATH.'assets/captcha/'.$captcha['filename']);

                    // Generate captcha baru
                    $this->session->captcha = false;
                    $captcha = $this->get_captcha();

                } else {
                    $data['error_msg'] = 'Wrong input captcha';
                }
            }
        } else if ( $this->input->post("new_captcha") ) {
            // Hapus gambar yang sudah valid
            @unlink(FCPATH.'assets/captcha/'.$captcha['filename']);

            // Generate captcha baru
            $this->session->captcha = false;
            $captcha = $this->get_captcha();
        }

        $data["captcha"] = $captcha;

		$this->load->view('captcha.php',$data);
    }

    public function get_captcha(){

        if( $this->session->captcha == false ) {

            $vals = array(
                'word'          => $this->randomString(6),
                'img_path'      => FCPATH.'assets/captcha/',
                'img_url'       => base_url('assets/captcha/'),
                'img_width'     => '100',
                'img_height'    => 30,
                'expiration'    => 7200,
                'word_length'   => 10,
                'font_size'     => 50,
                'img_id'        => 'Imageid',
                'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',//ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        
                // White background and border, black text and red grid
                'colors'        => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(255, 40, 40)
                )
            );
            
            $captcha = create_captcha($vals);

            $this->session->captcha = $captcha;
        } else {
            $captcha = $this->session->captcha;
        }

        return $captcha;
    }

    public function randomString($length = 32){
		$string = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($string);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $string[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
