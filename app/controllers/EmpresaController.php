<?php
/**
 * Empresa Controller
 * Sistema de Gestão de Bicicletaria
 */

//require_once 'BaseController.php';

class EmpresaController extends BaseController {
    public function index() {
        // Verifica se o usuário está logado
        $this->requireLogin_empresa();
        $pessoa_empresa = new PessoaEmpresa();
        // Busca os dados da empresa
        $empresas = $pessoa_empresa->getPessoasEmpresas();

        // Carrega a view com os dados da empresa
        $data = [
            'title' => 'Empresa - Sistema de Gestão',
            'empresas' => $empresas,
            'error' => $_SESSION['login_error'] ?? null
        ];

        // Limpar erro da sessão
        unset($_SESSION['empresa_id']);
        unset($_SESSION['empresa_data']);
        unset($_SESSION['login_error']);
        
        $this->loadView('empresa/index', $data);
    }

    public function novo() {
        // Verifica se o usuário está logado
        $this->requireLogin_empresa();
        $error = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nova_empresa = new PessoaEmpresa();
            $resultado = $nova_empresa->salvarEmpresa();

            if ($resultado['success'] ?? false) {
                // Redireciona para a página de seleção de empresa
                //$_SESSION['empresa_id'] = $resultado['id'];
                $this->redirect('/empresa');
                exit;
            } else {
                // Define um erro na sessão
                $error = $resultado['message'];
            }
        }

        // Carrega a view para criar uma nova empresa
        $data = [
            'title' => 'Nova Empresa - Sistema de Gestão',
            'errors' => $error
        ];

        $this->loadView('empresa/novo', $data);
    }

    
 

    public function select() {
        // Verifica se o usuário está logado
        $this->requireLogin_empresa();

        // Verifica se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empresaId = (int)$_POST['lista_empresa'] ?? null;
            $emp = new PessoaEmpresa();
            $ver = $emp->findById($empresaId);
            if ($ver) {
                $emp->atualizarSessao($empresaId);

                $this->redirect('/dashboard');
                exit;
            } else {
                // Define um erro de seleção de empresa
                $_SESSION['login_error'] = 'Selecione uma empresa válida.';
            }
        } else {
            $_SESSION['login_error'] = 'Selecione uma empresa válida.';
        }

        // Redireciona de volta para a página de seleção de empresa
        $this->redirect('/empresa');
        exit;
    }
}