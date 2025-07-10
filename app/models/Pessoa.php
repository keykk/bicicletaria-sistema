<?php
/**
 * Modelo Pessoa
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseModel.php';

class Pessoa extends BaseModel {
    protected $table = 'pessoa';

    /**
     * Busca pessoa por CPF
     * @param string $cpf
     * @return array|null
     */
    public function findByCpf($cpf) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE cpf_cnpj = ?");
            $stmt->execute([$cpf]);
            return $stmt->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    public function SalvarPessoa($data, $id=null) {

        $errors = $this->validatePessoa($data);
        
        if (!empty($errors)) {
            return ['success' => false, 'message' => $errors];
            exit;
        }

        //verifica se já existe uma pessoa com o mesmo CPF/CNPJ
        $existingPessoa = $this->findById($id) ?? $this->findByCpf($data['cpf_cnpj']);
        // Se já existir, atualiza
        if ($existingPessoa) {
            // Atualiza os campos necessários
            $id = $existingPessoa['id'];
            $up = $this->update($id, $data);
            if (!$up) {
                return ['success' => false, 'message' => ['Erro ao atualizar pessoa.'], 'id' => $id];
            } else {
                return ['success' => true, 'message' => ['Pessoa atualizada com sucesso.'], 'id' => $id];
            }
        } else {
            // Se não existir, insere nova pessoa
            $cad = $this->insert($data);
            if (!$cad) {
                return ['success' => false, 'message' => ['Erro ao cadastrar pessoa.']];
            } else {
                return ['success' => true, 'message' => ['Pessoa cadastrada com sucesso.'], 'id' => $cad];
            }
        }
    }

    public function validatePessoa($data) {
        $errors = [];
        
        if (empty($data['nome'])) {
            $errors[] = 'O nome é obrigatório.';
        }
        
        if (empty($data['cpf_cnpj'])) {
            $errors[] = 'O CPF/CNPJ é obrigatório.';
        }

        if (strlen($data['cpf_cnpj']) > 20) {
            $errors[] = 'O CPF/CNPJ deve ter entre 11 e 14 caracteres.';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'O email é inválido.';
        }
        
        return $errors;
    }
}

?>