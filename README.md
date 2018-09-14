# InnoLib
Site for Innopolis Library System.
Made as a course project for Introduction to Programming II subject in Innopolis University, 2nd semester. 

**Team:** [Irek Nazmiev](https://github.com/Nagellan), [Mikhail Moiseev](https://github.com/lackadaisicalcynic), [Lera Vertash](https://github.com/vvertash)

* Here is a [link](http://y98722gq.beget.tech/index.html) to the working site on a hosting service.

### Assigned task
Task is to make a library system. The system contains all information about books, magazines, audio/video materials, as well as people allowed to check out the materials. Library enables users to search for and check out documents. Types of users: student, teaching assistant, instructor, professor, visiting professor, librarian (with privileges 1, 2 or 3) and admin. Librarians can enter new materials, manage users of the library. Admin can manage librarians (add, delete or modify information about them), assign their privileges and see a list of logs (all the actions executed by each user of the library).

### Solution of the problem
There are some variants of how to solve this task: desktop app, telegram bot and website. We decided to make a site, because it doesn’t require any extra services as other variants have. Desktop app demands person to download the program, telegram bot obligates user to create a telegram account. Website is the most convenient way for solving our posed task, because it requires only web-browser which every device has.

### Functionality
Our site contains 4 sections for patrons and 6 sections for admin and librarians of different privileges.

**Patron sections:** main page, list of books page, account page and sign in/sign up page.
1. Main page _contains short description of InnoLib online library system._
2. List of books page _contains the table of all available books divided to 3 sections: books, articles and av-files. From this page user can go to chosen book’s description page where it’s available to book it. Also user can use search to find an interesting book._
3. Account page _contains all the user’s information and table of taken books. Here is possible to return and renew book, leave the queue on book and cancel the request on book. Also user can change its password and account image._
4. Sign in / sign up page _allows user to create an account or log in into the already created one._

**Admin/librarian sections:** main page, manage books page, manage patrons page, checking requests page, account page and sign in / sign up page.
1. Main page, account page and sign in/sign up page are the same as patron has.
2. Manage books page _contains the table of all available books and allows admin/librarian to add new books (for priv2 and priv3 librarians), edit and delete (only for priv3 librarians) the existing ones and to make an outstanding request. Also here is available a search._
3. Manage patrons page _contains the table of all users and allows librarian to add new users (for priv2 and priv3 librarians), edit and delete (only for priv3 librarians) the existing ones and see the list of users’ taken books._
4. Requests page _contains the table of users’ requests for taking available books and priority queue on taking unavailable books, requests on returning the books where it’s possible to accept or reject the requests. Also there is a list of logs which is available only for an admin._

### Description of the system
To make our library system, we used HTML, CSS and JavaScript for frontend, PHP for backend and phpMyAdmin administration tool for MySQL database. To host our site, we use online hosting http://beget.com which also provides online file manager with the opportunity to manage and edit files (we use this file manager instead of GitHub), phpMyAdmin database tool and lots of other stuff. 

Information is read by using forms, input tags and buttons on our html pages, processed by php scripts and then sent to the database. Example: section “Add book” on page “Books” use script “save_book.php” to add a new book to the library. 

Then this information is received from database by using php scripts, processed and written into the html page. The example is page “Books” which takes all the information about books from the database. 

Librarians of all privileges have the opportunity to edit the information given and written from the database. It’s possible, because we write this information into the value of special input tags that allows us to change their values and then read it by php script. All the table is inside the form, that is why we can read the changed information from inputs by using PHP and then update it in our database. Example: information on “Books” page is given from database, but we can change it and save changes. 

Our site uses cookies to remember user’s status to determine whether user is a librarian or not. This is necessary in order to giving an access to librarians special functions. Also cookies are used for remembering the book while going into the page with its description. Book id is given from the cookies and then used for reading the book information from the database and writing it into the page.

When a librarian (which is priv2 or priv3) adds a new user, its password is generated randomly and then sent into the email written in the form. It prevents librarian from knowing the user’s password. It’s possible because of php mail form handler which uses the existing email address (which can be set up) and sends from it necessary email - with passwords, in our case.

### Scheme
![Scheme of the project](https://github.com/Nagellan/InnoLib/blob/master/img/project%20scheme.png?raw=true)
