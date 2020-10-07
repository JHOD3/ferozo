<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="<?php if($this->session->userdata('idi_code')!='') echo $this->session->userdata('idi_code'); ?>"/> 
    <meta name="distribution" content="global"/> 
    <meta name="viewport"    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php if(isset($description)) echo $description; ?>">
    <meta name="Keywords" content="<?php if(isset($keywords)) echo $keywords; ?>" />
    <meta name="author"      content="Sistema">
    <meta name="msvalidate.01" content="EA13742EA5C0B975713761D0749A5F9F" />
    <meta property="og:site_name" content="Sistema">
    <?=(isset($meta_og_title))?'<meta property="og:title" content="'.$meta_og_title.'" />':''?>
    <?=(isset($meta_og_url))?'<meta property="og:url" content="'.$meta_og_url.'" />':''?>
    <?=(isset($meta_og_description))?'<meta property="og:description" content="'.$meta_og_description.'" />':''?>
    <?=(isset($meta_og_image))?'<meta property="og:image:secure_url" itemprop="image" content="'.$meta_og_image.'" />':''?>
    <?=(isset($meta_og_type))?'<meta property="og:type" content="'.$meta_og_type.'" />':''?>
    <?=(isset($meta_og_locale))?'<meta property="og:locale" content="'.$meta_og_locale.'" />':''?>
    <meta property="og:updated_time" content="<?=time()?>" />
    <title>Sistema<?php if(isset($title)) echo " - ".$title; ?></title>
    <link rel="shortcut icon" href="<?=base_url()?>images/Sistema.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url()?>images/Sistema-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url()?>images/Sistema-72x72.png">
    <link rel="apple-touch-icon-precomposed" href="<?=base_url()?>images/Sistema-54x54.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Icons -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css"/>
    <link href="<?=base_url()?>assets/css/icomoon.css" rel="stylesheet">
    <!-- Flags -->
    <link href="<?=base_url()?>assets/css/flag-icon.min.css" rel="stylesheet">
    <!-- Owl Carrusel  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.green.min.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700"> 
    <!-- Custom styles -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/styles.css">
    <?=($this->session->userdata('idi_code') == 'ar')?'<link href="'.base_url('assets/css/styles-rtl.css').'" rel="stylesheet" type="text/css">':''?>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/cs-select.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/cs-skin-elastic.min.css">
    <!-- Star rating -->
    <link href="<?=base_url()?>assets/css/star-rating.min.css" rel="stylesheet">
    <script>
        var SITE_URL = "<?=site_url()?>";
        var BASE_URL = "<?=base_url()?>";
    </script>
</head>
