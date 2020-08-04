<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cobranzas extends CI_Controller {

	private static $solapa = "cobranzas";

	public function __construct()
	{
		parent::__construct();

		$this->config->set_item('language', $this->session->userdata('idi_code'));
		date_default_timezone_set('America/Argentina/Buenos_Aires');

		$this->load->model('idiomas_model');
		$this->load->model('paises_model');
		$this->load->model('resultados_model');
		$this->load->model('productos_model');
		$this->load->model('user_model');
		$this->load->model('aranceles_model');
		$this->load->model('favoritos_model');
		$this->load->model('cobranzas_model');
		$this->load->model('palabras_model');
		$this->load->model('Common_model');
		$this->load->model('mensajes_model');
		$this->load->model('mails_info_model');
		
		$this->load->view('templates/validate_login');
	}

	public function index()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/index', $data);
	}

	public function options()
	{
		$data['solapa'] = self::$solapa;

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$this->load->view(self::$solapa.'/options', $data);
	}

	public function user_type()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));

		if($this->input->post())
		{
			$this->form_validation->set_rules('type','Type','required');

			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/user_type', $data);
			}
			else
			{				
				$this->session->set_userdata('type', $this->input->post('type'));
				
				redirect(self::$solapa.'/addOperation');
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/user_type', $data);
		}
	}

	public function user_type_invite($operation_id = FALSE, $operation_code = FALSE)
	{
		if($operation_id == FALSE)
		{
			redirect(self::$solapa.'/dashboard');
		}

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['operations'] = $this->cobranzas_model->get_items(FALSE, $operation_id);
		if($data['operations']['cob_codigo'] != $operation_code)
		{
			redirect(self::$solapa.'/dashboard');
		}

		$data['user_details'] = $this->cobranzas_model->get_item_usuarios($data['operations']['cob_id'], $this->session->userdata('usr_id'));
		if($data['user_details'])
		{
			redirect(self::$solapa.'/beginOperation/'.$data['operations']['cob_id']);
		}

		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos'] as $key_usr => $tipo)
		{
			$data['tipos'][$key_usr]['usuario'] = $this->cobranzas_model->get_item_usuario_x_tipo($data['operations']['cob_id'], $tipo['cob_usr_tipo_id']);
			//$data['tipos'][$key_usr]['empresas'] = $this->cobranzas_model->get_cobranza_tipo_empresas_x_tipo_usuario($this->session->userdata('idi_code'), $id, $tipo['cob_usr_tipo_id']);
		}
		/*
		$data['usuarios'] = array();
		$data['usuarios'][] = $this->cobranzas_model->get_item_usuario_x_tipo($data['operations']['cob_id'], COBRANZA_USUARIO_TIPO_1);
		$data['usuarios'][] = $this->cobranzas_model->get_item_usuario_x_tipo($data['operations']['cob_id'], COBRANZA_USUARIO_TIPO_2);
		$data['usuarios'][] = $this->cobranzas_model->get_item_usuario_x_tipo($data['operations']['cob_id'], COBRANZA_USUARIO_TIPO_3);
		*/
		if($this->input->post())
		{
			$this->form_validation->set_rules('type','Type','required');

			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/user_type_invite', $data);
			}
			else
			{
				$result = $this->cobranzas_model->set_usuario($data['operations']['cob_id'], $this->session->userdata('usr_id'), $this->input->post('type'));
				//$result = FALSE;
				if($result)
				{
					$this->session->set_flashdata('success', 'Te uniste a la operacion de cobranza documentaria.');

					redirect(self::$solapa.'/beginOperation/'.$data['operations']['cob_id']);
				}
				else
				{
					$this->session->set_flashdata('error', 'Ocurrio un error al unirte.');

					$this->load->view(self::$solapa.'/user_type_invite', $data);
				}
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/user_type_invite', $data);
		}
	}


	public function dashboard()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['operation'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'));
		$data['estados'] = $this->cobranzas_model->get_estados();

		$this->load->view(self::$solapa.'/dashboard', $data);
	}

	public function addOperation()
	{
		$this->load->helper('formulariocobranza');

		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		//$data['operation'] = $this->db->get_where('user_operation',array('user_id'=>$this->session->userdata('usr_id')))->result_array();
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos'] as $key => $tipo)
		{
			//$data['tipos'][$key]['usuario'] = $this->cobranzas_model->get_item_usuario_x_tipo($id, $tipo['cob_usr_tipo_id']);
		}
		$data['monedas'] = $this->paises_model->get_monedas($this->session->userdata('idi_code'));
		
		if($this->input->post())
		{
			if($this->input->post('tyc') != "")
			{
				$this->form_validation->set_rules('name','Name','required|trim');
				if($this->form_validation->run()===FALSE)
				{
					$this->session->set_flashdata('error', validation_errors());
				}
				else
				{				
					$cob_id = $this->cobranzas_model->set_item($this->session->userdata('usr_id'), $this->input->post('name'), $this->input->post('description'), COBRANZA_ESTADO_INICIADO, $this->gen_uuid(), $this->input->post('detalle_documentacion'), $this->input->post('acciones_requeridas'), $this->input->post('moneda'));
					if($cob_id)
					{
						$cob_usr_id = $this->cobranzas_model->set_usuario($cob_id, $this->session->userdata('usr_id'), $this->session->userdata('type'));
						
						$this->session->set_flashdata('success','Operation Added Successfully !');
						redirect(self::$solapa.'/beginOperation/'.$cob_id);
					}
					else
					{
						$this->session->set_flashdata('error','Something went wrong. Please try again later !');
						redirect(self::$solapa.'/dashboard');
					}
					
				}
			}
			else
			{
				$this->session->set_flashdata('error','Debe aceptar los terminos y condiciones !');
			}
		}
		
		$this->load->view(self::$solapa.'/addOperation', $data);
	}


	public function joinOperation()
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		//$data['operation'] = $this->db->get_where('user_operation',array('user_id'=>$this->session->userdata('usr_id')))->result_array();
		
		if($this->input->post())
		{
			$this->form_validation->set_rules('codigo', mostrar_palabra(671, $data['palabras']), 'required|trim');
			
			if($this->form_validation->run()===FALSE)
			{
				$this->session->set_flashdata('error', validation_errors());
			}
			else
			{				
				$cobranza = $this->cobranzas_model->get_item_x_codigo($this->input->post('codigo'));
				if($cobranza)
				{
					redirect(self::$solapa.'/user_type_invite/'.$cobranza['cob_id'].'/'.$this->input->post('codigo'));
				}
				else
				{
					$this->session->set_flashdata('error','El codigo ingresado no pertenece a ninguna operacion en curso !');
				}
				
			}
		}

		$this->load->view(self::$solapa.'/joinOperation', $data);
	}


	public function editOperation($id = FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|trim');
			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/editOperation', $data);
			}
			else
			{
				$update = $this->cobranzas_model->update_item($id, $this->input->post('name'), $this->input->post('description'));
				
				if($update)
				{
					$this->session->set_flashdata('success','Operation Updated Successfully !');
					redirect(self::$solapa.'/dashboard');
				}
				else
				{
					$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
					redirect(self::$solapa.'/dashboard');
				}
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/editOperation', $data);
		}

	}


	public function deleteOperation($id=FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$result = $this->cobranzas_model->delete_item($id);
		if($result)
		{
			$this->session->set_flashdata('success', 'Operation deleted successfully.');
		}
		else
		{
			$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
		}
		
		redirect(self::$solapa.'/dashboard');
	}
	

	public function beginOperation($id=FALSE)
	{
		$this->load->helper('formulariocobranza');
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['estados'] = $this->cobranzas_model->get_estados();
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos'] as $key_usr => $tipo)
		{
			$data['tipos'][$key_usr]['usuario'] = $this->cobranzas_model->get_item_usuario_x_tipo($id, $tipo['cob_usr_tipo_id']);
			$data['tipos'][$key_usr]['empresas'] = $this->cobranzas_model->get_cobranza_tipo_empresas_x_tipo_usuario($this->session->userdata('idi_code'), $id, $tipo['cob_usr_tipo_id']);
		}

		if($this->input->post())
		{
			foreach($data['tipos'] as $key_usr => $tipo)
			{
				/*
				$cant_empresas = 0;
				if($key_usr == 0)
				{
					$cant_empresas = 4;
				}
				elseif($key_usr == 1)
				{
					$cant_empresas = 5;
				}
				elseif($key_usr == 2)
				{
					$cant_empresas = 3;
				}
				elseif($key_usr == 3)
				{
					$cant_empresas = 5;
				}
				*/
				foreach($tipo['empresas'] as $key_emp => $empresa)
				{
					//CHECKEO LOS PERMISOS PARA EDITAR
					$permiso_editar = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $id, $empresa['cob_emp_tipo_id'], $data['operations']['cob_usr_tipo_id'], 3);
					if($permiso_editar && $permiso_editar['cob_per_activo'] == 1)
					{
						if($this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_id') != "")
						{
							if($this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_1') != "")
							{
								// echo $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_1').'-';
								// echo $id.' '.$empresa['cob_emp_tipo_id'].' '.$data['operations']['cob_usr_tipo_id'];
								// echo '<br>';
								//die();
								// UPDATE
								$result = $this->cobranzas_model->update_empresa($this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_id'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_1'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_2'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_3'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_4'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_5'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_6'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_7'));
							}
							else
							{
								// DELETE
								$result = $this->cobranzas_model->delete_empresa($this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_id'));
							}
						}
						else
						{
							if($this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_1') != "")
							{
								// INSERT
								$result = $this->cobranzas_model->set_empresa($id, $tipo['cob_usr_tipo_id'], $empresa['cob_emp_tipo_id'], $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_1'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_2'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_3'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_4'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_5'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_6'), $this->input->post('usr_'.($key_usr+1).'_emp_'.($key_emp+1).'_item_7'));
							}
						}
					}
				}
				//die();
			}

			$aranceles = $this->input->post('arancel_id[]');
			if($aranceles)
			{
				$producto_id = $this->input->post('producto_id[]');
				$producto_val1 = $this->input->post('producto_val1[]');
				$producto_val2 = $this->input->post('producto_val2[]');
				$producto_val3 = $this->input->post('producto_val3[]');
				$producto_val4 = $this->input->post('producto_val4[]');
				$producto_val5 = $this->input->post('producto_val5[]');
				$producto_val6 = $this->input->post('producto_val6[]');
				$pais = $this->input->post('pais[]');
				$ciudad = $this->input->post('ciudad[]');
				$producto_val9 = $this->input->post('producto_val9[]');
				$moneda = $this->input->post('moneda[]');
				$producto_subtotal = $this->input->post('producto_subtotal[]');

				foreach ($aranceles as $key_ara => $ara_id)
				{
					$cob_prod_id = FALSE;

					if($producto_id[$key_ara] != "")
					{
						if($ara_id != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_producto($producto_id[$key_ara], $ara_id, $producto_val1[$key_ara], $producto_val2[$key_ara], $producto_val3[$key_ara], $producto_val4[$key_ara], $producto_val5[$key_ara], $producto_val6[$key_ara], $pais[$key_ara], $ciudad[$key_ara], $producto_val9[$key_ara], $moneda[$key_ara], $producto_subtotal[$key_ara]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_producto($producto_id[$key_ara]);
						}

						$cob_prod_id = $producto_id[$key_ara];
					}
					else
					{
						if($ara_id != "")
						{
							//INSERT
							$cob_prod_id = $this->cobranzas_model->set_producto($id, $ara_id, $producto_val1[$key_ara], $producto_val2[$key_ara], $producto_val3[$key_ara], $producto_val4[$key_ara], $producto_val5[$key_ara], $producto_val6[$key_ara], $pais[$key_ara], $ciudad[$key_ara], $producto_val9[$key_ara], $moneda[$key_ara], $producto_subtotal[$key_ara]);
						}
					}

					if($cob_prod_id)
					{
						// SERVICIOS DEL PRODUCTO
						$producto_servicios_val1 = $this->input->post('producto'.$key_ara.'_servicios_val1[]');
						if($producto_servicios_val1)
						{
							$producto_servicios_id = $this->input->post('producto'.$key_ara.'_servicios_id[]');
							$producto_servicios_arancel = $this->input->post('producto'.$key_ara.'_servicios_ara_id[]');
							$producto_servicios_val1 = $this->input->post('producto'.$key_ara.'_servicios_val1[]');
							$producto_servicios_val2 = $this->input->post('producto'.$key_ara.'_servicios_val2[]');
							$producto_servicios_val3 = $this->input->post('producto'.$key_ara.'_servicios_val3[]');
							$producto_servicios_moneda = $this->input->post('producto'.$key_ara.'_servicios_moneda[]');
							$producto_servicios_val4 = $this->input->post('producto'.$key_ara.'_servicios_val4[]');
							
							foreach ($producto_servicios_val1 as $key => $value)
							{
								if($producto_servicios_id[$key] != "")
								{
									if($producto_servicios_val1[$key] != "")
									{
										//UPDATE
										$update_result = $this->cobranzas_model->update_producto_servicio($producto_servicios_id[$key], $producto_servicios_arancel[$key], $producto_servicios_val1[$key], $producto_servicios_val2[$key], $producto_servicios_val3[$key], $producto_servicios_moneda[$key], $producto_servicios_val4[$key]);
									}
									else
									{
										//DELETE
										$delete_result = $this->cobranzas_model->delete_producto_servicio($producto_servicios_id[$key]);
									}
								}
								else
								{
									if($producto_servicios_val1[$key] != "")
									{
										//INSERT
										$cob_prod_serv_id = $this->cobranzas_model->set_producto_servicio($cob_prod_id, $producto_servicios_arancel[$key], $producto_servicios_val1[$key], $producto_servicios_val2[$key], $producto_servicios_val3[$key], $producto_servicios_moneda[$key], $producto_servicios_val4[$key]);
									}
								}
							}
						}
					}
				}
			}

			// OTROS SERVICIOS
			$otros_servicios_val1 = $this->input->post('otros_servicios_val1[]');
			if($otros_servicios_val1)
			{
				$otros_servicios_id = $this->input->post('otros_servicios_id[]');
				$otros_servicios_val1 = $this->input->post('otros_servicios_val1[]');
				$otros_servicios_val2 = $this->input->post('otros_servicios_val2[]');
				$otros_servicios_val3 = $this->input->post('otros_servicios_val3[]');
				$otros_servicios_val4 = $this->input->post('otros_servicios_val4[]');
				$otros_servicios_val5 = $this->input->post('otros_servicios_val5[]');
				$otros_servicios_val6 = $this->input->post('otros_servicios_val6[]');
				$otros_servicios_val7 = $this->input->post('otros_servicios_val7[]');

				foreach ($otros_servicios_val1 as $key => $value)
				{
					if($otros_servicios_id[$key] != "")
					{
						if($otros_servicios_val1[$key] != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_otro_servicio($otros_servicios_id[$key], $otros_servicios_val1[$key], $otros_servicios_val2[$key], formatear_fecha($otros_servicios_val3[$key],1), $otros_servicios_val4[$key], $otros_servicios_val5[$key], $otros_servicios_val6[$key], $otros_servicios_val7[$key]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_otro_servicio($otros_servicios_id[$key]);
						}
					}
					else
					{
						if($otros_servicios_val1[$key] != "")
						{
							//INSERT
							$cob_otro_serv_id = $this->cobranzas_model->set_otro_servicio($id, $otros_servicios_val1[$key], $otros_servicios_val2[$key], formatear_fecha($otros_servicios_val3[$key],1), $otros_servicios_val4[$key], $otros_servicios_val5[$key], $otros_servicios_val6[$key], $otros_servicios_val7[$key]);
						}
					}
				}
			}

			// TRANSPORTE
			$transporte_val2 = $this->input->post('transportes_val2[]');
			if($transporte_val2)
			{
				$transporte_id = $this->input->post('transportes_id[]');
				$transporte_val1 = $this->input->post('transportes_val1[]');
				$transporte_val2 = $this->input->post('transportes_val2[]');
				$transporte_val3 = $this->input->post('transportes_val3[]');
				$transporte_val4 = $this->input->post('transportes_val4[]');
				$transporte_val5 = $this->input->post('transportes_val5[]');
				$transporte_val6 = $this->input->post('transportes_val6[]');
				$transporte_val7 = $this->input->post('transportes_val7[]');
				$transporte_val8 = $this->input->post('transportes_val8[]');
				$transporte_val9 = $this->input->post('transportes_val9[]');
				$transporte_val10 = $this->input->post('transportes_val10[]');
				$transporte_val11 = $this->input->post('transportes_val11[]');
				$transporte_val12 = $this->input->post('transportes_val12[]');
				$transporte_val13 = $this->input->post('transportes_val13[]');

				foreach ($transporte_val2 as $key => $value)
				{
					if($transporte_id[$key] != "")
					{
						if($transporte_val2[$key] != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_transporte($transporte_id[$key], $transporte_val1[$key], $transporte_val2[$key], $transporte_val3[$key], $transporte_val4[$key], $transporte_val5[$key], $transporte_val6[$key], formatear_fecha($transporte_val7[$key],1), formatear_fecha($transporte_val8[$key],1), $transporte_val9[$key], $transporte_val10[$key], $transporte_val11[$key], $transporte_val12[$key], $transporte_val13[$key]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_transporte($transporte_id[$key]);
						}
					}
					else
					{
						if($transporte_val2[$key] != "")
						{
							//INSERT
							$cob_trans_id = $this->cobranzas_model->set_transporte($id, $transporte_val1[$key], $transporte_val2[$key], $transporte_val3[$key], $transporte_val4[$key], $transporte_val5[$key], $transporte_val6[$key], formatear_fecha($transporte_val7[$key],1), formatear_fecha($transporte_val8[$key],1), $transporte_val9[$key], $transporte_val10[$key], $transporte_val11[$key], $transporte_val12[$key], $transporte_val13[$key]);
						}
					}
				}
			}

			// SEGUROS
			$seguros_val1 = $this->input->post('seguros_val1[]');
			if($seguros_val1)
			{
				$seguros_id = $this->input->post('seguros_id[]');
				$seguros_val1 = $this->input->post('seguros_val1[]');
				$seguros_val2 = $this->input->post('seguros_val2[]');
				$seguros_val3 = $this->input->post('seguros_val3[]');
				$seguros_val4 = $this->input->post('seguros_val4[]');
				$seguros_val5 = $this->input->post('seguros_val5[]');
				$seguros_val6 = $this->input->post('seguros_val6[]');
				$seguros_val7 = $this->input->post('seguros_val7[]');
				$seguros_val8 = $this->input->post('seguros_val8[]');
				$seguros_val9 = $this->input->post('seguros_val9[]');
				$seguros_val10 = $this->input->post('seguros_val10[]');
				$seguros_val11 = $this->input->post('seguros_val11[]');
				$seguros_val12 = $this->input->post('seguros_val12[]');
				$seguros_val13 = $this->input->post('seguros_val13[]');

				foreach ($seguros_val1 as $key => $value)
				{
					if($seguros_id[$key] != "")
					{
						if($seguros_val1[$key] != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_seguro($seguros_id[$key], $seguros_val1[$key], $seguros_val2[$key], formatear_fecha($seguros_val3[$key],1), $seguros_val4[$key], $seguros_val5[$key], $seguros_val6[$key], $seguros_val7[$key], $seguros_val8[$key], $seguros_val9[$key], $seguros_val10[$key], $seguros_val11[$key], $seguros_val12[$key], $seguros_val13[$key]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_seguro($seguros_id[$key]);
						}
					}
					else
					{
						if($seguros_val1[$key] != "")
						{
							//INSERT
							$cob_seg_id = $this->cobranzas_model->set_seguro($id, $seguros_val1[$key], $seguros_val2[$key], formatear_fecha($seguros_val3[$key],1), $seguros_val4[$key], $seguros_val5[$key], $seguros_val6[$key], $seguros_val7[$key], $seguros_val8[$key], $seguros_val9[$key], $seguros_val10[$key], $seguros_val11[$key], $seguros_val12[$key], $seguros_val13[$key]);
						}
					}
				}
			}

			// COMISIONES
			$comision = $this->cobranzas_model->get_comision($this->session->userdata('idi_code'), $id);
			if($comision)
			{
				//UPDATE
				$update_result = $this->cobranzas_model->update_comision($comision['cob_com_id'], $this->input->post('comision_calculo'), $this->input->post('comision_chk1'), $this->input->post('comision_chk2'), $this->input->post('comision_chk3'), $this->input->post('comision_chk4'), $this->input->post('comision_suma'), $this->input->post('comision_importe'), $this->input->post('comision_total'));
			}
			else
			{
				//INSERT
				$cob_seg_id = $this->cobranzas_model->set_comision($id, $this->input->post('comision_calculo'), $this->input->post('comision_chk1'), $this->input->post('comision_chk2'), $this->input->post('comision_chk3'), $this->input->post('comision_chk4'), $this->input->post('comision_suma'), $this->input->post('comision_importe'), $this->input->post('comision_total'));
			}

			// PAGOS
			$pagos_val1 = $this->input->post('pagos_val1[]');
			if($pagos_val1)
			{
				$pagos_id = $this->input->post('pagos_id[]');
				$pagos_val1 = $this->input->post('pagos_val1[]');
				$pagos_val2 = $this->input->post('pagos_val2[]');
				$pagos_val3 = $this->input->post('pagos_val3[]');
				$pagos_val4 = $this->input->post('pagos_val4[]');
				$pagos_val5 = $this->input->post('pagos_val5[]');
				$pagos_val6 = $this->input->post('pagos_val6[]');
				$pagos_val7 = $this->input->post('pagos_val7[]');
				$pagos_val8 = $this->input->post('pagos_val8[]');
				$pagos_val9 = $this->input->post('pagos_val9[]');

				foreach ($pagos_val1 as $key => $value)
				{
					if($pagos_id[$key] != "")
					{
						if($pagos_val1[$key] != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_pago($pagos_id[$key], $pagos_val1[$key], formatear_fecha($pagos_val2[$key],1), $pagos_val3[$key], $pagos_val4[$key], $pagos_val5[$key], $pagos_val6[$key], $pagos_val7[$key], $pagos_val8[$key], $pagos_val9[$key]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_pago($pagos_id[$key]);
						}
					}
					else
					{
						if($pagos_val1[$key] != "")
						{
							//INSERT
							$cob_pago_id = $this->cobranzas_model->set_pago($id, $pagos_val1[$key], formatear_fecha($pagos_val2[$key],1), $pagos_val3[$key], $pagos_val4[$key], $pagos_val5[$key], $pagos_val6[$key], $pagos_val7[$key], $pagos_val8[$key], $pagos_val9[$key]);
						}
					}
				}
			}

			// PAGOS
			$pagos_comisiones_val1 = $this->input->post('pagos_comisiones_val1[]');
			if($pagos_comisiones_val1)
			{
				$pagos_comisiones_id = $this->input->post('pagos_comisiones_id[]');
				$pagos_comisiones_val1 = $this->input->post('pagos_comisiones_val1[]');
				$pagos_comisiones_val2 = $this->input->post('pagos_comisiones_val2[]');
				$pagos_comisiones_val3 = $this->input->post('pagos_comisiones_val3[]');
				$pagos_comisiones_val4 = $this->input->post('pagos_comisiones_val4[]');
				$pagos_comisiones_val5 = $this->input->post('pagos_comisiones_val5[]');
				$pagos_comisiones_val6 = $this->input->post('pagos_comisiones_val6[]');
				$pagos_comisiones_val7 = $this->input->post('pagos_comisiones_val7[]');
				$pagos_comisiones_val8 = $this->input->post('pagos_comisiones_val8[]');
				$pagos_comisiones_val9 = $this->input->post('pagos_comisiones_val9[]');

				foreach ($pagos_comisiones_val1 as $key => $value)
				{
					if($pagos_comisiones_id[$key] != "")
					{
						if($pagos_comisiones_val1[$key] != "")
						{
							//UPDATE
							$update_result = $this->cobranzas_model->update_pago_comisiones($pagos_comisiones_id[$key], $pagos_comisiones_val1[$key], formatear_fecha($pagos_comisiones_val2[$key],1), $pagos_comisiones_val3[$key], $pagos_comisiones_val4[$key], $pagos_comisiones_val5[$key], $pagos_comisiones_val6[$key], $pagos_comisiones_val7[$key], $pagos_comisiones_val8[$key], $pagos_comisiones_val9[$key]);
						}
						else
						{
							//DELETE
							$delete_result = $this->cobranzas_model->delete_pago_comisiones($pagos_comisiones_id[$key]);
						}
					}
					else
					{
						if($pagos_comisiones_val1[$key] != "")
						{
							//INSERT
							$cob_pago_id = $this->cobranzas_model->set_pago_comisiones($id, $pagos_comisiones_val1[$key], formatear_fecha($pagos_comisiones_val2[$key],1), $pagos_comisiones_val3[$key], $pagos_comisiones_val4[$key], $pagos_comisiones_val5[$key], $pagos_comisiones_val6[$key], $pagos_comisiones_val7[$key], $pagos_comisiones_val8[$key], $pagos_comisiones_val9[$key]);
						}
					}
				}
			}

			$this->cobranzas_model->update_fecha($id);

			$usuarios_notif = $this->cobranzas_model->get_item_usuarios($id);
			if($usuarios_notif)
			{
				$cobranza_datos = $this->cobranzas_model->get_items(FALSE, $this->input->post('cob_id'));
				$mensaje = "El usuario ".$this->session->userdata('usr_mail')." realizo modificaciones sobre la operacion de cobranza documentaria ".$cobranza_datos['cob_nombre'];
        		$link = self::$solapa.'/dashboard';

				foreach ($usuarios_notif as $key => $usuario)
				{
					if($usuario['usr_id'] != $this->session->userdata('usr_id'))
					{
						$this->notificaciones_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], NULL, NULL, NOTIFICACION_COBRANZA_MODIFICACION, NOTI_ESTADO_PENDIENTE, $id, $mensaje, $link);
					}
				}
			}

			$this->session->set_flashdata('success','Operation saved Successfully !');
			redirect(self::$solapa.'/dashboard');
		}

		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
		$data['monedas'] = $this->paises_model->get_monedas($this->session->userdata('idi_code'));
		$data['productos'] = $this->cobranzas_model->get_productos($this->session->userdata('idi_code'), $id);
		foreach ($data['productos'] as $key => $value)
		{
			$data['productos'][$key]['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'), $value['ctry_code']);
			$data['productos'][$key]['servicios'] = $this->cobranzas_model->get_producto_servicios($this->session->userdata('idi_code'), $value['cob_prod_id']);
		}
		$data['otros_servicios'] = $this->cobranzas_model->get_otros_servicios($this->session->userdata('idi_code'), $id);
		$data['transportes'] = $this->cobranzas_model->get_transportes($this->session->userdata('idi_code'), $id);
		$data['seguros'] = $this->cobranzas_model->get_seguros($this->session->userdata('idi_code'), $id);
		$data['comision'] = $this->cobranzas_model->get_comision($this->session->userdata('idi_code'), $id);
		if(!$data['comision'])
		{
			$data['comision'] = array('cob_com_calculo' => 1, 'cob_com_calculo_productos' => 0, 'cob_com_calculo_servicios' => 0, 'cob_com_calculo_transporte' => 0, 'cob_com_calculo_seguros' => 0, 'cob_com_calculo_suma' => 0, 'cob_com_importe' => 0, 'cob_com_total' => 0);
		}
		$data['pagos'] = $this->cobranzas_model->get_pagos($this->session->userdata('idi_code'), $id);
		$data['pagos_comisiones'] = $this->cobranzas_model->get_pagos_comisiones($this->session->userdata('idi_code'), $id);
		foreach ($data['tipos'] as $key_usr => $tipo)
		{
			$data['tipos'][$key_usr]['empresas'] = $this->cobranzas_model->get_cobranza_tipo_empresas_x_tipo_usuario($this->session->userdata('idi_code'), $id, $tipo['cob_usr_tipo_id']);
		}
		
		$this->load->view(self::$solapa.'/beginOperation/beginOperation', $data);
	}

	public function viewOperation($id=FALSE)
	{
		$this->load->helper('formulariocobranza');
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['estados'] = $this->cobranzas_model->get_estados();
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos'] as $key => $tipo)
		{
			$data['tipos'][$key]['usuario'] = $this->cobranzas_model->get_item_usuario_x_tipo($id, $tipo['cob_usr_tipo_id']);
			/*
			$data['tipos'][$key]['tipos_campos_padres'] = $this->cobranzas_model->get_campos_tipos_padre_x_tipo_usuario($this->session->userdata('idi_code'), $tipo['cob_usr_tipo_id']);
			foreach ($data['tipos'][$key]['tipos_campos_padres'] as $key_tipo_padre => $tipo_campo_padre)
			{
				$data['tipos'][$key]['tipos_campos_padres'][$key_tipo_padre]['tipos_campos'] = $this->cobranzas_model->get_campos_tipos_x_tipo_usuario_y_padre($this->session->userdata('idi_code'), $tipo['cob_usr_tipo_id'], $tipo_campo_padre['cob_camp_tipo_id']);
				foreach ($data['tipos'][$key]['tipos_campos_padres'][$key_tipo_padre]['tipos_campos'] as $key_tipo => $tipo_campo)
				{
					$data['tipos'][$key]['tipos_campos_padres'][$key_tipo_padre]['tipos_campos'][$key_tipo]['campos'] = $this->cobranzas_model->get_campos_x_tipo($this->session->userdata('idi_code'), $tipo_campo['cob_camp_tipo_id'], $tipo['cob_usr_tipo_id']);
				}
			}
			*/
		}
		/*
		$data['otros_tipos_campos'] = $this->cobranzas_model->get_campos_tipos_x_tipo_usuario($this->session->userdata('idi_code'), FALSE);
		foreach ($data['otros_tipos_campos'] as $key_tipo => $tipo_campo)
		{
			$data['otros_tipos_campos'][$key_tipo]['campos'] = $this->cobranzas_model->get_campos_x_tipo($this->session->userdata('idi_code'), $tipo_campo['cob_camp_tipo_id']);
		}
		*/
		$data['paises'] = $this->paises_model->get_items($this->session->userdata('idi_code'));
        //$data['ciudades'] = $this->paises_model->get_provincias_ciudad($this->session->userdata('idi_code'));

		$data['estados_documentos'] = $this->cobranzas_model->get_documentos_estados();

		//$data['operationsModifications'] = $this->db->get_where('user_operation_modification',array('operation_id'=>$id))->result_array();
		
		$data['documents'] = $this->cobranzas_model->get_item_documentos($id);
		
		$this->load->view(self::$solapa.'/viewOperation', $data);
	}

	public function documentation($id=FALSE)
	{
		$this->load->helper('formulariocobranza');
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['estados'] = $this->cobranzas_model->get_estados();
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos'] as $key => $tipo)
		{
			$data['tipos'][$key]['usuario'] = $this->cobranzas_model->get_item_usuario_x_tipo($id, $tipo['cob_usr_tipo_id']);
		}

		$data['estados_documentos'] = $this->cobranzas_model->get_documentos_estados();

		//$data['operationsModifications'] = $this->db->get_where('user_operation_modification',array('operation_id'=>$id))->result_array();
		
		$data['documents'] = $this->cobranzas_model->get_item_documentos($id);
		
		$this->load->view(self::$solapa.'/documentation', $data);
	}

	public function editPermisos($id = FALSE)
	{
		//$this->cobranzas_model->set_permisos_default($id);
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);
		$data['tipos'] = $this->cobranzas_model->get_tipos($this->session->userdata('idi_code'));
		$data['usuario'] = $this->cobranzas_model->get_item_usuarios($id, $this->session->userdata('usr_id'));

		$data['permiso_editar'] = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $id, 1, $data['operations']['cob_usr_tipo_id'], 3);
		
		$data['acciones_permisos'] = $this->cobranzas_model->get_permisos_acciones($this->session->userdata('idi_code'));
		$data['tipos_permisos'] = $this->cobranzas_model->get_permisos_tipos($this->session->userdata('idi_code'));
		foreach ($data['tipos_permisos'] as $key_tipo => $tipo_permiso)
		{
			//$data['tipos_permisos'][$key_tipo]['acciones_permisos'] = $data['acciones_permisos'];
			$data['tipos_permisos'][$key_tipo]['tipos_usuarios'] = $data['tipos'];
			foreach ($data['tipos_permisos'][$key_tipo]['tipos_usuarios'] as $key_usr_tipo => $tipo_usr)
			{
				$data['tipos_permisos'][$key_tipo]['tipos_usuarios'][$key_usr_tipo]['permisos'] = $this->cobranzas_model->get_permiso_x_cobranza_tipo_accion_tipousuario($this->session->userdata('idi_code'), $id, $tipo_permiso['cob_per_tipo_id'], $tipo_usr['cob_usr_tipo_id']);
			}
		}

		if($this->input->post())
		{
			$update = FALSE;

			foreach ($data['tipos_permisos'] as $key_tipo => $tipo_permiso)
			{
				foreach ($data['tipos_permisos'][$key_tipo]['tipos_usuarios'] as $key_usr_tipo => $tipo_usr)
				{
					foreach ($data['tipos_permisos'][$key_tipo]['tipos_usuarios'][$key_usr_tipo]['permisos'] as $key_per => $value)
					{
						$update = $this->cobranzas_model->update_permiso($value['cob_per_id'], $this->input->post('per_'.$value['cob_per_id']));
						//Actualizo el valor para no volver a consultar todo
						$data['tipos_permisos'][$key_tipo]['tipos_usuarios'][$key_usr_tipo]['permisos'][$key_per]['cob_per_activo'] = $this->input->post('per_'.$value['cob_per_id']);
					}
				}
			}
			
			if($update)
			{
				$this->session->set_flashdata('success','Operation Updated Successfully !');
			}
			else
			{
				$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
			}
		}

		$this->load->view(self::$solapa.'/editPermisos', $data);
	}

	public function uploadDocument($id=FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));
		
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $id);

		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|trim');
			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/uploadDocument');
			}
			else
			{
				if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']>6291456 )
				{
					$this->session->set_flashdata('error','Total file size not more than 6 MB');
					redirect(self::$solapa.'/uploadDocument/'.$id);
				}
				
				$allowed_extentions = array('bmp','png','jpg','jpeg','pdf','docx');
				

				foreach($_FILES['file']['name'] as $key => $filename)
				{
					$ext = pathinfo($_FILES['file']['name'][$key], PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed_extentions) )
					{
						$this->session->set_flashdata('error','Please upload the file having extension <strong>JPG, JPEG, BMP, PNG, PDF, DOCX </strong> !');
						redirect(self::$solapa.'/uploadDocument/'.$id);
					}
				}


				foreach($_FILES['file']['name'] as $key => $filename)
				{
					$path = time().'_'.$_FILES['file']['name'][$key];
					move_uploaded_file($_FILES["file"]["tmp_name"][$key], 'images/cobranza/'.$path );
					
					$insert[] = $this->cobranzas_model->set_documento($id, $this->session->userdata('usr_id'), $this->input->post('name'), $path, COBRANZA_DOCUMENTO_ESTADO_ENVIADO);
				}
				
				
				if(!empty($insert))
				{
					$this->session->set_flashdata('success','Documents Uploaded Successfully !');
					redirect(self::$solapa.'/documentation/'.$id);
				}
				else
				{
					$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
					redirect(self::$solapa.'/documentation/'.$id);
				}
				
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/uploadDocument', $data);
		}
	}

	public function deleteDocument($id=FALSE, $operation_id=FALSE)
	{
		$this->cobranzas_model->delete_documento($id);
		$this->session->set_flashdata('success','Document deleted successfully.');

		redirect(self::$solapa.'/documentation/'.$operation_id);
	}


	public function editDocument($id=FALSE, $operation_id=FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['user_details'] = $this->cobranzas_model->get_item_usuarios($operation_id, $this->session->userdata('usr_id'));
		$data['documento'] = $this->cobranzas_model->get_item_documentos($operation_id, $id);
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $operation_id);
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|trim');
			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/editDocument', $data);
			}
			else
			{
				$path = $data['documento']['cob_doc_ruta'];

				if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']>6291456 )
				{
					$this->session->set_flashdata('error','Total file size not more than 6 MB');
					redirect(self::$solapa.'/editDocument'.$id.'/'.$operation_id);
				}
				
				$allowed_extentions = array('bmp','png','jpg','jpeg','pdf','docx');
				

				if(!empty($_FILES['file']['name']))
				{
					$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed_extentions) )
					{
						$this->session->set_flashdata('error','Please upload the file having extension <strong>JPG, JPEG, BMP, PNG, PDF, DOCX </strong> !');
						redirect(self::$solapa.'/editDocument/'.$id.'/'.$operation_id);
					}
				}


				if(!empty($_FILES['file']['name']))
				{
					$path = time().'_'.$_FILES['file']['name'];
					move_uploaded_file($_FILES["file"]["tmp_name"], 'images/cobranza/'.$path );
					$datas['file'] = $path;
				}

				if($this->input->post('status') != "")
				{
					$update = $this->cobranzas_model->update_documento_estado($id, $this->input->post('status'));
				}
				
				$update = $this->cobranzas_model->update_documento($id, $this->input->post('name'), $path);
				if($update)
				{
					$this->session->set_flashdata('success','Documents Updated Successfully !');
					redirect(self::$solapa.'/documentation/'.$operation_id);
				}
				else
				{
					$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
					redirect(self::$solapa.'/documentation/'.$operation_id);
				}
				
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/editDocument', $data);
		}
	}

	public function markDocument($id=FALSE, $operation_id=FALSE)
	{
		$data['palabras'] = $this->palabras_model->get_items($this->session->userdata('idi_code'));

		$data['user_details'] = $this->cobranzas_model->get_item_usuarios($operation_id, $this->session->userdata('usr_id'));
		$data['documento'] = $this->cobranzas_model->get_item_documentos($operation_id, $id);
		$data['operations'] = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $operation_id);
		if($this->input->post())
		{
			$this->form_validation->set_rules('name','Name','required|trim');
			if($this->form_validation->run()===FALSE)
			{
				$this->load->view(self::$solapa.'/markDocument', $data);
			}
			else
			{
				$path = $data['documento']['cob_doc_ruta'];

				if(isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH']>6291456 )
				{
					$this->session->set_flashdata('error','Total file size not more than 6 MB');
					redirect(self::$solapa.'/markDocument'.$id.'/'.$operation_id);
				}
				
				$allowed_extentions = array('bmp','png','jpg','jpeg','pdf','docx');
				

				if(!empty($_FILES['file']['name']))
				{
					$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
					if(!in_array($ext,$allowed_extentions) )
					{
						$this->session->set_flashdata('error','Please upload the file having extension <strong>JPG, JPEG, BMP, PNG, PDF, DOCX </strong> !');
						redirect(self::$solapa.'/markDocument/'.$id.'/'.$operation_id);
					}
				}


				if(!empty($_FILES['file']['name']))
				{
					$path = time().'_'.$_FILES['file']['name'];
					move_uploaded_file($_FILES["file"]["tmp_name"], 'images/cobranza/'.$path );
					$datas['file'] = $path;
				}

				if($this->input->post('status') != "")
				{
					$update = $this->cobranzas_model->update_documento_estado($id, $this->input->post('status'));
				}
				
				$update = $this->cobranzas_model->update_documento($id, $this->input->post('name'), $path);
				if($update)
				{
					$this->session->set_flashdata('success','Documents Updated Successfully !');
					redirect(self::$solapa.'/documentation/'.$operation_id);
				}
				else
				{
					$this->session->set_flashdata('error','Something went wrong. Please try after sometime !');
					redirect(self::$solapa.'/documentation/'.$operation_id);
				}
				
			}
		}
		else
		{
			$this->load->view(self::$solapa.'/markDocument', $data);
		}
	}

	public function cambiar_estado_operacion_ajax()
	{
		if($this->input->post('cob_id') != "" && $this->input->post('est_id') != "")
		{
			$result = $this->cobranzas_model->update_estado($this->input->post('cob_id'), $this->input->post('est_id'));
			if($result)
			{
				$usuarios_notif = $this->cobranzas_model->get_item_usuarios($this->input->post('cob_id'));
				if($usuarios_notif)
				{
					$cobranza_datos = $this->cobranzas_model->get_items(FALSE, $this->input->post('cob_id'));
					$mensaje = "El usuario ".$this->session->userdata('usr_mail')." modifico el estado de la operacion de cobranza documentaria ".$cobranza_datos['cob_nombre'];
	        		$link = self::$solapa.'/dashboard';

					foreach ($usuarios_notif as $key => $usuario)
					{
						if($usuario['usr_id'] != $this->session->userdata('usr_id'))
						{
							$this->notificaciones_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], NULL, NULL, NOTIFICACION_COBRANZA_MODIFICACION, NOTI_ESTADO_PENDIENTE, $this->input->post('cob_id'), $mensaje, $link);
						}
					}
				}

				$data['error'] = FALSE;
				$data['data'] = "El estado fue actualizado";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function cambiar_estado_documento_ajax()
	{
		if($this->input->post('cob_doc_id') != "" && $this->input->post('est_id') != "")
		{
			$result = $this->cobranzas_model->update_documento_estado($this->input->post('cob_doc_id'), $this->input->post('est_id'));
			if($result)
			{
				$data['error'] = FALSE;
				$data['data'] = "El estado fue actualizado";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function get_notas_ajax()
	{
		if($this->input->post('cob_doc_id') != "")
		{
			$data['error'] = FALSE;
			$data['data'] = $this->cobranzas_model->get_documento_notas($this->input->post('cob_doc_id'));
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function comentar_ajax()
	{
		//$_POST['cob_id'] = 1;
		//$_POST['item_id'] = 1;
		//$_POST['estado1'] = 1;
		//$_POST['texto'] = 'asd';

		$data['error'] = FALSE;
		if($this->input->post('cob_id') != "" && $this->input->post('item_tipo_id') != "" && $this->input->post('item_id') != "" && $this->input->post('sub_item_id') != "")
		{
			$result = $this->cobranzas_model->set_comentario($this->input->post('cob_id'), $this->session->userdata('usr_id'), $this->input->post('item_tipo_id'), $this->input->post('item_id'), $this->input->post('sub_item_id'), $this->input->post('estado'), $this->input->post('texto'));
			if($result)
			{
				$usuarios_notif = $this->cobranzas_model->get_item_usuarios($this->input->post('cob_id'));
				if($usuarios_notif)
				{
					$cobranza_datos = $this->cobranzas_model->get_items(FALSE, $this->input->post('cob_id'));
					$mensaje = "El usuario ".$this->session->userdata('usr_mail')." realizó comentarios en la operacion de cobranza documentaria ".$cobranza_datos['cob_nombre'];
	        		$link = self::$solapa.'/beginOperation/'.$this->input->post('cob_id');

					foreach ($usuarios_notif as $key => $usuario)
					{
						if($usuario['usr_id'] != $this->session->userdata('usr_id'))
						{
							$this->notificaciones_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], NULL, NULL, NOTIFICACION_COBRANZA_MODIFICACION, NOTI_ESTADO_PENDIENTE, $this->input->post('cob_id'), $mensaje, $link);
						}
					}
				}

				$data['cob_com_est_id'] = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $this->input->post('cob_id'), $this->input->post('item_tipo_id'), $this->input->post('item_id'), $this->input->post('sub_item_id'));
				$data['data'] = "El comentario fue cargado.";
			}
			else
			{
				$data['error'] = TRUE;
				$data['data'] = "Ocurrio un error al cargar el comentario.";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function comentar_estado_ajax()
	{
		// $_POST['cob_id'] = 9;
		// $_POST['item_tipo_id'] = 1;
		// $_POST['item_id'] = 26;
		// $_POST['sub_item_id'] = 10;
		// $_POST['estado'] = 1;
		// $_POST['texto'] = 'asd';

		$data['error'] = FALSE;
		if($this->input->post('cob_id') != "" && $this->input->post('item_tipo_id') != "" && $this->input->post('item_id') != "" && $this->input->post('sub_item_id') != "")
		{
			$result = $this->cobranzas_model->set_comentario($this->input->post('cob_id'), $this->session->userdata('usr_id'), $this->input->post('item_tipo_id'), $this->input->post('item_id'), $this->input->post('sub_item_id'), $this->input->post('estado'), NULL);
			if($result)
			{
				$usuarios_notif = $this->cobranzas_model->get_item_usuarios($this->input->post('cob_id'));
				if($usuarios_notif)
				{
					$cobranza_datos = $this->cobranzas_model->get_items(FALSE, $this->input->post('cob_id'));
					$mensaje = "El usuario ".$this->session->userdata('usr_mail')." realizó comentarios en la operacion de cobranza documentaria ".$cobranza_datos['cob_nombre'];
	        		$link = self::$solapa.'/beginOperation/'.$this->input->post('cob_id');

					foreach ($usuarios_notif as $key => $usuario)
					{
						if($usuario['usr_id'] != $this->session->userdata('usr_id'))
						{
							$this->notificaciones_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], NULL, NULL, NOTIFICACION_COBRANZA_MODIFICACION, NOTI_ESTADO_PENDIENTE, $this->input->post('cob_id'), $mensaje, $link);
						}
					}
				}

				$data['cob_com_est_id'] = $this->cobranzas_model->get_comentario_estado($this->session->userdata('idi_code'), $this->input->post('cob_id'), $this->input->post('item_tipo_id'), $this->input->post('item_id'), $this->input->post('sub_item_id'));
				$data['data'] = "El estado fue cargado.";
			}
			else
			{
				$data['error'] = TRUE;
				$data['data'] = "Ocurrio un error al cargar el comentario.";
			}
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function get_comentarios_ajax()
	{
		// $_POST['cob_id'] = 1;
		// $_POST['item_id'] = 1;
		// $_POST['item_tipo_id'] = 1;
		// $_POST['sub_item_id'] = 1;
		
		if($this->input->post('cob_id') != "" && $this->input->post('item_id') != "" && $this->input->post('item_tipo_id') != "" && $this->input->post('sub_item_id') != "")
		{
			$data['error'] = FALSE;
			$data['data'] = $this->cobranzas_model->get_comentarios($this->session->userdata('idi_code'), $this->input->post('cob_id'), $this->input->post('item_tipo_id'), $this->input->post('item_id'), $this->input->post('sub_item_id'));
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function guardar_notas_ajax()
	{
		//$_POST['cob_doc_id'] = 4;
		//$_POST['items'] = '[{"className":"yello","id":"1","title":"asd","content":"aaaaa","x":0,"y":0,"pos":{"x":0,"y":21},"col":1},{"className":"yello","id":"2","title":"asd","content":"aaaaa","x":0,"y":0,"pos":{"x":0,"y":94},"col":1},{"content":"Content for mock marker should be a bit longer, longer, longer... ok that`s it.","className":"green","pos":{"x":0,"y":176},"col":1}]';

		if($this->input->post('cob_doc_id') != "")
		{
			if($this->input->post('items'))
			{
				$items = json_decode($this->input->post('items'));
				foreach ($items as $key => $value)
				{
					if(isset($value->id))
					{
						if(isset($value->delete))
						{
							//DELETE
							$result = $this->cobranzas_model->delete_documento_nota($value->id);
						}
						else
						{
							//UPDATE
							$result = $this->cobranzas_model->update_documento_nota($value->id, $value->title, $value->content, $value->pos->x, $value->pos->y);
						}
					}
					else
					{
						if(isset($value->delete))
						{
							//NADA
						}
						else
						{
							//INSERT
							$cob_doc_not_id = $this->cobranzas_model->set_documento_nota($this->input->post('cob_doc_id'), $this->session->userdata('usr_id'), $value->title, $value->content, $value->tipo, 0, $value->pos->x, $value->pos->y);
						}
					}
				}
			}

			$data['error'] = FALSE;
			$data['data'] = "ok";
			$this->session->set_flashdata('success', 'Los datos fueron guardados.');
		}
		else
		{
			$data['error'] = TRUE;
			$data['data'] = "Faltan datos";
		}

		echo json_encode($data);
	}

	public function invitar_ajax()
    {
    	// $_POST['mail'] = 'fabianmayoral@gmail.com';
    	// $_POST['cob_id'] = 1;

        $data['error'] = FALSE;
        $palabras = $this->palabras_model->get_items($this->session->userdata('idi_code'));
        
        $this->form_validation->set_rules('mail', mostrar_palabra(4, $palabras), 'required|valid_email');
        $this->form_validation->set_rules('cob_id', mostrar_palabra(4, $palabras), 'required');

        if ($this->form_validation->run() !== FALSE)
        {
        	$operations = $this->cobranzas_model->get_items($this->session->userdata('usr_id'), $this->input->post('cob_id'));
        	$mensaje = "El usuario ".$this->session->userdata('usr_mail')." te invita a participar de la operacion de cobranza documentaria";
        	$link = self::$solapa.'/user_type_invite/'.$this->input->post('cob_id').'/'.$operations['cob_codigo'];

        	//ENVIAR MAIL
            $this->load->helper('mails');
            $mail_info = $this->mails_info_model->get_item($this->session->userdata('idi_code'),30);

            $mensaje1 = str_replace("[USER MAIL]", $this->session->userdata('usr_mail'), $mail_info['mi_cuerpo1']);
            $mensaje1 = str_replace("[USER COMPLETE NAME]", $this->session->userdata('usr_nombre')." ".$this->session->userdata('usr_apellido'), $mensaje1);
            $mensaje2 = str_replace("[LINK]", "<div style='text-align:center; margin:10px auto; display:block; padding:15px 10px; background:#FFFFFF; width:200px; border-radius:8px; color:#C30D00; font-size:18px; text-decoration:none;'><a href='".site_url($link)."' style='color:#C30D00;'>".mostrar_palabra(6, $palabras)."</a></div>", $mail_info['mi_cuerpo2']);

            mail_base($this->input->post('mail'), $mail_info['mi_asunto'], $mail_info['mi_titulo'], $mensaje1, $mensaje2);

            $usuario = $this->user_model->get_items_byMail($this->input->post('mail'));
            if($usuario)
            {
            	$this->notificaciones_model->set_item($this->session->userdata('usr_id'), $usuario['usr_id'], NULL, NULL, NOTIFICACION_COBRANZA_INVITACION, NOTI_ESTADO_PENDIENTE, $this->input->post('cob_id'), $mensaje, $link);
                
                $data['data'] = "El usuario fue invitado a participar.";
            }
            else
            {
                $data['data'] = "Enviamos una invitacion a ".$this->input->post('mail')." para que se una a Nocnode y participe en esta operación.";
            }
        }
        else
        {
            $data['error'] = TRUE;
            $data['data'] = validation_errors();
        }

        echo json_encode($data);
    }

	public function gen_uuid() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			// 32 bits for "time_low"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

			// 16 bits for "time_mid"
			mt_rand( 0, 0xffff ),

			// 16 bits for "time_hi_and_version",
			// four most significant bits holds version number 4
			mt_rand( 0, 0x0fff ) | 0x4000,

			// 16 bits, 8 bits for "clk_seq_hi_res",
			// 8 bits for "clk_seq_low",
			// two most significant bits holds zero and one for variant DCE1.1
			mt_rand( 0, 0x3fff ) | 0x8000,

			// 48 bits for "node"
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}


}
