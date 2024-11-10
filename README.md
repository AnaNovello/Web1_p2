# Mini Sistema de Cadastro para Cozinheiros

## Descrição

Este projeto foi desenvolvido a partir do Mini Sistema de Portifólio para Cozinheiros, a fim de testar requisições assíncronas utilizando Ajax e jQuery. Em comparação com o projeto anterior, a maior parte das features foi retirada para melhor vizualização de como as requisições em Ajax e jQuery iriam trabalhar.

## Funcionalidades
- **Cadastro simples de usuário:** O usuário pode se cadastrar no sistema;
- **Operações em Entidades Secundárias:** Além da entidade principal, é possível criar, visualizar e deletar informações relacionadas às entidades secundárias;
- **Listagem de dados:** O sistema é capaz de listar os dados das entidades secundárias, no entanto, a associação é feita por um identificador único atrelada ao usuário, portanto apenas os cadastros(secundários) feitos antes do cadastro final irão aparecer na listagem.

## Estrutura do Projeto
/css          -> Arquivos de estilo (CSS)  
/js          -> Scripts usados no projeto  


## Tecnologias Utilizadas
- **Banco de Dados:** PostgreSQL
- **Servidor:** XAMPP
- **Linguagens:** PHP, JavaScript, HTML e CSS

## Instalação
Para rodar este projeto localmente, siga os passos abaixo:

1. Certifique-se de que o XAMPP esteja instalado e em execução.
2. Crie uma pasta com o nome 'p2' dentro da pasta htdocs
3. Clone o repositório dentro da pasta 'p2'
4. Instale o PostgreSQL e crie um novo banco de dados utilizando o script SQL fornecido(sql_v2.sql)
5. Configure o arquivo conexao.php com suas credenciais do banco de dados.
6. Acesse a aplicação pelo navegador em: http://localhost/p2/index.html
