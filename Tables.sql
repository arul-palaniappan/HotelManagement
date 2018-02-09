Drop Table Employees;
Drop Table Inventory;
Drop Table Department;


Create Table Department (
  DeptID INTEGER PRIMARY KEY,
  DeptName VARCHAR(35),
  PhoneNo INTEGER
);

Create Table Employees (
  EmpID INTEGER PRIMARY KEY,
  EmpName Varchar(35),
  DeptID INTEGER,
  Salary INTEGER
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
