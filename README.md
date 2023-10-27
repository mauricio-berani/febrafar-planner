# Desafio Técnico - Backend PHP 2023

Este é o desafio para a vaga de Backend PHP e consiste na entrega de uma API Restful
escrita em PHP e usando o framework LARAVEL (8 ou superior), bem como, banco de
dados MySQL 8. O prazo para este desafio é de 3 dias, e neste dia deverão ser entregues
os códigos fontes para análise via GitHub para rodrigo.warzak@terceirizados.farmarcas.com.br.

## Regras

-   A API deverá atender um módulo de agenda (CRUD);
-   Sabemos que uma agenda é composta por diversas atividades, e que possuem uma data de início, data de prazo, data de conclusão e um status(aberto/concluído), bem como possui um título, um tipo (que podem ser customizados), uma descrição e um usuário responsável pode-se usar Laravel Sanctum para os usuários);
-   Deve existir opção de filtrar as atividades por range de data, ex.: do dia 21/12/2022 até 10/01/2025;
-   O banco deverá ser criado utilizando migrations;
-   O projeto deve conter testes automatizados com PHPUnit;
-   A documentação da API deve ser feito via Swagger;
-   Não poderá permitir cadastros na mesma data ou que se sobreponham a outras
    datas de atividades de um mesmo usuário;
-   Não poderá permitir o registro de datas em finais de semana;
-   Caso você seja selecionado, marcaremos uma data para a revisão em conjunto do
    código entregue.

## Backlog

-   Aumentar cobertura de testes (65.8%).
-   Melhorar documentação Swagger.
-   Implementar interfaces.
-   Executar ferramenta de análise de código.
-   Criar endpoints de tasks do dia e tasks atrasadas.

## Informações

-   O arquivo insomnia_2023-10-27.yaml é uma coleção json e pode ser usada no Insomnia (https://insomnia.rest/download).
-   Foi utiliza Laravel Sail para desenvolvimento local (https://laravel.com/docs/10.x/sail#main-content).
-   Foi criado um seeder para um usuário administrador, para utilizar, execute o comando a seguir: `sail artisan db:seed --class=UserSeeder` - Se não estiver utilizando Sail, substitua "sail" por "php". Apenas usuários administradores podem utilizar o recurso "users". Usuário administrador: email=administrador@febrafar.com.br senha=febrafar2023$
-   Para acessar a documentação Swagger, utilize o link: [base_url]/api/documentation/
-   Para filtrar datas por range utilizar o endpoint tasks/match?filterDate=[data]&deadline=[data].
