
CREATE TABLE `satellite_Asteroid` (
    `asteroidID` INT(12) NOT NULL AUTO_INCREMENT,
    `siteID` INT(12) NOT NULL,
    `creator` INT(12) NOT NULL,
    `created` DATETIME NOT NULL,
    `updated` DATETIME NOT NULL,
    `deleted` INT(1) NOT NULL,
    `asteroidName` VARCHAR(100) NOT NULL,
    `asteroidDiameter` INT(12) NOT NULL,
    `asteroidDistanceFromSun` INT(12) NOT NULL,
    `asteroidDiscoverer` VARCHAR(100) NOT NULL,
    `asteroidDateDiscovered` DATE NOT NULL,
    PRIMARY KEY (`asteroidID`)
);
