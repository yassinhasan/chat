<?php
namespace App\Controllers;

use App\Lib\redirect;
use App\Lib\response;

class ChangelangController extends AbstractController
{
    use redirect;
    use response;
    public function default()
    {
        if( $this->session->default_lang)
        {
            if( $this->session->default_lang == 'en')
            {
                
                 $this->session->default_lang = 'ar';
            }else
            {
                 $this->session->default_lang= 'en';
            }
          
        }

     $this->redirect($_SERVER["HTTP_REFERER"]);
    }
}