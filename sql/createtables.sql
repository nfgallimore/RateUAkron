USE myproject;

CREATE TABLE Courses(
    Cid varchar(100) NOT NULL UNIQUE,
    Id varchar(100) NOT NULL,
    End_Date varchar(100),
    Term varchar(100),
    Description varchar(1000),
    Title varchar(100),
    Career varchar(100),
    Section varchar(100),
    Days varchar(100),
    Credit varchar(100),
    Start_Time varchar(100),
    Course varchar(100),
    End_Time varchar(100),
    Location varchar(100),
    Department varchar(100),
    Instructor_Email varchar(100),
    Start_Date varchar(100),
    Instructor varchar(255),
    Instruction_Mode varchar(100),
    Campus varchar(100),
    PRIMARY KEY (Id)
);

CREATE TABLE Evaluations(
	Id int NOT NULL,
	CourseID varchar(100) NOT NULL,
	UserID int(11) NOT NULL,
	Recommended decimal(2,1) NOT NULL,
	TimeSpent decimal(3,1) NOT NULL,
	Reason char NOT NULL,
	Grade varchar(2) NOT NULL,
	GPA decimal(3,2) NOT NULL,
	Created_At DATETIME DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (Id),
	FOREIGN KEY(CourseID) REFERENCES Courses(Cid),
	FOREIGN KEY(UserID) REFERENCES users(id)
);

