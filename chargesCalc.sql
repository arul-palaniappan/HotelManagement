CREATE OR REPLACE PROCEDURE chargeForRoom (stayLength IN INTEGER, custIDIN IN INTEGER, cardNoIN IN INTEGER, typeIN IN VARCHAR, numIN IN NUMBER, checkInDateIN IN DATE)
IS
  retCost NUMBER (20, 2);
  GD NUMBER(10,2);
  SD NUMBER(10,2);
  initialCost NUMBER := 0;
  roomCost NUMBER := 0;
  currentPoints INTEGER;
  newTier NUMBER(10,0);
  oldTier INTEGER;
  previousCost INTEGER;
  newCharge NUMBER (20,2);
BEGIN
  GD := 1-(checkGroupDiscount(typeIN, numIN) / 100);
  SD := 1-(checkSeasonalDiscount(typeIN, checkInDateIN) / 100);
  Select Distinct price into roomCost from Room where typeIn = roomType;
  initialCost := roomCost * stayLength;
  IF GD <= SD
  THEN
    retCost := initialCost * GD;
    retCost := retCost * SD;
  ELSE
    retCost := initialCost * SD;
    retCost := retCost * GD;
  END IF;



  BEGIN
    Select totalCost into previousCost From Charges Where cardNoIN = CreditCardNo;
  EXCEPTION
    When NO_DATA_FOUND THEN
      previousCost := NULL;
  END;

  IF previousCost IS NOT NULL
  THEN
      newCharge := previousCost + retCost;
      UPDATE charges SET totalCost = newCharge where CardNoIN = CreditCardNo;
  ELSE
    newCharge := retCost;
    INSERT INTO charges VALUES (CardNoIn, newCharge);
  END IF;

  BEGIN
    Select points into currentPoints from Rewards where custID = custIDIN;
  EXCEPTION
    WHEN NO_DATA_FOUND THEN
      currentPoints := -1;
  END;



  IF currentPoints < 0
  THEN
    currentPoints := retCost;
    newTier := currentPoints / 1000;
    INSERT INTO Rewards VALUES (cardNoIN, currentPoints, newTier);
  ELSE
    Select tier into oldTier from Rewards where custID = CustIDIN;
    currentPoints := currentPoints + retCost;
    newTier := currentPoints/(1000 + 500 * oldTier);
    UPDATE Rewards SET points = currentPoints, tier = newTier Where custID = CustIDIN;
  END IF;


END;
/
Show Errors;
