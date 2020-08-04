
CREATE TABLE `accesos` (
  `acc_id` int(11) UNSIGNED NOT NULL,
  `acc_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_plataforma` varchar(50) DEFAULT NULL,
  `acc_navegador` varchar(50) DEFAULT NULL,
  `acc_mobile` varchar(50) DEFAULT NULL,
  `acc_robot` varchar(50) DEFAULT NULL,
  `acc_referred` varchar(200) DEFAULT NULL,
  `acc_ip` varchar(20) DEFAULT NULL,
  `acc_pais` varchar(50) DEFAULT NULL,
  `acc_ciudad` varchar(50) DEFAULT NULL,
  `acc_region` varchar(50) DEFAULT NULL,
  `acc_lat` double DEFAULT NULL,
  `acc_lng` double DEFAULT NULL,
  `acc_session` varchar(20) DEFAULT NULL,
  `acc_extra` varchar(100) DEFAULT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `administradores`
--

CREATE TABLE `administradores` (
  `admin_id` int(11) UNSIGNED NOT NULL,
  `admin_nombre` varchar(50) NOT NULL,
  `admin_apellido` varchar(50) NOT NULL,
  `admin_usuario` varchar(50) NOT NULL,
  `admin_mail` varchar(50) NOT NULL,
  `admin_clave` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ads_id` int(11) UNSIGNED NOT NULL,
  `ads_tipo_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `ads_nombre` varchar(100) NOT NULL,
  `ads_titulo` varchar(100) NOT NULL,
  `ads_texto` text NOT NULL,
  `ads_texto_corto` text NOT NULL,
  `ads_imagen` varchar(100) NOT NULL,
  `ads_link` varchar(100) NOT NULL,
  `ads_estado` int(1) UNSIGNED NOT NULL DEFAULT '1',
  `ads_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ads_oferta` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ads_demanda` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ads_forms` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ads_forms_mail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_aranceles`
--

CREATE TABLE `ads_aranceles` (
  `ads_ara_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `ara_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_bloqueos`
--

CREATE TABLE `ads_bloqueos` (
  `ads_blo_id` int(11) UNSIGNED NOT NULL,
  `ads_blo_usr_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_click`
--

CREATE TABLE `ads_click` (
  `ads_click_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `ads_click_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ads_click_importe` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ads_countrys`
--

CREATE TABLE `ads_countrys` (
  `ads_ctry_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `ctry_code` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_forms`
--

CREATE TABLE `ads_forms` (
  `ads_form_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `ads_form_nombre` varchar(100) NOT NULL,
  `ads_form_mail` varchar(100) NOT NULL,
  `ads_form_telefono` varchar(100) NOT NULL,
  `ads_form_consulta` text NOT NULL,
  `ads_form_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ads_form_importe` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_imagenes`
--

CREATE TABLE `ads_imagenes` (
  `ads_img_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `ads_img_ruta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_importes`
--

CREATE TABLE `ads_importes` (
  `ads_imp_id` int(11) UNSIGNED NOT NULL,
  `ads_imp_nombre` varchar(50) NOT NULL,
  `ads_imp_valor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ads_impresion`
--

CREATE TABLE `ads_impresion` (
  `ads_imp_id` int(11) UNSIGNED NOT NULL,
  `ads_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `ads_imp_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ads_imp_importe` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ads_tipos`
--

CREATE TABLE `ads_tipos` (
  `ads_tipo_id` int(11) UNSIGNED NOT NULL,
  `ads_tipo_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Aranceles`
--

CREATE TABLE `Aranceles` (
  `ara_id` int(7) NOT NULL,
  `ara_code` varchar(7) NOT NULL,
  `cat_id` int(3) NOT NULL,
  `ara_desc_zh` varchar(1300) NOT NULL,
  `ara_desc_es` varchar(1300) NOT NULL,
  `ara_desc_en` varchar(1300) NOT NULL,
  `ara_desc_hi` varchar(1300) NOT NULL,
  `ara_desc_ar` varchar(1300) NOT NULL,
  `ara_desc_pt` varchar(1300) NOT NULL,
  `ara_desc_ru` varchar(1300) NOT NULL,
  `ara_desc_ja` varchar(1300) NOT NULL,
  `ara_desc_de` varchar(1300) NOT NULL,
  `ara_desc_fr` varchar(1300) NOT NULL,
  `ara_desc_ko` varchar(1300) NOT NULL,
  `ara_desc_it` varchar(1300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Categorias`
--

CREATE TABLE `Categorias` (
  `cat_id` int(3) NOT NULL,
  `cat_code` varchar(3) NOT NULL,
  `sec_id` int(3) NOT NULL,
  `cat_desc_zh` varchar(350) NOT NULL,
  `cat_desc_es` varchar(350) NOT NULL,
  `cat_desc_en` varchar(350) NOT NULL,
  `cat_desc_hi` varchar(350) NOT NULL,
  `cat_desc_ar` varchar(350) NOT NULL,
  `cat_desc_pt` varchar(350) NOT NULL,
  `cat_desc_ru` varchar(350) NOT NULL,
  `cat_desc_ja` varchar(350) NOT NULL,
  `cat_desc_de` varchar(350) NOT NULL,
  `cat_desc_fr` varchar(350) NOT NULL,
  `cat_desc_ko` varchar(350) NOT NULL,
  `cat_desc_it` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Categoria_Tipo_Dato`
--

CREATE TABLE `Categoria_Tipo_Dato` (
  `ctd_id` int(11) UNSIGNED NOT NULL,
  `td_id` int(11) UNSIGNED NOT NULL,
  `ctd_desc_zh` varchar(30) NOT NULL,
  `ctd_desc_es` varchar(30) NOT NULL,
  `ctd_desc_en` varchar(30) NOT NULL,
  `ctd_desc_hi` varchar(30) NOT NULL,
  `ctd_desc_ar` varchar(30) NOT NULL,
  `ctd_desc_pt` varchar(30) NOT NULL,
  `ctd_desc_ru` varchar(30) NOT NULL,
  `ctd_desc_ja` varchar(30) NOT NULL,
  `ctd_desc_de` varchar(30) NOT NULL,
  `ctd_desc_fr` varchar(30) NOT NULL,
  `ctd_desc_ko` varchar(30) NOT NULL,
  `ctd_desc_it` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `City`
--

CREATE TABLE `City` (
  `city_id` int(11) NOT NULL,
  `city_countryCode` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `city_nombre_zh` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_es` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_en` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_hi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_ar` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_pt` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_ru` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_ja` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_de` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_fr` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_ko` varchar(50) CHARACTER SET utf8 NOT NULL,
  `city_nombre_it` varchar(50) CHARACTER SET utf8 NOT NULL,
  `toponymName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `geonameId` int(11) NOT NULL,
  `fcl` varchar(10) CHARACTER SET utf8 NOT NULL,
  `fcode` varchar(10) CHARACTER SET utf8 NOT NULL,
  `numberOfChildren` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `click_contacto`
--

CREATE TABLE `click_contacto` (
  `cc_id` int(11) UNSIGNED NOT NULL,
  `cc_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_id_origen` int(11) UNSIGNED DEFAULT NULL,
  `usr_id_destino` int(11) UNSIGNED DEFAULT NULL,
  `cc_contenido` varchar(300) DEFAULT NULL,
  `cc_tipo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas`
--

CREATE TABLE `cobranzas` (
  `cob_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `cob_nombre` varchar(300) NOT NULL,
  `cob_descripcion` text NOT NULL,
  `cob_est_id` int(11) UNSIGNED NOT NULL,
  `cob_fecha` timestamp NOT NULL,
  `cob_codigo` varchar(255) NOT NULL,
  `cob_fecha_modif` timestamp NOT NULL,
  `cob_detalle_documentacion` text,
  `cob_acciones_requeridas` text,
  `mon_code` varchar(3) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_comentarios`
--

CREATE TABLE `cobranzas_comentarios` (
  `cob_com_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `item_tipo_id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) UNSIGNED NOT NULL,
  `sub_item_id` int(11) UNSIGNED DEFAULT NULL,
  `cob_com_est_id` int(11) UNSIGNED NOT NULL,
  `cob_com_texto` text,
  `cob_com_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_comisiones`
--

CREATE TABLE `cobranzas_comisiones` (
  `cob_com_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_com_calculo` int(11) UNSIGNED NOT NULL,
  `cob_com_calculo_productos` tinyint(1) UNSIGNED NOT NULL,
  `cob_com_calculo_servicios` tinyint(1) UNSIGNED NOT NULL,
  `cob_com_calculo_transporte` tinyint(1) UNSIGNED NOT NULL,
  `cob_com_calculo_seguros` tinyint(1) UNSIGNED NOT NULL,
  `cob_com_calculo_suma` double NOT NULL,
  `cob_com_importe` double NOT NULL,
  `cob_com_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_documentos`
--

CREATE TABLE `cobranzas_documentos` (
  `cob_doc_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_nombre` varchar(300) NOT NULL,
  `cob_doc_ruta` varchar(300) NOT NULL,
  `cob_doc_est_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_fecha` timestamp NOT NULL,
  `cob_doc_fecha_modif` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_documentos_estados`
--

CREATE TABLE `cobranzas_documentos_estados` (
  `cob_doc_est_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_est_color` varchar(50) NOT NULL,
  `cob_doc_est_desc_zh` varchar(100) NOT NULL,
  `cob_doc_est_desc_es` varchar(100) NOT NULL,
  `cob_doc_est_desc_en` varchar(100) NOT NULL,
  `cob_doc_est_desc_hi` varchar(100) NOT NULL,
  `cob_doc_est_desc_ar` varchar(100) NOT NULL,
  `cob_doc_est_desc_pt` varchar(100) NOT NULL,
  `cob_doc_est_desc_ru` varchar(100) NOT NULL,
  `cob_doc_est_desc_ja` varchar(100) NOT NULL,
  `cob_doc_est_desc_de` varchar(100) NOT NULL,
  `cob_doc_est_desc_fr` varchar(100) NOT NULL,
  `cob_doc_est_desc_ko` varchar(100) NOT NULL,
  `cob_doc_est_desc_it` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_documentos_notas`
--

CREATE TABLE `cobranzas_documentos_notas` (
  `cob_doc_not_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_not_titulo` varchar(100) NOT NULL,
  `cob_doc_not_texto` text NOT NULL,
  `cob_doc_not_tipo` int(11) UNSIGNED NOT NULL,
  `cob_doc_not_estado` int(11) UNSIGNED NOT NULL,
  `cob_doc_not_pos_x` int(11) UNSIGNED NOT NULL,
  `cob_doc_not_pos_y` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `cob_doc_not_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_empresas`
--

CREATE TABLE `cobranzas_empresas` (
  `cob_emp_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_emp_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_emp_nombre` varchar(300) NOT NULL,
  `ctry_code` varchar(3) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `cob_emp_cp` varchar(50) NOT NULL,
  `cob_emp_direccion` varchar(300) NOT NULL,
  `cob_emp_telefono` varchar(300) NOT NULL,
  `cob_emp_mail` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_empresas_tipos`
--

CREATE TABLE `cobranzas_empresas_tipos` (
  `cob_emp_tipo_id` int(11) UNSIGNED NOT NULL,
  `pal_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_estados`
--

CREATE TABLE `cobranzas_estados` (
  `cob_est_id` int(11) UNSIGNED NOT NULL,
  `cob_est_color` varchar(50) NOT NULL,
  `cob_est_desc_zh` varchar(100) NOT NULL,
  `cob_est_desc_es` varchar(100) NOT NULL,
  `cob_est_desc_en` varchar(100) NOT NULL,
  `cob_est_desc_hi` varchar(100) NOT NULL,
  `cob_est_desc_ar` varchar(100) NOT NULL,
  `cob_est_desc_pt` varchar(100) NOT NULL,
  `cob_est_desc_ru` varchar(100) NOT NULL,
  `cob_est_desc_ja` varchar(100) NOT NULL,
  `cob_est_desc_de` varchar(100) NOT NULL,
  `cob_est_desc_fr` varchar(100) NOT NULL,
  `cob_est_desc_ko` varchar(100) NOT NULL,
  `cob_est_desc_it` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_otros_servicios`
--

CREATE TABLE `cobranzas_otros_servicios` (
  `cob_otro_serv_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_otro_serv_descripcion` varchar(300) NOT NULL,
  `ara_id` int(11) UNSIGNED NOT NULL,
  `cob_otro_serv_fecha` date NOT NULL,
  `cob_otro_serv_calculo_importe` int(11) UNSIGNED NOT NULL,
  `cob_otro_serv_importe` double NOT NULL,
  `cob_otro_serv_subtotal` double NOT NULL,
  `cob_otro_serv_metodo_pago` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_pagos`
--

CREATE TABLE `cobranzas_pagos` (
  `cob_pago_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_pago_descripcion` varchar(200) NOT NULL,
  `cob_pago_fecha` date NOT NULL,
  `cob_pago_hito` int(11) UNSIGNED NOT NULL,
  `cob_pago_calculo` int(11) UNSIGNED NOT NULL,
  `cob_pago_importe` double NOT NULL,
  `mon_code` varchar(3) NOT NULL,
  `cob_pago_subtotal` double NOT NULL,
  `cob_pago_metodo` int(11) UNSIGNED NOT NULL,
  `cob_pago_destinatario` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_pagos_comisiones`
--

CREATE TABLE `cobranzas_pagos_comisiones` (
  `cob_pago_com_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_pago_com_descripcion` varchar(200) NOT NULL,
  `cob_pago_com_fecha` date NOT NULL,
  `cob_pago_com_hito` int(11) UNSIGNED NOT NULL,
  `cob_pago_com_calculo` int(11) UNSIGNED NOT NULL,
  `cob_pago_com_importe` double NOT NULL,
  `mon_code` varchar(3) NOT NULL,
  `cob_pago_com_subtotal` double NOT NULL,
  `cob_pago_com_metodo` int(11) UNSIGNED NOT NULL,
  `cob_pago_com_destinatario` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_permisos`
--

CREATE TABLE `cobranzas_permisos` (
  `cob_per_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED DEFAULT NULL,
  `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_per_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_per_acc_id` int(11) UNSIGNED NOT NULL,
  `cob_per_activo` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_permisos_acciones`
--

CREATE TABLE `cobranzas_permisos_acciones` (
  `cob_per_acc_id` int(11) UNSIGNED NOT NULL,
  `cob_per_acc_descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_permisos_tipos`
--

CREATE TABLE `cobranzas_permisos_tipos` (
  `cob_per_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_per_tipo_descripcion` varchar(100) NOT NULL,
  `pal_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_productos`
--

CREATE TABLE `cobranzas_productos` (
  `cob_prod_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `ara_id` int(11) UNSIGNED NOT NULL,
  `cob_prod_detalle` text NOT NULL,
  `cob_prod_marca` varchar(100) NOT NULL,
  `cob_prod_unidad` varchar(100) NOT NULL,
  `cob_prod_cantidad` int(11) UNSIGNED NOT NULL,
  `cob_prod_precio` double UNSIGNED NOT NULL,
  `mon_code` varchar(3) NOT NULL,
  `cob_prod_incoterm` varchar(100) NOT NULL,
  `cob_prod_tolerancia` double NOT NULL,
  `ctry_code` varchar(3) DEFAULT NULL,
  `city_id` int(11) UNSIGNED DEFAULT NULL,
  `cob_prod_subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_productos_servicios`
--

CREATE TABLE `cobranzas_productos_servicios` (
  `cob_prod_serv_id` int(11) UNSIGNED NOT NULL,
  `cob_prod_id` int(11) UNSIGNED NOT NULL,
  `ara_id` int(11) UNSIGNED NOT NULL,
  `cob_prod_serv_descripcion` varchar(300) NOT NULL,
  `cob_prod_serv_calculo_importe` int(1) UNSIGNED NOT NULL,
  `cob_prod_serv_importe` double NOT NULL,
  `mon_code` varchar(3) NOT NULL,
  `cob_prod_serv_subtotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_seguros`
--

CREATE TABLE `cobranzas_seguros` (
  `cob_seg_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_seg_numero` varchar(300) NOT NULL,
  `cob_seg_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_seg_fecha_emision` date NOT NULL,
  `cob_seg_empresa` varchar(300) NOT NULL,
  `cob_seg_nombre` varchar(300) NOT NULL,
  `cob_seg_apellido` varchar(300) NOT NULL,
  `cob_seg_telefono` varchar(300) NOT NULL,
  `cob_seg_mail` varchar(300) NOT NULL,
  `cob_seg_prima` double NOT NULL,
  `cob_seg_forma_pago` int(11) NOT NULL,
  `cob_seg_monto` double NOT NULL,
  `cob_seg_descripcion` varchar(300) NOT NULL,
  `cob_seg_procedimiento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_transportes`
--

CREATE TABLE `cobranzas_transportes` (
  `cob_trans_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `cob_trans_tipo_id` int(11) NOT NULL,
  `cob_trans_nombre` varchar(100) NOT NULL,
  `cob_trans_origen` varchar(100) NOT NULL,
  `cob_trans_destino` varchar(100) NOT NULL,
  `cob_trans_numero` varchar(100) NOT NULL,
  `cob_trans_container` varchar(100) NOT NULL,
  `cob_trans_fecha_ini` date NOT NULL,
  `cob_trans_fecha_fin` date NOT NULL,
  `cob_trans_tiempo` int(11) NOT NULL,
  `cob_trans_estado` int(11) NOT NULL,
  `mon_code` varchar(3) NOT NULL,
  `cob_trans_importe` double NOT NULL,
  `cob_trans_forma_pago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_usuarios`
--

CREATE TABLE `cobranzas_usuarios` (
  `cob_usr_id` int(11) UNSIGNED NOT NULL,
  `cob_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_usuarios_tipos`
--

CREATE TABLE `cobranzas_usuarios_tipos` (
  `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL,
  `pal_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cobranzas_usuarios_tipos_empresas`
--

CREATE TABLE `cobranzas_usuarios_tipos_empresas` (
  `cob_usr_tipo_emp_id` int(11) UNSIGNED NOT NULL,
  `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL,
  `cob_emp_tipo_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `codigos_telefono`
--

CREATE TABLE `codigos_telefono` (
  `ct_id` int(11) UNSIGNED NOT NULL,
  `ct_pais` varchar(100) NOT NULL,
  `ct_numero` int(11) UNSIGNED NOT NULL,
  `ct_estado` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Comtrade`
--

CREATE TABLE `Comtrade` (
  `com_id` int(11) UNSIGNED NOT NULL,
  `com_anio` int(4) UNSIGNED NOT NULL,
  `com_origen` int(4) NOT NULL,
  `com_destino` int(4) NOT NULL,
  `com_tipo` tinyint(1) UNSIGNED NOT NULL,
  `com_arancel` varchar(6) NOT NULL,
  `com_cantidad` double DEFAULT NULL,
  `com_valor` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comtrade2`
--

CREATE TABLE `comtrade2` (
  `com_id` int(11) UNSIGNED NOT NULL,
  `com_anio` int(4) UNSIGNED NOT NULL,
  `ctry_code_origen` varchar(3) NOT NULL,
  `ctry_code_destino` varchar(3) NOT NULL,
  `com_tipo` tinyint(1) UNSIGNED NOT NULL,
  `ara_id` int(7) UNSIGNED NOT NULL,
  `com_unidad` int(3) NOT NULL,
  `com_cantidad` double DEFAULT NULL,
  `com_peso` double NOT NULL,
  `com_valor` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comtrade_crecimiento`
--

CREATE TABLE `comtrade_crecimiento` (
  `comc_id` int(11) UNSIGNED NOT NULL,
  `comc_anio_ini` int(4) UNSIGNED NOT NULL,
  `comc_anio_fin` int(4) UNSIGNED NOT NULL,
  `ctry_code_origen` varchar(3) NOT NULL,
  `ctry_code_destino` varchar(3) NOT NULL,
  `comc_tipo` int(1) NOT NULL,
  `ara_id` int(7) NOT NULL,
  `comc_valor_ini` double NOT NULL,
  `comc_valor_fin` double NOT NULL,
  `comc_porcentaje` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comtrade_csv`
--

CREATE TABLE `comtrade_csv` (
  `csv_id` int(11) UNSIGNED NOT NULL,
  `csv_nombre` varchar(100) NOT NULL,
  `csv_estado` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Configuracion`
--

CREATE TABLE `Configuracion` (
  `conf_id` int(3) UNSIGNED NOT NULL,
  `conf_nombre` varchar(30) NOT NULL,
  `conf_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Country`
--

CREATE TABLE `Country` (
  `ctry_code` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `ctry_code2` varchar(2) CHARACTER SET utf8 NOT NULL,
  `ctry_code3` int(5) NOT NULL,
  `idi_code` varchar(3) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_zh` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_es` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_en` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_hi` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_ar` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_pt` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_ru` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_ja` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_de` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_fr` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_ko` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_nombre_it` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cont_code` varchar(3) CHARACTER SET utf8 NOT NULL,
  `ctry_capital` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ctry_area` double NOT NULL,
  `ctry_population` double NOT NULL,
  `cur_code` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `geonameId` int(11) NOT NULL,
  `ctry_west` double NOT NULL,
  `ctry_north` double NOT NULL,
  `ctry_east` double NOT NULL,
  `ctry_south` double NOT NULL,
  `ctry_pcformat` varchar(10) DEFAULT NULL,
  `ctry_idiomas` varchar(50) NOT NULL,
  `ctry_phone_code` int(4) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `errores`
--

CREATE TABLE `errores` (
  `err_id` int(11) UNSIGNED NOT NULL,
  `err_tipo_id` int(11) UNSIGNED NOT NULL,
  `err_descripcion` text NOT NULL,
  `err_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `extra_id` int(11) UNSIGNED DEFAULT NULL,
  `idi_code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `errores_tipos`
--

CREATE TABLE `errores_tipos` (
  `err_tipo_id` int(11) UNSIGNED NOT NULL,
  `err_tipo_descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `excel`
--

CREATE TABLE `excel` (
  `exc_id` int(11) UNSIGNED NOT NULL,
  `exc_fuente` varchar(100) NOT NULL,
  `exc_num` int(11) UNSIGNED NOT NULL,
  `tp_id` int(1) UNSIGNED NOT NULL,
  `ara_id` int(6) UNSIGNED NOT NULL,
  `exc_pais` varchar(100) NOT NULL,
  `exc_ciudad` varchar(100) NOT NULL,
  `exc_descripcion` text NOT NULL,
  `exc_mail` varchar(100) NOT NULL,
  `exc_idioma` varchar(100) NOT NULL,
  `exc_estado` tinyint(1) UNSIGNED DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `exp_imp`
--

CREATE TABLE `exp_imp` (
  `id` bigint(11) UNSIGNED NOT NULL,
  `field1` varchar(100) NOT NULL,
  `field2` varchar(100) NOT NULL,
  `field3` varchar(100) NOT NULL,
  `field4` varchar(100) NOT NULL,
  `field5` varchar(100) NOT NULL,
  `field6` varchar(100) NOT NULL,
  `field7` varchar(100) NOT NULL,
  `field8` varchar(100) NOT NULL,
  `field9` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facturas`
--

CREATE TABLE `facturas` (
  `fac_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `fac_total` double NOT NULL DEFAULT '0',
  `fac_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fac_cae` varchar(100) NOT NULL,
  `fac_vto_cae` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) UNSIGNED NOT NULL,
  `faq_numero` int(11) UNSIGNED NOT NULL,
  `faq_orden` int(11) NOT NULL DEFAULT '0',
  `idi_code` varchar(3) NOT NULL,
  `faq_pregunta` varchar(300) NOT NULL,
  `faq_respuesta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Foro`
--

CREATE TABLE `Foro` (
  `foro_id` int(11) UNSIGNED NOT NULL,
  `foro_titulo` varchar(300) DEFAULT NULL,
  `foro_descripcion` text NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `foro_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `foro_estado` tinyint(1) NOT NULL DEFAULT '0',
  `ara_id` int(7) UNSIGNED DEFAULT NULL,
  `ctry_code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `foro_mensaje`
--

CREATE TABLE `foro_mensaje` (
  `forom_id` int(11) UNSIGNED NOT NULL,
  `foro_id` int(11) UNSIGNED NOT NULL,
  `forom_descripcion` text NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `forom_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `foro_visitados`
--

CREATE TABLE `foro_visitados` (
  `fv_id` int(11) UNSIGNED NOT NULL,
  `foro_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `fv_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Idiomas`
--

CREATE TABLE `Idiomas` (
  `idi_code` varchar(3) NOT NULL,
  `idi_desc_zh` varchar(30) NOT NULL,
  `idi_desc_es` varchar(30) NOT NULL,
  `idi_desc_en` varchar(30) NOT NULL,
  `idi_desc_hi` varchar(30) NOT NULL,
  `idi_desc_ar` varchar(30) NOT NULL,
  `idi_desc_pt` varchar(30) NOT NULL,
  `idi_desc_ru` varchar(30) NOT NULL,
  `idi_desc_ja` varchar(30) NOT NULL,
  `idi_desc_de` varchar(30) NOT NULL,
  `idi_desc_fr` varchar(30) NOT NULL,
  `idi_desc_ko` varchar(30) NOT NULL,
  `idi_desc_it` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(10) UNSIGNED NOT NULL,
  `log_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_titulo` varchar(300) DEFAULT NULL,
  `log_texto` text,
  `log_link` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Mails`
--

CREATE TABLE `Mails` (
  `mail_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `mail_direccion` varchar(100) NOT NULL,
  `mail_codigo` varchar(4) NOT NULL,
  `mail_estado` tinyint(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails_info`
--

CREATE TABLE `mails_info` (
  `mi_id` int(11) UNSIGNED NOT NULL,
  `mi_codigo` int(11) UNSIGNED NOT NULL,
  `idi_code` varchar(2) NOT NULL,
  `mi_asunto` varchar(300) NOT NULL,
  `mi_titulo` varchar(300) NOT NULL,
  `mi_cuerpo1` text NOT NULL,
  `mi_cuerpo2` text NOT NULL,
  `mi_texto_crudo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails_info_codigo`
--

CREATE TABLE `mails_info_codigo` (
  `mi_codigo` int(3) UNSIGNED NOT NULL,
  `mi_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails_para_publicidad`
--

CREATE TABLE `mails_para_publicidad` (
  `mpp_id` int(11) UNSIGNED NOT NULL,
  `mpp_mail` varchar(100) NOT NULL,
  `mpp_fuente` varchar(100) NOT NULL,
  `mpp_fecha` date NOT NULL,
  `idi_code` varchar(3) NOT NULL,
  `mpp_enviado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mpp_unsubscribe` tinyint(1) NOT NULL DEFAULT '0',
  `mpp_valido` int(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mails_ultimo_spam`
--

CREATE TABLE `mails_ultimo_spam` (
  `mail_id` int(11) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `estado` int(1) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `msj_id` int(11) UNSIGNED NOT NULL,
  `usr_id_emisor` int(11) UNSIGNED NOT NULL,
  `usr_id_receptor` int(11) UNSIGNED NOT NULL,
  `msj_texto` text NOT NULL,
  `msj_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msj_estado` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `monedas`
--

CREATE TABLE `monedas` (
  `mon_code` varchar(3) NOT NULL,
  `mon_simbolo` varchar(10) NOT NULL,
  `mon_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `noreply`
--

CREATE TABLE `noreply` (
  `nr_id` int(11) NOT NULL,
  `nr_mail` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones`
--

CREATE TABLE `notificaciones` (
  `not_id` int(11) UNSIGNED NOT NULL,
  `usr_emisor` int(11) UNSIGNED DEFAULT NULL,
  `usr_receptor` int(11) UNSIGNED DEFAULT NULL,
  `prod_emisor` int(11) UNSIGNED DEFAULT NULL,
  `prod_receptor` int(11) UNSIGNED DEFAULT NULL,
  `not_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note_id` int(3) UNSIGNED NOT NULL,
  `not_tipo_id` int(3) UNSIGNED NOT NULL,
  `not_aux_id` int(11) UNSIGNED DEFAULT NULL,
  `not_descripcion` text,
  `not_link` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones_estados`
--

CREATE TABLE `notificaciones_estados` (
  `note_id` int(3) UNSIGNED NOT NULL,
  `note_descripcion` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones_tipos`
--

CREATE TABLE `notificaciones_tipos` (
  `not_tipo_id` int(3) UNSIGNED NOT NULL,
  `not_tipo_desc_es` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE `pagos` (
  `pago_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `pago_cantidad` double NOT NULL,
  `pago_metodo` int(1) UNSIGNED NOT NULL,
  `pago_codigo` varchar(100) NOT NULL,
  `pago_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pago_destino` int(1) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_actualizaciones`
--

CREATE TABLE `pagos_actualizaciones` (
  `pago_act_id` int(11) UNSIGNED NOT NULL,
  `pago_id` int(11) UNSIGNED NOT NULL,
  `pago_est_id` int(1) UNSIGNED NOT NULL,
  `pago_act_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_estados`
--

CREATE TABLE `pagos_estados` (
  `pago_est_id` int(1) UNSIGNED NOT NULL,
  `pago_est_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_suscripciones`
--

CREATE TABLE `pagos_suscripciones` (
  `pago_sus_id` int(11) UNSIGNED NOT NULL,
  `pago_id` int(11) UNSIGNED NOT NULL,
  `pago_sus_fecha_ini` date NOT NULL,
  `pago_sus_fecha_fin` date NOT NULL,
  `pago_sus_estado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `palabras`
--

CREATE TABLE `palabras` (
  `pal_id` int(3) UNSIGNED NOT NULL,
  `pal_desc_zh` text NOT NULL,
  `pal_desc_es` text NOT NULL,
  `pal_desc_en` text NOT NULL,
  `pal_desc_hi` text NOT NULL,
  `pal_desc_ar` text NOT NULL,
  `pal_desc_pt` text NOT NULL,
  `pal_desc_ru` text NOT NULL,
  `pal_desc_ja` text NOT NULL,
  `pal_desc_de` text NOT NULL,
  `pal_desc_fr` text NOT NULL,
  `pal_desc_ko` text NOT NULL,
  `pal_desc_it` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `palabras_usadas`
--

CREATE TABLE `palabras_usadas` (
  `pal_us_id` int(11) NOT NULL,
  `pal_id` int(11) NOT NULL,
  `pal_us_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pal_us_link` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `politicas`
--

CREATE TABLE `politicas` (
  `pol_id` int(11) UNSIGNED NOT NULL,
  `pol_tipo_id` int(11) UNSIGNED NOT NULL,
  `idi_code` char(2) NOT NULL,
  `pol_titulo` varchar(100) NOT NULL,
  `pol_texto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `politicas_tipos`
--

CREATE TABLE `politicas_tipos` (
  `pol_tipo_id` int(11) UNSIGNED NOT NULL,
  `pol_tipo_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_bancos`
--

CREATE TABLE `prices_bancos` (
  `banco_id` int(11) UNSIGNED NOT NULL,
  `banco_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_categorias`
--

CREATE TABLE `prices_categorias` (
  `cat_id` int(11) UNSIGNED NOT NULL,
  `cat_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_comercios`
--

CREATE TABLE `prices_comercios` (
  `com_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `com_nombre` varchar(100) NOT NULL,
  `com_estado` tinyint(1) NOT NULL DEFAULT '1',
  `com_lat` double NOT NULL,
  `com_lng` double NOT NULL,
  `com_accuracy` double NOT NULL,
  `com_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_tipo` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `com_direccion` varchar(300) DEFAULT NULL,
  `ctry_code` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_comercios_codigos`
--

CREATE TABLE `prices_comercios_codigos` (
  `com_cod_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `com_cod_codigo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_comercios_descuentos`
--

CREATE TABLE `prices_comercios_descuentos` (
  `com_desc_id` int(11) UNSIGNED NOT NULL,
  `com_id` int(11) UNSIGNED NOT NULL,
  `desc_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_descuentos`
--

CREATE TABLE `prices_descuentos` (
  `desc_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `desc_nombre` varchar(300) NOT NULL,
  `desc_estado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `desc_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tarj_id` int(11) UNSIGNED DEFAULT NULL,
  `desc_tipo` int(2) UNSIGNED DEFAULT NULL,
  `desc_fecha_fin` date DEFAULT NULL,
  `desc_dias` varchar(100) DEFAULT NULL,
  `desc_minimo` int(11) DEFAULT NULL,
  `desc_porcentaje` double DEFAULT NULL,
  `desc_promocion` double DEFAULT NULL,
  `desc_gratis` int(11) DEFAULT NULL,
  `banco_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_descuentos_tipos`
--

CREATE TABLE `prices_descuentos_tipos` (
  `desc_tipo_id` int(11) UNSIGNED NOT NULL,
  `desc_tipo_desc_zh` varchar(100) NOT NULL,
  `desc_tipo_desc_es` varchar(100) NOT NULL,
  `desc_tipo_desc_en` varchar(100) NOT NULL,
  `desc_tipo_desc_hi` varchar(100) NOT NULL,
  `desc_tipo_desc_ar` varchar(100) NOT NULL,
  `desc_tipo_desc_pt` varchar(100) NOT NULL,
  `desc_tipo_desc_ru` varchar(100) NOT NULL,
  `desc_tipo_desc_ja` varchar(100) NOT NULL,
  `desc_tipo_desc_de` varchar(100) NOT NULL,
  `desc_tipo_desc_fr` varchar(100) NOT NULL,
  `desc_tipo_desc_ko` varchar(100) NOT NULL,
  `desc_tipo_desc_it` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_devices`
--

CREATE TABLE `prices_devices` (
  `dev_id` int(10) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `dev_code` varchar(300) NOT NULL,
  `dev_platform` varchar(50) NOT NULL,
  `dev_model` varchar(100) NOT NULL,
  `dev_manufacturer` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_encuestas`
--

CREATE TABLE `prices_encuestas` (
  `enc_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `enc_rating` float UNSIGNED NOT NULL,
  `enc_comentario` text NOT NULL,
  `enc_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_marcas`
--

CREATE TABLE `prices_marcas` (
  `marc_id` int(11) UNSIGNED NOT NULL,
  `marc_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_precios`
--

CREATE TABLE `prices_precios` (
  `pre_id` int(11) NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `pre_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pre_importe` double NOT NULL,
  `mon_code` varchar(3) DEFAULT NULL,
  `pre_lat` double NOT NULL,
  `pre_lng` double NOT NULL,
  `pre_alt` double NOT NULL,
  `pre_accuracy` double NOT NULL,
  `pre_alt_accuracy` double NOT NULL,
  `pre_heading` double NOT NULL COMMENT 'Direction of travel',
  `pre_speed` double NOT NULL,
  `pre_en_oferta` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `pre_oferta` varchar(300) DEFAULT NULL,
  `desc_id` int(11) UNSIGNED DEFAULT NULL,
  `pre_en_comercio` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `pre_comercio` varchar(300) DEFAULT NULL,
  `com_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_productos`
--

CREATE TABLE `prices_productos` (
  `prod_id` int(11) UNSIGNED NOT NULL,
  `prod_nombre` varchar(100) NOT NULL,
  `marc_id` int(11) UNSIGNED DEFAULT NULL,
  `prod_codigo` varchar(100) DEFAULT NULL,
  `prod_codigo_tipo` varchar(20) NOT NULL,
  `prod_imagen` varchar(200) DEFAULT NULL,
  `sub_cat_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_productos_usuarios`
--

CREATE TABLE `prices_productos_usuarios` (
  `prod_usr_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED DEFAULT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `prod_usr_nombre` varchar(100) NOT NULL,
  `prod_usr_imagen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_rating`
--

CREATE TABLE `prices_rating` (
  `rat_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `rat_valor` double NOT NULL,
  `rat_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_reportes`
--

CREATE TABLE `prices_reportes` (
  `rep_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `rep_importe` double NOT NULL,
  `rep_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_subcategorias`
--

CREATE TABLE `prices_subcategorias` (
  `sub_cat_id` int(11) UNSIGNED NOT NULL,
  `cat_id` int(11) UNSIGNED NOT NULL,
  `sub_cat_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_tarjetas`
--

CREATE TABLE `prices_tarjetas` (
  `tarj_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED DEFAULT NULL,
  `tarj_tipo` int(11) UNSIGNED NOT NULL,
  `tarj_nombre` varchar(100) NOT NULL,
  `tarj_estado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `tarj_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_tarjetas_tipos`
--

CREATE TABLE `prices_tarjetas_tipos` (
  `tarj_tipo_id` int(11) UNSIGNED NOT NULL,
  `tarj_tipo_desc_zh` varchar(100) NOT NULL,
  `tarj_tipo_desc_es` varchar(100) NOT NULL,
  `tarj_tipo_desc_en` varchar(100) NOT NULL,
  `tarj_tipo_desc_hi` varchar(100) NOT NULL,
  `tarj_tipo_desc_ar` varchar(100) NOT NULL,
  `tarj_tipo_desc_pt` varchar(100) NOT NULL,
  `tarj_tipo_desc_ru` varchar(100) NOT NULL,
  `tarj_tipo_desc_ja` varchar(100) NOT NULL,
  `tarj_tipo_desc_de` varchar(100) NOT NULL,
  `tarj_tipo_desc_fr` varchar(100) NOT NULL,
  `tarj_tipo_desc_ko` varchar(100) NOT NULL,
  `tarj_tipo_desc_it` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_usuarios`
--

CREATE TABLE `prices_usuarios` (
  `usr_id` int(11) UNSIGNED NOT NULL,
  `usr_nombre` varchar(100) NOT NULL,
  `usr_apellido` varchar(100) NOT NULL,
  `usr_mail` varchar(100) NOT NULL,
  `ctry_code` varchar(3) NOT NULL,
  `idi_code` varchar(2) NOT NULL,
  `usr_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_sexo` varchar(1) DEFAULT NULL,
  `usr_fecha_nac` date DEFAULT NULL,
  `usr_radio_busqueda` int(4) UNSIGNED NOT NULL DEFAULT '10',
  `usr_estudios` int(2) UNSIGNED DEFAULT NULL,
  `usr_hijos` int(1) UNSIGNED DEFAULT NULL,
  `usr_ocupacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prices_usuarios_tarjetas`
--

CREATE TABLE `prices_usuarios_tarjetas` (
  `usr_tarj_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `tarj_id` int(11) UNSIGNED NOT NULL,
  `banco_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Productos`
--

CREATE TABLE `Productos` (
  `prod_id` int(11) UNSIGNED NOT NULL,
  `tp_id` int(1) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `ara_id` int(6) NOT NULL,
  `prod_nombre` varchar(50) NOT NULL,
  `prod_descripcion` text NOT NULL,
  `ctry_code` varchar(3) NOT NULL,
  `city_id` int(11) UNSIGNED NOT NULL,
  `prod_estado` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `prod_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Productos_Favoritos`
--

CREATE TABLE `Productos_Favoritos` (
  `usr_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `pf_puntaje` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Productos_Idiomas`
--

CREATE TABLE `Productos_Idiomas` (
  `prod_id` int(11) UNSIGNED NOT NULL,
  `idi_code` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productos_imagenes`
--

CREATE TABLE `productos_imagenes` (
  `pi_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `pi_ruta` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Productos_Mails`
--

CREATE TABLE `Productos_Mails` (
  `pm_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `mail_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `productos_visitados`
--

CREATE TABLE `productos_visitados` (
  `pv_id` int(11) UNSIGNED NOT NULL,
  `prod_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `pv_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referencias`
--

CREATE TABLE `referencias` (
  `ref_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `ref_mail` varchar(100) NOT NULL,
  `ref_est_id` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `ref_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Secciones`
--

CREATE TABLE `Secciones` (
  `sec_id` int(3) NOT NULL,
  `sec_code` varchar(5) NOT NULL,
  `sec_desc_zh` varchar(350) NOT NULL,
  `sec_desc_es` varchar(350) NOT NULL,
  `sec_desc_en` varchar(350) NOT NULL,
  `sec_desc_hi` varchar(350) NOT NULL,
  `sec_desc_ar` varchar(350) NOT NULL,
  `sec_desc_pt` varchar(350) NOT NULL,
  `sec_desc_ru` varchar(350) NOT NULL,
  `sec_desc_ja` varchar(350) NOT NULL,
  `sec_desc_de` varchar(350) NOT NULL,
  `sec_desc_fr` varchar(350) NOT NULL,
  `sec_desc_ko` varchar(350) NOT NULL,
  `sec_desc_it` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `supermercados`
--

CREATE TABLE `supermercados` (
  `super_id` int(11) UNSIGNED NOT NULL,
  `super_nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Tipo_Datos`
--

CREATE TABLE `Tipo_Datos` (
  `td_id` int(3) UNSIGNED NOT NULL,
  `td_icono` varchar(20) NOT NULL,
  `td_placeholder` varchar(20) NOT NULL,
  `td_desc_zh` varchar(30) NOT NULL,
  `td_desc_es` varchar(30) NOT NULL,
  `td_desc_en` varchar(30) NOT NULL,
  `td_desc_hi` varchar(30) NOT NULL,
  `td_desc_ar` varchar(30) NOT NULL,
  `td_desc_pt` varchar(30) NOT NULL,
  `td_desc_ru` varchar(30) NOT NULL,
  `td_desc_ja` varchar(30) NOT NULL,
  `td_desc_de` varchar(30) NOT NULL,
  `td_desc_fr` varchar(30) NOT NULL,
  `td_desc_ko` varchar(30) NOT NULL,
  `td_desc_it` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Tipo_Productos`
--

CREATE TABLE `Tipo_Productos` (
  `tp_id` int(1) UNSIGNED NOT NULL,
  `tp_desc_zh` varchar(20) NOT NULL,
  `tp_desc_es` varchar(20) NOT NULL,
  `tp_desc_en` varchar(20) NOT NULL,
  `tp_desc_hi` varchar(20) NOT NULL,
  `tp_desc_ar` varchar(20) NOT NULL,
  `tp_desc_pt` varchar(20) NOT NULL,
  `tp_desc_ru` varchar(20) NOT NULL,
  `tp_desc_ja` varchar(20) NOT NULL,
  `tp_desc_de` varchar(20) NOT NULL,
  `tp_desc_fr` varchar(20) NOT NULL,
  `tp_desc_ko` varchar(20) NOT NULL,
  `tp_desc_it` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Tipo_Usuarios`
--

CREATE TABLE `Tipo_Usuarios` (
  `tu_id` tinyint(1) UNSIGNED NOT NULL,
  `tu_descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unsubscribes`
--

CREATE TABLE `unsubscribes` (
  `uns_id` int(11) UNSIGNED NOT NULL,
  `mail_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios`
--

CREATE TABLE `Usuarios` (
  `usr_id` int(9) UNSIGNED NOT NULL,
  `usr_nombre` varchar(50) NOT NULL,
  `usr_apellido` varchar(50) NOT NULL,
  `usr_mail` varchar(100) NOT NULL,
  `usr_clave` varchar(20) NOT NULL,
  `usr_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_estado` int(1) NOT NULL DEFAULT '1',
  `idi_code` varchar(3) NOT NULL DEFAULT 'ing',
  `usr_publica` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `usr_imagen` varchar(100) DEFAULT NULL,
  `usr_empresa` varchar(100) DEFAULT NULL,
  `usr_pais` varchar(3) DEFAULT NULL,
  `usr_provincia` int(11) DEFAULT NULL,
  `usr_ciudad` varchar(100) DEFAULT NULL,
  `usr_direccion` varchar(100) DEFAULT NULL,
  `usr_ult_acceso` timestamp NULL DEFAULT NULL,
  `usr_nac` date DEFAULT NULL,
  `usr_cp` varchar(10) DEFAULT NULL,
  `tu_id` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `usr_facebook` varchar(100) DEFAULT NULL,
  `usr_google` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_ads`
--

CREATE TABLE `usuarios_ads` (
  `usr_id` int(11) UNSIGNED NOT NULL,
  `usr_ads_fecha_ini` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usr_ads_estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Stand-in structure for view `usuarios_ads_saldo`
-- (See below for the actual view)
--
CREATE TABLE `usuarios_ads_saldo` (
`usr_id` int(11) unsigned
,`usr_ads_fecha_ini` timestamp
,`usr_ads_estado` tinyint(1)
,`saldo` double
);

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios_Datos`
--

CREATE TABLE `Usuarios_Datos` (
  `ud_id` int(11) UNSIGNED NOT NULL,
  `usr_id` int(11) UNSIGNED NOT NULL,
  `td_id` int(11) UNSIGNED NOT NULL,
  `ctd_id` int(11) UNSIGNED DEFAULT NULL,
  `ud_descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_datos_facturacion`
--

CREATE TABLE `usuarios_datos_facturacion` (
  `usr_id` int(11) UNSIGNED NOT NULL,
  `usr_dat_fac_nombre` varchar(50) NOT NULL,
  `usr_dat_fac_apellido` varchar(50) NOT NULL,
  `usr_dat_fac_empresa` varchar(100) NOT NULL,
  `usr_dat_fac_id` varchar(50) NOT NULL,
  `ctry_code` varchar(3) NOT NULL,
  `usr_dat_fac_telefono` varchar(100) NOT NULL,
  `usr_dat_fac_direccion` varchar(100) NOT NULL,
  `usr_dat_fac_cp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios_Favoritos`
--

CREATE TABLE `Usuarios_Favoritos` (
  `usr_id` int(10) UNSIGNED NOT NULL,
  `usr_favorito` int(10) UNSIGNED NOT NULL,
  `uf_puntaje` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Usuarios_Push`
--

CREATE TABLE `Usuarios_Push` (
  `usr_id` int(11) UNSIGNED NOT NULL,
  `usr_device` int(11) UNSIGNED NOT NULL,
  `usr_token` varchar(300) NOT NULL,
  `usr_service` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`acc_id`);

--
-- Indexes for table `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ads_id`),
  ADD KEY `fk_ads_tipo` (`ads_tipo_id`);

--
-- Indexes for table `ads_aranceles`
--
ALTER TABLE `ads_aranceles`
  ADD PRIMARY KEY (`ads_ara_id`),
  ADD KEY `fk_ads2` (`ads_id`),
  ADD KEY `fk_aranceles_ads` (`ara_id`);

--
-- Indexes for table `ads_bloqueos`
--
ALTER TABLE `ads_bloqueos`
  ADD PRIMARY KEY (`ads_blo_id`),
  ADD KEY `fk_ads_blo_user` (`ads_blo_usr_id`),
  ADD KEY `fk_ads_blo_user2` (`usr_id`);

--
-- Indexes for table `ads_click`
--
ALTER TABLE `ads_click`
  ADD PRIMARY KEY (`ads_click_id`),
  ADD KEY `fk_ads4` (`ads_id`),
  ADD KEY `fk_ads_users` (`usr_id`);

--
-- Indexes for table `ads_countrys`
--
ALTER TABLE `ads_countrys`
  ADD PRIMARY KEY (`ads_ctry_id`),
  ADD KEY `fk_ads` (`ads_id`),
  ADD KEY `fk_country_ads` (`ctry_code`);

--
-- Indexes for table `ads_forms`
--
ALTER TABLE `ads_forms`
  ADD PRIMARY KEY (`ads_form_id`),
  ADD KEY `fk_ads6` (`ads_id`),
  ADD KEY `fk_ads_users3` (`usr_id`);

--
-- Indexes for table `ads_imagenes`
--
ALTER TABLE `ads_imagenes`
  ADD PRIMARY KEY (`ads_img_id`),
  ADD KEY `fk_ads3` (`ads_id`);

--
-- Indexes for table `ads_importes`
--
ALTER TABLE `ads_importes`
  ADD PRIMARY KEY (`ads_imp_id`);

--
-- Indexes for table `ads_impresion`
--
ALTER TABLE `ads_impresion`
  ADD PRIMARY KEY (`ads_imp_id`),
  ADD KEY `fk_ads5` (`ads_id`),
  ADD KEY `fk_ads_users2` (`usr_id`);

--
-- Indexes for table `ads_tipos`
--
ALTER TABLE `ads_tipos`
  ADD PRIMARY KEY (`ads_tipo_id`);

--
-- Indexes for table `Aranceles`
--
ALTER TABLE `Aranceles`
  ADD PRIMARY KEY (`ara_id`),
  ADD KEY `fk_categoria` (`cat_id`);

--
-- Indexes for table `Categorias`
--
ALTER TABLE `Categorias`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `fk_secccion` (`sec_id`);

--
-- Indexes for table `Categoria_Tipo_Dato`
--
ALTER TABLE `Categoria_Tipo_Dato`
  ADD PRIMARY KEY (`ctd_id`),
  ADD KEY `fk_tipo_dato` (`td_id`);

--
-- Indexes for table `City`
--
ALTER TABLE `City`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `fk_country` (`city_countryCode`);

--
-- Indexes for table `click_contacto`
--
ALTER TABLE `click_contacto`
  ADD PRIMARY KEY (`cc_id`);

--
-- Indexes for table `cobranzas`
--
ALTER TABLE `cobranzas`
  ADD PRIMARY KEY (`cob_id`);

--
-- Indexes for table `cobranzas_comentarios`
--
ALTER TABLE `cobranzas_comentarios`
  ADD PRIMARY KEY (`cob_com_id`);

--
-- Indexes for table `cobranzas_comisiones`
--
ALTER TABLE `cobranzas_comisiones`
  ADD PRIMARY KEY (`cob_com_id`);

--
-- Indexes for table `cobranzas_documentos`
--
ALTER TABLE `cobranzas_documentos`
  ADD PRIMARY KEY (`cob_doc_id`);

--
-- Indexes for table `cobranzas_documentos_estados`
--
ALTER TABLE `cobranzas_documentos_estados`
  ADD PRIMARY KEY (`cob_doc_est_id`);

--
-- Indexes for table `cobranzas_documentos_notas`
--
ALTER TABLE `cobranzas_documentos_notas`
  ADD PRIMARY KEY (`cob_doc_not_id`);

--
-- Indexes for table `cobranzas_empresas`
--
ALTER TABLE `cobranzas_empresas`
  ADD PRIMARY KEY (`cob_emp_id`);

--
-- Indexes for table `cobranzas_empresas_tipos`
--
ALTER TABLE `cobranzas_empresas_tipos`
  ADD PRIMARY KEY (`cob_emp_tipo_id`);

--
-- Indexes for table `cobranzas_estados`
--
ALTER TABLE `cobranzas_estados`
  ADD PRIMARY KEY (`cob_est_id`);

--
-- Indexes for table `cobranzas_otros_servicios`
--
ALTER TABLE `cobranzas_otros_servicios`
  ADD PRIMARY KEY (`cob_otro_serv_id`);

--
-- Indexes for table `cobranzas_pagos`
--
ALTER TABLE `cobranzas_pagos`
  ADD PRIMARY KEY (`cob_pago_id`);

--
-- Indexes for table `cobranzas_pagos_comisiones`
--
ALTER TABLE `cobranzas_pagos_comisiones`
  ADD PRIMARY KEY (`cob_pago_com_id`);

--
-- Indexes for table `cobranzas_permisos`
--
ALTER TABLE `cobranzas_permisos`
  ADD PRIMARY KEY (`cob_per_id`);

--
-- Indexes for table `cobranzas_permisos_acciones`
--
ALTER TABLE `cobranzas_permisos_acciones`
  ADD PRIMARY KEY (`cob_per_acc_id`);

--
-- Indexes for table `cobranzas_permisos_tipos`
--
ALTER TABLE `cobranzas_permisos_tipos`
  ADD PRIMARY KEY (`cob_per_tipo_id`);

--
-- Indexes for table `cobranzas_productos`
--
ALTER TABLE `cobranzas_productos`
  ADD PRIMARY KEY (`cob_prod_id`);

--
-- Indexes for table `cobranzas_productos_servicios`
--
ALTER TABLE `cobranzas_productos_servicios`
  ADD PRIMARY KEY (`cob_prod_serv_id`);

--
-- Indexes for table `cobranzas_seguros`
--
ALTER TABLE `cobranzas_seguros`
  ADD PRIMARY KEY (`cob_seg_id`);

--
-- Indexes for table `cobranzas_transportes`
--
ALTER TABLE `cobranzas_transportes`
  ADD PRIMARY KEY (`cob_trans_id`);

--
-- Indexes for table `cobranzas_usuarios`
--
ALTER TABLE `cobranzas_usuarios`
  ADD PRIMARY KEY (`cob_usr_id`);

--
-- Indexes for table `cobranzas_usuarios_tipos`
--
ALTER TABLE `cobranzas_usuarios_tipos`
  ADD PRIMARY KEY (`cob_usr_tipo_id`);

--
-- Indexes for table `cobranzas_usuarios_tipos_empresas`
--
ALTER TABLE `cobranzas_usuarios_tipos_empresas`
  ADD PRIMARY KEY (`cob_usr_tipo_emp_id`);

--
-- Indexes for table `codigos_telefono`
--
ALTER TABLE `codigos_telefono`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `Comtrade`
--
ALTER TABLE `Comtrade`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `fk_origen` (`com_origen`),
  ADD KEY `fk_destino` (`com_destino`),
  ADD KEY `fk_tipo_producto2` (`com_tipo`),
  ADD KEY `fk_arancel2` (`com_arancel`);

--
-- Indexes for table `comtrade2`
--
ALTER TABLE `comtrade2`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `comtrade_crecimiento`
--
ALTER TABLE `comtrade_crecimiento`
  ADD PRIMARY KEY (`comc_id`),
  ADD KEY `fk_arancel3` (`ara_id`),
  ADD KEY `ctry_code_origen` (`ctry_code_origen`),
  ADD KEY `ctry_code_destino` (`ctry_code_destino`);

--
-- Indexes for table `comtrade_csv`
--
ALTER TABLE `comtrade_csv`
  ADD PRIMARY KEY (`csv_id`);

--
-- Indexes for table `Configuracion`
--
ALTER TABLE `Configuracion`
  ADD PRIMARY KEY (`conf_id`);

--
-- Indexes for table `Country`
--
ALTER TABLE `Country`
  ADD PRIMARY KEY (`ctry_code`),
  ADD KEY `fk_moneda` (`cur_code`);

--
-- Indexes for table `errores`
--
ALTER TABLE `errores`
  ADD PRIMARY KEY (`err_id`);

--
-- Indexes for table `errores_tipos`
--
ALTER TABLE `errores_tipos`
  ADD PRIMARY KEY (`err_tipo_id`);

--
-- Indexes for table `excel`
--
ALTER TABLE `excel`
  ADD PRIMARY KEY (`exc_id`);

--
-- Indexes for table `exp_imp`
--
ALTER TABLE `exp_imp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`),
  ADD UNIQUE KEY `faq_numero` (`faq_numero`,`idi_code`),
  ADD KEY `fk_idioma2` (`idi_code`);

--
-- Indexes for table `Foro`
--
ALTER TABLE `Foro`
  ADD PRIMARY KEY (`foro_id`);

--
-- Indexes for table `foro_mensaje`
--
ALTER TABLE `foro_mensaje`
  ADD PRIMARY KEY (`forom_id`),
  ADD KEY `fk_foro` (`foro_id`);

--
-- Indexes for table `foro_visitados`
--
ALTER TABLE `foro_visitados`
  ADD PRIMARY KEY (`fv_id`),
  ADD KEY `fk_usuario9` (`usr_id`),
  ADD KEY `fk_foro2` (`foro_id`);

--
-- Indexes for table `Idiomas`
--
ALTER TABLE `Idiomas`
  ADD PRIMARY KEY (`idi_code`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `Mails`
--
ALTER TABLE `Mails`
  ADD PRIMARY KEY (`mail_id`),
  ADD KEY `fk_usuario` (`usr_id`);

--
-- Indexes for table `mails_info`
--
ALTER TABLE `mails_info`
  ADD PRIMARY KEY (`mi_id`),
  ADD UNIQUE KEY `mi_codigo_2` (`mi_codigo`,`idi_code`),
  ADD KEY `mi_codigo` (`mi_codigo`),
  ADD KEY `fk_idioma3` (`idi_code`);

--
-- Indexes for table `mails_info_codigo`
--
ALTER TABLE `mails_info_codigo`
  ADD PRIMARY KEY (`mi_codigo`);

--
-- Indexes for table `mails_para_publicidad`
--
ALTER TABLE `mails_para_publicidad`
  ADD PRIMARY KEY (`mpp_id`);

--
-- Indexes for table `mails_ultimo_spam`
--
ALTER TABLE `mails_ultimo_spam`
  ADD PRIMARY KEY (`mail_id`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`msj_id`);

--
-- Indexes for table `monedas`
--
ALTER TABLE `monedas`
  ADD PRIMARY KEY (`mon_code`);

--
-- Indexes for table `noreply`
--
ALTER TABLE `noreply`
  ADD PRIMARY KEY (`nr_id`),
  ADD UNIQUE KEY `nr_mail` (`nr_mail`);

--
-- Indexes for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`not_id`),
  ADD KEY `fk_usuario10` (`usr_emisor`),
  ADD KEY `fk_usuario11` (`usr_receptor`),
  ADD KEY `fk_producto5` (`prod_emisor`),
  ADD KEY `fk_producto6` (`prod_receptor`);

--
-- Indexes for table `notificaciones_estados`
--
ALTER TABLE `notificaciones_estados`
  ADD PRIMARY KEY (`note_id`);

--
-- Indexes for table `notificaciones_tipos`
--
ALTER TABLE `notificaciones_tipos`
  ADD PRIMARY KEY (`not_tipo_id`);

--
-- Indexes for table `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`pago_id`),
  ADD KEY `fk_usuario14` (`usr_id`);

--
-- Indexes for table `pagos_actualizaciones`
--
ALTER TABLE `pagos_actualizaciones`
  ADD PRIMARY KEY (`pago_act_id`),
  ADD KEY `fk_pago` (`pago_id`),
  ADD KEY `fk_pago_estado` (`pago_est_id`);

--
-- Indexes for table `pagos_estados`
--
ALTER TABLE `pagos_estados`
  ADD PRIMARY KEY (`pago_est_id`);

--
-- Indexes for table `pagos_suscripciones`
--
ALTER TABLE `pagos_suscripciones`
  ADD PRIMARY KEY (`pago_sus_id`);

--
-- Indexes for table `palabras`
--
ALTER TABLE `palabras`
  ADD PRIMARY KEY (`pal_id`);

--
-- Indexes for table `palabras_usadas`
--
ALTER TABLE `palabras_usadas`
  ADD PRIMARY KEY (`pal_us_id`);

--
-- Indexes for table `politicas`
--
ALTER TABLE `politicas`
  ADD PRIMARY KEY (`pol_id`),
  ADD KEY `fk_pol_tipo` (`pol_tipo_id`),
  ADD KEY `fk_pol_idioma` (`idi_code`);

--
-- Indexes for table `politicas_tipos`
--
ALTER TABLE `politicas_tipos`
  ADD PRIMARY KEY (`pol_tipo_id`);

--
-- Indexes for table `prices_bancos`
--
ALTER TABLE `prices_bancos`
  ADD PRIMARY KEY (`banco_id`),
  ADD UNIQUE KEY `banco_nombre` (`banco_nombre`);

--
-- Indexes for table `prices_categorias`
--
ALTER TABLE `prices_categorias`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_nombre` (`cat_nombre`);

--
-- Indexes for table `prices_comercios`
--
ALTER TABLE `prices_comercios`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `prices_comercios_codigos`
--
ALTER TABLE `prices_comercios_codigos`
  ADD PRIMARY KEY (`com_cod_id`),
  ADD KEY `fk_prod_id_comercios_codigos` (`prod_id`);

--
-- Indexes for table `prices_comercios_descuentos`
--
ALTER TABLE `prices_comercios_descuentos`
  ADD PRIMARY KEY (`com_desc_id`);

--
-- Indexes for table `prices_descuentos`
--
ALTER TABLE `prices_descuentos`
  ADD PRIMARY KEY (`desc_id`),
  ADD KEY `fk_banco_id_prices_descuentos` (`banco_id`),
  ADD KEY `fk_tarj_id_prices_descuentos` (`tarj_id`),
  ADD KEY `fk_usr_id_prices_descuentos` (`usr_id`);

--
-- Indexes for table `prices_descuentos_tipos`
--
ALTER TABLE `prices_descuentos_tipos`
  ADD PRIMARY KEY (`desc_tipo_id`);

--
-- Indexes for table `prices_devices`
--
ALTER TABLE `prices_devices`
  ADD PRIMARY KEY (`dev_id`),
  ADD KEY `fk_usr_id_prices_devices` (`usr_id`);

--
-- Indexes for table `prices_encuestas`
--
ALTER TABLE `prices_encuestas`
  ADD PRIMARY KEY (`enc_id`);

--
-- Indexes for table `prices_marcas`
--
ALTER TABLE `prices_marcas`
  ADD PRIMARY KEY (`marc_id`),
  ADD UNIQUE KEY `marc_nombre` (`marc_nombre`);

--
-- Indexes for table `prices_precios`
--
ALTER TABLE `prices_precios`
  ADD PRIMARY KEY (`pre_id`),
  ADD KEY `fk_mon_code_prices_precios` (`mon_code`),
  ADD KEY `fk_usr_id_prices_precios` (`usr_id`),
  ADD KEY `fk_desc_id_prices_precios` (`desc_id`),
  ADD KEY `fk_prod_id_prices_precios` (`prod_id`),
  ADD KEY `fk_com_id_prices_precios` (`com_id`);

--
-- Indexes for table `prices_productos`
--
ALTER TABLE `prices_productos`
  ADD PRIMARY KEY (`prod_id`),
  ADD UNIQUE KEY `prod_codigo` (`prod_codigo`),
  ADD KEY `fk_marca_producto` (`marc_id`),
  ADD KEY `fk_sub_cat_id_producto` (`sub_cat_id`);

--
-- Indexes for table `prices_productos_usuarios`
--
ALTER TABLE `prices_productos_usuarios`
  ADD PRIMARY KEY (`prod_usr_id`);

--
-- Indexes for table `prices_rating`
--
ALTER TABLE `prices_rating`
  ADD PRIMARY KEY (`rat_id`),
  ADD KEY `fk_rating_producto` (`prod_id`),
  ADD KEY `fk_rating_usuario` (`usr_id`);

--
-- Indexes for table `prices_reportes`
--
ALTER TABLE `prices_reportes`
  ADD PRIMARY KEY (`rep_id`);

--
-- Indexes for table `prices_subcategorias`
--
ALTER TABLE `prices_subcategorias`
  ADD PRIMARY KEY (`sub_cat_id`),
  ADD UNIQUE KEY `cat_id` (`cat_id`,`sub_cat_nombre`);

--
-- Indexes for table `prices_tarjetas`
--
ALTER TABLE `prices_tarjetas`
  ADD PRIMARY KEY (`tarj_id`),
  ADD UNIQUE KEY `tarj_nombre` (`tarj_nombre`);

--
-- Indexes for table `prices_tarjetas_tipos`
--
ALTER TABLE `prices_tarjetas_tipos`
  ADD PRIMARY KEY (`tarj_tipo_id`);

--
-- Indexes for table `prices_usuarios`
--
ALTER TABLE `prices_usuarios`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `fk_idi_code_prices_usuarios` (`idi_code`),
  ADD KEY `fk_ctry_code_prices_usuarios` (`ctry_code`);

--
-- Indexes for table `prices_usuarios_tarjetas`
--
ALTER TABLE `prices_usuarios_tarjetas`
  ADD PRIMARY KEY (`usr_tarj_id`);

--
-- Indexes for table `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `fk_tipo_producto` (`tp_id`),
  ADD KEY `fk_arancel` (`ara_id`),
  ADD KEY `fk_country_prod` (`ctry_code`),
  ADD KEY `fk_usuario3` (`usr_id`);

--
-- Indexes for table `Productos_Favoritos`
--
ALTER TABLE `Productos_Favoritos`
  ADD PRIMARY KEY (`usr_id`,`prod_id`),
  ADD KEY `fk_producto` (`prod_id`);

--
-- Indexes for table `Productos_Idiomas`
--
ALTER TABLE `Productos_Idiomas`
  ADD PRIMARY KEY (`prod_id`,`idi_code`),
  ADD KEY `fk_idiomas` (`idi_code`);

--
-- Indexes for table `productos_imagenes`
--
ALTER TABLE `productos_imagenes`
  ADD PRIMARY KEY (`pi_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `Productos_Mails`
--
ALTER TABLE `Productos_Mails`
  ADD PRIMARY KEY (`pm_id`),
  ADD KEY `fk_producto2` (`prod_id`);

--
-- Indexes for table `productos_visitados`
--
ALTER TABLE `productos_visitados`
  ADD PRIMARY KEY (`pv_id`),
  ADD KEY `fk_usuario8` (`usr_id`),
  ADD KEY `fk_producto4` (`prod_id`);

--
-- Indexes for table `referencias`
--
ALTER TABLE `referencias`
  ADD PRIMARY KEY (`ref_id`),
  ADD KEY `fk_usuario12` (`usr_id`);

--
-- Indexes for table `Secciones`
--
ALTER TABLE `Secciones`
  ADD PRIMARY KEY (`sec_id`);

--
-- Indexes for table `supermercados`
--
ALTER TABLE `supermercados`
  ADD PRIMARY KEY (`super_id`);

--
-- Indexes for table `Tipo_Datos`
--
ALTER TABLE `Tipo_Datos`
  ADD PRIMARY KEY (`td_id`);

--
-- Indexes for table `Tipo_Productos`
--
ALTER TABLE `Tipo_Productos`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `Tipo_Usuarios`
--
ALTER TABLE `Tipo_Usuarios`
  ADD PRIMARY KEY (`tu_id`);

--
-- Indexes for table `unsubscribes`
--
ALTER TABLE `unsubscribes`
  ADD PRIMARY KEY (`uns_id`);

--
-- Indexes for table `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `fk_idioma` (`idi_code`),
  ADD KEY `fk_tipo` (`tu_id`);

--
-- Indexes for table `usuarios_ads`
--
ALTER TABLE `usuarios_ads`
  ADD PRIMARY KEY (`usr_id`);

--
-- Indexes for table `Usuarios_Datos`
--
ALTER TABLE `Usuarios_Datos`
  ADD PRIMARY KEY (`ud_id`),
  ADD KEY `usr_id` (`usr_id`),
  ADD KEY `fk_tipo_dato2` (`td_id`),
  ADD KEY `fk_categoria_tipo_dato` (`ctd_id`);

--
-- Indexes for table `usuarios_datos_facturacion`
--
ALTER TABLE `usuarios_datos_facturacion`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `fk_country_fact` (`ctry_code`);

--
-- Indexes for table `Usuarios_Favoritos`
--
ALTER TABLE `Usuarios_Favoritos`
  ADD PRIMARY KEY (`usr_id`,`usr_favorito`),
  ADD KEY `fk_usuario2` (`usr_favorito`);

--
-- Indexes for table `Usuarios_Push`
--
ALTER TABLE `Usuarios_Push`
  ADD KEY `usr_id` (`usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesos`
--
ALTER TABLE `accesos`
  MODIFY `acc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `administradores`
--
ALTER TABLE `administradores`
  MODIFY `admin_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ads_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_aranceles`
--
ALTER TABLE `ads_aranceles`
  MODIFY `ads_ara_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_bloqueos`
--
ALTER TABLE `ads_bloqueos`
  MODIFY `ads_blo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_click`
--
ALTER TABLE `ads_click`
  MODIFY `ads_click_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_countrys`
--
ALTER TABLE `ads_countrys`
  MODIFY `ads_ctry_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_forms`
--
ALTER TABLE `ads_forms`
  MODIFY `ads_form_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_imagenes`
--
ALTER TABLE `ads_imagenes`
  MODIFY `ads_img_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_importes`
--
ALTER TABLE `ads_importes`
  MODIFY `ads_imp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_impresion`
--
ALTER TABLE `ads_impresion`
  MODIFY `ads_imp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ads_tipos`
--
ALTER TABLE `ads_tipos`
  MODIFY `ads_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Categoria_Tipo_Dato`
--
ALTER TABLE `Categoria_Tipo_Dato`
  MODIFY `ctd_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `City`
--
ALTER TABLE `City`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `click_contacto`
--
ALTER TABLE `click_contacto`
  MODIFY `cc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas`
--
ALTER TABLE `cobranzas`
  MODIFY `cob_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_comentarios`
--
ALTER TABLE `cobranzas_comentarios`
  MODIFY `cob_com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_comisiones`
--
ALTER TABLE `cobranzas_comisiones`
  MODIFY `cob_com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_documentos`
--
ALTER TABLE `cobranzas_documentos`
  MODIFY `cob_doc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_documentos_notas`
--
ALTER TABLE `cobranzas_documentos_notas`
  MODIFY `cob_doc_not_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_empresas`
--
ALTER TABLE `cobranzas_empresas`
  MODIFY `cob_emp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_empresas_tipos`
--
ALTER TABLE `cobranzas_empresas_tipos`
  MODIFY `cob_emp_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_otros_servicios`
--
ALTER TABLE `cobranzas_otros_servicios`
  MODIFY `cob_otro_serv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_pagos`
--
ALTER TABLE `cobranzas_pagos`
  MODIFY `cob_pago_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_pagos_comisiones`
--
ALTER TABLE `cobranzas_pagos_comisiones`
  MODIFY `cob_pago_com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_permisos`
--
ALTER TABLE `cobranzas_permisos`
  MODIFY `cob_per_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_permisos_acciones`
--
ALTER TABLE `cobranzas_permisos_acciones`
  MODIFY `cob_per_acc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_permisos_tipos`
--
ALTER TABLE `cobranzas_permisos_tipos`
  MODIFY `cob_per_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_productos`
--
ALTER TABLE `cobranzas_productos`
  MODIFY `cob_prod_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_productos_servicios`
--
ALTER TABLE `cobranzas_productos_servicios`
  MODIFY `cob_prod_serv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_seguros`
--
ALTER TABLE `cobranzas_seguros`
  MODIFY `cob_seg_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_transportes`
--
ALTER TABLE `cobranzas_transportes`
  MODIFY `cob_trans_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_usuarios`
--
ALTER TABLE `cobranzas_usuarios`
  MODIFY `cob_usr_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_usuarios_tipos`
--
ALTER TABLE `cobranzas_usuarios_tipos`
  MODIFY `cob_usr_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cobranzas_usuarios_tipos_empresas`
--
ALTER TABLE `cobranzas_usuarios_tipos_empresas`
  MODIFY `cob_usr_tipo_emp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `codigos_telefono`
--
ALTER TABLE `codigos_telefono`
  MODIFY `ct_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Comtrade`
--
ALTER TABLE `Comtrade`
  MODIFY `com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comtrade2`
--
ALTER TABLE `comtrade2`
  MODIFY `com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comtrade_crecimiento`
--
ALTER TABLE `comtrade_crecimiento`
  MODIFY `comc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comtrade_csv`
--
ALTER TABLE `comtrade_csv`
  MODIFY `csv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `errores`
--
ALTER TABLE `errores`
  MODIFY `err_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `errores_tipos`
--
ALTER TABLE `errores_tipos`
  MODIFY `err_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `excel`
--
ALTER TABLE `excel`
  MODIFY `exc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `facturas`
--
ALTER TABLE `facturas`
  MODIFY `fac_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Foro`
--
ALTER TABLE `Foro`
  MODIFY `foro_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foro_mensaje`
--
ALTER TABLE `foro_mensaje`
  MODIFY `forom_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foro_visitados`
--
ALTER TABLE `foro_visitados`
  MODIFY `fv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Mails`
--
ALTER TABLE `Mails`
  MODIFY `mail_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mails_info`
--
ALTER TABLE `mails_info`
  MODIFY `mi_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mails_para_publicidad`
--
ALTER TABLE `mails_para_publicidad`
  MODIFY `mpp_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `msj_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noreply`
--
ALTER TABLE `noreply`
  MODIFY `nr_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `not_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notificaciones_tipos`
--
ALTER TABLE `notificaciones_tipos`
  MODIFY `not_tipo_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos`
--
ALTER TABLE `pagos`
  MODIFY `pago_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos_actualizaciones`
--
ALTER TABLE `pagos_actualizaciones`
  MODIFY `pago_act_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pagos_suscripciones`
--
ALTER TABLE `pagos_suscripciones`
  MODIFY `pago_sus_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `palabras_usadas`
--
ALTER TABLE `palabras_usadas`
  MODIFY `pal_us_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `politicas`
--
ALTER TABLE `politicas`
  MODIFY `pol_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `politicas_tipos`
--
ALTER TABLE `politicas_tipos`
  MODIFY `pol_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_bancos`
--
ALTER TABLE `prices_bancos`
  MODIFY `banco_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_categorias`
--
ALTER TABLE `prices_categorias`
  MODIFY `cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_comercios`
--
ALTER TABLE `prices_comercios`
  MODIFY `com_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_comercios_codigos`
--
ALTER TABLE `prices_comercios_codigos`
  MODIFY `com_cod_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_comercios_descuentos`
--
ALTER TABLE `prices_comercios_descuentos`
  MODIFY `com_desc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_descuentos`
--
ALTER TABLE `prices_descuentos`
  MODIFY `desc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_descuentos_tipos`
--
ALTER TABLE `prices_descuentos_tipos`
  MODIFY `desc_tipo_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_devices`
--
ALTER TABLE `prices_devices`
  MODIFY `dev_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_encuestas`
--
ALTER TABLE `prices_encuestas`
  MODIFY `enc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_marcas`
--
ALTER TABLE `prices_marcas`
  MODIFY `marc_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_precios`
--
ALTER TABLE `prices_precios`
  MODIFY `pre_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_productos`
--
ALTER TABLE `prices_productos`
  MODIFY `prod_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_productos_usuarios`
--
ALTER TABLE `prices_productos_usuarios`
  MODIFY `prod_usr_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_rating`
--
ALTER TABLE `prices_rating`
  MODIFY `rat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_reportes`
--
ALTER TABLE `prices_reportes`
  MODIFY `rep_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_subcategorias`
--
ALTER TABLE `prices_subcategorias`
  MODIFY `sub_cat_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_tarjetas`
--
ALTER TABLE `prices_tarjetas`
  MODIFY `tarj_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_usuarios`
--
ALTER TABLE `prices_usuarios`
  MODIFY `usr_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prices_usuarios_tarjetas`
--
ALTER TABLE `prices_usuarios_tarjetas`
  MODIFY `usr_tarj_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Productos`
--
ALTER TABLE `Productos`
  MODIFY `prod_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos_imagenes`
--
ALTER TABLE `productos_imagenes`
  MODIFY `pi_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Productos_Mails`
--
ALTER TABLE `Productos_Mails`
  MODIFY `pm_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos_visitados`
--
ALTER TABLE `productos_visitados`
  MODIFY `pv_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referencias`
--
ALTER TABLE `referencias`
  MODIFY `ref_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supermercados`
--
ALTER TABLE `supermercados`
  MODIFY `super_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tipo_Datos`
--
ALTER TABLE `Tipo_Datos`
  MODIFY `td_id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tipo_Productos`
--
ALTER TABLE `Tipo_Productos`
  MODIFY `tp_id` int(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Tipo_Usuarios`
--
ALTER TABLE `Tipo_Usuarios`
  MODIFY `tu_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unsubscribes`
--
ALTER TABLE `unsubscribes`
  MODIFY `uns_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `usr_id` int(9) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Usuarios_Datos`
--
ALTER TABLE `Usuarios_Datos`
  MODIFY `ud_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `fk_ads_tipo` FOREIGN KEY (`ads_tipo_id`) REFERENCES `ads_tipos` (`ads_tipo_id`);

--
-- Constraints for table `ads_aranceles`
--
ALTER TABLE `ads_aranceles`
  ADD CONSTRAINT `fk_ads2` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`),
  ADD CONSTRAINT `fk_aranceles_ads` FOREIGN KEY (`ara_id`) REFERENCES `Aranceles` (`ara_id`);

--
-- Constraints for table `ads_bloqueos`
--
ALTER TABLE `ads_bloqueos`
  ADD CONSTRAINT `fk_ads_blo_user` FOREIGN KEY (`ads_blo_usr_id`) REFERENCES `Usuarios` (`usr_id`),
  ADD CONSTRAINT `fk_ads_blo_user2` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `ads_click`
--
ALTER TABLE `ads_click`
  ADD CONSTRAINT `fk_ads4` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`),
  ADD CONSTRAINT `fk_ads_users` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `ads_countrys`
--
ALTER TABLE `ads_countrys`
  ADD CONSTRAINT `fk_ads` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`),
  ADD CONSTRAINT `fk_country_ads` FOREIGN KEY (`ctry_code`) REFERENCES `Country` (`ctry_code`);

--
-- Constraints for table `ads_forms`
--
ALTER TABLE `ads_forms`
  ADD CONSTRAINT `fk_ads6` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`),
  ADD CONSTRAINT `fk_ads_users3` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `ads_imagenes`
--
ALTER TABLE `ads_imagenes`
  ADD CONSTRAINT `fk_ads3` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`);

--
-- Constraints for table `ads_impresion`
--
ALTER TABLE `ads_impresion`
  ADD CONSTRAINT `fk_ads5` FOREIGN KEY (`ads_id`) REFERENCES `ads` (`ads_id`),
  ADD CONSTRAINT `fk_ads_users2` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `Aranceles`
--
ALTER TABLE `Aranceles`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`cat_id`) REFERENCES `Categorias` (`cat_id`);

--
-- Constraints for table `Categorias`
--
ALTER TABLE `Categorias`
  ADD CONSTRAINT `fk_secccion` FOREIGN KEY (`sec_id`) REFERENCES `Secciones` (`sec_id`);

--
-- Constraints for table `Categoria_Tipo_Dato`
--
ALTER TABLE `Categoria_Tipo_Dato`
  ADD CONSTRAINT `fk_tipo_dato` FOREIGN KEY (`td_id`) REFERENCES `Tipo_Datos` (`td_id`);

--
-- Constraints for table `City`
--
ALTER TABLE `City`
  ADD CONSTRAINT `fk_country` FOREIGN KEY (`city_countryCode`) REFERENCES `Country` (`ctry_code`);

--
-- Constraints for table `comtrade_crecimiento`
--
ALTER TABLE `comtrade_crecimiento`
  ADD CONSTRAINT `fk_arancel3` FOREIGN KEY (`ara_id`) REFERENCES `Aranceles` (`ara_id`);

--
-- Constraints for table `Country`
--
ALTER TABLE `Country`
  ADD CONSTRAINT `fk_moneda` FOREIGN KEY (`cur_code`) REFERENCES `monedas` (`mon_code`);

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `fk_idioma2` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`);

--
-- Constraints for table `foro_mensaje`
--
ALTER TABLE `foro_mensaje`
  ADD CONSTRAINT `fk_foro` FOREIGN KEY (`foro_id`) REFERENCES `Foro` (`foro_id`);

--
-- Constraints for table `foro_visitados`
--
ALTER TABLE `foro_visitados`
  ADD CONSTRAINT `fk_foro2` FOREIGN KEY (`foro_id`) REFERENCES `Foro` (`foro_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario9` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Mails`
--
ALTER TABLE `Mails`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `mails_info`
--
ALTER TABLE `mails_info`
  ADD CONSTRAINT `fk_idioma3` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`),
  ADD CONSTRAINT `fk_mails_info_codigo` FOREIGN KEY (`mi_codigo`) REFERENCES `mails_info_codigo` (`mi_codigo`);

--
-- Constraints for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `fk_producto5` FOREIGN KEY (`prod_emisor`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_producto6` FOREIGN KEY (`prod_receptor`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario10` FOREIGN KEY (`usr_emisor`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario11` FOREIGN KEY (`usr_receptor`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `fk_usuario14` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `pagos_actualizaciones`
--
ALTER TABLE `pagos_actualizaciones`
  ADD CONSTRAINT `fk_pago` FOREIGN KEY (`pago_id`) REFERENCES `pagos` (`pago_id`),
  ADD CONSTRAINT `fk_pago_estado` FOREIGN KEY (`pago_est_id`) REFERENCES `pagos_estados` (`pago_est_id`);

--
-- Constraints for table `politicas`
--
ALTER TABLE `politicas`
  ADD CONSTRAINT `fk_pol_idioma` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`),
  ADD CONSTRAINT `fk_pol_tipo` FOREIGN KEY (`pol_tipo_id`) REFERENCES `politicas_tipos` (`pol_tipo_id`);

--
-- Constraints for table `prices_comercios_codigos`
--
ALTER TABLE `prices_comercios_codigos`
  ADD CONSTRAINT `fk_prod_id_comercios_codigos` FOREIGN KEY (`prod_id`) REFERENCES `prices_productos` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `prices_descuentos`
--
ALTER TABLE `prices_descuentos`
  ADD CONSTRAINT `fk_banco_id_prices_descuentos` FOREIGN KEY (`banco_id`) REFERENCES `prices_bancos` (`banco_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_tarj_id_prices_descuentos` FOREIGN KEY (`tarj_id`) REFERENCES `prices_tarjetas` (`tarj_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_usr_id_prices_descuentos` FOREIGN KEY (`usr_id`) REFERENCES `prices_usuarios` (`usr_id`) ON DELETE SET NULL;

--
-- Constraints for table `prices_devices`
--
ALTER TABLE `prices_devices`
  ADD CONSTRAINT `fk_usr_id_prices_devices` FOREIGN KEY (`usr_id`) REFERENCES `prices_usuarios` (`usr_id`);

--
-- Constraints for table `prices_precios`
--
ALTER TABLE `prices_precios`
  ADD CONSTRAINT `fk_com_id_prices_precios` FOREIGN KEY (`com_id`) REFERENCES `prices_comercios` (`com_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_desc_id_prices_precios` FOREIGN KEY (`desc_id`) REFERENCES `prices_descuentos` (`desc_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_mon_code_prices_precios` FOREIGN KEY (`mon_code`) REFERENCES `monedas` (`mon_code`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_prod_id_prices_precios` FOREIGN KEY (`prod_id`) REFERENCES `prices_productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usr_id_prices_precios` FOREIGN KEY (`usr_id`) REFERENCES `prices_usuarios` (`usr_id`) ON DELETE SET NULL;

--
-- Constraints for table `prices_productos`
--
ALTER TABLE `prices_productos`
  ADD CONSTRAINT `fk_marca_producto` FOREIGN KEY (`marc_id`) REFERENCES `prices_marcas` (`marc_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sub_cat_id_producto` FOREIGN KEY (`sub_cat_id`) REFERENCES `prices_subcategorias` (`sub_cat_id`) ON DELETE SET NULL;

--
-- Constraints for table `prices_rating`
--
ALTER TABLE `prices_rating`
  ADD CONSTRAINT `fk_rating_producto` FOREIGN KEY (`prod_id`) REFERENCES `prices_productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_rating_usuario` FOREIGN KEY (`usr_id`) REFERENCES `prices_usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `prices_subcategorias`
--
ALTER TABLE `prices_subcategorias`
  ADD CONSTRAINT `fk_cat_id_prices_subcategorias` FOREIGN KEY (`cat_id`) REFERENCES `prices_categorias` (`cat_id`) ON DELETE CASCADE;

--
-- Constraints for table `prices_usuarios`
--
ALTER TABLE `prices_usuarios`
  ADD CONSTRAINT `fk_ctry_code_prices_usuarios` FOREIGN KEY (`ctry_code`) REFERENCES `Country` (`ctry_code`),
  ADD CONSTRAINT `fk_idi_code_prices_usuarios` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`);

--
-- Constraints for table `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `fk_arancel` FOREIGN KEY (`ara_id`) REFERENCES `Aranceles` (`ara_id`),
  ADD CONSTRAINT `fk_country_prod` FOREIGN KEY (`ctry_code`) REFERENCES `Country` (`ctry_code`),
  ADD CONSTRAINT `fk_tipo_producto` FOREIGN KEY (`tp_id`) REFERENCES `Tipo_Productos` (`tp_id`),
  ADD CONSTRAINT `fk_usuario3` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Productos_Favoritos`
--
ALTER TABLE `Productos_Favoritos`
  ADD CONSTRAINT `fk_producto` FOREIGN KEY (`prod_id`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario4` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `Productos_Idiomas`
--
ALTER TABLE `Productos_Idiomas`
  ADD CONSTRAINT `fk_idiomas` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`),
  ADD CONSTRAINT `fk_producto3` FOREIGN KEY (`prod_id`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `productos_imagenes`
--
ALTER TABLE `productos_imagenes`
  ADD CONSTRAINT `fk_imagen` FOREIGN KEY (`prod_id`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `Productos_Mails`
--
ALTER TABLE `Productos_Mails`
  ADD CONSTRAINT `fk_producto2` FOREIGN KEY (`prod_id`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `productos_visitados`
--
ALTER TABLE `productos_visitados`
  ADD CONSTRAINT `fk_producto4` FOREIGN KEY (`prod_id`) REFERENCES `Productos` (`prod_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario8` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `referencias`
--
ALTER TABLE `referencias`
  ADD CONSTRAINT `fk_usuario12` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD CONSTRAINT `fk_idioma` FOREIGN KEY (`idi_code`) REFERENCES `Idiomas` (`idi_code`),
  ADD CONSTRAINT `fk_tipo` FOREIGN KEY (`tu_id`) REFERENCES `Tipo_Usuarios` (`tu_id`);

--
-- Constraints for table `usuarios_ads`
--
ALTER TABLE `usuarios_ads`
  ADD CONSTRAINT `fk_usuario13` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Usuarios_Datos`
--
ALTER TABLE `Usuarios_Datos`
  ADD CONSTRAINT `fk_categoria_tipo_dato` FOREIGN KEY (`ctd_id`) REFERENCES `Categoria_Tipo_Dato` (`ctd_id`),
  ADD CONSTRAINT `fk_tipo_dato2` FOREIGN KEY (`td_id`) REFERENCES `Tipo_Datos` (`td_id`),
  ADD CONSTRAINT `fk_usuario5` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);

--
-- Constraints for table `usuarios_datos_facturacion`
--
ALTER TABLE `usuarios_datos_facturacion`
  ADD CONSTRAINT `fk_country_fact` FOREIGN KEY (`ctry_code`) REFERENCES `Country` (`ctry_code`),
  ADD CONSTRAINT `fk_usuario15` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Usuarios_Favoritos`
--
ALTER TABLE `Usuarios_Favoritos`
  ADD CONSTRAINT `fk_usuario2` FOREIGN KEY (`usr_favorito`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario6` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`) ON DELETE CASCADE;

--
-- Constraints for table `Usuarios_Push`
--
ALTER TABLE `Usuarios_Push`
  ADD CONSTRAINT `fk_usuario7` FOREIGN KEY (`usr_id`) REFERENCES `Usuarios` (`usr_id`);