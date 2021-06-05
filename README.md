# catL
University PHP Project 

# About the Project
catL is an university project for cat-lovers, where they can share,explore and enjoy cats. 
 
* Implemented features :
    * User Registration/Authentication/Authorization - catL supports two type of users (regular user and ```Admin``` user)
        * Admin User    
            * Structured as a regular user with the difference that ```isAdmin column``` in the table ```tbl_user``` is set to ```true```.
            * Has privilleges over the regular user and user's cat(s).
    * Sessions
        * Every sessions has its own profile page where the current user has the authorization to:
            * Read and Update personal user data from the database.
            * Create, Read, Update, Delete (CRUD) data for current user's cat(s) data.
            * Add images to their personal gallery and preview them.
        * The ```Cats``` pannel (page) is viewable for the current user. In case the session is not set ,then the cats-page's (```cats.php```) content is not visible. In the Cats pannel the user is authorized to :
            * Read and Filter all cat data from the database.

        * ```Controls``` pannel (page)  - accessed when the user is of type ```Admin```, in the controls pannel the admin is authorized to:
            * Read and Delete all cat and user data from the database.


# Built With:
* HTML
* PHP
* CSS
* Javascript


# Resources :
* Images : 
    * https://unsplash.com/
    * https://www.pexels.com/
    * https://www.flaticon.com/
* Color palletes :
    * https://www.happyhues.co/
* Fonts:
    * https://fonts.google.com/
* Icons:
    * https://fontawesome.com/v6.0

# Deployment
To set up the database you'll need to import the database from the folder : ```database-export``` , where you can find the following file : ```cat;(1).sql``` (which is the database for the catL project).
To set up and admin, you need to register as a regular user and the in the table ```tbl_user``` you'll need to set ```isAdmin``` to **true**, since the default value for all users is **NULL**.
