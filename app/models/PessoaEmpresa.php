<?php
/**
 * Modelo PessoaEmpresa
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class PessoaEmpresa extends BaseModel {
    protected $table = 'pessoa_empresa';

    /**
     * Busca pessoa por ID
     * @param int $id
     * @return array|null
     */
    public function findById($id, $empresa=0) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_pessoa = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Atualiza um registro
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        try {
            $fields = array_keys($data);
            $setClause = implode(' = ?, ', $fields) . ' = ?';
            
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE id_pessoa = ?";
            $stmt = $this->db->prepare($sql);
            
            $values = array_values($data);
            $values[] = $id;

            return $stmt->execute($values);
        } catch (Exception $e) {
            gravarLog("Erro ao atualizar registro: " . $e->getMessage());
            gravarLog("Consulta: " . $sql);
            gravarLog("Campos: " . json_encode($data));
            return false;
        }
    }

    /**
     * Buscar lista de pessoas empresas
     * @return array
     */
    public function getPessoasEmpresas() {
        try {
            $stmt = $this->db->query("SELECT p.id, p.nome, p.nome_fantasia, p.cpf_cnpj FROM {$this->table} inner join pessoa p on p.id = {$this->table}.id_pessoa");
            return $stmt->fetchAll();
        } catch (Exception $e) {
            return null;
        }
    }
    /**
     * Adiciona uma nova pessoa empresa
     * @param array $data
     * @return bool
     */
    public function addPessoaEmpresa($data) {
        return $this->insert($data);
    }

    public function salvarEmpresa($id = null) {

        //Informações basica
        $nomeEmpresa = $_POST['empresa_nome'] ?? null;
        $empresaFantasia = $_POST['empresa_nome_fantasia'] ?? null;
        $cnpj = $_POST['empresa_cnpj'] ?? null;
        $slogan = $_POST['empresa_slogan'] ?? null;
        $endereco = $_POST['empresa_endereco'] ?? null;
        $cidade = $_POST['cidade'] ?? null;
        $estado = $_POST['estado'] ?? null;
        $cep = $_POST['cep'] ?? null;

        //Informações de contato
        $telefone = $_POST['empresa_telefone'] ?? null;
        $whatsapp = $_POST['empresa_whatsapp'] ?? null;
        $email = $_POST['empresa_email'] ?? null;
        $site = $_POST['empresa_website'] ?? null;

        //Redes sociais
        $facebook = $_POST['empresa_facebook'] ?? null;
        $instagram = $_POST['empresa_instagram'] ?? null;
        $twitter = $_POST['empresa_twitter'] ?? null;
        $youtube = $_POST['empresa_youtube'] ?? null;

        //Logo da empresa
        $logo = $_FILES['empresa_logo'] ?? null;

        //Cores da Marca
        $corPrimaria = $_POST['empresa_cor_primaria'] ?? null;
        $corSecundaria = $_POST['empresa_cor_secundaria'] ?? null;

        //Informaçoes adicionais
        $inscricaoEstadual = $_POST['empresa_inscricao_estadual'] ?? null;
        $regimeTributario = $_POST['empresa_regime_tributario'] ?? null;
        $respnsavelTecnico = $_POST['empresa_responsavel'] ?? null;

        $pessoa_dados = [
            'nome' => $nomeEmpresa,
            'nome_fantasia' => $empresaFantasia,
            'tipo' => 'J',
            'cpf_cnpj' => $cnpj,
            'email' => $email,
            'telefone' => $telefone,
            'whatsapp' => $whatsapp,
            'endereco' => $endereco,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep
        ];

        $pessoa = new Pessoa();
        
        $this->db->beginTransaction();
        $id_pessoa = $pessoa->SalvarPessoa($pessoa_dados, $id);

        if(!$id_pessoa['success'] ?? false and empty($id_pessoa['id'] ?? null)) {
            $this->db->rollBack();
            return $id_pessoa;
        }

        $pessoa_empresa_dados = [
            'id_pessoa' => $id_pessoa['id'] ?? $id,
            'slogan' => $slogan,
            'website' => $site,
            'facebook' => $facebook,
            'instagram' => $instagram,
            'twitter' => $twitter,
            'youtube' => $youtube,
            'caminho_logo' => '',//$logo ? $logo['name'] : null, // Aqui você pode implementar o upload do arquivo
            'cor_primaria' => $corPrimaria,
            'cor_secundaria' => $corSecundaria,
            'inscricao_estadual' => $inscricaoEstadual,
            'regime_tributario' => $regimeTributario,
            'nome_responsavel' => $respnsavelTecnico
        ];
        
        $ver = $this->findById($id_pessoa['id'] ?? $id);
        $retorno = [];
        if ($ver) {
            // Atualiza os dados da empresa
            $up = $this->update($ver['id_pessoa'] ?? $id, $pessoa_empresa_dados);
            if (!$up) {
                $retorno = ['success' => false, 'message' => ['Erro ao atualizar empresa.'], 'id' => $ver['id_pessoa'] ?? $id];
            } else {
                $retorno = ['success' => true, 'message' => ['Empresa atualizada com sucesso.'], 'id' => $ver['id_pessoa'] ?? $id];
            }
        } else {
            // Insere nova empresa
            $in = $this->insert($pessoa_empresa_dados);
            if (!$in) {
                $retorno = ['success' => false, 'message' => ['Erro ao cadastrar empresa. id: ' . $id_pessoa['id']]];
            } else {
                $retorno = ['success' => true, 'message' => ['Empresa cadastrada com sucesso.'], 'id' => $in];
            }
        }
        
        if (!$retorno['success'] ?? false) {
            $this->db->rollBack();
            return $retorno;
        } else {
            // Se tudo estiver certo, commit na transação
            $this->db->commit();
            return $retorno;
        }
        
    }
    
       /**
     * Atualizar dados da empresa logada
     * @param int $id
     */
    public function atualizarSessao($id) {
        $dados_empresa = $this->findById($id);

        //Busca os dados da pessoa
        $ps = new Pessoa();
        $pessoa = $ps->findById($id);

        // Atualiza os dados da sessão
        if (!$pessoa) {
            // Se não encontrar a pessoa, define um erro
            $_SESSION['login_error'] = 'Empresa não encontrada.';
            return;
        }

        $_SESSION['empresa_id'] = $id;
        $_SESSION['empresa_data'] = [
            'id' => $pessoa['id'],
            'nome' => $pessoa['nome'],
            'nome_fantasia' => $pessoa['nome_fantasia'],
            'cnpj' => $pessoa['cpf_cnpj'],
            'slogan' => $dados_empresa['slogan'],
            'endereco' => $pessoa['endereco'],
            'cidade' => $pessoa['cidade'],
            'estado' => $pessoa['estado'],
            'cep' => $pessoa['cep'],
            'telefone' => $pessoa['telefone'],
            'whatsapp' => $pessoa['whatsapp'],
            'email' => $pessoa['email'],
            'website' => $dados_empresa['website'],
            'facebook' => $dados_empresa['facebook'],
            'instagram' => $dados_empresa['instagram'],
            'twitter' => $dados_empresa['twitter'],
            'youtube' => $dados_empresa['youtube'],
            'linkedin' => $dados_empresa['linkedin'],
            'logo' => $dados_empresa['caminho_logo'],
            'cor_primaria' => $dados_empresa['cor_primaria'],
            'cor_secundaria' => $dados_empresa['cor_secundaria'],
            'inscricao_estadual' => $dados_empresa['inscricao_estadual'],
            'regime_tributario' => $dados_empresa['regime_tributario'],
            'responsavel' => $dados_empresa['nome_responsavel']
        ];

    }
}

?>