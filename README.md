# Library
This is a book library with api.

## Run
To run this application, create config.local.php in app folder (you can use config.local.php.example as a basis) 

You can also override any parameters from config.local.php if needed

## API
Here are available api methods:

### Add new book.
#### POST /scan
It accepts following params
* "isbn": \<int\>,
* "author_full_name": \<string\>,
* "title": \<string\>,
* "year": \<int\>

### Get authors top 100
#### GET /authorsTop100
Returns top 100 items, where each item contains author name
and number of books written by this author in our library.

### Get books by author
#### GET /books?author={AUTHOR}
Method accepts any part of the author name ("fuzzy" search) and  and returns list of matched books. Each item contains book
title, ISBN, author and time of adding to the library.

### Get books in a range of years.
#### GET /books?from={FROM}&to={TO}
Method accepts one or two parameters that specify years range.
Year parameter that is not specified means "infinity". Method returns books written in that years
inclusively. Each item contains book title and ISBN.

### Get number of books per year by an author.
#### GET /authorYearlyBooks?author={AUTHOR}
Accepts author name and returns a JSON object where keys are years, value of each key is an object containing author name and number of books.
