<?php 
if(!function_exists('generatedBreadcrumb')){
    function generateBreadcrumb(){
        $ci=&get_instance();
        $i=1;
        $uri = $ci->uri->segment($i);
        $link='
        <div class="page-header-breadcrumb" id="breadcrumbs">
        <ul class="breadcrumb-title"><li class="breadcrumb-item"><a href="'.$ci->baseUrl.'"><i class="feather icon-home"></i></a></li>';

        while($uri != ''){
            $prep_link = '';
            for($j=1; $j<=$i; $j++){
                $prep_link.=$ci->uri->segment($j).'/';
            }

            if($ci->uri->segment($i+1)== ''){
                $link.='<li class="breadcrumb-item active">';
                $link.=str_replace('_', ' ', ucfirst($ci->uri->segment($i))).'</li>';
            }else{
                $link.='<li class="breadcrumb-item"><a href="'.site_url($prep_link).'">';
                $link.=str_replace('_',' ', ucfirst($ci->uri->segment($i))).'</a></li>';
            }

            $i++;
            $uri = $ci->uri->segment($i);
        }
        $link .='</ul></div>';
        return $link;
    }
}