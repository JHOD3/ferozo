<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('templates/head_front'); ?>
    <body>
        <?php $this->load->view('templates/analytics'); ?>
        <section class="navbar-default header pb-0">    
            <?php $this->load->view('pages/header_pages');?>
        </section>
        
        <section class="pt-4">
            <div class="text-center py-5">
                <h3 class="text-danger">CONOCÉ NUESTRA NUEVA HERRAMIENTA</h3>
                <h5 class="text-muted">
                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <br class="d-none d-md-block"> 
                    euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
                </h5>
            </div>
        </section>

        <div class="linea-background-conocenos">
            <section>
                <div class="row container mx-auto">
                    <div class="col-md-6 align-items-center d-flex">
                        <div class="row">
                            <div class="col-md-4">
                                <embed src="<?=base_url()?>assets/images/file.svg" type="">
                            </div>
                            <div class="col-md-8 pt-md-5 pr-md-5">
                                <h5 class="text-muted">Lorem ipsum dolor</h5>
                                <h6 class="text-muted">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <br class="d-none d-md-block"> 
                                    euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="<?=base_url()?>assets/images/table-conocenos.png" alt="" class="img-table-conocenos">
                    </div>
                </div>
            </section>
            <section class="pt-md-5">
                <div class="row container mx-auto">
                    <div class="col-md-6">
                        <img src="<?=base_url()?>assets/images/table-conocenos.png" alt="" class="img-table-conocenos">
                    </div>
                    <div class="col-md-6 align-items-center d-flex">
                        <div class="row">
                            <div class="col-md-4">
                                <embed src="<?=base_url()?>assets/images/file.svg" type="">
                            </div>
                            <div class="col-md-8 pt-md-5 pr-md-5">
                                <h5 class="text-muted">Lorem ipsum dolor</h5>
                                <h6 class="text-muted">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <br class="d-none d-md-block"> 
                                    euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="pt-md-5 pb-5">
                <div class="row container mx-auto">
                    <div class="col-md-6 align-items-center d-flex">
                        <div class="row">
                            <div class="col-md-4">
                                <embed src="<?=base_url()?>assets/images/file.svg" type="">
                            </div>
                            <div class="col-md-8 pt-md-5 pr-md-5">
                                <h5 class="text-muted">Lorem ipsum dolor</h5>
                                <h6 class="text-muted">
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh <br class="d-none d-md-block"> 
                                    euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. 
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <img src="<?=base_url()?>assets/images/table-conocenos.png" alt="" class="img-table-conocenos">
                    </div>
                </div>
            </section>

            <section class="py-md-5 my-4">
                <div class="text-center py-5">
                    <h3 class="text-danger">LOREM IPSUM DOLOR <br class="d-block d-md-none">   SIT AMETs</h3>
                </div>
                <div class="container row mx-auto">
                    <div class="col-md-3">
                        <embed src="<?=base_url()?>assets/images/imagen-icono-1.svg" class="mx-auto d-block" type="">
                        <div class="text-center">
                            <h5 class="text-muted mt-3">VOLUTPAT</h5>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing 
                                elit, sed diam nonummy nibh euismod tincidunt ut laoreet 
                                dolore magna aliquam erat volutpat des. 
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <embed src="<?=base_url()?>assets/images/imagen-icono-2.svg" class="mx-auto d-block" type="">
                        <div class="text-center">
                            <h5 class="text-muted mt-3">VOLUTPAT</h5>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing 
                                elit, sed diam nonummy nibh euismod tincidunt ut laoreet 
                                dolore magna aliquam erat volutpat des. 
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <embed src="<?=base_url()?>assets/images/imagen-icono-3.svg" class="mx-auto d-block" type="">
                        <div class="text-center">
                            <h5 class="text-muted mt-3">VOLUTPAT</h5>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing 
                                elit, sed diam nonummy nibh euismod tincidunt ut laoreet 
                                dolore magna aliquam erat volutpat des. 
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <embed src="<?=base_url()?>assets/images/imagen-icono-4.svg" class="mx-auto d-block" type="">
                        <div class="text-center">
                            <h5 class="text-muted mt-3">VOLUTPAT</h5>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing 
                                elit, sed diam nonummy nibh euismod tincidunt ut laoreet 
                                dolore magna aliquam erat volutpat des. 
                            </p>
                        </div>
                    </div>
                </div>
                <button class="btn btn-color-secundary mt-5 mx-auto d-block">CONTRATAR</button>
            </section>
        </div>
        <?php
            $this->load->view('templates/menu_footer');
            $this->load->view('templates/footer_front');
            $this->load->view('pages/header_scripts');
        ?>
</body>
</html>