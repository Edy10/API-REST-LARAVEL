# Desafio-Stefanini

## Instruções do projeto

Para a execução do projeto é preciso ter o PHP >= 7 instalado e configurado na maquina.

Versão do Laravel é 8.x

- Realiza o download do dump do banco "Dump20220414.7z" e executa os inscripts para a criação do Banco de Dados do projeto. 
- Após a criação do banco, verificar as credenciais de conexão no argivo .env do projeto "app_calcadista"

## Inicialização do projeto
- Após clonar o projeto e com o banco criado "conforme o dump", navegar até o projeto "app_calcadista" e executar o comando "php artisan serve" para inicializar o servido. 

Como o projeto já configurado e rodando, acessar as endpoint conforme segue abaixo.

### Endpoint api do projeto
- **[Login](http://127.0.0.1:8000/api/v1/auth/login)**
- **[Users](http://127.0.0.1:8000/api/v1/users)**
- **[Logaut](http://127.0.0.1:8000/api/v1/auth/refresh)**
- **[refresh](http://127.0.0.1:8000/api/v1/auth/refresh/)**
- **[Pedidos](http://127.0.0.1:8000/api/v1/pedidos)**
- **[Lotes](http://127.0.0.1:8000/api/v1/lotes)**
- **[Produtos](http://127.0.0.1:8000/api/v1/produtos/)**
- **[Clientes](http://127.0.0.1:8000/api/v1/clientes)**
- **[Nota fiscal](http://127.0.0.1:8000/api/v1/notaFiscal)**
- **[Alteração Pedido](http://127.0.0.1:8000/api/v1/pedidos/alteracao)**
- **[Alteração Produto](http://127.0.0.1:8000/api/v1/pedidos/alteracao)**

É necessário está logado e com o token válido para realizar as requisições nas endpoit.
**[Aqui está uma documentação mais detalhada dos endipoint.](https://documenter.getpostman.com/view/16113745/Uyr4Kzqu)**
