SET @langTimeStamp := now();

INSERT INTO perihelion_Lang VALUES ('asteroidID', 'ID', 0, 'ID', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroidName', 'Name', 0, '小惑星名', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroidDiameter', 'Diameter', 0, '直径', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroidDistanceFromSun', 'Distance from Sun', 0, '太陽からの距離', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroidDiscoverer', 'Discoverer', 0, '発見者', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroidDateDiscovered', 'Date Discovered', 0, '発見日', 0, @langTimeStamp);
INSERT INTO perihelion_Lang VALUES ('asteroids', 'Asteroids', 0, '小惑星', 0, @langTimeStamp);
