# Hospital Database
Developed a website using HTML, CSS, JavaScript, Ajax, PHP and MySQL. Could be used in hospitals by doctors and patients to save time.
Used role-based access control (RBAC) to ensure secure handling of patient data 
Stores data in hospital and storage tables.
Also has data in users table, therby allowing only authorized users. Inactivity for more than 60 seconds would expire the session.

Implemented RESTful API with a single source endpoint for all database actions.
Steps to Execute the program using Xampp:
1. Run the SQL code in xampp console
2. All files placed in a file inside htdocs in Xampp
3. Run it using localhost after starting apache and sql servers:
  The patient uses- index file
  The doctor uses- doc file
4. If not using localhost for testing/ for more security, make sure to setup config.php with your credentials
5. Doc.php will routinely update every 60seconds to update patients
