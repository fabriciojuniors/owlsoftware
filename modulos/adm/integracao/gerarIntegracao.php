<?php
    include $_SERVER['DOCUMENT_ROOT'].'/owlsoftware/conexao.php';
    
    $sql = "SELECT clientes.*, cidade.codigo_ibge as cidadeIBGE, uf.cod as UFIBGE, pais.cod as paisIBGE
              FROM clientes
        INNER JOIN cidade on cidade.id = clientes.cidade
        INNER JOIN uf on uf.id = clientes.uf
        INNER JOIN pais on pais.id = clientes.pais
        WHERE exporta_webmais = 1";
    $query = mysqli_query($link, $sql);
    $xml = "";
    $key = 1;
    if(mysqli_num_rows($query)>0){
        $xml = "<Records><Clientes>";
        while($result =  mysqli_fetch_array($query)){
            $xml .= "<Cliente ClientesKey=\"".$key."\">";
            $xml .= "<CliEmpTrabCNPJ>07.491.156/0001-61</CliEmpTrabCNPJ>";
            $xml .= "<CliInativo>0</CliInativo>";
            $xml .= "<CliCodigo>".$result['cod_webmais']."</CliCodigo>";
            $xml .= "<CliTipoJuri>".(strlen($result['CPF_CNPJ']) > 15 ? 1 : 0)."</CliTipoJuri>";
            $xml .= "<CliCPFCNPJ>".$result['CPF_CNPJ']."</CliCPFCNPJ>";
            $xml .= "<CliRSocial>".$result['razao_social']."</CliRSocial>";
            $xml .= "<CliFantasia>".$result['nome']."</CliFantasia>";
            $xml .= "<CliInscrEst>ISENTO</CliInscrEst>";
            $xml .= "<CliCelular>".$result['telefone']."</CliCelular>";
            $xml .= "<CliRepresenCPFCNPJ>944.755.550-00</CliRepresenCPFCNPJ>";
            $xml .= "<CliSegComCod>1</CliSegComCod>";
            $xml .= "<CliRegTribCod>1</CliRegTribCod>";
            $xml .= "<CliSegContCod>1</CliSegContCod>";
            $xml .= "<CliGeraSubs>0</CliGeraSubs>";
            $xml .= "<CliEmailNFe>".$result['email']."</CliEmailNFe>";
            //Endereço Principal
            $xml .= "<CliContatoPri>".$result['nome']."</CliContatoPri>";
			$xml .= "<CliTelefonePri>".$result['telefone']."</CliTelefonePri>";
			$xml .= "<CliCEPPri>".$result['CEP']."</CliCEPPri>";
			$xml .= "<CliEndePri>".$result['rua']."</CliEndePri>";
			$xml .= "<CliEndPriNum>".($result['numero'] > 0 ? $result['numero'] : 0)."</CliEndPriNum>";
			$xml .= "<CliEndPriBairro>".$result['bairro']."</CliEndPriBairro>";
			$xml .= "<CliEndPriCidCodIBGE>".$result['cidadeIBGE']."</CliEndPriCidCodIBGE>";
			$xml .= "<CliEndPriUFCodIBGE>".$result['UFIBGE']."</CliEndPriUFCodIBGE>";
            $xml .= "<CliEndPriPaisCodIBGE>1058</CliEndPriPaisCodIBGE>";
            //Endereço entrega
            $xml .= "<CliContatoEnt>".$result['nome']."</CliContatoEnt>";
			$xml .= "<CliTelefoneEnt>".$result['telefone']."</CliTelefoneEnt>";
			$xml .= "<CliCEPEnt>".$result['CEP']."</CliCEPEnt>";
			$xml .= "<CliEndeEnt>".$result['rua']."</CliEndeEnt>";
			$xml .= "<CliEndEntNum>".($result['numero'] > 0 ? $result['numero'] : 0)."</CliEndEntNum>";
			$xml .= "<CliEndEntBairro>".$result['bairro']."</CliEndEntBairro>";
			$xml .= "<CliEndEntCidCodIBGE>".$result['cidadeIBGE']."</CliEndEntCidCodIBGE>";
			$xml .= "<CliEndEntUFCodIBGE>".$result['UFIBGE']."</CliEndEntUFCodIBGE>";
            $xml .= "<CliEndEntPaisCodIBGE>1058</CliEndEntPaisCodIBGE>";
            //Endereço cobrança
            $xml .= "<CliContatoCob>".$result['nome']."</CliContatoCob>";
			$xml .= "<CliTelefoneCob>".$result['telefone']."</CliTelefoneCob>";
			$xml .= "<CliCEPCob>".$result['CEP']."</CliCEPCob>";
			$xml .= "<CliEndeCob>".$result['rua']."</CliEndeCob>";
			$xml .= "<CliEndCobNum>".($result['numero'] > 0 ? $result['numero'] : 0 )."</CliEndCobNum>";
			$xml .= "<CliEndCobBairro>".$result['bairro']."</CliEndCobBairro>";
			$xml .= "<CliEndCobCidCodIBGE>".$result['cidadeIBGE']."</CliEndCobCidCodIBGE>";
			$xml .= "<CliEndCobUFCodIBGE>".$result['UFIBGE']."</CliEndCobUFCodIBGE>";
            $xml .= "<CliEndCobPaisCodIBGE>1058</CliEndCobPaisCodIBGE>";
            //Endereço escritório
            $xml .= "<CliContatoEsc>".$result['nome']."</CliContatoEsc>";
			$xml .= "<CliTelefoneEsc>".$result['telefone']."</CliTelefoneEsc>";
			$xml .= "<CliCEPEsc>".$result['CEP']."</CliCEPEsc>";
			$xml .= "<CliEndeEsc>".$result['rua']."</CliEndeEsc>";
			$xml .= "<CliEndEscNum>".($result['numero'] > 0 ? $result['numero'] : 0)."</CliEndEscNum>";
			$xml .= "<CliEndEscBairro>".$result['bairro']."</CliEndEscBairro>";
			$xml .= "<CliEndEscCidCodIBGE>".$result['cidadeIBGE']."</CliEndEscCidCodIBGE>";
			$xml .= "<CliEndEscUFCodIBGE>".$result['UFIBGE']."</CliEndEscUFCodIBGE>";
            $xml .= "<CliEndEscPaisCodIBGE>1058</CliEndEscPaisCodIBGE>";
            $xml .= "</Cliente>";
            
            $key++;

            $sql = "UPDATE clientes
                       SET exporta_webmais = 0
                     WHERE id = ".$result['id'];
            mysqli_query($link, $sql);
        }
        $xml .= "</Clientes></Records>";
        $arquivo = fopen("integracao.xml", "w");
        fwrite($arquivo, $xml);
        fclose($arquivo);
    }else echo "Nenhum resultado encontrado.";
?>
<a href="/owlsoftware/modulos/adm/integracao/integracao.xml" hidden download>Baixar</a>
<script>
    document.querySelector("a").click();
    setTimeout(() => {
        window.close();    
    }, 500);
    
</script>