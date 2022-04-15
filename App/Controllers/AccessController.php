<?php
namespace App\Controllers;


use App\Lib\redirect;
use App\Lib\response;
class AccessController extends AbstractController 
{
    use response;
    public function default()
    {
        $this->lang->laod("access/accessdefault")->laod("common");
        $this->template->addCss(toCss("access/access.css?121"));
        $this->template->addExclude(["breadcrumb"]);
        $this->_view();
    }

}