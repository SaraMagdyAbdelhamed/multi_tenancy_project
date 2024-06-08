Multi-Tenant Quiz Application
==================
This application is a multi-tenant quiz platform that allows you to serve multiple clients with a single codebase

==============

# Models 
The application consists of the following models:

# Central Database
Tenant => To Handle tenant data such as id , name , email of user , database name
domains => To handle domains for each tenant 

# Tenant Database
User => Has Admins Data
Member => Has Members Data
Quiz => Quizes That Members can subscribe and submit
Question => Related to Quiz 
Choice => Related To Question 
MemberQuiz => Has each attempts member has for quiz
QuizAttempt => Has last attempt data and number of attempts that member has for quiz


=============================
# Features
 * You Can create multiple tenants served by same code and multiple databases  , So You can create your own Tenant .
 * When Create Your Own Tenant And Visit domain name , You can see your tenant Dahboard .
 * Tenant Admin can create Members [ add , edit , delete ]
 * Tenant Admin can Create Quiz [ add , edit , delete ]
 * Member Can register and login to same dashboad 
 * Member can see quiz list and supscribe to quiz 
 * Email sent to member after subscribtions , Member can goto quiz and submit answers
 * Email sent with result To member and admin 
 * Member can see his result on dashboard 
 * Admin can see All results on quiz ( make with filament )
 * Admin can export all results on quiz 
 * Their is schudueled job for reminding member before exam start
 * Their is job for export exam result so it run in queue if data is big 
 * Seeder for create 20000 record on quizattempt table using faker
 * dashbaord  has:
    Number of members
    Attempts
    Pass rate
    Fail rate
    Average score
    Average time (for in-time quiz)

 * Test Cases Using Pest

=====================





