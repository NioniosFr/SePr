#Software Security Project

#### Group Members
* Fan  Wang  
* Chen  ...  
* Jan Eefting  
* Tobias Zobrist 
* Dionysios Fryganas

#### Description  
For this project we are going to implement a dummy "Internal Wiki" for a company.  The purpose of this is to practice and present secure development methods and implementations as well as to test the outcome by doing penetration testing.

# --

#### Functionality Requirements  
##### Login Screen  
A secure login screen will handle user authentication.  Login will have a "capctha" to ensure that the user is indeed human.  

##### Chat functionality  
A secure chat will be implemented to enable users to comunicate with one another. The chat is global available for everybody who is logged in into the system. 

##### Wiki page  
A simple page containing sensitive company information. 

# --

### Security Requirements  


##### Threats

There might be a number of parties that will try to compromise our data or break our system for few reasons.

* Competeing companies might want to access the data in the system in order to gain a insight into the data or for a competitive edge.  
* Script kiddies might try to break into our system or break it without any paticular motive other than the disruption itself.
* Hackers might try to gain access to data in order to sell it to competitors.  
* Employees that have been let go or that hold a grudge against the company/organization might want to break the system or access the information to sell to competitors or a number of other motives.  

#####Security Principles

The system will have to be tollerant towards all the known type of attacks.

###### SQL Injection

Uri's send from the user will have to be properly escaped and should always (at any level of authentication) be handled
as untrusted.

###### XSS, XSRF, XSSI

The system needs to be thoroughly tested to ensure that no security holes are left on the design and implementation of the frontend site.
The interfaxce should be minimal and all input needs to be validated, (even the checkboxes).

###### Buffer Overflow

Pages and request will have to be processed properly and all output should be escaped when send to the user.

###### User Elevation

This technique is a subset of the buffer overflow attacks. An attacker tries to grant itself provildeges through the system and access parts that it should not. These types of attacks will have to be handled in the design of the system, as users will be able only to follow a CRUD priviledges table.
Any user not in the table will not be granted access to the system.


##### User roles and permissions

Each user of the system needs and will have to have a role. Users that are not identified by a role will not be granted access. This design pronciple will ensure that any data requested from or send to the system will be validated against the permissions the user has.

##### Data Assets Security

Data Assests:


* CRUD Permissions
* Roles
* Database Acounts
* Coding structure

###### CRUD

|   |   Roles    |
|----|----|----|
|Anonymous| - (Loggin)|
|User|  R |
|Maintainer| RU|
|Manager| CRU  |
|Admin| CRUD |


#### CIA  

##### Confidentiality  
All the information and data that our website contains should be treated as confidential and we have to make sure that it cannot be easily access by unwanted parties.  

##### Integrity  
The information should always be accurate and consistent.  This is because the information might be crucial to the company or organization.  

##### Availibility  
The content should always be available and we can only handle limited downtime.  

#### Architectural Security  

* User access permissions are required to ensure that no employee has the ability to delete the tables or databases in the system.  
* When the server or service fails, it is important not to expose any of the components without protection and failsafe mechanisms in place.  
* Source code should be written in the least complex way in order to avoid issues that may arise due to neglegance and code complexity.  
* It is important to limit user input to the absolute required amount of input for the functionality to be proper.
* The strength of all passwords will be tested to ensure that they are strong enough.  
* The passwords will be encrypted to ensure that they will remian uncompromised even if the database is compromised.  
* We will use a "Captcha" to make sure that all the login attempts are human instead of a bot or something else.  

### Security risk assesment

Risk Scenario's

##### System broken:

If the system is broken by hackers/script-kiddies etc. this will cause downtime until the system is fully recovered and running again.

Probability : low - assume it will occur 20 times a year
Impact Scale : medium - Downtime will have a medium impact because it will have financial ramifications as it will cost developers time and possibly reduce income for a time.  

##### Data Compromised:

If our data is compromised it will have a varied impact depending on how the data has been compromised.

Probability : Low - assume this will occur 5 times a year

###### Data accessed

Impact Scale : Medium - If the data is merely accesed and read then the impact is bad but not the worst.  In this case it can lead to finacial ramifications as well as a loss of reputation and eventually capital income.   

###### Data changed

Impact Scale : High - If the data is changed then the impact will be high as it will take a reletively large amount of time to find the change and correct it.  As with the other scenario's, this too will have financial ramifications as well a great potential for loss of reputation and capital income.

###### Data removed

Impact Scale : High - If the data is removed from the system it will have quite a big impact on the company.organization if the data is not securely backed up.  This will have large financial ramifications such as a loss of capital income and a loss of reputation.

##### Access Compromised:

Probability : Low - assume this happens 2x per year.
Impact Scale : High - When access to the system is compromised it allows unwanted parties to observe and slowly sabbotage the comapny/organization by systematically disrupting information used to conduct operations within the company/organization.  This can have massive financial ramifications and can mean the end of the company.  it is therefore crucial to ensure that this is difficult to happen

# --

#### Web Application Design

##### Login  Page  
https://wireframe.cc/nDSpzX  
![Login_frame](./wire_frames/login.png?raw=true)

##### Wiki Page  
https://wireframe.cc/x3Mkce  
![wiki_frame](./wire_frames/wiki.png?raw=true)
