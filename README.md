# Still Point

Still Point is a database-driven catalogue of precision cue instruments. It was built as a focused web application rather than a general sports shop, combining a public browsing experience with a protected member area for content management.

## Project overview

The site allows public users to browse a curated collection of cue instruments, open individual detail pages, read supporting pages such as provenance and FAQ, and send an enquiry through a contact form. Authenticated members can sign in, access the dashboard, and register new instruments with structured metadata and an uploaded image.

## Features

- Public home page
- Collection page with database-driven entries
- Instrument detail page
- Provenance page
- FAQ page
- Contact form with validation and feedback
- Member login area
- Protected dashboard
- Add instrument form with image upload
- Server-side validation
- Prepared statements for database access
- Flash feedback messages
- Keyboard focus states and skip link

## Technology stack

- PHP
- MySQL
- HTML5
- CSS3
- XAMPP
- VS Code
- Git and GitHub

## Database structure

The database uses two main tables:

- `users` — stores member login credentials
- `instruments` — stores cue instrument data such as name, type, material, dimensions, description, image path, and creation timestamp

## Demo login

For assessment purposes, the protected member area can be accessed with:

- Username: `custodian`
- Password: `test123`

In a real deployment, credentials would not be displayed publicly.

## Local setup

1. Place the project inside `htdocs` in XAMPP
2. Start Apache and MySQL from XAMPP Control Panel
3. Import the SQL schema into phpMyAdmin
4. Open the site in the browser through `localhost`
5. Use the demo credentials to test the protected area

## Project structure

- `public/` — public-facing pages and stylesheet
- `src/` — bootstrap and database helpers
- `templates/` — shared header and footer
- `uploads/` — uploaded images
- `sql/` — schema file

## Security and validation highlights

- Password hashing
- Session-based access control
- Prepared statements
- Output escaping
- File type and size validation
- Realistic numeric validation ranges
- CSRF protection
- Required-field validation

## Accessibility highlights

- Shared semantic page structure
- Visible keyboard focus states
- Skip link
- Labelled form controls
- Consistent navigation
- Readable colour contrast
- Responsive content layout

## Future improvements

- Search and filter on collection page
- Edit and delete actions in member area
- Database storage for contact enquiries
- Better image management
- Stronger deployment pipeline

## Author

Salahdine Maamri El Hazmiri  
Student ID: 1390901
