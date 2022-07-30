describe("Login", () => {
  it("logs in the default user", () => {
    const user = Cypress.env("users").default;
    cy.login(user);
    cy.contains('Hello, there!');
    cy.contains('Dashboard')
    cy.get('ul.navbar-nav').should('not.contain', 'CRM'); // default user should not CRM
    cy.get('ul.navbar-nav').should('not.contain', 'KnowledgeCafe'); // default user should not CRM
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
  cy.get('ul.navbar-nav').contains('CRM'); // employee should see CRM
  cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // employee should see KnowledgeCafe
});

it("logs in the superadmin user", () => {
  const user = Cypress.env("users").superadmin;
  cy.login(user);
  cy.get('ul.navbar-nav').contains('CRM'); // employee should see CRM
  cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // employee should see KnowledgeCafe
});

});