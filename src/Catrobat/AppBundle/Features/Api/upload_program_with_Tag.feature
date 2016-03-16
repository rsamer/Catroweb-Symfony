@api
Feature: Upload a program with tag

  Background: 
    Given there are users:
      | name     | password | token      |
      | Catrobat | 12345    | cccccccccc |
    And there are programs:
      | id | name      | description | owned by | downloads | views | upload time      | version | RemixOf  |
      | 1  | program 1 | p1          | Catrobat | 3         | 12    | 01.01.2013 12:00 | 0.8.5   | null     |
    And there are tags:
      | id | en        | de          |
      | 1  | Games     | Spiele      |
      | 2  | Story     | Geschichte  |


  Scenario: program upload with tags
    Given I have a parameter "username" with value "Catrobat"
    And I have a parameter "token" with value "cccccccccc"
    And I have a parameter "language" with value "en"
    And I have a valid Catrobat file with a tag
    And I have a parameter "fileChecksum" with the md5checksum of "program_with_tags.catrobat"
    When I POST these parameters to "/pocketcode/api/upload/upload.json"
    Then The program should be tagged


     
