<?php
    defined('BASEPATH') OR exit('No direct script acess allowed');

    class DadosSensores extends CI_Controller{
        // ** Criando atributos privados da classe 
            private $idLeitura;
            private $temperatura;
            private $umidade;
            private $luminosidade;
            private $datahora_leitura;

        // ** Criando os métodos Getters ** 

        public function getIdLeitura(){
            return $this->idLeitura;
        }

        public function getTemperatura(){
            return $this->temperatura;
        }

        public function getUmidade(){
            return $this->umidade;
        }

        public function getLuminosidade(){
            return $this->luminosidade;
        }

        public function getDataHora(){
            return $this->datahora_leitura;
        }

        //** Criando os métodos Setters **/ 

        public function setIdLeitura($paramentoDeIdLeitura){
            $this->idLeitura = $paramentoDeIdLeitura;
        }
        public function setTemperatura($paramentoTemperatura){
            $this->temperatura = $paramentoTemperatura;
        }
        public function setUmidade($parametroUmidade){
            $this->umidade = $parametroUmidade;
        }
        public function setLuminosidade($parametroLuminosidade){
            $this->luminosidade = $parametroLuminosidade;
        }
        public function setDataHora($parametroDataHora){
            $this->datahora_leitura = $parametroDataHora;
        }

// *****2°Parte da controller*********************************************************

    // ** Criando o método de Inserção de dados  

        public function inserir(){
        
            //Temperatura, umidade e luminosidade
            //recebidos via POST e colocados em variáveis
            //Retornos possíveis:
            // 1 - Dados salvo corretamente
            // 2 - Faltou a temperatura
            // 3 - Faltou a umidade
            // 4 - Faltou a luminosidade
            // 99 - Erro na aquisição dos dados 
            
            try{
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //Fazendo os setters
                    $this->setTemperatura($_POST['temperatura']); 
                    $this->setUmidade($_POST['umidade']);  
                    $this->setLuminosidade($_POST['luminosidade']);


                    if($this->getTemperatura() == ''){
                        $retorno = array(
                                        'Codigo' => 2,
                                        'msg' => 'Valor da TEMPERATURA não informado.');
                    }elseif($this->getUmidade() == '' || $this->getUmidade() == 0){
                        $retorno = array(
                                        'Codigo' => 3,
                                        'msg' => 'Valor da UMIDADE não informado ou valor ZERO.');
                    }elseif($this->getLuminosidade() == ''){
                        $retorno = array(
                                        'Codigo' => 4,
                                        'msg' => 'Valor da LUMINOSIDADE não informado.');
                    }else{
                        // ** Realiza a instancia da Model
                        $this->load->model('M_dadosSensores');

                        //Atrbuto '$retorno' vai receber o array
                        // Com as informações da validação de acesso 

                        $retorno = $this->M_dadosSensores->inserirModel($this->getTemperatura(),
                                                                        $this->getUmidade(),
                                                                        $this->getLuminosidade());
                    }
                }else{
                    $retorno = array('Codigo' => 99,
                                     'msg' => 'ATENÇÃO: Aquisição Inválida. "inserir in Controller   "'
                    );
                }
            }catch (Exception $e){
                    $retorno = array('Codigo' => 00,
                                     'msg' => 'ATENÇÃO: O sequinte erro aconteceu.',
                        $e ->getMessage());
            }
            echo json_encode($retorno);
        }
    }
?>