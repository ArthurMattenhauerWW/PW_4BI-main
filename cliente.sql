use laptop;
CREATE TABLE clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL,
  telefone VARCHAR(20) NOT NULL,
  cpf VARCHAR(20) NOT NULL,
  data_cad datetime not null,
  foto varchar(50) not null
);

