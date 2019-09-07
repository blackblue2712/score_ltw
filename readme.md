# <img src="./icon/favicon.png" width="40" /> View score - Web programing (v0.0.1)


## For student
* Access: [https://liars2712.000webhostapp.com]
* Type student id **(8 characters)**, **valid captcha** then click **Fetch**. You may wait for a second because of ajax method 
## For admin
* Access: [https://liars2712.000webhostapp.com/admin]

## After signin, choose file excel to import
Type: 
### Insert in one query: all of student ids not exist in database
* INSERT INTO table VALUES('', '', '', ''), VALUES('', '', '', ''), VALUES('', '', '', '') ,...
### Insert in for loop: have ids student in database and want to add more
* INSERT INTO table VALUES('', '', '', '') INSERT INTO table VALUES('', '', '', '') INSERT INTO table VALUES('', '', '', '') INSERT INTO table VALUES('', '', '', '')
### Update:
* UPDATE table SET ' ' = ' '
### Click submit
* Wait for a second, you will see the alert **check the console**
* You **can review, delete** file after uploaded

# Format file excel
| id | name | gender | score |
| -- | ---- | ------ | ----- |
| 1 | Liars | Female | 7 |
