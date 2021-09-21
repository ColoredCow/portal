## Cypress 💻
Cypress is a next generation front end testing tool built for the modern web. We address the key pain points developers and QA engineers face when testing modern applications.
For more information check [here](https://www.docs.cypress.io/)

### In a nutshell
We make it possible to:
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
    1. Visit the page at /posts/new.
    2. Find the `<input>` with class post-title.
    3. Type "My First Post" into it.
    4. Find the `<input>` with class post-body.
    5. Type "Hello, world!" into it.
    6. Find the element containing the text Submit.
    7. Click it.
    8. Grab the browser URL, ensure it includes /posts/my-first-post.
    9. Find the h1 tag, ensure it contains the text "My First Post".
    
- Your test case look like:
    ```
        describe('Post Resource', () => {
            it('Creating a New Post', () => {
                cy.visit('/posts/new') // 1.
                cy.get('input.post-title') // 2.
                .type('My First Post') // 3.
                cy.get('input.post-body') // 4.
                .type('Hello, world!') // 5.
                cy.contains('Submit') // 6.
                .click() // 7.
                cy.url() // 8.
                .should('include', '/posts/my-first-post')
                cy.get('h1') // 9.
                .should('contain', 'My First Post')
            })
        })
    ```