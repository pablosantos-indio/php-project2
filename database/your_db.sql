-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/

-- Host: localhost
-- Generation Time: Mar 22, 2024 at 10:00 AM
-- Server version: 8.0.23
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create dbClassSchedule
CREATE DATABASE IF NOT EXISTS job_board;
USE job_board;

-- Dropping existing table for job postings
DROP TABLE IF EXISTS JobPostings;

-- Creating table for Job Postings
CREATE TABLE IF NOT EXISTS JobPostings (
    Id INT NOT NULL AUTO_INCREMENT,
    CreatedAt DATETIME NOT NULL,
    Title VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    Location VARCHAR(255) NOT NULL,
    StartDate DATE NOT NULL,
    ContactEmail VARCHAR(255) NOT NULL,
    PRIMARY KEY (Id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert on table JobPostings
INSERT INTO JobPostings (CreatedAt, Title, Description, Location, StartDate, ContactEmail) VALUES
('2024-02-16 14:31:19', 'Howe-Simonis', 'Description for Howe-Simonis. An innovative solution in the tech landscape, focusing on advanced analytics and data processing.', 'Port Vincenzomouth', '2024-02-23', 'chaim17@yahoo.com'),
('2024-02-16 14:31:19', 'Dach, Jacobson and Gibson', 'Dach, Jacobson and Gibson brings forward a new era of digital marketing strategies tailored for the modern consumer.', 'Lake Edhaven', '2024-02-27', 'akautzer@hamill.com'),
('2024-02-16 14:31:19', 'Cronin Group', 'Cronin Group specializes in logistical solutions that streamline supply chain processes for enterprises around the globe.', 'New Selinaton', '2024-03-26', 'larson.annabel@yahoo.com'),
('2024-02-16 14:31:19', 'Schinner-Hane', 'At Schinner-Hane, we redefine the boundaries of web development with our cutting-edge technologies and innovative practices.', 'Lake Devonhaven', '2024-03-23', 'mayert.stanford@quitzon.com'),
('2024-02-16 14:31:19', 'Cummerata-Moen', 'Cummerata-Moen is at the forefront of architectural design, offering sustainable and aesthetically pleasing solutions for modern living.', 'Fritschberg', '2024-03-08', 'hessel.wilma@gmail.com'),
('2024-02-16 14:31:19', 'Ward, Zieme and Orn', 'In the realm of financial consulting, Ward, Zieme and Orn stand out with their unparalleled advice and investment strategies.', 'Gaylordview', '2024-04-14', 'yoshiko89@hotmail.com'),
('2024-02-16 14:31:19', 'Aufderhar, Adams and Tremblay', 'Aufderhar, Adams and Tremblay lead the legal industry with their expert counsel and commitment to justice and client success.', 'Hahnberg', '2024-04-13', 'wehner.orlando@mosciski.com'),
('2024-02-16 14:31:19', 'Mann-Ryan', 'Mann-Ryan’s innovative healthcare solutions provide cutting-edge treatments and technologies to patients worldwide.', 'Bennyville', '2024-04-10', 'hillary.rippin@funk.biz'),
('2024-02-16 14:31:19', 'Mraz Group', 'The Mraz Group is a leader in the entertainment industry, producing critically acclaimed films, music, and live performances.', 'New Mariahport', '2024-02-25', 'chelsea64@langosh.com'),
('2024-02-16 14:31:19', 'Hane Ltd', 'Hane Ltd’s expertise in renewable energy solutions contributes to a sustainable future with innovative solar and wind technologies.', 'Heidenreichburgh', '2024-03-04', 'elisabeth82@goodwin.com');
