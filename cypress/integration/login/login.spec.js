describe("Login", () => {

  it("opens up the login page", () => {
    cy.visit("https://uat.employee.coloredcow.com");
    cy.get('[name="email"]').type('user@coloredcow.com')
    cy.get('[name="password"]').type('12345678')
  });

});
