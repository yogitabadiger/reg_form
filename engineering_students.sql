-- Create the database
CREATE DATABASE IF NOT EXISTS engineering_students;

-- Use the database
USE engineering_students;

-- Create the students table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(50),
    mname VARCHAR(50),
    lname VARCHAR(50),
    dob DATE,
    gender VARCHAR(10),
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255),
    phone VARCHAR(15),
    color VARCHAR(7),
    photo LONGBLOB,
    document LONGBLOB,
    rollno VARCHAR(20),
    department VARCHAR(20),
    year TINYINT,
    sem TINYINT,
    cgpa FLOAT(3,2),
    favsub VARCHAR(50),
    percentage INT(3),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    pincode VARCHAR(10),
    linkedin VARCHAR(255),
    github VARCHAR(255),
    hobbies TEXT,
    clubs TEXT,
    skills TEXT,
    languages TEXT,
    dateTime DATETIME
);
