<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class M_dadosSensores extends CI_Model {
        public function inserirModel($temperatura, $umidade, $luminosidade){
            try{
                //Query da inserção de dados 
                $this->db->query("insert into tbl_sensores(temperatura, umidade, luminosidade) values ($temperatura, $umidade, '$luminosidade');"); 
                // Verificar se a inserção ocorreu tudo certo
                if($this->db->affected_rows() > 0){
                    $dados = array(
                                'Codigo' => 1,
                                'msg' => 'Dados cadastrados corretamento.'
                                );
                }else{
                    $dados = array(
                                'Codigo' =>  6,
                                'msg' => 'Houve algum problema na inserção na tabela de sensores.'
                                );
                }
            }catch (Exception $e){
                $dados = array(
                            'Codigo' =>  00,
                            'msg' => 'Houve algum problema na inserção na tabela de sensores.',
                            $e->getMessage()
                            );
            }
            return $dados;
        }
    }

?>