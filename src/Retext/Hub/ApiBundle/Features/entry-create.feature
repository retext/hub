@Entries
Feature: Create Entry
  As a user
  I should be able to create a new entry

  Background:
    Given the "RetextHubBackendBundle:User" entity exists in "user" with values:
      | handle | {\Dothiv\ValueObject\IdentValue@userhandle}          |
      | email  | {\Dothiv\ValueObject\EmailValue@someone@example.com} |
    And the "RetextHubBackendBundle:Organization" entity exists in "organization" with values:
      | handle | {\Dothiv\ValueObject\IdentValue@bcrm} |
    And the "RetextHubBackendBundle:Project" entity exists in "project" with values:
      | organization | {organization}                          |
      | handle       | {\Dothiv\ValueObject\IdentValue@bcrm14} |
    And the "RetextHubBackendBundle:EntryType" entity exists in "sessionType" with values:
      | project | {project}                                |
      | handle  | {\Dothiv\ValueObject\IdentValue@session} |
    And the "RetextHubBackendBundle:EntryField" entity exists in "titleField" with values:
      | type   | {sessionType}                          |
      | handle | {\Dothiv\ValueObject\IdentValue@title} |
    And the "RetextHubBackendBundle:EntryField" entity exists in "descriptionField" with values:
      | type   | {sessionType}                                |
      | handle | {\Dothiv\ValueObject\IdentValue@description} |
    And the "RetextHubBackendBundle:EntryField" entity exists in "hostField" with values:
      | type   | {sessionType}                         |
      | handle | {\Dothiv\ValueObject\IdentValue@host} |
    And the "RetextHubBackendBundle:UserToken" entity exists in "userToken" with values:
      | user     | {user}                                     |
      | token    | {\Dothiv\ValueObject\IdentValue@usert0k3n} |
      | scope    | {\Dothiv\ValueObject\IdentValue@login}     |
      | lifetime | {\DateTime@2014-01-02T13:44:15}            |
    Given I add "Accept" header equal to "application/json"

  Scenario: Create entry
    Given I add Bearer token equal to "3fa0271a5730ff49539aed903ec981eb1868a735"
    When I send a POST request to "https://hub.retext.it.dev/api/bcrm/bcrm14/entry" with JSON values:
      | type        | session                   |
      | title       | My example Session        |
      | description | Description of my session |
      | host        | John Doe                  |
    Then the response status code should be 201
    And the header "content-type" should contain "application/json"
    And the header "location" should match "%^https://hub\.retext\.it\.dev/api/bcrm/bcrm14/entry/[0-9a-f]{32}$%"
    When I follow the location header
    Then the response status code should be 200
    And the header "content-type" should contain "application/json"
    And the response should contain these JSON values:
      | @context           | http://hub.retext.it/jsonld/Entry |
      | fields.title       | My example Session                |
      | fields.description | Description of my session         |
      | fields.host        | John Doe                          |
    When I send a GET request to "https://hub.retext.it.dev/api/bcrm/bcrm14/entry"
    Then the response status code should be 200
    And the header "content-type" should contain "application/json"
    And the response should contain these JSON values:
      | @context                    | http://hub.retext.it/jsonld/PaginatedList |
      | count                       | 1                                         |
      #| items[0].@context           | http://hub.retext.it/jsonld/Entry         |
      | items[0].fields.title       | My example Session                        |
      | items[0].fields.description | Description of my session                 |
      | items[0].fields.host        | John Doe                                  |
