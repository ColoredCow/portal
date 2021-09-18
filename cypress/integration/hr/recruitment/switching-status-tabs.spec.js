describe("Recruitment", () => {
    const username = Cypress.env("username");
    const password = Cypress.env("password");
    it("Switching application status tabs", () => {
      cy.visit("/login");
      cy.get('[name="email"]').type(username);
      cy.get('[name="password"]').type(password);
      cy.get('[type="submit"]')
        .first()
        .click();
      cy.visit("/hr/recruitment/job");
      cy.get('.justify-content-between > .nav > :nth-child(2) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(3) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(3) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(4) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(5) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(6) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(7) > .nav-item').click();
      cy.get('.justify-content-between > .nav > :nth-child(8) > .nav-item').click();
    });
  });
  