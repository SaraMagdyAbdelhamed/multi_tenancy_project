Multi-Tenant Quiz Application
==================
This application is a multi-tenant quiz platform that allows you to serve multiple clients with a single codebase

# Requirements
PHP 8.1 or higher
Composer 2.3.10
node 18.17.0
npm 9.8.1

============
# Installation

* clone this repository git clone https://github.com/SaraMagdyAbdelhamed/multi_tenancy_project.git quiz
* cd into the project directory cd quiz
* run composer install
* run npm install and npm run dev
* Rename the .env.example file to .env and update the configuration values, including database settings and any other required environment variables.
* run migration php artisan migrate
* serve the application php artisan serve or use laravel valet, or any other server , I use laragon on windwos 
* visit the application in your browser http://quiz.test if you are using valet
* Run the application locally by executing php artisan serve

***** Important If you run in WINDOWS 
- edit hosts file permission to write so project can edit it when creates new tenants 
==============
# Testing
for run the test cases you need
* commit middleware in tenant.php file 
 [InitializeTenancyBySubdomain::class,
 PreventAccessFromCentralDomains::class ]
* change APP_ENV=local to be APP_ENV=testing 
* run php artisan optimize in cmd
* run php artisan test
* Tests Done ( Member registration , Admin Login To dashboard , Create Quiz By Admin , Show All Quizzes )

============================
# # ROUTES 
* Tenant Registration
To register a new tenant, send a POST request to the following endpoint:

POST /tenant/register
The request body should contain the following information:
{
  "name": "Tenant Name",
  "email": "tenant@example.com",
  "password": "password",
  "domain": "test"
}

This will create subdomain under you parent domain 
example  (test.quiz.test)

----------------
* Quiz Management
The application provides several routes for managing quizzes. Here are some of the available routes:

GET /quizes: Get a list of all quizzes.
GET /quizes/create: Show the form to create a new quiz.
POST /quizes: Store a new quiz in the database.
GET /quizes/{quiz}/edit: Show the form to edit an existing quiz.
PUT /quizes/{quiz}: Update the details of an existing quiz.
DELETE /quizes/{quiz}: Delete a quiz from the database.
GET /quizes/export-quiz-results: Export quiz results to a file. This route dispatches a job to export the quiz results in the background. The exported file will be available for download after a delay of 1 minute.

GET /quizes/{quiz}/result : show result of qll members in quiz ( this was done by filament )
-----------------------

* Member Registration and Authentication
Members can register and log in to access the quiz platform. Here are some of the available routes for member registration and authentication:

GET /member/login: Show the login form for members.
POST /member/login: Log in a member with the provided credentials.
GET /member/register: Show the registration form for members.
POST /member/register: Register a new member in the database.
POST /member/logout: Log out the authenticated member.
-----------------
* Members 

GET /members: Get a list of all members.
GET /members/create: Show the form to create a new member.
POST /members: Store a new member in the database.
GET /members/{member}/edit: Show the form to edit an existing member.
PUT /members/{member}: Update the details of an existing member.
DELETE /members/{member}: Delete a member from the database.

----------------
* Admin login and logout 
POST /logout: Log out the authenticated user (admin).
GET /login : show login form for admin 
POST /login : post login data 

-------------------
* Members Subscribe To Quiz
POST /quizes/{quiz}/subscribe : subscribe to quiz 
GET /quizes/member/{link} : open quiz link that has start quiz button 
GET /quizes/startQuiz/{link} : start quiz
POST /quizes/{quiz}/submit : submit quiz result

