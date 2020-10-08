<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('templates/head_front'); ?>
    <body>
        <?php $this->load->view('templates/analytics'); ?>
        <section class="header">    
            <?php $this->load->view('pages/header_inicio');?>
            <div class="" style="margin-bottom:0px;">
                <div class="container mx-md-3 mx-md-auto">
                    <div class="row px-md-4 pt-5">
                        <div class="col-md-6 col-lg-4 text-white">
                            <h1 class="text-left"><?=mostrar_palabra(482, $palabras)?></h1>
                            <p class="lead text-left">
                                <?=mostrar_palabra(493, $palabras)?>
                            </p>
                            <a href="#" class="btn btn-light"><?=mostrar_palabra(281, $palabras)?></a>
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <div class="owl-carousel owl-carousel-header owl-theme">
                                <div>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;">
                                        <img src="<?=base_url('assets/images/slides/laptop.svg')?>" alt="" class="img-responsive" title="<?=mostrar_palabra(119, $palabras)?>">
                                    </a>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;" class="img-home-youtube">
                                        <img src="<?=base_url('assets/images/slides/play-laptop.svg')?>" class="play-laptop" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;">
                                        <img src="<?=base_url('assets/images/slides/laptop.svg')?>" alt="" class="img-responsive" title="<?=mostrar_palabra(119, $palabras)?>">
                                    </a>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;" class="img-home-youtube">
                                        <img src="<?=base_url('assets/images/slides/play-laptop.svg')?>" class="play-laptop" alt="">
                                    </a>
                                </div>
                                <div>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;">
                                        <img src="<?=base_url('assets/images/slides/laptop.svg')?>" alt="" class="img-responsive" title="<?=mostrar_palabra(119, $palabras)?>">
                                    </a>
                                    <a href="javascript: mostrar_video();" style="cursor:pointer;" class="img-home-youtube">
                                        <img src="<?=base_url('assets/images/slides/play-laptop.svg')?>" class="play-laptop" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container py-5 d-md-flex d-block">
                <div class="col-md-5">
                    <embed src="<?=base_url('assets/images/world.svg')?>" class="img-world mx-auto" >
                </div>
                <div class="col-md-7 d-flex align-items-center">
                    <h5 class="text-interlineado text-color-muted text-md-left text-center">
                        <?=mostrar_palabra(1061, $palabras)?>
                    </h5>
                </div>
            </div>
        </section>
        <section class="background-section-3">
            <div class="container py-5 d-md-flex d-block">
                <div class="col-md-4 col-12">
                    <h3 class="text-white sub-title"><?=mostrar_palabra(646, $palabras)?></h3>
                    <h6 class="text-white text-center text-md-left">
                        <?=mostrar_palabra(1062, $palabras)?>
                    </h6>
                    <a href="" class="btn btn-light mt-3 mx-auto ml-md-0 d-block col-4"><?=mostrar_palabra(151, $palabras)?></a>
                </div>
                <div class="col-md-8 col-12 pt-md-0 pt-5">
                    <embed src="<?=base_url('assets/images/table-section-3.png')?>" class="img-table mx-auto d-block">
                </div>
            </div>
        </section>
        <section>
            <div class="container py-5 d-md-flex d-block">
                <div class="col-md-6 col-12 pt-md-0 pt-5">
                    <embed src="<?=base_url('assets/images/background-section-4.svg')?>" class="img-table">
                </div>
                <div class="col-md-6 col-12 padding-center-section-4">
                    <h3 class="text-danger sub-title"><?=mostrar_palabra(505, $palabras)?></h3>
                    <h4 class="text-muted text-center text-md-left">
                        <?=mostrar_palabra(506, $palabras)?>
                    </h4>
                    <a href="" class="btn btn-danger mt-4 mx-auto ml-md-0 d-block col-4"> <?=mostrar_palabra(151, $palabras)?></a>
                </div>
            </div>
        </section>
        <section class="bg-light pt-5">
            <h5 class="text-interlineado text-color-muted text-center">
                <?=mostrar_palabra(1063, $palabras)?>
            </h5>
            <div class="col-12 pb-5 owl-carousel owl-carousel-1 owl-theme">
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <embed src="<?=base_url('assets/images/iconos-web/destocado.svg')?>" class="position-absolute">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <embed src="<?=base_url('assets/images/iconos-web/destocado.svg')?>" class="position-absolute">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-0">
                    <div class="px-3">
                        <embed src="<?=base_url('assets/images/icono-bote.svg')?>" type="" class="icono-bote">
                        <div class="mt-1 line-height-0rem">
                            <p class="font10-px font-weight-bold text-dark mb-1">chapak1994@gmail.com </p>
                            <small class="font-weight-bold font8-px text-danger">Última vez 26/02/2018</small>
                        </div>
                        <div class="pl-1">
                            <p class="font10-px mb-0 mt-3 font-weight-500 text-dark line-height-1rem">15121910 - Aceite de girasol excluido en bruto</p>
                            <p class="font10-px font-weight-500 text-dark mb-2 line-height-1rem">Aceites de girasol o cártamo y sus fracciones, incl...</p>
                        </div>
                        <div class="">
                            <p class="font10-px font-weight-bold text-danger mb-2"><b>1512.19</b> - Código del producto (HS)</p>
                        </div>
                        <div class="d-flex">
                            <img src="<?=base_url('/assets/flags/4x3/us.svg')?>" class="bandera mr-2" type="">
                            <p class="font10-px font-weight-500 text-dark">Estados Unidos (Washington D.C./District of Columbia)</p>
                        </div>
                    </div>
                    <div class="border-top d-flex pt-1">
                        <div class="px-3 mt">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-e.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                        <div class="px-3 d-flex ml-auto">
                            <div class="d-flex">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-s.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-u.svg')?>" class="img-icono" alt="">
                            </div>
                            <div class="text-muted divisor">|</div>
                            <div class="d-flex ml-2">
                                <p class="mb-0">0</p>
                                <img src="<?=base_url('/assets/images/iconos-web/icono-g.svg')?>" class="img-icono" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="background-section-4 pb-2">
                <div class="text-center">
                    <h3 class="text-danger"><?=mostrar_palabra(1064, $palabras)?></h3>
                    <div class="text-muted">
                        <h4 class="mt-5">"I've never seen such an innovative tool."</h4>
                        <p class="font-weight-bold">Clayton F, Hyundai</p>
                        <h4 class="mt-5">
                            "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam <br class="d-md-block d-none">
                            nonummy nibh euismod tincidunt ut laoreet"
                        </h4>
                        <p class="font-weight-bold">Clayton F, Hyundai</p>
                    </div>
                    <div class="container pt-5">
                        <div class="owl-carousel owl-theme owl-carousel-2">
                            <div>
                                <embed src="<?=base_url('/assets/images/logo-1.svg')?>" class="logos-empresas" type="">
                            </div>
                            <div>
                                <embed src="<?=base_url('/assets/images/logo-2.svg')?>" class="logos-empresas-1" type="">
                            </div>
                            <div>
                                <embed src="<?=base_url('/assets/images/logo-3.svg')?>" class="logos-empresas" type="">
                            </div>
                            <div>
                                <embed src="<?=base_url('/assets/images/logo-4.svg')?>" class="logos-empresas" type="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="modal fade" id="modal_video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:-10px; right:-40px; color:#FFF; z-index:9999;"><i class="fa fa-2x fa-times"></i></button>
                    <div class="modal-body" style="background-color: #000;">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EOsf1f9b6xU?rel=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            $this->load->view('templates/menu_footer');
            $this->load->view('templates/footer_front');
            $this->load->view('pages/header_scripts');
        ?>

