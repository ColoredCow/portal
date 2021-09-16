describe("Recruitment", () => {
    it("opens up the job page", () => {
        const username = Cypress.env("username");
        const password = Cypress.env("password");
        cy.visit("/login");
        cy.get('[name="email"]').type(username);
        cy.get('[name="password"]').type(password);
        cy.get('[type="submit"]')
            .first()
            .click();
        cy.get("h3")
        .first()
        .should("have.text", "Dashboard");
        cy.visit("/hr/recruitment/job");
        cy.get("[class='w-25p']");
    });
});
  