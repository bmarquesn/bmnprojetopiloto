<?php
/**
 * Model de Logs
 * <pre>22/04/2016</pre>
 * Classe de movimenação com a tabela Historico_acoes
 * 
 * @author Bruno Marques <bmarquesn@gmail.com>
 * @name Logs_model
 * @license BrunoMarquesNogueira
 * @package Comuns_model
 * @subpackage Logs_model
 * @date 22/04/2016
 */
require_once('Comuns_model.php');

class Logs_model extends Comuns_model {
	public $tabela = 'historico_acoes';
	
	public function listar($filtros, $pagina = '', $limit = '') {
		$select = 'Logs.*';
		$this->db->select($select);
		
		if(!empty($filtros)) {
			if(isset($filtros['acao']) && !empty($filtros['acao'])) {
				$this->db->where('Logs.acao LIKE(\'%%'.$filtros['acao'].'%%\')');
			}
			if(isset($filtros['data_acao']) && !empty($filtros['data_acao'])) {
				$this->db->where('DATE(Logs.data_acao) = "'.$filtros['data_acao'].'"');
			}
		}
		
		$this->db->group_by('Logs.id');
		$this->db->order_by('Logs.data_acao DESC');
		
		if($pagina !== '' && $limit !== '') {
			$this->db->limit($limit, $pagina);
		}
		
		$data = $this->db->get($this->tabela.' AS Logs');
		//var_dump($this->db->last_query());die;
		return $data->result();
	}
}