<?php
return $_ = 
[
    "template_parts" =>
    [

        "blocks"=> [
            "nav"    => TEMPLATE_PATH."nav.php",
            "breadcrumb"    => TEMPLATE_PATH."breadcrumb.php",
            "spinner"    => TEMPLATE_PATH."spinner.php",
            "wraperstart" => TEMPLATE_PATH."wraperstart.php",
            ":view"       =>  "here require view",
            "wraperend" =>  TEMPLATE_PATH."wraperend.php",
            "activatenodel" =>  TEMPLATE_PATH."activatenodel.php",
            "footer"    => TEMPLATE_PATH."footer.php"
        ],
        "header_links" =>
        [
        "css" => [
            '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">',
            '<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">',
            "<link rel='stylesheet' href='".toCss("all.min.css")."' >",
            "<link rel='stylesheet' href='". toCss("style.css?22")."' >",
        ],
        "js" =>[]
        ]
        
        ,
        "footer_links" =>
        [
            "js" =>
            [
                "<script src='". toJs("jquery.js")."'></script>",
                '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>',
                '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>',
                '<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>',
                "<script src='". toJs("all.min.js")."'></script>",
                "<script src='". toJs("main.js?114")."' type='module'></script>",
            ]
        ]
        
    ]
];