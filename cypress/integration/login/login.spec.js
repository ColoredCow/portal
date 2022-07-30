describe("Login", () => {
  const username = Cypress.env("username");
  const password = Cypress.env("password");
  it("opens up the login page", () => {
    cy.login({ username, password })
  });
});
