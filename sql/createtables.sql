USE myproject;

CREATE TABLE Courses(
	Id varchar(17) NOT NULL,
	End_Date varchar(10) NOT NULL,
	Term varchar(20) NOT NULL,
	Description varchar(1000) NOT NULL,
	Title varchar(100) NOT NULL,
	Career varchar(55) NOT NULL,
	Section varchar(25) NOT NULL,
	Days varchar(100) NOT NULL,
	Credit varchar(25) NOT NULL,
	Start_Time varchar(25) NOT NULL,
	Course varchar(25) NOT NULL,
	End_Time varchar(25) NOT NULL,
	Location varchar(100) NOT NULL,
	Department varchar(100) NOT NULL,
	Instructor_Email varchar(100) NOT NULL,
	Start_Date varchar(10) NOT NULL,
	Instructor varchar(100) NOT NULL,
	Instruction_Mode varchar(100) NOT NULL,
	Campus varchar(100) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE Users(
	Id int(11) NOT NULL,
	Username varchar(50)
	Password varchar(255) NOT NULL,
	Created_At DATETIME DEFAULT CURRENT_TIMESTAMP
	PRIMARY KEY (Id)
);

CREATE TABLE Evaluations(
	Id int NOT NULL,
	CourseID varchar(17) NOT NULL,
	UserID int(11) NOT NULL,
	Recommended decimal(2,1) NOT NULL,
	TimeSpent decimal(3,1) NOT NULL,
	Reason char NOT NULL,
	Grade varchar(2) NOT NULL,
	GPA decimal(3,2) NOT NULL,
	Created_At DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Id),
	FOREIGN KEY(CourseID) REFERENCES Courses(Id),
	FOREIGN KEY(UserID) REFERENCES Users(Id)
);
