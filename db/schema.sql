DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL,
  phone TEXT NOT NULL,
  email TEXT NOT NULL UNIQUE,
  bio TEXT NOT NULL,
  password TEXT NOT NULL,
  role TEXT NOT NULL DEFAULT "user" CHECK(role IN("user", "company", "admin")),
  banned BOOLEAN NOT NULL DEFAULT FALSE,
  verified BOOLEAN NOT NULL DEFAULT FALSE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS company_data (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  name TEXT NOT NULL,
  website TEXT NOT NULL,
  location TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS categories (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS jobs (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  category_id INT NOT NULL,
  company_id INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (company_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS messages (
  id INT PRIMARY KEY AUTO_INCREMENT,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  message TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (sender_id) REFERENCES users(id),
  FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS verification_tokens (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  token TEXT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO categories (name) VALUES
  ("Web Development"),
  ("Mobile Development"),
  ("Data Science"),
  ("Machine Learning"),
  ("Artificial Intelligence"),
  ("Blockchain"),
  ("UI/UX Design"),
  ("DevOps"),
  ("Quality Assurance"),
  ("Other");
