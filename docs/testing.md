## Testing Guidelines 🧪
Portal uses Cypress for automated testing.
## Cypress 💻
Cypress is a next generation front end testing tool built for the modern web. It address the key pain points developers and QA engineers face when testing modern applications.
For more information check offical documentation [here](https://docs.cypress.io/guides/getting-started/writing-your-first-test).

### In a nutshell
Cypress make it possible to:
- Set up tests
- Write tests
- Run tests
- Debug Tests

This enables you to write faster, easier and more reliable tests.

### Who uses Cypress?
Cypress enables you to write all types of tests:
- End-to-end tests
- Integration tests
- Unit tests

Cypress can test anything that runs in a browser.

### Writing Your Test Case
- Tasks:
    1. Visit the page at `/posts/new`.
    2. Find the `<input>` with class post-title.
    3. Type `"My First Post"` into it.
    4. Find the `<input>` with class post-body.
    5. Type `"Hello, world!"` into it.
    6. Click the element containing the text `Submit`.
    7. Grab the browser URL, ensure it includes `/posts/my-first-post`.
    8. Find the `h1 tag`, ensure it contains the text `"My First Post"`.
    
- Your test case look like:
    ```js
    describe('Post Resource', () => {
        it('Creating a New Post', () => {
            cy.visit('/posts/new') // 1.
            cy.get('input.post-title') // 2.
            .type('My First Post') // 3.
            cy.get('input.post-body') // 4.
            .type('Hello, world!') // 5.
            cy.contains('Submit') 
            .click() // 6.
            cy.url() // 7.
            .should('include', '/posts/my-first-post')
            cy.get('h1') // 8.
            .should('contain', 'My First Post')
        })
    })
    ```

### Steps to run cypress:
1. Copy `cypress.json.example` as `cypress.json` in the same directory.
    ```sh
    cp cypress.json.example cypress.json
    ```
    For more configuration options please refer [here](https://docs.cypress.io/guides/references/configuration#cypress-json).


2. Run the following command to run cypress 
    - Headless mode  
        ```sh
        npm run cypress
        ```
    - GUI mode 
        ```sh
        npm run cypress-open
        ```
