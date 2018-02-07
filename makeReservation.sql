CREATE OR REPLACE Procedure makeReservation (roomNoIN IN INTEGER,
                                              custIDIN IN INTEGER,
                                              checkInDateIN IN DATE,
                                              checkInTimeIN IN INTEGER,
                                              checkOutDateIN IN DATE,
                                              checkOutTimeIN IN INTEGER)
IS
  rmCheck INTEGER;
  custCheck INTEGER;
BEGIN

    BEGIN
      Select RoomNo into rmCheck FROM Room where roomNoIN = roomNo;
      EXCEPTION
        WHEN NO_DATA_FOUND THEN
          rmCheck := Null;
    END;
    IF rmCheck IS NOT NULL
    THEN
        INSERT INTO Availibility_Calendar VALUES (roomNoIN, custIDIN, checkInDateIN, checkInTimeIN, checkOutDateIN, checkOutTimeIN);
    END IF;
END;
/
Show Errors;
