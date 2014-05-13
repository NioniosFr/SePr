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

#### Data Assets Security

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
