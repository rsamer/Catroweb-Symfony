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
      | 3  | Music     | Musik       |
      | 4  | Art       | Kunst       |

  Scenario: get all tags for language english before upload
    Given I want to upload a program
    And I have a parameter "language" with value "de"
    When I GET the tag list from "/pocketcode/api/tags/getTags.json" with these parameters
    Then I should get the json object:
      """
      {
        "statusCode":200,
        "constantTags":[
                          "Spiele",
                          "Geschichte",
                          "Musik",
                          "Kunst"
                       ]
      }
      """
  Scenario: get all tags in english and statuscode 404 when no language is passed
    Given I want to upload a program
    And I have no parameters
    When I GET the tag list from "/pocketcode/api/tags/getTags.json" with these parameters
    Then I should get the json object:
      """
      {
        "statusCode":404,
        "constantTags":[
                          "Games",
                          "Story",
                          "Music",
                          "Art"
                       ]
      }
      """
  Scenario: get all tags in english and statuscode 404 when a none existing language is passed
    Given I want to upload a program
    And I have a parameter "language" with value "NotExisting"
    When I GET the tag list from "/pocketcode/api/tags/getTags.json" with these parameters
    Then I should get the json object:
      """
      {
        "statusCode":404,
        "constantTags":[
                          "Games",
                          "Story",
                          "Music",
                          "Art"
                       ]
      }
      """

#  Scenario: upload a tagged program with tags Games and Story
#    Given I have a Catrobat file with tags "Story,Art"
#    And I use the "english" app
#    When I upload the tagged program
#    Then The program should be tagged with "Story,Art" in the database


#  Scenario: show random programs
#    Given I have a parameter "limit" with value "2"
#    And I have a parameter "offset" with value "0"
#    When I GET "/pocketcode/api/projects/randomPrograms.json" with these parameters
#    Then I should get 2 programs in random order:
#      | Name      |
#      | program 1 |
#      | program 4 |

#  Scenario: upload a tagged program
#    Given I have a valid Catrobat file with a tag
#    And I have a parameter "deviceLanguage" with value "en"
#    When I upload the tagged program
#    Then The program should be tagged correctly in the database
#

#  Scenario: upload a tagged program
#    Given I have a Catrobat file with tags "xxx"
#    And I use the english app
#    When I upload the tagged program
#    Then The program should have the tag "xxx" in the database

     
