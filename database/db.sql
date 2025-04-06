CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    cpfCnpj VARCHAR(20),
    balance DECIMAL(10,2) DEFAULT 0
);

-- Seed
-- Usuários comuns (CPF - 11 dígitos)
INSERT INTO users (name, email, password, cpfCnpj, balance)
VALUES 
  ('Ana Silva', 'ana@example.com', 'senha123', '12345678901', 100.00),
  ('Carlos Souza', 'carlos@example.com', 'senha123', '10987654321', 150.00);

-- Lojistas (CNPJ - 14 dígitos)
INSERT INTO users (name, email, password, cpfCnpj, balance)
VALUES 
  ('Loja do João', 'loja.joao@example.com', 'senha123', '12345678000199', 1000.00),
  ('Mercado XYZ', 'mercado@example.com', 'senha123', '98765432000188', 5000.00);

