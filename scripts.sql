CREATE DATABASE IF NOT EXISTS garage_v_parrot;

USE garage_v_parrot;

CREATE TABLE users (
  id VARCHAR(36) PRIMARY KEY NOT NULL,
  email VARCHAR(255) NOT NULL,
  password CHAR(60) NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  isAdmin BOOLEAN default 0
);

CREATE TABLE schedules (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  text VARCHAR(100) NOT NULL,
  day VARCHAR(20) NOT NULL
);

CREATE TABLE services (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  title VARCHAR(50) NOT NULL,
  text VARCHAR(400) NOT NULL,
  picture VARCHAR(255) NOT NULL
);

CREATE TABLE reviews (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  text VARCHAR(175) NOT NULL,
  service INT(11) NOT NULL,
  approved BOOLEAN default 0,
  FOREIGN KEY (service) REFERENCES services(id)
);

CREATE TABLE brands (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  property VARCHAR(30) NOT NULL
);

CREATE TABLE motor_technologies (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  property VARCHAR(30) NOT NULL
);

CREATE TABLE cars (
  id VARCHAR(36) PRIMARY KEY NOT NULL,
  title VARCHAR(50) NOT NULL,
  price INT(11) NOT NULL,
  year YEAR NOT NULL,
  mileage INT(11) NOT NULL,
  puissance_din INT(11) NOT NULL,
  puissance_fiscale INT(11) NOT NULL,
  automatically BOOLEAN NOT NULL,
  motor_technologie INT(11) NOT NULL,
  brand INT(11) NOT NULL,
  FOREIGN KEY (motor_technologie) REFERENCES motor_technologies(id),
  FOREIGN KEY (brand) REFERENCES brands(id)
);

CREATE TABLE messages (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  firstname VARCHAR(50) NOT NULL,
  lastname VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL,
  phone_number VARCHAR(20) NOT NULL,
  text VARCHAR(255) NOT NULL,
  subject VARCHAR(255) NOT NULL,
  car VARCHAR(36),
  FOREIGN KEY (car) REFERENCES cars(id)
);

CREATE TABLE pictures (
  id INT(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  picture VARCHAR(255) NOT NULL,
  is_primary BOOLEAN default 0,
  car VARCHAR(36) NOT NULL,
  FOREIGN KEY (car) REFERENCES cars(id)
);

-- Table associative
CREATE TABLE schedules_users (
    user_id VARCHAR(36) NOT NULL,
    schedule_id INT(11) NOT NULL,
    PRIMARY KEY (user_id, schedule_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (schedule_id) REFERENCES schedules(id)
);

-- Table associative
CREATE TABLE reviews_users (
    user_id VARCHAR(36) NOT NULL,
    review_id INT(11) NOT NULL,
    PRIMARY KEY (user_id, review_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (review_id) REFERENCES reviews(id)
);

-- Table associative
CREATE TABLE services_users (
    user_id VARCHAR(36) NOT NULL,
    service_id INT(11) NOT NULL,
    PRIMARY KEY (user_id, service_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Table associative
CREATE TABLE cars_users (
    user_id VARCHAR(36) NOT NULL,
    cars_id VARCHAR(36) NOT NULL,
    PRIMARY KEY (user_id, cars_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (cars_id) REFERENCES cars(id)
);