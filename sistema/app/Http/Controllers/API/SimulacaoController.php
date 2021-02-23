<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SimulacaoController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->only(['valor_emprestimo','instituicoes','convenios','parcela']);

        $valida = $this->validateValue($data);

        if($valida != '1'){
            return $valida;
        }

        $arquivo = file_get_contents('../resources/json/taxas_instituicoes.json');
        
        $json = json_decode($arquivo);

        $instituicoes = false;
        $convenios = false;
        $parcela = false;
        if(isset($data['instituicoes'])){
            $instituicoes = $data['instituicoes'];
        }
        if(isset($data['convenios'])){
            $convenios = $data['convenios'];
        }
        if(isset($data['parcela'])){
            $parcela = $data['parcela'];
        }
        
        $bank = $this->valueArray($json,$instituicoes,$convenios,$parcela,$data['valor_emprestimo']);

        
        return json_encode($bank,JSON_PRETTY_PRINT);
    }
    private function validateValue($data){

        if(!isset($data['valor_emprestimo'])){
            return 'Parametro valor_emprestimo obigatório!'; 
         }else{
             if(!is_numeric($data['valor_emprestimo'])){
                 return 'valor_emprestimo deve ser um numero no formato americano!';
             }
         }
         if(isset($data['instituicoes'])){
             if(is_array($data['instituicoes'])){
 
             }else{
                 return 'campo instituicoes deve ser um array!';
             }
         }
         if(isset($data['convenios'])){
             if(is_array($data['convenios'])){
 
             }else{
                 return 'campo convenios deve ser um array!';
             }
         }
         if(isset($data['parcela'])){
             if(!is_numeric($data['parcela'])){
                 return 'parcela deve ser um numero inteiro!';
             }
         }
         return '1';
    }
    private function valueArray($json,$instituicoes,$convenios,$parcela,$valor){
        
        $bank = array();
        $cont = 0;
        $banco_anterior = '';
        foreach($json as $item){
            
            if($instituicoes){
                if(in_array($item->instituicao,$instituicoes)){
                    if($convenios){
                        if(in_array($item->convenio,$convenios)){
                            if($parcela){
                                if($parcela == $item->parcelas){
                                    if($banco_anterior != $item->instituicao){
                                        $cont = 0;
                                    }
                                    $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                                    $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                                    $valor_parcela = $valor * $item->coeficiente;
                                    $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                                    $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                                    $banco_anterior = $item->instituicao;
                                    $cont++;
                                }
                            }else{     
                                if($banco_anterior != $item->instituicao){
                                    $cont = 0;
                                }                           
                                $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                                $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                                $valor_parcela = $valor * $item->coeficiente;
                                $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                                $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                                $banco_anterior = $item->instituicao;
                                $cont++;                                
                            }                            
                        }
                    }else{
                        if($parcela){
                            if($parcela == $item->parcelas){
                                if($banco_anterior != $item->instituicao){
                                    $cont = 0;
                                }
                                $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                                $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                                $valor_parcela = $valor * $item->coeficiente;
                                $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                                $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                                $banco_anterior = $item->instituicao;
                                $cont++;
                            }
                        }else{                            
                            if($banco_anterior != $item->instituicao){
                                $cont = 0;
                            }
                            $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                            $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                            $valor_parcela = $valor * $item->coeficiente;
                            $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                            $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                            $banco_anterior = $item->instituicao;
                            $cont++;
                        }
                        
                    }
                }
            }else{
                if($convenios){
                    if(in_array($item->convenio,$convenios)){
                        if($parcela){
                            if($parcela == $item->parcelas){
                                if($banco_anterior != $item->instituicao){
                                    $cont = 0;
                                }
                                $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                                $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                                $valor_parcela = $valor * $item->coeficiente;
                                $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                                $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                                $banco_anterior = $item->instituicao;
                                $cont++;
                            }
                        }else{
                            if($banco_anterior != $item->instituicao){
                                $cont = 0;
                            }
                            $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                            $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                            $valor_parcela = $valor * $item->coeficiente;
                            $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                            $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                            $banco_anterior = $item->instituicao;
                            $cont++;
                        }
                        
                    }
                }else{
                    if($parcela){
                        if($parcela == $item->parcelas){
                            if($banco_anterior != $item->instituicao){
                                $cont = 0;
                            }
                            $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                            $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                            $valor_parcela = $valor * $item->coeficiente;
                            $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                            $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                            $banco_anterior = $item->instituicao;
                            $cont++;
                        }
                    }else{
                        if($banco_anterior != $item->instituicao){
                            $cont = 0;
                        }
                        $bank[$item->instituicao][$cont]['taxa'] = $item->taxaJuros;
                        $bank[$item->instituicao][$cont]['parcelas'] = $item->parcelas;
                        $valor_parcela = $valor * $item->coeficiente;
                        $bank[$item->instituicao][$cont]['valor_parcela'] = $valor_parcela;
                        $bank[$item->instituicao][$cont]['convenio'] = $item->convenio;
                        $banco_anterior = $item->instituicao;
                        $cont++;
                    }
                    
                }                
            }
        }
        return $bank;
    }
}
