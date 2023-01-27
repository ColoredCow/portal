describe("Login", () => {
  it("logs in the default user", () => {
    const user = Cypress.env("users").default;
    cy.login(user);
    cy.contains('Hello, there!');
    cy.get('ul.navbar-nav').should('not.contain', 'CRM'); // default user should not contain CRM
    cy.get('ul.navbar-nav').should('not.contain', 'KnowledgeCafe'); // default user should not have KnowledgeCafe
  });

  it("logs in the employee user", () => {
    const user = Cypress.env("users").employee;
    cy.login(user);
    cy.get("#wishlist").contains('Your wishlist');
    cy.get('ul.navbar-nav').contains('CRM'); // employee should see CRM
    cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // employee should see KnowledgeCafe
  });

  it("logs in the admin user", () => {
    const user = Cypress.env("users").admin;
    cy.login(user);
    cy.get('ul.navbar-nav').contains('CRM'); // admin should see CRM
    cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // admin should see KnowledgeCafe
    cy.get('ul.navbar-nav').contains('HR'); // admin should see HR
    cy.get('ul.navbar-nav').contains('Finance'); // admin should see Finance
    cy.get('ul.navbar-nav').contains('Sales'); // admin should see Sales
    cy.get('ul.navbar-nav').contains('Infrastructure'); // admin should see Infrastructure  
    cy.get('ul.navbar-nav').contains('Settings'); //admin should see Settings 
  });

  it("logs in the superadmin user", () => {
    const user = Cypress.env("users").superadmin;
    cy.login(user);
    cy.get('ul.navbar-nav').contains('CRM'); // superadmin should see CRM
    cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // superadmin should see KnowledgeCafe
    cy.get('ul.navbar-nav').contains('HR'); // superadmin should see HR
    cy.get('ul.navbar-nav').contains('Finance'); // superadmin should see Finance
    cy.get('ul.navbar-nav').contains('Sales'); // superadmin should see Sales
    cy.get('ul.navbar-nav').contains('Infrastructure'); // superadmin should see Infrastructure 
    cy.get('ul.navbar-nav').contains('Settings'); //superadmin should see Settings 
    cy.get('#navbarDropdown_settings').then(dropdown =>{
      cy.wrap(dropdown).click()    //click on dropdown
      cy.get('#dropdownMenu_settings').contains('User Management') //superadmin should see User Management
     });
  });
});