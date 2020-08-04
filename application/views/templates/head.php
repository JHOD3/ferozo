<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="<?php if($this->session->userdata('idi_code')!='') echo $this->session->userdata('idi_code'); ?>"/> 
    <meta name="distribution" content="global"/> 
    <meta name="viewport"    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php if(isset($description)) echo $description; ?>">
    <meta name="Keywords" content="<?php if(isset($keywords)) echo $keywords; ?>" />
    <meta name="author"      content="Sistema">
    <meta name="msvalidate.01" content="EA13742EA5C0B975713761D0749A5F9F" />
    
    <title>Sistema<?php if(isset($title)) echo " - ".$title; ?></title>

    <link rel="shortcut icon" href="<?=base_url()?>images/Sistema.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url()?>images/Sistema-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=base_url()?>images/Sistema-72x72.png">
    <link rel="apple-touch-icon-precomposed" href="<?=base_url()?>images/Sistema-54x54.png">

    <!--[if lt IE 9]> <script src="<?=base_url()?>assets/js/html5shiv.js"></script> <![endif]-->
    <script>
        var SITE_URL = "<?=site_url()?>";
        var BASE_URL = "<?=base_url()?>";
    </script>

    <script type="text/javascript">
        /*
        window.smartlook||(function(d) {
        var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
        var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
        c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
        })(document);
        smartlook('init', '109f3728eb2511757cf09097b4ca25989eb4c009');
        */
    </script>

    <?php
    /*
    if($this->router->fetch_class() == "resultados" && $this->router->fetch_method() == "view")
    {
        echo '<title>your keyword rich title of the website and/or webpage</title>';
    }
    */
    echo '<meta property="og:site_name" content="Sistema">';
    if(isset($meta_og_title))
    {
        echo '<meta property="og:title" content="'.$meta_og_title.'" />';
    }
    if(isset($meta_og_url))
    {
        echo '<meta property="og:url" content="'.$meta_og_url.'" />';
    }
    if(isset($meta_og_description))
    {
        echo '<meta property="og:description" content="'.$meta_og_description.'" />';
    }
    if(isset($meta_og_image))
    {
        echo '<meta property="og:image:secure_url" itemprop="image" content="'.$meta_og_image.'" />';
    }
    if(isset($meta_og_type))
    {
        echo '<meta property="og:type" content="'.$meta_og_type.'" />';
    }
    if(isset($meta_og_locale))
    {
        echo '<meta property="og:locale" content="'.$meta_og_locale.'" />';
    }
    echo '<meta property="og:updated_time" content="'.time().'" />';
    ?>
</head>