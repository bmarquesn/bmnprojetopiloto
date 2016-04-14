<?php
/**
 * Model de Usuarios
 * <pre>14/04/2016</pre>
 * Classe de movimenação com a tabela Usuario
 * 
 * @author Bruno Marques <developer@crosshost.com.br>
 * @name Usuario_model
 * @license BrunoMarquesNogueira
 * @package Comuns_model
 * @subpackage Usuario_Model
 * @date 14/04/2016
 */
require_once('Comuns_model.php');

class Usuario_model extends Comuns_model {
	protected $tabela = 'usuario';
	
	public function listar($filtros, $pagina = null, $limit = null) {
		$select = 'Usuario.id, Usuario.nome, Usuario.email, Usuario.ativo';
		$this->db->select($select);
		
		if(!empty($filtros)) {
			if(isset($filtros['nome'])) {
				$this->db->where('Usuario.nome LIKE(\'%%'.$filtros['nome'].'%%\')');
			}
			if(isset($filtros['texto'])) {
				$this->db->where('Usuario.email LIKE(\'%%'.$filtros['email'].'%%\')');
			}
			if(isset($filtros['ativo'])) {
				$this->db->where('Usuario.ativo = '.$filtros['ativo']);
			}
		}
		
		$this->db->group_by('Usuario.id');
		$this->db->order_by('Usuario.nome ASC');
		
		if($pagina !== '' && $limit !== '') {
			$this->db->limit((int)$limit, (int)$pagina);
		}
		
		$data = $this->db->get($this->tabela.' AS Usuario');
		//var_dump($pagina,$limit,$this->db->last_query());die;
		
		return $data->result();
	}
}