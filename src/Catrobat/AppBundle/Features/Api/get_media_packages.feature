@api
Feature: Get media package files

  Background: 
    Given the server name is "pocketcode.org"
    And I use a secure connection

    Given there are mediapackages:
      | id | name    | name_url |
      | 1  | Looks   | looks    |
      | 2  | Sounds  | sounds   |

    And there are mediapackage categories:
      | id | name    | package |
      | 1  | Animals | Looks   |
      | 2  | Fantasy | Sounds  |
      | 3  | Bla     | Looks   |

    And there are mediapackage files:
      | id | name       | category | extension | active | file   | flavor                   |
      | 1  | Dog        | Animals  | png       | 1      | 1.png  | pocketcode               |
      | 2  | Bubble     | Fantasy  | mpga      | 1      | 2.mpga | pocketcode               |
      | 3  | SexyGrexy  | Bla      | png       | 0      | 3.png  |                          |
      | 4  | SexyFlavor | Animals  | png       | 1      | 4.png  | pocketflavor             |
      | 5  | SexyNULL   | Animals  | png       | 1      | 5.png  |                          |
      | 6  | SexyWolfi  | Animals  | png       | 1      | 6.png  | pocketflavor, pocketcode |
      
  Scenario: show featured programs
    When I GET "/pocketcode/pocket-library/looks.json"
    Then I should get the json object:
      """
      [
        {
        "name":"Animals",
        "files":
          [
            {
              "id":1,
              "name":"Dog",
              "url":"resources_test\/mediapackage\/1.png"
            },
            {
              "id":4,
              "name":"SexyFlavor",
              "url":"resources_test\/mediapackage\/4.png"
            },
            {
              "id":5,
              "name":"SexyNULL",
              "url":"resources_test\/mediapackage\/5.png"
            },
            {
              "id":6,
              "name":"SexyWolfi",
              "url":"resources_test\/mediapackage\/6.png"
            }
          ],
        "priority":0
        }
      ]
      """
