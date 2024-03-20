# Farm Control App

Este é um sistema de controle de Fazenda Desenvolvido para gerenciar o cadastro de 
bovinos, fazendas e gados. Ele permite o regitro e acompanhamento de informações 
importantes relacionadas a criação de gado, como dados do bovino, fazendas e 
controle de abate. 

### Principais Recursos

- Cadastro de Bovinos: Registre informações detalhadas sobre bovinos, incluindo 
códigon de indentificação do animal, peso, produção de leite, data de nascimento e mais.
- Cadastro de Fazendas: Gerencie informações sobre as fazendas, como nome, tamanho,
responsável e veterinários associados.
- Controle de Gados: Acompanhe o status dos gados, incluindo se estão vivos, abatidos,
e registre os dados de abate quando necessário.
- Interface Intuitiva: O sistema possui uma interface fácil de usar, permitindo 
- navegação e utilização sem complicações. 

### Pré-requisitos

Certifique-se de ter o Docker instalado em sua máquina. Você pode encontrar instruções
de instalação para diferentes sistemas operacionais no link https://docs.docker.com/

## Iniciando o Projeto

### 1. Clone este repositório para o seu ambiente de desenvolvimento:
`git clone git@github.com:ellenjulia4rr/Farm-Control-App.git
`
### 2. Navegue até o diretório do projeto:

### 3. Construa os contêineres Docker:
`docker-compose build`

### 4. Inicie os contêineres Docker:
`docker-compose up -d`

### 5. Instale as dependências do projeto:
`docker-compose exec php-apache composer install`

### 6. Configurando o Banco
Para configurar o banco adicione a linha abaixo ao seu arquivo '.env', ou, se preferir 
utilize as suas próprias credenciais, lembrando que é necessário realziar a alteração
também no seu arquivo 'docker-compose.yml'.

`DATABASE_URL="mysql://user:password@mysql:3306/symfony?serverVersion=8.0.32&charset=utf8mb4"`

### 7. Execute as migrations:
`docker-compose exec php-apache bin/console d:m:m
`
### 8. Acesse o sistema em seu navegador da web através do seguinte URL:
http://localhost:8000


