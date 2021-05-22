SET @now := now();
SET @siteID = 1; -- whatever number you use here needs to go in instance.config.php siteID
SET @userID = 1; -- admin

INSERT INTO `example_Asteroid` VALUES
(1,@siteID,@userID,@now,@now,0,'Ceres',939.4,2.7660,'Giuseppe Piazzi','1801-01-01'),
(2,@siteID,@userID,@now,@now,0,'Vesta',525.4,2.3620,'Heinrich Wilhelm Matthias Olbers','1807-03-29');
