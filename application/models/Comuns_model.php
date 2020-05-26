<?php
class Comuns_model extends CI_Model {
	/** funcoes comuns */
	public function tabela() {
		return $this->tabela;
	}
	
	function get_all_where($table, $field, $option, $ativo = null, $order = null, $type_order = null, $debug = false) {
		$this->db->select('*');
		
		if(is_array($field)) {
			foreach($field as $key => $value) {
				$this->db->where($value,$option[$key]);
			}
		} else {
			$this->db->where($field,$option);
		}
		
		if($ativo != null) {
			if($ativo != 1) {
				$this->db->where('ativo', 0);
			} else {
				$this->db->where('ativo', 1);
			}
		}
		
		if(!empty($order)) {
			if(!empty($type_order)) {
				$this->db->order_by($table.".".$order, $type_order);
			} else {
				$this->db->order_by($table.".".$order, "DESC");
			}
		}

		$data = $this->db->get($table);
		
		if(!$debug) {
			return $data->result();
		} else {
			var_dump($this->db->last_query());
			exit;
		}
	}
	
	function get_all_where_in($table, $field, $option, $ativo = null, $not_in = null) {
		$this->db->select('*');
		
		
		if(is_array($field) && count($field) > 1) {
			foreach($field as $key => $value) {
				$option[$key] = explode('-', $option[$key]);
				$this->db->where_in($value,$option[$key],FALSE);
			}
		} else {
			$option = str_replace(',', '-', $option);
			
			if(is_array($option)) {
				$option = explode('-', $option[0]);
			} else {
				$option = explode('-', $option);
			}
			
			if(count($option) < 2) {
				if(is_array($option)) {
					$option = explode(',', $option[0]);
				} else {
					$option = explode(',', $option);
				}
			}
				
			if(is_array($field)) {
				$field = $field[0];
			}
			
			if(empty($not_in)) {
				$this->db->where_in($field,$option,FALSE);
			} else {
				$this->db->where_not_in($field,$option,FALSE);
				//$this->db->where($field.' !=',$option);
			}
		}
		
		if($ativo != null) {
			if($ativo != 1) {
				$this->db->where('ativo',0);
			} else {
				$this->db->where('ativo',1);
			}
		}

		$data = $this->db->get($table);
		//var_dump($this->db->last_query());die;

		return $data->result();
	}

	function get_all_nodate($table) {
		$data = $this->db->get($table);

		return $data->result();
	}

	function get_all($table, $order = 'data', $ativo = null, $type_order = null) {
		if($order != 'data') {
			if(!is_array($order)) {
				if(!empty($type_order)) {
					$this->db->order_by($table.".".$order, $type_order);
				} else {
					$this->db->order_by($table.".".$order, "DESC");
				}
			} else {
				foreach($order as $key => $value) {
					if(!empty($type_order)) {
						$this->db->order_by($table.".".$value, $type_order[$key]);
					} else {
						$this->db->order_by($table.".".$value, "DESC");
					}
				}
			}
		}
		
		if($ativo != null) {
			if($ativo != 1) {
				$this->db->where('ativo',0);
			} else {
				$this->db->where('ativo',1);
			}
		}
		$data = $this->db->get($table);
		//var_dump($this->db->last_query());die;

		return $data->result();
	}
	
	function get_all_paginate($table, $pagina, $itens_por_pagina, $order = 'data', $ativo = 0, $type_order = null) {
		if($order != 'data') {
			if(!empty($type_order)) {
				$this->db->order_by($table.".".$order, $type_order);
			} else {
				$this->db->order_by($table.".".$order, "DESC");
			}
		}
		
		if($ativo == 1) {
			$this->db->where('ativo',0);
		} else {
			$this->db->where('ativo',1);
		}
		
		$data = $this->db->get($table, $itens_por_pagina, $pagina);

		return $data->result();
	}

	function get_all_specific_update($table,$field,$specific,$field_id,$value_id) {
		$this->db->where($field . " = '" . $specific . "' AND ".$field_id." != ".$value_id."");

		$users = $this->db->get($table);

		return $users->result();
	}

	function add_record($table,$options = array()) {
		$this->db->insert($table,$options);

		if($this->db->affected_rows()) {//active records
			if($this->db->insert_id() != '0') {
				$return = $this->db->insert_id();
			}
		} else {
			$return = null;
		}

		return $return;
	}

	function upd_record($table, $options = array(), $campo_atualizar = null, $debug = false) {
		if(isset($options['id']) && empty($campo_atualizar)) {
			$this->db->where('id', $options['id']);
		} else {
			/** aqui verifico chaves primarias compostas */
			if(strpos($campo_atualizar, ',') !== false) {
				$campos_atualizar = explode(',', $campo_atualizar);
				foreach($campos_atualizar as $key => $value) {
					$this->db->where($value,$options[$value]);
				}
			} else {
				$this->db->where($campo_atualizar,$options[$campo_atualizar]);
			}
		}
		
		if($debug) {
			var_dump($this->db->last_query());
			exit;
		} else {
			$this->db->update($table, $options);
			return $this->db->affected_rows();//active records
		}
	}

	function del_record($table, $id, $ativo = false, $campo_nao_id = null) {
		if(strpos($id, ',')) {
			$id = explode(',', $id);
		}
		
		if(is_array($id)) {
			foreach($id as $key => $value) {
				if(empty($campo_nao_id)) {
					$this->db->where('id', $value);
				} else {
					$this->db->where($campo_nao_id, $value);
				}
				
				if($ativo) {
					$data = array('ativo' => '0');
					$this->db->update($table,$data);
				} else {
					$data = $this->db->delete($table);
				}
			}
		} else {
			if(empty($campo_nao_id)) {
				$this->db->where('id', $id);
			} else {
				$this->db->where($campo_nao_id, $id);
			}
			
			if($ativo) {
				$data = array('ativo' => '0');
				$this->db->update($table,$data);
			} else {
				$data = $this->db->delete($table);
			}
		}
		//var_dump($this->db->last_query());die;

		return $this->db->affected_rows();//active records
	}

	function logs_sistema($tabela, $pagina, $itens_por_pagina) {
		$this->db->select($tabela.'.*');
		
		$this->db->group_by($tabela.'.id');
		$this->db->order_by($tabela.'.data_hora DESC');
		$dados = $this->db->get($tabela, $itens_por_pagina, $pagina);
		
		return $dados->result();
	}
}