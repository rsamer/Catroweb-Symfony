@doc
Feature: Upload a program to the website

  Background:
   
    Given there are users:
      | name     | password | token      |
      | Catrobat | 12345    | cccccccccc |
      | User1    | vwxyz    | aaaaaaaaaa |

  Scenario: Upload program
    Given The HTTP Request:
          | Method | POST                               |
          | Url    | /pocketcode/api/upload/upload.json |
      And The POST parameters:
          | Name          | Value                  |
          | username      | Catrobat               |
          | token         | cccccccccc             |
          | fileChecksum  | <md5 checksum of file> |
      And A catrobat file is attached to the request
      And The POST parameter "fileChecksum" contains the MD5 sum of the attached file
      And We assume the next generated token will be "rrrrrrrrrrr"
     When The Request is invoked
     Then The returned json object will be:
          """
          {
            "projectId": "1",
            "statusCode": 200,
            "answer": "Your project was uploaded successfully!",
            "token": "rrrrrrrrrrr",
            "preHeaderMessages": ""
          }
          """
