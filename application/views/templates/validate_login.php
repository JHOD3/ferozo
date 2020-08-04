<?php
if($this->session->userdata('usr_id') == "")
{
    redirect('pages/index', 'refresh');
    exit();
}

if($this->session->userdata('usr_pais') == "" && $this->router->fetch_class() != "user")
{
    redirect('user/pais', 'refresh');
    exit();
}
?>