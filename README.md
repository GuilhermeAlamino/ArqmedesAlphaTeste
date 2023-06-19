# ArqmedesAlphaTeste

# Você quer ser um desenvolvedor na Arqmedes?

Criamos esse teste para avaliar seus conhecimentos e habilidades como desenvolvedor FullStack.

# O teste

O desafio é desenvolver um sistema de gerenciamento de produtos. Esse sistema será composto de um cadastro de produtos e categorias. Os requisitos desse sistema estão listados nos tópicos abaixo.
Não existe certo ou errado, queremos saber como você se sai em situações reais como esse desafio.

# Instruções

- O foco principal do nosso teste é o backend. Para facilitar, você poderá utilizar os arquivos html  disponíveis no diretório assets;
- Crie essa aplicação como se fosse uma aplicação real, que seria utilizada pela Arqmedes;
- Fique à vontade para usar bibliotecas/componentes externos (composer);
- **Não utilize** nenhum Framework, tais como Laravel, Lumen ou Symfony;
- Procure seguir os princípios **SOLID**;
- Utilize boas práticas de programação;
- Utilize boas práticas de git;
- Documente como rodar o projeto;
- Crie uma documentação simples comentando sobre as tecnologias, versões e soluções adotadas.

# Requisitos

- O sistema deverá ser desenvolvido utilizando o PHP e o MySQL nas versões definidas no arquivo docker-compose.yaml;
- Você deve criar um CRUD que permita cadastrar as seguintes informações:
  - **Produto**: Nome, SKU (Código), preço, descrição, quantidade e categoria (cada produto pode conter uma ou mais categorias)
  - **Categoria**: Código e nome.
- Salvar as informações necessárias em um banco de dados (relacional ou não), de sua escolha.

# Opcionais

- Gerar logs das ações;
- Testes automatizados com informação da cobertura de testes;
- Upload de imagem no cadastro de produtos;
- Rotina de importação de produtos no arquivo CSV (import.csv).

# O que será avaliado

- Estrutura e organização do código e dos arquivos;
- Soluções adotadas;
- Tecnologias utilizadas;
- Qualidade;
- Padrões PSR, Design Patterns;
- Enfim, tudo será observado e levado em conta.

# Como iniciar o desenvolvimento

- **Fork** esse repositório na sua conta do Gitlab;
- Crie uma branch com o nome **desafio;**
- Clone a sua versão do repositório para seu ambiente de desenvolvimento local;
- Suba o ambiente com o docker-compose;
- OBS: Caso a mensagem de erro "network arqmedes declared as external, but could not be found" seja apresentada, crie a rede manualmente, e volte a executar o comando para subir o ambiente.

# Como enviar seu teste

Envie um email para [ecio@arqmedesconsultoria.com.br] com o link do seu repositório.

O repositório do teste precisa ser público.

Tendo qualquer dúvida sobre o teste, fique à vontade para entrar em contato conosco.
