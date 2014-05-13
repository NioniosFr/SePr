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
A secure chat will be implemented to enable users to comunicate with one another.  

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

##### User roles and permissions

Each user of the system needs and will have to have a role. Users that are not identified by a role will not be granted access. This design pronciple will ensure that any data requested from or send to the system will be validated against the permissions the user has.

##### Data Assets Security

Data Assests:


* CRUD Permissions
* Roles
* Database Acounts
* Coding structure

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


### Security Principles  


### Security Risks  

# --

#### Web Application Design

##### Login  Page  
https://wireframe.cc/nDSpzX  
![Login_frame](./wire_frames/login.png?raw=true)

##### Wiki Page  
https://wireframe.cc/x3Mkce  
![wiki_frame](./wire_frames/wiki.png?raw=true)
