CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    cpfCnpj VARCHAR(20),
    balance DECIMAL(10,2) DEFAULT 0
);
ALTER TABLE users ADD COLUMN type ENUM('common', 'merchant') NOT NULL;
-- Seed
INSERT INTO users (name, email, password, cpfCnpj, balance, type) 
VALUES
('João da Silva', 'joao@exemplo.com', 'senha123', '12345678901', 500.00, 'common'),
('Maria Oliveira', 'maria@exemplo.com', 'senha123', '98765432100', 750.00, 'common'),
('Loja XPTO', 'contato@lojaxpto.com', 'senha123', '11222333000181', 1000.00, 'merchant'),
('Comércio ABC', 'vendas@abc.com', 'senha123', '99888777000155', 1250.00, 'merchant');
