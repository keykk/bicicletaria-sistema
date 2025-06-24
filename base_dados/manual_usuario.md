# Manual do Usuário
## Sistema de Gestão de Bicicletaria - BikeSystem

**Versão:** 1.0.0  
**Data:** <?= date('d/m/Y') ?>  
**Autor:** Manus AI  

---

## Sumário

1. [Introdução ao Sistema](#introdução-ao-sistema)
2. [Primeiros Passos](#primeiros-passos)
3. [Gestão de Produtos](#gestão-de-produtos)
4. [Controle de Estoque](#controle-de-estoque)
5. [Criação de Orçamentos](#criação-de-orçamentos)
6. [Tabelas de Preço](#tabelas-de-preço)
7. [Módulo de Serviços](#módulo-de-serviços)
8. [Relatórios e Análises](#relatórios-e-análises)
9. [Configurações do Sistema](#configurações-do-sistema)
10. [Dicas e Melhores Práticas](#dicas-e-melhores-práticas)

---

## Introdução ao Sistema

O BikeSystem é uma solução completa desenvolvida especificamente para atender às necessidades de gestão de bicicletarias modernas. O sistema integra todas as operações essenciais do negócio em uma interface intuitiva e responsiva, permitindo que você gerencie produtos, estoque, orçamentos e relatórios de forma eficiente e profissional.

### Visão Geral das Funcionalidades

O sistema foi projetado com foco na experiência do usuário, oferecendo navegação intuitiva e acesso rápido às funcionalidades mais utilizadas. A interface responsiva garante que você possa acessar o sistema tanto em computadores desktop quanto em tablets e smartphones, proporcionando flexibilidade para gerenciar seu negócio de qualquer lugar.

O dashboard principal apresenta uma visão consolidada do seu negócio, exibindo indicadores-chave como produtos com estoque baixo, vendas do mês, orçamentos recentes e estatísticas de performance. Esta centralização de informações permite tomadas de decisão mais rápidas e assertivas.

### Arquitetura do Sistema

O BikeSystem utiliza arquitetura MVC (Model-View-Controller), garantindo organização do código, facilidade de manutenção e escalabilidade. O banco de dados foi estruturado com relacionamentos otimizados para garantir integridade dos dados e performance adequada mesmo com grandes volumes de informações.

A segurança é uma prioridade, com sistema de autenticação robusto, controle de acesso por níveis de usuário e criptografia de senhas. Todas as operações são registradas em logs para auditoria e rastreabilidade.

---

## Primeiros Passos

### Acessando o Sistema

Para acessar o BikeSystem, abra seu navegador web e digite o endereço fornecido pelo administrador do sistema. A tela de login apresentará campos para usuário e senha, além de opção para lembrar o login em dispositivos confiáveis.

**Credenciais Padrão (primeiro acesso):**
- Usuário: admin
- Senha: admin123

**IMPORTANTE:** Altere a senha padrão imediatamente após o primeiro acesso através do menu "Configurações > Minha Conta".

### Navegação Principal

Após o login, você será direcionado ao dashboard principal. A navegação do sistema é organizada em um menu lateral que permanece acessível em todas as telas, facilitando a movimentação entre os módulos.

**Estrutura do Menu Principal:**
- **Dashboard:** Visão geral do negócio com indicadores principais
- **Produtos:** Cadastro e gestão do catálogo de produtos
- **Estoque:** Controle de quantidades e movimentações
- **Orçamentos:** Criação e gestão de propostas comerciais
- **Tabelas de Preço:** Gestão de preços diferenciados
- **Serviços:** Registro de manutenções e reparos
- **Relatórios:** Análises e estatísticas do negócio
- **Configurações:** Ajustes do sistema e empresa

### Personalizando o Dashboard

O dashboard pode ser personalizado conforme suas necessidades. Os cards informativos exibem dados em tempo real e podem ser reorganizados clicando e arrastando. As informações incluem:

- **Produtos Cadastrados:** Total de itens no catálogo
- **Estoque Baixo:** Produtos que precisam de reposição
- **Orçamentos do Mês:** Quantidade e valor total
- **Vendas Recentes:** Últimas transações realizadas

### Configuração Inicial

Antes de começar a utilizar o sistema, configure as informações básicas da sua empresa através do menu "Configurações > Empresa". Estas informações aparecerão nos orçamentos impressos e comunicações com clientes:

- Nome da bicicletaria
- Endereço completo
- Telefones de contato
- Email corporativo
- CNPJ (se aplicável)
- Logo da empresa (opcional)

---

## Gestão de Produtos

### Cadastrando Produtos

O módulo de produtos é o coração do sistema, permitindo cadastrar todo o catálogo da sua bicicletaria de forma organizada e detalhada. Para acessar, clique em "Produtos" no menu lateral e depois em "Novo Produto".

**Informações Básicas:**
- **Nome do Produto:** Seja descritivo e específico (ex: "Bicicleta Mountain Bike Aro 29 Shimano 21v")
- **Descrição:** Detalhes técnicos e características importantes
- **Categoria:** Classifique entre Bicicletas, Peças, Acessórios, Serviços ou Ferramentas
- **Unidade de Medida:** Unidade, Par, Metro, Quilograma, Litro ou Serviço
- **Preço de Venda:** Valor praticado para o cliente final

**Campos Específicos para Bicicletas:**

Quando a categoria "Bicicletas" é selecionada, campos adicionais são exibidos automaticamente:
- **Marca:** Fabricante da bicicleta (Caloi, Specialized, Trek, etc.)
- **Modelo:** Linha específica do produto
- **Aro:** Tamanho da roda (12, 14, 16, 20, 24, 26, 27.5, 29, 700c)
- **Tipo:** Classificação (Mountain Bike, Speed, Urbana, BMX, Infantil, Elétrica, Dobrável)

### Organizando o Catálogo

Uma organização eficiente do catálogo facilita a localização de produtos e agiliza o atendimento. Utilize as funcionalidades de busca e filtros para encontrar rapidamente os itens desejados.

**Dicas de Organização:**
- Use nomes padronizados para facilitar buscas
- Mantenha descrições detalhadas e atualizadas
- Utilize categorias de forma consistente
- Inclua informações técnicas relevantes na descrição

### Editando e Removendo Produtos

Para editar um produto, acesse a listagem em "Produtos" e clique no ícone de edição (lápis) ao lado do item desejado. Todas as informações podem ser alteradas, exceto o ID único do produto.

A remoção de produtos deve ser feita com cuidado, pois pode afetar históricos de orçamentos e movimentações de estoque. O sistema exibirá um aviso antes de confirmar a exclusão.

### Importação em Massa

Para facilitar a migração de sistemas anteriores ou cadastro de grandes quantidades de produtos, o sistema suporta importação via arquivo CSV. O arquivo deve seguir o formato específico disponível no menu "Produtos > Importar".

---

## Controle de Estoque

### Visão Geral do Estoque

O módulo de estoque oferece controle completo das quantidades disponíveis, com alertas automáticos para produtos com estoque baixo e relatórios detalhados de movimentações. Acesse através do menu "Estoque" para visualizar a situação atual.

### Movimentações de Estoque

**Entrada de Produtos:**

Para registrar entrada de mercadorias, acesse "Estoque > Entrada" e siga os passos:
1. Selecione o produto na lista suspensa
2. Informe a quantidade recebida
3. Confirme a operação

O sistema atualizará automaticamente o saldo e registrará a movimentação com data e hora.

**Saída de Produtos:**

Registre saídas através de "Estoque > Saída":
1. Selecione o produto
2. Informe a quantidade vendida ou utilizada
3. Adicione observações se necessário
4. Confirme a operação

**Ajuste de Estoque:**

Para correções de inventário, utilize "Estoque > Ajuste":
1. Selecione o produto
2. Informe a quantidade correta atual
3. O sistema calculará automaticamente a diferença
4. Adicione justificativa para o ajuste

### Alertas de Estoque Baixo

O sistema monitora continuamente os níveis de estoque e exibe alertas quando produtos atingem quantidades críticas. Por padrão, produtos com 5 unidades ou menos são considerados com estoque baixo.

Os alertas aparecem:
- No dashboard principal
- Na tela de relatório de estoque
- Em notificações por email (se configurado)

### Relatório de Estoque

O relatório completo de estoque apresenta informações detalhadas sobre todos os produtos:
- Quantidade atual em estoque
- Valor unitário e total por produto
- Status do estoque (OK, Baixo, Crítico)
- Valor total do estoque

Este relatório pode ser exportado em formato CSV para análises externas ou integração com outros sistemas.

---


## Criação de Orçamentos

### Processo de Orçamentação

O módulo de orçamentos é uma das funcionalidades mais importantes do sistema, permitindo criar propostas profissionais de forma rápida e eficiente. O processo foi otimizado para reduzir o tempo de atendimento e melhorar a experiência do cliente.

Para criar um novo orçamento, acesse "Orçamentos > Novo Orçamento" e siga o processo estruturado em etapas:

**Dados do Cliente:**
- Nome completo do cliente
- Telefone de contato (formatação automática)
- Email (necessário para envio eletrônico)

**Adição de Itens:**

O sistema permite adicionar múltiplos produtos ao orçamento com cálculo automático de subtotais:
1. Selecione o produto na lista suspensa
2. Informe a quantidade desejada
3. O preço é preenchido automaticamente (pode ser editado)
4. O subtotal é calculado em tempo real
5. Use "Adicionar Item" para incluir mais produtos

**Cálculos Automáticos:**

O sistema realiza todos os cálculos automaticamente:
- Subtotal por item (quantidade × preço)
- Total geral do orçamento
- Atualização em tempo real conforme alterações

### Gerenciamento de Orçamentos

**Visualização de Orçamentos:**

A listagem de orçamentos apresenta informações resumidas com filtros por período:
- Número sequencial do orçamento
- Nome do cliente e dados de contato
- Data e hora de criação
- Valor total
- Ações disponíveis (visualizar, imprimir, enviar, excluir)

**Detalhamento Completo:**

Ao visualizar um orçamento específico, todas as informações são apresentadas de forma organizada:
- Dados completos do cliente
- Lista detalhada de itens com quantidades e preços
- Totais e subtotais
- Data de criação e validade
- Status do orçamento

### Impressão e Envio

**Impressão Profissional:**

O sistema gera orçamentos em formato profissional para impressão em papel A4:
- Cabeçalho com informações da empresa
- Dados do cliente organizados
- Tabela detalhada de itens
- Totais destacados
- Termos e condições padrão
- Rodapé com informações de contato

**Envio por Email:**

Para orçamentos com email cadastrado, é possível enviar automaticamente:
- Email formatado em HTML profissional
- Orçamento completo no corpo da mensagem
- Informações de contato da empresa
- Instruções para confirmação do pedido

### Controle de Validade

Todos os orçamentos possuem validade padrão de 30 dias, claramente indicada nos documentos impressos e emails. Esta informação ajuda a criar senso de urgência e facilita o controle comercial.

---

## Tabelas de Preço

### Conceito e Aplicação

As tabelas de preço permitem criar políticas de preços diferenciadas para diversos tipos de clientes ou situações comerciais. Esta funcionalidade é especialmente útil para:
- Preços diferenciados para atacado e varejo
- Promoções e campanhas sazonais
- Descontos para clientes especiais
- Preços por categoria de cliente

### Criando Tabelas de Preço

Para criar uma nova tabela, acesse "Tabelas de Preço > Nova Tabela":
1. Defina um nome descritivo (ex: "Tabela Promocional Verão", "Preços Atacado")
2. Confirme a criação
3. Adicione produtos à tabela com preços específicos

### Gerenciamento de Preços

**Adicionando Produtos:**

Na tela de edição da tabela:
1. Selecione o produto desejado
2. O preço original é exibido como referência
3. Defina o novo preço para esta tabela
4. Confirme a adição

**Atualização em Massa:**

Para ajustar todos os preços de uma tabela simultaneamente:
1. Acesse a opção "Atualização em Massa"
2. Defina o percentual de ajuste (positivo para aumento, negativo para desconto)
3. Confirme a operação

**Cópia de Tabelas:**

Para criar variações de tabelas existentes:
1. Selecione a tabela base
2. Use a opção "Copiar Tabela"
3. Defina um novo nome
4. Ajuste os preços conforme necessário

### Aplicação em Orçamentos

Durante a criação de orçamentos, você pode selecionar qual tabela de preços utilizar, permitindo aplicar automaticamente os valores diferenciados conforme a política comercial estabelecida.

---

## Módulo de Serviços

### Registro de Serviços

O módulo de serviços permite registrar e acompanhar manutenções, reparos e outros serviços prestados pela bicicletaria. Esta funcionalidade é essencial para oficinas que oferecem serviços além da venda de produtos.

**Informações do Serviço:**
- Dados completos do cliente
- Descrição detalhada do problema
- Serviços a serem realizados
- Valor do serviço
- Data de entrada e previsão de entrega
- Status atual (Aguardando, Em Andamento, Concluído)

### Controle de Status

O sistema permite acompanhar o progresso dos serviços através de status bem definidos:
- **Aguardando:** Serviço recebido, aguardando início
- **Em Andamento:** Serviço sendo executado
- **Aguardando Peças:** Parado por falta de componentes
- **Concluído:** Serviço finalizado, pronto para retirada
- **Entregue:** Serviço entregue ao cliente

### Relatórios de Serviços

O módulo gera relatórios específicos para acompanhamento:
- Serviços por status
- Faturamento de serviços por período
- Tempo médio de execução
- Serviços em atraso

---

## Relatórios e Análises

### Dashboard Executivo

O dashboard executivo oferece uma visão consolidada do negócio com indicadores-chave de performance (KPIs):
- Total de produtos cadastrados
- Orçamentos do mês (quantidade e valor)
- Produtos com estoque baixo
- Vendas dos últimos 7 dias
- Top 5 produtos mais vendidos

### Relatório de Vendas

Análise detalhada das vendas por período personalizável:
- Filtros por data de início e fim
- Total de orçamentos no período
- Valor total e médio das vendas
- Gráfico de vendas por dia
- Lista detalhada de todos os orçamentos

### Produtos Mais Vendidos

Ranking dos produtos com maior volume de vendas:
- Quantidade total vendida por produto
- Valor total faturado por item
- Número de orçamentos que incluíram o produto
- Análise por categoria de produto

### Relatório de Estoque Crítico

Identificação de produtos que necessitam reposição urgente:
- Lista de produtos com estoque baixo
- Configuração de limite personalizado
- Valor total imobilizado em estoque baixo
- Sugestões de reposição

### Exportação de Dados

Todos os relatórios podem ser exportados em formato CSV para análises externas:
- Compatibilidade com Excel e Google Sheets
- Dados formatados e organizados
- Encoding UTF-8 para caracteres especiais
- Separadores configuráveis

---

## Configurações do Sistema

### Configurações da Empresa

Mantenha sempre atualizadas as informações da sua empresa:
- Razão social e nome fantasia
- Endereço completo
- Telefones e email de contato
- CNPJ e inscrição estadual
- Logo da empresa (para orçamentos)

### Gerenciamento de Usuários

**Criação de Usuários:**

Para adicionar novos usuários ao sistema:
1. Acesse "Configurações > Usuários"
2. Clique em "Novo Usuário"
3. Preencha nome, email e senha
4. Defina o nível de acesso
5. Confirme a criação

**Níveis de Acesso:**
- **Administrador:** Acesso completo a todas as funcionalidades
- **Gerente:** Acesso a relatórios e configurações básicas
- **Operador:** Acesso a produtos, estoque e orçamentos
- **Consulta:** Apenas visualização de dados

### Configuração de Email

Para habilitar o envio de orçamentos por email:
1. Configure servidor SMTP
2. Defina credenciais de autenticação
3. Teste o envio através da opção "Testar Email"
4. Ajuste templates de email se necessário

### Sistema de Backup

**Backup Automático:**

Configure backups automáticos para proteção dos dados:
- Frequência de backup (diário recomendado)
- Quantidade de arquivos a manter
- Local de armazenamento dos backups

**Backup Manual:**

Crie backups manuais antes de atualizações importantes:
1. Acesse "Configurações > Backup"
2. Clique em "Criar Backup"
3. Aguarde a conclusão do processo
4. Faça download do arquivo gerado

### Configurações de Segurança

Mantenha o sistema seguro através de:
- Senhas fortes para todos os usuários
- Atualizações regulares do sistema
- Monitoramento de logs de acesso
- Backup regular dos dados

---

## Dicas e Melhores Práticas

### Organização de Dados

**Cadastro de Produtos:**
- Use nomenclatura padronizada e descritiva
- Mantenha categorias organizadas e consistentes
- Inclua informações técnicas relevantes
- Atualize preços regularmente

**Controle de Estoque:**
- Faça contagens físicas periódicas
- Registre movimentações imediatamente
- Configure alertas de estoque baixo adequados
- Mantenha histórico de fornecedores

### Atendimento ao Cliente

**Criação de Orçamentos:**
- Seja detalhado na descrição dos produtos
- Inclua informações de garantia quando aplicável
- Mantenha dados de contato atualizados
- Faça follow-up de orçamentos pendentes

**Comunicação:**
- Use o envio por email para agilizar o processo
- Mantenha templates de email profissionais
- Responda rapidamente às solicitações
- Documente acordos especiais

### Análise de Negócio

**Uso de Relatórios:**
- Analise relatórios semanalmente
- Identifique tendências de vendas
- Monitore produtos com baixo giro
- Acompanhe sazonalidades do negócio

**Tomada de Decisões:**
- Base decisões em dados concretos
- Compare períodos para identificar crescimento
- Identifique oportunidades de melhoria
- Ajuste estratégias conforme resultados

### Manutenção do Sistema

**Rotinas Recomendadas:**
- Backup semanal dos dados
- Verificação mensal de relatórios
- Limpeza de dados desnecessários
- Atualização de informações da empresa

**Segurança:**
- Altere senhas periodicamente
- Monitore acessos ao sistema
- Mantenha software atualizado
- Treine usuários em boas práticas

### Expansão e Crescimento

**Preparação para Crescimento:**
- Organize dados desde o início
- Padronize processos operacionais
- Documente procedimentos importantes
- Treine equipe adequadamente

**Integração com Outros Sistemas:**
- Mantenha dados organizados para facilitar integrações
- Use exportações CSV para análises externas
- Considere APIs para integrações futuras
- Documente customizações realizadas

---

## Conclusão

O BikeSystem foi desenvolvido para ser uma ferramenta completa e intuitiva para gestão de bicicletarias. Este manual apresenta as principais funcionalidades e melhores práticas para aproveitamento máximo do sistema.

**Lembre-se:**
- Mantenha dados sempre atualizados
- Faça backups regulares
- Utilize relatórios para tomada de decisões
- Treine sua equipe adequadamente
- Mantenha o sistema sempre atualizado

Para suporte adicional, consulte a documentação técnica ou entre em contato com nossa equipe através dos canais oficiais.

**Recursos Adicionais:**
- Documentação técnica completa
- Vídeos tutoriais (em desenvolvimento)
- Fórum da comunidade
- Suporte técnico especializado

---

*Manual do Usuário - BikeSystem v1.0.0*  
*© 2024 - Todos os direitos reservados*

