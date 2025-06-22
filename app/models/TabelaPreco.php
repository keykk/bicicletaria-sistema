<?php
/**
 * Modelo Tabela de Preço
 * Sistema de Gestão de Bicicletaria
 */

require_once 'BaseModel.php';

class TabelaPreco extends BaseModel {
    protected $table = 'tabelas_preco';
    
    /**
     * Cria uma nova tabela de preço com itens
     * @param array $dadosTabela
     * @param array $itens
     * @return int|false ID da tabela criada ou false em caso de erro
     */
    public function criarTabela($dadosTabela, $itens = []) {
        try {
            $itemTabelaModel = new ItemTabelaPreco();
            $itemTabelaModel->db->beginTransaction();
            
            // Inserir a tabela de preço
            $idTabela = $this->insert($dadosTabela);
            
            if (!$idTabela) {
                $itemTabelaModel->db->rollBack();
                return false;
            }
            
            // Inserir os itens da tabela de preço
            if (!empty($itens)) {
               
                foreach ($itens as $item) {
                    $item['id_tabela'] = $idTabela;
                    if (!$itemTabelaModel->insert($item)) {
                        $itemTabelaModel->db->rollBack();
                        return false;
                    }
                }
            }
            
            $itemTabelaModel->db->commit();
            return $idTabela;
        } catch (Exception $e) {
            gravarLog("Erro ao criar tabela de preço: " . $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }
    
    /**
     * Busca tabela com itens
     * @param int $id
     * @return array|null
     */
    public function findWithItens($id) {
        try {
            $tabela = $this->findById($id);
            if (!$tabela) {
                return null;
            }
            
            // Buscar itens da tabela
            $sql = "
                SELECT 
                    itp.*,
                    p.nome as produto_nome,
                    p.categoria,
                    p.unidade_medida
                FROM itens_tabela_preco itp
                INNER JOIN produtos p ON itp.id_produto = p.id
                WHERE itp.id_tabela = ?
                ORDER BY p.categoria, p.nome
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            $tabela['itens'] = $stmt->fetchAll();
            
            return $tabela;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Copia uma tabela de preço existente
     * @param int $idTabelaOrigem
     * @param string $novoNome
     * @return int|false ID da nova tabela ou false em caso de erro
     */
    public function copiarTabela($idTabelaOrigem, $novoNome) {
        try {
            $tabelaOrigem = $this->findWithItens($idTabelaOrigem);
            if (!$tabelaOrigem) {
                return false;
            }
            
            // Criar nova tabela
            $dadosNovaTabela = [
                'nome' => $novoNome
            ];
            $itens = $tabelaOrigem['itens'];
            
            $itens = array_map(function($item) {
                unset($item['produto_nome'], $item['categoria'], $item['unidade_medida'], $item['id']);
                return $item;
            }, $itens);

            return $this->criarTabela($dadosNovaTabela, $itens);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Atualiza preços em massa
     * @param int $idTabela
     * @param float $percentualAumento
     * @return bool
     */
    public function atualizarPrecosEmMassa($idTabela, $percentualAumento) {
        try {
            $sql = "
                UPDATE itens_tabela_preco 
                SET preco = preco * (1 + ? / 100)
                WHERE id_tabela = ?
            ";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$percentualAumento, $idTabela]);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Busca preço de um produto em uma tabela específica
     * @param int $idTabela
     * @param int $idProduto
     * @return float|null
     */
    public function getPrecoProduto($idTabela, $idProduto) {
        try {
            $sql = "
                SELECT preco 
                FROM itens_tabela_preco 
                WHERE id_tabela = ? AND id_produto = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idTabela, $idProduto]);
            $result = $stmt->fetch();
            
            return $result ? $result['preco'] : null;
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Valida os dados da tabela
     * @param array $data
     * @return array Erros de validação
     */
    public function validate($data) {
        $errors = [];
        
        if (empty($data['nome'])) {
            $errors[] = 'Nome da tabela é obrigatório';
        }
        
        return $errors;
    }
}

