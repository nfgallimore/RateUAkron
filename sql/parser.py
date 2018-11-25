import json
from collections import namedtuple

with open('courses.json', encoding='utf-8') as data_file:
	courses = json.loads(data_file.read())	
	with open('insert_courses.sql', 'a') as file:
		#file.write('INSERT INTO Courses (Cid, Id, End_Date, Term, Description, Title, Career, Section, Days, Credit, Start_Time, Course, End_Time, Location, Department, Instructor_Email, Start_Date, Instructor, Instruction_Mode, Campus)\nVALUES \n')
		for i, course in enumerate(courses):
			print(course['Id'])
			#file.write('(\'' + str(i) + '\',\'' + course['Id'] + '\',\'' + course['End_Date'] + '\',\'' + course['Term'] + '\',\'' + course['Description'] + '\',\'' + course['Title'] + '\',\'' + course['Career'] + '\',\'' + course['Section'] + '\',\'' + course['Days'] + '\',\'' + course['Credit'] + '\',\'' + course['Start_Time'] + '\',\'' + course['Course'] + '\',\'' + course['End_Time'] + '\',\'' + course['Location'] + '\',\'' + course['Department'] + '\',\'' + course['Instructor_Email'] + '\',\'' + course['Start_Date'] + '\',\'' + course['Instructor'] + '\',\'' + course['Instruction_Mode'] + '\',\'' + course['Campus'] + '\'),\n')
		#file.close()