# PicWeb 2

Created in 2009 by Andrew Landsverk as a learning exercise.

## Setup

### Docker

1. Edit `application/fixtures/data.yml` and update the admin credentials to be your own
2. docker-compose up -d
3. After the applicaiton has started, Navigate to http://localhost/picweb2/setup
4. Click "Submit"
5. After the page refreshes you can now navigate to http://localhost/picweb2
6. You will see errors because no albums exist yet. Just login as the admin user as specified in `applicaiton/fixtures/data.yml` and create an album on the profile page.
7. Upload an image to your new album
8. Done!

### LAMP

Full instructions are not provided for LAMP stacks at this time. You will need to edit a few files to point to a different MySQL instance however:

- `displaypic.php`
- `application/config/database.php`

You will also need to make sure mod_rewrite is enable for Apache and that you deploy the application to the `/picweb2/` directory under your base `/var/www/html/` or similar, otherwise you will most likely need to alter the `.htaccess` file that has also been provided.
