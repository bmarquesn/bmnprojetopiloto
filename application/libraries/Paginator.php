<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Librarie para Paginacao
 * <pre>23/03/2015</pre>
 * Classe para criação de paginação dos dados do sistema
 * 
 * @author Bruno Marques Nogueira <bmarquesn@gmail.com>
 * @name Paginator
 * @license BrunoMarquesNogueira
 * @package Paginator
 * @date 23/03/2015
 */
class Paginator {
	/** Metodo que cria links de paginacao */
	function createPaginate($acao, $pagina, $total_registros, $itens_por_pagina) {
		/** montando os links */
		$paginaInicial = 0;
		$linkPagina = array();
		$paginador = '';
		
		if($total_registros > $itens_por_pagina) {
			$qtdLinks = ceil($total_registros / $itens_por_pagina);
			$contadorPag = 0;
			
			for($i = 0; $i < $qtdLinks; $i++) {
				$linkPagina[$i] = $i*$itens_por_pagina;
			}
			
			if(!empty($linkPagina)) {
				$paginador .= '<div class="btn-group"><div class="btn-group">';
				
				if(isset($_GET) && !empty($_GET)) {
					$filtros = '?';
					foreach($_GET as $key => $value) {
						$filtros .= $key.'='.$value.'&';
					}
					$filtros = substr($filtros, 0, -1);
				} else {
					$filtros = '';
				}
				
				foreach($linkPagina as $key => $value) {
					if($value == $pagina) {
						$paginador .= '<a href="'.base_url().$acao.$value.$filtros.'" style="float:left;"><button class="btn btn-info" style="margin2px;display:block;">'.($key+1).'</button></a>';
					} else {
						$paginador .= '<a href="'.base_url().$acao.$value.$filtros.'" style="float:left;"><button class="btn" style="margin:2px;display:block;">'.($key+1).'</button></a>';
					}
				}
				$paginador .= '</div></div>';
			}
		}
		
		return $paginador;
	}
}