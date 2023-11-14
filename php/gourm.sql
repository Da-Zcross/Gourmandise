-- Categories --
CREATE TABLE Categories (
  CategoryId      INT PRIMARY KEY AUTO_INCREMENT,
  Label           VARCHAR(50) NOT NULL
);

-- Customers --
CREATE TABLE Customers (
  CustomerId      INT PRIMARY KEY AUTO_INCREMENT,
  LastName        VARCHAR(50) NOT NULL,
  FirstName       VARCHAR(50) NOT NULL,
  BirthDate       DATE NOT NULL,
  StreetNumber    VARCHAR(50) NOT NULL,
  StreetName      VARCHAR(50) NOT NULL,
  PostalCode      INT NOT NULL,
  City            VARCHAR(50) NOT NULL,
  PhoneNumber     VARCHAR(50) NOT NULL,
  Email           VARCHAR(255) NOT NULL UNIQUE,
  Password        VARCHAR(70) NOT NULL
);

-- Fruits --
CREATE TABLE Fruits (
  ProductId       INT PRIMARY KEY AUTO_INCREMENT,
  Denomination    VARCHAR(50) NOT NULL,
  Reference       VARCHAR(50) NOT NULL UNIQUE,
  Price           DECIMAL(10, 2) NOT NULL,
  CategoryId      INT,
  FOREIGN KEY (CategoryId) REFERENCES Categories (CategoryId)
);

-- Orders --
CREATE TABLE Orders (
  OrderId         INT PRIMARY KEY AUTO_INCREMENT,
  OrderNumber     VARCHAR(50) NOT NULL UNIQUE,
  OrderDateTime   DATETIME DEFAULT CURRENT_TIMESTAMP,
  ShippingMethod  VARCHAR(50) NOT NULL,
  CustomerId      INT,
  FOREIGN KEY (CustomerId) REFERENCES Customers (CustomerId)
);

-- Order-Fruit Relations --
CREATE TABLE OrderFruits (
  OrderFruitId    INT PRIMARY KEY AUTO_INCREMENT,
  OrderId         INT,
  ProductId       INT,
  FOREIGN KEY (OrderId) REFERENCES Orders (OrderId),
  FOREIGN KEY (ProductId) REFERENCES Fruits (ProductId)
);

-- Quantities --
CREATE TABLE Quantities (
  QuantityId      INT PRIMARY KEY AUTO_INCREMENT,
  OrderFruitId    INT,
  Quantity        INT NOT NULL,
  FOREIGN KEY (OrderFruitId) REFERENCES OrderFruits (OrderFruitId)
);

CREATE TABLE fruit_category (
	ProductId INT(11) NOT NULL,
	CategoryId INT(11) NOT NULL,
	PRIMARY KEY (ProductId, CategoryId),
	FOREIGN KEY (ProductId) REFERENCES fruits(id) ON DELETE CASCADE,
	FOREIGN KEY (CategoryId) REFERENCES categories(id) ON DELETE CASCADE
);




-- Administrators --
CREATE TABLE Administrators (
  AdminId         INT PRIMARY KEY AUTO_INCREMENT,
  LastName        VARCHAR(50) NOT NULL,
  FirstName       VARCHAR(50) NOT NULL,
  Email           VARCHAR(255) NOT NULL UNIQUE,
  Password        VARCHAR(70) NOT NULL
);



