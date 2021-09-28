describe("Login", () => {
  const username = Cypress.env("username");
  const password = Cypress.env("password");
  it("opens up the login page", () => {
    cy.visit("/login");
    cy.get('[name="email"]').type(username);
    cy.get('[name="password"]').type(password);
    cy.get('[type="submit"]')
      .first()
      .click();
    cy.get("h3")
      .first()
      .should("have.text", "Dashboard");
    cy.get('#navbarDropdown').click();
    cy.get('[href="http://127.0.0.1:8000/logout"]').click();
  });
});