<script type="text/javascript">
   
    function mostrar_video()
    {
        $('#modal_video').modal('show');
        mostro_video = true;
    }


    var offset = 0;
    var limit = 5;
    var fin = false;
    var buscando = false;
    var ads_mostradas = 0;
    var ads_inter_cant = 0;
    var ads_inter = 4;
    var ads = null;

    function buscar()
    {
        $('#loading').show();

        $.ajax({
        url: SITE_URL+'pages/buscar_ultimos_ajax/'+offset+'/'+limit,
        dataType: 'json',
        timeout: 5000,
        success: function(data) {
            if(data.cant == -1)
            {
                fin = true;
                var htmlData = "";
                htmlData += "<?=mostrar_palabra(56, $palabras)?><br><br>";
                //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                htmlData += "<div style='clear:both; height:20px;'></div>";
                $('#results').append(htmlData);
                $('#area_primera_cargar').show();
                $('#modal_tutorial').modal('show');
            }
            else if(data.cant == -2)
            {
                fin = true;
                var htmlData = "";
                htmlData += "<?=mostrar_palabra(274, $palabras)?><br><br>";
                //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                htmlData += "<div style='clear:both; height:20px;'></div>";
                $('#header_resultados').show();
                $('#results').show();
                $('#results').append(htmlData);
            }
            else if(data.cant == 0)
            {
                fin = true;
                if(offset == 0)
                {
                    var htmlData = "";
                    htmlData += "<?=mostrar_palabra(56, $palabras)?><br><?=mostrar_palabra(243, $palabras)?><br>";
                    //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_DEMANDA?>'><img src='"+BASE_URL+"images/demanda.png' class='img-responsive'> <?=mostrar_palabra(24, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                    //htmlData += "<a class='col-xs-6 btn-nuevo-gigante' href='"+SITE_URL+"productos/nuevo/<?=TP_OFERTA?>'><img src='"+BASE_URL+"images/oferta.png' class='img-responsive'> <?=mostrar_palabra(23, $palabras)?> <i class='fa fa-plus fa-3x'></i></a>";
                    htmlData += "<div style='clear:both; height:20px;'></div>";
                    //$('#results').append(htmlData);
                    $('#area_botones_cargar').show();
                    $('#results').show();
                    $( "#area-mayor-actividad" ).appendTo( "#results" );
                }
            }
            else
            {
            if(data.ads)
            {
                ads = data.ads;
            }

            $('#header_resultados').show();
            $('#results').show();
            if(data.cant < limit)
            {
                fin = true;
            }
            offset += data.cant;

            var num_item = 0;

            $.each(data.result, function(i, item) {
                
                var htmlData = "";

                /***** ADS *****/
                
                if(ads && ads.length > 0 && i==0)
                {
                    ads_inter_cant=0;

                    htmlData += '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 panel resultado2" onclick="location.href=\''+SITE_URL+'ads_free/view/'+ads[ads_mostradas].ads_id+'\';" style="cursor:pointer;">';
                        htmlData += '<div class="panel-body" style="background:#F5F5F5; padding:0px;">';
                        htmlData += '<div class="media" id="prod_">';
                            if(ads[ads_mostradas].ads_imagen)
                            {
                            htmlData += '<div style="width:100%; height:160px; overflow:hidden;">';
                                htmlData += "<img src='"+BASE_URL+"images/ads/"+ads[ads_mostradas].ads_imagen+"' width='100%'>";
                            htmlData += '</div>';
                            }
                            htmlData += '<div class="media-body" style="padding:15px;">';
                            htmlData += '<b class="texto-bordo">'+ads[ads_mostradas].ads_titulo+'</b>';
                            htmlData += '<div class="cortar-texto-ads" style="margin-top:5px;">'+ads[ads_mostradas].ads_texto_corto+'</div>';
                            htmlData += '</div>';
                        htmlData += '</div>';
                        htmlData += '</div>';
                        htmlData += '<div class="panel-footer" style="text-align:center; background:#999999; color:#FFF;">';
                        htmlData += "<span style='display:block; padding: 3px 0;'>ADVERTISMENT</span>";
                        htmlData += '</div>';
                    htmlData += '</div>';

                    post_impresion(ads[ads_mostradas].ads_id);

                    ads_mostradas++;
                    num_item++;
                }

                ads_inter_cant++;
                /***************/

                var color_visto = "visto";
                if(item.mis_visitas == 0)
                {
                    color_visto = "no-visto";
                }

                var premium = "";
                var media_right = '';
                if(item.tu_id == <?=TU_PREMIUM?>)
                {
                    premium = "premium";
                    media_right = '<img src="<?=base_url('assets/images/esquina-premium.png')?>">';
                    if("<?=$this->session->userdata('idi_code')?>" == "ar")
                    {
                        media_right = '<img src="<?=base_url('assets/images/esquina-premium-rtl.png')?>">';
                    }
                }
                
                htmlData += '<div class="col-xs-12 col-sm-6 col-md-3 col-lg-2 panel resultado2 '+premium+'">';
                htmlData += '<div class="panel-body '+color_visto+'">';

                    htmlData += '<div class="menu-tarjeta">';
                    htmlData += media_right;
                    htmlData += '</div>';

                htmlData += '<div class="media" id="prod_'+item.prod_id+'">';

                    htmlData += '<div class="">';

                    var background = "";
                    var clase = "sin_imagen";
                    if(item.prod_imagen)
                    {
                        background = "background:url("+BASE_URL+"images/productos/"+item.prod_imagen+"); background-size:cover;";
                        clase = "con_imagen";
                    }

                    htmlData += "<div class='media-object img-rounded "+clase+"' style='"+background+"'>";

                    if(item.usr_imagen)
                    {
                    htmlData += "<img class='img-circle' src='"+BASE_URL+"images/usuarios/"+item.usr_imagen+"'>";
                    }
                    else
                    {
                    htmlData += "<img class='img-circle' src='"+BASE_URL+"images/usuarios/perfil.jpg'>";
                    }

                    if(item.tp_id == <?=TP_OFERTA?>)
                    {
                        htmlData += "<img class='media-tipo' src='"+BASE_URL+"images/oferta.png'>";
                    }
                    else
                    {
                        htmlData += "<img class='media-tipo' src='"+BASE_URL+"images/demanda.png'>";
                    }

                    htmlData += "</div>";

                    htmlData += '</div>';
                    htmlData += '<div class="media-body">';
                    if(item.tp_id == <?=TP_OFERTA?>)
                    {
                        htmlData += '<b class="cortar-texto-mail"><?=mostrar_palabra(19, $palabras)?></b>';
                    }
                    else
                    {
                        htmlData += '<b class="cortar-texto-mail"><?=mostrar_palabra(20, $palabras)?></b>';
                    }
                    htmlData += '<b class="fecha">'+item.usr_ult_acceso+'</b>';
                    htmlData += '<div class="cortar-texto-productos2" style="margin-top:5px;">'+item.prod_descripcion+'</div>';
                    htmlData += '<div class="cortar-texto-productos2" style="margin:5px 0px;">'+item.ara_desc+'</div>';
                    htmlData += '<small>';
                        if(item.sec_id == 22)
                        {
                        htmlData += '<b class="cortar-texto-mail texto-bordo">'+item.ara_code+' - <?=mostrar_palabra(21, $palabras)?></b>';
                        }
                        else
                        {
                        htmlData += '<b class="cortar-texto-mail texto-bordo">'+item.ara_code+' - <?=mostrar_palabra(22, $palabras)?></b>';
                        }
                        htmlData += "<span class='cortar-texto-mail'><img src='"+BASE_URL+"images/banderas/"+item.ctry_code+".png'> "+item.ctry_nombre;
                        htmlData += " (";
                        if(item.city_nombre == item.toponymName)
                        {
                            htmlData += item.city_nombre;
                        }
                        else
                        {
                            htmlData += item.city_nombre+" / "+item.toponymName;
                        }
                        htmlData += ")</span>";
                    htmlData += '</small>';
                    htmlData += '</div>';

                htmlData += '</div>';
                htmlData += '</div>';
                htmlData += '<div class="panel-footer">';
                    htmlData += '<div class="col-xs-6 text-left flip">';
                    var color_aux = "";
                    if(item.visitas > 0)
                    {
                        color_aux = "color:#980521;";
                    }
                    htmlData += "<span style='"+color_aux+"'>"+item.visitas+"</span> <i class='fa fa-eye fa-lg' style='"+color_aux+"'></i>";
                    htmlData += "<span style='color:#B2B2B2'> | </span>";
                    color_aux = "";
                    if(item.referencias > 0)
                    {
                        color_aux = "color:#980521;";
                    }
                    htmlData += "<span style='"+color_aux+"'>"+item.referencias+"</span> <i class='icon-relacion' style='font-size:18px; "+color_aux+"'></i>";
                    htmlData += '</div>';
                    htmlData += '<div class="col-xs-6 text-right flip" id="area_puntaje_'+item.prod_id+'">';
                    if(item.puntaje == null)
                    {
                        item.puntaje = 0;
                    }

                    htmlData += "<div class='derecha' style='cursor:default;'>";
                        color_aux = "";
                        if(item.puntaje > 0)
                        {
                        color_aux = "color:#980521;";
                        }

                        htmlData += "<span style='"+color_aux+"'>"+item.puntaje+"</span> <i class='fas fa-star fa-lg' style='"+color_aux+"'></i>";
                        htmlData += "<span style='color:#B2B2B2'> / </span>";
                        htmlData += "<span style='"+color_aux+"'>"+item.cant_seguidores+"</span> <i class='fa fa-user fa-lg' style='"+color_aux+"'></i>";
                        
                    htmlData += '</div>';
                    htmlData += '</div>';
                    htmlData += '<div style="clear:both"></div>';
                htmlData += '</div>';
                htmlData += '</div>';
                $("#results").append(htmlData);
            });
            
            }
            $('#loading').hide();
            buscando = false;
        },
        error: function(x, status, error){
            $('#loading').hide();
            var htmlData = '<div class="alert with-icon alert-danger" role="alert"><i class="icon fa fa-exclamation-triangle"></i> ';
            htmlData += "An error occurred: " + status + " nError: " + error;
            htmlData += '</div>';
            $("#results").append(htmlData);
        }
        });

    }

    buscar();
</script>

</body>
</html>