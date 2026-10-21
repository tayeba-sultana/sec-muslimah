SEC Muslimah Community

A web-based community platform for the SEC Muslimah Community at Sylhet Engineering College. The platform is designed to provide a central place for female students to learn about the community, join as members, view events and notices, access Islamic resources, register for events, and support community activities through donations and clothing drives.

🌙 Project Overview

SEC Muslimah Community is a non-political, female-student-focused community website built around three main pillars:

Deen — strengthening faith through knowledge and practice

Dawah — sharing Islam with wisdom, kindness, and sincerity

Righteous Learning — pursuing beneficial knowledge for both deen and dunya

The project contains both a public-facing website and an administrator panel backed by a MySQL database.

✨ Main Features

Public Website

The public section includes:

🏠 Home — introduction to the community and quick navigation

🌙 About — community purpose and the three pillars

📅 Events — displays upcoming community events

📌 Notices — community announcements and updates

📖 Resources — Islamic resources such as:

Ayah of the Week

Hadith

Articles

🤲 Donate — donation and fundraising facilities

🌸 Join Us — membership application form

🧥 Clothes Collection — support for community clothing drives

Membership System

Students can submit:

Full name

Student ID

Department

Batch / year

Reason for joining

After submission, the system generates a public member ID in the format:

SMC-0001
SMC-0002
SMC-0003

Membership requests are initially stored with a pending status and can be reviewed by an administrator.

Event System

The event system allows users to:

View available events

See event date, time, location, seats, and status

Register for an event

Prevent duplicate registration using Student ID

Prevent registration after an event is closed

Prevent registration when the event reaches its seat limit

Donation System

Users can submit donation information through bKash, including:

Donor name

Phone number

bKash number

Transaction ID

Amount

Donation purpose

Optional note

Submitted donations are initially marked as pending and can be verified or rejected by an administrator.

Admin Panel

The administrator section provides management features for:

👥 Members

📋 Event registrations

📅 Events

📌 Notices

📖 Resources

💰 Donations / fundraising

🧥 Clothing collection

💳 Payment settings

🔑 Administrator accounts

The PHP admin login uses the admins table and verifies passwords using PHP's secure password_verify() mechanism.

🛠️ Technologies Used

Frontend

HTML5

CSS3

JavaScript

Google Fonts

Responsive navigation and page layouts

Backend

PHP

PHP PDO

JSON-based API endpoints

Session-based admin authentication

Database

MySQL

Database name used by the project:

sec_muslimah

Development Environment

The project is suitable for:

XAMPP

Apache

MySQL / MariaDB

Any modern web browser

📁 Project Structure

sec-muslimah/
│
├── index.html
├── about.html
├── events.html
├── notices.html
├── resources.html
├── donate.html
├── join.html
├── admin.html
│
├── admin/
│   ├── auth.php
│   ├── dashboard.php
│   ├── login.php
│   ├── members.php
│   ├── member_action.php
│   ├── events.php
│   ├── event_action.php
│   ├── event_edit.php
│   ├── donations.php
│   └── donation_action.php
│
├── api/
│   ├── members.php
│   ├── events.php
│   ├── event_registrations.php
│   └── donations.php
│
├── config/
│   ├── database.php
│   └── test.php
│
├── css/
│   └── style.css
│
└── js/
    ├── app.js
    └── admin.js


Automated database backups

