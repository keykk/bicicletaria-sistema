# Manual de Instalação e Configuração
## Sistema de Gestão de Bicicletaria - BikeSystem

**Versão:** 1.0.0  
**Data:** <?= date('d/m/Y') ?>  
**Autor:** Manus AI  

---

## Sumário

1. [Introdução](#introdução)
2. [Requisitos do Sistema](#requisitos-do-sistema)
3. [Instalação do Ambiente](#instalação-do-ambiente)
4. [Configuração do Banco de Dados](#configuração-do-banco-de-dados)
5. [Instalação do Sistema](#instalação-do-sistema)
6. [Configuração Inicial](#configuração-inicial)
7. [Configuração de Email](#configuração-de-email)
8. [Configuração de Backup](#configuração-de-backup)
9. [Configuração de Segurança](#configuração-de-segurança)
10. [Solução de Problemas](#solução-de-problemas)

---

## Introdução

O BikeSystem é um sistema completo de gestão desenvolvido especificamente para bicicletarias, oferecendo controle de produtos, estoque, orçamentos, tabelas de preço e relatórios avançados. Este manual fornece instruções detalhadas para instalação e configuração do sistema em ambiente de produção.

O sistema foi desenvolvido utilizando arquitetura MVC (Model-View-Controller) em PHP, com banco de dados MariaDB/MySQL e interface responsiva com Bootstrap 5. A arquitetura modular permite fácil manutenção e expansão das funcionalidades.

### Características Principais

O BikeSystem oferece um conjunto abrangente de funcionalidades projetadas para atender às necessidades específicas de uma bicicletaria moderna. O sistema de cadastro de produtos permite o registro detalhado de bicicletas, peças e acessórios, com campos específicos para marca, modelo, aro e tipo de bicicleta. O controle de estoque oferece monitoramento em tempo real das quantidades disponíveis, alertas automáticos para produtos com estoque baixo e histórico completo de movimentações.

O módulo de orçamentos facilita a criação rápida de propostas comerciais, com cálculo automático de totais, impressão em formato profissional e possibilidade de envio por email. As tabelas de preço permitem criar diferentes políticas de preços para diversos tipos de clientes, com atualização em massa e cópia de tabelas existentes.

O sistema de relatórios oferece análises detalhadas de vendas por período, ranking de produtos mais vendidos, controle de estoque crítico e dashboard executivo com indicadores-chave de performance. O controle de usuários permite diferentes níveis de acesso, garantindo segurança e organização das operações.

---

## Requisitos do Sistema

### Requisitos de Hardware

Para garantir o funcionamento adequado do BikeSystem, o servidor deve atender aos seguintes requisitos mínimos de hardware. Em ambientes de produção com alto volume de transações, recomenda-se especificações superiores para otimizar a performance.

**Requisitos Mínimos:**
- Processador: Intel Core i3 ou AMD equivalente (2.0 GHz ou superior)
- Memória RAM: 4 GB (recomendado 8 GB ou mais)
- Armazenamento: 20 GB de espaço livre (SSD recomendado)
- Conexão de rede: 100 Mbps (para acesso remoto)

**Requisitos Recomendados:**
- Processador: Intel Core i5 ou AMD equivalente (3.0 GHz ou superior)
- Memória RAM: 16 GB ou mais
- Armazenamento: 100 GB de espaço livre em SSD
- Conexão de rede: 1 Gbps
- Backup: Sistema de backup automático configurado

### Requisitos de Software

O BikeSystem requer um ambiente LAMP (Linux, Apache, MySQL, PHP) ou equivalente. A compatibilidade foi testada nas versões especificadas abaixo, garantindo estabilidade e segurança.

**Sistema Operacional:**
- Ubuntu 20.04 LTS ou superior (recomendado)
- CentOS 8 ou superior
- Debian 10 ou superior
- Windows Server 2019 ou superior (com XAMPP/WAMP)

**Servidor Web:**
- Apache 2.4 ou superior (recomendado)
- Nginx 1.18 ou superior
- Suporte a mod_rewrite (Apache) ou configuração equivalente (Nginx)

**PHP:**
- PHP 8.0 ou superior (recomendado PHP 8.1)
- Extensões obrigatórias: PDO, PDO_MySQL, mbstring, openssl, curl, gd
- Extensões recomendadas: zip, xml, json, fileinfo
- Configurações: memory_limit >= 256M, max_execution_time >= 300

**Banco de Dados:**
- MariaDB 10.5 ou superior (recomendado)
- MySQL 8.0 ou superior
- Suporte a InnoDB engine
- Configuração de charset UTF-8

### Requisitos de Rede

Para funcionamento adequado em ambiente de rede, considere os seguintes aspectos de conectividade e segurança. O sistema foi projetado para funcionar tanto em redes locais quanto com acesso via internet.

**Conectividade:**
- Acesso HTTP/HTTPS na porta 80/443
- Acesso SSH na porta 22 (para administração)
- Acesso MySQL na porta 3306 (apenas local, por segurança)
- Firewall configurado para bloquear acessos não autorizados

**Certificado SSL:**
- Certificado SSL válido para acesso HTTPS (obrigatório em produção)
- Redirecionamento automático HTTP para HTTPS
- Configuração HSTS (HTTP Strict Transport Security)

---


## Instalação do Ambiente

### Instalação no Ubuntu/Debian

A instalação em sistemas baseados em Debian é o método recomendado devido à estabilidade e facilidade de manutenção. O processo envolve a instalação do stack LAMP e configuração dos componentes necessários.

Primeiro, atualize o sistema operacional para garantir que todas as dependências estejam nas versões mais recentes. Execute os comandos abaixo com privilégios de administrador:

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install software-properties-common apt-transport-https ca-certificates
```

**Instalação do Apache:**

O servidor web Apache será responsável por servir as páginas do sistema. Configure-o com os módulos necessários para o funcionamento adequado do PHP e reescrita de URLs:

```bash
sudo apt install apache2 -y
sudo systemctl enable apache2
sudo systemctl start apache2

# Habilitar módulos necessários
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2enmod headers
sudo systemctl restart apache2
```

**Instalação do PHP:**

O PHP 8.1 oferece melhor performance e recursos de segurança. Instale o PHP junto com as extensões necessárias para o funcionamento do sistema:

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php8.1 php8.1-apache2 php8.1-mysql php8.1-mbstring php8.1-xml php8.1-curl php8.1-gd php8.1-zip php8.1-json -y

# Verificar instalação
php -v
```

**Instalação do MariaDB:**

O MariaDB oferece excelente compatibilidade com MySQL e performance superior. Configure-o com as melhores práticas de segurança:

```bash
sudo apt install mariadb-server mariadb-client -y
sudo systemctl enable mariadb
sudo systemctl start mariadb

# Configuração de segurança
sudo mysql_secure_installation
```

Durante a configuração de segurança, responda as perguntas conforme orientações abaixo:
- Set root password: Y (defina uma senha forte)
- Remove anonymous users: Y
- Disallow root login remotely: Y
- Remove test database: Y
- Reload privilege tables: Y

### Instalação no CentOS/RHEL

Para sistemas baseados em Red Hat, o processo é similar, mas utiliza o gerenciador de pacotes yum ou dnf:

```bash
sudo dnf update -y
sudo dnf install httpd mariadb-server php php-mysqlnd php-mbstring php-xml php-curl php-gd php-zip -y

# Habilitar serviços
sudo systemctl enable httpd mariadb
sudo systemctl start httpd mariadb

# Configurar firewall
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

### Configuração do PHP

Após a instalação, configure o PHP para otimizar a performance e segurança do sistema. Edite o arquivo de configuração principal:

```bash
sudo nano /etc/php/8.1/apache2/php.ini
```

Ajuste as seguintes configurações:

```ini
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
upload_max_filesize = 50M
post_max_size = 50M
date.timezone = America/Sao_Paulo
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
```

Reinicie o Apache para aplicar as alterações:

```bash
sudo systemctl restart apache2
```

---

## Configuração do Banco de Dados

### Criação do Banco de Dados

O banco de dados é o componente central do sistema, armazenando todas as informações de produtos, clientes, orçamentos e configurações. A estrutura foi projetada para garantir integridade referencial e performance otimizada.

Acesse o MariaDB como usuário root e execute os comandos para criar o banco de dados e usuário específico:

```sql
mysql -u root -p

CREATE DATABASE bikesystem CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'bikesystem_user'@'localhost' IDENTIFIED BY 'senha_forte_aqui';
GRANT ALL PRIVILEGES ON bikesystem.* TO 'bikesystem_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Importação da Estrutura

O arquivo `database.sql` contém toda a estrutura de tabelas e dados iniciais necessários. Importe-o utilizando o comando abaixo:

```bash
mysql -u bikesystem_user -p bikesystem < /caminho/para/database.sql
```

### Verificação da Instalação

Após a importação, verifique se todas as tabelas foram criadas corretamente:

```sql
mysql -u bikesystem_user -p bikesystem

SHOW TABLES;
DESCRIBE produtos;
DESCRIBE usuarios;
```

O banco deve conter as seguintes tabelas principais:
- produtos: Cadastro de produtos e serviços
- estoque: Controle de quantidades em estoque
- orcamentos: Orçamentos gerados
- itens_orcamento: Itens de cada orçamento
- tabelas_preco: Tabelas de preços personalizadas
- itens_tabela_preco: Itens das tabelas de preço
- usuarios: Usuários do sistema
- servicos: Registro de serviços prestados

### Configuração de Performance

Para otimizar a performance do banco de dados, especialmente em ambientes com alto volume de transações, configure os parâmetros do MariaDB:

```bash
sudo nano /etc/mysql/mariadb.conf.d/50-server.cnf
```

Adicione ou modifique as seguintes configurações:

```ini
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
query_cache_size = 128M
query_cache_type = 1
max_connections = 200
```

Reinicie o MariaDB para aplicar as configurações:

```bash
sudo systemctl restart mariadb
```

---

## Instalação do Sistema

### Download e Extração

Faça o download dos arquivos do sistema e extraia-os no diretório web do servidor. O diretório padrão do Apache no Ubuntu é `/var/www/html`:

```bash
cd /var/www/html
sudo wget https://github.com/seu-usuario/bikesystem/archive/main.zip
sudo unzip main.zip
sudo mv bikesystem-main bikesystem
sudo chown -R www-data:www-data bikesystem
sudo chmod -R 755 bikesystem
```

### Configuração de Permissões

Configure as permissões adequadas para garantir segurança e funcionamento correto:

```bash
# Permissões gerais
sudo find /var/www/html/bikesystem -type d -exec chmod 755 {} \;
sudo find /var/www/html/bikesystem -type f -exec chmod 644 {} \;

# Permissões especiais para diretórios de escrita
sudo chmod -R 777 /var/www/html/bikesystem/backups
sudo chmod -R 777 /var/www/html/bikesystem/uploads
sudo chmod 666 /var/www/html/bikesystem/config/database.php
```

### Configuração do Virtual Host

Crie um virtual host específico para o sistema, permitindo acesso via domínio personalizado:

```bash
sudo nano /etc/apache2/sites-available/bikesystem.conf
```

Adicione a configuração abaixo:

```apache
<VirtualHost *:80>
    ServerName bikesystem.local
    DocumentRoot /var/www/html/bikesystem/public
    
    <Directory /var/www/html/bikesystem/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/bikesystem_error.log
    CustomLog ${APACHE_LOG_DIR}/bikesystem_access.log combined
</VirtualHost>
```

Habilite o site e reinicie o Apache:

```bash
sudo a2ensite bikesystem.conf
sudo systemctl reload apache2
```

### Configuração HTTPS (Produção)

Para ambiente de produção, configure SSL/TLS usando Let's Encrypt:

```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d seu-dominio.com
```

O Certbot configurará automaticamente o redirecionamento HTTPS e renovação automática do certificado.

---


## Configuração Inicial

### Configuração do Banco de Dados

Edite o arquivo de configuração do banco de dados com as credenciais criadas anteriormente:

```bash
sudo nano /var/www/html/bikesystem/config/database.php
```

Configure os parâmetros de conexão:

```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bikesystem');
define('DB_USER', 'bikesystem_user');
define('DB_PASS', 'senha_forte_aqui');
define('DB_CHARSET', 'utf8mb4');
```

### Primeiro Acesso

Acesse o sistema através do navegador utilizando o endereço configurado. Na primeira execução, o sistema criará automaticamente o usuário administrador padrão:

- **URL:** http://seu-dominio.com/bikesystem
- **Usuário:** admin
- **Senha:** admin123

**IMPORTANTE:** Altere a senha padrão imediatamente após o primeiro acesso por questões de segurança.

### Configuração da Empresa

Acesse o menu "Configurações > Empresa" e preencha as informações da sua bicicletaria:

- Nome da empresa
- Telefone de contato
- Email corporativo
- Endereço completo
- CNPJ (se aplicável)

Essas informações aparecerão nos orçamentos impressos e emails enviados pelo sistema.

---

## Configuração de Email

### Configuração SMTP

Para envio de orçamentos por email, configure o servidor SMTP no arquivo de configuração:

```bash
sudo nano /var/www/html/bikesystem/config/Config.php
```

Localize a seção de configuração de email e ajuste os parâmetros:

```php
// Configurações de email
const EMAIL_SMTP_HOST = 'smtp.gmail.com';
const EMAIL_SMTP_PORT = 587;
const EMAIL_SMTP_USERNAME = 'seu-email@gmail.com';
const EMAIL_SMTP_PASSWORD = 'sua-senha-de-app';
const EMAIL_FROM_NAME = 'Sua Bicicletaria';
const EMAIL_FROM_ADDRESS = 'noreply@suabicicletaria.com.br';
```

### Configuração Gmail

Para usar o Gmail como servidor SMTP:

1. Ative a verificação em duas etapas na sua conta Google
2. Gere uma senha de aplicativo específica
3. Use essa senha no campo `EMAIL_SMTP_PASSWORD`

### Teste de Email

Após a configuração, teste o envio através do menu "Configurações > Sistema > Testar Email".

---

## Configuração de Backup

### Backup Automático

O sistema inclui funcionalidade de backup automático. Configure os parâmetros no arquivo de configuração:

```php
// Configurações de backup
const BACKUP_AUTOMATICO = true;
const BACKUP_INTERVALO_HORAS = 24;
const BACKUP_MANTER_ARQUIVOS = 7; // dias
```

### Configuração do Cron

Para executar backups automáticos, configure uma tarefa cron:

```bash
sudo crontab -e
```

Adicione a linha para backup diário às 2h da manhã:

```bash
0 2 * * * /usr/bin/php /var/www/html/bikesystem/scripts/backup_automatico.php
```

### Backup Manual

Backups manuais podem ser criados através do menu "Configurações > Backup" ou via linha de comando:

```bash
cd /var/www/html/bikesystem
php scripts/criar_backup.php
```

---

## Configuração de Segurança

### Configuração do Firewall

Configure o firewall para permitir apenas as portas necessárias:

```bash
sudo ufw enable
sudo ufw allow 22/tcp    # SSH
sudo ufw allow 80/tcp    # HTTP
sudo ufw allow 443/tcp   # HTTPS
sudo ufw deny 3306/tcp   # MySQL (bloquear acesso externo)
```

### Configuração de Logs

Configure logs detalhados para monitoramento de segurança:

```bash
sudo nano /etc/apache2/conf-available/security.conf
```

Adicione as configurações de segurança:

```apache
ServerTokens Prod
ServerSignature Off
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
```

### Atualizações de Segurança

Configure atualizações automáticas de segurança:

```bash
sudo apt install unattended-upgrades -y
sudo dpkg-reconfigure -plow unattended-upgrades
```

---

## Solução de Problemas

### Problemas Comuns

**Erro de Conexão com Banco de Dados:**
- Verifique as credenciais no arquivo `config/database.php`
- Confirme se o serviço MariaDB está rodando: `sudo systemctl status mariadb`
- Teste a conexão manualmente: `mysql -u bikesystem_user -p bikesystem`

**Erro 500 - Internal Server Error:**
- Verifique os logs do Apache: `sudo tail -f /var/log/apache2/error.log`
- Confirme as permissões dos arquivos: `sudo chown -R www-data:www-data /var/www/html/bikesystem`
- Verifique se o mod_rewrite está habilitado: `sudo a2enmod rewrite`

**Problemas de Performance:**
- Aumente a memória do PHP: `memory_limit = 512M`
- Otimize o banco de dados: `mysql -u root -p -e "OPTIMIZE TABLE bikesystem.*"`
- Configure cache do Apache: `sudo a2enmod expires`

**Problemas de Email:**
- Verifique as configurações SMTP no arquivo Config.php
- Teste a conectividade: `telnet smtp.gmail.com 587`
- Confirme se as portas não estão bloqueadas pelo firewall

### Logs do Sistema

O sistema gera logs detalhados para facilitar a identificação de problemas:

- **Logs do Apache:** `/var/log/apache2/`
- **Logs do PHP:** `/var/log/php_errors.log`
- **Logs do Sistema:** `/var/www/html/bikesystem/logs/`

### Suporte Técnico

Para suporte adicional:

1. Consulte a documentação completa no diretório `docs/`
2. Verifique os logs de erro para identificar a causa do problema
3. Acesse o fórum de suporte da comunidade
4. Entre em contato com o suporte técnico através do email: suporte@bikesystem.com.br

### Backup e Restauração

Em caso de problemas graves, utilize os backups para restaurar o sistema:

```bash
# Restaurar banco de dados
mysql -u bikesystem_user -p bikesystem < backup_bikesystem_2024-01-01.sql

# Restaurar arquivos
sudo cp -r backup_files/* /var/www/html/bikesystem/
sudo chown -R www-data:www-data /var/www/html/bikesystem
```

---

## Conclusão

Este manual fornece todas as informações necessárias para instalação e configuração do BikeSystem em ambiente de produção. Siga cuidadosamente cada etapa para garantir o funcionamento adequado do sistema.

Para dúvidas adicionais ou suporte técnico, consulte a documentação complementar ou entre em contato com nossa equipe de suporte.

**Próximos Passos:**
1. Consulte o Manual do Usuário para aprender a utilizar todas as funcionalidades
2. Configure backups regulares e monitore a performance do sistema
3. Mantenha o sistema sempre atualizado com as versões mais recentes
4. Treine sua equipe nas funcionalidades principais do sistema

---

*Documentação gerada automaticamente pelo BikeSystem v1.0.0*  
*© 2024 - Todos os direitos reservados*

