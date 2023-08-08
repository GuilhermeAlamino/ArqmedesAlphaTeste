# ArqmedesAlphaTeste

# Clone o projeto

git clone {{url do projeto do github ou gitlab}}

Dentro do diretorio do projeto, execute o comando abaixo pois ele já vai gerar toda a estrutura do db e iniciar o projeto na porta localhost:8009

# Como rodar o projeto

Tenha o Docker :) rodando em background ou da maneira que preferir, execute o comando docker-compose up -d dentro da pasta do projeto

# O teste

Esse sistema será composto por alguns cadastros (produtos e categorias). Optei pela seguinte regra o produto só é criado se todos os campos forem preenchidos, ou seja deve haver categorias na hora de criar um produto. então as categorias poderam ser (criadas).

Optei por utilizar o mesmo padrão de styles e views, tambem pensei em algo similiar ao mvc portanto funcionando de forma diferente da convencional como por exemplo chamada de *routas*.

Mas entretanto, consegui criar uma solução para as chamadas views e controllers para manipular as ações.

A estrutura do projeto está assim :

1. app {<br>
        1.1 controllers -> ações de update create delete e read (para cada controller)<br>
        1.2 database -> implementação de conexão com o banco de dados rodando no docker<br>
        1.3 Views -> chamadas das views em php<br>
    }
2. public {<br>
        2.1 css -> vamos ter aqui os estilos<br>
        2.2 images -> imagens default do projeto que funcionam nas views<br>
        2.3 index -> implementação das views e controllers<br>
   }

docker-compose.yaml -> optei somente por organizar o network pra funcionar na rede predestinada.

error_log.txt -> logs simples de ações dentro dos controllers, e conexões com o banco, e geração de importações do banco ao import.csv.

export.php -> está a lógica para fazer a importação e iterar sobre os dados já existentes, utilize o command "*php export.php*"(arqmedes-app) utilizei dentro do container rodando e intrepretando o php.

se quiser acessar o banco de dados por algum software vou deixar as configs abaixo.

servidor/ip : 127.0.0.1

usuário : arqmedes_alpha

senha : 12345678

agradeço desde já!
