@api @tag
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


#  Scenario: get all tags before upload
#    Given I want to upload a program
#    When I GET the tag list from
#    Then I should get the json object:
#
#  Scenario: show random programs
#    Given I have a parameter "limit" with value "2"
#    And I have a parameter "offset" with value "0"
#    When I GET "/pocketcode/api/projects/randomPrograms.json" with these parameters
#    Then I should get 2 programs in random order:
#      | Name      |
#      | program 1 |
#      | program 4 |



  Scenario: get tags before uploading
    Given I want to upload a program
    When I GET the tag list
    Then I should get the json object:
      """
      {
        "statusCode":200,
        "constantTags":[
                          "Games",
                          "Story"
                       ]
      }
      """

  Scenario: upload a tagged program
    Given I have a valid Catrobat file with a tag
    And I have a parameter "language" with value "en"
    When I upload the tagged program
    Then The program should be tagged correctly in the database


#  Scenario: upload a tagged program
#    Given I have a Catrobat file with tags "xxx"
#    And I use the english app
#    When I upload the tagged program
#    Then The program should have the tag "xxx" in the database

     
