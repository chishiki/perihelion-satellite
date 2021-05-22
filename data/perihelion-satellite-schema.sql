DROP TABLE IF EXISTS `example_Asteroid`;

CREATE TABLE `example_Asteroid` (
    `asteroidID` int(12) NOT NULL AUTO_INCREMENT,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `asteroidName` varchar(100) NOT NULL,
    `asteroidDiameter` decimal(6,1) NOT NULL,
    `asteroidDistanceFromSun` decimal(8,4) NOT NULL,
    `asteroidDiscoverer` varchar(100) NOT NULL,
    `asteroidDateDiscovered` date NOT NULL,
    PRIMARY KEY (`asteroidID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4

