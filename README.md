# :money_with_wings: Simplifin

O projeto Simplifin foi desenvolvido para fins de aprendizado. 

O objetivo é testar o micro framework Slim e validar conceitos de OOP, DDD, SOLID, Clean Arch, entre outros.

O projeto trata de uma aplicação de cunho financeira responsavel por fazer transferências financeiras entre usuários comuns e lojistas, mediante autorizações.

## Funcionalidades

... Em construção ...

## :round_pushpin: Requisitos

- **PHP**: Versão 8.2 ou superior.
- **Banco de Dados**: MySQL 5.7 ou superior.
- **Variáveis de Ambiente**: O projeto esta configurado para ser disponibilizado utilizando containers. Como projeto de desenvolvimento, as variáveis de ambiente estão configuradas diretamente no **docker-compose**.

## :package: Instalação

1. Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina.
2. Clone o repositório:
    ```bash
    git clone https://github.com/brunocarazato/simplifin.git
    ```
3. Navegue até o diretório do projeto:
    ```bash
    cd simplifin
    ```
4. Inicie os containers com o Docker Compose:
    ```bash
    docker-compose up -d
    ```
5. Acesse o projeto no navegador:
    ```
    http://localhost:8080
    ```
## :hammer: Testes
Para executar os testes
    ```
    docker-compose exec -it slim bash -c "composer test"
    ```
