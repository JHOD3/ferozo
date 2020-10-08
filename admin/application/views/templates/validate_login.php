<?php
if($this->session->userdata('admin_id') == "")
{
    redirect('login/index', 'refresh');
    exit();
}
?>