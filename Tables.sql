Drop Table room;
Drop Table Group_packages;
Drop Table Seasonal_Discount;
Drop Table Availibility_calendar;
Drop Table Customer;
Drop Table charges;
Drop Table rewards;
Drop Table employees;
Drop Table department;
Drop Table Inventory;

Create Table Room (
  RoomNo INTEGER PRIMARY KEY,
  roomType VARCHAR(35),
  Price INTEGER,
  --Availability Number(1),
  CHECK (roomType in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room'))
);

Create Table Group_Packages (
  roomType VARCHAR(35),
  Num INTEGER,
  Discount INTEGER,
  CONSTRAINT PKP_GP PRIMARY KEY (roomType, Num),
  CHECK (roomType in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room'))
);

Create Table Seasonal_Discount (
  roomType VARCHAR(35),
  StartDate DATE,
  EndDate DATE,
  Discount INTEGER,
  CONSTRAINT PK_SD PRIMARY KEY (roomType, StartDate),
  CHECK (roomType in ('Presidential Suite', 'Deluxe Suite', 'Suite', 'Conference Room', 'Ball Room'))
);

Create Table Availibility_Calendar (
  RoomNo INTEGER,
  CustID INTEGER,
  CheckInDate DATE,
  CheckInTime INTEGER,
  CheckOutDate Date,
  CheckOutTime INTEGER,
  CONSTRAINT PK_AC PRIMARY KEY (RoomNo, CheckOutDate)
);

Create Table Customer (
  CustID INTEGER PRIMARY KEY,
  password VARCHAR(35),
  CustName VARCHAR(35),
  CreditCardNo INTEGER
);

Create Table Charges (
  CreditCardNo INTEGER PRIMARY KEY,
  TotalCost INTEGER
);

Create Table Rewards (
  CustID INTEGER PRIMARY KEY,
  Points INTEGER,
  Tier INTEGER
);

Create Table Employees (
  EmpID INTEGER PRIMARY KEY,
  EmpName Varchar(35),
  DeptID INTEGER,
  Salary INTEGER
);

Create Table Department (
  DeptID INTEGER PRIMARY KEY,
  DeptName VARCHAR(35),
  PhoneNo INTEGER
);

Create Table Inventory(
  PartID INTEGER PRIMARY KEY,
  PartName VARCHAR(35),
  Qty INTEGER,
  MinQty INTEGER,
  Price INTEGER,
  DeptID INTEGER,
  Date_Checked DATE
);

--Needed Parts has been removed
