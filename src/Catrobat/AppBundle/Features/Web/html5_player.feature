@homepage
Feature: Check if html5 player is integrad

  Background:
    Given there are users:
      | name     | password | token       | email               |
      | Catrobat | 123456    | cccccccccc | dev1@pocketcode.org |
    Given there are programs:
      | id | name      | description | owned by | downloads | views | upload time      | version | apk_downloads |
      | 1  | program 1 | p1          | Catrobat | 3         | 12    | 01.01.2013 12:00 | 0.8.5   | 1             |
    And I am on "/pocketcode"

  Scenario: In order to play a program in the browser
            The html5 team
            Needs the player javascript to be integrated
    When I am on a programs details page
    Then the javascript file "/html5/player/pocketCodePlayer.min.js" should be included
    And the javascript function "launchProject" should be available

  Scenario: In order to play a program in the browser
            The html5 team
            Wants the user to be able to starts the program
    Given I am on the details page of the program with id "1"
    And the player javascripts are loaded
    When the user clicks on the player icon
    Then the javascript function "launchProject" should be called with parameters:
        | Value | Description |
        | 1     | Program ID  |
        | 'en'  | Language    |