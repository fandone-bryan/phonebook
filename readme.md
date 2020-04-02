## PhoneBook

##### Tecnologia utilizada
[Laravel 5.8](https://laravel.com/docs/5.8)

##### Requisitos
- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

##### Configuração
``` bash
# Baixe projeto
git clone https://github.com/info-bryanalves/phonebook.git

# Instale as dependências
cd phonebook
composer install

# A partir deste ponto, será necessário criar o banco de dados.
# Após o banco criado, crie um arquivo .env a partir do .env.example que esta na raiz da aplicação.
# Configure o nome, usuario e senha do banco de dados.
Crie o banco de dados

# Obs.: Já deixei o arquivo .env.example igual ao que estou utilizando somente para facilidade na apresentação.
# Está configurado da seguinte forma: usuário: "root", senha: "",e banco: "phonebook".
Crie o arquivo .env baseado no .env.example

# Rode as migrations e seeds
php artisan migrate:refresh --seed

# Por fim, execute o projeto
php artisan serve

# Obs.: Você pode configurar o seu apache diretamente para pasta public do projeto que irá ter o mesmo efeito;
