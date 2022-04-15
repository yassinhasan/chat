<?php
namespace App\Controllers;
class NotFoundController extends AbstractController 
{
    public function notfound()
    {
        $this->lang->laod("notFound/notFoundnotfound")->laod("common");
        $this->template->addCss(toCss("notfound/notfound.css?121"));
        $this->_view();
    }
}