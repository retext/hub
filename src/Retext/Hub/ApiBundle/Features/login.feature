@Login
Feature: Login
  As a user
  I should be able to login with my email address
  In order to receive a login link

  Background:
    Given I add "Accept" header equal to "application/json"

  Scenario: Request login link
    Given I send a POST request to "https://hub.retext.it.dev/api/auth/login" with JSON values:
      | email | john.doe@example.com |
    Then the response status code should be 201
    And the header "content-type" should contain "application/json"
