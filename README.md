# Sweet Media API

Acesso ao banco de dados do Sweet Media. 

## Instalar em servidor local

Siga os seguintes passos para rodar o projeto em seu ambiente local de desenvolvimento.

#### 1. Clone o projeto para seu repositório local

#### 2. Faça o setup do arquivo .env

Copie o arquivo *.env.example*, renomeando para *.env*. Além das padrões, as propriedades abaixo deverão estar presentes: 

`STORE_URL=` Informe a URL da store.

Para disparo de e-mail transacional, as seguintes propriedades devem ser informadas: 
`ALLIN_USER=` e `ALLIN_PASS=`.


#### 3. Atualize seu projeto
Digite o comando `composer update` dentro da pasta.

#### 4. Adicione o projeto ao Homestead
Para que o projeto rode no Homestead, é necessário incluir as informações no arquivo *Homestead.yaml*.  

Exemplo de configuração para folders:

    folders: 
       - map: C:/www/api
         to: /home/vagrant/Sites/api.sweetmedia.test

Exemplo de configuração para sites:

    sites: 
       - map: api.sweetmedia.test
         to: /home/vagrant/Sites/api.sweetmedia.test/public
         schedule: true   

Lembre-se também de configurar o arquivo de *hosts* do seu sistema operacional. Veja o exemplo abaixo: 

    192.168.10.10	api.sweetmedia.test

