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

🔌 API Endpoints

The project uses PHP endpoints to connect the frontend with MySQL.

Membership

POST /api/members.php

Used to submit a membership request.

Events

GET /api/events.php

Used to retrieve events.

POST /api/events.php

Used to create an event.

Event Registration

POST /api/event_registrations.php

Used to register a student for an event.

The API checks:

Whether the event exists

Whether the event is active

Whether the student has already registered

Whether seats are still available

Donations

POST /api/donations.php

Used to submit donation information.

🗄️ Database Configuration

The project currently expects a MySQL database named:

sec_muslimah

The database connection is configured in:

config/database.php

The current configuration uses:

Host: localhost
Database: sec_muslimah
Username: root
Password: empty

For a different MySQL configuration, update config/database.php.

Important: Do not commit real database passwords or payment credentials to a public repository.

🚀 How to Run the Project Locally

1. Install XAMPP

Install XAMPP with:

Apache

MySQL

Start both Apache and MySQL from the XAMPP Control Panel.

2. Copy the Project

Place the project folder inside:

C:\xampp\htdocs\

For example:

C:\xampp\htdocs\sec-muslimah\

3. Create the Database

Open:

http://localhost/phpmyadmin

Create a database named:

sec_muslimah

The required tables should then be created according to the application's PHP queries, including the core tables for:

admins

members

events

event_registrations

donations

The application also contains functionality referring to campaign/cause and community-content data.

The current project ZIP does not contain a SQL dump file, so the database schema is not automatically imported from the repository.

4. Configure Database Connection

Open:

config/database.php

Make sure the connection matches your MySQL setup.

5. Open the Website

Visit:

http://localhost/sec-muslimah/

or:

http://localhost/sec-muslimah/index.html

6. Open the PHP Admin Login

The PHP admin login is available at:

http://localhost/sec-muslimah/admin/login.php

An administrator account must exist in the admins table.

The password stored in the database should be a PHP password hash generated using password_hash().

🔐 Admin Authentication

The PHP admin login:

Receives the administrator username and password.

Searches the admins table by username.

Verifies the password using:

password_verify($password, $admin["password"])

Creates a PHP session after successful authentication.

Redirects the administrator to the dashboard.

The admin authentication files are located in:

admin/login.php
admin/auth.php

👩‍💻 User Workflow

A typical student workflow is:

Visit Website
      ↓
View About / Events / Notices / Resources
      ↓
        ┌───────────────┐
        │               │
     Join Us          Events
        │               │
 Submit Membership   Register
        │               │
        ↓               ↓
 Pending Review    Registration Saved

For donations:

Choose Donation / Fundraising
          ↓
Send money through bKash
          ↓
Enter transaction information
          ↓
Submit donation details
          ↓
Donation status = Pending
          ↓
Admin verifies / rejects

👩‍💼 Administrator Workflow

Admin Login
     ↓
Dashboard
     ↓
 ┌───────────┬────────────┬─────────────┐
 Members     Events       Donations
     ↓          ↓             ↓
 Review      Add/Edit      Verify/
 Requests    Events         Reject

The administrator can manage community information and review submitted data from the admin area.

🎨 Design

The website uses a soft, elegant visual style with:

Purple and lavender tones

Islamic-inspired visual elements

Serif typography

Responsive layouts

Card-based content sections

Mobile navigation

Separate public and administrative interfaces

The main styling is contained in:

css/style.css

🔒 Security Considerations

For production deployment, the following should be considered:

Use strong administrator passwords.

Store only hashed passwords in the admins table.

Never expose database credentials publicly.

Use HTTPS.

Validate and sanitize all user input.

Add CSRF protection to administrative forms.

Restrict access to administrative endpoints.

Use appropriate database permissions instead of a full-privilege MySQL account.

Keep payment information and credentials out of source control.

Disable detailed PHP error output on the production server.

📌 Important Project Note

The current repository contains both:

admin.html

and a PHP-based:

admin/

directory.

The PHP admin system connects to MySQL and provides server-side authentication and management pages. The older/static admin.html and its JavaScript-based admin logic are also present in the project.

When deploying the database-backed version, the PHP admin pages should be treated as the primary server-side administrative interface.

🎯 Project Objectives

The main objectives of SEC Muslimah Community are to:

Provide an online platform for the community.

Make community information easily accessible.

Allow students to apply for membership online.

Organize and manage events digitally.

Allow students to register for events.

Share Islamic educational resources.

Publish notices and announcements.

Support charitable activities and fundraising.

Manage donations through an administrative system.

Reduce manual management of community activities.

🔮 Future Improvements

Possible future improvements include:

Complete SQL database/schema file in the repository

Full CRUD APIs for notices and resources

Role-based administrator permissions

Email notifications

Membership approval notifications

Event reminder notifications

Donation receipts

Improved donation reporting

Search and filtering

Admin activity logs

Stronger CSRF and authorization protection

HTTPS deployment

Production-ready payment integration

Cloud/database deployment

Automated database backups

