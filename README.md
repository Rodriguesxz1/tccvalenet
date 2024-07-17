# TCC valenet
Este projeto visa oferecer uma solução abrangente para a gestão de infraestrutura e o monitoramento de rede, utilizando uma interface web para visualizar e controlar os hosts inseridos na rede. A solução permitirá o gerenciamento de ambientes, clientes e sua infraestrutura, simplificando processos e otimizando a administração de serviços.

## Backend

# Instruções para Criação do Banco de Dados

Este documento fornece instruções passo a passo para a criação das tabelas do banco de dados e suas relações. Siga cuidadosamente as instruções abaixo para configurar o banco de dados corretamente.

## Pré-requisitos

- MySQL instalado e configurado.
- Um usuário com permissões adequadas para criar bancos de dados e tabelas.

## Passo a Passo

### 1. Conectar ao MySQL

Abra o terminal ou use um cliente de banco de dados como MySQL Workbench e conecte-se ao seu servidor MySQL.


mysql -u root -p


### 2. Criar o Banco de Dados

Crie o banco de dados que será usado para armazenar as tabelas.

CREATE DATABASE tccvalenet;
USE tccvalenet;


### 3. Criar Tabela `Clientes`

Crie a tabela `Clientes` com as colunas especificadas.


CREATE TABLE Clientes (
    CPF VARCHAR(11) PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100),
    Telefone VARCHAR(15),
    Endereco VARCHAR(255),
    DataDeNascimento DATE
);


### 4. Criar Tabela `Equipamentos`

Crie a tabela `Equipamentos` com uma chave estrangeira referenciando a tabela `Clientes`.


CREATE TABLE Equipamentos (
    IP VARCHAR(15) PRIMARY KEY,
    Mac VARCHAR(17) UNIQUE NOT NULL,
    Tipo VARCHAR(50),
    Descrição VARCHAR(50),
    Cliente_CPF VARCHAR(11),
    FOREIGN KEY (Cliente_CPF) REFERENCES Clientes(CPF)
);


### 5. Criar Tabela `Permissoes`

Crie a tabela `Permissoes`.


CREATE TABLE Permissoes (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    NomePermissao VARCHAR(50) NOT NULL,
    Descricao TEXT
);


### 6. Criar Tabela `Funcionarios`

Crie a tabela `Funcionarios` com uma chave estrangeira referenciando a tabela `Permissoes`.


CREATE TABLE Funcionarios (
    Matricula INT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    DataDeNascimento DATE,
    EmailCorporativo VARCHAR(100),
    PermissaoID INT,
    FOREIGN KEY (PermissaoID) REFERENCES Permissoes(ID)
);


### 7. Adicionar Coluna `Funcionario_Matricula` à Tabela `Equipamentos`

Adicione a coluna `Funcionario_Matricula` e configure a chave estrangeira.


ALTER TABLE Equipamentos
ADD Funcionario_Matricula INT;

ALTER TABLE Equipamentos
ADD CONSTRAINT fk_equipamentos_funcionario
FOREIGN KEY (Funcionario_Matricula)
REFERENCES Funcionarios(Matricula);


### 8. Criar Tabela `Equipamentos_Clientes`

Crie a tabela `Equipamentos_Clientes` para gerenciar as relações entre `Equipamentos` e `Clientes`.


CREATE TABLE Equipamentos_Clientes (
    EquipamentoIP VARCHAR(255),
    ClienteCPF VARCHAR(11),
    PRIMARY KEY (EquipamentoIP, ClienteCPF),
    FOREIGN KEY (EquipamentoIP) REFERENCES Equipamentos(IP),
    FOREIGN KEY (ClienteCPF) REFERENCES Clientes(CPF)
);


### 9. Criar Tabela `Equipamentos_Funcionarios`

Crie a tabela `Equipamentos_Funcionarios` para gerenciar as relações entre `Equipamentos` e `Funcionarios`.


CREATE TABLE Equipamentos_Funcionarios (
    EquipamentoIP VARCHAR(255),
    FuncionarioMatricula INT,
    PRIMARY KEY (EquipamentoIP, FuncionarioMatricula),
    FOREIGN KEY (EquipamentoIP) REFERENCES Equipamentos(IP),
    FOREIGN KEY (FuncionarioMatricula) REFERENCES Funcionarios(Matricula)
);


### 10. Adicionar Coluna `Imagem` à Tabela `Permissoes`

Adicione a coluna `Imagem` à tabela `Permissoes`.

ALTER TABLE Permissoes
ADD Imagem VARCHAR(255);

## Conclusão

Após seguir esses passos, seu banco de dados estará configurado com todas as tabelas e relações necessárias. Se encontrar algum problema durante o processo, verifique novamente cada comando SQL para garantir que todos foram executados corretamente.


Este arquivo `README.md` fornece instruções claras e detalhadas para criar as tabelas e configurar o banco de dados corretamente. Siga esses passos em sequência para garantir que o banco de dados seja configurado sem erros.


