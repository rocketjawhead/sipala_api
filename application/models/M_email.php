<?php if(!defined('BASEPATH')) exit('No direct script allowed');
use \Firebase\JWT\JWT;
class M_email extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->model('M_base','base');
        $this->load->model('M_main','main');
        $this->poin_register = $this->config->item('poin_register');
        $this->base_url_web = $this->config->item('base_url_web');
    }


    public function upload_receipt(){
        $data = array(
            'trx_id' => $this->input->post('trx_id'),
            'type_upload' => $this->input->post('type_upload'),
            'base64image' => $this->input->post('base64image'),
            'secretkey' => $this->secretkey
        );
        $url = 'api/transaction/uploadreceipt/';
        $exec = $this->base->post_curl_token($url,$data);
        echo json_encode($exec);
    }


    public function email_verify($code){

        // $unique_id = '12312321';
        $url_confirm = $this->base_url_web.'auth/verifyuser/'.md5($code);
        $html = '<!DOCTYPE html>
                <html>

                <head>
                    <title></title>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <link rel="stylesheet" href="https://jajanpulsa.id/assets/assets/css/style_email.css">
                    <style type="text/css">
                        
                    </style>
                </head>

                <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
                    <!-- HIDDEN PREHEADER TEXT -->
                    
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- LOGO -->
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">JAJANPULSA.ID</h1><h3>Selamat Datang</h3> <img src="https://jajanpulsa.id/assets/img/Logo.png" style="display: block; border: 0px;" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Kami sangat senang Anda bergabung dengan <b>JAJANPULSA.ID</b><br/> Pertama, Anda perlu mengkonfirmasi akun Anda. Cukup tekan tombol di bawah ini. </p>
                                            <br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" align="left">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" style="border-radius: 3px;" bgcolor="#FF6363"><a href='.$url_confirm.' target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FF6363; display: inline-block;">Konfirmasi Akun</a></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> <!-- COPY -->
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Jika itu tidak berhasil, salin dan tempel tautan berikut di browser Anda: <br/> 
                                            <a href="'.$url_confirm.'" target="_blank" style="color: #FF6363;">'.$url_confirm.'</a>
                                            <br/><br/>
                                            Atau Anda dapat menghubungi Live Chat didalam halaman JAJANPULSA.ID<br><br>
                                            Cheers,<br><b>JAJANPULSA.ID Team
                                            </p>
                                        </td>
                                    </tr> <!-- COPY -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>

                </html>';
        return $html;
    }

    public function email_otp($code){

        $html = '<!DOCTYPE html>
                <html>

                <head>
                    <title></title>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <link rel="stylesheet" href="https://jajanpulsa.id/assets/assets/css/style_email.css">
                    <style type="text/css">
                        
                    </style>
                </head>

                <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
                    <!-- HIDDEN PREHEADER TEXT -->
                    
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- LOGO -->
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">JAJANPULSA.ID</h1><h3>Selamat Datang</h3> <img src="https://jajanpulsa.id/assets/img/Logo.png" style="display: block; border: 0px;" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Berikut adalah Kode OTP, Mohon dapat menjaga rahasia Kode OTP dan tidak untuk dibagikan selain Anda sendiri.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" align="left">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <h1>'.$code.'</h1>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> <!-- COPY -->
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Jika Anda memiliki kendala, Anda dapat menghubungi Live Chat didalam halaman JAJANPULSA.ID<br><br>
                                            Cheers,<br><b>JAJANPULSA.ID Team
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>

                </html>';
        return $html;
    }

    public function email_reset_password($code){

        $url_confirm = $this->base_url_web.'auth/resetpassword/'.md5($code);
        $html = '<!DOCTYPE html>
                <html>

                <head>
                    <title></title>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <link rel="stylesheet" href="https://jajanpulsa.id/assets/assets/css/style_email.css">
                    <style type="text/css">
                        
                    </style>
                </head>

                <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
                    <!-- HIDDEN PREHEADER TEXT -->
                    
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- LOGO -->
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">JAJANPULSA.ID</h1><h3>Reset Password</h3> <img src="https://jajanpulsa.id/assets/img/Logo.png" style="display: block; border: 0px;" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Silahkan tekan tombol di bawah ini untuk melakukan pengauturan ulang Kata Sandi baru, Perlu diperhatikan kerahasiaan Kata Sandi baru.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" align="left">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" style="border-radius: 3px;" bgcolor="#FF6363"><a href="'.$url_confirm.'" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FF6363; display: inline-block;">Set Ulang Password</a></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> <!-- COPY -->
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Jika itu tidak berhasil, salin dan tempel tautan berikut di browser Anda: <br/>
                                            <a href="'.$url_confirm.'" target="_blank" style="color: #FF6363;">'.$url_confirm.'</a>
                                            <br/>
                                            Jika Anda memiliki kendala, Anda dapat menghubungi Live Chat didalam halaman website
                                            <br/>
                                            Cheers,<br><b>JAJANPULSA.ID Team</b> 
                                            </p>
                                        </td>
                                    </tr> <!-- COPY -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>

                </html>';
        return $html;
    }

    public function email_reset_pin($code){

        $url_confirm = $this->base_url_web.'auth/resetpin/'.md5($code);
        $html = '<!DOCTYPE html>
                <html>

                <head>
                    <title></title>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <link rel="stylesheet" href="https://jajanpulsa.id/assets/assets/css/style_email.css">
                    <style type="text/css">
                        
                    </style>
                </head>

                <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
                    <!-- HIDDEN PREHEADER TEXT -->
                    
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <!-- LOGO -->
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">JAJANPULSA.ID</h1><h3>Reset PIN</h3> <img src="https://jajanpulsa.id/assets/img/Logo.png" style="display: block; border: 0px;" />
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center" style="padding: 0px 10px 0px 10px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Silahkan tekan tombol di bawah ini untuk melakukan pengauturan ulang PIN baru, Perlu diperhatikan kerahasiaan PIN baru.</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#ffffff" align="left">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                                        <table border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" style="border-radius: 3px;" bgcolor="#FF6363"><a href="'.$url_confirm.'" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FF6363; display: inline-block;">Set Ulang PIN</a></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr> <!-- COPY -->
                                    <tr>
                                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                            <p style="margin: 50px;">Jika itu tidak berhasil, salin dan tempel tautan berikut di browser Anda: <br/>
                                            <a href="'.$url_confirm.'" target="_blank" style="color: #FF6363;">'.$url_confirm.'</a>
                                            <br/>
                                            Jika Anda memiliki kendala, Anda dapat menghubungi Live Chat didalam halaman website
                                            <br/>
                                            Cheers,<br><b>JAJANPULSA.ID Team</b> 
                                            </p>
                                        </td>
                                    </tr> <!-- COPY -->
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#E8E8E8" align="center">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                                    <tr>
                                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>

                </html>';
        return $html;
    }


    
}