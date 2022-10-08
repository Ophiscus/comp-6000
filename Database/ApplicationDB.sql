-- -----------------------------------------------------
-- Table `Staff`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Replies` ;
DROP TABLE IF EXISTS `Forum Posts` ;
DROP TABLE IF EXISTS `Private Messages` ;
DROP TABLE IF EXISTS `Announcements` ;
DROP TABLE IF EXISTS `Assigned Training` ;
DROP TABLE IF EXISTS `Training Document` ;
DROP TABLE IF EXISTS `Payslips` ;
DROP TABLE IF EXISTS `Rota` ;
DROP TABLE IF EXISTS `Staff` ;

CREATE TABLE IF NOT EXISTS `Staff` (
  `StaffID` INT NOT NULL AUTO_INCREMENT,
  `First Name` VARCHAR(45) NOT NULL,
  `Last Name` VARCHAR(45) NOT NULL,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `contact number` VARCHAR(45) NOT NULL,
  `Role` VARCHAR(20) NOT NULL,
  `Job Title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`StaffID`),
  UNIQUE INDEX `StaffID_UNIQUE` (`StaffID` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC)
  );


-- -----------------------------------------------------
-- Table `Rota`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Rota` (
  `RotaID` INT NOT NULL AUTO_INCREMENT,
  `StaffID` INT NOT NULL,
  `Shift Start` DATETIME NOT NULL,
  `End Time` DATETIME NOT NULL,
  `Description` VARCHAR(45) NULL,
  PRIMARY KEY (`RotaID`),
  UNIQUE INDEX `RotaID_UNIQUE` (`RotaID` ASC),
  INDEX `StaffID_idx` (`StaffID` ASC),
  CONSTRAINT `StaffID`
    FOREIGN KEY (`StaffID`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Payslips`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Payslips` (
  `SlipId` INT NOT NULL AUTO_INCREMENT,
  `StaffID` INT NOT NULL,
  `Date` DATE NOT NULL,
  `FilePath` VARCHAR(260) NOT NULL,
  PRIMARY KEY (`SlipId`),
  UNIQUE INDEX `SlipId_UNIQUE` (`SlipId` ASC),
  INDEX `StaffID_idx` (`StaffID` ASC),
  CONSTRAINT `Staff`
    FOREIGN KEY (`StaffID`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Training Document`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Training Document` (
  `TrainingID` INT NOT NULL AUTO_INCREMENT,
  `Date` DATE NOT NULL,
  `FilePath` VARCHAR(260) NOT NULL,
  `Type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`TrainingID`),
  UNIQUE INDEX `TrainingID_UNIQUE` (`TrainingID` ASC) 
  );


-- -----------------------------------------------------
-- Table `Assigned Training`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Assigned Training` (
  `StaffID` INT NOT NULL,
  `TrainingID` INT NOT NULL,
  `Completed` TINYINT NULL,
  PRIMARY KEY (`StaffID`, `TrainingID`),
  INDEX `trainingID_idx` (`TrainingID` ASC),
  CONSTRAINT `staffToTrain`
    FOREIGN KEY (`StaffID`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `trainingDoc`
    FOREIGN KEY (`TrainingID`)
    REFERENCES `Training Document` (`TrainingID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Announcements`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Announcements` (
  `AnnouncementID` INT NOT NULL AUTO_INCREMENT,
  `Subject` VARCHAR(45) NOT NULL,
  `Poster` INT NOT NULL,
  `PostDate` DATETIME NOT NULL,
  `PinUntil` DATETIME NOT NULL,
  `Content` LONGTEXT NULL,
  PRIMARY KEY (`AnnouncementID`),
  UNIQUE INDEX `AnnouncementID_UNIQUE` (`AnnouncementID` ASC),
  INDEX `Poster_idx` (`Poster` ASC),
  CONSTRAINT `Poster`
    FOREIGN KEY (`Poster`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Private Messages`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS `Private Messages` (
  `PMID` INT NOT NULL AUTO_INCREMENT,
  `Subject` VARCHAR(45) NOT NULL,
  `SendDate` DATETIME NOT NULL,
  `Content` LONGTEXT NOT NULL,
  `Sender` INT NOT NULL,
  `Recipient` INT NOT NULL,
  `Seen` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`PMID`),
  UNIQUE INDEX `PMID_UNIQUE` (`PMID` ASC),
  INDEX `Sender_idx` (`Sender` ASC),
  INDEX `Recipient_idx` (`Recipient` ASC),
  CONSTRAINT `Sender`
    FOREIGN KEY (`Sender`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Recipient`
    FOREIGN KEY (`Recipient`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Forum Posts`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Forum Posts` (
  `PostID` INT NOT NULL AUTO_INCREMENT,
  `Subject` VARCHAR(45) NOT NULL,
  `Poster` INT NOT NULL,
  `PostDate` DATETIME NOT NULL,
  `Content` LONGTEXT NOT NULL,
  `Acknowledgements` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`PostID`),
  UNIQUE INDEX `PostID_UNIQUE` (`PostID` ASC),
  INDEX `Poster_idx` (`Poster` ASC),
  CONSTRAINT `OriginalPoster`
    FOREIGN KEY (`Poster`)
    REFERENCES `Staff` (`StaffID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


-- -----------------------------------------------------
-- Table `Replies`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `Replies` (
  `CommentID` INT NOT NULL AUTO_INCREMENT,
  `Subject` VARCHAR(4) NOT NULL,
  `Poster` INT NOT NULL,
  `PostDate` DATETIME NOT NULL,
  `Content` LONGTEXT NOT NULL,
  `ReplyTo` INT NOT NULL,
  PRIMARY KEY (`CommentID`),
  UNIQUE INDEX `CommentID_UNIQUE` (`CommentID` ASC),
  INDEX `ReplyTo_idx` (`ReplyTo` ASC),
  CONSTRAINT `ReplyTo`
    FOREIGN KEY (`ReplyTo`)
    REFERENCES `Forum Posts` (`PostID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
