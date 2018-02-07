--returns the discount. Returned value is (-)1 if discount is null
Create or Replace Function checkGroupDiscount (typeIN IN VARCHAR, numIN IN INTEGER)
return INTEGER IS
  retVal INTEGER;
Begin
  BEGIN
    Select Discount INTO retVal From Group_Packages where roomType = typeIN and num = numIN;

  EXCEPTION
    WHEN NO_DATA_FOUND THEN
      retVal := 0;
  END;
  Return retVal;
END;
/
show errors;

--Same as above but for SeasonalDiscounts
Create or Replace Function checkSeasonalDiscount (typeIN IN VARCHAR, checkInDate IN DATE)
return INTEGER IS
  retVal INTEGER;
Begin
  BEGIN
    Select Discount INTO retVal From Seasonal_Discount where roomType = typeIN and checkInDate >= startDate and checkInDate <= endDate;
  EXCEPTION
    WHEN NO_DATA_FOUND THEN
      retVal := 0;
  END;
  return retVal;
END;
/
show errors;
