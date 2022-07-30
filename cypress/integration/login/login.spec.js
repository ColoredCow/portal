describe("Login", () => {
  it("logs in the default user", () => {
    const user = Cypress.env("users").default;
    cy.login(user);
    cy.contains('Hello, there!');
    cy.get('ul.navbar-nav').should('not.contain', 'CRM'); // default user should not CRM
    cy.get('ul.navbar-nav').should('not.contain', 'KnowledgeCafe'); // default user should not CRM
  });

  it("logs in the employee user", () => {
    const user = Cypress.env("users").employee;
    cy.login(user);
    cy.get('ul.navbar-nav').contains('CRM'); // employee should see CRM
    cy.get('ul.navbar-nav').contains('KnowledgeCafe'); // employee should see KnowledgeCafe
  });
});
