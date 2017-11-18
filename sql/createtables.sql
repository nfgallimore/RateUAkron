USE myproject;

CREATE TABLE Courses(
	Id varchar(17) NOT NULL,
	End_Date varchar(10) NOT NULL,
	Term varchar(20) NOT NULL,
	Description varchar(1000) NOT NULL,
	Title varchar(100) NOT NULL,
	Career varchar(55) NOT NULL,
	Section varchar(3) NOT NULL,
	Days varchar(100) NOT NULL,
	Credit decimal(2,1) NOT NULL,
	Start_Time varchar(8) NOT NULL,
	Course varchar(8) NOT NULL,
	End_Time varchar(8) NOT NULL,
	Location varchar(100) NOT NULL,
	Department varchar(100) NOT NULL,
	Instructor_Email varchar(100) NOT NULL,
	Start_Date varchar(10) NOT NULL,
	Instructor varchar(100) NOT NULL,
	Instruction_Mode varchar(100) NOT NULL,
	Campus varchar(100) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE Students(
	Id int NOT NULL,
	Fname varchar(32) NOT NULL,
	Lname varchar(32) NOT NULL,
	Email varchar(200) NOT NULL,
	Password varchar(32) NOT NULL,
	PRIMARY KEY (Id)
);

CREATE TABLE Evaluation(
	Id int NOT NULL,
	CourseID varchar(17) NOT NULL,
	StudentID int NOT NULL,
	Recommended decimal(2,1) NOT NULL,
	TimeSpent decimal(3,1) NOT NULL,
	Reason char NOT NULL,
	Grade varchar(2) NOT NULL,
	GPA decimal(3,2) NOT NULL,
	PRIMARY KEY (Id),
	FOREIGN KEY(CourseID) REFERENCES Courses(Id),
	FOREIGN KEY(StudentID) REFERENCES Students(Id)
);
