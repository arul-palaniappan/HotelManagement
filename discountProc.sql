--Two simple insertion functions for use by the PHP Code to Insert values for discount packages into the database
CREATE OR REPLACE PROCEDURE createGroupPackage (typeIN IN VARCHAR, numIN IN VARCHAR, DiscountIN IN VARCHAR)
IS
Begin
  INSERT INTO Group_Packages VALUES (TypeIN, numIN, DiscountIN);
End;
/
show errors;


CREATE OR REPLACE PROCEDURE createSeasonalDiscount (typeIN IN VARCHAR, startDateIN IN DATE, endDateIN IN DATE, DiscountIN IN INTEGER)
IS
Begin
  INSERT INTO Seasonal_Discount VALUES (TypeIN, startDateIN, endDateIN, DiscountIN);
End;
/
show errors;

--Amit
