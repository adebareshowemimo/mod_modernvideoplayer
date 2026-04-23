@mod @mod_modernvideoplayer
Feature: Focus Mode enforcement settings
  In order to keep learners focused on the video
  As a teacher
  I need to be able to enable Focus Mode and toggle Picture-in-Picture and transcript download

  Background:
    Given the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "users" exist:
      | username | firstname | lastname |
      | teacher1 | Teacher   | One      |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "activities" exist:
      | activity         | course | name        |
      | modernvideoplayer | C1     | Focus demo |

  Scenario: The Enforcement settings section exposes the Focus Mode toggles with the expected defaults
    When I am on the "Focus demo" "modernvideoplayer activity editing" page logged in as teacher1
    And I expand all fieldsets
    Then I should see "Enforcement settings"
    And the field "Enforce focus on the video" matches value "0"
    And the field "Allow Picture-in-Picture" matches value "1"
    And the field "Allow transcript download" matches value "1"

  Scenario: Teacher can enable Focus Mode and disable transcript download
    When I am on the "Focus demo" "modernvideoplayer activity editing" page logged in as teacher1
    And I expand all fieldsets
    And I set the field "Enforce focus on the video" to "1"
    And I set the field "Allow transcript download" to "0"
    And I press "Save and return to course"
    And I am on the "Focus demo" "modernvideoplayer activity editing" page
    And I expand all fieldsets
    Then the field "Enforce focus on the video" matches value "1"
    And the field "Allow transcript download" matches value "0"
