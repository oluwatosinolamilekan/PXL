<p align="center"><a href="https://pxlwidgets.com" target="_blank"><img src="https://pxlwidgets.com/images/illustrations/home-hero.png" width="300"></a></p>

### PXL.Widgets

## The application should have the following:

Write a process that will neatly transfers the contents of the JSON file to a database.
Preferably as a background task in Laravel. Using Docker is allowed, but only if that makes its more fun.
We mainly pay attention to the design and structure of the code. We would prefer a solid, neat, well-maintainable solution that doesn’t work 100%, then a completed solution that is messy and inimitable. We are particularly interested in the thinking behind your approach.


## Conditions

-  [Primary] Create a process in such a way that it can be cut off at any moment (i.e. by a
SIGTERM, power failure, etc.), and can easily be resumed from the point where you left off, by anyone, in a robust & reliable manner (without duplicating data)1.
- Design your solution 'for growth', taking into account a hypothetical customer who will always have additional wishes.
- Use a solid, but not exaggerated database model.
Code for Eloquent models, relationships are not important here, we are more concerned about the data structure.
- Only process records of which the age is between 18 and 65 (or unknown).


## Bonus

Bonus
As an added challenge, we offer the following information:
- What if the source file suddenly becomes 500 times larger?
- Is the process easy to deploy for an XML or CSV file with similar content?
- Suppose that only records of which the credit card number contains three of the same numbers consecutively should be processed, how would you approach that?
- Please note that there is no guarantee that there are no duplicate records in the source file (there are no guaranteed unique (combinations of) properties) – and all duplicates must be copied in an exact manner into the database.

## Technologies

- PHP ^7.3|^8.0
- Laravel
- Docker

## How to run the application

Below are the steps you need to successfully setup and run the application.
- Clone the app from the repository and cd into the root directory of the app


